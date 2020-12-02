<?php

namespace Watson\Breadcrumbs\Facades;

use Illuminate\Support\Facades\Facade;
use Watson\Breadcrumbs\Generator;

class Trail extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Generator::class;
    }
}
