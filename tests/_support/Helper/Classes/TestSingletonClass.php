<?php
/**
 * Copyright (C) Jan Kovacs - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */


namespace Helper\Classes;


class TestSingletonClass implements ITestSingletonClass
{

    protected $someValue;


    /**
     * @return int
     */
    public function getSomeValue():int
    {
        return $this->someValue;
    }

    /**
     * @param int $someValue
     * @return void
     */
    public function setSomeValue(int $someValue):void
    {
        $this->someValue = $someValue;
    }
}