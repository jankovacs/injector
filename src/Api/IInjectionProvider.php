<?php
namespace JanKovacs\Injector\Api;

use JanKovacs\Injector\Api\IInjectionMapper;

interface IInjectionProvider
{

    /**
     *
     * @param  string $className
     * @return IInjectionMapper
     */
    public function addUnique(string $className):IInjectionMapper;

    /**
     *
     * @param  string $className
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
     * @param  string $className
     * @return \JanKovacs\Injector\Api\IInjectionMapper|null
     */
    public function getMapperByRules(string $className): ?IInjectionMapper;
}
