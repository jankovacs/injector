<?php

namespace injector\api;


interface IInjectionMapper {

    /**
     * Maps to a given type.
     * @param $typeName
     * @return
     */
    function toType($typeName);

    /**
     * Maps to a concrete object.
     * @param $object
     * @return
     */
    function toObject($object);

    /**
     * Maps as a singleton.
     * @return
     */
    function asSingleton();

    /**
     * Returns the instance base on mapping type.
     * @return
     */
    function getInstance();
}