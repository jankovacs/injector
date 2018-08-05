<?php

namespace JanKovacs\Injector\Impl;

use JanKovacs\Injector\Api\InjectionProviderInterface;
use JanKovacs\Injector\Api\ProviderMapperInterface;

class ExtendedMapper extends InjectionMapper implements ProviderMapperInterface
{

    /** @var \JanKovacs\Injector\Api\InjectionProviderInterface */
    protected $injectionProvider;

    /**
     *
     * @return InjectionProviderInterface
     */
    public function toProvider():InjectionProviderInterface
    {
        $this->mappingType = ProviderMapperInterface::TO_PROVIDER;
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
