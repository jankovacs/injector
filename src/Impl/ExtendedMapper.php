<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\IInjectionMapper;
use JanKovacs\Injector\Api\IInjectionProvider;
use JanKovacs\Injector\Api\IProviderMapper;

class ExtendedMapper extends InjectionMapper implements IProviderMapper
{
    /** @var IInjectionProvider */
    protected $injectionProvider;

    protected const TO_PROVIDER = 'to_provider';

    /**
     * @return IInjectionProvider
     */
    public function toProvider():IInjectionProvider
    {
        $this->mappingType = self::TO_PROVIDER;
        $this->injectionProvider = new InjectionProvider( $this->className );
        return $this->injectionProvider;
    }

    /**
     * @param string $where
     * @return object
     */
    public function getInstance(string $where = '' ):object
    {
        return $this->mappingType == self::TO_PROVIDER ? $this->provideInstance( $where ) : parent::getInstance( $where );
    }

    /**
     * @param string $where
     * @return object
     */
    protected function provideInstance(string $where):object
    {
        return $this->injectionProvider->getInstance($where);
    }
}