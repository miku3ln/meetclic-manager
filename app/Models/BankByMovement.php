<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;
use Auth;



class BankByMovement extends  ModelManager
{
const STATE_ACTIVE = 'ACTIVE';
const STATE_INACTIVE = 'INACTIVE';
protected $table='bank_by_movement';

protected $fillable =array(
'user_id',//*
'state',//*
'movement_type',//*
'accounting_account_id',//*
'details',
'rode',//*
'date_current',//*
'transaction_type',//*
'entity_type',//*
'entity_id',//*
'created_at',//*
'update_at',//*
'available_balance',//*
'bank_reason_id',//*
'accounting_bank_id',//*
'document_number',//*
'transaction'//*

);
protected $attributesData =[
['column'=>'user_id','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'state','type'=>'string','defaultValue'=>'ACTIVE','required'=>'true'],
['column'=>'movement_type','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'accounting_account_id','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'details','type'=>'string','defaultValue'=>'','required'=>'false'],
['column'=>'rode','type'=>'double','defaultValue'=>'','required'=>'true'],
['column'=>'date_current','type'=>'string','defaultValue'=>'','required'=>'true'],
['column'=>'transaction_type','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'entity_type','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'entity_id','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'created_at','type'=>'string','defaultValue'=>'','required'=>'true'],
['column'=>'update_at','type'=>'string','defaultValue'=>'','required'=>'true'],
['column'=>'available_balance','type'=>'double','defaultValue'=>'','required'=>'true'],
['column'=>'bank_reason_id','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'accounting_bank_id','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'document_number','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'transaction','type'=>'integer','defaultValue'=>'0','required'=>'true']

];
public $timestamps = false;

protected $field_main='state';

public static function getRulesModel()
{
$rules = ["user_id"=>"required|numeric",
"state"=>"required",
"movement_type"=>"required|numeric",
"accounting_account_id"=>"required|numeric",
"rode"=>"required|numeric",
"date_current"=>"required",
"transaction_type"=>"required|numeric",
"entity_type"=>"required|numeric",
"entity_id"=>"required|numeric",
"created_at"=>"required",
"update_at"=>"required",
"available_balance"=>"required|numeric",
"bank_reason_id"=>"required|numeric",
"accounting_bank_id"=>"required|numeric",
"document_number"=>"required|numeric",
"transaction"=>"required|numeric"
];
return $rules;
}



/*MANAGER MAINS*/

public function getAdmin($params)
{
$sort = 'asc';
$field = $this->field_main;
$query = DB::table($this->table);

if (isset($params['sort'])) {
$field = $column = array_keys($params['sort']);
$field = $field[0];
$sort = $params['sort'][$column[0]];
}

$page = isset($params['current']) ? (int)$params['current'] : 0;
$perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

$selectString = "$this->table.id,$this->table.user_id,$this->table.state,$this->table.movement_type,$this->table.accounting_account_id,$this->table.details,$this->table.rode,$this->table.date_current,$this->table.transaction_type,$this->table.entity_type,$this->table.entity_id,$this->table.created_at,$this->table.update_at,$this->table.available_balance,$this->table.bank_reason_id,$this->table.accounting_bank_id,$this->table.document_number,$this->table.transaction";

$select = DB::raw($selectString);
$query->select($select);
if ($params['searchPhrase'] != null) {
$searchValue = $params['searchPhrase'];
$likeSet =  $searchValue;
   $query->where(function ($query) use (                   $likeSet
            ) {$query->orWhere($this->table.'.id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.user_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.state','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.movement_type','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.accounting_account_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.details','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.rode','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.date_current','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.transaction_type','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.entity_type','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.entity_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.created_at','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.update_at','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.available_balance','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.bank_reason_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.accounting_bank_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.document_number','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.transaction','like','%'.$likeSet.'%');
 });;

}

$recordsTotal = $query->get()->count();
$pages = 1;
$total = $recordsTotal; // total items in array
// sort
$query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
if ($perpage > 0) {
$pages = ceil($total / $perpage); // calculate total pages
$page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
$page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
$offset = ($page - 1) * $perpage;
if ($offset < 0) {
$offset = 0;
}
$query->offset((int)$offset);
$query->limit((int)$perpage);
}
$current_page = isset($params['current']) ? (int)$params['current'] : 0;
$data = $query->get()->toArray();

$result['total'] = $total;
$result['rows'] = $data;
$result['current'] = $current_page;
$limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
$result['rowCount'] = $limit;

return $result;
}


public function saveData($params)
{
$success = false;
$msj = "";
$result = array();
$attributesPost = $params["attributesPost"];
$errors = array();
DB::beginTransaction();
try {
$modelName= 'BankByMovement';
$model = new BankByMovement();
$createUpdate = true;

    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
    $model = BankByMovement::find($attributesPost[$modelName]['id']);
    $createUpdate = false;
    } else {
    $createUpdate = true;
    }




    $bankByMovementData = $attributesPost[$modelName];
    $attributesSet = $this->getValuesModel(array('fillAble'=>$this->fillable,'haystack'=>$bankByMovementData,'attributesData'=>$this->attributesData));
    $paramsValidate = array(
    'modelAttributes' => $attributesSet,
    'rules' => self::getRulesModel(),

    );
    $validateResult = $this->validateModel($paramsValidate);
    $success = $validateResult["success"];
    if ($success) {
    $model->fill($attributesSet);
    $success = $model->save();
    } else {
    $success = false;
    $msj = "Problemas al guardar  BankByMovement.";
    $errors = $validateResult["errors"];
    }
    if (!$success) {
    DB::rollBack();

    } else {
    DB::commit();
    }
    $result = [
    "errors" => $errors,
    "msj" => $msj,
    "success" => $success
    ];





return ($result);
} catch (Exception $e) {

$msj = $e->getMessage();
$result = array(
"success" => $success,
"msj" => $msj,
"errors" => $errors
);
return ($result);
}

}

public function getListSelect2($params)
{
$textValue = $this->table . '.' . $this->field_main;
$field = $textValue;
$query = DB::table($this->table);
$selectString = "$this->table.id,$textValue as text";
$select = DB::raw($selectString);
$query->select($select);
if (isset($params["filters"]['search_value']["term"])) {

$likeSet = $params["filters"]['search_value']["term"];
   $query->where(function ($query) use (                   $likeSet
            ) {$query->orWhere($this->table.'.id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.user_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.state','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.movement_type','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.accounting_account_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.details','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.rode','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.date_current','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.transaction_type','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.entity_type','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.entity_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.created_at','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.update_at','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.available_balance','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.bank_reason_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.accounting_bank_id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.document_number','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.transaction','like','%'.$likeSet.'%');
 });;

}

$query->limit(10)->orderBy($field, 'asc');
$result = $query->get()->toArray();
return $result;

}

}