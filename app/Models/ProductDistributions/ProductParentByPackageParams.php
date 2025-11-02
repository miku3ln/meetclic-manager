<?php

namespace App\Models\ProductDistributions;

use App\Models\Exception;
use App\Models\ModelManager;

use Auth;
use Illuminate\Support\Facades\DB;


class ProductParentByPackageParams extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';

    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_parent_by_package_params';

    protected $fillable = array(

        'name',//*
        'type_param',
        'product_parent_id',//*
        'limit_one',//*
        'limit_two',
        'product_parent_by_prices_id',//*


    );
    protected $attributesData = [
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_param', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'product_parent_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'limit_one', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'limit_two', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'product_parent_by_prices_id', 'type' => 'integer', 'defaultValue' => '-1', 'required' => 'true']


    ];
    public $timestamps = false;

    protected $field_main = 'name';

    public static function getRulesModel()
    {
        $rules = [
            "name" => "required",
            "type_param" => "required|numeric",
            "product_parent_id" => "required|numeric",
            "limit_one" => "required|numeric",
            "limit_two" => "required|numeric",
            "product_parent_by_prices_id" => "required|numeric",

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
        $selectString = $this->table . ".id," . $this->getFieldsCurrentModel() . ',' . $this->table . '.product_parent_by_prices_id product_parent_by_prices_id_data';

        $selectString .= ',product_parent_by_prices.description product_parent_by_prices_description';
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product_parent_by_prices', 'product_parent_by_prices.id', '=', $this->table . '.product_parent_by_prices_id');

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
                $model = ProductParentByPackageParams::find($attributesPost['id']);
                $createUpdate = false;

            } else {
                $createUpdate = true;
                $model = new ProductParentByPackageParams();
            }
            $mainData = $attributesPost;
            $mainData['product_parent_by_prices_id'] = $mainData['product_parent_by_prices_id_data'];
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
                $data['ProductParentByPackageParams'] = $model->attributes;


            } else {
                $success = false;
                $msj = "Problemas al guardar  Paquete.";
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
            $model = ProductParentByPackageParams::find($attributesPost['id']);
            $model->delete();
            $model = ProductParentByPackageParams::find($attributesPost['id']);
            if ($model) {
                $success = false;
                $msj = "Problemas al eliminar .";
            } else {
                $success = true;
                $msj = "Se elimino";
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
