<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;


class ProductDetailsShippingFee extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_details_shipping_fee';

    protected $fillable = array(

        "height",
        "length",
        "width",
        "weight",
        'product_id'//*

    );
    protected $attributesData = [
        ['column' => 'height', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'length', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'width', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'weight', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'width';

    public static function getRulesModel()
    {
        $rules = [
            "width" => "required|numeric",
            "height" => "required|numeric",
            "length" => "required|numeric",
            "weight" => "required|numeric",
            "product_id" => "required|numeric"
        ];
        return $rules;
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
            $modelName = 'ProductDetailsShippingFee';
            $model = new ProductDetailsShippingFee();
            $createUpdate = true;
            $modelInventory = null;
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = ProductDetailsShippingFee::find($attributesPost['id']);
                $createUpdate = false;

            } else {
                $createUpdate = true;

            }


            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];

            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();

            } else {
                $success = false;
                $msj = "Problemas al guardar  ProductDetailsShippingFee.";
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

}
