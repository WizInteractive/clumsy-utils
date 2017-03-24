<?php

namespace Wizclumsy\Utils\Facades;

class Geo extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Wizclumsy\Utils\Library\Geo';
    }
}
