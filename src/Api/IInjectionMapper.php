<?php

namespace JanKovacs\Injector\Api;

interface IInjectionMapper
{


    public const JUST_INJECT = 'just_inject';
    public const AS_SINGLETON = 'as_singleton';
    public const TO_SINGLETON = 'to_singleton';
    public const TO_TYPE = 'to_type';
    public const TO_OBJECT = 'to_object';

    /**
     * Maps to a given type.
     *
     * @api
     *
     * @param string $typeName the name of the class
     *
     * @return void
     */
    public function toType(string $typeName):void;

    /**
     * Maps to a concrete object.
     *
     * @api
     *
     * @param object $object the object to which a type is going to be mapped
     *
     * @return void
     */
    public function toObject(object $object):void;

    /**
     * Maps as a singleton.
     *
     * @api
     *
     * @return void
     */
    public function asSingleton():void;

    /**
     * Maps the type as a singleton
     *
     * @api
     *
     * @param string $type the class name of the singleton
     *
     * @return void
     */
    public function toSingleton(string $type):void;

    /**
     * Returns the instance.
     *
     * @api
     *
     * @return null|object
     */
    public function getInstance():?object;


    /**
     *
     * @param object $instance the instance which was created by the mapping rules
     *
     * @return void
     */
    public function setInstance(object $instance):void;


    /**
     * Returns with the set mapping type
     *
     * @api
     *
     * @return string
     */
    public function getMappingType():string;


    /**
     *
     * @return string
     */
    public function getClassName():string;
}
