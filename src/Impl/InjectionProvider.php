<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\IInjectionProvider;
use JanKovacs\Injector\Api\IInjectionMapper;

class InjectionProvider implements IInjectionProvider {

    /** @var array */
    protected $uniqueMappers;

    /** @var \JanKovacs\Injector\Api\IInjectionMapper */
    protected $exceptionMapper;

    /** @var \JanKovacs\Injector\Api\IInjectionMapper */
    protected $restMapper;

    /** @var string */
    protected $exceptClassName;

    /** @var string */
    protected $className;

    /**
     * InjectionProvider constructor.
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->uniqueMappers = array();
        $this->className = $className;
    }

    /**
     *
     * @param $className
     * @return \JanKovacs\Injector\Api\IInjectionMapper
     */
    public function addUnique(string $className):IInjectionMapper
    {
        $this->uniqueMappers[ $className ] = new InjectionMapper( $className );
        return $this->uniqueMappers[ $className ];
    }

    /**
     * @param $className
     * @return \JanKovacs\Injector\Api\IInjectionMapper
     */
    public function addExceptTo(string $className):IInjectionMapper
    {
        $this->exceptClassName = $className;
        $this->exceptionMapper = new InjectionMapper( $this->className );
        return $this->exceptionMapper;
    }

    /**
     * @return \JanKovacs\Injector\Api\IInjectionMapper
     */
    public function addToRest():IInjectionMapper
    {
        $this->restMapper = new InjectionMapper( $this->className );
        return $this->restMapper;
    }

    /**
     * @param string $className
     * @return IInjectionMapper|null
     */
    public function getMapperByRules(string $className): ?IInjectionMapper
    {
        if (array_key_exists($className, $this->uniqueMappers)) {
            return $this->uniqueMappers[$className];
        }

        if ($this->exceptClassName === $className) {
            return $this->exceptionMapper;
        }

        return $this->restMapper;
    }
}