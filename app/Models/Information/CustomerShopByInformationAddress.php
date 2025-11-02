<?php


namespace App\Models\Information;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ModelManager;
class CustomerShopByInformationAddress extends ModelManager
{


    protected $table = 'customer_shop_by_information_address';
    protected $fillable = array(
        'courtesy_title',
        'courtesy_name',
        'information_address_id'
    );
    protected $attributesData = [
        ['column' => 'courtesy_title', 'type' => 'string', 'defaultValue' => 'None description', 'required' => 'true'],
        ['column' => 'courtesy_name', 'type' => 'string', 'defaultValue' => 'None description', 'required' => 'true'],
        ['column' => 'information_address_id', 'type' => 'string', 'defaultValue' => 'None description', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'courtesy_title';


    public static function getRulesModel()
    {
        $rules = [

            "courtesy_title" => "required|numeric",
            "courtesy_name" => "required|max:300",
            "information_address_id" => "required"];
        return $rules;
    }


    /*MANAGER MAINS*/




    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data=null;
        DB::beginTransaction();
        try {
            $modelName = 'CustomerShopByInformationAddress';
            $model = new CustomerShopByInformationAddress();
            $createUpdate = true;
            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = CustomerShopByInformationAddress::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }

            $modelData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $modelData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {


                if (!$createUpdate) {


                }
                $model->fill($attributesSet);
                $success = $model->save();

            } else {
                $success = false;
                $msj = "Problemas al guardar  CustomerShopByInformationAddress.";
                $errors = $validateResult["errors"];
            }
            if (!$success) {
                DB::rollBack();

            } else {
                $data=$model;
                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "data"=>$data,
                "success" => $success
            ];

            return ($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "data"=>$data,
                "errors" => $errors
            );
            return ($result);
        }
    }



}
