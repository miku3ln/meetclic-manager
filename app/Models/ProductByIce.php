<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class ProductByIce extends  ModelManager
{
const STATE_ACTIVE = 'ACTIVE';
const STATE_INACTIVE = 'INACTIVE';
protected $table='product_by_ice';

protected $fillable =array(
'product_id',//*
'product_ice_id',//*
'value'//*

);
protected $attributesData =[
['column'=>'product_id','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'product_ice_id','type'=>'integer','defaultValue'=>'','required'=>'true'],
['column'=>'value','type'=>'string','defaultValue'=>'','required'=>'true']

];
public $timestamps = false;

protected $field_main='value';

public static function getRulesModel()
{
$rules = ["product_id"=>"required|numeric",
"product_ice_id"=>"required|numeric",
"value"=>"required|numeric"
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

$selectString = "$this->table.id,product.code as product,
product.id as product_id,
product_ice.value as product_ice,
product_ice.id as product_ice_id,
$this->table.value";

$select = DB::raw($selectString);
$query->select($select);
$query->join('product','product.id','=',$this->table.'.product_id');
$query->join('product_ice','product_ice.id','=',$this->table.'.product_ice_id');
if ($params['searchPhrase'] != null) {
$searchValue = $params['searchPhrase'];
$likeSet =  $searchValue;
$query->orWhere($this->table.'.id','like','%'.$likeSet.'%');
$query->orWhere("product.code",'like','%'.$likeSet.'%');
$query->orWhere("product_ice.value",'like','%'.$likeSet.'%');
$query->orWhere($this->table.'.value','like','%'.$likeSet.'%');
;

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
$modelName= 'ProductByIce';
$model = new ProductByIce();
$createUpdate = true;

    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
    $model = ProductByIce::find($attributesPost[$modelName]['id']);
    $createUpdate = false;
    } else {
    $createUpdate = true;
    }




    $productByIceData = $attributesPost[$modelName];
    $attributesSet = $this->getValuesModel(array('fillAble'=>$this->fillable,'haystack'=>$productByIceData,'attributesData'=>$this->attributesData));
    $paramsValidate = array(
    'inputs' => $attributesSet,
    'rules' => self::getRulesModel(),

    );
    $validateResult = $this->validateModel($paramsValidate);
    $success = $validateResult["success"];
    if ($success) {
    $model->fill($attributesSet);
    $success = $model->save();
    } else {
    $success = false;
    $msj = "Problemas al guardar  ProductByIce.";
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
$query->join('product','product.id','=',$this->table.'.product_id');
$query->join('product_ice','product_ice.id','=',$this->table.'.product_ice_id');
if (isset($params["filters"]['search_value']["term"])) {

$likeSet = $params["filters"]['search_value']["term"];
$query->orWhere($this->table.'.id','like','%'.$likeSet.'%');
$query->orWhere("product.code",'like','%'.$likeSet.'%');
$query->orWhere("product_ice.value",'like','%'.$likeSet.'%');
$query->orWhere($this->table.'.value','like','%'.$likeSet.'%');
;

}

$query->limit(10)->orderBy($field, 'asc');
$result = $query->get()->toArray();
return $result;

}

}
