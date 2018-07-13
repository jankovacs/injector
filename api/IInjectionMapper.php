<?php

namespace injector\api;


interface IInjectionMapper {

    /**
     * Maps to a given type.
     *
     * @api
     *
     * @param string $typeName
     *
     * @return IInjectionPayload
     */
    public function toType($typeName);

    /**
     * Maps to a concrete object.
     *
     * @api
     *
     * @param mixed $object
     *
     * @return IInjectionPayload
     */
    public function toObject($object);

    /**
     * Maps as a singleton.
     *
     * @api
     *
     * @return IInjectionPayload
     */
    public function asSingleton( );

    /**
     * Maps the type as a singleton
     *
     * @api
     *
     * @param string $type
     *
     * @return IInjectionPayload
     */
    public function toSingleton( $type );

    /**
     * Returns the instance base on mapping type.
     *
     * @api
     *
     * @param string $where
     *
     * @return mixed
     */
    public function getInstance( $where = '' );


    /**
     * Returns with the set mapping type
     *
     * @api
     *
     * @return string
     */
    public function getMappingType();

}