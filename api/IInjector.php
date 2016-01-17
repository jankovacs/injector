<?php

namespace injector\api;


interface IInjector {

    /**
     * @param $className the name of the class in string format
     * @return \injector\api\IInjectionMapper
     */
    public function map( $className );

    /**
     * Returns with the instance of the requested class/type.
     * If it mapped as singleton, it will give back the single instance.
     * @param $className
     * @return mixed
     */
    public function getInstance( $className );

    /**
     * Injects all defined dependencies to instantiated class passed as argument
     * @param $instance an instantiated class what has to be injected
     * @return null
     */
    public function inject( $instance );
}