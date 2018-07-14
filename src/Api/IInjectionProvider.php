<?php
namespace JanKovacs\Injector\Api;

interface IInjectionProvider {

    /**
     * @param string $className
     * @return IInjectionMapper
     */
    public function addUnique(string $className):IInjectionMapper;

    /**
     * @param string $className
     * @return IInjectionMapper
     */
    public function addExceptTo(string $className):IInjectionMapper;

    /**
     * @return IInjectionMapper
     */
    public function addToRest():IInjectionMapper;

    /**
     * @param string $where
     * @return null|object
     */
    public function getInstance(string $where = ''):?object;
}