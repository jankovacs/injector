<?php
/**
 * Copyright (C) Jan Kovacs - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */


namespace Helper\Classes\ForProvider\EndClasses;

use Helper\Classes\ForProvider\ClassForProviderInterface;

class BaseEndClass implements EndClassInterface
{

    protected $classForProvider;


    /**
     * BaseEndClass constructor.
     * @param ClassForProviderInterface $classForProvider class used for provider interface test
     */
    public function __construct(ClassForProviderInterface $classForProvider)
    {
        $this->classForProvider = $classForProvider;
    }

    /**
     *
     * @return ClassForProviderInterface
     */
    public function getClassForProviderInstance(): ClassForProviderInterface
    {
        return $this->classForProvider;
    }
}
