<?php


namespace App\Models\FinanSoft;

use Auth;

use App\Models\ModelManager;

class FinaListaPrecios extends ModelManager
{

    protected $table = 'FINA_LISTAPRECIOS';
    protected $fieldMain = "LIST_ID";

    protected $fillable = array(
        'COMP_ID',
        'LIST_ID',
        'LIST_NOMBRE',
        'LIST_GANANCIA',
        'LIST_REDONDEAR',
        'LIST_ENCOMPRA'

    );

    public $timestamps = false;


    public static function getRulesModel()
    {
        $rules = [
        ];
        return $rules;
    }




}
