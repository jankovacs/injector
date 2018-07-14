<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\IInjectionMapper;
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

    protected const JUST_INJECT = 'just_inject';
    protected const AS_SINGLETON = 'as_singleton';
    protected const TO_SINGLETON = 'to_singleton';
    protected const TO_TYPE = 'to_type';
    protected const TO_OBJECT = 'to_object';

    /**
     * InjectionMapper constructor.
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
        $this->isInjectable = true;
        $this->setType( self::JUST_INJECT );
    }

    /**
     * @inheritdoc
     */
    public function getMappingType():string
    {
        return $this->mappingType;
    }

    /**
     * @inheritdoc
     */
    public function toType(string $typeName):void
    {
        $this->className = $typeName;
        $this->setType( self::TO_TYPE );
    }

    /**
     * @inheritdoc
     */
    public function toObject(object $object):void
    {
        $this->object = $object;
        $this->setType( self::TO_OBJECT );
    }

    /**
     * @inheritdoc
     */
    public function asSingleton():void
    {
        $this->setType( self::AS_SINGLETON );
    }

    /**
     * @inheritdoc
     */
    public function toSingleton(string $type):void
    {
        $this->className = $type;
        $this->setType( self::TO_SINGLETON );
    }

    /**
     * @param string $type
     */
    protected function setType(string $type):void
    {
        $this->mappingType = $type;
    }


    /**
     * @inheritdoc
     */
    public function getInstance(string $where = ''):?object
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
     * @return null|object
     */
    protected function prepareSingleton():?object
    {
        $this->isInjectable = $this->instance === null;
        /*if ($this->instance === null)
        {
            $this->isInjectable = true;
            $this->instance = new $this->className;
        }*/

        return $this->instance;
    }

    /**
     * @return object
     */
    protected function prepareObject():object
    {
        $this->isInjectable = !isset( $this->instance ) && is_object( $this->object );
        $this->instance = $this->object;
        return $this->instance;
    }

    /**
     * @return null|object
     *
     */
    protected function prepareNewInstance():?object
    {
        $this->isInjectable = true;
        return new $this->className;
    }

    /**
     * @param $property
     *
     * @return mixed|null
     */
    public function __get($property)
    {
        return property_exists( $this, $property ) ? $this->$property : null;
    }
}