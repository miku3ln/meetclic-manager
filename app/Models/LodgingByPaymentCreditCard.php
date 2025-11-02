<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class LodgingByPaymentCreditCard extends Model
{
    const typeCreditCardDiners = 0;
    const typeCreditCardDinersText = "Diners";

    const typeCreditCardCreditVisa = 1;
    const typeCreditCardCreditVisaText = "Visa";

    const typeCreditCardPaymentMasterCard = 2;
    const typeCreditCardPaymentMasterCardText = "Master Card";

    const typeCreditCardPaymentOthers = 3;
    const typeCreditCardPaymentOthersText = "Otras";
    protected $table = 'lodging_by_payment_credit_card';

    protected $fillable = array(
        "type_credit_card",//*
        "lodging_by_payment_id",//*
    );
    public $attributesData = array(
        "type_credit_card",//*
        "lodging_by_payment_id",//*
    );
    public $timestamps = false;
    public static function getRulesModel()
    {
        $rules = [
            "type_credit_card" => 'required',
            "lodging_by_payment_id" => 'required'
        ];
        return $rules;
    }
    public static function validateModel($modelAttributes)
    {
        $rules = LodgingByPaymentCreditCard::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getPaymentsOfCreditCards($params)
    {


        $lodging_by_payment_id = $params["lodging_by_payment_id"];
        $query = DB::table($this->table);
        $compare = "IF($this->table.type_credit_card=" . self::typeCreditCardDiners . ",'" . self::typeCreditCardDinersText . "',IF($this->table.type_credit_card=" . self::typeCreditCardCreditVisa . ",'" . self::typeCreditCardCreditVisaText . "',IF($this->table.type_credit_card=" . self::typeCreditCardPaymentMasterCard . ",'" . self::typeCreditCardPaymentMasterCardText . "',IF($this->table.type_credit_card=" . self::typeCreditCardPaymentOthers . ",'" . self::typeCreditCardPaymentOthersText . "',2)))) as type_credit_card_text";
        $selectString = "$this->table.id lodging_by_payment_credit_card_id ,$this->table.lodging_by_payment_id,$compare,$this->table.type_credit_card";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("lodging_by_payment_id", '=', $lodging_by_payment_id);
        $data = $query->get()->toArray();
        return $data;
    }

}
