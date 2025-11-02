<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductSubcategory;

use App\Models\Multimedia;

class ProductCategory extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'product_category';
    const DEFAULT_ID = 1;

    protected $fillable = array(
        'value', //*
        'state', //*
        'description',
        'subtitle',
        'source',
        'business_id',

    );
    protected $attributesData = [
        ['column' => 'value', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => 'ACTIVE', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'subtitle', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'source', 'type' => 'string', 'defaultValue' => '', 'required' => 'false']

    ];
    public $timestamps = false;

    protected $field_main = 'value';

    public static function getRulesModel()
    {
        $rules = [
            "value" => "required|max:200",
            "state" => "required",
            "subtitle" => "max:250",
            "source" => "max:250"
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

        $selectString = "$this->table.id,$this->table.value,$this->table.state,$this->table.description,$this->table.subtitle,$this->table.source";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');;
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
        $data = [];
        DB::beginTransaction();
        try {
            $modelName = 'ProductCategory';
            $model = new ProductCategory();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = ProductCategory::find($attributesPost['id']);
                $createUpdate = false;
                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }


            $productCategoryData = $attributesPost;
            $source = $productCategoryData["source"];
            $pathSet = "/uploads/products/productCategory";
            $change = $productCategoryData["change"];
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
                $productCategoryData['source'] = $source;


                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $productCategoryData, 'attributesData' => $this->attributesData));
                $business_id = isset($attributesPost['business_id']) ? $attributesPost['business_id'] : 0;
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
                    $data['attributes'] = $model->attributes;
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  ProductCategory.";
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
            } else {
                $msj = $successMultimediaModel["message"];
                DB::rollBack();
                // throw new \Exception($msj);
                $success = false;
            }

        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors
            );


        }
        $result = array(
            "success" => $success,
            "msj" => $msj,
            "errors" => $errors
        );
        return ($result);

    }

    public function getListSelect2($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.value', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.subtitle', 'like', '%' . $likeSet . '%');
            $query->orWhere($this->table . '.source', 'like', '%' . $likeSet . '%');;
        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getListCategoriesFrontend($params)
    {
        $field = $this->table . '.value';
        $business_id = $params['filters']['business_id'];
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.description,$this->table.source,$this->table.state,$this->table.subtitle,$this->table.value
        ,product_subcategory.value product_subcategory_value,product_subcategory.id product_subcategory_id,product_subcategory.value product_subcategory,product_subcategory.source product_subcategory_source,product_subcategory.description product_subcategory_description";

        $relationLanguage = 'language_product_category';
        $relationLanguageId = 'product_category_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.value value_lang,' . $relationLanguage . '.description description_lang,' . $relationLanguage . '.subtitle subtitle_lang
           ';
        }

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('product', 'product.product_category_id', '=', $this->table . '.id');
        $query->join('product_subcategory', 'product.product_subcategory_id', '=', 'product_subcategory.id');
        $query->join('product_inventory', 'product_inventory.product_id', '=', 'product.id');
        $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');
        $query->where('product_inventory.quantity_units', '>', 0);

        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
           $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });
        }
        $query->where('business_by_products.business_id', '=', $business_id);
        $view_online = 1;
        $state_product = 'ACTIVE';

        $query->where('product.view_online', '=', $view_online);
        $query->where('product.state', '=', $state_product);
        if (!env('allowBusinessOwner')) {
         //   $query->groupBy(['product.product_category_id']);
        }
        $query->orderBy($field, 'asc');
        $result = $query->get()->toArray();

        return $result;
    }

    public function getListCategories($params)
    {
        $field = $this->table . '.value';
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;


        $query = DB::table('business_by_products');
        $selectString = "$this->table.id,$this->table.description,$this->table.source,$this->table.state,$this->table.subtitle,$this->table.value
        ,business_by_products.products_id
        ,product.product_category_id,product.product_subcategory_id
        ,product_subcategory.value product_subcategory_value,product_subcategory.subtitle product_subcategory_subtitle,product_subcategory.description product_subcategory_description,product_subcategory.source product_subcategory_source,product_subcategory.id product_subcategory_id
        ,business_by_inventory_management_subcategory.source business_by_inventory_management_subcategory_source";
        $relationLanguage = 'language_product_category';
        $relationLanguageId = 'product_category_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.value value_lang,' . $relationLanguage . '.description description_lang,' . $relationLanguage . '.subtitle subtitle_lang
           ';
        }

        $select = DB::raw($selectString);
        $query->select($select);

        if ($business_id) {
            $query->join('product', 'business_by_products.products_id', '=', 'product.id');
            $query->join('product_category', 'product.product_category_id', '=', 'product_category.id');
            $query->join('product_subcategory', 'product.product_subcategory_id', '=', 'product_subcategory.id');

        }
        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });
        }


        $query->leftJoin('business_by_inventory_management_subcategory', function ($query)
        use (
            $selectString,
            $business_id

        ) {
            $query->on('business_by_inventory_management_subcategory.product_subcategory_id', '=', 'product_subcategory.id');
            $query->where('business_by_inventory_management_subcategory.business_id', '=', $business_id);
        });
        if ($business_id) {
            $query->where('business_by_products.business_id', '=', $business_id);
        }
        $query->orderBy($field, 'asc');
        $result = $query->get()->toArray();

        return $result;
    }

    public function getListCategories2($params)
    {
        $field = $this->table . '.value';
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $language = isset($params['filters']['language']) ? ($params['filters']['language'] == 'es' ? null : $params['filters']['language']) : null;


        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.description,$this->table.source,$this->table.state,$this->table.subtitle,$this->table.value
        ,business_by_products.products_id
        ,product.product_category_id,product.product_subcategory_id
        ,product_subcategory.value product_subcategory_value,product_subcategory.subtitle product_subcategory_subtitle,product_subcategory.description product_subcategory_description,product_subcategory.source product_subcategory_source,product_subcategory.id product_subcategory_id
        ,business_by_inventory_management_subcategory.source business_by_inventory_management_subcategory_source";
        $relationLanguage = 'language_product_category';
        $relationLanguageId = 'product_category_id';
        $entityLanguage = $this->table;
        if ($language) {
            $selectString .= ',' . $relationLanguage . '.value value_lang,' . $relationLanguage . '.description description_lang,' . $relationLanguage . '.subtitle subtitle_lang
           ';
        }

        $select = DB::raw($selectString);
        $query->select($select);

        if ($business_id) {
            $query->join('product', 'product.product_category_id', '=', $this->table . '.id');
            $query->join('business_by_products', 'product.id', '=', 'business_by_products.products_id');

        }
        $query->join('product_subcategory', $this->table . '.id', '=', 'product_subcategory.product_category_id');
        if ($language) {
            $state = 'ACTIVE';
            $query->leftJoin($relationLanguage, function ($query) use ($language, $state, $relationLanguage, $entityLanguage, $relationLanguageId) {
                $query->on($entityLanguage . '.id', '=', $relationLanguage . '.' . $relationLanguageId);
                $query->join('language', $relationLanguage . '.language_id', '=', 'language.id');
                $query->where($entityLanguage . '.state', '=', $state);
                $query->where('language.initials', '=', $language);
            });
        }
        if ($business_id) {
            $query->where('business_by_products.business_id', '=', $business_id);
        }

        $query->leftJoin('business_by_inventory_management_subcategory', function ($query)
        use (
            $selectString,
            $business_id

        ) {
            $query->on('business_by_inventory_management_subcategory.product_subcategory_id', '=', 'product_subcategory.id');
            $query->where('business_by_inventory_management_subcategory.business_id', '=', $business_id);
        });

        $query->orderBy($field, 'asc');
        $result = $query->get()->toArray();

        return $result;
    }

    public function getListCategoriesManagerFrontend($params)
    {
        $categoriesData = $this->getListCategoriesFrontend($params);
        $language = $params['filters']['language'];
        $result = $this->getSubcategoriesByCategories([
            'filters' => [
                'language' => $language,
                'categories' => $categoriesData
            ]
        ]);
        return $result;
    }

    public function getListCategoriesManager($params)
    {
        $categoriesData = $this->getListCategories($params);

        $language = $params['filters']['language'];
        $business_id = $params['filters']['business_id'];
        $resourcePathServer = $params['filters']['resourcePathServer'];


        return $this->getSubcategoriesByCategories([
            'filters' => [
                'language' => $language,
                'categories' => $categoriesData,
                'business_id' => $business_id,
                'resourcePathServer' => $resourcePathServer,

            ]
        ]);
    }

    public function getDataSubcategoriesBy($params)
    {
        $haystack = $params['haystack'];

        $product_category_id = $params['product_category_id'];

        $subcategoryDataAux = [];
        foreach ($haystack as $key => $row) {
            $equal_product_category_id = $row->id;
            if ($product_category_id == $equal_product_category_id) {
                if (!in_array($row->product_subcategory_id, $subcategoryDataAux)) {
                    $subcategoryDataAux[] = $row->product_subcategory_id;
                    $setPush = [
                        'id' => $row->product_subcategory_id,
                        'value' => $row->product_subcategory_value,
                        'subtitle' => $row->product_subcategory_subtitle,
                        'description' => $row->product_subcategory_description,
                        'source' => $row->product_subcategory_source,
                        'business_by_inventory_management_subcategory_source' => $row->business_by_inventory_management_subcategory_source,

                    ];
                    $result[] = $setPush;
                }
            }
        }

        return $result;
    }

    public function getSubcategoriesByCategories($params)
    {
        $language = $params['filters']['language'];
        $categoriesDataCurrent = $params['filters']['categories'];
        $business_id = $params['filters']['business_id'];
        $modelPS = new ProductSubcategory();
        $result = [];
        $resourcePathServer = $params['filters']['resourcePathServer'];
        $categoriesData = [];

        $categoriesDataAux = [];
        foreach ($categoriesDataCurrent as $key => $row) {
            if (!in_array($row->id, $categoriesDataAux)) {
                $categoriesDataAux[] = $row->id;
                $categoriesData [] = $row;
            }

        }

        if (count($categoriesData) > 0) {

            $allow = false;
            foreach ($categoriesData as $key => $row) {

                $product_category_id = $row->id;
                $setPush = [
                    'id' => $row->id,
                    'description' => $row->description,
                    'source' => $row->source,
                    'state' => $row->state,
                    'subtitle' => $row->subtitle,
                    'value' => $row->value,
                    //'count_products' => $row->count_products,

                ];

                $dataCurrent = $this->getDataSubcategoriesBy([
                    'haystack' => $categoriesDataCurrent,
                    'product_category_id' => $product_category_id,
                ]);
                if (count($dataCurrent) > 0) {
                    $setPush['data'] = $dataCurrent;
                    $result[] = $setPush;
                    $allow = true;
                }

            }
            if (!$allow) {
                $result = [];
            }
        }


        return $result;
    }
}
