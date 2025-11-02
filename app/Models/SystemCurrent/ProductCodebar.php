<?php

namespace App\Models\SystemCurrent;

use App\Models\Exception;
use App\Models\ModelManager;

use Auth;
use Illuminate\Support\Facades\DB;


class ProductCodebar extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const VIEW_ONLINE = 1;

    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_codebar';

    protected $fillable = array(
        'PRBA_CODIGO',//*
        'PROD_ID',//*
        'PROD_NOMBRE',//*
        'PROD_PRECIO',//*
        'COMP_RNC ',//*


    );

    public static function getRulesModel()
    {
        $rules = [
            "PRBA_CODIGO" => "required",
            "PROD_ID" => "required",
            "PROD_NOMBRE" => "required",
            "PROD_PRECIO" => "required",
            "COMP_RNC" => "required",

        ];
        return $rules;
    }

    protected $attributesData = [
        ['column' => 'PRBA_CODIGO', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'PROD_ID', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'PROD_NOMBRE', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'PROD_PRECIO', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'COMP_RNC', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = true;

    protected $field_main = 'COMP_RNC ';

}
