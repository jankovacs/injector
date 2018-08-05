<?php

namespace JanKovacs\Injector\Api;

interface ProviderMapperInterface extends InjectionMapperInterface
{

    public const TO_PROVIDER = 'to_provider';

    /**
     *
     * @return InjectionProviderInterface
     */
    public function toProvider():InjectionProviderInterface;

    /**
     *
     * @param  string $endClassName the name of the class in which the mapped instance will be used
     *
     * @return string
     */
    public function getClassNameByEndClass(string $endClassName): string;
}
