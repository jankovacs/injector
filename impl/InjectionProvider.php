<?php

namespace injector\impl;

use injector\api\IInjectionProvider;

class InjectionProvider implements IInjectionProvider {

    /**
     * @var array
     */
    private $uniqueMappers;

    /**
     * @var \injector\api\IInjectionMapper
     */
    private $exceptionMapper;

    private $exceptClassName;

    public $className;

    public function __construct( $className )
    {
        $this->uniqueMappers = array();
        $this->className = $className;
    }

    /**
     *
     * @param $className
     * @return \injector\api\IInjectionMapper
     */
    public function addUnique( $className )
    {
        $this->uniqueMappers[ $className ] = new InjectionMapper( '' );
        return $this->uniqueMappers[ $className ];
    }

    /**
     * @param $className
     * @return \injector\api\IInjectionMapper
     */
    public function addExceptTo( $className )
    {
        $this->exceptClassName = $className;
        return $this->exceptionMapper = new InjectionMapper( $this->className );
    }

    /**
     * @return \injector\api\IInjectionMapper
     */
    public function addToRest()
    {
        return $this->addExceptTo( $this->className );
    }

    public function getInstance( $where = '' )
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