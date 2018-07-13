<?php

namespace injector\impl;

use injector\api\IInjectionMapper;
use injector\api\IInjectionPayload;
use ReflectionClass;

class InjectionMapper implements IInjectionMapper
{
    /** @var string */
    protected $className;

    /** @var string */
    protected $mappingType;

    /** @var mixed */
    protected $instance;

    /** @var mixed */
    protected $object;

    /** @var bool */
    protected $isInjectable;

    /** @var IInjectionPayload */
    protected $injectionPayload;

    const JUST_INJECT = 'just_inject';
    const AS_SINGLETON = 'as_singleton';
    const TO_SINGLETON = 'to_singleton';
    const TO_TYPE = 'to_type';
    const TO_OBJECT = 'to_object';

    /**
     * InjectionMapper constructor.
     *
     * @param string $className
     */
    public function __construct( $className )
    {
        $this->className = $className;
        $this->isInjectable = false;
        $this->injectionPayload = new InjectionPayload();
        $this->setType( self::JUST_INJECT );
    }

    /**
     * @inheritdoc
     */
    public function getMappingType()
    {
        return $this->mappingType;
    }

    /**
     * @inheritdoc
     */
    public function toType( $typeName )
    {
        $this->className = $typeName;
        $this->setType( self::TO_TYPE );
        return $this->injectionPayload;
    }

    /**
     * @inheritdoc
     */
    public function toObject($object)
    {
        $this->object = $object;
        $this->setType( self::TO_OBJECT );
        return $this->injectionPayload;
    }

    /**
     * @inheritdoc
     */
    public function asSingleton( )
    {
        $this->setType( self::AS_SINGLETON );
        return $this->injectionPayload;
    }

    /**
     * @inheritdoc
     */
    public function toSingleton($type)
    {
        $this->className = $type;
        $this->setType( self::TO_SINGLETON );
        return $this->injectionPayload;
    }

    /**
     * @param string $type
     */
    protected function setType( $type )
    {
        $this->mappingType = $type;
    }


    /**
     * @inheritdoc
     */
    public function getInstance( $where = '' )
    {
        if ($this->mappingType === self::AS_SINGLETON || $this->mappingType === self::TO_SINGLETON) {
            return $this->prepareSingleton();
        }
        else if ($this->mappingType === self::TO_TYPE || $this->mappingType === self::JUST_INJECT) {
            return $this->prepareNewInstance();
        }
        else if ($this->mappingType === self::TO_OBJECT) {
            return $this->prepareObject();
        }

        return null;
    }

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
    private function prepareObject()
    {
        $this->isInjectable = !isset( $this->instance ) && is_object( $this->object );
        $this->instance = $this->object;
        return $this->instance;
    }

    /**
     * @return object
     * @throws \ReflectionException
     */
    private function prepareNewInstance()
    {
        $this->isInjectable = true;
        $reflectionClass = new ReflectionClass($this->className);
        return $reflectionClass->newInstanceArgs($this->injectionPayload->getPayload());
    }

    /**
     * @param $property
     * @return mixed|null
     */
    public function __get( $property )
    {
        return property_exists( $this, $property ) ? $this->$property : null;
    }
}