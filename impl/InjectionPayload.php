<?php

namespace injector\impl;

use injector\api\IInjectionPayload;

class InjectionPayload implements IInjectionPayload
{

    /** @var array */
    protected $payload;

    /**
     * @inheritdoc
     */
    public function addPayload(...$payload): void
    {
        $this->payload = $payload;
    }


    /**
     * @inheritdoc
     */
    public function getPayload()
    {
        return $this->payload;
    }
}