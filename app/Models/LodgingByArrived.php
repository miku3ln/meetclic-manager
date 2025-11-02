<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


use App\Models\LodgingArrivedBySocialNetworks as LodgingArrivedBySocialNetworks;
use App\Models\LodgingByReasons as LodgingByReasons;

class LodgingByArrived extends Model
{
    const wayToContactNetworkSocial = 0;
    const wayToContactNetworkSocialText = "Redes Sociales";

    const wayToContactNewsPaper = 1;
    const wayToContactNewsPaperText = "Periodicos";

    const wayToContactRecommendations = 2;
    const wayToContactRecommendationsText = "Recomendaciones";

    const wayToContactOthers = 3;
    const wayToContactOthersText = "Otros";
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lodging_by_arrived';

    protected $fillable = array(
        "way_to_contact",//*
        "lodging_id",//*
    );
    public $attributesData = array(
        "way_to_contact",//*
        "lodging_id",//*
    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "way_to_contact" => 'required',
            "lodging_id" => 'required'
        ];
        return $rules;
    }

    public static function validateModel($modelAttributes)
    {
        $rules = LodgingByArrived::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getArrived($params)
    {


        $lodging_id = $params["lodging_id"];
        $query = DB::table($this->table);
        $compare = "IF($this->table.way_to_contact=" . self::wayToContactNetworkSocial . ",'" . self::wayToContactNetworkSocialText . "',IF($this->table.way_to_contact=" . self::wayToContactNewsPaper . ",'" . self::wayToContactNewsPaperText . "',IF($this->table.way_to_contact=" . self::wayToContactRecommendations . ",'" . self::wayToContactRecommendationsText . "',IF($this->table.way_to_contact=" . self::wayToContactOthers . ",'" . self::wayToContactOthersText . "','Sin Cualificar')))) as way_to_contact_text";
        $selectString = "$this->table.id lodging_by_arrived_id ,$this->table.lodging_id,$compare,$this->table.way_to_contact";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("lodging_id", '=', $lodging_id);
        $data = $query->get()->first();
        return $data;
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
            $lodgingByPaymentData = $lodgingData["LodgingByArrived"];

            foreach ($lodgingByPaymentData as $attributes) {

                $modelLBA = new LodgingByArrived();
                $attributesSet = array(
                    "way_to_contact" => $attributes["way_to_contact"],
                    "lodging_id" => $lodging_id
                );
                $validateResult = LodgingByArrived::validateModel($attributesSet);
                $success = $validateResult["success"];

                if (!$success) {
                    $msj = "Problemas al guardar LodgingByArrived Payment";
                    $errors = $validateResult["errors"];
                } else {

                    $modelLBA->fill($attributesSet);
                    $success = $modelLBA->save();
                    $lodging_by_payment_id = $modelLBA->id;

                    $msj = "Save LodgingByArrived";
                    $modelLBR = new LodgingByReasons();
                    $attributesSet = array(
                        "reason" => $attributes["type_reasons"],
                        "lodging_id" => $lodging_id
                    );

                    $validateResult = LodgingByReasons::validateModel($attributesSet);
                    $success = $validateResult["success"];
                    if (!$success) {
                        $msj = "Problemas al guardar Arrived Reasons";
                        $errors = $validateResult["errors"];
                    } else {
                        $modelLBR->fill($attributesSet);
                        $success = $modelLBR->save();
                    }


                    if (isset($attributes["LodgingArrivedBySocialNetworks"])) {
                        $lodgingArrivedBySocialNetworks = $attributes["LodgingArrivedBySocialNetworks"];
                        foreach ($lodgingArrivedBySocialNetworks as $attributesLBPCC) {
                            $modelLBSN = new LodgingArrivedBySocialNetworks();
                            $attributesSet = array(
                                "type_social_networks" => $attributesLBPCC["type_social_networks"],
                                "lodging_by_arrived_id" => $lodging_by_payment_id
                            );

                            $validateResult = LodgingArrivedBySocialNetworks::validateModel($attributesSet);
                            $success = $validateResult["success"];
                            if (!$success) {
                                $msj = "Problemas al guardar LodgingArrivedBySocialNetworks";
                                $errors = $validateResult["errors"];
                            } else {
                                $modelLBSN->fill($attributesSet);
                                $success = $modelLBSN->save();
                                $msj = "Save LodgingArrivedBySocialNetworks";
                            }
                        }
                    }
                }
            }

            $modelL = Lodging::find($lodging_id);
            $modelL->arrived_made = 1;
            $success = $modelL->save();

            if (!$success) {
                $msj = "Problemas al guardar Lodging";

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
