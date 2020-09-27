<?php

namespace Watson\Breadcrumbs\Facades;

use Illuminate\Support\Facades\Facade;

class Trail extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'breadcrumbs.generator';
    }
}
