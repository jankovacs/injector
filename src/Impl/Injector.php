<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\IInjector;
use JanKovacs\Injector\Api\IProviderMapper;
use JanKovacs\Injector\Exceptions\InjectionMapperException;
use ReflectionClass;

class Injector implements IInjector
{
    
    /** @var array */
    protected $mappings;

    /**
     * Injector constructor.
     */
    public function __construct()
    {
        $this->mappings = array();
        $this
            ->map(IInjector::class)
            ->toObject($this);
    }

    /**
     * @param string $className
     * @return IProviderMapper
     */
    public function map(string $className):IProviderMapper
    {
        $className = $this->cleanClassName($className);
        return array_key_exists($className, $this->mappings) ? $this->mappings[ $className ] : $this->createMapping($className);
    }

    /**
     * @param string $className
     * @return IProviderMapper
     */
    protected function createMapping(string $className):IProviderMapper
    {
        $className = $this->cleanClassName($className);
        $mapper = new ExtendedMapper( $className );
        $this->mappings[ $className ] = $mapper;
        return $mapper;
    }

    /**
     * @param string $className
     * @return string
     */
    protected function cleanClassName(string $className):string
    {
        return ltrim($className, '\\');
    }

    /**
     * @param string $className
     * @param string $where
     * @return null|object
     * @throws InjectionMapperException
     * @throws \ReflectionException
     */
    public function getInstance(string $className, string $where = ''):?object
    {
        $className = $this->cleanClassName($className);
        /** @var IProviderMapper $injectionMapper */
        $injectionMapper = $this->getInjectionMapper($className);

        $mappingType = $injectionMapper->getMappingType();
        $className = $injectionMapper->getClassName();

        if ($mappingType === IProviderMapper::TO_PROVIDER) {
            return $this->createInstance(
                $injectionMapper->getClassNameByEndClass($where)
            );
        }
        else if ($mappingType === IProviderMapper::AS_SINGLETON || $mappingType === IProviderMapper::TO_SINGLETON) {
            if ($injectionMapper->getInstance() !== null) {
                return $injectionMapper->getInstance();
            }

            $instance = $this->createInstance($className);
            $injectionMapper->setInstance($instance);
            return $instance;
        }
        else if ($mappingType === IProviderMapper::TO_TYPE || $mappingType === IProviderMapper::JUST_INJECT) {
            return $this->createInstance($className);
        }
        else if ($mappingType === IProviderMapper::TO_OBJECT) {
            return $injectionMapper->getInstance();
        }

        return null;
    }

    /**
     * @param string $className
     * @return null|object
     * @throws InjectionMapperException
     * @throws \ReflectionException
     */
    protected function createInstance(string $className):?object
    {
        $className = $this->cleanClassName($className);

        $reflectionClass = new ReflectionClass($className);
        return $reflectionClass->newInstanceArgs(
            $this->getConstructorPayloads($reflectionClass)
        );
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return array
     * @throws InjectionMapperException
     * @throws \ReflectionException
     */
    protected function getConstructorPayloads(ReflectionClass $reflectionClass):array
    {
        $constructorPayloads = [];
        $constructorParameters = $reflectionClass->getConstructor() ? $reflectionClass->getConstructor()->getParameters() : [];

        foreach ($constructorParameters as $parameter) {
            $constructorPayloads[] = $this->getInstance($parameter->getType()->getName(), $reflectionClass->getName());
        }
        return $constructorPayloads;
    }

    /**
     * @param string $className
     * @return IProviderMapper|null
     * @throws InjectionMapperException
     */
    protected function getInjectionMapper(string $className):?IProviderMapper
    {
        if (array_key_exists( $className, $this->mappings ) && $this->mappings[ $className ] instanceof IProviderMapper) {
            return $this->mappings[$className];
        }

        throw new InjectionMapperException('There is no defined mapping for '.$className);
    }
}