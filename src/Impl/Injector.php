<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\IProviderMapper;
use JanKovacs\Injector\Api\IInjector;
use JanKovacs\Injector\Exceptions\InjectionMapperException;
use ReflectionClass;
use ReflectionProperty;

/**
 * Class Injector
 * @package JanKovacs\Injector\Impl
 */
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
            ->map('\JanKovacs\Injector\Api\IInjector')
            ->toObject($this);
    }

    /**
     * @param string $className
     * @return IProviderMapper
     */
    public function map(string $className):IProviderMapper
    {
        $className = (strpos($className,'\\') !== 0 ? '\\' : '') . $className;
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
     */
    public function getInstance(string $className, string $where = ''):?object
    {
        $className = $this->cleanClassName($className);
        /** @var IProviderMapper $injectionMapperInstance */
        $injectionMapperInstance = $this->getInjectionMapperInstance($className);

        if ($injectionMapperInstance === null) {
            throw new InjectionMapperException('There is no defined mapping for '.$className);
        }

        if ($injectionMapperInstance->isInjectable ) {

            $className = $this->cleanClassName($injectionMapperInstance->className);

            $reflectionClass = new ReflectionClass($className);
            return $reflectionClass->newInstanceArgs(
                $this->getConstructorPayloads($reflectionClass)
            );
        }
        return null;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return array
     */
    protected function getConstructorPayloads(ReflectionClass $reflectionClass):array
    {
        $constructorPayloads = [];
        $constructorPsrameters = $reflectionClass->getConstructor() ? $reflectionClass->getConstructor()->getParameters() : [];
        foreach ($constructorPsrameters as $parameter) {
            $constructorPayloads[] = $this->getInstance($parameter->getType()->getName());
        }
        return $constructorPayloads;
    }

    /**
     * @param string $className
     * @return IProviderMapper|null
     */
    protected function getInjectionMapperInstance(string $className):?IProviderMapper
    {
        return array_key_exists( $className, $this->mappings ) && $this->mappings[ $className ] instanceof IProviderMapper ?  $this->mappings[ $className ] : null;
    }

    /**
     * @param object $instance
     * @throws \ReflectionException
     */
    public function inject(object $instance):void
    {
        $reflection = new ReflectionClass( $instance );
        $memberVariables = $reflection->getProperties( ReflectionProperty::IS_PUBLIC );
        $pattern = "/(@Inject)/";
        $replace = array( "/", " ", "*", "@Inject", "@var", "\n", "\r" );

        foreach($memberVariables as $key=>$value)
        {
            $propertyName = $value->getName();
            $docComment = $value->getDocComment();
            $return_value = preg_match( $pattern, $docComment, $matches );
            if ( $return_value )
            {
                $className = str_replace( $replace, '', $docComment );
                $instance->$propertyName = $this->getInstanceInOldWay( $className, $reflection->getName() );
            }
        }
    }

    /**
     * @param string $className
     * @param string $where
     * @return null|object
     * @throws \ReflectionException
     */
    protected function getInstanceInOldWay(string $className, string $where = ''):?object
    {
        $className = $this->cleanClassName($className);
        /** @var ExtendedMapper $injectionMapperInstance */
        $injectionMapperInstance = $this->getInjectionMapperInstance( $className );
        $instance = $injectionMapperInstance->getInstance( $where );

        if ( $injectionMapperInstance->isInjectable ) {
            if ( method_exists($instance, 'preInject') ){
                $instance->preInject();
            }

            $this->inject( $instance );

            if ( method_exists($instance, 'postInject') ){
                $instance->postInject();
            }
        }
        return $instance;
    }
}