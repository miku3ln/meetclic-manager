<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Lodging as Lodging;
use App\Models\LodgingByPaymentCreditCard as LodgingByPaymentCreditCard;
use App\Utils\Util;
class LodgingByPayment extends Model
{
    const wayToPayCash = 0;
    const wayToPayCashText = "Efectivo";

    const wayToPayCreditCards = 1;
    const wayToPayCreditCardsText = "Tarjetas de Credito";

    const wayToPayPaymentDocuments = 2;
    const wayToPayPaymentDocumentsText = "Documentos de Pago";
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lodging_by_payment';

    protected $fillable = array(
        "way_to_pay",//*
        "lodging_id",//*
    );
    public $attributesData = array(
        "way_to_pay",//*
        "lodging_id",//*
    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "way_to_pay" => 'required',
            "lodging_id" => 'required'
        ];
        return $rules;
    }

    public static function validateModel($modelAttributes)
    {
        $rules = LodgingByPayment::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getPayments($params)
    {


        $lodging_id = $params["lodging_id"];
        $query = DB::table($this->table);
        $compare = "IF($this->table.way_to_pay=" . self::wayToPayCash . ",'" . self::wayToPayCashText . "',IF($this->table.way_to_pay=" . self::wayToPayCreditCards . ",'" . self::wayToPayCreditCardsText . "',IF($this->table.way_to_pay=" . self::wayToPayPaymentDocuments . ",'" . self::wayToPayPaymentDocumentsText . "',2))) as way_to_pay_text";
        $selectString = "$this->table.id lodging_by_payment_id ,$this->table.lodging_id,$compare,$this->table.way_to_pay";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("lodging_id", '=', $lodging_id);
        $data = $query->get()->toArray();
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
            $lodgingByPaymentData = $lodgingData["LodgingByPayment"];
            foreach ($lodgingByPaymentData as $attributes) {

                $modelLBP = new LodgingByPayment();
                $attributesSet = array(
                    "way_to_pay" => $attributes["way_to_pay"],
                    "lodging_id" => $attributes["lodging_id"]
                );
                $validateResult = LodgingByPayment::validateModel($attributesSet);
                $success = $validateResult["success"];
                if (!$success) {
                    $msj = "Problemas al guardar LodgingByPayment Payment";
                    $errors = $validateResult["errors"];
                } else {
                    $modelLBP->fill($attributesSet);
                    $success = $modelLBP->save();
                    $lodging_by_payment_id = $modelLBP->id;
                    if (isset($attributes["LodgingByPaymentCreditCard"])) {
                        $lodgingByPaymentCreditCardData = $attributes["LodgingByPaymentCreditCard"];
                        foreach ($lodgingByPaymentCreditCardData as $attributesLBPCC) {
                            $modelLBPCC = new LodgingByPaymentCreditCard();
                            $attributesSet = array(
                                "type_credit_card" => $attributesLBPCC["type_credit_card"],
                                "lodging_by_payment_id" => $lodging_by_payment_id
                            );

                            $validateResult = LodgingByPaymentCreditCard::validateModel($attributesSet);
                            $success = $validateResult["success"];
                            if (!$success) {
                                $msj = "Problemas al guardar LodgingByPaymentCreditCard";
                                $errors = $validateResult["errors"];
                            } else {
                                $modelLBPCC->fill($attributesSet);
                                $success = $modelLBPCC->save();
                            }
                        }
                    }
                }
            }
            $modelL = Lodging::find($lodging_id);
            $modelL->payment_made = 1;

            $modelL->output_at = Util::DateCurrent();

            $success = $modelL->save();
            if ($success) {
                $msj = "Problemas al guardar LodgingByPaymentCreditCard";
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
