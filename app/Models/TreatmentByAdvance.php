<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;
use Auth;



class TreatmentByAdvance extends  ModelManager
{
const STATE_ACTIVE = 'ACTIVE';
const STATE_INACTIVE = 'INACTIVE';
protected $table='treatment_by_advance';

protected $fillable =array(
'advance',//*
'type_input',//*
'created_at',
'updated_at',
'deleted_at',
'treatment_by_patient_id'//*

);
protected $attributesData =[
['column'=>'advance','type'=>'string','defaultValue'=>'0.00','required'=>'true'],
['column'=>'type_input','type'=>'integer','defaultValue'=>'0','required'=>'true'],
['column'=>'created_at','type'=>'string','defaultValue'=>'','required'=>'false'],
['column'=>'updated_at','type'=>'string','defaultValue'=>'','required'=>'false'],
['column'=>'deleted_at','type'=>'string','defaultValue'=>'','required'=>'false'],
['column'=>'treatment_by_patient_id','type'=>'integer','defaultValue'=>'','required'=>'true']

];
public $timestamps = false;

protected $field_main='advance';

public static function getRulesModel()
{
$rules = ["advance"=>"required|numeric",
"type_input"=>"required|numeric",
"treatment_by_patient_id"=>"required|numeric"
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

$selectString = "$this->table.id,$this->table.advance,$this->table.type_input,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,treatment_by_patient.invoice_code as treatment_by_patient,
treatment_by_patient.id as treatment_by_patient_id
";

$select = DB::raw($selectString);
$query->select($select);
$query->join('treatment_by_patient','treatment_by_patient.id','=',$this->table.'.treatment_by_patient_id');
if ($params['searchPhrase'] != null) {
$searchValue = $params['searchPhrase'];
$likeSet =  $searchValue;
   $query->where(function ($query) use (                   $likeSet
            ) {$query->orWhere($this->table.'.id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.advance','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.type_input','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.created_at','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.updated_at','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.deleted_at','like','%'.$likeSet.'%');
$query->orWhere("treatment_by_patient.invoice_code",'like','%'.$likeSet.'%');
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
$modelName= 'TreatmentByAdvance';
$model = new TreatmentByAdvance();
$createUpdate = true;

    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
    $model = TreatmentByAdvance::find($attributesPost[$modelName]['id']);
    $createUpdate = false;
    } else {
    $createUpdate = true;
    }




    $treatmentByAdvanceData = $attributesPost[$modelName];
    $attributesSet = $this->getValuesModel(array('fillAble'=>$this->fillable,'haystack'=>$treatmentByAdvanceData,'attributesData'=>$this->attributesData));
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
    $msj = "Problemas al guardar  TreatmentByAdvance.";
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
$query->join('treatment_by_patient','treatment_by_patient.id','=',$this->table.'.treatment_by_patient_id');
if (isset($params["filters"]['search_value']["term"])) {

$likeSet = $params["filters"]['search_value']["term"];
   $query->where(function ($query) use (                   $likeSet
            ) {$query->orWhere($this->table.'.id','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.advance','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.type_input','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.created_at','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.updated_at','like','%'.$likeSet.'%');
$query->orWhere($this->table.'.deleted_at','like','%'.$likeSet.'%');
$query->orWhere("treatment_by_patient.invoice_code",'like','%'.$likeSet.'%');
 });;

}

$query->limit(10)->orderBy($field, 'asc');
$result = $query->get()->toArray();
return $result;

}

}