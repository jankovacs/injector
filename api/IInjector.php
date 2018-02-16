<?php

namespace injector\api;

/**
 * Interface IInjector
 *
 * @var boolean $isInjectable
 * @package injector\api
 */
interface IInjector {

    /**
     * @param $className string name of the class in string format
     * @return \injector\impl\ExtendedMapper
     */
    public function map( $className );

    /**
     * Returns with the instance of the requested class/type.
     * If it mapped as singleton, it will give back the single instance.
     * @param $className
     * @return mixed
     */
    public function getInstance( $className, $where = '' );

    /**
     *
     * @param $instance
     * @return mixed
     */
    public function inject( $instance );
}