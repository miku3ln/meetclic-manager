<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\InformationAddress as InformationAddress;

class EventsTrailsRegistrationPoints extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'events_trails_registration_points';

    protected $fillable = array(

        'business_id',
        'status',//*
        'events_trails_project_id'//*

    );
    protected $attributesData = [

        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'events_trails_project_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']


    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["business_id" => "required|numeric",
            "status" => "required",
            "events_trails_project_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function deletePointSale($params)
    {


        $id = $params['filters']['id'];
        $success = false;
        $msg = '';
        $model = EventsTrailsRegistrationPoints::find($id);
        if ($model) {
            $events_trails_registration_points_id = $id;
            $modelE = new \App\Models\EventsTrailsRegistrationPaymentsByBusiness();
            $dataResult = $modelE->getSumCurrentPointEvent([
                'filters' => [
                    'events_trails_registration_points_id' => $events_trails_registration_points_id
                ]
            ]);
            if (count($dataResult) > 0) {
                $success = false;
                $msg = 'No se puede eliminar punto de venta realizando ventas.';
            } else {
                $success = true;
                $msg = 'Punto de venta eliminado.';
                $model->delete();
            }
        } else {
            $success = false;
            $msg = 'No existe este punto de venta.';
        }
        $result = [
            'success' => $success,
            'message' => $msg,

        ];
        return $result;

    }

    public function getAdminData($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $events_trails_project_id = $params['filters']['events_trails_project_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.business_id,$this->table.status,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id
,business.id business_id,business.description,business.options_map,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.street_lat,business.business_subcategories_id,business.qualification
        ,countries.name countries_name,countries.place_id countries_place_id,countries.id countries_id
                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id

        ,business_subcategories.id business_subcategories_id,business_subcategories.name business_subcategories_name
         ,business_categories.id business_categories_id,business_categories.name business_categories_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');

        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
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
        $query->join('business_subcategories', "business.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->where('business.value', 'like', '%' . $likeSet . '%');
                $query->where('business.email', 'like', '%' . $likeSet . '%');

            });;
        }
        $query->where($this->table . '.events_trails_project_id', '=', $events_trails_project_id);

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

    public function getAdmin($params)
    {
        $result = $this->getAdminData($params);

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
            $modelName = 'EventsTrailsRegistrationPoints';
            $model = new EventsTrailsRegistrationPoints();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = EventsTrailsRegistrationPoints::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $eventsTrailsRegistrationPointsData = $attributesPost[$modelName];
            $postData = $eventsTrailsRegistrationPointsData;

            $attributesSet = $postData;
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
                $msj = "Problemas al guardar  EventsTrailsRegistrationPoints.";
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
        $events_trails_project_id = $params['filters']['events_trails_project_id'];

        $query->select($select);
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];

            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');


        }
        $query->where($this->table . '.events_trails_project_id', '=', $events_trails_project_id);

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getCountDataPoints($params = [])
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        $selectString = "$this->table.id,$this->table.business_id,$this->table.status,events_trails_project.value as events_trails_project,
events_trails_project.id as events_trails_project_id
,business.id business_id,business.description,business.options_map,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.street_lat,business.business_subcategories_id,business.qualification
        ,countries.name countries_name,countries.place_id countries_place_id,countries.id countries_id
                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id

        ,business_subcategories.id business_subcategories_id,business_subcategories.name business_subcategories_name
         ,business_categories.id business_categories_id,business_categories.name business_categories_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
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
        $query->join('business_subcategories', "business.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');

        $user_id = $params['filters']['user_id'];

        $query->where('business.user_id', '=', $user_id);

        $recordsTotal = $query->get()->count();

        $result = $recordsTotal;
        return $result;
    }

    public function adminBusiness($params)
    {


        $result = $this->adminDataBusiness($params);
        $business_id = 1;

        $modelTeams = new \App\Models\EventsTrailsTypeTeams();
        $modelCategories = new \App\Models\EventsTrailsTypeOfCategories();
        $modelDistances = new \App\Models\EventsTrailsDistances();
        $modelKits = new \App\Models\EventsTrailsByKit();
        foreach ($result['rows'] as $key => $row) {
            $events_trails_project_id = $row->id;
            $paramsData = [
                'filters' => [
                    'events_trails_project_id' => $events_trails_project_id,
                    'business_id' => $business_id
                ]
            ];
            $teams = $modelTeams->getTeamsByEvents($paramsData);
            $categories = $modelCategories->getCategoriesByEvent($paramsData);
            $distances = $modelDistances->getDistancesByEvent($paramsData);
            $kits = $modelKits->getKitsByEvent($paramsData);
            $dataRow = (array)$row;
            $result['rows'][$key] = $dataRow;
            $result['rows'][$key]['teams'] = $teams;
            $result['rows'][$key]['categories'] = $categories;
            $result['rows'][$key]['distances'] = $distances;
            $result['rows'][$key]['kits'] = $kits;


        }


        return $result;
    }

    public function adminDataBusiness($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $user = Auth::user();
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id events_trails_registration_points_id
       ,events_trails_project.id,events_trails_project.source,events_trails_project.value,events_trails_project.value name,events_trails_project.description,events_trails_project.status,events_trails_project.date_init_project,events_trails_project.date_end_project,bow.title as business
,DATE_FORMAT(events_trails_project.date_init_project,'%d/%m/%Y') date_init_project,DATE_FORMAT(events_trails_project.date_end_project,'%d/%m/%Y') date_end_project
,events_trails_types.value as events_trails_types
,events_trails_types.id as events_trails_types_id
,business.id business_id,business.description business_description,business.options_map,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.street_lat,business.business_subcategories_id,business.qualification
        ,countries.name countries_name,countries.place_id countries_place_id,countries.id countries_id
                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id
        ,business_subcategories.id business_subcategories_id,business_subcategories.name business_subcategories_name
         ,business_categories.id business_categories_id,business_categories.name business_categories_name
         ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');

        $query->join('events_trails_project', 'events_trails_project.id', '=', $this->table . '.events_trails_project_id');
        $query->join('business as bow', 'bow.id', '=', 'events_trails_project.business_id');
        $query->join('events_trails_types', 'events_trails_types.id', '=', 'events_trails_project.events_trails_types_id');

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
        $query->join('business_subcategories', "business.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->where('events_trails_project.value', 'like', '%' . $likeSet . '%');
                $query->orWhere('events_trails_project.date_end_project', 'like', '%' . $likeSet . '%');

                $query->orWhere('events_trails_project.description', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_types.value", 'like', '%' . $likeSet . '%');

            });;
        }
        $user_id = $user->id;
        $query->where('business.user_id', '=', $user_id);

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
}
