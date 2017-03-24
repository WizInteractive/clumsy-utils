<?php

namespace Wizclumsy\Utils\Facades;

class Date extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Wizclumsy\Utils\Library\Date';
    }
}
