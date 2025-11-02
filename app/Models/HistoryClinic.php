<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class HistoryClinic extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'history_clinic';

    protected $fillable = array(
        'status',//*
        'created_at',
        'updated_at',
        'deleted_at',
        'customer_id',//*
        'business_id'//*

    );
    protected $attributesData = [
        ['column' => 'status', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = true;

    protected $field_main = 'status';

    public static function getRulesModel()
    {
        $rules = ["status" => "required",
            "customer_id" => "required|numeric",
            "business_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'people.last_name';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;

        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $selectString = "$this->table.id,$this->table.status,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.customer_id,$this->table.business_id
             ,  customer_by_profile.id customer_by_profile_id,customer_by_profile.user_id
              ,users.email
                ,people.last_name last_name,people.name first_name,DATE_FORMAT(people.birthdate,'%Y-%m-%d') birthdate,people.gender,people.id people_id
                ,customer.representative_fullname,customer.has_representative,customer.identification_document identification ,customer.id customer_id,customer.business_name,customer.business_reason,customer.ruc_type_id
               ,customer_by_information.id customer_by_information_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
                ,ruc_type.name ruc_type
                ,people_type_identification.name people_type_identification,people_type_identification.id people_type_identification_id
                ,people_nationality.name people_nationality,people_nationality.id people_nationality_id
                 ,people_profession.name people_profession
,customer_profile_by_location.zones_id,customer_profile_by_location.id customer_profile_by_location_id
,zones.name zones
,cities.name cities,cities.id cities_id
,provinces.name provinces,provinces.id provinces_id
,countries.name countries,countries.id countries_id
,information_phone.id information_phone_id,information_phone.value information_phone_value,information_phone.information_phone_operator_id,information_phone.information_phone_type_id
,information_address.id information_address_id,information_address.street_one,information_address.street_two,information_address.reference,information_address.street_one,information_address_type_id,has_location,options_map,options_map,country_code_id,administrative_area_level_2,administrative_area_level_3,administrative_area_level_1
,information_address_type.value information_address_type";

        $select = DB::raw($selectString);
        $query->select($select);

        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->join('customer_by_profile', 'customer.id', '=', 'customer_by_profile.customer_id');
        $entity_type = \App\Models\InformationPhone::ENTITY_TYPE_CUSTOMER;


        $query->leftJoin('information_phone', function ($query)
        use (
            $entity_type

        ) {
            $query->on('information_phone.entity_id', '=', 'customer.id')
                ->where('information_phone.main', '=', 1)
                ->where('information_phone.entity_type', '=', $entity_type)
                ->where('information_phone.state', '=', 'ACTIVE');

        });
        $query->leftJoin('information_address', function ($query)
        use (
            $entity_type

        ) {
            $query->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address_type.id', '=', 'information_address.information_address_type_id')
                ->where('information_address.main', '=', 1)
                ->where('information_address.entity_type', '=', $entity_type)
                ->where('information_address.state', '=', 'ACTIVE');

        });
        $query->leftJoin('users', 'users.id', '=', 'customer_by_profile.user_id');
        $query->join('customer_by_information', 'customer_by_information.id', '=', 'customer.id');
        $query->join('people_nationality', 'people_nationality.id', '=', 'customer_by_information.people_nationality_id');
        $query->join('people_profession', 'people_profession.id', '=', 'customer_by_information.people_profession_id');
        $query->join('ruc_type', 'ruc_type.id', '=', 'customer.ruc_type_id');
        $query->join('people_type_identification', 'people_type_identification.id', '=', 'customer.people_type_identification_id');
        $query->join('people', 'people.id', '=', 'customer.people_id');
        $query->leftJoin('customer_profile_by_location', 'customer_by_profile.id', '=', 'customer_profile_by_location.customer_by_profile_id');
        $query->leftJoin('zones', 'zones.id', '=', 'customer_profile_by_location.zones_id');
        $query->leftJoin('cities', 'cities.id', '=', 'zones.city_id');
        $query->leftJoin('provinces', 'provinces.id', '=', 'cities.province_id');
        $query->leftJoin('countries', 'countries.id', '=', 'provinces.country_id');
        $query->where($this->table . '.business_id', '=', $business_id);


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->where($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere('people.last_name', 'like', '%' . $likeSet . '%');
                $query->orWhere('people.name', 'like', '%' . $likeSet . '%');
                $query->orWhere('customer.identification_document', 'like', '%' . $likeSet . '%');


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
            $modelName = 'HistoryClinic';
            $model = new HistoryClinic();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = HistoryClinic::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $historyClinicData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $historyClinicData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  HistoryClinic.";
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
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.customer_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.business_id', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDataHistoryClinicLog($params)
    {
        $modelAntecedentOne = new \App\Models\AntecedentByHistoryClinic();
        $modelTreatments = new \App\Models\TreatmentByPatient();
        $modelByTreatments = new \App\Models\TreatmentByDetails();

        $history_clinic_id = $params['filters']['history_clinic_id'];
        $paramsCurrent = [
            'history_clinic_id' => $history_clinic_id
        ];
        $antecedentsOne = $modelAntecedentOne->getLogHistoryClinic($paramsCurrent);
        $antecedents = [
            'one' => $antecedentsOne
        ];

        $treatmentsResult = $modelTreatments->getLogHistoryClinic($paramsCurrent);
        $treatments = [];
        foreach ($treatmentsResult as $key => $modelItemRow) {
            $treatment_by_patient_id = $modelItemRow->id;
            $dataRow = (array)$modelItemRow;
            $setPush = $dataRow;
            $dataCurrent = $modelByTreatments->getDataDetails([
                'treatment_by_patient_id' => $treatment_by_patient_id
            ]);
            $setPush['data'] = $dataCurrent;
            $treatments[] = $setPush;
        }
        $result = [
            'antecedents' => $antecedents,
            'treatments' => $treatments,

        ];
        return $result;

    }
}
