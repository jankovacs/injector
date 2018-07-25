<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\IInjectionMapper;
use ReflectionClass;

class InjectionMapper implements IInjectionMapper
{
    /**
     * 
     *
     * @var string 
     */
    protected $className;

    /**
     * 
     *
     * @var string 
     */
    protected $mappingType;

    /**
     * 
     *
     * @var object 
     */
    protected $instance;

    /**
     * 
     *
     * @var bool 
     */
    protected $isInjectable;

    /**
     * InjectionMapper constructor.
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
        $this->isInjectable = true;
        $this->setType(self::JUST_INJECT);
    }

    /**
     *
     * @inheritdoc
     */
    public function getMappingType():string
    {
        return $this->mappingType;
    }

    /**
     *
     * @inheritdoc
     */
    public function toType(string $typeName):void
    {
        $this->className = $typeName;
        $this->setType(self::TO_TYPE);
    }

    /**
     *
     * @inheritdoc
     */
    public function toObject(object $object):void
    {
        $this->instance = $object;
        $this->setType(self::TO_OBJECT);
    }

    /**
     *
     * @inheritdoc
     */
    public function asSingleton():void
    {
        $this->setType(self::AS_SINGLETON);
    }

    /**
     *
     * @inheritdoc
     */
    public function toSingleton(string $type):void
    {
        $this->className = $type;
        $this->setType(self::TO_SINGLETON);
    }

    /**
     *
     * @param string $type
     */
    protected function setType(string $type):void
    {
        $this->mappingType = $type;
    }

    /**
     *
     * @inheritdoc
     */
    public function getInstance():?object
    {
        return $this->instance;
    }

    /**
     *
     * @param object $instance
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
