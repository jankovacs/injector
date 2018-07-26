<?php

namespace JanKovacs\Injector\Api;

interface IProviderMapper extends IInjectionMapper
{

    public const TO_PROVIDER = 'to_provider';

    /**
     *
     * @return IInjectionProvider
     */
    public function toProvider():IInjectionProvider;

    /**
     *
     * @param  string $endClassName the name of the class in which the mapped instance will be used
     *
     * @return string
     */
    public function getClassNameByEndClass(string $endClassName): string;
}
