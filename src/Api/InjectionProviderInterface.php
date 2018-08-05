<?php
namespace JanKovacs\Injector\Api;

use JanKovacs\Injector\Api\InjectionMapperInterface;

interface InjectionProviderInterface
{

    /**
     *
     * @param  string $className the name of the class in which a unique type will be injected
     *
     * @return InjectionMapperInterface
     */
    public function addUnique(string $className):InjectionMapperInterface;

    /**
     *
     * @return InjectionMapperInterface
     */
    public function addToRest():InjectionMapperInterface;


    /**
     *
     * @param  string $className the name of the class for what the mapping rules will be returned
     *
     * @return \JanKovacs\Injector\Api\InjectionMapperInterface|null
     */
    public function getMapperByRules(string $className): ?InjectionMapperInterface;
}
