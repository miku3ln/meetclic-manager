<?php

namespace App\Utils;

use App;
use Illuminate\Support\Arr;

class LanguageUtil
{
    public static function getValidationLangFlat(): array
    {
        $result = ["validations"=>[],"form"=>[]];
       $all = trans('validation');      // array grande
        $flat = Arr::dot($all);          // flatten


        foreach ($flat as $k => $v) {
            $result["validations"]["$k"] = $v;
        }


        $all = trans('form');      // array grande
        $flat = Arr::dot($all);          // flatten


        foreach ($flat as $k => $v) {
            $result["form"]["$k"] = $v;
        }

        return $result;
    }
}
