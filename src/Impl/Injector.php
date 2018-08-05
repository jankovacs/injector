<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\InjectorInterface;
use JanKovacs\Injector\Api\ProviderMapperInterface;
use JanKovacs\Injector\Exceptions\InjectionMapperException;
use ReflectionClass;

class Injector implements InjectorInterface
{
    
    /**
     * 
     *
     * @var array 
     */
    protected $mappings;

    /**
     * Injector constructor.
     */
    public function __construct()
    {
        $this->mappings = array();
        $this
            ->map(Injector::class)
            ->toObject($this);
    }

    /**
     * @param  string $className the name of the class
     *
     * @return ProviderMapperInterface
     */
    public function map(string $className):ProviderMapperInterface
    {
        $className = $this->cleanClassName($className);
        return array_key_exists($className, $this->mappings) ? $this->mappings[ $className ] : $this->createMapping($className);
    }

    /**
     * @param  string $className the name of the class
     *
     * @return ProviderMapperInterface
     */
    protected function createMapping(string $className):ProviderMapperInterface
    {
        $className = $this->cleanClassName($className);
        $mapper = new ExtendedMapper($className);
        $this->mappings[ $className ] = $mapper;
        return $mapper;
    }

    /**
     * @param  string $className the name of the class
     *
     * @return string
     */
    protected function cleanClassName(string $className):string
    {
        return ltrim($className, '\\');
    }

    /**
     * @param string $className the name of the class
     * @param string $where     the name of the end class
     *
     * @return null|object
     *
     * @throws InjectionMapperException
     * @throws \ReflectionException
     */
    public function getInstance(string $className, string $where = ''):?object
    {
        $className = $this->cleanClassName($className);
        /** @var InjectionMapper $injectionMapper */
        $injectionMapper = $this->getInjectionMapper($className);

        $mappingType = $injectionMapper->getMappingType();
        $className = $injectionMapper->getClassName();

        if ($mappingType === ProviderMapperInterface::TO_PROVIDER) {
            return $this->createInstance(
                $injectionMapper->getClassNameByEndClass($where)
            );
        } elseif ($mappingType === ProviderMapperInterface::AS_SINGLETON || $mappingType === ProviderMapperInterface::TO_SINGLETON) {
            if ($injectionMapper->getInstance() !== null) {
                return $injectionMapper->getInstance();
            }

            $instance = $this->createInstance($className);
            $injectionMapper->setInstance($instance);
            return $instance;
        } elseif ($mappingType === ProviderMapperInterface::TO_TYPE || $mappingType === ProviderMapperInterface::JUST_INJECT) {
            return $this->createInstance($className);
        } elseif ($mappingType === ProviderMapperInterface::TO_OBJECT) {
            return $injectionMapper->getInstance();
        }

        return null;
    }

    /**
     * @param  string $className the name of the class
     *
     * @return null|object
     *
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
     * @param  ReflectionClass $reflectionClass the reflection class
     *
     * @return array
     *
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
     *
     * @param  string $className the name of the class
     *
     * @return ProviderMapperInterface|null
     *
     * @throws InjectionMapperException
     */
    protected function getInjectionMapper(string $className):?ProviderMapperInterface
    {
        if (array_key_exists($className, $this->mappings) && $this->mappings[ $className ] instanceof ProviderMapperInterface) {
            return $this->mappings[$className];
        }

        throw new InjectionMapperException('There is no defined mapping for '.$className);
    }
}
