<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BusinessByLodgingByPrice;


class LodgingTypeOfRoomByPrice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const STATUS_FREE = 'FREE';
    const STATUS_OCCUPIED = 'OCCUPIED';
    const STATUS_CLEANING = 'CLEANING';

    protected $table = 'lodging_type_of_room_by_price';

    protected $fillable = array(
        "lodging_type_of_room_id",//*
        "lodging_room_levels_id",//*
        "price",//*
        "status",
        "room_number",
        "name",
        "description",

    );
    public $attributesData = array(
        "lodging_type_of_room_id",//*
        "price",//*
        "status",
        "room_number",
        "lodging_room_levels_id",//*
        "name",
        "description",

    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "price" => 'required',
            "lodging_type_of_room_id" => 'required',
            "lodging_room_levels_id" => 'required',
            "room_number" => 'required',
            "name" => 'required',

        ];
        return $rules;
    }

    public function features()
    {
        return $this->belongsToMany(LodgingRoomFeatures::class, 'lodging_type_of_room_price_by_features', 'lodging_type_of_room_by_price_id', 'lodging_room_features_id');
    }

    public static function validateModel($modelAttributes)
    {
        $rules = LodgingTypeOfRoomByPrice::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getAdmin($params)
    {

        $result = $this->getAdminData($params);


        foreach ($result["rows"] as $key => $row) {
            $setPush = json_decode(json_encode($row), true);
            $result["rows"][$key] = $setPush;

                $lodging_type_of_room_by_price_id = $row->id;
                $model = LodgingTypeOfRoomByPrice::find($lodging_type_of_room_by_price_id);
                $features = $model->features->pluck('name', 'id')->toArray();
                $result["rows"][$key]['features'] = $features;


        }
        return $result;
    }

    public function getAdminData($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $business_id = $params["filters"]["business_id"];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.price ,$this->table.description  ,$this->table.name ,$this->table.room_number,$this->table.status,$this->table.lodging_type_of_room_id,$this->table.lodging_room_levels_id
       ,lodging_type_of_room.name lodging_type_of_room
       ,lodging_room_levels.name lodging_room_levels";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('lodging_type_of_room', 'lodging_type_of_room.id', '=', $this->table . '.lodging_type_of_room_id');
        $query->join('lodging_room_levels', 'lodging_room_levels.id', '=', $this->table . '.lodging_room_levels_id');
        $query->join('business_by_lodging_by_price', 'business_by_lodging_by_price.lodging_type_of_room_by_price_id', '=', $this->table . '.id');
        $conditions = array(
            array("business_by_lodging_by_price.business_id", "=", $business_id)
        );

        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $conditionsLike = array();
            array_push($conditionsLike, array('lodging_type_of_room.name', 'like', $likeSet));
            array_push($conditionsLike, array($this->table . '.room_number', 'like', $likeSet));
            $query
                ->when(array(
                    "conditions" => $conditions,
                    "conditionsOr" => $conditionsLike,
                    "likeSet" => $likeSet,
                    "tableCurrent" => $this->table
                ), function ($query, $params) {
                    $tableCurrent = $params["tableCurrent"];
                    $condition = $params["conditions"];
                    $conditionOr = $params["conditionsOr"];
                    $likeSet = $params["likeSet"];
                    $query->orWhere('lodging_type_of_room.name', 'like', $likeSet);
                    $query->orWhere($tableCurrent . '.room_number', 'like', $likeSet);
                    $query->orWhere('lodging_type_of_room.description', 'like', $likeSet);

                });


        }
        $query->where($conditions);
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

    public function getAdminReception($params)
    {

        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);
        $status = $params["filters"]["status"];
        $business_id = $params["filters"]["business_id"];
        $lodging_room_levels_id = isset($params["filters"]["lodging_room_levels_id"]["value"]) ? $params["filters"]["lodging_room_levels_id"]["value"] : $params["filters"]["lodging_room_levels_id"];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;

        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.price  ,$this->table.room_number,$this->table.status,$this->table.lodging_type_of_room_id
       ,lodging_type_of_room.name lodging_type_of_room
       ,business_by_lodging_by_price.business_id ";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('lodging_type_of_room', 'lodging_type_of_room.id', '=', $this->table . '.lodging_type_of_room_id');
        $query->join('business_by_lodging_by_price', 'business_by_lodging_by_price.lodging_type_of_room_by_price_id', '=', $this->table . '.id');
        $conditions = array(
            array("business_by_lodging_by_price.business_id", "=", $business_id),
            array($this->table . ".lodging_room_levels_id", "=", $lodging_room_levels_id)

        );
        if ($status != "ALL") {
            array_push($conditions, array($this->table . ".status", "=", $status));
        }
        if (isset($params['searchPhrase']) && $params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $conditionsLike = array();
            array_push($conditionsLike, array('lodging_type_of_room.name', 'like', $likeSet));
            array_push($conditionsLike, array($this->table . '.room_number', 'like', $likeSet));
            $query
                ->when(array(
                    "conditions" => $conditions,
                    "conditionsOr" => $conditionsLike,
                    "likeSet" => $likeSet,
                    "tableCurrent" => $this->table
                ), function ($query, $params) {
                    $tableCurrent = $params["tableCurrent"];
                    $condition = $params["conditions"];
                    $conditionOr = $params["conditionsOr"];
                    $likeSet = $params["likeSet"];
                    $query->orWhere('lodging_type_of_room.name', 'like', $likeSet);
                    $query->orWhere($tableCurrent . '.room_number', 'like', $likeSet);
                    $query->orWhere('lodging_type_of_room.description', 'like', $likeSet);

                });


        }

        $query->where($conditions);
        $recordsTotal = $query->get()->count();

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

            $model = new LodgingTypeOfRoomByPrice();
            $createUpdate = true;
            if (isset($attributesPost["LodgingTypeOfRoomByPrice"]["id"]) && $attributesPost["LodgingTypeOfRoomByPrice"]["id"] != "null" && $attributesPost["LodgingTypeOfRoomByPrice"]["id"] != "-1") {
                $model = LodgingTypeOfRoomByPrice::find($attributesPost["LodgingTypeOfRoomByPrice"]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $lodgingData = $attributesPost["LodgingTypeOfRoomByPrice"];
            $business_id = $lodgingData["business_id"];

            $attributesSet = array(
                "price" => $lodgingData["price"],
                "room_number" => $lodgingData["room_number"],
                "name" => $lodgingData["name"],
                "description" => isset($lodgingData["description"]) ? $lodgingData["description"] : "",
                "lodging_type_of_room_id" => $lodgingData["lodging_type_of_room_id"],
                "lodging_room_levels_id" => $lodgingData["lodging_room_levels_id"],

            );
            $validateResult = self::validateModel($attributesSet);

            $success = $validateResult["success"];
            if ($success) {

                $model->fill($attributesSet);
                if ($createUpdate) {
                    $model->status = "FREE";
                }
                $success = $model->save();
                if ($success) {
                    $relations_ids = $lodgingData['features_id_data'];
                    $model->features()->sync($relations_ids);
                    $lodging_type_of_room_by_price_id = $model->id;
                    $attributesSet = array(
                        "business_id" => $business_id,
                        "lodging_type_of_room_by_price_id" => $lodging_type_of_room_by_price_id,

                    );

                    $validateResult = BusinessByLodgingByPrice::validateModel($attributesSet);
                    $success = $validateResult["success"];
                    if ($success) {
                        if ($createUpdate) {
                            $modelBBLBP = new BusinessByLodgingByPrice();
                            $modelBBLBP->fill($attributesSet);
                            $success = $modelBBLBP->save();


                        }

                    } else {
                        $success = false;
                        $msj = "Problemas al guardar BusinessByLodgingByPrice.";
                        $errors = $validateResult["errors"];
                    }
                } else {
                    $success = false;
                    $msj = "Problemas al guardar LodgingTypeOfRoomByPrice.";
                    $errors = $validateResult["errors"];
                }

            } else {
                $success = false;
                $msj = "Problemas al guardar LodgingTypeOfRoomByPrice.";
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

    public function saveDataReception($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {

            $model = null;
            $createUpdate = true;
            if (isset($attributesPost["LodgingTypeOfRoomByPrice"]["id"]) && $attributesPost["LodgingTypeOfRoomByPrice"]["id"] != "null" && $attributesPost["LodgingTypeOfRoomByPrice"]["id"] != "-1") {
                $model = LodgingTypeOfRoomByPrice::find($attributesPost["LodgingTypeOfRoomByPrice"]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $lodgingData = $attributesPost["LodgingTypeOfRoomByPrice"];
            $model->status = $lodgingData["status"];
            $success = $model->save();
            if ($success) {

            } else {
                $success = false;
                $msj = "Problemas al guardar LodgingTypeOfRoomByPrice.";
                $errors = array();
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
}
