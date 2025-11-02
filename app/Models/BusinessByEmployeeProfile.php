<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User as User;


class BusinessByEmployeeProfile extends ModelManager
{

    protected $table = 'business_by_employee_profile';

    protected $fillable = array(
        "human_resources_employee_profile_id",//*
        "user_id",
        "business_id",//*
    );
    public $attributesData = array(
        "human_resources_employee_profile_id",//*
        "user_id",
        "business_id",//*
    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "human_resources_employee_profile_id" => 'required',
            "user_id" => 'required',
            "business_id" => 'required',

        ];
        return $rules;
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

            $modelU = new User;
            $createUpdate = true;
            $userAttributes = array(
                "status" => $attributesPost["BusinessByEmployeeProfile"]["status"],
                "name" => isset($attributesPost["BusinessByEmployeeProfile"]["name"]) ? $attributesPost["BusinessByEmployeeProfile"]["name"] : 'Sin Name',
                "email" => $attributesPost["BusinessByEmployeeProfile"]["email"],
                "username" => isset($attributesPost["BusinessByEmployeeProfile"]["username"]) ? $attributesPost["BusinessByEmployeeProfile"]["username"] : "",
                "password" => $attributesPost["BusinessByEmployeeProfile"]['password'],
                "provider_id" => isset($attributesPost["BusinessByEmployeeProfile"]["provider_id"]) ? $attributesPost["BusinessByEmployeeProfile"]["provider_id"] : "",
                "provider" => isset($attributesPost["BusinessByEmployeeProfile"]["provider"]) ? $attributesPost["BusinessByEmployeeProfile"]["provider"] : "",
                'roles_id_data' => $attributesPost["BusinessByEmployeeProfile"]["role_id_data"]
            );

            $attributesSet = array();
            $attributesSetAll = array();

            $resultUser = array();
            if (isset($attributesPost["BusinessByEmployeeProfile"]["id"]) && $attributesPost["BusinessByEmployeeProfile"]["id"] != "null" && $attributesPost["BusinessByEmployeeProfile"]["id"] != "-1") {
                $userAttributes['id'] = $attributesPost["BusinessByEmployeeProfile"]['user_id'];

                if (isset($attributesPost["BusinessByEmployeeProfile"]["password_old"]) && $attributesPost["BusinessByEmployeeProfile"]["password_old"] != 'null') {
                    $userAttributes['password_old'] = $attributesPost["BusinessByEmployeeProfile"]["password_old"];
                    $userAttributes['password_new'] = $attributesPost["BusinessByEmployeeProfile"]["password_new"];
                    $userAttributes['change_password'] = $attributesPost["BusinessByEmployeeProfile"]["change_password"];
                }

                $attributesSet = array('User' => $userAttributes);
                $resultUser = $modelU->saveData($attributesSet);
                $createUpdate = false;
            } else {
                $createUpdate = true;
                $attributesSet = array('User' => $userAttributes);
                $resultUser = $modelU->saveData($attributesSet);
            }
            $success = $resultUser['validateResult']['success'];
            if ($success) {

                $user_id = $resultUser['model']['user_id'];
                $attributesSetAll['User'] = $resultUser['model'];
                $postData = $attributesPost["BusinessByEmployeeProfile"];
                $attributesSet = array(
                    "human_resources_employee_profile_id" => $postData["human_resources_employee_profile_id"],
                    "user_id" => $user_id,
                    "business_id" => $postData["business_id"],
                );
                $model = new BusinessByEmployeeProfile();
                if (!$createUpdate) {//create
                    $model = BusinessByEmployeeProfile::find($attributesPost["BusinessByEmployeeProfile"]['id']);
                }
                $validateResult = self::validateModel($attributesSet);
                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);

                    $model->save();
                    $attributesSet['business_by_employee_profile_id'] = $model->id;
                    $attributesSetAll['BusinessByEmployeeProfile'] = $attributesSet;
                } else {
                    $success = false;
                    $msj = "Problemas al guardar Usuario a la Empresa .";
                    $errors = $validateResult["errors"];
                }


            } else {
                $success = false;
                $msj = "Problemas al guardar Usuario y Roles .";
                $errors = $resultUser['validateResult']["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                "models" => $attributesSetAll
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


    public function getUserBusiness($params)
    {


        $user_id = $params["user_id"];
        $query = DB::table($this->table);
        $selectString = "$this->table.id  ,$this->table.human_resources_employee_profile_id,$this->table.user_id,$this->table.business_id
        ,business.user_id owner_user_id,business.description,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.street_lat,business.business_subcategories_id,business.status,business.qualification
         ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
         ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', $this->table . '.business_id', '=', 'business.id');
        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->where($this->table . ".user_id", '=', $user_id);
        $data = $query->get()->first();
        return $data;
    }
    public function getUserEmployerInformation($params)
    {


        $user_id = $params["user_id"];
        $query = DB::table($this->table);
        $selectString = "$this->table.id  ,$this->table.human_resources_employee_profile_id,$this->table.user_id,$this->table.business_id
        ,business.user_id owner_user_id,business.description,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.street_lat,business.business_subcategories_id,business.status,business.qualification
         ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
 ,people.name people_name ,people.last_name people_last_name
 ,human_resources_employee_profile.identification_document, human_resources_employee_profile.identification_document

         ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('business', $this->table . '.business_id', '=', 'business.id');
        $query->join('human_resources_employee_profile', $this->table . '.human_resources_employee_profile_id', '=', 'human_resources_employee_profile.id');
        $query->join('people',  'human_resources_employee_profile.people_id', '=', 'people.id');

        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->leftJoin('zones', "business_location.zones_id", '=', 'zones.id');
            $query->leftJoin('cities', "zones.city_id", '=', 'cities.id');
            $query->leftJoin('provinces', "cities.province_id", '=', 'provinces.id');
            $query->leftJoin('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->where($this->table . ".user_id", '=', $user_id);
        $data = $query->get()->first();
        return $data;
    }
    public  function getDataUserEmployerInformation($params)
    {
        $result = null;
        $owner_id = $params['filters']['user_id'];
        $params_data_search = array("cruge_user_id" => $owner_id);
        $model_epgu = $this->findByAttributes($params_data_search);
        $result["nombres"] = "Administrador Total";
        $result["identificacion"] = "123456789";
        $result["id"] = $owner_id;
        if ($model_epgu) {
            $model_ep = $model_epgu->employerProfile;
            $model_p = $model_ep->persona;
            $result["nombres"] = $model_p->nombres . " " . $model_p->apellidos;
            $result["identificacion"] = $model_ep->identificacion;
        }


        return $result;
    }

    public function employerProfile()
    {
        return $this->hasOne(HumanResourcesEmployeeProfile::class,'human_resources_employee_profile_id','id');
    }
}
