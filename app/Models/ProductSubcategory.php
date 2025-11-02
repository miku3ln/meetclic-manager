<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Multimedia;

class ProductSubcategory extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_subcategory';
    const DEFAULT_ID = 1;

    protected $fillable = array(
        'value', //*
        'state', //*
        'description',
        'source',
        'subtitle',
        'product_category_id', //*
        'business_id',

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'product_category_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = [
            "value" => "required|max:200",
            "state" => "required",
            "source" => "max:250",
            "subtitle" => "max:250",
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

        $selectString = "$this->table.id,$this->table.value,$this->table.state,$this->table.description,$this->table.source,$this->table.subtitle,product_category.value as product_category,
product_category.id as product_category_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere("product_category.value", 'like', '%' . $likeSet . '%');;
        }
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        if ($business_id) {

            $query->where($this->table . '.business_id', '=', $business_id);
        }
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
            $modelName = 'ProductSubcategory';
            $model = new ProductSubcategory();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = ProductSubcategory::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }


            $productSubcategoryData = $attributesPost;
            $source = $productSubcategoryData["source"];
            $pathSet = "/uploads/products/productSubcategory";
            $change = $productSubcategoryData["change"];
            $successMultimediaModel = $modelMultimedia->managerUploadModel(
                array(
                    'createUpdate' => $createUpdate,
                    'source' => $source,
                    'pathSet' => $pathSet,
                    'change' => $change,
                    'auxResource' => $auxResource
                )
            );
            $successMultimedia = $successMultimediaModel['success'];

            if ($successMultimedia) {


                $source = $successMultimediaModel['sourceServer'];
                $productSubcategoryData['source'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productSubcategoryData, 'attributesData' => $this->attributesData));
                $business_id = isset($attributesPost[$modelName]['business_id']) ? $attributesPost[$modelName]['business_id'] : 0;
                $attributesSet['business_id'] = $business_id;
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
                    $msj = "Problemas al guardar  ProductSubcategory.";
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
            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
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

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $product_category_id = $params['filters']['product_category_id'];
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
        }
        $query->where('product_category.id', '=', $product_category_id);

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getListSubCategoriesFrontend($params)
    {
        $field = $this->table . '.value';
        $product_category_id = $params['filters']['product_category_id'];
        $business_id = $params['filters']['business_id'];
        $query = DB::table('business_by_products');
        $selectString = "$this->table.product_category_id,$this->table.id,$this->table.description,$this->table.source,$this->table.state,$this->table.subtitle,$this->table.value
        ,product.id product_id
        ,business_by_inventory_management_subcategory.source business_by_inventory_management_subcategory_source";

        $relationLanguage = 'language_product_subcategory';
        $relationLanguageId = 'product_subcategory_id';
        $entityLanguage = $this->table;
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.value value_lang,' . $relationLanguage . '.description description_lang,' . $relationLanguage . '.subtitle subtitle_lang
           ';
        }
        $select = DB::raw($selectString);
        $query->select($select);
        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });
        }


        $query->join('product', 'product.id', '=', 'business_by_products.products_id');
        $query->join($this->table, 'product.product_category_id', '=', $this->table . '.product_category_id');
     $query->leftJoin('business_by_inventory_management_subcategory', function ($query)
        use (
            $selectString,
            $business_id

        ) {
            $query->on('business_by_inventory_management_subcategory.product_subcategory_id', '=', 'product_subcategory.id');
            $query->where('business_by_inventory_management_subcategory.business_id', '=', $business_id);
        });


        $query->where($this->table . '.product_category_id', '=', $product_category_id);
        $query->where('business_by_products.business_id', '=', $business_id);
        $query->orderBy($field, 'asc');


        $result = $query->get()->toArray();

        return $result;
    }

    public function getListSelect2Config($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $product_category_id = isset($params['filters']['product_category_id']) ? $params['filters']['product_category_id'] : null;
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;


        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product_category', 'product_category.id', '=', $this->table . '.product_category_id');

        $paramsCurrent = [
            'business_id' => $business_id, 'product_category_id' => $product_category_id];
        $query->whereNotIn($this->table . '.id', function ($q) use ($paramsCurrent) {
            $business_id = $paramsCurrent["business_id"];
            $q->select('product_subcategory_id')->from('business_by_inventory_management_subcategory')
                ->where('business_by_inventory_management_subcategory.business_id', '=', $business_id);
        });
        /*
        $resltQueries = DB::raw("SELECT business_by_inventory_management_subcategory.product_subcategory_id FROM business_by_inventory_management_subcategory");
        $arrQuery = array();
dd($arrQuery);
        foreach($resltQueries as $key => $resltQuery){
            $arrQuery[$key] = $resltQuery;
        }*/
        /*        $query->whereNotIn($this->table.'.id', 'not in',$arrQuery);*/


        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
        }
        if ($business_id) {

            /*  $query->where('business_by_inventory_management_subcategory.business_id', '=', $business_id);*/
        }
        if ($product_category_id) {

            $query->where('product_category.id', '=', $product_category_id);
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
}
