<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class LodgingRoomFeatures extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    protected $table = 'lodging_room_features';

    protected $fillable = array(
        "name",//*
        "description",
        "created_at",
        "updated_at",
        "deleted_at",
        "status",//*
        "business_id"

    );
    public $attributesData = array(
        "name",//*
        "description",
        "created_at",
        "updated_at",
        "deleted_at",
        "status",//*,
        "business_id"
    );
    public $timestamps = true;
    public function features()
    {
        return $this->belongsToMany(LodgingTypeOfRoomByPrice::class, 'lodging_type_of_room_price_by_features', 'lodging_room_features_id', 'lodging_type_of_room_by_price_id');
    }
    public static function getRulesModel()
    {
        $rules = [
            "name" => 'required',
            "business_id" => 'required',

        ];
        return $rules;
    }

    public static function validateModel($modelAttributes)
    {
        $rules = self::getRulesModel();
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
        $selectString = "$this->table.id ,$this->table.name  ,$this->table.description,$this->table.status,$this->table.business_id
        ";

        $select = DB::raw($selectString);
        $query->select($select);

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query
                ->orWhere($this->table . '.name', 'like', $likeSet)
                ->orWhere($this->table . '.description', 'like', $likeSet);
        }
        $query->where($this->table . '.business_id', '=', $business_id);

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
        $dataCatalogue = array();

        DB::beginTransaction();
        try {

            $model = new LodgingRoomFeatures();
            $createUpdate = true;
            if (isset($attributesPost["LodgingRoomFeatures"]["id"]) && $attributesPost["LodgingRoomFeatures"]["id"] != "null" && $attributesPost["LodgingRoomFeatures"]["id"] != "-1") {
                $model = LodgingRoomFeatures::find($attributesPost["LodgingRoomFeatures"]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $lodgingData = $attributesPost["LodgingRoomFeatures"];
            $attributesSet = array(
                "name" => $lodgingData["name"],
                "description" => $lodgingData["description"],
                "business_id" => $lodgingData["business_id"],

            );
            $business_id = $lodgingData["business_id"];
            $validateResult = LodgingRoomFeatures::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {

                $model->fill($attributesSet);
                $success = $model->save();

                $LodgingRoomFeatures = self::getDataListAll(array("business_id" => $business_id));

                $dataCatalogue = array(

                    "LodgingRoomFeatures" => $LodgingRoomFeatures,

                );
            } else {
                $success = false;
                $msj = "Problemas al guardar LodgingRoomFeatures.";
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
                "dataCatalogue" => $dataCatalogue
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

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name as text ";
        $business_id = $params['filters']['business_id'];
        $select = DB::raw($selectString);
        $query->select($select);

        $query->where('business_id', '=', $business_id);
        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->orWhere('name', 'like', '%' . $like . '%');
        }

        $query->limit(10)->orderBy('name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getDataListAll($params)
    {
        $business_id = $params["business_id"];

        $query = DB::table($this->table);
        $selectString = "$this->table.id value ,$this->table.name text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . ".business_id", "=", $business_id);
        $query->orderBy("$this->table.name", "asc");
        $result = $query->get()->toArray();

        return $result;
    }
}
