<?php
/**
 * Copyright (C) Jan Kovacs - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */


namespace Helper\Classes\ForProvider\EndClasses;


use Helper\Classes\ForProvider\IClassForProvider;

interface IEndClass
{

    /**
     *
     * @return IClassForProvider
     */
    public function getClassForProviderInstance():IClassForProvider;

}
