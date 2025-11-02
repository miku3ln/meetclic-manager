<?php


namespace App\Models\FinanSoft;

use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\ModelManager;

class FinaClases extends ModelManager
{

    protected $table = 'FINA_CLASES';
    protected $fieldMain = "CLAS_ID";

    protected $fillable = array(
        'COMP_ID',
        'CLAS_ID',
        'DEPA_ID',
        'CLAS_NOMBRE',
        'CLAS_CUEN_COSTO',
        'CLAS_CUEN_DESCUENTOS',
        'CLAS_CUEN_INVENTARIO',
        'CLAS_CUEN_COMPRAS',
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
