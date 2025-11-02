<?php

namespace App\Models\ProductDistributions;

use App\Models\Exception;
use App\Models\ModelManager;

use Auth;
use Illuminate\Support\Facades\DB;


class ProductParentByPrices extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';

    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_parent_by_prices';

    protected $fillable = array(
        'price',//*
        'priority',//*
        'utility',//*
        'type_price',
        'measurement_type',
        'manager_equivalence_id',
        'type_of_income',
        'description',//*
        'product_parent_id',//*


    );
    protected $attributesData = [
        ['column' => 'price', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'priority', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'utility', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_price', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'measurement_type', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'manager_equivalence_id', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_of_income', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_parent_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],


    ];
    public $timestamps = false;

    protected $field_main = 'description';

    public static function getRulesModel()
    {
        $rules = [
            "price" => "required|numeric",
            "priority" => "required",
            "utility" => "required",
            "type_price" => "required|numeric",
            "measurement_type" => "required|numeric",
            "manager_equivalence_id" => "required|numeric",
            "type_of_income" => "required|numeric",
            "description" => "required",
            "product_parent_id" => "required|numeric",


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
        $selectString = $this->table.".id,".$this->getFieldsCurrentModel();


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
                $model = ProductParentByPrices::find($attributesPost['id']);
                $createUpdate = false;

            } else {
                $createUpdate = true;
                $model = new ProductParentByPrices();
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
                $data['ProductParentByPrices'] = $model->attributes;


            } else {
                $success = false;
                $msj = "Problemas al guardar  Precio.";
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

    public function saveDataDelete($params)
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
            $product_parent_by_prices_id = $attributesPost['id'];


            $model = ProductParentByPrices::find($attributesPost['id']);

            if ($model) {
                $modelSearch = new ProductParentByPackageParams();
                $modelSearchData = $modelSearch->findAllByAttributes(array("product_parent_by_prices_id" => $product_parent_by_prices_id));
                if (count($modelSearchData) == 0) {
                    $model->delete();
                    $model = ProductParentByPrices::find($attributesPost['id']);
                    if ($model) {
                        $success = false;
                        $msj = "Problemas al eliminar .";
                    } else {
                        $success = true;
                        $msj = "Se elimino";
                    }
                } else {
                    $success = false;
                    $msj = "No se puede eliminar debido a que tiene registros realacionados.";
                }


            } else {
                $success = false;
                $msj = "No Existe registro.";
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
                "success" => false,
                "msj" => $msj,
                "errors" => $errors
            );
            return ($result);
        }

    }

}
