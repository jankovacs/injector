<?php
namespace injector\api;

interface IInjectionProvider {

    /**
     *
     * @param $className
     * @return \injector\api\IInjectionMapper
     */
    public function addUnique( $className );

    /**
     * @param $className
     * @return \injector\api\IInjectionMapper
     */
    public function addExceptTo($className );

    /**
     * @return \injector\api\IInjectionMapper
     */
    public function addToRest();

    /**
     * Returns the instance base on mapping type.
     * @return
     */
    public function getInstance( $where = '' );
}