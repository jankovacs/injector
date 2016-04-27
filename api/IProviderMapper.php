<?php

namespace injector\api;


interface IProviderMapper {

    /**
     * @return \injector\api\IInjectionProvider
     */
    public function toProvider();
}