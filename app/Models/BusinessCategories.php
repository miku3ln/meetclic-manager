<?php

namespace App\Models;

use App\Models\ModelManager;

use DB;
class BusinessCategories extends ModelManager
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business_categories';
    public $timestamps = true;
    protected $fillable = array(
        'name',//*
        'status',//*
        'created_at',
        'updated_at',
        'deleted_at',
        'src',//*
        'has_icon',//*
        'icon_class',//*
        'description'//*

    );
    protected $attributesData = [
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'created_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'updated_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'deleted_at', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'src', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'has_icon', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'icon_class', 'type' => 'string', 'defaultValue' => 'anyone', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];


    protected $field_main = 'name';

    public static function getRulesModel()
    {
        $rules = ["name" => "required|max:45",
            "status" => "required",
            "src" => "required|max:250",
            "has_icon" => "required|numeric",
            "icon_class" => "required|max:20",
            "description" => "required"
        ];
        return $rules;
    }

    public function getCategories($params = array())
    {
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'name';
        $select = "*";
        $query = BusinessCategories::query()->select($select);
        $query->orderBy($field, $sort);
        $data = $query->get()->toArray();

        return $data;
    }

    public function getProductCategories($params = array())
    {
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'value';
        $business_id = isset($params['business_id']) ? $params['business_id'] : null;
        $select = "*";
        $query = null;
        if (!$business_id) {
            $query = ProductCategory::query()->select($select);
            $query->limit(8)->orderBy($field, 'asc')->orderBy($field, $sort);
            $data = $query->get()->toArray();
        } else {
            $selectString = "product_category.id,
                 MIN(product_category.value) as value,
                 MIN(product_category.state) as state,
                 MIN(product_category.description) as description,
                 MIN(product_category.subtitle) as subtitle,
                 MIN(product_category.source) as source";

            $query = DB::table('product_category')
                ->select(DB::raw($selectString))
                ->join('product', 'product.product_category_id', '=', 'product_category.id')
                ->join('business_by_products', 'business_by_products.products_id', '=', 'product.id')
                ->where('business_by_products.business_id', '=', $business_id)
                ->groupBy('product_category.id');
            $data = $query->get()->toArray();

        }




        return $data;
    }

    public function getProductSubCategoriesByCategory($params = array())
    {

        $category_id = $params['filters']['id'];
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'value';
        $select = "*";
        $query = ProductSubcategory::query()->select($select);
        $query->limit(8)->orderBy($field, 'asc')->orderBy($field, $sort);

        $query->where('product_subcategory.product_category_id', '=', $category_id);

        $data = $query->get()->toArray();

        return $data;
    }

    public function getCategoriesSearchBee($params)
    {
        $textValue = $this->table . '.name';
        $field = $textValue;
        $query = DB::table($this->table);

        $selectString = "$this->table.id,$this->table.name as text";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.status', '=', 'ACTIVE');
        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.name', 'like', '%' . $likeSet . '%');


            });
        }
        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getAllCategoriesByProducts($params)
    {

        $resultCategories = $this->getProductCategories($params);
        $modelBusiness = new \App\Models\Business;

        $path = $params['path'];
        $data = [];
        $success = false;
        $business_id=isset($params["business_id"])?$params["business_id"]:null;
        foreach ($resultCategories as $index => $item) {
            $dataSubcategories=[];
            if($business_id){
                $dataSubcategories = $this->getProductSubCategoriesByCategory(['filters' => [
                    'id' => $item->id
                ]]);
            }else{
                $dataSubcategories = $this->getProductSubCategoriesByCategory(['filters' => [
                    'id' => $item["id"]
                ]]);
            }

            if ($dataSubcategories > 0) {
                $setPush = $item;
                $dataSubcategorieManager = [];
                foreach ($dataSubcategories as $indexSubcategorie => $itemSubcategorie) {
                    $setPushSubcategorie = $itemSubcategorie;
                    $setPushSubcategorie['src'] = asset($path . $itemSubcategorie['source']);
                    $dataSubcategorieManager[] = $setPushSubcategorie;
                }
                $setPush->sub_categories = $dataSubcategorieManager;


                $data[] =$setPush;
                $success = true;

            }


        }
        $result = [
            'data' => $data,
            'success' => $success
        ];

        return $result;

    }

    public function getAllCategoriesCount($params)
    {
        $resultCategories = $this->getCategories();
        $modelBusiness = new \App\Models\Business;

        $path = $params['path'];
        $data = [];
        $success = false;
        foreach ($resultCategories as $index => $item) {
            $countBusiness = $modelBusiness->getCountBusinessByCategory(['filters' => [
                'business_categories_id' => $item['id']
            ]]);
            if ($countBusiness > 0) {
                $setPush = $item;
                $setPush['src'] = asset($path . $item['src']);
                $setPush['count'] = $countBusiness;
                $data[] = (object)$setPush;
                $success = true;

            }


        }
        $result = [
            'data' => $data,
            'success' => $success
        ];

        return $result;

    }


    public function getAllCategories($params = [])
    {
        $textValue = $this->table . '.name';
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$this->table.name as text,$this->table.src ,$this->table.has_icon,$this->table.icon_class ,$this->table.description  ,$this->table.description ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.status', '=', 'ACTIVE');
        if (isset($params["filters"]['search_value']["term"])) {
            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.name', 'like', '%' . $likeSet . '%');


            });
        }
        $query->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

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

        $selectString = "$this->table.id,$this->table.name,$this->table.status,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,$this->table.src,$this->table.has_icon,$this->table.icon_class,$this->table.description";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {

                $query->where($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            });;

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
            $modelName = 'BusinessCategories';
            $model = new BusinessCategories();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = BusinessCategories::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }


            $businessCategoriesData = $attributesPost;
            $source = $businessCategoriesData["src"];
            $pathSet = "/uploads/business/businessCategories";
            $change = $businessCategoriesData["change"];
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


                $source = $successMultimediaModel['source'];
                $businessCategoriesData['src'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessCategoriesData, 'attributesData' => $this->attributesData));
                $paramsValidate = array(
                    'modelAttributes' => $attributesSet,
                    'rules' => self::getRulesModel(),

                );
                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                } else {
                    $success = false;
                    $msj = "Problemas al guardar  BusinessCategories.";
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
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {

                $query->where($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public function getCategoryFilters($params)
    {
        $textValue = $this->table . '.' . $this->field_main;
        $field = $textValue;
        $query = DB::table($this->table);
        $selectString = "$this->table.id,$textValue as text";
        $select = DB::raw($selectString);
        $query->select($select);
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->where($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');

            });;

        }


        $result = $query->first();
        return $result;

    }
}
