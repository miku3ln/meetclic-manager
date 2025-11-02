<?php

namespace App\Models;


use App\Models\Information\CustomerShopByInformationAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\InformationAddressLocationCurrent;

class InformationAddress extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    const ENTITY_TYPE_SALES_POINT = 1;
    const ENTITY_TYPE_CUSTOMERS = 0;
    const ENTITY_TYPE_CUSTOMER = 0;
    const ENTITY_TYPE_BUSINESS = 7;

    const MAIN = 1;
    const NOT_MAIN = 0;


    protected $table = 'information_address';

    protected $fillable = array(
        'street_one',//*
        'street_two',//*
        'reference',//*
        'state',//*
        'entity_id',//*
        'main',//*
        'entity_type',//*
        'information_address_type_id',//*
        'has_location',//*
        'options_map',//*
        "country_code_id",//*
        "administrative_area_level_2",//*google code types Ciudad
        "administrative_area_level_1",//*google code types Provincia
        "administrative_area_level_3",//google code types parroquia ,comunidad
        "entity_id",//*
        "entity_type",//*

    );
    protected $attributesData = [
        ['column' => 'street_one', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'street_two', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'reference', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'entity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'main', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'entity_type', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'information_address_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'has_location', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'options_map', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],

        ['column' => 'country_code_id', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'administrative_area_level_2', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'administrative_area_level_1', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'administrative_area_level_3', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],

    ];
    public $timestamps = false;

    protected $field_main = 'street_one';

    public static function getRulesModel()
    {
        $rules = ["street_one" => "required|max:150",
            "street_two" => "required|max:150",
            "reference" => "required",
            "state" => "required",
            "entity_id" => "required|numeric",
            "main" => "required|numeric",
            "entity_type" => "required|numeric",
            "information_address_type_id" => "required|numeric",
            "has_location" => "required|numeric",
            "options_map" => "required"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'desc';
        $field = 'main';
        $query = DB::table($this->table);
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;

        if (isset($params['sort'])) {
            /*         $field = $column = array_keys($params['sort']);
                     $field = $field[0];
                     $sort = $params['sort'][$column[0]];*/
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.street_one,$this->table.street_two,$this->table.reference,$this->table.state,$this->table.entity_id,$this->table.main,$this->table.entity_type,information_address_type.value as information_address_type,
information_address_type.id as information_address_type_id,
$this->table.has_location,$this->table.options_map";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_address_type', 'information_address_type.id', '=', $this->table . '.information_address_type_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->orWhere($this->table . '.street_one', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.street_two', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.reference', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_address_type.value", 'like', '%' . $likeSet . '%');


        }
        if ($entity_id != null && $entity_type != null) {

            $query->where(
                $this->table . '.entity_id', '=', $entity_id
            );
            $query->where(
                $this->table . '.entity_type', '=', $entity_type

            );
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

    public function getEntityByParams($params)
    {
        $entity_id = $params['entity_id'];
        $entity_type = $params['entity_type'];
        $information_address_type_id = $params['information_address_type_id'];

        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_address_type', 'information_address_type.id', '=', $this->table . '.information_address_type_id');
        $query->where($this->table . '.information_address_type_id', '=', $information_address_type_id);
        $query->where($this->table . '.entity_id', '=', $entity_id);
        $query->where($this->table . '.entity_type', '=', $entity_type);
        $query->where($this->table . '.main', '=', 1);
        $result = $query->get()->toArray();
        return $result;
    }

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();

        DB::beginTransaction();
        try {
            $modelName = 'InformationAddress';
            $model = new InformationAddress();
            $createUpdate = true;
            $row_id = null;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InformationAddress::find($attributesPost[$modelName]['id']);
                $row_id = $attributesPost[$modelName]['id'];
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $informationAddressData = $attributesPost[$modelName];
            $information_address_location_current = $attributesPost[$modelName]['information_address_location_current'];
            $information_address_location_current = json_decode($information_address_location_current, true);
            $informationAddressData['country_code_id'] = $information_address_location_current['country_code_id'];
            $informationAddressData['administrative_area_level_2'] = $information_address_location_current['administrative_area_level_2'];
            $informationAddressData['administrative_area_level_1'] = $information_address_location_current['administrative_area_level_1'];
            $informationAddressData['administrative_area_level_3'] = $information_address_location_current['administrative_area_level_3'];

            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $informationAddressData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {


                if ($attributesSet['main'] == '1') {
                    $modelIAC = new InformationAddressLocationCurrent;
                    $entity_id = $attributesSet['entity_id'];
                    $entity_type = $attributesSet['entity_type'];
                    $information_address_type_id = $attributesSet['information_address_type_id'];
                    $dataInformation = $this->getEntityByParams(array(
                        'entity_type' => $entity_type,
                        'entity_id' => $entity_id,
                        'information_address_type_id' => $information_address_type_id,
                    ));

                    foreach ($dataInformation as $key => $value) {
                        $allowSave = true;
                        if (!$createUpdate) {
                            $allowSave = $row_id == $value->id ? false : true;
                        }
                        if ($allowSave) {

                            $modelCurrent = InformationAddress::find($value->id);
                            $modelCurrent->main = 0;
                            $modelCurrent->save();
                        }
                    }


                }

                $model->fill($attributesSet);
                $success = $model->save();
                $data = $model->attributes;
            } else {
                $success = false;
                $msj = "Problemas al guardar  InformationAddress.";
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
                'data' => $data,
                "success" => $success
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                'data' => $data,
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
        $query->join('information_address_type', 'information_address_type.id', '=', $this->table . '.information_address_type_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.street_one', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.street_two', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.reference', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.main', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_type', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_address_type.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.has_location', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.options_map', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getInformation($params)
    {


        $query = DB::table($this->table);
        $selectString = "information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id');
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;
        $information_address_type_id = isset($params['filters']['information_address_type_id']) ? $params['filters']['information_address_type_id'] : null;
        $main = isset($params['filters']['main']) ? $params['filters']['main'] : null;
        $state = isset($params['filters']['state']) ? $params['filters']['state'] : null;

        if ($entity_id) {
            $query->where($this->table . '.entity_id', '=', $entity_id);
        }
        if ($entity_type) {
            $query->where($this->table . '.entity_type', '=', $entity_type);
        }
        if ($information_address_type_id) {
            $query->where($this->table . '.information_address_type_id', '=', $information_address_type_id);
        }
        if ($main) {
            $query->where($this->table . '.main', '=', $main);
        }
        if ($state) {
            $query->where($this->table . '.state', '=', $state);
        }
        $result = $query->first();
        return $result;

    }

    public function getListDataEntity($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,CONCAT(information_address.street_one,'-',information_address.street_one) text,information_address.id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_address_type', 'information_address_type.id', '=', $this->table . '.information_address_type_id');

        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;
        $information_address_type_id = isset($params['filters']['information_address_type_id']) ? $params['filters']['information_address_type_id'] : null;
        $main = isset($params['filters']['main']) ? $params['filters']['main'] : null;
        $state = isset($params['filters']['state']) ? $params['filters']['state'] : null;

        if ($entity_id) {
            $query->where($this->table . '.entity_id', '=', $entity_id);
        }
        if ($entity_type) {
            $query->where($this->table . '.entity_type', '=', $entity_type);
        }
        if ($information_address_type_id) {
            $query->where($this->table . '.information_address_type_id', '=', $information_address_type_id);
        }
        if ($main) {
            $query->where($this->table . '.main', '=', $main);
        }
        if ($state) {
            $query->where($this->table . '.state', '=', $state);
        }

        if (isset($params["filters"]['search_value'])) {

            $likeSet = $params["filters"]['search_value'];
            $query->orWhere($this->table . '.street_one', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.street_two', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.reference', 'like', '%' . $likeSet . '%');

        }


        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getCustomerAdminAddresInformationShop($params)
    {
        $sort = 'desc';
        $field = 'main';
        $query = DB::table($this->table);
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;

        if (isset($params['sort'])) {
            /*         $field = $column = array_keys($params['sort']);
                     $field = $field[0];
                     $sort = $params['sort'][$column[0]];*/
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.street_one,$this->table.street_two,$this->table.reference,$this->table.state,$this->table.entity_id,$this->table.main,$this->table.entity_type,information_address_type.value as information_address_type,
information_address_type.id as information_address_type_id,
$this->table.has_location,$this->table.options_map";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_address_type', 'information_address_type.id', '=', $this->table . '.information_address_type_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->orWhere($this->table . '.street_one', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.street_two', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.reference', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_address_type.value", 'like', '%' . $likeSet . '%');


        }
        if ($entity_id != null && $entity_type != null) {

            $query->where(
                $this->table . '.entity_id', '=', $entity_id
            );
            $query->where(
                $this->table . '.entity_type', '=', $entity_type

            );
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

    public function saveCustomerAddressInformationShop($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();

        DB::beginTransaction();
        try {
            $modelName = 'InformationAddress';
            $model = new InformationAddress();
            $createUpdate = true;
            $row_id = null;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InformationAddress::find($attributesPost[$modelName]['id']);
                $row_id = $attributesPost[$modelName]['id'];
                $information_address_id = $row_id;
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $informationAddressData = $attributesPost[$modelName];
            $information_address_location_current = $attributesPost[$modelName]['information_address_location_current'];
            $information_address_location_current = json_decode($information_address_location_current, true);
            $informationAddressData['country_code_id'] = $information_address_location_current['country_code_id'];
            $informationAddressData['administrative_area_level_2'] = $information_address_location_current['administrative_area_level_2'];
            $informationAddressData['administrative_area_level_1'] = $information_address_location_current['administrative_area_level_1'];
            $informationAddressData['administrative_area_level_3'] = $information_address_location_current['administrative_area_level_3'];

            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $informationAddressData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);

                $success = $model->save();
                $row_id = $model->id;
                $informationAddressData["information_address_id"]=$row_id;
                $data = $model->attributes;
                $modelCustomerShop = new CustomerShopByInformationAddress();
                if (!$createUpdate) {
                    $modelCustomerShop = CustomerShopByInformationAddress::findByAttributes([
                        "information_address_id" => $row_id

                    ]);
                }



                $attributesSet = $modelCustomerShop->getValuesModel(array('fillAble' => $modelCustomerShop->getFillable(), 'haystack' => $informationAddressData, 'attributesData' => $modelCustomerShop->getAttributesData()));
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => $modelCustomerShop->getRulesModel(),

                );

                $validateResult = $modelCustomerShop->validateModel($paramsValidate);

                $success = $validateResult["success"];
                if ($success) {
                    $modelCustomerShop->fill($attributesSet);
                    $success = $modelCustomerShop->save();
                } else {
                    $data=[];
                    $success = false;
                    $msj = "Problemas al guardar  InformationAddress Shop.";
                    $errors = $validateResult["errors"];
                }
            } else {
                $success = false;
                $msj = "Problemas al guardar  InformationAddress.";
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
                'data' => $data,
                "success" => $success
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                'data' => $data,
                "errors" => $errors
            );
            DB::rollBack();
            return ($result);
        }
    }
}
