<?php

namespace JanKovacs\Injector\Api;


/**
 * Interface IInjector
 *
 * @var boolean $isInjectable
 * @package JanKovacs\Injector\Api
 */
interface IInjector {

    /**
     * @param string $className
     * @return IProviderMapper
     */
    public function map(string $className):IProviderMapper;

    /**
     * @param string $className
     * @param string $where
     * @return null|object
     */
    public function getInstance(string $className, string $where = ''):?object;
}