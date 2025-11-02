<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Business;
use App\Models\InformationSocialNetwork;

use App\Models\InformationSocialNetworkType;
use App\Models\TemplateChatApi;

class TemplateContactUs extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'template_contact_us';

    protected $fillable = array(
        'source',//*
        'template_information_id',//*
        'allow_routes'//*

    );
    protected $attributesData = [
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'template_information_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'allow_routes', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'source';

    public static function getRulesModel()
    {
        $rules = ["source" => "required|max:350",
            "template_information_id" => "required|numeric",
            "allow_routes" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.source,template_information.value as template_information,
template_information.id as template_information_id,
$this->table.allow_routes";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow_routes', 'like', '%' . $likeSet . '%');;

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
            $modelName = 'TemplateContactUs';
            $model = new TemplateContactUs();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = TemplateContactUs::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $templateContactUsData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $templateContactUsData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  TemplateContactUs.";
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
        $query->join('template_information', 'template_information.id', '=', $this->table . '.template_information_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere("template_information.value", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.allow_routes', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getSocialNetworkData($params)
    {
        $resultData = $this->getSocialNetwork($params);
        $result = [];
        foreach ($resultData as $index => $social) {
            if ($social) {
                $result[] = $social;
            }

        }

        return $result;

    }

    public function getSocialNetwork($params)
    {
        $modelISN = new InformationSocialNetwork();
        $entity_id = $params['filters']['business_id'];
        $entity_type = InformationSocialNetwork::ENTITY_TYPE_BUSINESS;
        $facebook = $modelISN->getSocialNetworkInformation([
            'filters' => [
                'information_social_network_type_id' => InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type
            ]
        ]);
        $instagram = $modelISN->getSocialNetworkInformation([
            'filters' => ['information_social_network_type_id' => InformationSocialNetworkType::TYPE_INSTAGRAM_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type,
            ]
        ]);
        $twitter = $modelISN->getSocialNetworkInformation([
            'filters' => ['information_social_network_type_id' => InformationSocialNetworkType::TYPE_TWITTER_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type,
            ]
        ]);
        $youtube = $modelISN->getSocialNetworkInformation([
            'filters' => ['information_social_network_type_id' => InformationSocialNetworkType::TYPE_YOUTUBE_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type,
            ]
        ]);
        $whatsapp = $modelISN->getSocialNetworkInformation([
            'filters' => ['information_social_network_type_id' => InformationSocialNetworkType::TYPE_WHATSAPP_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type,
            ]
        ]);
        $information_social_network = [];
        $information_social_network['facebook'] = $facebook;
        $information_social_network['instagram'] = $instagram;
        $information_social_network['twitter'] = $twitter;
        $information_social_network['youtube'] = $youtube;
        $information_social_network['whatsapp'] = $whatsapp;

        return $information_social_network;
    }

    public function getContactUsData($params)
    {
        $template_contact_us = $this->getContactUs($params);
        $modelB = new Business();
        $business = $modelB->getBusinessInformation($params);


        $modelTCA = new TemplateChatApi();
        $chatConfig = $modelTCA->getChatsTypesData($params);

        $success = true;
        $result = array(
            'success' => $success,
            'business' => $business,
            'template_contact_us' => $template_contact_us,
            'information_social_network' => $this->getSocialNetwork($params),
            'chat' => $chatConfig,

        );

        return $result;
    }

    public function getContactUs($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue,$this->table.allow_routes";
        $select = DB::raw($selectString);
        $query->select($select);

        $template_information_id = $params['filters']['template_information_id'];
        $query->where($this->table . '.template_information_id', '=', $template_information_id);
        $query->orderBy($field, 'asc');
        $result = $query->first();
        return $result;

    }

    public function getContactUsFrontend($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue,$this->table.allow_routes";
        $select = DB::raw($selectString);
        $query->select($select);

        $template_information_id = $params['filters']['template_information_id'];
        $query->where($this->table . '.template_information_id', '=', $template_information_id);
        $query->orderBy($field, 'asc');
        $result = $query->first();
        return $result;

    }
}
