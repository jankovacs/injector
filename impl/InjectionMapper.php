<?php

namespace injector\impl;
use injector\api\IInjectionMapper;

/**
 * Class InjectionMapper
 *
 * @package injector\impl
 */
class InjectionMapper implements IInjectionMapper
{
    protected $className;
    protected $mappingType;
    protected $instance;
    protected $object;
    protected $isInjectable;

    const JUST_INJECT = 'just_inject';
    const AS_SINGLETON = 'as_singleton';
    const TO_SINGLETON = 'to_singleton';
    const TO_TYPE = 'to_type';
    const TO_OBJECT = 'to_object';

    public function __construct( $className )
    {
        $this->className = $className;
        $this->isInjectable = false;
        $this->setType( self::JUST_INJECT );
    }

    public function getMappingType()
    {
        return $this->mappingType;
    }

    public function toType( $typeName )
    {
        $this->className = $typeName;
        $this->setType( self::TO_TYPE );
    }

    public function toObject($object)
    {
        $this->object = $object;
        $this->setType( self::TO_OBJECT );
    }

    public function asSingleton( )
    {
        $this->setType( self::AS_SINGLETON );
    }

    public function toSingleton($type)
    {
        $this->className = $type;
        $this->setType( self::TO_SINGLETON );
    }

    protected function setType( $type )
    {
        $this->mappingType = $type;
    }

    public function getInstance( $where = '' )
    {
        $instance = null;
        switch( $this->mappingType )
        {
            case self::AS_SINGLETON:
            case self::TO_SINGLETON:
                $instance = $this->prepareSingleton();
                break;

            case self::TO_TYPE:
            case self::JUST_INJECT:
                $instance = $this->prepareNewInstance();
                break;

            case self::TO_OBJECT:
                $instance = $this->prepareObject();
                break;
        }

        return $instance;
    }

    private function prepareSingleton()
    {
        $this->isInjectable = false;
        if ( !isset( $this->instance ) )
        {
            $this->isInjectable = true;
            $this->instance = new $this->className;
        }

        return $this->instance;
    }

    private function prepareObject()
    {
        $this->isInjectable = !isset( $this->instance );
        $this->instance = $this->object;
        return $this->instance;
    }

    private function prepareNewInstance()
    {
        $this->isInjectable = true;
        return new $this->className;
    }

    public function __get( $property )
    {
        return property_exists( $this, $property ) ? $this->$property : null;
    }
}