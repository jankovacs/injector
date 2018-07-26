<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\IInjectionProvider;
use JanKovacs\Injector\Api\IProviderMapper;

class ExtendedMapper extends InjectionMapper implements IProviderMapper
{

    /** @var \JanKovacs\Injector\Api\IInjectionProvider */
    protected $injectionProvider;

    /**
     *
     * @return IInjectionProvider
     */
    public function toProvider():IInjectionProvider
    {
        $this->mappingType = IProviderMapper::TO_PROVIDER;
        $this->injectionProvider = new InjectionProvider($this->className);
        return $this->injectionProvider;
    }

    /**
     *
     * @param  string $endClassName the name of the class in which the mapped instance will be used
     *
     * @return string
     */
    public function getClassNameByEndClass(string $endClassName): string
    {
        return $this->injectionProvider
            ->getMapperByRules($endClassName)
            ->getClassName();
    }
}
