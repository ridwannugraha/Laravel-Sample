<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class IocContainerFacades extends Facade {
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Name-IocContainer'; // the IoC binding.
    }
}