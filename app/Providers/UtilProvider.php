<?php

namespace App\Providers;

use App\Models\BusinessByEmployeeProfile;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

use App\Models\Business;
use App\Models\EventsTrailsTypes;

use App\Models\Action;
use Blade;
use Request;
use Auth;
use Ekko;
use URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\HtmlString;
use App\Utils\Util;

class UtilProvider
{
    public static function dosNumeros($numero1, $numero2)
    {
        return $numero1 + $numero2;
    }
}
