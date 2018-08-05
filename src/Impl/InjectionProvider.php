<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\InjectionProviderInterface;
use JanKovacs\Injector\Api\InjectionMapperInterface;

class InjectionProvider implements InjectionProviderInterface
{

    /**
     * 
     *
     * @var array 
     */
    protected $uniqueMappers;

    /**
     * 
     *
     * @var \JanKovacs\Injector\Api\InjectionMapperInterface
     */
    protected $exceptionMapper;

    /**
     * 
     *
     * @var \JanKovacs\Injector\Api\InjectionMapperInterface
     */
    protected $restMapper;

    /**
     * 
     *
     * @var string 
     */
    protected $exceptClassName;

    /**
     * 
     *
     * @var string 
     */
    protected $className;

    /**
     * InjectionProvider constructor.
     *
     * @param string $className the name of the class
     */
    public function __construct(string $className)
    {
        $this->uniqueMappers = array();
        $this->className = $className;
    }

    /**
     * @param string $className the name of the class
     *
     * @return InjectionMapper
     */
    public function addUnique(string $className):InjectionMapperInterface
    {
        $this->uniqueMappers[ $className ] = new InjectionMapper($className);
        return $this->uniqueMappers[ $className ];
    }

    /**
     * @param string $className the name of the class
     *
     * @return InjectionMapper
     */
    public function addExceptTo(string $className):InjectionMapperInterface
    {
        $this->exceptClassName = $className;
        $this->exceptionMapper = new InjectionMapper($this->className);
        return $this->exceptionMapper;
    }

    /**
     *
     * @return \JanKovacs\Injector\Api\InjectionMapperInterface
     */
    public function addToRest():InjectionMapperInterface
    {
        $this->restMapper = new InjectionMapper($this->className);
        return $this->restMapper;
    }

    /**
     *
     * @param  string $className the name of the class
     *
     * @return InjectionMapper|null
     */
    public function getMapperByRules(string $className): ?InjectionMapperInterface
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
