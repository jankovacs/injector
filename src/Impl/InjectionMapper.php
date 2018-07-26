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

    /** @var object */
    protected $instance;

    /** @var bool */
    protected $isInjectable;

    /**
     * InjectionMapper constructor.
     *
     * @param string $className the name of the class
     */
    public function __construct(string $className)
    {
        $this->className = $className;
        $this->isInjectable = true;
        $this->setType(self::JUST_INJECT);
    }

    /**
     * Returns with the set mapping type
     *
     * @return string
     */
    public function getMappingType():string
    {
        return $this->mappingType;
    }

    /**
     * Maps to a given type.
     *
     * @param string $typeName the name of the class
     *
     * @return void
     */
    public function toType(string $typeName):void
    {
        $this->className = $typeName;
        $this->setType(self::TO_TYPE);
    }

    /**
     * Maps to a concrete object.
     *
     * @param object $object the object to which a type is going to be mapped
     *
     * @return void
     */
    public function toObject(object $object):void
    {
        $this->instance = $object;
        $this->setType(self::TO_OBJECT);
    }

    /**
     * Maps as a singleton.
     *
     * @return void
     */
    public function asSingleton():void
    {
        $this->setType(self::AS_SINGLETON);
    }

    /**
     * Maps the type as a singleton
     *
     * @param string $type the class name of the singleton
     *
     * @return void
     */
    public function toSingleton(string $type):void
    {
        $this->className = $type;
        $this->setType(self::TO_SINGLETON);
    }

    /**
     *
     * @param string $type the mapping type
     *
     * @return void
     */
    protected function setType(string $type):void
    {
        $this->mappingType = $type;
    }

    /**
     * Returns the instance.
     *
     * @return null|object
     */
    public function getInstance():?object
    {
        return $this->instance;
    }

    /**
     *
     * @param object $instance the instance which was created by the mapping rules
     *
     * @return void
     */
    public function setInstance(object $instance): void
    {
        $this->instance = $instance;
    }

    /**
     *
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }
}
