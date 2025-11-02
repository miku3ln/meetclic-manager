<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class BusinessByLodgingByPrice extends Model
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

    protected $table = 'business_by_lodging_by_price';

    protected $fillable = array(
        "lodging_type_of_room_by_price_id",//*
        "business_id"//*
    );
    public $attributesData = array(
        "lodging_type_of_room_by_price_id",//*
        "business_id"//*
    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "lodging_type_of_room_by_price_id" => 'required',
            "business_id" => 'required',
        ];
        return $rules;
    }

    public static function validateModel($modelAttributes)
    {
        $rules = BusinessByLodgingByPrice::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getListRooms($params)
    {

        $business_id = $params["business_id"];
        $searchPhrase = isset($params["searchPhrase"]) ? $params["search"] : null;

        $selectString = "t.id,t.business_id,t.lodging_type_of_room_by_price_id
,ltorbp.lodging_type_of_room_id,ltorbp.price,ltorbp.room_number,ltorbp.status
,ltor.name,ltor.description
,lbtor.lodging_id";

        $select = DB::raw($selectString);
        $query = DB::table($this->table . " t")
            ->select($select)
            ->join('lodging_type_of_room_by_price ltorbp', $this->table . '.lodging_type_of_room_by_price_id', '=', 'ltorbp.id')
            ->leftJoin('lodging_by_type_of_room lbtor', $this->table . '.lodging_type_of_room_by_price_id', '=', 'ltorbp.id')
            ->join('lodging_type_of_room ltor', 'ltorbp.lodging_type_of_room_id', '=', 'ltor.id');
        $query->where("business_id", $business_id);
        if ($searchPhrase != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->orWhere('ltor.name', 'like', $likeSet)
                ->orWhere('ltor.description', 'like', $likeSet)
                ->orWhere('ltorbp.price', 'like', $likeSet);
        }

        return $query->get()->toArray();
    }

    public function getRoomsDataByBusiness($params)
    {

        $business_id = $params["business_id"];
        $selectString = "t.id,t.business_id,t.lodging_type_of_room_by_price_id
,ltorbp.lodging_type_of_room_id,ltorbp.price,ltorbp.room_number,ltorbp.status
,ltor.name,ltor.description";

        $select = DB::raw($selectString);
        $query = DB::table($this->table . " as t")
            ->select($select, "t.id as manager_id")
            ->join('lodging_type_of_room_by_price as ltorbp', 't.lodging_type_of_room_by_price_id', '=', 'ltorbp.id')
            ->join('lodging_type_of_room as ltor', 'ltorbp.lodging_type_of_room_id', '=', 'ltor.id');
        $query->where("t.business_id", $business_id);
        return $query->get()->toArray();

    }

}
