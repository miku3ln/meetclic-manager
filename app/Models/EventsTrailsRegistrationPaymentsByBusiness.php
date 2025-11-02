<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;


class EventsTrailsRegistrationPaymentsByBusiness extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'events_trails_registration_payments_by_business';

    protected $fillable = array(
        'events_trails_registration_points_id',//*
        'order_shopping_cart_id'//*

    );
    protected $attributesData = [
        ['column' => 'events_trails_registration_points_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'order_shopping_cart_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["events_trails_registration_points_id" => "required|numeric",
            "order_shopping_cart_id" => "required|numeric"
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

        $selectString = "$this->table.id,events_trails_registration_points.status as events_trails_registration_points,
events_trails_registration_points.id as events_trails_registration_points_id,
order_shopping_cart.state as order_shopping_cart,
order_shopping_cart.id as order_shopping_cart_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_registration_points', 'events_trails_registration_points.id', '=', $this->table . '.events_trails_registration_points_id');
        $query->join('order_shopping_cart', 'order_shopping_cart.id', '=', $this->table . '.order_shopping_cart_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_registration_points.status", 'like', '%' . $likeSet . '%');
                $query->orWhere("order_shopping_cart.state", 'like', '%' . $likeSet . '%');
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
            $modelName = 'EventsTrailsRegistrationPaymentsByBusiness';
            $model = new EventsTrailsRegistrationPaymentsByBusiness();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = EventsTrailsRegistrationPaymentsByBusiness::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $eventsTrailsRegistrationPaymentsByBusinessData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $eventsTrailsRegistrationPaymentsByBusinessData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  EventsTrailsRegistrationPaymentsByBusiness.";
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


        $query->join('events_trails_registration_points', 'events_trails_registration_points.id', '=', $this->table . '.events_trails_registration_points_id');
        $query->join('order_shopping_cart', 'order_shopping_cart.id', '=', $this->table . '.order_shopping_cart_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("events_trails_registration_points.status", 'like', '%' . $likeSet . '%');
                $query->orWhere("order_shopping_cart.state", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getSumCurrentPointEvent($params)
    {
        $events_trails_registration_points_id = $params['filters']['events_trails_registration_points_id'];
        $query = DB::table($this->table);
        $selectString = "order_shopping_cart.subtotal,order_shopping_cart.id order_shopping_cart_id";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('events_trails_registration_points', 'events_trails_registration_points.id', '=', $this->table . '.events_trails_registration_points_id');
        $query->join('order_shopping_cart', 'order_shopping_cart.id', '=', $this->table . '.order_shopping_cart_id');
        $query->where($this->table . '.events_trails_registration_points_id', '=', $events_trails_registration_points_id);
        $result = $query->get()->toArray();
        return $result;

    }

    public function getDataPaymentsManagement($params)
    {
        $data = $this->getSumCurrentPointEvent($params);
        $total = 0;
        foreach ($data as $key => $row) {
            $total += $row->subtotal;
        }
        $result = [
            'success' => true,
            'data' => [
                'data' => $data,
                'total' => $total
            ]
        ];
        return $result;
    }
}
