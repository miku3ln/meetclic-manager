<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\LodgingTypeOfRoomByPrice as LodgingTypeOfRoomByPrice;
class LodgingByTypeOfRoom extends Model
{

    protected $table = 'lodging_by_type_of_room';

    protected $fillable = array(
        "lodging_id",//*
        "lodging_type_of_room_by_price_id"//*
    );
    public $attributesData = array(
        "lodging_id",//*
        "lodging_type_of_room_by_price_id"//*
    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "lodging_id" => 'required',
            "lodging_type_of_room_by_price_id" => 'required'
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

    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $lodging_id = $attributesPost["lodging_id"];

        $errors = array();
        DB::beginTransaction();
        try {

            $lodgingData = $attributesPost;
            //PAYMENT
            $lodgingByTypeOfRoom = $lodgingData["LodgingByTypeOfRoom"];
            foreach ($lodgingByTypeOfRoom as $attributes) {

                $modelLBTOR = new LodgingByTypeOfRoom();
                $lodging_type_of_room_by_price = $attributes["lodging_type_of_room_by_price_id"];
                $attributesSet = array(
                    "lodging_type_of_room_by_price_id" => $lodging_type_of_room_by_price,
                    "lodging_id" => $lodging_id
                );

                $validateResult = LodgingByTypeOfRoom::validateModel($attributesSet);
                $success = $validateResult["success"];
                if (!$success) {
                    $msj = "Problemas al guardar LodgingByTypeOfRoom ";
                    $errors = $validateResult["errors"];
                } else {
                    $modelLBTOR->fill($attributesSet);
                    $success = $modelLBTOR->save();
                    
                    $modelLTORBP = LodgingTypeOfRoomByPrice::find($lodging_type_of_room_by_price);
                    $modelLTORBP->status = LodgingTypeOfRoomByPrice::STATUS_OCCUPIED;
                    $success = $modelLTORBP->save();
                    if (!$success) {
                        $msj = "Problemas al Actualizar estado Room";
                        $errors = array();
                        break;
                    }

                }
            }

            $modelL = Lodging::find($lodging_id);
            $modelL->rooms_add_made = 1;
            $success = $modelL->save();
            if ($success) {
                $msj = "Problemas al guardar Estado Cuartos Asignados";
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

    public function getRooms($params)
    {


        $lodging_id = $params["lodging_id"];
        $query = DB::table($this->table);
        $selectString = "$this->table.id lodging_by_type_of_room_id ,$this->table.lodging_id,$this->table.lodging_type_of_room_by_price_id
        ,lodging_type_of_room_by_price.price,lodging_type_of_room_by_price.room_number
        ,lodging_type_of_room.name";
        $select = DB::raw($selectString);
        $query->select($select)
            ->join('lodging_type_of_room_by_price', $this->table . '.lodging_type_of_room_by_price_id', '=', 'lodging_type_of_room_by_price.id')
            ->join('lodging_type_of_room', 'lodging_type_of_room_by_price.lodging_type_of_room_id', '=', 'lodging_type_of_room.id');

        $query->where("lodging_id", '=', $lodging_id);
        $data = $query->get()->toArray();
        return $data;
    }
}
