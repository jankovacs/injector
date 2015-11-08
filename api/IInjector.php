<?php

namespace injector\api;


interface IInjector {

    /**
     * @param $className the name of the class in string format
     * @return \injector\api\IInjectionMapper
     */
    function map( $className );

    /**
     * Returns with the instance of the requested class/type.
     * If it mapped as singleton, it will give back the single instance.
     * @param $className
     * @return mixed
     */
    function getInstance( $className );
}