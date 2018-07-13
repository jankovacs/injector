<?php


namespace injector\api;


interface IInjectionPayload
{

    /**
     * Adds the payloads. Please use the correct positions!
     *
     * @api
     *
     * @param mixed ...$payload
     */
    public function addPayload(...$payload);


    /**
     * Returns the payload
     *
     * @api
     *
     * @return array
     */
    public function getPayload();

}