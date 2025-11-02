<?php

namespace App\Models;
namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ModelManager;
class DeliveryByBusinessManager extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    const STATE_DELIVERED= 'DELIVERED';
    const STATE_CANCELLED= 'CANCELLED';
    const STATE_DELETED= 'DELETED';

    const STATE_INITIALIZED = 'INITIALIZED';
    protected $table = 'delivery_by_business_manager';
    const MAIN = 1;
    const NOT_MAIN = 0;

    const ENTITY_TYPE_CUSTOMER = 0;
    protected $fillable = array(
        'customer_id',
        'number_box',
        'description',
        'address_id',
        'phone_id',
        'status',
        'user_id',
        'number_invoice',
        'created_at',
        'updated_at',
        'business_id',
    );
    protected $attributesData = [
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'number_box', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => 'None description', 'required' => 'true'],
        ['column' => 'address_id', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'phone_id', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'INITIALIZED', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'number_invoice', 'type' => 'string', 'defaultValue' => '0001', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'true'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
    ];
    public $timestamps = false;

    protected $field_main = 'number_box';


    public static function getRulesModel()
    {
        $rules = [

            "customer_id" => "required|numeric",
            "number_box" => "required|numeric",
            "description" => "required",
            "address_id" => "required|numeric",
            "phone_id" => "required|numeric",
            "status" => "required",
            "user_id" => "required",
            "number_invoice" => "required|max:300",
            "business_id" => "required|numeric"];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'desc';
        $field = 'id';
        $query = DB::table($this->table);
        $entity_id = isset($params['filters']['entity_id']) ? $params['filters']['entity_id'] : null;

        $entity_manager_id = isset($params['filters']['entity_manager_id']) ? $params['filters']['entity_manager_id'] : null;


        if (isset($params['sort'])) {
            /*    $field = $column = array_keys($params['sort']);
                $field = $field[0];
                $sort = $params['sort'][$column[0]];*/
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.customer_id,$this->table.number_box,$this->table.description,$this->table.address_id,$this->table.phone_id,$this->table.status,$this->table.user_id,$this->table.number_invoice,$this->table.created_at,$this->table.updated_at,$this->table.business_id
        ,customer.identification_document customer_identification_document,customer.people_type_identification_id customer_people_type_identification_id ,customer.people_id customer_people_id ,customer.business_name customer_business_name,customer.business_reason customer_business_reason ,customer.ruc_type_id customer_ruc_type_id  ,customer.has_representative customer_has_representative,customer.representative_fullname customer_representative_fullname
,people.id people_id,people.last_name people_last_name,people.name people_name,people.birthdate people_birthdate,people.gender people_gender
, information_phone.id information_phone_id, information_phone.value information_phone_value,information_phone.state information_phone_state,information_phone.entity_id information_phone_entity_id,information_phone.main information_phone_main,information_phone.entity_type information_phone_entity_type,information_phone.information_phone_operator_id information_phone_information_phone_operator_id ,information_phone.information_phone_type_id information_phone_information_phone_type_id
,information_phone_operator.id information_phone_operator_id,information_phone_operator.value information_phone_operator_value
 ,information_phone_type.id information_phone_type_id,information_phone_type.value information_phone_type_value
 ,information_address.id information_address_id,information_address.street_one information_address_street_one,information_address.street_two information_address_street_two,information_address.reference information_address_reference,information_address.information_address_type_id information_address_information_address_type_id
 ,information_address_type.id information_address_type_id,information_address_type.value information_address_type_value";

        if ($entity_id != null ) {

            $query->where(
                $this->table . '.customer_id', '=', $entity_id
            );

        }
        if ($entity_manager_id != null ) {

          $query->where(
                $this->table . '.business_id', '=', $entity_manager_id
            );

        }
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('information_phone', 'information_phone.id', '=', $this->table . '.phone_id');
        $query->join('information_phone_operator', 'information_phone_operator.id', '=', 'information_phone.information_phone_operator_id');
        $query->join('information_phone_type', 'information_phone_type.id', '=',  'information_phone.information_phone_type_id');

        $query->join('customer', 'customer.id', '=', $this->table . '.customer_id');
        $query->join('people', 'people.id', '=', 'customer.people_id');

        $query->join('information_address', 'information_address.id', '=', $this->table . '.address_id');
        $query->join('information_address_type', 'information_address_type.id', '=', 'information_address.information_address_type_id');

        if ($params['searchPhrase'] != null && $params['searchPhrase'] !="") {

            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.number_box', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.number_invoice', 'like', '%' . $likeSet . '%');
                $query->orWhere("information_phone_operator.value", 'like', '%' . $likeSet . '%');
                $query->orWhere("information_phone_type.value", 'like', '%' . $likeSet . '%');;
                $query->orWhere("customer.identification_document", 'like', '%' . $likeSet . '%');
                $query->orWhere("people.last_name", 'like', '%' . $likeSet . '%');
                $query->orWhere("people.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("information_address.street_one", 'like', '%' . $likeSet . '%');
                $query->orWhere("information_address.street_two", 'like', '%' . $likeSet . '%');
            });
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
        $data=null;
        DB::beginTransaction();
        try {
            $modelName = 'DeliveryByBusinessManager';
            $model = new DeliveryByBusinessManager();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = DeliveryByBusinessManager::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $modelData = $attributesPost[$modelName];
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
                $msj = "Problemas al guardar  DeliveryByBusinessManager.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $data=$model;
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "data"=>$data,

                "success" => $success
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "data"=>$data,
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
        $query->join('information_phone_operator', 'information_phone_operator.id', '=', $this->table . '.information_phone_operator_id');
        $query->join('information_phone_type', 'information_phone_type.id', '=', $this->table . '.information_phone_type_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];

            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere("information_phone_operator.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("information_phone_type.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
