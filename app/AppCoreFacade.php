<?php

namespace App;

use App\AppCore as RealAppCore;
use Illuminate\Support\Facades\Facade;

class AppCoreFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RealAppCore::class;
    }
}
