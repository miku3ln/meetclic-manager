<?php

namespace App\Models;
use App\Models\BusinessCategories;
use DB;
class BusinessSubcategories extends ModelManager
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'business_subcategories';

    protected $fillable = array(
        'name',//*
        'status',//*
        'created_at',
        'updated_at',
        'deleted_at',
        'business_categories_id',//*
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
        ['column' => 'business_categories_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'src', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'has_icon', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'icon_class', 'type' => 'string', 'defaultValue' => 'anyone', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'true']

    ];
    protected $field_main = 'name';

    public $timestamps = true;
    public static function getRulesModel()
    {
        $rules = ["name" => "required|max:45",
            "status" => "required",
            "business_categories_id" => "required|numeric",
            "src" => "required|max:250",
            "has_icon" => "required|numeric",
            "icon_class" => "required|max:20",
            "description" => "required"
        ];
        return $rules;
    }
    public function getSubcategories()
    {
        $result = array();
        $modelCategories = new BusinessCategories;
        $modelsubcategories = new BusinessSubcategories;

        $categories = $modelCategories->getCategories();

        foreach ($categories as $key => $value) {
            $nameParent = $value["name"];
            $business_categories_id = $value["id"];
            $dataParent = $modelsubcategories->getStructureDrop($modelsubcategories->getSubcategoriesByCategorieId(array("business_categories_id" => $business_categories_id)));

            $result[$nameParent] = $dataParent;

        }
        return $result;
    }

    public function getCategoriesSearch()
    {
        $result = array();
        $modelCategories = new BusinessCategories;
        $modelsubcategories = new BusinessSubcategories;

        $categories = $modelCategories->getCategories();
        foreach ($categories as $key => $value) {
            $nameParent = $value["name"];
            $business_categories_id = $value["id"];
            $dataParent = $modelsubcategories->getStructureSubcategory($modelsubcategories->getSubcategoriesByCategorieId(array("business_categories_id" => $business_categories_id)));
            $setPush = array(
                "id" => $business_categories_id,
                "name" => $nameParent,
                "subcategories" => $dataParent
            );
            array_push(
                $result, $setPush
            );


        }
        return $result;
    }

    public function getSubcategoriesByCategorieId($params = array())
    {
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'name';
        $business_categories_id = $params["business_categories_id"];
        $select = "*";
        $query = BusinessSubcategories::query()->select($select);
        $query->where("business_categories_id", '=', $business_categories_id);
        $query->orderBy($field, $sort);
        $data = $query->get()->toArray();

        return $data;
    }

    public function getStructureDrop($haystack)
    {
        $result = array();

        foreach ($haystack as $key => $value) {
            $name = $value["name"];
            $id = $value["id"];
            $result[$id] = $name;

        }

        return $result;
    }

    public function getStructureSubcategory($haystack)
    {
        $result = array();

        foreach ($haystack as $key => $value) {
            $name = $value["name"];
            $id = $value["id"];
            array_push($result, array("id" => $id, "name" => $name));

        }

        return $result;
    }

    /*MANAGER MAINS*/

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = $this->field_main;
        $query = DB::table($this->table);
        $business_categories_id = $params['filters']['business_categories_id'];

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;

        $selectString = "$this->table.id,$this->table.name,$this->table.status,$this->table.created_at,$this->table.updated_at,$this->table.deleted_at,business_categories.name as business_categories,
business_categories.id as business_categories_id,
$this->table.src,$this->table.has_icon,$this->table.icon_class,$this->table.description";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business_categories', 'business_categories.id', '=', $this->table . '.business_categories_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->where($this->table . '.name', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
            });;

        }
        $query->where($this->table . '.business_categories_id', '=', $business_categories_id);

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
            $modelName = 'BusinessSubcategories';
            $model = new BusinessSubcategories();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "null" && $attributesPost["id"] != "-1") {
                $model = BusinessSubcategories::find($attributesPost['id']);
                $createUpdate = false;

                $auxResource = $model->source;
            } else {
                $createUpdate = true;
            }


            $businessSubcategoriesData = $attributesPost;
            $source = $businessSubcategoriesData["src"];
            $pathSet = "/uploads/business/businessSubcategories";
            $change = $businessSubcategoriesData["change"];
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
                $businessSubcategoriesData['src'] = $source;

                $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessSubcategoriesData, 'attributesData' => $this->attributesData));
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
                    $msj = "Problemas al guardar  BusinessSubcategories.";
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
        $query->join('business_categories', 'business_categories.id', '=', $this->table . '.business_categories_id');
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
}
