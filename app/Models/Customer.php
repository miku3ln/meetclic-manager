<?php

namespace App\Models;

use App\Models\InformationPhoneOperator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\People as People;
use App\Models\CustomerByInformation as CustomerByInformation;
use App\Models\InformationPhone as InformationPhone;
use App\Models\InformationPhoneType;

use App\Utils\Util;

use App\Models\InformationAddress as InformationAddress;

use App\Rules\DocumentIdentification;
use App\Models\Multimedia;

class Customer extends Model
{

    protected $table = 'customer';
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    protected $fillable = array(
        "identification_document",//*
        "src",
        "people_type_identification_id",//*
        "people_id",//*
        "business_name",
        "business_reason",
        "has_representative",
        "representative_fullname",

        "ruc_type_id"//*
    );
    public $attributesData = array(
        "identification_document",//*
        "src",
        "people_type_identification_id",//*
        "people_id",//*
        "business_name",
        "business_reason",
        "ruc_type_id",//*
        "has_representative",
        "representative_fullname",
    );
    public $timestamps = false;
    const MESSAGES_ERROR = [
        'people_type_identification_id.required' => 'Tipo de Identificacion es Requerido.',
        'people_id.required' => 'Persona es Requerido.',
        'ruc_type_id.required' => 'Tipo de Documento es Requerido.',
        'identification_document.unique' => ' Identificacion no debe ser Repetido!.',

    ];

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
    public static function getRulesModel($params)
    {
        $id = null;
        if (isset($params['customer_id']) && $params['customer_id'] != null) {
            $id = $params['customer_id'];
        }


        $rules = [
            "people_type_identification_id" => 'required',
            "people_id" => 'required',
            "ruc_type_id" => 'required',
        ];
        if ($id == null) {
            $rules['identification_document'] = ['required', 'unique:customer', new DocumentIdentification($params)];
        } else {

            $ruleCurrent = 'unique:customer,identification_document,' . $id . ',id';
            $rules['identification_document'] = ['required', $ruleCurrent, new DocumentIdentification($params)];
        }


        return $rules;
    }


    public static function validateModel($modelAttributes)
    {
        $rules = self::getRulesModel($modelAttributes);
        $id = null;
        if (isset($modelAttributes['customer_id']) && $modelAttributes['customer_id'] != null) {
            $id = $modelAttributes['customer_id'];
        }

        if ($id) {

            $modelAttributes['id'] = $id;
        }

        $validation = Validator::make($modelAttributes, $rules, Customer::MESSAGES_ERROR);

        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }

        $result = array("success" => $success, "errors" => $errors);

        return $result;
    }


    public function getAdminEmails($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,information_mail.value information_mail_value";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });
        $paramsFunction = ['entity_type' => 0, 'main' => 1, 'state' => 'ACTIVE', 'information_mail_type_id' => 2];
        $query->join('information_mail', function ($join) use ($paramsFunction) {

            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->join('information_mail_type', 'information_mail.information_mail_type_id', '=', 'information_mail_type.id')
                ->where('information_mail.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_mail.main', '=', $paramsFunction['main'])
                ->where('information_mail.information_mail_type_id', '=', $paramsFunction['information_mail_type_id'])
                ->where('information_mail.state', '=', $paramsFunction['state'])//house
            ;
        });
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";

            $query->orWhere($this->table . '.identification_document', 'like', $likeSet);
            $query->orWhere('people.name', 'like', $likeSet);
            $query->orWhere('people.last_name', 'like', $likeSet);
            $query->orWhere($this->table . '.business_name', 'like', $likeSet);
            $query->orWhere($this->table . '.business_reason', 'like', $likeSet);

        }


        if ($business_id) {

            //  $query->where($this->table . '.business_id', '=', $business_id);
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

    public function getAdminNotAssistanceEvent($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,information_mail.value information_mail_value,information_mail.id information_mail_id
  ,information_phone.value information_phone_value,information_phone.id information_phone_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });
        $entity_type = 0;
        $paramsFunction = ['entity_type' => $entity_type, 'main' => 1, 'state' => 'ACTIVE', 'information_mail_type_id' => 2];//personal
        $query->leftJoin('information_mail', function ($join) use ($paramsFunction) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->join('information_mail_type', 'information_mail.information_mail_type_id', '=', 'information_mail_type.id')
                ->where('information_mail.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_mail.main', '=', $paramsFunction['main'])
                ->where('information_mail.information_mail_type_id', '=', $paramsFunction['information_mail_type_id'])
                ->where('information_mail.state', '=', $paramsFunction['state'])//house
            ;
        });
        $entity_type = 0;
        $paramsFunction = ['entity_type' => $entity_type, 'main' => 1, 'state' => 'ACTIVE', 'information_phone_operator_id' => 1, 'information_phone_type_id' => 4];//personal
        $query->join('information_phone', function ($join) use ($paramsFunction) {
            $join->on('information_phone.entity_id', '=', 'customer.id')
                ->join('information_phone_operator', 'information_phone.information_phone_operator_id', '=', 'information_phone_operator.id')
                ->join('information_phone_type', 'information_phone.information_phone_type_id', '=', 'information_phone_type.id')
                ->where('information_phone.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_phone.main', '=', $paramsFunction['main'])
                ->where('information_phone.state', '=', $paramsFunction['state'])
                ->where('information_phone.information_phone_operator_id', '=', $paramsFunction['information_phone_operator_id'])
                ->where('information_phone.information_phone_type_id', '=', $paramsFunction['information_phone_type_id']);
        });

        $paramsCurrent = ['business_id' => 1];
        $query->whereNotIn($this->table . '.id', function ($q) use ($paramsCurrent) {
            $business_id = $paramsCurrent["business_id"];
            $q->select('customer_id')->from('event_by_assistance')
                ->where('event_by_assistance.customer_id', '=', $business_id);
        });

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";


            $query->where(function ($query) use ($likeSet
            ) {


                $query->orWhere($this->table . '.identification_document', 'like', $likeSet);
                $query->orWhere('people.name', 'like', $likeSet);
                $query->orWhere('information_phone.value', 'like', $likeSet);
                $query->orWhere('information_mail.value', 'like', $likeSet);

                $query->orWhere('people.last_name', 'like', $likeSet);

                $query->orWhere($this->table . '.business_name', 'like', $likeSet);
                $query->orWhere($this->table . '.business_reason', 'like', $likeSet);
            });;
        }


        if ($business_id) {

            //  $query->where($this->table . '.business_id', '=', $business_id);
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

    public function getAdminEmailsRegisters($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,information_mail.value information_mail_value,information_mail.id information_mail_id
  ,information_phone.value information_phone_value,information_phone.id information_phone_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });
        $entity_type = 0;
        $paramsFunction = ['entity_type' => $entity_type, 'main' => 1, 'state' => 'ACTIVE', 'information_mail_type_id' => 2];//personal
        $query->leftJoin('information_mail', function ($join) use ($paramsFunction) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->join('information_mail_type', 'information_mail.information_mail_type_id', '=', 'information_mail_type.id')
                ->where('information_mail.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_mail.main', '=', $paramsFunction['main'])
                ->where('information_mail.information_mail_type_id', '=', $paramsFunction['information_mail_type_id'])
                ->where('information_mail.state', '=', $paramsFunction['state'])//house
            ;
        });
        $entity_type = 0;
        $paramsFunction = ['entity_type' => $entity_type, 'main' => 1, 'state' => 'ACTIVE', 'information_phone_operator_id' => 1, 'information_phone_type_id' => 4];//personal
        $query->join('information_phone', function ($join) use ($paramsFunction) {
            $join->on('information_phone.entity_id', '=', 'customer.id')
                ->join('information_phone_operator', 'information_phone.information_phone_operator_id', '=', 'information_phone_operator.id')
                ->join('information_phone_type', 'information_phone.information_phone_type_id', '=', 'information_phone_type.id')
                ->where('information_phone.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_phone.main', '=', $paramsFunction['main'])
                ->where('information_phone.state', '=', $paramsFunction['state'])
                ->where('information_phone.information_phone_operator_id', '=', $paramsFunction['information_phone_operator_id'])
                ->where('information_phone.information_phone_type_id', '=', $paramsFunction['information_phone_type_id']);
        });
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";

            $query->orWhere($this->table . '.identification_document', 'like', $likeSet);
            $query->orWhere('people.name', 'like', $likeSet);
            $query->orWhere('information_phone.value', 'like', $likeSet);
            $query->orWhere('information_mail.value', 'like', $likeSet);

            $query->orWhere('people.last_name', 'like', $likeSet);

            $query->orWhere($this->table . '.business_name', 'like', $likeSet);
            $query->orWhere($this->table . '.business_reason', 'like', $likeSet);

        }


        if ($business_id) {

            //  $query->where($this->table . '.business_id', '=', $business_id);
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

    public function getCustomerRegisters($params)
    {

        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $identification_document = isset($params['filters']['identification_document']) ? $params['filters']['identification_document'] : null;


        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,information_mail.value information_mail_value,information_mail.id information_mail_id
  ,information_phone.value information_phone_value,information_phone.id information_phone_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });
        $entity_type = 0;
        $paramsFunction = ['entity_type' => $entity_type, 'main' => 1, 'state' => 'ACTIVE', 'information_mail_type_id' => 2];//personal
        $query->leftJoin('information_mail', function ($join) use ($paramsFunction) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->join('information_mail_type', 'information_mail.information_mail_type_id', '=', 'information_mail_type.id')
                ->where('information_mail.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_mail.main', '=', $paramsFunction['main'])
                ->where('information_mail.information_mail_type_id', '=', $paramsFunction['information_mail_type_id'])
                ->where('information_mail.state', '=', $paramsFunction['state'])//house
            ;
        });
        $entity_type = 0;
        $paramsFunction = ['entity_type' => $entity_type, 'main' => 1, 'state' => 'ACTIVE', 'information_phone_operator_id' => 1, 'information_phone_type_id' => 4];//personal
        $query->join('information_phone', function ($join) use ($paramsFunction) {
            $join->on('information_phone.entity_id', '=', 'customer.id')
                ->join('information_phone_operator', 'information_phone.information_phone_operator_id', '=', 'information_phone_operator.id')
                ->join('information_phone_type', 'information_phone.information_phone_type_id', '=', 'information_phone_type.id')
                ->where('information_phone.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_phone.main', '=', $paramsFunction['main'])
                ->where('information_phone.state', '=', $paramsFunction['state'])
                ->where('information_phone.information_phone_operator_id', '=', $paramsFunction['information_phone_operator_id'])
                ->where('information_phone.information_phone_type_id', '=', $paramsFunction['information_phone_type_id']);
        });
        $query->where($this->table . '.identification_document', '=', $identification_document);


        $data = $query->first();

        $result = $data;

        return $result;
    }

    public function getAllAdminEmails($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,information_mail.value information_mail_value";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });
        $paramsFunction = ['entity_type' => 0, 'main' => 1, 'state' => 'ACTIVE', 'information_mail_type_id' => 2];
        $query->join('information_mail', function ($join) use ($paramsFunction) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->join('information_mail_type', 'information_mail.information_mail_type_id', '=', 'information_mail_type.id')
                ->where('information_mail.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_mail.main', '=', $paramsFunction['main'])
                ->where('information_mail.information_mail_type_id', '=', $paramsFunction['information_mail_type_id'])
                ->where('information_mail.state', '=', $paramsFunction['state'])//house
            ;
        });

        if ($business_id) {
            //  $query->where($this->table . '.business_id', '=', $business_id);
        }
        // sort
        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();


        return $result;
    }

    public function getAllAdminEmailsRegisters($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,information_mail.value information_mail_value
  ,information_phone.value information_phone_value,information_phone.id information_phone_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });
        $entity_type = 0;
        $paramsFunction = ['entity_type' => $entity_type, 'main' => 1, 'state' => 'ACTIVE', 'information_mail_type_id' => 2];//personal
        $query->leftJoin('information_mail', function ($join) use ($paramsFunction) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->join('information_mail_type', 'information_mail.information_mail_type_id', '=', 'information_mail_type.id')
                ->where('information_mail.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_mail.main', '=', $paramsFunction['main'])
                ->where('information_mail.information_mail_type_id', '=', $paramsFunction['information_mail_type_id'])
                ->where('information_mail.state', '=', $paramsFunction['state'])//house
            ;
        });
        $entity_type = 0;
        $paramsFunction = ['entity_type' => $entity_type, 'main' => 1, 'state' => 'ACTIVE', 'information_phone_operator_id' => 1, 'information_phone_type_id' => 4];//personal
        $query->join('information_phone', function ($join) use ($paramsFunction) {
            $join->on('information_phone.entity_id', '=', 'customer.id')
                ->join('information_phone_operator', 'information_phone.information_phone_operator_id', '=', 'information_phone_operator.id')
                ->join('information_phone_type', 'information_phone.information_phone_type_id', '=', 'information_phone_type.id')
                ->where('information_phone.entity_type', '=', $paramsFunction['entity_type'])
                ->where('information_phone.main', '=', $paramsFunction['main'])
                ->where('information_phone.state', '=', $paramsFunction['state'])
                ->where('information_phone.information_phone_operator_id', '=', $paramsFunction['information_phone_operator_id'])
                ->where('information_phone.information_phone_type_id', '=', $paramsFunction['information_phone_type_id']);
        });
        if ($business_id) {
            //  $query->where($this->table . '.business_id', '=', $business_id);
        }
        // sort
        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();


        return $result;
    }

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,information_phone.value information_phone_value,information_phone.id information_phone_id,information_phone.information_phone_type_id ,information_phone_type.value information_phone_type
  ,information_phone_operator.value information_phone_operator,information_phone_operator.id information_phone_operator_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });
        $information_phone_type_id = 4;
        $information_phone_operator_id = 1;

        $query->leftJoin('information_phone', function ($join) use ($information_phone_type_id, $information_phone_operator_id) {
            $join->on('information_phone.entity_id', '=', 'customer.id')
                ->join('information_phone_operator', 'information_phone.information_phone_operator_id', '=', 'information_phone_operator.id')
                ->join('information_phone_type', 'information_phone.information_phone_type_id', '=', 'information_phone_type.id')
                ->where('information_phone.entity_type', '=', 0)
                ->where('information_phone.information_phone_type_id', '=', $information_phone_type_id)//house
                ->where('information_phone.information_phone_operator_id', '=', $information_phone_operator_id)//house
                ->where('information_phone.main', '=', 1)//house
                ->where('information_phone.state', '=', 'ACTIVE')//house
            ;
        });
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";

            $query->orWhere($this->table . '.identification_document', 'like', $likeSet);
            $query->orWhere('people.name', 'like', $likeSet);
            $query->orWhere('people.last_name', 'like', $likeSet);
            $query->orWhere($this->table . '.business_name', 'like', $likeSet);
            $query->orWhere($this->table . '.business_reason', 'like', $likeSet);

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

    public function getAdminRegisters($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3 ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";

            $query->orWhere($this->table . '.identification_document', 'like', $likeSet);
            $query->orWhere('people.name', 'like', $likeSet);
            $query->orWhere('people.last_name', 'like', $likeSet);
            $query->orWhere($this->table . '.business_name', 'like', $likeSet);
            $query->orWhere($this->table . '.business_reason', 'like', $likeSet);

        }


        if ($business_id) {

            //  $query->where($this->table . '.business_id', '=', $business_id);
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
        $data = array();
        $customerManager = [];
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {

            $model = new People();
            $createUpdate = true;
            if (isset($attributesPost["Customer"]["people_id"]) && $attributesPost["Customer"]["people_id"] != "null" && $attributesPost["Customer"]["people_id"] != "-1") {
                $model = People::find($attributesPost["Customer"]['people_id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost["Customer"];
            $attributesSet = array(
                "last_name" => $postData["last_name"],
                "name" => $postData["name"],
                "type_document" => $postData["type_document"] ?? PeopleTypeIdentification::TYPE_IDENTIFICATION_OTHERS,
                "document_number" => $postData["document_number"],
                "birthdate" => $postData["birthdate"],
                "age" => $postData["age"],
                "gender" => $postData["gender"],


            );
            $validateResult = People::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {
                $modelC = new Customer();
                $model->fill($attributesSet);
                $data['People'] = $attributesSet;
                $model->save();
                $people_id = $model->id;
                $data['People']['id'] = $people_id;

                $customer_id = null;
                if (!$createUpdate) {
                    $customer_id = $attributesPost["Customer"]['customer_id'];
                    $modelC = Customer::find($customer_id);

                }
                $attributesSet = array(
                    "identification_document" => $postData["identification_document"],
                    "people_type_identification_id" => $postData["people_type_identification_id"],
                    "people_id" => $people_id,
                    "business_name" => isset($postData["business_name"]) ? $postData["business_name"] : "",
                    "business_reason" => isset($postData["business_reason"]) ? $postData["business_reason"] : "",
                    "ruc_type_id" => $postData["ruc_type_id"],
                    // "business_id" => $postData["business_id"],
                    "customer_id" => $customer_id,


                );

                $validateResult = Customer::validateModel($attributesSet);

                $success = $validateResult["success"];
                if ($success) {
                    $customerManager['text'] = $postData["identification_document"] . ' ' . $postData["name"] . " " . $postData["last_name"];
                    $modelC->fill($attributesSet);
                    $data['Customer'] = $attributesSet;
                    $modelC->save();
                    $modelCBI = new CustomerByInformation();
                    if (!$createUpdate) {
                        $modelCBI = CustomerByInformation::find($attributesPost["Customer"]['customer_by_information_id']);
                    }
                    $customer_id = $modelC->id;
                    $data['Customer']['id'] = $customer_id;
                    $customerManager['id'] = $customer_id;
                    $data['CustomerManager'] = $customerManager;
                    $attributesSet = array(
                        "customer_id" => $customer_id,
                        "people_nationality_id" => $postData["people_nationality_id"],
                        "people_profession_id" => $postData["people_profession_id"],

                    );

                    $validateResult = CustomerByInformation::validateModel($attributesSet);

                    $success = $validateResult["success"];
                    if (!$success) {
                        $success = false;
                        $msj = "Problemas al guardar Informacion ." . '<br>';
                        $errors = $validateResult["errors"];
                    } else {
                        $modelCBI->fill($attributesSet);
                        $modelCBI->save();
                    }
//Address Information
                    $entity_type = Util::INFORMATION_CUSTOMER_TYPE;
                    if (isset($postData['information_address_id'])) {

                        $information_address_location_current = $postData['information_address_location_current'];
                        $information_address_location_current = json_decode($information_address_location_current, true);
                        $postData['country_code_id'] = $information_address_location_current['country_code_id'];
                        $postData['administrative_area_level_2'] = $information_address_location_current['administrative_area_level_2'];
                        $postData['administrative_area_level_1'] = $information_address_location_current['administrative_area_level_1'];
                        $postData['administrative_area_level_3'] = $information_address_location_current['administrative_area_level_3'];
                        $postData['state'] = 'ACTIVE';
                        $postData['entity_id'] = $customer_id;
                        $postData['entity_type'] = $entity_type;
                        $postData['main'] = 1;

                        $modelIA = new InformationAddress();
                        if ($postData['information_address_id'] != "null" && $postData['information_address_id'] != "-1") {
                            $modelIA = InformationAddress::find($postData['information_address_id']);

                        }
                        $modelCurrent = $modelIA;
                        $paramsSendValidate = array('fillAble' => $modelCurrent->getfillable(), 'haystack' => $postData, 'attributesData' => $modelCurrent->getAttributesData());
                        $attributesSet = $modelCurrent->getValuesModel($paramsSendValidate);
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),

                        );

                        $validateResult = $modelCurrent->validateModel($paramsValidate);

                        $success = $validateResult["success"];
                        if ($success) {
                            $modelIA->fill($attributesSet);
                            $modelIA->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Direccion ." . '<br>';
                            $errors = $validateResult["errors"];
                        }
                    }
                    $key_process = 'information_phone';
                    if (isset($postData[$key_process . '_id'])) {

                        $information_phone_operator_id = InformationPhoneOperator:: OPERATOR_NOT_SPECIFIC_ID;
                        $postData['value'] = $postData[$key_process . '_value'];
                        $postData['information_phone_type_id'] = $postData[$key_process . '_type_id']['id'];
                        $postData['information_phone_operator_id'] = $postData[$key_process . '_operator_id']['id'];
                        $postData['entity_id'] = $customer_id;
                        $postData['entity_type'] = $entity_type;
                        $postData['main'] = 1;
                        $postData['state'] = InformationPhone::STATE_ACTIVE;

                        $modelIA = new InformationPhone();
                        if ($postData[$key_process . '_id'] != "null" && $postData[$key_process . '_id'] != "-1") {
                            $modelIA = InformationPhone::find($postData[$key_process . '_id']);

                        }
                        $modelCurrent = $modelIA;
                        $paramsSendValidate = array('fillAble' => $modelCurrent->getfillable(), 'haystack' => $postData, 'attributesData' => $modelCurrent->getAttributesData());
                        $attributesSet = $modelCurrent->getValuesModel($paramsSendValidate);
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),

                        );

                        $validateResult = $modelCurrent->validateModel($paramsValidate);

                        $success = $validateResult["success"];
                        if ($success) {
                            $modelIA->fill($attributesSet);
                            $modelIA->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Telefono ." . '<br>';
                            $errors = $validateResult["errors"];
                        }
                    }
                } else {
                    $success = false;
                    $msj = "Problemas al guardar Cliente ." . '<br>';
                    $errors = $validateResult["errors"];
                }

            } else {
                $success = false;
                $msj = "Problemas al guardar Persona ." . '<br>';
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
                "success" => $success,
                "data" => $data

            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                "data" => $data
            );
            return ($result);
        }
    }

    public function saveDataData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $dataCustomer = $attributesPost["Customer"];
            $dataCustomerContacts = [];
            $customerMainModel = null;

            foreach ($dataCustomer as $key => $customer) {

                $isMain = $customer['main'] == 'on';

                $model = new People();
                $createUpdate = true;
                if (isset($customer["people_id"]) && $customer["people_id"] != "null" && $customer["people_id"] != "-1") {
                    $model = People::find($customer['people_id']);
                    $createUpdate = false;
                } else {
                    $createUpdate = true;
                }
                $postData = $customer;
                $attributesSet = array(
                    "last_name" => $postData["last_name"],
                    "name" => $postData["name"],
                    "type_document" => 0,
                    "document_number" => 0,
                    "birthdate" => $postData["birthdate"],
                    "age" => $postData["age"],
                    "gender" => $postData["gender"],
                );
                $validateResult = People::validateModel($attributesSet);
                $success = $validateResult["success"];
                if ($success) {

                    $modelC = new Customer();
                    $model->fill($attributesSet);
                    $model->save();
                    $people_id = $model->id;
                    $customer_id = null;
                    if (!$createUpdate) {
                        $customer_id = $attributesPost["Customer"]['customer_id'];
                        $modelC = Customer::find($customer_id);

                    }


                    $attributesSet = array(
                        "identification_document" => $postData["identification_document"],
                        "people_type_identification_id" => $postData["people_type_identification_id"],
                        "people_id" => $people_id,
                        "business_name" => isset($postData["business_name"]) ? $postData["business_name"] : "",
                        "business_reason" => isset($postData["business_reason"]) ? $postData["business_reason"] : "",
                        "ruc_type_id" => $postData["ruc_type_id"] == null ? 1 : $postData["ruc_type_id"],
                        // "business_id" => $postData["business_id"],
                        "customer_id" => $customer_id,
                    );

                    $validateResult = Customer::validateModel($attributesSet);
                    $success = $validateResult["success"];

                    if ($success) {
                        $modelC->fill($attributesSet);
                        $modelC->save();
                        $modelCBI = new CustomerByInformation();
                        if (!$createUpdate) {
                            $modelCBI = CustomerByInformation::find($postData['customer_by_information_id']);
                        }
                        $customer_id = $modelC->id;
                        if ($isMain) {
                            $customerMainModel = [
                                'id' => $modelC->id
                            ];
                        } else {
                            $customer_contact_id = $customer_id;
                            $setPushSaveContacts = [
                                'customer_id' => null,
                                'customer_contact_id' => $customer_contact_id,

                            ];
                            array_push($dataCustomerContacts, $setPushSaveContacts);
                        }
                        $attributesSet = array(
                            "customer_id" => $customer_id,
                            "people_nationality_id" => $postData["people_nationality_id"],
                            "people_profession_id" => $postData["people_profession_id"],

                        );
                        $validateResult = CustomerByInformation::validateModel($attributesSet);
                        $success = $validateResult["success"];
                        if (!$success) {
                            $success = false;
                            $msj = "Problemas al guardar Informacion ." . '<br>';
                            $errors = $validateResult["errors"];
                            throw new \Exception($msj);
                        } else {
                            $modelCBI->fill($attributesSet);
                            $modelCBI->save();
                        }

                        if (isset($postData['information_mail_value']) && $postData['information_mail_value'] != 'null') {
                            $modelIC = new InformationMail();
                            if ($postData['information_mail_id'] != null && $postData['information_mail_id'] != "-1") {
                                $modelIC = InformationMail::find($postData['information_mail_id']);

                            }
                            $modelCurrent = $modelIC;

                            $attributesSet = [
                                'value' => $postData['information_mail_value'],
                                'state' => 'ACTIVE',
                                'entity_id' => $customer_id,
                                'entity_type' => 0,//customer
                                'main' => 1,
                                'information_mail_type_id' => 2,//personal

                            ];
                            $paramsValidate = array(
                                'inputs' => $attributesSet,
                                'rules' => InformationMail::getRulesModel(),

                            );

                            $validateResult = InformationMail::validateModel($paramsValidate);

                            $success = $validateResult["success"];
                            if ($success) {
                                $modelIC->fill($attributesSet);
                                $modelIC->save();
                            } else {
                                $success = false;
                                $msj = "Problemas al guardar Correo Electronico ." . '<br>';
                                $errors = $validateResult["errors"];
                            }
                        }
                        if (isset($postData['information_phone_value']) && $postData['information_phone_value'] != 'null') {
                            $modelIC = new InformationPhone();
                            if ($postData['information_phone_id'] != null && $postData['information_phone_id'] != "-1") {

                                $modelIC = InformationPhone::find($postData['information_phone_id']);

                            }
                            $modelCurrent = $modelIC;
                            $attributesSet = [
                                'value' => $postData['information_phone_value'],
                                'state' => 'ACTIVE',
                                'entity_id' => $customer_id,
                                'entity_type' => 0,//customer
                                'main' => 1,
                                'information_phone_operator_id' => 1,//SIN DEFINIR
                                'information_phone_type_id' => 4,//personal

                            ];
                            $paramsValidate = array(
                                'inputs' => $attributesSet,
                                'rules' => InformationPhone::getRulesModel(),

                            );

                            $validateResult = InformationPhone::validateModel($paramsValidate);
                            $success = $validateResult["success"];
                            if ($success) {
                                $modelIC->fill($attributesSet);
                                $modelIC->save();
                            } else {
                                $success = false;
                                $msj = "Problemas al guardar Telefono ." . '<br>';
                                $errors = $validateResult["errors"];
                                throw new \Exception($msj);
                            }
                        }
//Address Information
                        if (isset($postData['information_address_id'])) {
                            $information_address_location_current = $postData['information_address_location_current'];
                            $information_address_location_current = json_decode($information_address_location_current, true);
                            $postData['country_code_id'] = $information_address_location_current['country_code_id'];
                            $postData['administrative_area_level_2'] = $information_address_location_current['administrative_area_level_2'];
                            $postData['administrative_area_level_1'] = $information_address_location_current['administrative_area_level_1'];
                            $postData['administrative_area_level_3'] = $information_address_location_current['administrative_area_level_3'];
                            $postData['state'] = 'ACTIVE';
                            $postData['entity_id'] = 'ACTIVE';
                            $postData['entity_id'] = $customer_id;
                            $postData['entity_type'] = 0;
                            $postData['main'] = 1;

                            $modelIA = new InformationAddress();
                            if ($postData['information_address_id'] != "null" && $postData['information_address_id'] != "-1") {
                                $modelIA = InformationAddress::find($postData['information_address_id']);

                            }
                            $modelCurrent = $modelIA;
                            $paramsSendValidate = array('fillAble' => $modelCurrent->getfillable(), 'haystack' => $postData, 'attributesData' => $modelCurrent->getAttributesData());
                            $attributesSet = $modelCurrent->getValuesModel($paramsSendValidate);
                            $paramsValidate = array(
                                'inputs' => $attributesSet,
                                'rules' => $modelCurrent::getRulesModel(),

                            );

                            $validateResult = $modelCurrent->validateModel($paramsValidate);

                            $success = $validateResult["success"];
                            if ($success) {
                                $modelIA->fill($attributesSet);
                                $modelIA->save();
                            } else {
                                $success = false;
                                $msj = "Problemas al guardar Direccion ." . '<br>';
                                $errors = $validateResult["errors"];
                                throw new \Exception($msj);
                            }
                        }

                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Cliente ." . '<br>';
                        $errors = $validateResult["errors"];
                        throw new \Exception($msj);
                    }

                } else {
                    $success = false;
                    $msj = "Problemas al guardar Persona ." . '<br>';
                    $errors = $validateResult["errors"];
                    throw new \Exception($msj);
                }
            }
            if ($customerMainModel) {

                $customer_id = $customerMainModel['id'];

                foreach ($dataCustomerContacts as $key => $contact) {
                    $modelCI = new CustomerByContacts();
                    $modelCurrent = $modelCI;
                    $attributesSet = [];
                    $customer_contact_id = $contact['customer_contact_id'];
                    $attributesSet['customer_id'] = $customer_id;
                    $attributesSet['customer_contact_id'] = $customer_contact_id;

                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),

                    );

                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelCI->fill($attributesSet);
                        $modelCI->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Contacto  ." . '<br>';
                        $errors = $validateResult["errors"];
                        throw new \Exception($msj);
                    }
                }
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
            ];

            return ($result);
        } catch (\Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );
            DB::rollBack();
            return ($result);
        }
    }

    public function saveDataFix($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $customer_id = 0;
            $model = new People();
            $createUpdate = true;
            if (isset($attributesPost["Customer"]["people_id"]) && $attributesPost["Customer"]["people_id"] != "null" && $attributesPost["Customer"]["people_id"] != "-1") {
                $model = People::find($attributesPost["Customer"]['people_id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost["Customer"];
            $attributesSet = array(
                "last_name" => $postData["last_name"],
                "name" => $postData["name"],
                "type_document" => 0,
                "document_number" => 0,
                "birthdate" => $postData["birthdate"],
                "age" => $postData["age"],
                "gender" => $postData["gender"],


            );
            $validateResult = People::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {
                $modelC = new Customer();
                $model->fill($attributesSet);
                $model->save();
                $people_id = $model->id;
                $attributesSet = array(
                    "identification_document" => $postData["identification_document"],
                    "people_type_identification_id" => $postData["people_type_identification_id"],
                    "people_id" => $people_id,
                    "business_name" => isset($postData["business_name"]) ? $postData["business_name"] : "",
                    "business_reason" => isset($postData["business_reason"]) ? $postData["business_reason"] : "",
                    "ruc_type_id" => $postData["ruc_type_id"],
                    // "business_id" => $postData["business_id"],

                );
                if (!$createUpdate) {
                    $modelC = Customer::find($attributesPost["Customer"]['id']);
                }
                $validateResult = Customer::validateModel($attributesSet);
                $success = $validateResult["success"];
                if ($success) {
                    $modelC->fill($attributesSet);
                    $modelC->save();
                    $modelCBI = new CustomerByInformation();
                    if (!$createUpdate) {
                        $modelCBI = CustomerByInformation::find($attributesPost["Customer"]['customer_by_information_id']);
                    }

                    $customer_id = $modelC->id;
                    $attributesSet = array(
                        "customer_id" => $customer_id,
                        "people_nationality_id" => $postData["people_nationality_id"],
                        "people_profession_id" => $postData["people_profession_id"],

                    );
                    $validateResult = CustomerByInformation::validateModel($attributesSet);
                    $success = $validateResult["success"];
                    if (!$success) {
                        $success = false;
                        $msj = "Problemas al guardar Informacion ." . '<br>';
                        $errors = $validateResult["errors"];
                    } else {
                        $modelCBI->fill($attributesSet);
                        $modelCBI->save();
                    }

                    //Phone Information

//Address Information
                    $modelCurrent = new InformationPhone();
                    $value = $attributesPost["Customer"]['phone'];
                    if (!$createUpdate) {
                        if (isset($attributesPost["Customer"]['phone_id'])) {
                            $modelCurrent = InformationPhone::find($attributesPost["Customer"]['phone_id']);
                        }
                    }
                    $information_phone_type_id = isset($attributesPost["Customer"]['phone_type_id']) ? $attributesPost["Customer"]['phone_type_id'] : InformationPhoneType::TYPE_WORKFORCE_ID;
                    $entity_id = $customer_id;
                    $main = InformationPhone::MAIN;
                    $entity_type = InformationPhone::ENTITY_TYPE_CUSTOMER;
                    $information_phone_operator_id = InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID;
                    $attributesSet = array(
                        "value" => $value,
                        "state" => 'ACTIVE',
                        "entity_id" => $entity_id,
                        "main" => $main,
                        "entity_type" => $entity_type,
                        "information_phone_operator_id" => $information_phone_operator_id,
                        "information_phone_type_id" => $information_phone_type_id,

                    );

                    $validateResult = $modelCurrent::validateModel(['inputs' => $attributesSet, 'rules' => $modelCurrent::getRulesModel()]);

                    $success = $validateResult["success"];
                    if (!$success) {

                        $msj = "Problemas al guardar Telefono ." . '<br>';
                        $errors = $validateResult["errors"];
                    } else {
                        $modelCurrent->fill($attributesSet);
                        $modelCurrent->save();
                    }

                    if (isset($postData['information_address_id'])) {

                        $information_address_location_current = $postData['information_address_location_current'];
                        $information_address_location_current = json_decode($information_address_location_current, true);
                        $postData['country_code_id'] = $information_address_location_current['country_code_id'];
                        $postData['administrative_area_level_2'] = $information_address_location_current['administrative_area_level_2'];
                        $postData['administrative_area_level_1'] = $information_address_location_current['administrative_area_level_1'];
                        $postData['administrative_area_level_3'] = $information_address_location_current['administrative_area_level_3'];
                        $postData['state'] = 'ACTIVE';
                        $postData['entity_id'] = 'ACTIVE';
                        $postData['entity_id'] = $customer_id;
                        $postData['entity_type'] = 0;
                        $postData['main'] = 1;

                        $modelIA = new InformationAddress();
                        if ($postData['information_address_id'] != "null" && $postData['information_address_id'] != "-1") {
                            $modelIA = InformationAddress::find($postData['information_address_id']);

                        }
                        $modelCurrent = $modelIA;
                        $paramsSendValidate = array('fillAble' => $modelCurrent->getfillable(), 'haystack' => $postData, 'attributesData' => $modelCurrent->getAttributesData());
                        $attributesSet = $modelCurrent->getValuesModel($paramsSendValidate);
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),

                        );

                        $validateResult = $modelCurrent->validateModel($paramsValidate);

                        $success = $validateResult["success"];
                        if ($success) {
                            $modelIA->fill($attributesSet);
                            $modelIA->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Direccion ." . '<br>';
                            $errors = $validateResult["errors"];
                        }
                    }

                } else {
                    $success = false;
                    $msj = "Problemas al guardar Cliente ." . '<br>';
                    $errors = $validateResult["errors"];
                }

            } else {
                $success = false;
                $msj = "Problemas al guardar Persona ." . '<br>';
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
                $data = $this->getCustomerRepair(['filters' => [
                    'customer_id' => $customer_id
                ]]);
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'data' => $data
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $data
            );
            return ($result);
        }
    }

    public function getListSelect2NotLodging($params)
    {
        $modelPhone = new InformationPhone();
        $modelPhoneType = new InformationPhoneType();
        $modelPhoneOperator = new InformationPhoneOperator();

        $result = $this->getListSelect2NotLodgingData($params);
        foreach ($result as $key => $row) {
            $customer_id = $row->customer_id;

            $setPush = json_decode(json_encode($row), true);
            $phone = null;
            $mobile = null;
            $information_mobile_id = null;
            $information_phone_id = null;


            $phoneData = $modelPhone->getInformationByParams(array(
                "information_phone_type_id" => $modelPhoneType::TYPE_HOUSE_ID,
                "information_phone_operator_id" => $modelPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                "entity_id" => $customer_id,
                "entity_type" => 0,
                "main" => 1,
            ));

            $mobileData = $modelPhone->getInformationByParams(array(
                "information_phone_type_id" => $modelPhoneType::TYPE_WORKFORCE_ID,
                "information_phone_operator_id" => $modelPhoneOperator::OPERATOR_NOT_SPECIFIC_ID,
                "entity_id" => $customer_id,
                "entity_type" => 0,
                "main" => 1,
            ));
            if ($mobileData) {
                $mobile = $mobileData->value;
                $information_mobile_id = $mobileData->id;
            }
            if ($phoneData) {
                $phone = $phoneData->value;
                $information_phone_id = $phoneData->id;
            }
            $result[$key] = $setPush;
            $result[$key]['phone'] = $phone;
            $result[$key]['mobile'] = $mobile;
            $result[$key]['information_mobile_id'] = $information_mobile_id;
            $result[$key]['information_phone_id'] = $information_phone_id;


        }
        return $result;
    }

    public function getListSelect2NotLodgingData($params)
    {

        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_location_current_id,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3,information_address.options_map,information_address.entity_id,information_address.entity_type
  ,CONCAT($this->table.identification_document,' ',people.name,' ',people.last_name)  text
  ,information_mail.id information_mail_id,information_mail.value mail ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE');//house
        });

        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        $query->leftJoin('information_mail', function ($join) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->where('information_mail.entity_type', '=', 0);
        });
        if (null) {
            //$query->where('.business_id', '=', $business_id);
        }

        if (isset($params["filters"]['search_value']["term"])) {

            $likeSearch = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.identification_document', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.last_name', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.name', 'like', '%' . $likeSearch . '%');

        }
        if (isset($params["filters"]['lodging_id'])) {
            $lodging_id = $params["filters"]['lodging_id'];
            $paramsCurrent = array(
                "lodging_id" => $lodging_id
            );
            $query->whereNotIn($this->table . '.id', function ($q) use ($paramsCurrent) {
                $lodging_id = $paramsCurrent["lodging_id"];
                $q->select('customer_id')->from('lodging_by_customer')
                    ->where('lodging_by_customer.lodging_id', '=', $lodging_id);
            });
        }
        $query->limit(10)->orderBy('people.name', 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getListS2InformationAddress($params)
    {

        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,CONCAT($this->table.identification_document,' ',people.name,' ',people.last_name)  text
  ,information_mail.id information_mail_id,information_mail.value mail ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');

        $query->rightJoin('information_address', function ($join) {

            $join->on('information_address.entity_id', '=', 'customer.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE');//house*/
        });

        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        $query->leftJoin('information_mail', function ($join) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->where('information_mail.entity_type', '=', 0);
        });
        if (null) {

            //  $query->where('.business_id', '=', $business_id);
        }

        if (isset($params["filters"]['search_value']["term"])) {

            $likeSearch = $params["filters"]['search_value']["term"];
            $query->where($this->table . '.identification_document', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.last_name', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.name', 'like', '%' . $likeSearch . '%');

        }

        $query->limit(10)->orderBy('people.name', 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getListAllInformationAddress($params)
    {

        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,CONCAT($this->table.identification_document,' ',people.name,' ',people.last_name)  text
  ,information_mail.id information_mail_id,information_mail.value mail ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');

        $query->join('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE');//house
        });

        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        $query->leftJoin('information_mail', function ($join) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->where('information_mail.entity_type', '=', 0);
        });
        if (null) {

            //$query->where('.business_id', '=', $business_id);
        }

        if (isset($params['search_value']["term"])) {

            $likeSearch = $params['search_value']["term"];
            $query->where($this->table . '.identification_document', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.last_name', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.name', 'like', '%' . $likeSearch . '%');

        }
        $result = $query->get()->toArray();
        return $result;

    }

    public function getListRepair($params)
    {

        $query = DB::table($this->table);
        $business_id = $params['business_id'];
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_location_current_id,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3,information_address.options_map,information_address.entity_id,information_address.entity_type
  ,CONCAT($this->table.identification_document,' ',people.name,' ',people.last_name)  text
  ,information_mail.id information_mail_id,information_mail.value mail
   ,information_phone.id information_phone_id ,information_phone.value information_phone";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE');//house
        });

        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        $query->leftJoin('information_mail', function ($join) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->where('information_mail.entity_type', '=', 0);
        });
        $query->leftJoin('information_phone', function ($join) {
            $join->on('information_phone.entity_id', '=', 'customer.id')
                ->where('information_phone.entity_type', '=', 0)
                ->where('information_phone.information_phone_type_id', '=', 4);
        });
        if (null) {
            //$query->where('.business_id', '=', $business_id);
        }

        if (isset($params['search_value'])) {

            $likeSearch = $params['search_value'];
            $query->where($this->table . '.identification_document', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.last_name', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.name', 'like', '%' . $likeSearch . '%');

        }

        $query->limit(10)->orderBy('people.name', 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getCustomerRepair($params)
    {

        $query = DB::table($this->table);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $customer_id = $params['filters']['customer_id'];

        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_location_current_id,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3,information_address.options_map,information_address.entity_id,information_address.entity_type
  ,CONCAT($this->table.identification_document,' ',people.name,' ',people.last_name)  text
  ,information_mail.id information_mail_id,information_mail.value mail
   ,information_phone.id information_phone_id ,information_phone.value information_phone";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE');//house
        });

        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        $query->leftJoin('information_mail', function ($join) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->where('information_mail.entity_type', '=', 0);
        });

        $query->leftJoin('information_phone', function ($join) {
            $join->on('information_phone.entity_id', '=', 'customer.id')
                ->where('information_phone.entity_type', '=', 0)
                ->where('information_phone.information_phone_type_id', '=', 4);
        });
        if (null) {
            //$query->where('.business_id', '=', $business_id);
        }
        $query->where($this->table . '.id', '=', $customer_id);

        $result = $query->first();
        return $result;

    }

    public function saveDataProfile($params)//CMS-TEMPLATE-MY-PROFILE-FUNCTION
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $model = new People();
            $createUpdate = true;
            if (isset($attributesPost["people_id"]) && $attributesPost["people_id"] != "null" && $attributesPost["people_id"] != "-1") {
                $model = People::find($attributesPost['people_id']);//key
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost;
            $attributesSet = array(
                "last_name" => $postData["last_name"],
                "name" => $postData["name"],
                "type_document" => 0,
                "document_number" => 0,
                "birthdate" => $postData["birthdate"],
                "age" => $postData["age"],
                "gender" => $postData["gender"],


            );
            $validateResult = People::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {
                $modelC = new Customer();
                $model->fill($attributesSet);
                $model->save();
                $people_id = $model->id;
                $customer_id = null;
                if (isset($attributesPost["customer_id"]) && $attributesPost["customer_id"] != "null" && $attributesPost["customer_id"] != "-1") {
                    $modelC = Customer::find($attributesPost['customer_id']);//key
                    $customer_id = $attributesPost['customer_id'];
                }
                $attributesSet = array(
                    "identification_document" => $postData["identification_document"],
                    "people_type_identification_id" => $postData["people_type_identification_id"],
                    "people_id" => $people_id,
                    "business_name" => isset($postData["business_name"]) ? $postData["business_name"] : "",
                    "business_reason" => isset($postData["business_reason"]) ? $postData["business_reason"] : "",
                    "ruc_type_id" => $postData["ruc_type_id"],
                    "customer_id" => $customer_id,

                );

                $validateResult = Customer::validateModel($attributesSet);
                $success = $validateResult["success"];
                if ($success) {
                    $modelC->fill($attributesSet);
                    $modelC->save();
                    $modelCBI = new CustomerByInformation();
                    if (isset($attributesPost["customer_by_information_id"]) && $attributesPost["customer_by_information_id"] != "null" && $attributesPost["customer_by_information_id"] != "-1") {
                        $modelCBI = CustomerByInformation::find($attributesPost['customer_by_information_id']);//key
                    }
                    $customer_id = $modelC->id;
                    //Customer Information
                    $attributesSet = array(
                        "customer_id" => $customer_id,
                        "people_nationality_id" => $postData["people_nationality_id"],
                        "people_profession_id" => $postData["people_profession_id"],
                    );
                    $validateResult = CustomerByInformation::validateModel($attributesSet);
                    $success = $validateResult["success"];
                    if (!$success) {
                        $success = false;
                        $msj = "Problemas al guardar Informacion .";
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    } else {
                        $modelCBI->fill($attributesSet);
                        $modelCBI->save();
                    }

                    //PHONE
                    $modelCurrent = new \App\Models\InformationPhone();
                    if (isset($postData['information_phone_id']) && $postData['information_phone_id'] != "null" && $postData['information_phone_id'] != "-1") {
                        $modelCurrent = \App\Models\InformationPhone::find($postData['information_phone_id']);//key

                    }

                    $attributesSet = [];
                    $information_phone_value = $postData['information_phone_value'];
                    $information_phone_operator_id = $postData['information_phone_operator_id'];
                    $information_phone_type_id = $postData['information_phone_type_id'];
                    $attributesSet['value'] = $information_phone_value;
                    $attributesSet['state'] = 'ACTIVE';
                    $attributesSet['entity_id'] = $customer_id;
                    $attributesSet['main'] = \App\Models\InformationPhone::MAIN;
                    $attributesSet['entity_type'] = \App\Models\InformationPhone::ENTITY_TYPE_CUSTOMER;
                    $attributesSet['information_phone_operator_id'] = $information_phone_operator_id;
                    $attributesSet['information_phone_type_id'] = $information_phone_type_id;

                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),
                    );
                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelCurrent->fill($attributesSet);
                        $modelCurrent->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Customer Phone .";

                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    }

//social network
                    $number = '_one';
                    if ($postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {

                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook .";
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }

                    $number = '_two';
                    if ($postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {
                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook .";
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
                    $number = '_three';
                    if ($postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {
                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook .";
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
                    $number = '_four';
                    if ($postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {
                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook .";
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
                    $number = '_five';
                    if ($postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {
                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook .";
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
                    $number = '_six';
                    if ($postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {
                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook .";
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
//Address Information

                    $information_address_location_current = $postData['information_address_location_current'];
                    $information_address_location_current = json_decode($information_address_location_current, true);

                    $postData['country_code_id'] = $information_address_location_current['country_code_id'];
                    $postData['administrative_area_level_2'] = $information_address_location_current['administrative_area_level_2'];
                    $postData['administrative_area_level_1'] = $information_address_location_current['administrative_area_level_1'];
                    $postData['administrative_area_level_3'] = $information_address_location_current['administrative_area_level_3'];
                    $postData['state'] = 'ACTIVE';
                    $postData['entity_id'] = 'ACTIVE';
                    $postData['entity_id'] = $customer_id;
                    $postData['entity_type'] = InformationAddress::ENTITY_TYPE_CUSTOMERS;
                    $postData['main'] = InformationAddress::MAIN;

                    $modelIA = new InformationAddress();
                    if (isset($postData['information_address_id']) && $postData['information_address_id'] != "null" && $postData['information_address_id'] != "-1") {
                        $modelIA = InformationAddress::find($postData['information_address_id']);//key

                    }
                    $modelCurrent = $modelIA;

                    $paramsSendValidate = array('fillAble' => $modelCurrent->getfillable(), 'haystack' => $postData, 'attributesData' => $modelCurrent->getAttributesData());

                    $attributesSet = $modelCurrent->getValuesModel($paramsSendValidate);
                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),

                    );

                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelIA->fill($attributesSet);
                        $modelIA->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Direccion .";
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    }

//PROFILE


                    $modelCurrent = new \App\Models\CustomerByProfile();
                    if (isset($postData['customer_by_profile_id']) && $postData['customer_by_profile_id'] != "null" && $postData['customer_by_profile_id'] != "-1") {
                        $modelCurrent = \App\Models\CustomerByProfile::find($postData['customer_by_profile_id']);//key

                    }
                    $user_id = $user->id;
                    $attributesSet = [];
                    $attributesSet['user_id'] = $user_id;
                    $attributesSet['customer_id'] = $customer_id;
                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),
                    );

                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];

                    if ($success) {
                        $modelCurrent->fill($attributesSet);
                        $modelCurrent->save();
                        $customer_by_profile_id = $modelCurrent->id;
                        $modelCurrent = new \App\Models\CustomerProfileByLocation();
                        if (isset($postData['customer_profile_by_location_id']) && $postData['customer_profile_by_location_id'] != "null" && $postData['customer_profile_by_location_id'] != "-1") {
                            $modelCurrent = \App\Models\CustomerProfileByLocation::find($postData['customer_profile_by_location_id']);//key

                        }

                        $attributesSet = [];
                        $zones_id = $postData['zones_id'];
                        $attributesSet['zones_id'] = $zones_id;
                        $attributesSet['customer_by_profile_id'] = $customer_by_profile_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Location .";
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }

                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Customer Profile .";
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    }


//USER ABOUT
                    $modelCurrent = new \App\Models\UsersByAboutUs();
                    if (isset($postData['users_by_about_us_id']) && $postData['users_by_about_us_id'] != "null" && $postData['users_by_about_us_id'] != "-1") {
                        $modelCurrent = \App\Models\UsersByAboutUs::find($postData['users_by_about_us_id']);//key

                    }
                    $attributesSet = [];

                    $attributesSet['users_id'] = $user_id;
                    $attributesSet['description'] = $postData['users_by_about_us_description'];
                    $attributesSet['web'] = ($postData['users_by_about_us_web'] != 'null' || $postData['users_by_about_us_web'] != '') ? $postData['users_by_about_us_web'] : '';
                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),
                    );
                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelCurrent->fill($attributesSet);
                        $modelCurrent->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar User About .";
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    }

                    $modelMultimedia = new Multimedia;
                    $createUpdate = false;
                    $auxResource = $user->avatar;
                    $source = $postData["source"];
                    $pathSet = "/uploads/frontend/profile";
                    $change = $postData["change"];
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
                        $source = $successMultimediaModel['sourceServer'];
                        $modelUser = User::find($user_id);
                        $modelUser->avatar = $source;
                        $modelUser->save();
                    }

                } else {
                    $success = false;
                    $msj = "Problemas al guardar Cliente .";
                    $errors = $validateResult["errors"];
                    foreach ($errors as $key => $value) {
                        $msj .= $value . '<br>';
                    }
                    throw new \Exception($msj);

                }

            } else {
                $success = false;
                $msj = "Problemas al guardar Persona ." . '<br>';
                $errors = $validateResult["errors"];
                foreach ($errors as $key => $value) {
                    $msj .= $value . '<br>';
                }
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
                $modelManager = new \App\Models\CustomerByProfile();
                $data = $modelManager->getDataProfile(
                    ['user' => $user]
                );
            }
            $result = [
                "errors" => $errors,
                "message" => $msj,
                "success" => $success,
                'data' => $data

            ];

            return ($result);
        } catch (\Exception $e) {

            $msj = $e->getMessage();
            $success = false;
            $result = array(
                "success" => $success,
                "message" => $msj,
                "errors" => $errors,
                'data' => $data
            );
            DB::rollBack();
            return ($result);
        }
    }

    public function saveDataProfilePatient($params)
    {
        $success = false;
        $msj = "Paciente registrado correctamente.";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $model = new People();
            $createUpdate = true;
            if (isset($attributesPost["people_id"]) && $attributesPost["people_id"] != "null" && $attributesPost["people_id"] != "-1") {
                $model = People::find($attributesPost['people_id']);//key
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $postData = $attributesPost;
            $attributesSet = array(
                "last_name" => $postData["last_name"],
                "name" => $postData["name"],
                "type_document" => 0,
                "document_number" => 0,
                "birthdate" => $postData["birthdate"],
                "age" => $postData["age"],
                "gender" => $postData["gender"],


            );
            $validateResult = People::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {
                $modelC = new Customer();
                $model->fill($attributesSet);
                $model->save();
                $people_id = $model->id;
                $customer_id = null;
                if (isset($attributesPost["customer_id"]) && $attributesPost["customer_id"] != "null" && $attributesPost["customer_id"] != "-1") {
                    $modelC = Customer::find($attributesPost['customer_id']);//key
                    $customer_id = $attributesPost['customer_id'];
                }

                $attributesSet = array(
                    "identification_document" => $postData["identification_document"],
                    "people_type_identification_id" => $postData["people_type_identification_id"],
                    "people_id" => $people_id,
                    "business_name" => isset($postData["business_name"]) ? $postData["business_name"] : "",
                    "business_reason" => isset($postData["business_reason"]) ? $postData["business_reason"] : "",
                    "ruc_type_id" => $postData["ruc_type_id"],
                    "customer_id" => $customer_id,
                    "has_representative" => $postData["has_representative"],
                    "representative_fullname" => $postData["representative_fullname"],
                );

                $validateResult = Customer::validateModel($attributesSet);
                $success = $validateResult["success"];
                if ($success) {
                    $modelC->fill($attributesSet);
                    $modelC->save();
                    $modelCBI = new CustomerByInformation();
                    $customer_by_information_id = null;
                    if (isset($attributesPost["customer_by_information_id"]) && $attributesPost["customer_by_information_id"] != "null" && $attributesPost["customer_by_information_id"] != "-1") {
                        $customer_by_information_id = $attributesPost['customer_by_information_id'];
                        $modelCBI = CustomerByInformation::find($attributesPost['customer_by_information_id']);//key
                    }
                    $customer_id = $modelC->id;
                    //Customer Information
                    $attributesSet = array(
                        "customer_id" => $customer_id,
                        "people_nationality_id" => $postData["people_nationality_id"],
                        "people_profession_id" => $postData["people_profession_id"],
                    );


                    $validateResult = CustomerByInformation::validateModel($attributesSet);
                    $success = $validateResult["success"];
                    if (!$success) {
                        $success = false;
                        $msj = "Problemas al guardar Informacion ." . '<br>';
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    } else {
                        $modelCBI->fill($attributesSet);
                        $modelCBI->save();
                    }

                    //PHONE
                    $modelCurrent = new \App\Models\InformationPhone();
                    $information_phone_id = null;
                    if (isset($postData['information_phone_id']) && $postData['information_phone_id'] != "null" && $postData['information_phone_id'] != "-1") {
                        $modelCurrent = \App\Models\InformationPhone::find($postData['information_phone_id']);//key
                        $information_phone_id = $postData['information_phone_id'];
                    }

                    $attributesSet = [];
                    $information_phone_value = $postData['information_phone_value'];
                    $information_phone_operator_id = $postData['information_phone_operator_id'];
                    $information_phone_type_id = $postData['information_phone_type_id'];
                    $attributesSet['value'] = $information_phone_value;
                    $attributesSet['state'] = 'ACTIVE';
                    $attributesSet['entity_id'] = $customer_id;
                    $attributesSet['main'] = \App\Models\InformationPhone::MAIN;
                    $attributesSet['entity_type'] = \App\Models\InformationPhone::ENTITY_TYPE_CUSTOMER;
                    $attributesSet['information_phone_operator_id'] = $information_phone_operator_id;
                    $attributesSet['information_phone_type_id'] = $information_phone_type_id;

                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),
                    );
                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelCurrent->fill($attributesSet);
                        $modelCurrent->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Customer Phone ." . '<br>';
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    }

//social network
                    $number = '_one';
                    if ($postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {

                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook ." . '<br>';
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }

                    $number = '_two';
                    if ($postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {
                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook ." . '<br>';
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
                    $number = '_three';
                    $allowPositionSave = isset($postData['information_social_network_value' . $number]);
                    if ($allowPositionSave && $postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {

                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook ." . '<br>';
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
                    $number = '_four';
                    $allowPositionSave = isset($postData['information_social_network_value' . $number]);
                    if ($allowPositionSave && $postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {

                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook ." . '<br>';
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
                    $number = '_five';

                    $allowPositionSave = isset($postData['information_social_network_value' . $number]);
                    if ($allowPositionSave && $postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {

                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook ." . '<br>';
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }
                    $number = '_six';
                    $allowPositionSave = isset($postData['information_social_network_value' . $number]);
                    if ($allowPositionSave && $postData['information_social_network_value' . $number] != 'null' && $postData['information_social_network_value' . $number] != '') {

                        $modelCurrent = new \App\Models\InformationSocialNetwork();
                        if (isset($postData['information_social_network_id' . $number]) && $postData['information_social_network_id' . $number] != "null" && $postData['information_social_network_id' . $number] != "-1") {
                            $modelCurrent = \App\Models\InformationSocialNetwork::find($postData['information_social_network_id' . $number]);//key

                        }

                        $attributesSet = [];
                        $information_social_network_value = $postData['information_social_network_value' . $number];
                        $information_social_network_type_id = $postData['information_social_network_type_id' . $number];
                        $attributesSet['value'] = $information_social_network_value;
                        $attributesSet['state'] = 'ACTIVE';
                        $attributesSet['entity_id'] = $customer_id;
                        $attributesSet['main'] = \App\Models\InformationSocialNetwork::MAIN;
                        $attributesSet['entity_type'] = \App\Models\InformationSocialNetwork::ENTITY_TYPE_CUSTOMER;
                        $attributesSet['information_social_network_type_id'] = $information_social_network_type_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Facebook ." . '<br>';
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }
                    }


//Address Information

                    $information_address_location_current = $postData['information_address_location_current'];
                    $information_address_location_current = json_decode($information_address_location_current, true);

                    $postData['country_code_id'] = $information_address_location_current['country_code_id'];
                    $postData['administrative_area_level_2'] = $information_address_location_current['administrative_area_level_2'];
                    $postData['administrative_area_level_1'] = $information_address_location_current['administrative_area_level_1'];
                    $postData['administrative_area_level_3'] = $information_address_location_current['administrative_area_level_3'];
                    $postData['state'] = 'ACTIVE';
                    $postData['entity_id'] = 'ACTIVE';
                    $postData['entity_id'] = $customer_id;
                    $postData['entity_type'] = InformationAddress::ENTITY_TYPE_CUSTOMERS;
                    $postData['main'] = InformationAddress::MAIN;

                    $modelIA = new InformationAddress();
                    $information_address_id = null;
                    if (isset($postData['information_address_id']) && $postData['information_address_id'] != "null" && $postData['information_address_id'] != "-1") {
                        $modelIA = InformationAddress::find($postData['information_address_id']);//key
                        $information_address_id = $postData['information_address_id'];
                    }

                    $modelCurrent = $modelIA;
                    $paramsSendValidate = array('fillAble' => $modelCurrent->getfillable(), 'haystack' => $postData, 'attributesData' => $modelCurrent->getAttributesData());

                    $attributesSet = $modelCurrent->getValuesModel($paramsSendValidate);
                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),

                    );

                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelIA->fill($attributesSet);
                        $modelIA->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Direccion ." . '<br>';
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    }

//PROFILE
                    $modelCurrent = new \App\Models\CustomerByProfile();
                    $customer_by_profile_id = null;
                    if (isset($postData['customer_by_profile_id']) && $postData['customer_by_profile_id'] != "null" && $postData['customer_by_profile_id'] != "-1") {
                        $customer_by_profile_id = $postData['customer_by_profile_id'];
                        $modelCurrent = \App\Models\CustomerByProfile::find($customer_by_profile_id);//key

                    }


                    $user_id = 0;
                    $attributesSet = [];
                    $attributesSet['user_id'] = $user_id;
                    $attributesSet['customer_id'] = $customer_id;
                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),
                    );

                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];

                    if ($success) {
                        $modelCurrent->fill($attributesSet);
                        $modelCurrent->save();
                        $customer_by_profile_id = $modelCurrent->id;
                        $modelCurrent = new \App\Models\CustomerProfileByLocation();
                        $customer_profile_by_location_id = null;
                        if (isset($postData['customer_profile_by_location_id']) && $postData['customer_profile_by_location_id'] != "null" && $postData['customer_profile_by_location_id'] != "-1") {
                            $customer_profile_by_location_id = $postData['customer_profile_by_location_id'];
                            $modelCurrent = \App\Models\CustomerProfileByLocation::find($customer_profile_by_location_id);//key

                        }

                        $attributesSet = [];
                        $zones_id = $postData['zones_id'];
                        $attributesSet['zones_id'] = $zones_id;
                        $attributesSet['customer_by_profile_id'] = $customer_by_profile_id;
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar Customer Location ." . '<br>';
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }

                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Customer Profile ." . '<br>';
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    }


//USER ABOUT
                    if ($user_id != 0) {
                        $modelCurrent = new \App\Models\UsersByAboutUs();
                        if (isset($postData['users_by_about_us_id']) && $postData['users_by_about_us_id'] != "null" && $postData['users_by_about_us_id'] != "-1") {
                            $modelCurrent = \App\Models\UsersByAboutUs::find($postData['users_by_about_us_id']);//key

                        }
                        $attributesSet = [];
                        $attributesSet['users_id'] = $user_id;
                        $attributesSet['description'] = $postData['users_by_about_us_description'];
                        $attributesSet['web'] = ($postData['users_by_about_us_web'] != 'null' || $postData['users_by_about_us_web'] != '') ? $postData['users_by_about_us_web'] : '';
                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $modelCurrent::getRulesModel(),
                        );
                        $validateResult = $modelCurrent->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if ($success) {
                            $modelCurrent->fill($attributesSet);
                            $modelCurrent->save();
                        } else {
                            $success = false;
                            $msj = "Problemas al guardar User About ." . '<br>';
                            $errors = $validateResult["errors"];
                            foreach ($errors as $key => $value) {
                                $msj .= $value . '<br>';
                            }
                            throw new \Exception($msj);

                        }

                    }
                    if ($user_id != 0) {
                        $modelMultimedia = new Multimedia;
                        $createUpdate = false;
                        $auxResource = $user->avatar;
                        $source = $postData["source"];
                        $pathSet = "/uploads/frontend/profile";
                        $change = $postData["change"];
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
                            $source = $successMultimediaModel['sourceServer'];
                            $modelUser = User::find($user_id);
                            $modelUser->avatar = $source;
                            $modelUser->save();
                        }
                    }
                    $business_id = $postData["business_id"];

                    $modelCurrent = new \App\Models\HistoryClinic();
                    if (isset($postData['id']) && $postData['id'] != "null" && $postData['id'] != "-1") {
                        $modelCurrent = \App\Models\HistoryClinic::find($postData['id']);//key
                    }
                    $attributesSet = [];
                    $attributesSet['status'] = 'ACTIVE';
                    $attributesSet['customer_id'] = $customer_id;
                    $attributesSet['business_id'] = $business_id;
                    $paramsValidate = array(
                        'inputs' => $attributesSet,
                        'rules' => $modelCurrent::getRulesModel(),
                    );
                    $validateResult = $modelCurrent->validateModel($paramsValidate);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelCurrent->fill($attributesSet);
                        $modelCurrent->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar historial Clinico" . '<br>';
                        $errors = $validateResult["errors"];
                        foreach ($errors as $key => $value) {
                            $msj .= $value . '<br>';
                        }
                        throw new \Exception($msj);

                    }
                } else {
                    $success = false;
                    $msj = "Problemas al guardar Cliente ." . '<br>';
                    $errors = $validateResult["errors"];
                    foreach ($errors as $key => $value) {
                        $msj .= $value . '<br>';
                    }
                    throw new \Exception($msj);

                }

            } else {
                $success = false;
                $msj = "Problemas al guardar Persona ." . '<br>';
                $errors = $validateResult["errors"];
                foreach ($errors as $key => $value) {
                    $msj .= $value . '<br>';
                }
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
                $modelManager = new \App\Models\CustomerByProfile();
                $data = $modelManager->getDataProfilePatient(
                    ['user' => $user]
                );
            }
            $result = [
                "errors" => $errors,
                "message" => $msj,
                "success" => $success,
                'data' => $data

            ];

            return ($result);
        } catch (\Exception $e) {

            $msj = $e->getMessage();
            $success = false;
            $result = array(
                "success" => $success,
                "message" => $msj,
                "errors" => $errors,
                'data' => $data
            );
            DB::rollBack();
            return ($result);
        }
    }

    public function findByAttributes($arrayParams, $params = [])
    {
        $selectString = isset($params['columnsSelect']) ? $params['columnsSelect'] : '*';
        $select = DB::raw($selectString);
        $query = DB::table($this->table)
            ->select($select);
        foreach ($arrayParams as $key => $value) {
            $query->where($key, "=", $value);
        }

        $result = $query->first();
        return $result;
    }

    public function getListCustomers($params)
    {

        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id ,$this->table.has_representative ,$this->table.representative_fullname ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name people_last_name ,people.name people_name,people.birthdate people_birthdate,people.age people_age,people.gender people_gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.street_one information_address_street_one,information_address.street_two information_address_street_two,information_address.reference information_address_reference,information_address.state information_address_state,information_address.entity_id information_address_entity_id,information_address.main information_address_main,information_address.entity_type information_address_entity_type,information_address.information_address_type_id information_address_information_address_type_id,information_address.has_location information_address_has_location,information_address.options_map information_address_options_map,information_address.country_code_id information_address_country_code_id,information_address.administrative_area_level_2 information_address_administrative_area_level_2,information_address.administrative_area_level_1 information_address_administrative_area_level_1,information_address.administrative_area_level_3 information_address_administrative_area_level_3,information_address.entity_id information_address_entity_id,information_address.entity_type information_address_entity_type
  ,information_mail.id information_mail_id,information_mail.value information_mail_value,information_mail.state information_mail_state,information_mail.entity_id information_mail_entity_id,information_mail.main information_mail_main,information_mail.entity_type information_mail_entity_type,information_mail.information_mail_type_id information_mail_information_mail_type_id
   ,information_phone.id information_phone_id,information_phone.value information_phone_value, information_phone.state information_phone_state,information_phone.entity_id information_phone_entity_id,information_phone.main information_phone_main,information_phone.entity_type information_phone_entity_type,information_phone.information_phone_operator_id information_phone_information_phone_operator_id,information_phone.information_phone_type_id information_phone_information_phone_type_id
  ,CONCAT($this->table.identification_document,' ',people.name,' ',people.last_name)  text
  , " . 'CONCAT(' . $this->table . '.identification_document, " ",people.name," ",people.last_name) as text,' . "$this->table.identification_document identificacion,$this->table.people_type_identification_id tipo_identificacion_id,$this->table.people_type_identification_id tipo_identificacion_id," . 'concat(people.name," ",people.last_name) nombres_cliente , ' . "$this->table.business_reason razon_social
 ";//THIS BY XYTAB CONSULT
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');

        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        $query->leftJoin('information_mail', function ($join) {
            $join->on('information_mail.entity_id', '=', 'customer.id')
                ->where('information_mail.entity_type', '=', 0);
        });
        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE');//house
        });
        $query->leftJoin('information_phone', function ($join) {
            $join->on('information_phone.entity_id', '=', 'customer.id')
                ->join('information_phone_type', 'information_phone.information_phone_type_id', '=', 'information_phone_type.id')
                ->where('information_phone.entity_type', '=', 0)
                ->where('information_phone.information_phone_type_id', '=', 4)//PERSONAL
                ->where('information_phone.main', '=', 1)
                ->where('information_phone.state', '=', 'ACTIVE');//house
        });

        if (null) {
            //$query->where('.business_id', '=', $business_id);
        }

        if (isset($params["filters"]['search_value'])) {

            $likeSearch = $params["filters"]['search_value'];
            $query->orWhere($this->table . '.identification_document', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.last_name', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.name', 'like', '%' . $likeSearch . '%');
            $query->orWhere($this->table . '.business_reason', 'like', '%' . $likeSearch . '%');

        }

        $query->limit(10)->orderBy('people.name', 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getListCustomersManager($params)
    {

        $paramsSearch = [
            'filters' => [
                'business_id' => $params['search_entidadid'],
                'search_value' => $params['search_value']

            ]
        ];


        $resultCustomers = $this->getListCustomers($paramsSearch);
        $modelIA = new \App\Models\InformationAddress();
        $modelPhone = new \App\Models\InformationAddress();
        $model = new \App\Models\Customer();
        foreach ($resultCustomers as $key => $value) {

            $informationData = $model->getInformationCustomer(array("customer" => $value));
            $resultCustomers[$key] = (array)$value;
            $resultCustomers[$key]["information"] = $informationData['information'];
            $resultCustomers[$key]["telefono"] = $informationData['telefono'];
            $resultCustomers[$key]["direccion"] = $informationData['information'];
            $resultCustomers[$key]["email"] = $informationData['email'];
            $resultCustomers[$key]["text"] = $informationData['text'];


        }
        return $resultCustomers;

    }

    public function getListCustomersMikrotiksManager($params)
    {


        $paramsSearch = [
            'filters' => [
                'business_id' => $params['search_entidadid'],

            ]
        ];

        if (isset($params["search_value"]["term"])) {
            $paramsSearch["filters"]["search_value"] = $params['search_value']["term"];
        }
        $resultCustomers = $this->getListCustomers($paramsSearch);
        $modelIA = new \App\Models\InformationAddress();
        $modelPhone = new \App\Models\InformationAddress();
        $model = new \App\Models\Customer();
        foreach ($resultCustomers as $key => $value) {

            $informationData = $model->getInformationCustomer(array("customer" => $value));
            $resultCustomers[$key] = (array)$value;
            $resultCustomers[$key]["information"] = $informationData['information'];
            $resultCustomers[$key]["telefono"] = $informationData['telefono'];
            $resultCustomers[$key]["direccion"] = $informationData['information'];
            $resultCustomers[$key]["email"] = $informationData['email'];
            $resultCustomers[$key]["text"] = $informationData['text'];


        }
        return $resultCustomers;

    }

    public function getInformationCustomer($params)
    {
        $email = '';
        $direccion = '';
        $telefono = '';
        $customerCurrent = $params['customer'];
        $customer_id = $customerCurrent->id;
        $customerText = '';
        $customerFullName = '';


        $person = array();
        $address = array();
        $mail = array();
        $phone = array();
        $customer_id = $customerCurrent->id;


        $customer = [
            "id" => $customerCurrent->id,//*

            "identification_document" => $customerCurrent->identification_document,//*
            "src" => $customerCurrent->src,
            "people_type_identification_id" => $customerCurrent->people_type_identification_id,//*
            "people_id" => $customerCurrent->people_id,//*
            "business_name" => $customerCurrent->business_name,
            "business_reason" => $customerCurrent->business_reason,
            "has_representative" => $customerCurrent->has_representative,
            "representative_fullname" => $customerCurrent->representative_fullname,
            "ruc_type_id" => $customerCurrent->representative_fullname//*
        ];

        if ($customerCurrent->information_address_id) {
            $modelD = null;
            $direccion = $customerCurrent->information_address_street_one . ' y ' . $customerCurrent->information_address_street_two;

            $valueCurrent = $direccion;
            $viewAllow = true;
            $tableCurrent = 'information_address_';

            $address = array(
                "viewAllow" => $viewAllow,
                "value" => $valueCurrent,
                "attributes" => [
                    'id' => $customerCurrent->information_address_id,//*

                    'street_one' => $customerCurrent->information_address_street_one,//*
                    'street_two' => $customerCurrent->information_address_street_two,//*
                    'reference' => $customerCurrent->information_address_reference,//*
                    'state' => $customerCurrent->information_address_state,//*
                    'entity_id' => $customerCurrent->information_address_entity_id,//*
                    'main' => $customerCurrent->information_address_main,//*
                    'entity_type' => $customerCurrent->information_address_entity_type,//*
                    'information_address_type_id' => $customerCurrent->information_address_information_address_type_id,//*
                    'has_location' => $customerCurrent->information_address_has_location,//*
                    'options_map' => $customerCurrent->information_address_options_map,//*
                    "country_code_id" => $customerCurrent->information_address_country_code_id,//*
                    "administrative_area_level_2" => $customerCurrent->information_address_administrative_area_level_2,//*google code types Ciudad
                    "administrative_area_level_1" => $customerCurrent->information_address_administrative_area_level_1,//*google code types Provincia
                    "administrative_area_level_3" => $customerCurrent->information_address_administrative_area_level_3,//google code types parroquia ,comunidad
                    "entity_id" => $customerCurrent->information_address_entity_id,//*
                    "entity_type" => $customerCurrent->information_address_entity_type,//*
                ]
            );

        } else {
            $attributes = array();
            $valueCurrent = "Sin Gestionar.";

            $viewAllow = false;
            $address = array(
                "viewAllow" => $viewAllow,
                "value" => $valueCurrent,
                "attributes" => $attributes
            );
        }

        if ($customerCurrent->information_phone_id) {
            $telefono = $customerCurrent->information_phone_value;

            $valueCurrent = $telefono;
            $attributes = [
                'id' => $customerCurrent->id,//*
                'value' => $customerCurrent->information_phone_value,//*
                'state' => $customerCurrent->information_phone_state,//*
                'entity_id' => $customerCurrent->information_phone_entity_id,//*
                'main' => $customerCurrent->information_phone_main,//*
                'entity_type' => $customerCurrent->information_phone_entity_type,//*
                'information_phone_operator_id' => $customerCurrent->information_phone_information_phone_operator_id,//*
                'information_phone_type_id' => $customerCurrent->information_phone_information_phone_type_id//*

            ];
            $viewAllow = false;
            $phone = array(
                "value" => $valueCurrent,
                "viewAllow" => $viewAllow,
                "attributes" => $attributes
            );
        } else {
            $valueCurrent = "Sin Gestionar.";
            $attributes = array();
            $viewAllow = false;
            $phone = array(
                "value" => $valueCurrent,
                "viewAllow" => $viewAllow,
                "attributes" => $attributes
            );
        }
        if ($customerCurrent->information_mail_id) {
            $email = $customerCurrent->information_mail_value;
            //        ----email---
            $valueCurrent = $email;

            $attributes = [
                'id' => $customerCurrent->information_mail_id, //*
                'value' => $customerCurrent->information_mail_value, //*
                'state' => $customerCurrent->information_mail_state, //*
                'entity_id' => $customerCurrent->information_mail_entity_id, //*
                'main' => $customerCurrent->information_mail_main, //*
                'entity_type' => $customerCurrent->information_mail_entity_type, //*
                'information_mail_type_id' => $customerCurrent->information_mail_information_mail_type_id//*
            ];
            $viewAllow = true;
            $mail = array(
                "value" => $valueCurrent,
                "viewAllow" => $viewAllow,
                "attributes" => $attributes
            );


        } else {
            $valueCurrent = "Sin Gestionar.";
            $attributes = array();
            $viewAllow = false;
            $mail = array(
                "value" => $valueCurrent,
                "viewAllow" => $viewAllow,
                "attributes" => $attributes
            );
        }

        if ($customerCurrent->people_type_identification_id == 1) { // RUC
            $customerText = $customerCurrent->identificacion . " " . $customerCurrent->razon_social;
            $customerFullName = $customerCurrent->razon_social;
        } else if ($customerCurrent->people_type_identification_id > 1) {
            $customerText = $customerCurrent->identification_document . ' - ' . $customerCurrent->people_name . " " . $customerCurrent->people_last_name;
            $customerFullName = $customerCurrent->people_name . " " . $customerCurrent->people_last_name;
        }

        if ($customerCurrent->people_id) {
            $attributes = $customerCurrent;
            $person = array(
                "value" => $attributes->people_name . " " . $attributes->people_last_name,
                "attributes" => [
                    "id" => $attributes->people_id,//*
                    "last_name" => $attributes->people_last_name,//*
                    "name" => $attributes->people_name,//*,
                    "birthdate" => $attributes->people_birthdate,
                    "age" => $attributes->people_age,//*
                    "gender" => $attributes->people_gender
                ]
            );
        } else {
            $valueCurrent = "Sin Gestionar.";
            $attributes = array();
            $viewAllow = false;
            $person = array(
                "value" => $valueCurrent,
                "viewAllow" => $viewAllow,
                "attributes" => $attributes
            );
        }


        $result = array(
            'information' => [
                "person" => $person,
                "address" => $address,
                "mail" => $mail,
                "phone" => $phone,
                "customer" => $customer,
            ],


            'email' => $email,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'text' => $customerText,
            'nombres_cliente' => $customerFullName,


        );


        return $result;
    }

    public function getCustomerInformation($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $customer_id = $params["filters"]["customer_id"];
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');

        $query->leftJoin('information_address', function ($join) {
            $join->on('information_address.entity_id', '=', 'customer.id')
                ->join('information_address_type', 'information_address.information_address_type_id', '=', 'information_address_type.id')
                ->where('information_address.entity_type', '=', 0)
                ->where('information_address.information_address_type_id', '=', 1)//house
                ->where('information_address.main', '=', 1)//house
                ->where('information_address.state', '=', 'ACTIVE')//house
            ;
        });
        $query->where($this->table . ".id", "=", $customer_id);

        $result = $query->first();


        return $result;
    }

    public function getListS2Customer($params)
    {

        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id ,$this->table.identification_document ,$this->table.people_id ,$this->table.src,$this->table.people_type_identification_id,$this->table.people_id,$this->table.business_name,$this->table.business_reason,$this->table.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,CONCAT($this->table.identification_document,' ',people.name,' ',people.last_name)  text ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $this->table . '.ruc_type_id', '=', 'ruc_type.id');


        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $this->table . '.id');
        $query->join('people_nationality', "customer_by_information.people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', "customer_by_information.people_profession_id", '=', 'people_profession.id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSearch = $params["filters"]['search_value']["term"];
            $query->where($this->table . '.identification_document', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.last_name', 'like', '%' . $likeSearch . '%');
            $query->orWhere('people.name', 'like', '%' . $likeSearch . '%');

        }

        $query->limit(10)->orderBy('people.name', 'asc');
        $result = $query->get()->toArray();
        return $result;

    }
    public function saveCustomerApi($params)
    {
        DB::beginTransaction();
        try {
            $attributesPost = $params["attributesPost"];
            $customerData = $attributesPost["Customer"];

            $peopleResult = $this->saveOrUpdatePerson($customerData);
            if (!$peopleResult['success']) return $this->rollbackWithError($peopleResult);

            $customerResult = $this->saveOrUpdateCustomer($customerData, $peopleResult['data']['id']);
            if (!$customerResult['success']) return $this->rollbackWithError($customerResult);

            $customerInfoResult = $this->saveOrUpdateCustomerInformation($customerData, $customerResult['data']['id']);
            if (!$customerInfoResult['success']) return $this->rollbackWithError($customerInfoResult);

            if (isset($customerData['information_address_id'])) {
                $addressResult = $this->saveOrUpdateAddress($customerData, $customerResult['data']['id']);
                if (!$addressResult['success']) return $this->rollbackWithError($addressResult);
            }

            if (isset($customerData['information_phone_id'])) {
                $phoneResult = $this->saveOrUpdatePhone($customerData, $customerResult['data']['id']);
                if (!$phoneResult['success']) return $this->rollbackWithError($phoneResult);
            }

            DB::commit();

            return [
                'success' => true,
                'msj' => '',
                'errors' => [],
                'data' => [
                    'People' => $peopleResult['data'],
                    'Customer' => $customerResult['data'],
                    'CustomerManager' => [
                        'id' => $customerResult['data']['id'],
                        'text' => $customerData["document_number"] . ' ' . $customerData["name"] . " " . $customerData["last_name"]
                    ]
                ]
            ];

        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'msj' => $e->getMessage(),
                'errors' => [],
                'data' => []
            ];
        }
    }

    private function saveOrUpdatePerson($data)
    {
        $person = (isset($data['people_id']) && $data['people_id'] != 'null' && $data['people_id'] != '-1')
            ? People::find($data['people_id'])
            : new People();

        $attributes = [
            'last_name' => $data["last_name"],
            'name' => $data["name"],
            'type_document' => $data["people_type_identification_id"] ?? PeopleTypeIdentification::TYPE_IDENTIFICATION_OTHERS,
            'document_number' => $data["document_number"],
            'birthdate' => isset($data["birthdate"]) && !empty($data["birthdate"])
                ? \Carbon\Carbon::parse($data["birthdate"])->format('Y-m-d')
                : \Carbon\Carbon::now()->format('Y-m-d'),
            'age' => $data["age"] ?? 0,
            'gender' => $data["gender"] ?? 3,
        ];

        return $this->validateAndSaveModel($person, $attributes, 'Persona');
    }

    private function saveOrUpdateCustomer($data, $peopleId)
    {
        $customer = (isset($data['customer_id']) && $data['customer_id'] != 'null' && $data['customer_id'] != '-1')
            ? Customer::find($data['customer_id'])
            : new Customer();

        $attributes = [
            'identification_document' => $data["document_number"],
            'people_type_identification_id' => $data["people_type_identification_id"] ?? PeopleTypeIdentification::TYPE_IDENTIFICATION_OTHERS,
            'people_id' => $peopleId,
            'business_name' => $data["business_name"] ?? "",
            'business_reason' => $data["business_reason"] ?? "",
            'ruc_type_id' => $data["ruc_type_id"] ?? RucType::RUC_TYPE_ANY,
        ];

        return $this->validateAndSaveModel($customer, $attributes, 'Cliente');
    }

    private function saveOrUpdateCustomerInformation($data, $customerId)
    {
        $customerInfo = (isset($data['customer_by_information_id']) && $data['customer_by_information_id'] != 'null' && $data['customer_by_information_id'] != '-1')
            ? CustomerByInformation::find($data['customer_by_information_id'])
            : new CustomerByInformation();

        $attributes = [
            'customer_id' => $customerId,
            'people_nationality_id' => $data["people_nationality_id"]??PeopleNationality::TYPE_ANYONE,
            'people_profession_id' => $data["people_profession_id"]??PeopleProfession::TYPE_ANYONE,
        ];

        return $this->validateAndSaveModel($customerInfo, $attributes, 'Información Adicional');
    }

    private function saveOrUpdateAddress($data, $entityId)
    {
        $address = (isset($data['information_address_id']) && $data['information_address_id'] != 'null' && $data['information_address_id'] != '-1')
            ? InformationAddress::find($data['information_address_id'])
            : new InformationAddress();

        $location = json_decode($data['information_address_location_current'], true);

        $attributes = [
            'country_code_id' => $location['country_code_id'],
            'administrative_area_level_1' => $location['administrative_area_level_1'],
            'administrative_area_level_2' => $location['administrative_area_level_2'],
            'administrative_area_level_3' => $location['administrative_area_level_3'],
            'state' => 'ACTIVE',
            'entity_id' => $entityId,
            'entity_type' => Util::INFORMATION_CUSTOMER_TYPE,
            'main' => 1,
        ];

        return $this->validateAndSaveModel($address, $attributes, 'Dirección');
    }

    private function saveOrUpdatePhone($data, $entityId)
    {
        $phone = (isset($data['information_phone_id']) && $data['information_phone_id'] != 'null' && $data['information_phone_id'] != '-1')
            ? InformationPhone::find($data['information_phone_id'])
            : new InformationPhone();

        $attributes = [
            'value' => $data['information_phone_value'],
            'information_phone_type_id' => $data['information_phone_type_id']['id'],
            'information_phone_operator_id' => $data['information_phone_operator_id']['id'],
            'entity_id' => $entityId,
            'entity_type' => Util::INFORMATION_CUSTOMER_TYPE,
            'main' => 1,
            'state' => InformationPhone::STATE_ACTIVE,
        ];

        return $this->validateAndSaveModel($phone, $attributes, 'Teléfono');
    }

    private function validateAndSaveModel($model, $attributes, $entityName)
    {
        $validation = $model::validateModel($attributes);
        if (!$validation['success']) {
            return [
                'success' => false,
                'msj' => "Problemas al guardar $entityName.",
                'errors' => $validation['errors'],
                'data' => []
            ];
        }
        $model->fill($attributes);
        $model->save();
        $attributes['id'] = $model->id;

        return [
            'success' => true,
            'msj' => '',
            'errors' => [],
            'data' => $attributes
        ];
    }

    private function rollbackWithError($response)
    {
        DB::rollBack();
        return $response;
    }


}
