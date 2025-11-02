<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\TemplateContactUs;


class InformationSocialNetwork extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'information_social_network';
    const MAIN = 1;
    const NOT_MAIN = 0;
    const ENTITY_TYPE_CUSTOMER = 0;
    const ENTITY_TYPE_EMPLOYER = 1;

    const ENTITY_TYPE_BUSINESS = 4;
    protected $fillable = array(
        'value',//*
        'state',//*
        'entity_id',//*
        'main',//*
        'entity_type',//*
        'information_social_network_type_id'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'entity_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'main', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'entity_type', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'information_social_network_type_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:150",
            "state" => "required",
            "entity_id" => "required|numeric",
            "main" => "required|numeric",
            "entity_type" => "required|numeric",
            "information_social_network_type_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'desc';
        $field = 'main';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            /*   $field = $column = array_keys($params['sort']);
               $field = $field[0];
               $sort = $params['sort'][$column[0]];*/
        }
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.value,$this->table.state,$this->table.entity_id,$this->table.main,$this->table.entity_type,information_social_network_type.value as information_social_network_type,
information_social_network_type.id as information_social_network_type_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_social_network_type', 'information_social_network_type.id', '=', $this->table . '.information_social_network_type_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_social_network_type.value", 'like', '%' . $likeSet . '%');;

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


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'InformationSocialNetwork';
            $model = new InformationSocialNetwork();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InformationSocialNetwork::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $informationSocialNetworkData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $informationSocialNetworkData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                if (!$createUpdate) {

                    if ($attributesSet['main']) {
                        $entity_id = $attributesSet['entity_id'];
                        $entity_type = $attributesSet['entity_type'];
                        $information_social_network_type_id = $attributesSet['information_social_network_type_id'];
                        $dataInformation = InformationSocialNetwork::where('entity_type', $entity_type)
                            ->where('entity_id', $entity_id)
                            ->where('information_social_network_type_id', $information_social_network_type_id)
                            ->where('state', self::STATE_ACTIVE)
                            ->where('main', 1)->update(['main' => 0]);
                    }
                }
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  InformationSocialNetwork.";
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

    public function saveDataFrontend($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();
        DB::beginTransaction();
        try {
            $modelName = 'InformationSocialNetwork';
            $model = new InformationSocialNetwork();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InformationSocialNetwork::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $informationSocialNetworkData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $informationSocialNetworkData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                if (!$createUpdate) {

                    if ($attributesSet['main']) {
                        $entity_id = $attributesSet['entity_id'];
                        $entity_type = $attributesSet['entity_type'];
                        $information_social_network_type_id = $attributesSet['information_social_network_type_id'];
                        $dataInformation = InformationSocialNetwork::where('entity_type', $entity_type)
                            ->where('entity_id', $entity_id)
                            ->where('information_social_network_type_id', $information_social_network_type_id)
                            ->where('state', self::STATE_ACTIVE)
                            ->where('main', 1)->update(['main' => 0]);
                    }
                }
                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  InformationSocialNetwork.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $modelTCU = new TemplateContactUs();
                $business_id = $informationSocialNetworkData['business_id'];
                $template_information_id = $informationSocialNetworkData['template_information_id'];
                $data = $modelTCU->getContactUsData([
                    'filters' => [
                        'business_id' => $business_id,
                        'template_information_id' => $template_information_id,

                    ]

                ]);
                $data['business_id'] = $business_id;
                $data['model_id'] = $template_information_id;

                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "data" => $data
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
        $query->join('information_social_network_type', 'information_social_network_type.id', '=', $this->table . '.information_social_network_type_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];

            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.entity_type', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_social_network_type.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getSocialNetworkInformation($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue,$this->table.state,$this->table.entity_id,$this->table.main,$this->table.entity_type,$this->table.information_social_network_type_id
       ,information_social_network_type.value social_network_name,information_social_network_type.icon social_network_icon ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_social_network_type', $this->table . '.information_social_network_type_id', 'information_social_network_type.id');

        $entity_id = $params['filters']['entity_id'];
        $entity_type = $params['filters']['entity_type'];
        $information_social_network_type_id = $params['filters']['information_social_network_type_id'];

        $query->where($this->table . '.entity_id', '=', $entity_id);
        $query->where($this->table . '.state', '=', 'ACTIVE');
        $query->where($this->table . '.entity_type', '=', $entity_type);
        $query->where($this->table . '.information_social_network_type_id', '=', $information_social_network_type_id);

        $query->orderBy($field, 'asc');
        $result = $query->first();
        return $result;

    }

    public function deleteFrontend($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();
        DB::beginTransaction();
        try {
            $modelName = 'InformationSocialNetwork';
            $model = new InformationSocialNetwork();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = InformationSocialNetwork::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $success = $model->delete();
            if ($success) {

            } else {
                $success = false;
                $msj = "Problemas al guardar  InformationSocialNetwork.";
                $errors = 'No se elimino.';
            }
            $informationSocialNetworkData = $attributesPost[$modelName];

            if (!$success) {
                DB::rollBack();

            } else {
                $modelTCU = new TemplateContactUs();
                $business_id = $informationSocialNetworkData['business_id'];
                $template_information_id = $informationSocialNetworkData['template_information_id'];

                $data = $modelTCU->getContactUsData([
                    'filters' => [
                        'business_id' => $business_id,
                        'template_information_id' => $template_information_id,

                    ]

                ]);
                $data['business_id'] = $business_id;
                $data['model_id'] = $template_information_id;

                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "data" => $data
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

    public function getAllFrontend($params = array())
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;

        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue,$this->table.state,$this->table.entity_id,$this->table.main,$this->table.entity_type,$this->table.information_social_network_type_id
       ,information_social_network_type.value information_social_network_type,information_social_network_type.icon ";
        $select = DB::raw($selectString);
        $query->select($select);

        $entity_id = $params['filters']['entity_id'];
        $entity_type = $params['filters']['entity_type'];
        $query->join('information_social_network_type', 'information_social_network_type.id', '=', $this->table . '.information_social_network_type_id');

        $query->where($this->table . '.entity_id', '=', $entity_id);
        $query->where($this->table . '.state', '=', 'ACTIVE');
        $query->where($this->table . '.entity_type', '=', $entity_type);

        $query->orderBy($field, 'asc');
        $data = $query->get()->toArray();

        return $data;
    }

    public function getInformation($params)
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.value information_social_network,$this->table.id information_social_network_id,$this->table.state,$this->table.entity_id,$this->table.main,$this->table.entity_type,$this->table.information_social_network_type_id
       ,information_social_network_type.value social_network_name,information_social_network_type.icon social_network_icon ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_social_network_type', $this->table . '.information_social_network_type_id', 'information_social_network_type.id');
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;
        $information_social_network_type_id = isset($params['filters']['information_social_network_type_id']) ? $params['filters']['information_social_network_type_id'] : null;
        $main = isset($params['filters']['main']) ? $params['filters']['main'] : null;
        $state = isset($params['filters']['state']) ? $params['filters']['state'] : null;

        if ($entity_id) {
            $query->where($this->table . '.entity_id', '=', $entity_id);
        }

        if ($state) {
            $query->where($this->table . '.state', '=', $state);

        }
        if ($main) {
            $query->where($this->table . '.main', '=', $main);

        }
        if ($entity_type) {
            $query->where($this->table . '.entity_type', '=', $entity_type);

        }
        if ($information_social_network_type_id) {
            $query->where($this->table . '.information_social_network_type_id', '=', $information_social_network_type_id);

        }
        $result = $query->first();
        return $result;

    }

    public function getInformationData($params)
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.value information_social_network,$this->table.id information_social_network_id,$this->table.state,$this->table.entity_id,$this->table.main,$this->table.entity_type,$this->table.information_social_network_type_id
       ,information_social_network_type.value social_network_name,information_social_network_type.icon social_network_icon ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_social_network_type', $this->table . '.information_social_network_type_id', 'information_social_network_type.id');
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;
        $entity_type = isset($params['filters']['entity_type']) ? $params['filters']['entity_type'] : null;
        $information_social_network_type_id = isset($params['filters']['information_social_network_type_id']) ? $params['filters']['information_social_network_type_id'] : null;
        $main = isset($params['filters']['main']) ? $params['filters']['main'] : null;
        $state = isset($params['filters']['state']) ? $params['filters']['state'] : null;

        if ($entity_id) {
            $query->where($this->table . '.entity_id', '=', $entity_id);
        }

        if ($state) {
            $query->where($this->table . '.state', '=', $state);

        }
        if ($main) {
            $query->where($this->table . '.main', '=', $main);

        }
        if ($entity_type) {
            $query->where($this->table . '.entity_type', '=', $entity_type);

        }
        if ($information_social_network_type_id) {
            $query->where($this->table . '.information_social_network_type_id', '=', $information_social_network_type_id);

        }
        $result = $query->get()->toArray();
        return $result;

    }
}
