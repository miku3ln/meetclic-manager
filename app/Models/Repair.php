<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\RepairByDetailsParts;
use App\Models\BussinessByRepair;


class Repair extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'repair';

    protected $fillable = array(
        'created_at',
        'updated_at',
        'deleted_at',
        'register_manager_date',//*
        'description',//*
        'customer_id',//*
        'value_taxes',//*
        'subtotal',//*
        'discount_value',//*
        'user_id',//*
        'observations_fix',
        'status',//*
        'advance',//*
        'total',//*
        'delivery_date'//*

    );
    protected $attributesData = [
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'register_manager_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'customer_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'value_taxes', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'subtotal', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'discount_value', 'type' => 'string', 'defaultValue' => '0.0000', 'required' => 'true'],
        ['column' => 'user_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'observations_fix', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'IN OBSERVATION', 'required' => 'true'],
        ['column' => 'advance', 'type' => 'string', 'defaultValue' => '0.0000', 'required' => 'true'],
        ['column' => 'total', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'delivery_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = true;

    protected $field_main = 'register_manager_date';

    public static function getRulesModel()
    {
        $rules = ["register_manager_date" => "required",
            "description" => "required",
            "customer_id" => "required|numeric",
            "value_taxes" => "required|numeric",
            "subtotal" => "required|numeric",
            "discount_value" => "required|numeric",
            "user_id" => "required|numeric",
            "status" => "required",
            "advance" => "required|numeric",
            "total" => "required|numeric",
            "delivery_date" => "required"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $result = $this->getAdminManager($params);
        $modelRBDP = new RepairByDetailsParts();

        foreach ($result['rows'] as $key => $row) {
            $detailsParts = $modelRBDP->getDetailsParts([
                'filters' => [
                    'repair_id' => $row->id]
            ]);
            $rowCurrent = (array)$row;
            $result['rows'][$key] = $rowCurrent;
            $result['rows'][$key]['detailsParts'] = $detailsParts;

        }
        return $result;
    }

    public function getAdminManager($params)
    {
        $sort = 'desc';
        $field = 'register_manager_date';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $status = isset($params['filters']['status']) ? ($params['filters']['status'] == 'ALL' ? null : $params['filters']['status']) : null;
        $business_id = ($params['filters']['business_id']);

        $selectString = "$this->table.id,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.register_manager_date,$this->table.description,$this->table.customer_id,$this->table.value_taxes,$this->table.subtotal,$this->table.discount_value,$this->table.user_id,$this->table.observations_fix,$this->table.status,$this->table.advance,$this->table.total,$this->table.delivery_date
        ,customer.identification_document,customer.people_type_identification_id,customer.people_id,customer.business_name,customer.business_reason,customer.ruc_type_id
        ,people.last_name,people.name,people.gender";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer', 'repair.customer_id', 'customer.id');
        $query->join('people', 'customer.people_id', 'people.id');
        $query->join('bussiness_by_repair', 'repair.id', 'bussiness_by_repair.repair_id');
        $query->where('bussiness_by_repair.business_id', '=', $business_id);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.observations_fix', 'like', '%' . $likeSet . '%');

        }
        if ($status) {
            $query->where($this->table . '.status', '=', $status);
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

        $dataManager = [];
        try {
            $user = Auth::user();
            $modelName = 'Repair';
            $model = new Repair();
            $createUpdate = true;
            $business_id = $attributesPost[$modelName]["business_id"];
            $filtersGrid = $attributesPost[$modelName]["filtersGrid"];
            $status = $filtersGrid['status'];
            $RepairByDetailsParts = $attributesPost[$modelName]["RepairByDetailsParts"];
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = Repair::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }

            $repairData = $attributesPost[$modelName];
            $repairData['user_id'] = $user->id;
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $repairData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $repair_id = $model->id;
                if ($createUpdate) {
                    $modelData = [
                        'repair_id' => $repair_id,
                        'business_id' => $business_id
                    ];

                    $modelCurrent = new BussinessByRepair();
                    $validateResultCurrent = $modelCurrent->validateModel([
                        'inputs' => $modelData,
                        'rules' => $modelCurrent::getRulesModel(),
                    ]);

                    $success = $validateResultCurrent["success"];
                    if (!$success) {
                        $success = false;
                        $msj = "Problemas al guardar  a la Empresa.";
                        $errors = $validateResultCurrent["errors"];
                    } else {
                        $modelCurrent->fill($modelData);
                        $success = $modelCurrent->save();
                    }

                    foreach ($RepairByDetailsParts as $key => $row) {
                        $modelData = $row;
                        $modelData['repair_id'] = $repair_id;
                        $modelRBDP = new RepairByDetailsParts();
                        $validateResultCurrent = $modelRBDP->validateModel([
                            'inputs' => $modelData,
                            'rules' => $modelRBDP::getRulesModel(),
                        ]);
                        $success = $validateResultCurrent["success"];
                        if (!$success) {
                            $success = false;
                            $msj = "Problemas al guardar  Parts.";
                            $errors = $validateResultCurrent["errors"];
                            break;
                        } else {
                            $modelRBDP->fill($modelData);
                            $success = $modelRBDP->save();
                        }
                    }
                } else {

                }

            } else {
                $success = false;
                $msj = "Problemas al guardar  Repair.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
                $dataManager['filtersGrid'] = $this->getResults(['filters' => ['business_id' => $business_id, 'status' => $status]]);
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'data' => $dataManager
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            ,
                'data' => $dataManager
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
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.created_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.updated_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.deleted_at', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.register_manager_date', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.customer_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value_taxes', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtotal', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.discount_value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.user_id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.observations_fix', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.status', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.advance', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.total', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.delivery_date', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getResults($params)
    {

        $query = DB::table($this->table);
        $status = isset($params['filters']['status']) ? ($params['filters']['status'] == 'ALL' ? null : $params['filters']['status']) : null;
        $business_id = ($params['filters']['business_id']);

        $selectString = "$this->table.id,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.register_manager_date,$this->table.description,$this->table.customer_id,$this->table.value_taxes,$this->table.subtotal,$this->table.discount_value,$this->table.user_id,$this->table.observations_fix,$this->table.status,$this->table.advance,$this->table.total,$this->table.delivery_date
        ,customer.identification_document,customer.people_type_identification_id,customer.people_id,customer.business_name,customer.business_reason,customer.ruc_type_id
        ,people.last_name,people.name,people.gender";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('customer', 'repair.customer_id', 'customer.id');
        $query->join('people', 'customer.people_id', 'people.id');
        $query->join('bussiness_by_repair', 'repair.id', 'bussiness_by_repair.repair_id');
        $query->where('bussiness_by_repair.business_id', '=', $business_id);
        if ($status) {
            $query->where($this->table . '.status', '=', $status);
        }

        $result = $query->get()->toArray();
        return $result;
    }
}
