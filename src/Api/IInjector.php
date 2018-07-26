<?php

namespace JanKovacs\Injector\Api;

/**
 * Interface IInjector
 *
 * @var     boolean $isInjectable
 * @package JanKovacs\Injector\Api
 */
interface IInjector
{

    /**
     *
     * @param  string $className the name of the class/interface which will be mapped
     *
     * @return IProviderMapper
     */
    public function map(string $className):IProviderMapper;

    /**
     *
     * @param  string $className the name of the class/interface which is already mapped
     * @param  string $where     the name of class to which an instance is going to be injected, optional
     *
     * @return null|object
     */
    public function getInstance(string $className, string $where = ''):?object;
}
