<?php

namespace App\Facades;

use Silver\Support\Facade;


/**
 * datatablehtml event provider
 */
class DataTableHTML extends Facade
{

    protected static function getClass()
    {
        return 'App\Helpers\DataTableHTML';
    }

}
