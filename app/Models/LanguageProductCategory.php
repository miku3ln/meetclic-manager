<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;


class LanguageProductCategory extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'language_product_category';

    protected $fillable = array(
        'value',//*
        'state',//*
        'description',
        'subtitle',
        'language_id',//*
        'product_category_id'//*

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'language_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'product_category_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = ["value" => "required|max:200",
            "state" => "required",
            "subtitle" => "max:250",
            "language_id" => "required|numeric",
            "product_category_id" => "required|numeric"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.value,$this->table.state,$this->table.description,$this->table.subtitle,language.value as language,
language.id as language_id,
product_category.value as product_category,
product_category.id as product_category_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('language', 'language.id', '=', $this->table . '.language_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;

            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere("language.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');;

        }
        $entity_name = 'product_category_id';
        $entity_id = $params['filters'][$entity_name];
        $query->where($this->table . '.'.$entity_name, '=',  $entity_id );

        $recordsTotal = $query->get()->count();
        $pages = 1;
        $total = $recordsTotal; // total items in array
// sort
        $query->orderBy($field, $sort);
// Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $current_page = isset($params['current']) ? (int)$params['current'] : 0;
        $data = $query->get()->toArray();

        $result['total'] = $total;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $limit = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $result['rowCount'] = $limit;

        return $result;
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
            $modelName = 'LanguageProductCategory';
            $model = new LanguageProductCategory();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = LanguageProductCategory::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $languageProductCategoryData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $languageProductCategoryData, 'attributesData' => $this->attributesData));
            $paramsValidate = array(
                'inputs' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];

            $language_id = $attributesPost[$modelName]['language_id'];
            $entity_manager_key = 'product_category_id';
            $entity_manager_id = $attributesPost[$modelName]['product_category_id'];

            if ($success) {
                $model->fill($attributesSet);
                if ($attributesSet['state'] == 'ACTIVE') {
                    if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {

                        $idCurrent = $attributesPost[$modelName]["id"];

                        LanguageProductCategory::where('state', 'ACTIVE')
                            ->where($entity_manager_key, '=', $entity_manager_id)
                            ->where('language_id', '=', $language_id)
                            ->whereNotIn('id', [$idCurrent])
                            ->update(['state' => 'INACTIVE']);
                    } else {
                        LanguageProductCategory::where('state', 'ACTIVE')
                            ->where($entity_manager_key, '=', $entity_manager_id)
                            ->where('language_id', '=', $language_id)
                            ->update(['state' => 'INACTIVE']);
                    }
                }
                $success = $model->save();
            } else {
                $success = false;
                $msj = "Problemas al guardar  LanguageProductCategory.";
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

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('language', 'language.id', '=', $this->table . '.language_id');
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere("language.value", 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function setDelete($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $id = $params["id"];
        $errors = array();
        DB::beginTransaction();
        try {
            $model = LanguageProductCategory::find($id);
            if ($model) {
                $success = $model->delete();
                if (!$success) {
                    $msj = 'No se elimino correctamente.';

                } else {
                    $msj = 'Eliminado correctamente.';

                }
            } else {

                $msj = 'No existe informacion.';
            }
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );

            if (!$success) {
                DB::rollBack();

            } else {
                DB::commit();
            }

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
