<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Redirect;

class BusinessByShippingRate extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_by_shipping_rate';

    protected $fillable = array(
        'shipping_rate_business_id',//*
        'business_id',//*
        'state'//*

    );
    protected $attributesData = [
        ['column' => 'shipping_rate_business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'state';

    public static function getRulesModel()
    {
        $rules = ["shipping_rate_business_id" => "required|numeric",
            "business_id" => "required|numeric",
            "state" => "required"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,shipping_rate_business.title as shipping_rate_business,
shipping_rate_business.id as shipping_rate_business_id,
business.title as business,
business.id as business_id,
$this->table.state";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('shipping_rate_business', 'shipping_rate_business.id', '=', $this->table . '.shipping_rate_business_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where("shipping_rate_business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');;

        }
        $query->where($this->table . ".business_id", '=', $business_id);

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
            $modelName = 'BusinessByShippingRate';
            $model = new BusinessByShippingRate();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessByShippingRate::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $businessByShippingRateData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessByShippingRateData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $business_id = $attributesSet['business_id'];
            $success = $validateResult["success"];
            if ($success) {

                if ($attributesSet['state'] == 'ACTIVE') {

                    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                        $idCurrent = $attributesPost[$modelName]["id"];

                        BusinessByShippingRate::where('state', 'ACTIVE')
                            ->where('business_id', '=', $business_id)
                            ->whereNotIn('id', [$idCurrent])
                            ->update(['state' => 'INACTIVE']);
                    } else {
                        BusinessByShippingRate::where('state', 'ACTIVE')
                            ->where('business_id', '=', $business_id)
                            ->update(['state' => 'INACTIVE']);
                    }
                }
                $model->fill($attributesSet);
                $success = $model->save();


            } else {
                $success = false;
                $msj = "Problemas al guardar  BusinessByShippingRate.";
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
        $query->join('shipping_rate_business', 'shipping_rate_business.id', '=', $this->table . '.shipping_rate_business_id');
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere("shipping_rate_business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

}
