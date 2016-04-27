<?php

namespace injector\impl;

use injector\api\IInjectionMapper;
use injector\api\IProviderMapper;

class ExtendedMapper extends InjectionMapper implements IProviderMapper, IInjectionMapper
{
    /**
     * @var \injector\api\IInjectionProvider
     */
    private $injectionProvider;

    const TO_PROVIDER = 'to_provider';

    /**
     * @return \injector\api\IInjectionProvider|InjectionProvider
     */
    public function toProvider()
    {
        $this->mappingType = self::TO_PROVIDER;
        $this->injectionProvider = new InjectionProvider( $this->className );
        return $this->injectionProvider;
    }

    public function getInstance( $where = '' )
    {
        return $this->mappingType == self::TO_PROVIDER ? $this->provideInstance( $where ) : parent::getInstance( $where );
    }

    private function provideInstance( $where )
    {
        return $this->injectionProvider->getInstance( $where );
    }
}