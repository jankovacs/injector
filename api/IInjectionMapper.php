<?php

namespace injector\api;


interface IInjectionMapper {

    /**
     * Maps to a given type.
     * @param $typeName
     * @return
     */
    public function toType($typeName);

    /**
     * Maps to a concrete object.
     * @param $object
     * @return
     */
    public function toObject($object);

    /**
     * Maps as a singleton.
     * @return
     */
    public function asSingleton( );

    /**
    * Maps the type as a singleton
    * @param $type
    * @return mixed
    */
    public function toSingleton( $type );

    /**
     * Returns the instance base on mapping type.
     * @return
     */
    public function getInstance( $where = '' );

}