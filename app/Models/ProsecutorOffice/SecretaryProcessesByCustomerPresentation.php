<?php

namespace App\Models;
namespace App\Models\ProsecutorOffice;

use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\ModelManager;

class SecretaryProcessesByCustomerPresentation extends ModelManager
{
    const STATE_INIT = 0;
    const STATE_DELETE = 1;
    const STATE_PRESENTED = 2;
    const STATE_NOT_PRESENTED = 3;
    protected $table = 'secretary_processes_by_customer_presentation';
    const ENTITY_TYPE_CUSTOMER = 0;
    public function getStatesData(){
        return [
            ['value'=>self::STATE_INIT,'id'=>self::STATE_INIT,'text'=>'Iniciada','class'=>'label label-warning'],
            ['value'=>self::STATE_PRESENTED,'id'=>self::STATE_PRESENTED,'text'=>'Presentada','class'=>'label label-success'],
            ['value'=>self::STATE_NOT_PRESENTED,'id'=>self::STATE_NOT_PRESENTED,'text'=>'No Presentada','class'=>'label label-danger'],
            ['value'=>self::STATE_DELETE,'id'=>self::STATE_DELETE,'text'=>'Eliminada','class'=>'label label-dangerous'],

        ];
    }
    protected $fillable = array(
        'customer_id',
        'state',
        'owner_id',
        'prosecution_process_number',
        'judical_process_number',
        'date_of_presentation',
        'due_date',
        'observation',
        'date_of_state',
        'business_id',

    );
    protected $attributesData = [
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'owner_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'prosecution_process_number', 'type' => 'string', 'defaultValue' => '0001', 'required' => 'true'],
        ['column' => 'judical_process_number', 'type' => 'string', 'defaultValue' => '0001', 'required' => 'false'],
        ['column' => 'date_of_presentation', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'true'],
        ['column' => 'due_date', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'false'],
        ['column' => 'observation', 'type' => 'string', 'defaultValue' => 'None description', 'required' => 'false'],
        ['column' => 'date_of_state', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'false'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],

    ];
    public $timestamps = false;

    protected $field_main = 'customer_id';


    public static function getRulesModel()
    {
        $rules = [

            "customer_id" => "required",
            "state" => "required",
            "owner_id" => "required",
            "prosecution_process_number" => "required",
            // "judical_process_number" => "required",
            "date_of_presentation" => "required",
            // "due_date" => "required",
            //"observation" => "required",
            //"date_of_state" => "required",
            "business_id" => "required"

        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'people.name';
        $tblCustomer = 'customer';
        $query = DB::table($tblCustomer);
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$tblCustomer.identification_document ,$tblCustomer.people_id ,$tblCustomer.src,$tblCustomer.people_type_identification_id,$tblCustomer.people_id,$tblCustomer.business_name,$tblCustomer.business_reason,$tblCustomer.ruc_type_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,ruc_type.name ruc_type
  ,customer_by_information.id customer_by_information_id,customer_by_information.customer_id,customer_by_information.people_nationality_id,customer_by_information.people_profession_id
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,information_address.id information_address_id,information_address.information_address_type_id,information_address.options_map,information_address.street_one,information_address.street_two,information_address.reference,information_address_type.value as information_address_type
  ,information_address.country_code_id,information_address.administrative_area_level_2,information_address.administrative_area_level_1,information_address.administrative_area_level_3
  ,information_phone.value information_phone_value,information_phone.id information_phone_id,information_phone.information_phone_type_id ,information_phone_type.value information_phone_type
  ,information_phone_operator.value information_phone_operator,information_phone_operator.id information_phone_operator_id
  ,secretary_processes_by_customer_presentation.id,secretary_processes_by_customer_presentation.customer_id, secretary_processes_by_customer_presentation.state ,secretary_processes_by_customer_presentation.owner_id,secretary_processes_by_customer_presentation.prosecution_process_number,secretary_processes_by_customer_presentation.judical_process_number,secretary_processes_by_customer_presentation.date_of_presentation,secretary_processes_by_customer_presentation.due_date,secretary_processes_by_customer_presentation.observation,secretary_processes_by_customer_presentation.date_of_state,secretary_processes_by_customer_presentation.business_id";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('secretary_processes_by_customer_presentation', 'secretary_processes_by_customer_presentation.customer_id', '=', $tblCustomer . '.id');

        $query->join('people_type_identification', $tblCustomer . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $tblCustomer . '.people_id', '=', 'people.id');
        $query->join('ruc_type', $tblCustomer . '.ruc_type_id', '=', 'ruc_type.id');
        $query->join('customer_by_information', "customer_by_information.customer_id", '=', $tblCustomer . '.id');
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

        $information_phone_type_id = \App\Models\InformationPhoneType::TYPE_WORKFORCE_ID;
        $information_phone_operator_id = \App\Models\InformationPhoneType::TYPE_NOT_SPECIFIC_ID;

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
            $query->orWhere( 'secretary_processes_by_customer_presentation.prosecution_process_number', 'like', $likeSet);
            $query->orWhere( 'secretary_processes_by_customer_presentation.judical_process_number', 'like', $likeSet);

            $query->orWhere($tblCustomer . '.identification_document', 'like', $likeSet);
            $query->orWhere('people.name', 'like', $likeSet);
            $query->orWhere('people.last_name', 'like', $likeSet);
            $query->orWhere($tblCustomer . '.business_name', 'like', $likeSet);
            $query->orWhere($tblCustomer . '.business_reason', 'like', $likeSet);

        }

        $query->where('secretary_processes_by_customer_presentation.business_id', '=', $business_id);


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
        $data = null;
        DB::beginTransaction();
        try {
            $modelName = 'SecretaryProcessesByCustomerPresentation';
            $model = new SecretaryProcessesByCustomerPresentation();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = SecretaryProcessesByCustomerPresentation::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $user = Auth::user();
            $user_id = $user->id;

            $modelData = $attributesPost[$modelName];

            $modelData['owner_id']=$user_id;

            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $modelData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {


                if (!$createUpdate) {


                }
                $model->fill($attributesSet);
                $success = $model->save();

            } else {
                $success = false;
                $msj = "Problemas al guardar  SecretaryProcessesByCustomerPresentation.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $data = $model;
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "data" => $data,

                "success" => $success
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "data" => $data,
                "errors" => $errors
            );
            return ($result);
        }
    }


}
