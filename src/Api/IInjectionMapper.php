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
     * @param string $typeName
     */
    public function toType(string $typeName):void;

    /**
     * Maps to a concrete object.
     *
     * @api
     *
     * @param object $object
     */
    public function toObject(object $object):void;

    /**
     * Maps as a singleton.
     *
     * @api
     */
    public function asSingleton():void;

    /**
     * Maps the type as a singleton
     *
     * @api
     *
     * @param string $type
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
     * @param object $instance
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
