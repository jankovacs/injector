<?php

namespace injector\impl;
use injector\api\IInjectionMapper;

class InjectionMapper implements IInjectionMapper
{
    private $className;
    private $typeName;
    private $mappingType;
    private $instance;
    private $object;
    private $isInjectable;

    const JUST_INJECT = 'just_inject';
    const AS_SINGLETON = 'as_singleton';
    const TO_TYPE = 'to_type';
    const TO_OBJECT = 'to_object';

    public function __construct($className)
    {
        $this->className = $className;
        $this->isInjectable = false;
        $this->setType( self::JUST_INJECT );
    }

    public function getMappingType()
    {
        return $this->mappingType;
    }

    public function toType($typeName)
    {
        $this->setType( self::TO_TYPE );
    }
    public function toObject($object)
    {
        $this->object = $object;
        $this->setType( self::TO_OBJECT );
    }
    public function asSingleton()
    {
        $this->setType( self::AS_SINGLETON );
    }

    private function setClassName( $className )
    {
        $this->className = $className;
    }

    private function setType( $type )
    {
        $this->mappingType = $type;
    }

    public function getInstance()
    {
        switch( $this->mappingType )
        {
            case self::AS_SINGLETON:
                $this->isInjectable = false;
                if ( !isset($this->instance) )
                {
                    $this->isInjectable = true;
                    $this->instance = new $this->className;
                }
                break;

            case self::TO_TYPE:
                $this->instance = new $this->typeName;
                $this->isInjectable = true;
                break;

            case self::JUST_INJECT:
                $this->instance = new $this->className;
                $this->isInjectable = true;
                break;

            case self::TO_OBJECT:
                $this->isInjectable = !isset($this->instance);
                $this->instance = $this->object;
                break;
        }

        return $this->instance;
    }

    public function __get( $property )
    {
        if( property_exists( $this, $property ) )
        {
            return $this->$property;
        }
    }
}