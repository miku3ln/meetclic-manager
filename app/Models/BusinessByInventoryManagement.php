<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class BusinessByInventoryManagement extends ModelManager
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'business_by_inventory_management';

    protected $fillable = array('type', 'config_management_inventory', 'business_id');

    public $timestamps = false;
    protected $field_main = 'id';
    public static function getRulesModel()
    {
        $rules = [
            "type" => "required",
            "business_id" => "required",



        ];
        return $rules;
    }
    public function getDataProfileBusiness($params)
    {
        $business_id = $params['filters']['business_id'];
        $query = DB::table($this->table);

        $selectString = "$this->table.id,$this->table.type,$this->table.config_management_inventory
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        $query->where($this->table . '.business_id', '=', $business_id);


        $result = $query->first();


        return $result;
    }
    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data=[];
        DB::beginTransaction();
        try {
            $modelName = 'BusinessByInventoryManagement';
            $model = new  \App\Models\BusinessByInventoryManagement();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model =  \App\Models\BusinessByInventoryManagement::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $postData = $attributesPost[$modelName];
            $attributesSet = $postData;
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $data=$model->attributes;
            } else {
                $success = false;
                $msj = "Problemas al guardar  Configuracion.";
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
                'data'=>$data,
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
