<?php
/**
 * Copyright (C) Jan Kovacs - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */


namespace Helper\Classes\ForProvider\EndClasses;

use Helper\Classes\ForProvider\ClassForProviderInterface;

interface EndClassInterface
{

    /**
     *
     * @return ClassForProviderInterface
     */
    public function getClassForProviderInstance():ClassForProviderInterface;
}
