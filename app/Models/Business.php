<?php

namespace App\Models;

use App\Utils\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\BusinessBySchedule;
use App\Models\Role;
use App\Models\UsersHasRoles;

use App\Models\BusinessByPanorama;
use App\Models\BusinessByLodgingByPrice;
use App\Models\BusinessByEmployeeProfile;

use App\Models\PeopleNationality;
use App\Models\PeopleProfession;

class Business extends ModelManager
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const BUSINESS_MAIN_ID = 1;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business';

    protected $fillable = array(
        "description",
        "title",//*
        "email",//*
        "page_url",
        "phone_value",//*
        "street_1",//*
        "street_2",
        "street_lat",//*
        "street_lng",//*
        "user_id",//*
        "options_map",

        "business_subcategories_id",//*
        "status",
        "qualification",
        "source",
        "business_id", "id",
        'has_document', 'has_about',
        'business_name',
        'keep_accounting',
        'type_ruc_id',
        'allow_cash_and_banks',
        'entity_plans_id',
        'entity_position_fiscal_id',
        'document',

    );
    public $attributesData = array(
        "description",
        "title",//*
        "email",//*
        "page_url",
        "phone_value",//*
        "street_1",//*
        "street_2",
        "street_lat",//*
        "street_lng",//*
        "user_id",//*
        "business_subcategories_id",//*
        "status",
        "qualification",
        "source",
        "options_map",
        'has_document', 'has_about',
        'business_name',
        'keep_accounting',
        'type_ruc_id',
        'allow_cash_and_banks',
        'entity_plans_id',
        'entity_position_fiscal_id',
        'document',
    );
    public $timestamps = false;


    public static function getRulesModel($params)
    {
        $rules = [
            "title" => "required|unique:business,title",
            "email" => "required",
            "phone_value" => "required",
            "street_1" => "required",
            "street_2" => "required",
            "street_lat" => "required",
            "street_lng" => "required",
            "user_id" => "required",
            "business_subcategories_id" => "required",
            "status" => "required",
            "qualification" => "required",
            "source" => "required",
            "has_document" => "required",
            "has_about" => "required",
            /*
                       "business_name" => "",
                        "keep_accounting" => "required",
                        "type_ruc_id" => "required",
                        "allow_cash_and_banks" => "required",
                        "entity_plans_id" => "required",
                        "entity_position_fiscal_id" => "required",
                        "document" => "required",

            */
        ];


        if (isset($params['id'])) {
            $rules['title'] = 'required|unique:business,title,' . $params['id'] . ',id';
        }
        return $rules;
    }

    public function amenities()
    {
        $parentKeyCurrent = 'business_id';
        $childrenKeyCurrent = 'business_amenities_id';
        $childrenClass = BusinessAmenities::class;
        $childrenTable = 'business_by_amenities';
        return $this->belongsToMany($childrenClass, $childrenTable, $parentKeyCurrent, $childrenKeyCurrent);
    }

    public
    function getActionsManager()
    {
        $model_entity = $this->getUpperCaseTable($this->table);
        $action_get_form = $model_entity . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $model_entity . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $model_entity . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity;
        $action_load = str_replace("'", "", $action_load);
        $model_entity = $this->getCamelCase();
        return [
            "action_get_form" => $action_get_form,
            "action_save_" . $model_entity => $action_save,
            "action_load_" . $model_entity . "s" => $action_load];
    }

    public
    function getUpperCaseTable($name_change)
    {
        $table = $name_change;
        $arrayNames = explode("_", $table);
        $model_entity = "";
        foreach ($arrayNames as $name) {
            // your code
            $model_entity .= ucfirst($name);
        }

        return $model_entity;
    }

    public
    function getCamelCase()
    {

        return lcfirst($this->getUpperCaseTable($this->table));
    }

    public
    function findAllByAttributes($attributes = array(), $values = array(), $columns = array('*'))
    {
        $response = DB::table($this->table)
            ->select($columns);
        if (!is_array($attributes) || !is_array($values)) {
            throw new Exception('$attributes and $values should be array.');
        }
        if (count($attributes) < 1 || count($values) < 1) {
            throw new Exception('$attributes and $values can not be empty.');
        }
        if (count($attributes) != count($values)) {
            throw new Exception('$attributes and $values must have the same length.');
        }
        foreach ($attributes as $key => $attribute) {
            $response->where($attribute, "=", $values[$key]);
        }
        return $response->get();
    }


    public
    function getBusinessByUser($params)
    {
        $select = "*";
        $user_id = $params["user_id"];
        $query = Business::query()->select($select);
        $query->where("user_id", '=', $user_id);

        $data = $query->get()->toArray();

        return $data;
    }

    public
    function getBusinessInformation($params)
    {
        $selectString = "business.id,business.options_map,business.description,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.user_id,business.business_subcategories_id,business.status,business.qualification,business.source
        ,countries.name countries
        ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id
        ,business_subcategories.name business_subcategories
        ,business_categories.name business_categories
        ,business.business_name,business.keep_accounting,business.type_ruc_id,business.allow_cash_and_banks,business.entity_plans_id,business.entity_position_fiscal_id,business.document
        ";
        $id = $params['filters']["business_id"];
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->where("business.id", '=', $id);

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
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $data = $query->first();

        return $data;
    }

    public
    function getBusinessByIdManager($params)
    {
        $selectString = "business.id,business.options_map,business.description,business.title,business.email,business.page_url,business.phone_value,business.street_1,business.street_2,business.street_lat,business.street_lng,business.user_id,business.business_subcategories_id,business.status,business.qualification,business.source
        ,countries.name countries
                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id
        ,business_subcategories.name business_subcategories
        ,business_categories.name business_categories";
        $id = $params["id"];
        $select = DB::raw($selectString);
        $query = DB::table($this->table);
        $query->select($select);
        $query->where("business.id", '=', $id);
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
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $user = Auth::user();
        $user_id = $user->id;
        $role = new Role();
        $hasRolesUser = new UsersHasRoles();
        $user = Auth::user();
        $roles = $hasRolesUser->getRolesUser($user->id);
        $managerOwner = false;
        $managerOwnerReceptionist = false;
        $allowManagerData = false;
        foreach ($roles as $role) {
            if ($role->role_id == Role::ROL_RECEPTIONIST) {
                $managerOwnerReceptionist = true;
            } else if ($role->role_id == Role::ROL_SUPERADMIN) {
                $managerOwner = true;
            } else if ($role->role_id == Role::ROL_BUSINESS) {
                $managerOwner = true;
                $allowManagerData = true;
            }
        }


        $allowWorker = false;
        $businessProfile = new BusinessByEmployeeProfile();
        $resultBusiness = $businessProfile->getUserBusiness(
            array(
                'user_id' => $user_id
            )
        );
        $owner_user_id = null;
        if ($resultBusiness) {

            if ($resultBusiness->business_id == $id) {
                $owner_user_id = $resultBusiness->owner_user_id;
            }
        }
        if ($owner_user_id) {
            $user_id = $owner_user_id;
        }

        $query->where("business.user_id", '=', $user_id);
        $data = $query->get()->toArray();

        return $data;
    }

    public
    function getManagerBusinessData($id)//BUSINESS-MANAGER-PROCESS-MENU
    {
        $modelBBS = new BusinessBySchedule;
        $modelPN = new PeopleNationality();
        $modelPP = new PeopleProfession();
        $user = Auth::user();
        $business = $this->getBusinessByIdManager(array("id" => $id));
        $schedules = array();
        $success = false;
        if (count($business) > 0) {
            $business_id = $business[0]->id;
            $schedules = $modelBBS->getStructureSchedulesBusiness(array("business_id" => $business_id));
            $success = true;
        }
        $peopleNationalityData = $modelPN->getDataListAll();
        $peopleProfessionData = $modelPP->getDataListAll();
        $dateCurrentData = array("format" => Util::DateCurrent('America/Guayaquil'), "not-format" => Util::DateCurrent('America/Guayaquil', "H:i:s d/m/Y"));
        $result = array(
            "business" => $business,
            "success" => $success,
            "schedules" => $schedules,
            "peopleNationalityData" => $peopleNationalityData,
            "peopleProfessionData" => $peopleProfessionData,
            "dateCurrentData" => $dateCurrentData,

        );

        return $result;
    }


    public
    function getAllBusiness($params = array())
    {
        $select = "*";

        $query = Business::query()->select($select);
        $query->where("status", '=', self::STATUS_ACTIVE);

        $data = $query->get()->toArray();

        return $data;
    }

    public
    function getBusinessById($params = array())
    {
        $select = "*";
        $id = $params["id"];
        $query = Business::query()->select($select);
        $query->where("status", '=', self::STATUS_ACTIVE);
        $query->where("id", '=', $id);

        $data = $query->get()->toArray();

        return $data;
    }

    public
    function getBusinessData($params = array())
    {
        $information = $this->getBusinessById($params);
        $modelBBS = new BusinessBySchedule;
        $modelBBP = new BusinessByPanorama;

        $business_id = $params["id"];
        $schedules = $modelBBS->getStructureSchedulesBusiness(array("business_id" => $business_id));
        $dataPanorama = $modelBBP->getDataPanoramaByBusiness(array("business_id" => $business_id));
        $result = array(
            "business" => $information,
            "dataSchedules" => $schedules,
            "dataPanorama" => $dataPanorama

        );

        return $result;
    }

    public
    function getBusinessAdmin($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $allowFilters = ($params["filters"]["categories"]["keys"] == "" && $params["filters"]["categories"]["all"] == "false" && $params["filters"]["subcategories"]["keys"] == "") ? false : true;

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id,$this->table.description,$this->table.options_map,$this->table.title,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.street_lat,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification
        ,countries.name countries_name,countries.place_id countries_place_id,countries.id countries_id
                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id

        ,business_subcategories.id business_subcategories_id,business_subcategories.name business_subcategories_name
         ,business_categories.id business_categories_id,business_categories.name business_categories_name";

        $select = DB::raw($selectString);
        $query->select($select);
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
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $allowCondition = false;
        $nameColumn = "";
        $dataIn = array();
        if ($allowFilters) {

            if ($params["filters"]["categories"]["keys"] != "") {//only categories
                $categoriesIn = explode(',', $params["filters"]["categories"]["keys"]);
                $dataIn = $categoriesIn;
                $allowCondition = true;
                $nameColumn = "business_categories.id";


            } else {//only subcategories

                if ($params["filters"]["subcategories"]["keys"] != "") {
                    $subCategoriesIn = explode(',', $params["filters"]["subcategories"]["keys"]);
                    $allowCondition = true;
                    $dataIn = $subCategoriesIn;
                    $nameColumn = "business_subcategories.id";

                }
            }

            if ($allowCondition) {
                $query->whereIn($nameColumn, $dataIn);
            }

        }
        $nameColumn = "business_categories.id";
        $query->whereIn($nameColumn, [1, 3]);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where("$this->table.description", 'like', $likeSet)
                ->orWhere("$this->table.title", 'like', $likeSet)
                ->orWhere("$this->table.email", 'like', $likeSet)
                ->orWhere("$this->table.page_url", 'like', $likeSet)
                ->orWhere("$this->table.phone_value", 'like', $likeSet)
                ->orWhere('countries.name', 'like', $likeSet)
                ->orWhere('business_subcategories.name', 'like', $likeSet);
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
        $result['paramsfilters'] = array(
            $nameColumn,
            $dataIn,
        );

        return $result;
    }

    public
    function getBusinessAdminData($params)
    {
        $result = $this->getBusinesssAdmin($params);

        return $result;

    }

    public function getDataManagerEmployer($params)
    {

        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        $user = Auth::user();
        $user_id = $user->id;
        if (isset($params['sort']) && count($params['sort']) > 0) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
 ,business_location.id business_location_id
 ,business_disbursement.id business_disbursement_id,business_disbursement.bank_id,business_disbursement.account_number,business_disbursement.type_account";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->leftJoin('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');

        $query->join('business_by_employee_profile', "business_by_employee_profile.business_id", '=', $this->table . ".id");
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

        $query->leftJoin('business_disbursement', function ($query)
        use (
            $user_id

        ) {
            $query->on('business_disbursement.business_id', '=', 'business.id');
        });
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";


            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.description', 'like', $likeSet);
                $query->orWhere($this->table . '.title', 'like', $likeSet);
                $query->orWhere($this->table . '.email', 'like', $likeSet);
                $query->orWhere($this->table . '.page_url', 'like', $likeSet);
                $query->orWhere($this->table . '.phone_value', 'like', $likeSet);

            });

        }
        $query->where("business_by_employee_profile.user_id", "=", $user_id);


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

    public function getDataManager($params)
    {

        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        $user = Auth::user();
        $user_id = $user->id;
        if (isset($params['sort']) && count($params['sort']) > 0) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
 ,business_location.id business_location_id
 ,business_disbursement.id business_disbursement_id,business_disbursement.bank_id,business_disbursement.account_number,business_disbursement.type_account";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->leftJoin('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->leftJoin('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
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

        $query->leftJoin('business_disbursement', function ($query)
        use (
            $user_id

        ) {
            $query->on('business_disbursement.business_id', '=', 'business.id');
        });
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";


            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.description', 'like', $likeSet);
                $query->orWhere($this->table . '.title', 'like', $likeSet);
                $query->orWhere($this->table . '.email', 'like', $likeSet);
                $query->orWhere($this->table . '.page_url', 'like', $likeSet);
                $query->orWhere($this->table . '.phone_value', 'like', $likeSet);

            });

        }
        $query->where($this->table . ".user_id", "=", $user_id);
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

    public function getAdminEmployer($params)
    {
        $result = $this->getDataManagerEmployer($params);
        $modelAmenities = new BusinessAmenities();

        foreach ($result['rows'] as $key => $row) {

            $business_id = $row->id;
            $setPush = (array)$row;
            $result['rows'][$key] = $setPush;

            $amenities = $modelAmenities->getAmenitiesBusiness([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            $result['rows'][$key]['amenities'] = $amenities;


        }
        return $result;
    }

    public function getAdmin($params)
    {
        $result = $this->getDataManager($params);
        $modelAmenities = new BusinessAmenities();

        foreach ($result['rows'] as $key => $row) {

            $business_id = $row->id;
            $setPush = (array)$row;
            $result['rows'][$key] = $setPush;

            $amenities = $modelAmenities->getAmenitiesBusiness([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            $result['rows'][$key]['amenities'] = $amenities;


        }
        return $result;
    }

    public
    function saveData()
    {

    }

    public
    function getAllBusinessFrontend($params = array())
    {
        $selectString = "$this->table.id ,$this->table.description ,$this->table.title alt,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
 ";
        $select = DB::raw($selectString);
        $query = Business::query()->select($select);
        $query->join('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
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
        $query->where("$this->table.status", '=', self::STATUS_ACTIVE);

        $data = $query->get()->toArray();

        return $data;
    }

    public
    function saveDataFrontend($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = array();
        DB::beginTransaction();
        try {
            $modelName = 'Business';
            $model = new Business();
            $createUpdate = true;
            $paramsModelBusiness = [

            ];
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = Business::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
                $paramsModelBusiness = [
                    'id' => $attributesPost[$modelName]['id']
                ];
            }
            $informationSocialNetworkData = $attributesPost[$modelName];
            $attributesSet['description'] = isset($attributesPost[$modelName]['description']) ? $attributesPost[$modelName]['description'] : $model->description;
            $attributesSet['title'] = isset($attributesPost[$modelName]['title']) ? $attributesPost[$modelName]['title'] : $model->title;
            $attributesSet['page_url'] = isset($attributesPost[$modelName]['page_url']) ? $attributesPost[$modelName]['page_url'] : $model->page_url;
            $attributesSet['phone_value'] = isset($attributesPost[$modelName]['phone_value']) ? $attributesPost[$modelName]['phone_value'] : $model->phone_value;
            $attributesSet['email'] = isset($attributesPost[$modelName]['email']) ? $attributesPost[$modelName]['email'] : $model->email;
            $attributesSet['street_1'] = isset($attributesPost[$modelName]['street_1']) ? $attributesPost[$modelName]['street_1'] : $model->street_1;
            $attributesSet['street_2'] = isset($attributesPost[$modelName]['street_2']) ? $attributesPost[$modelName]['street_2'] : $model->street_2;
            $attributesSet['street_lng'] = isset($attributesPost[$modelName]['street_lng']) ? $attributesPost[$modelName]['street_lng'] : $model->street_lng;
            $attributesSet['street_lat'] = isset($attributesPost[$modelName]['street_lat']) ? $attributesPost[$modelName]['street_lat'] : $model->street_lat;
            $attributesSet['status'] = isset($attributesPost[$modelName]['status']) ? $attributesPost[$modelName]['status'] : $model->status;
            $attributesSet['countries_id'] = isset($attributesPost[$modelName]['countries_id']) ? $attributesPost[$modelName]['countries_id'] : $model->countries_id;
            $attributesSet['qualification'] = isset($attributesPost[$modelName]['qualification']) ? $attributesPost[$modelName]['qualification'] : $model->qualification;
            $attributesSet['options_map'] = isset($attributesPost[$modelName]['options_map']) ? $attributesPost[$modelName]['options_map'] : $model->options_map;
            $attributesSet['status'] = isset($attributesPost[$modelName]['status']) ? $attributesPost[$modelName]['status'] : $model->status;
            $attributesSet['source'] = isset($attributesPost[$modelName]['source']) ? $attributesPost[$modelName]['source'] : ($model->source == '' ? 'not-source' : $model->source);
            $attributesSet['user_id'] = isset($attributesPost[$modelName]['user_id']) ? $attributesPost[$modelName]['user_id'] : $model->user_id;
            $attributesSet['business_subcategories_id'] = isset($attributesPost[$modelName]['business_subcategories_id']) ? $attributesPost[$modelName]['business_subcategories_id'] : $model->business_subcategories_id;
            $attributesSet['has_document'] = isset($attributesPost[$modelName]['has_document']) ? $attributesPost[$modelName]['has_document'] : $model->has_document;
            $attributesSet['has_about'] = isset($attributesPost[$modelName]['has_about']) ? $attributesPost[$modelName]['has_about'] : $model->has_about;

            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(
                    $paramsModelBusiness
                ),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {

                $model->fill($attributesSet);
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  Business.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $modelTCU = new TemplateContactUs();
                $business_id = $informationSocialNetworkData['id'];
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

    public
    function getBusinessFrontend($params = array())
    {
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id ,$this->table.options_map,$this->table.description ,$this->table.title alt,$this->table.title,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id,countries.phone_code
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id

 ";
        $select = DB::raw($selectString);
        $query = Business::query()->select($select);
        $query->join('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');

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
        $query->where("$this->table.status", '=', self::STATUS_ACTIVE);
        $query->where("$this->table.id", '=', $business_id);
        $data = $query->first();

        return $data;
    }

    public function getData($params)
    {
        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        $user = Auth::user();

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }
        if ($user) {
            $user_id = $user->id;
        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $managerQuery = $this->getManagerConfigBee(
            [
                'query' => $query,
                'params' => $params
            ]
        );
        $query = $managerQuery['query'];
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.title', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.email', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.phone_value', 'like', '%' . $likeSet . '%');
            });

        }
        $query->where($this->table . '.status', '=', Patient::STATUS_ACTIVE);
        $category_id = isset($params['filters']['category_id']) ? (($params['filters']['category_id'] != '' && $params['filters']['category_id']) ? $params['filters']['category_id'] : null) : null;
        if ($category_id) {
            $query->where("business_categories.id", "=", $category_id);
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

    public function getPopularListBee($params)
    {
        $result = $this->getData($params);
        return $result;
    }

    public function getAdminBee($params)
    {
        $result = $this->getData($params);
        return $result;
    }

    public function getDetailsBee($params)
    {
        $sort = 'asc';
        $field = $this->table . '.title';
        $query = DB::table($this->table);
        $user = Auth::user();
        $businessId = $params['filters']['business_id'];

        if ($user) {
            $user_id = $user->id;
        }
        $managerQuery = $this->getManagerConfigBee(
            [
                'query' => $query,
                'params' => $params
            ]
        );
        $query = $managerQuery['query'];
        $query->where($this->table . '.id', "=", $businessId);
        $query->orWhere($this->table . '.title', "=", $businessId);
        $query->orderBy($field, $sort);
        $data = $query->get()->first();
        $result = $data;
        return $result;
    }

    public function getManagerConfigBee($params)
    {

        $query = $params['query'];
        $getSelectBeeString = "$this->table.id ,$this->table.has_document,$this->table.has_about,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.phone_code countries_phone_code,countries.place_id countries_place_id,countries.iso_codes countries_iso_codes
 ,users.name user_name,users.username,users.email user_email,users.avatar,users.provider ,users.provider_id
,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id

 ";

        $select = DB::raw($getSelectBeeString);
        $query->select($select);
        $query->join('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->leftJoin('business_location', function ($query)
        use (
            $getSelectBeeString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->join('users', $this->table . ".user_id", '=', 'users.id');

        $query = $params['query'];
        return $result = [
            'getSelectBeeString' => $getSelectBeeString,
            'query' => $query
        ];
    }

    public function getCountBusinessByCategory($params)
    {

        $business_categories_id = $params['filters']['business_categories_id'];
        $query = DB::table($this->table);
        $selectString = "business_subcategories.id";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.status', '=', 'ACTIVE');
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->where('business_categories.id', '=', $business_categories_id);
        $result = $query->get()->count();
        return $result;

    }

    public
    function getManagementBusinessEvents($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $events_trails_project_id = $params['filters']['events_trails_project_id'];


        $selectString = "$this->table.id,$this->table.description,$this->table.options_map,$this->table.title,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.street_lat,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification
        ,countries.name countries_name,countries.place_id countries_place_id,countries.id countries_id
                ,zones.name zone,zones.id zone_id
        ,cities.name city,cities.id city_id
 ,provinces.name province,provinces.id province_id

        ,business_subcategories.id business_subcategories_id,business_subcategories.name business_subcategories_name
         ,business_categories.id business_categories_id,business_categories.name business_categories_name ,$this->table.title text";

        $select = DB::raw($selectString);
        $query->select($select);

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
        $query->join('business_subcategories', "$this->table.business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');


        $query->whereNotIn("$this->table.id", [$business_id]);
        if (isset($params['filters']['search_value']['term'])) {

            $searchValue = $params['filters']['search_value']['term'];
            $likeSet = $searchValue;

            $query->where(function ($query) use (
                $likeSet
            ) {

                $query
                    ->where("business.title", 'like', '%' . $likeSet . '%')
                    ->orWhere("business.email", 'like', '%' . $likeSet . '%')
                    ->orWhere("business.phone_value", 'like', '%' . $likeSet . '%')
                    ->orWhere('countries.name', 'like', '%' . $likeSet . '%')
                    ->orWhere('business_subcategories.name', 'like', '%' . $likeSet . '%');
            });
        }
        $query->orderBy($field, $sort);

        $result = $query->get()->toArray();


        return $result;
    }

    public function getEntityManager($params)
    {
        $businessId = $params["businessId"];
        $query = DB::table($this->table);
        $getSelectBeeString = "$this->table.id ,$this->table.has_document,$this->table.has_about,$this->table.options_map,$this->table.description ,$this->table.title ,$this->table.email,$this->table.page_url,$this->table.phone_value,$this->table.street_1,$this->table.street_2,$this->table.street_lat,$this->table.street_lng,$this->table.user_id,$this->table.business_subcategories_id,$this->table.status,$this->table.qualification,$this->table.source
 ,$this->table.document  documento,$this->table.title  razon_comercial,$this->table.entity_position_fiscal_id  entidad_posicion_fiscal_id,$this->table.business_name razon_social,$this->table.keep_accounting,$this->table.type_ruc_id,$this->table.allow_cash_and_banks,$this->table.entity_plans_id
        ,ep.name plane_name

 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.phone_code countries_phone_code,countries.place_id countries_place_id,countries.iso_codes countries_iso_codes
 ,users.name user_name,users.username,users.email user_email,users.avatar,users.provider ,users.provider_id
,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
,$this->table.description descripcion
 ";

        $select = DB::raw($getSelectBeeString);
        $query->select($select);
        $query->join('business_subcategories', $this->table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->join('users', $this->table . ".user_id", '=', 'users.id');
        $query->join('entity_plans', $this->table . ".entity_plans_id", '=', 'entity_plans.id');

        $query->leftJoin('business_location', function ($query)
        use (
            $getSelectBeeString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        $query->join('entity_plans as ep', $this->table . ".entity_plans_id", '=', 'entity_plans.id');

        $query->where('business.id', '=', $businessId);

        $result = $query->first();


        return $result;
    }
}
