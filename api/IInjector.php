<?php

namespace injector\api;


interface IInjector {

    /**
     * Maps the given class.
     * See \injector\api\IInjectionMapper for possibilities.
     * @param $className string the name of the class in string format
     * @return \injector\api\IInjectionMapper
     */
    public function map( $className );

    /**
     * Returns with the injected instance of the requested class/type.
     * If it is mapped as a singleton, it will give back the single instance.
     * @param $className string
     * @return mixed
     */
    public function getInstance( $className );

    /**
     * Injects all defined dependencies to instantiated class passed as argument
     * @param $instance object the instantiated class what has to be injected
     * @return null
     */
    public function inject( $instance );
}