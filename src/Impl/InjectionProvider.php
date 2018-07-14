<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\IInjectionProvider;
use JanKovacs\Injector\Api\IInjectionMapper;

class InjectionProvider implements IInjectionProvider {

    /** @var array */
    protected $uniqueMappers;

    /** @var \JanKovacs\Injector\Api\IInjectionMapper */
    protected $exceptionMapper;

    /** @var string */
    protected $exceptClassName;

    public $className;

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
        $this->uniqueMappers[ $className ] = new InjectionMapper( '' );
        return $this->uniqueMappers[ $className ];
    }

    /**
     * @param $className
     * @return \JanKovacs\Injector\Api\IInjectionMapper
     */
    public function addExceptTo(string $className):IInjectionMapper
    {
        $this->exceptClassName = $className;
        return $this->exceptionMapper = new InjectionMapper( $this->className );
    }

    /**
     * @return \JanKovacs\Injector\Api\IInjectionMapper
     */
    public function addToRest():IInjectionMapper
    {
        return $this->addExceptTo( $this->className );
    }

    /**
     * @param string $where
     * @return null|object
     */
    public function getInstance(string $where = ''):?object
    {
        $instance = null;
        if ( array_key_exists( $where, $this->uniqueMappers ) )
        {
            $instance = $this->uniqueMappers[ $where ]->getInstance();
        }
        else if ( $this->exceptClassName != $where && isset( $this->exceptionMapper ) )
        {
            $instance = $this->exceptionMapper->getInstance();
        }

        return $instance;
    }
}