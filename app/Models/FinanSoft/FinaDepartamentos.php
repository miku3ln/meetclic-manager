<?php


namespace App\Models\FinanSoft;

use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\ModelManager;

class FinaDepartamentos extends ModelManager
{

    protected $table = 'FINA_DEPARTAMENTOS';
    protected $fieldMain = "COMP_ID";

    protected $fillable = array(
        'COMP_ID',
        'DEPA_ID',
        'DEPA_NOMBRE',
        'DEPA_LOCALIZACION',
        'DEPA_CUEN_COSTO',
        'DEPA_CUEN_DESCUENTOS',
        'DEPA_CUEN_COMPRAS',
        'DEPA_CUEN_INVENTARIO',
        'DEPA_VENTAS',
        'USUA_ID',
        'USUA_FECHA',

    );

    public $timestamps = false;


    public static function getRulesModel()
    {
        $rules = [
        ];
        return $rules;
    }




}
