<?php

namespace JanKovacs\Injector\Api;


interface IInjectionMapper {

    /**
     * Maps to a given type.
     *
     * @api
     *
     * @param string $typeName
     *
     */
    public function toType(string $typeName):void;

    /**
     * Maps to a concrete object.
     *
     * @api
     *
     * @param object $object
     *
     */
    public function toObject(object $object):void;

    /**
     * Maps as a singleton.
     *
     * @api
     *
     */
    public function asSingleton():void;

    /**
     * Maps the type as a singleton
     *
     * @api
     *
     * @param string $type
     *
     */
    public function toSingleton(string $type):void;

    /**
     * Returns the instance base on mapping type.
     *
     * @api
     *
     * @param string $where
     *
     * @return null|object
     */
    public function getInstance(string $where = ''):?object;


    /**
     * Returns with the set mapping type
     *
     * @api
     *
     * @return string
     */
    public function getMappingType():string;

}