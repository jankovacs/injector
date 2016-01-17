<?php

namespace injector\api;


interface IInjectionMapper {

    /**
     * Maps the given class to a specified type.
     * @param $typeName
     * @return
     */
    public function toType( $typeName );

    /**
     * Maps the given class to a concrete, instantiated object.
     * @param $object
     * @return
     */
    public function toObject( $object );

    /**
     * Maps the given class as a singleton
     * @param string $type if specified, then it will return with the given singleton class
     * @return mixed
     */
    public function asSingleton( $type = '' );

    /**
     * Returns the instance base on mapping type.
     * @return
     */
    public function getInstance();

    /**
     * Tells if an object is injectable
     * @return bool
     */
    public function getIsInjectable();
}