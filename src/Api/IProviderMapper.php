<?php

namespace JanKovacs\Injector\Api;


interface IProviderMapper extends IInjectionMapper {

    public const TO_PROVIDER = 'to_provider';

    /**
     * @return IInjectionProvider
     */
    public function toProvider():IInjectionProvider;

    /**
     * @param string $endClassName
     * @return string
     */
    public function getClassNameByEndClass(string $endClassName): string;
}