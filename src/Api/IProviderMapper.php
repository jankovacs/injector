<?php

namespace JanKovacs\Injector\Api;


interface IProviderMapper extends IInjectionMapper {

    /**
     * @return IInjectionProvider
     */
    public function toProvider():IInjectionProvider;
}