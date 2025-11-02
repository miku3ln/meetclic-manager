<?php

namespace App\Models\ProductDistributions;
use App\Models\Exception;
use App\Models\ModelManager;

use Auth;
use Illuminate\Support\Facades\DB;


class ProductByLogInventory extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';

    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_by_log_inventory';

    protected $fillable = array(
        'product_id',//*
        'type_of_income',
        'price_unit',
        'amount',//*
        'manager_equivalence_id',
        'description',
    );
    protected $attributesData = [
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_of_income', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'price_unit', 'type' => 'integer', 'defaultValue' => '', 'required' => ''],
        ['column' => 'amount', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'manager_equivalence_id', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'false'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],



    ];
    public $timestamps = false;

    protected $field_main = 'description';
    public static function getRulesModel()
    {
        $rules = [
            "product_id" => "required|numeric",
            "type_of_income" => "numeric",
            "price_unit" => "numeric",
            "amount" => "required|numeric",
            "manager_equivalence_id" => "numeric",



        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function getDataByProductParent($params)
    {
        $sort = 'asc';
        $field = 'id';
        $query = DB::table($this->table);
        $product_parent_id = $params['filters']['product_parent_id'];
        $selectString = $this->getFieldsCurrentModel();


        $select = DB::raw($selectString);
        $query->select($select);
        $query->orderBy($field, $sort);

        $query->where($this->table . '.product_parent_id', '=', $product_parent_id);
        $result = $query->get()->toArray();


        return $result;
    }


    public function saveData($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];

        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $model = null;
            $createUpdate = true;
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = ProductByLogInventory::find($attributesPost['id']);
                $createUpdate = false;

            } else {
                $createUpdate = true;
                $model = new ProductByLogInventory();
            }
            $mainData = $attributesPost;
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $mainData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),
            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $data['ProductByLogInventory'] = $model->attributes;



            } else {
                $success = false;
                $msj = "Problemas al guardar.";
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
                'data' => $data
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
