<?php
namespace JanKovacs\Injector\Api;

use JanKovacs\Injector\Api\IInjectionMapper;

interface IInjectionProvider
{

    /**
     *
     * @param  string $className the name of the class in which a unique type will be injected
     *
     * @return IInjectionMapper
     */
    public function addUnique(string $className):IInjectionMapper;

    /**
     *
     * @param  string $className the name of the class to which the given should not be injected
     *
     * @return IInjectionMapper
     */
    public function addExceptTo(string $className):IInjectionMapper;

    /**
     *
     * @return IInjectionMapper
     */
    public function addToRest():IInjectionMapper;


    /**
     *
     * @param  string $className the name of the class for what the mapping rules will be returned
     *
     * @return \JanKovacs\Injector\Api\IInjectionMapper|null
     */
    public function getMapperByRules(string $className): ?IInjectionMapper;
}
