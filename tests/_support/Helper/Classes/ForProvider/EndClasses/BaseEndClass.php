<?php
/**
 * Copyright (C) Jan Kovacs - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */


namespace Helper\Classes\ForProvider\EndClasses;


use Helper\Classes\ForProvider\IClassForProvider;

class BaseEndClass implements IEndClass
{

    protected $classForProvider;


    public function __construct(IClassForProvider $classForProvider)
    {
        $this->classForProvider = $classForProvider;
    }

    /**
     *
     * @return IClassForProvider
     */
    public function getClassForProviderInstance(): IClassForProvider
    {
        return $this->classForProvider;
    }
}
