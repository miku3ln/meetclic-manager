<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


use App\Models\Multimedia;

class BusinessAmenities extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_amenities';

    protected $fillable = array(
        'value',//*
        'description',
        'state',//*
        'source',
        'type_source',//*
        'business_subcategories_id'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'type_source', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'business_subcategories_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:150",
            "state" => "required",
            "source" => "max:350",
            "type_source" => "required|numeric",
            "business_subcategories_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.value,$this->table.description,$this->table.state,$this->table.source,$this->table.type_source,business_subcategories.name as business_subcategories,
business_subcategories.id as business_subcategories_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_subcategories', 'business_subcategories.id', '=', $this->table . '.business_subcategories_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_source', 'like', '%' . $likeSet . '%');
                $query->orWhere("business_subcategories.name", 'like', '%' . $likeSet . '%');
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
            $modelName = 'BusinessAmenities';
            $model = new BusinessAmenities();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = BusinessAmenities::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }


            $businessAmenitiesData = $attributesPost;
            $source = $businessAmenitiesData["source"];
            $pathSet = "/uploads/business/businessAmenities";
            $change = $businessAmenitiesData["change"];
            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];

            if ($successMultimedia) {


                $source = $successMultimediaModel['source'];
                $businessAmenitiesData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessAmenitiesData, 'attributesData' => $this->attributesData));
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
                    $msj = "Problemas al guardar  BusinessAmenities.";
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


            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }


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
        $selectString = "$this->table.id,$textValue as text,business_subcategories.name business_subcategories,business_subcategories.id business_subcategories_id";
        $select = DB::raw($selectString);
        $business_subcategories_id = isset($params['filters']['subcategory_id']) ? $params['filters']['subcategory_id'] : null;
        $query->select($select);
        $query->join('business_subcategories', 'business_subcategories.id', '=', $this->table . '.business_subcategories_id');
        if ($business_subcategories_id) {

            /*$query->where($this->table . '.business_subcategories_id', '=', $business_subcategories_id);*/
        }

        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {

                $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere("business_subcategories.name", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getAmenitiesBusiness($params)
    {
        $table = 'business_by_amenities';
        $business_id = $params['filters']['business_id'];
        $query = DB::table($table);
        $table_name_data = 'business_amenities';
        $orderField = $table_name_data . '.value';
        $table_name_data_key = 'business_amenities_id';
        $selectString = $table_name_data . ".value," . $table_name_data . ".value as text ," . $table_name_data . ".id,$table_name_data.source,$table_name_data.type_source";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $table . '.business_id');
        $query->join($table_name_data, $table_name_data . '.id', '=', $table . '.' . $table_name_data_key);
        $query->where($table . '.business_id', '=', $business_id);
        $query->orderBy($orderField, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
}
