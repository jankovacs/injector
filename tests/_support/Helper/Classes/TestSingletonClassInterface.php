<?php
/**
 * Copyright (C) Jan Kovacs - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */


namespace Helper\Classes;

interface TestSingletonClassInterface
{

    /**
     *
     * @return int
     */
    public function getSomeValue():int;

    /**
     *
     * @param  int $someValue some value for testing purposes
     * @return void
     */
    public function setSomeValue(int $someValue):void;
}
