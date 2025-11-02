<?php

namespace App\Models\ProductDistributions;
use App\Models\Exception;
use App\Models\ModelManager;

use Auth;
use Illuminate\Support\Facades\DB;


class ProductByMetaData extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';

    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_by_meta_data';

    protected $fillable = array(
        'id',//*
        'product_id',//*
        'title',//*
        'keyword',//*
        'description',//*




    );
    protected $attributesData = [
        ['column' => 'product_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'title', 'type' => 'string', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'keyword', 'type' => 'string', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '0', 'required' => 'true'],



    ];
    public $timestamps = false;

    protected $field_main = 'title';
    public static function getRulesModel()
    {
        $rules = [
            "product_id" => "required|numeric",
            "title" => "required",
            "keyword" => "required",
            "description" => "required",


        ];
        return $rules;
    }


    /*MANAGER MAINS*/
    public function getDataByProductParent($params)
    {
        $sort = 'asc';
        $field = 'id';
        $query = DB::table($this->table);
        $product_parent_id = $params['filters']['product_id'];
        $selectString = $this->getFieldsCurrentModel();


        $select = DB::raw($selectString);
        $query->select($select);
        $query->orderBy($field, $sort);

        $query->where($this->table . '.product_id', '=', $product_parent_id);
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
                $model = ProductByMetaData::find($attributesPost['id']);
                $createUpdate = false;

            } else {
                $createUpdate = true;
                $model = new ProductByMetaData();
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
                $data['ProductByMetaData'] = $model->attributes;



            } else {
                $success = false;
                $msj = "Problemas al guardar .";
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
