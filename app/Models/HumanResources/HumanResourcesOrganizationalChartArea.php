<?php
//CPP-010
namespace App\Models\HumanResources;

use App\Models\Exception;
use App\Models\ModelManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HumanResourcesOrganizationalChartArea extends ModelManager
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    const typeManager = 0;//manager is link
    const typeMethod = 1;//method
    const typeRoot = 2;//init menu root

    const typeNotChild = 0;
    const typeNotChildText = 'Nivel 0';
    const typeLevelOne = 1;
    const typeLevelOneText = 'Nivel 1';

    const typeLevelTwo = 2;
    const typeLevelTwoText = 'Nivel 2';

    const typeLevelThree = 3;
    const typeLevelThreeText = 'Nivel 3';


    const typeDesignOne = 0;//only root
    const typeDesignTwo = 1;//only level 2

    const typeDesignThree = 2;
    protected $table = 'human_resources_organizational_chart_area';
    /*
     * primary key used by the model
     */
    protected $primaryKey = 'id';
    /*
     * this parameter add or remove timestamps columns depending its status
     */
    public $timestamps = false;

    protected $fillable = array(
        "id",//*
        "name",//*
        "parent_id",
        "weight",
        "icon",
        "type",//*
        "description",//
        "type_item",//*
        "business_id",

    );
    public $attributesData = array(
        "id",//*
        "name",//*

        "parent_id",
        "weight",
        "icon",
        "type",//*
        "description",//
        "type_item",//*
        "business_id",

    );

    public function departments()
    {
        return $this->belongsToMany(HumanResourcesDepartmentByOrganizationalChartArea::class, 'human_resources_department_by_organizational_chart_area', 'human_resources_organizational_chart_area_id', 'human_resources_department_id');
    }
    public function departmentsAdd()
    {
        return $this->belongsToMany(HumanResourcesDepartmentByOrganizationalChartArea::class, 'human_resources_department_by_organizational_chart_area', 'human_resources_organizational_chart_area_id', 'human_resources_department_id');

    }
    public static function getRulesModel()
    {
        $rules = [
            "name" => 'required',
            "type" => 'required',
            "description" => 'required',
            "type_item" => 'required',
            "business_id" => 'required',

        ];
        return $rules;
    }

    public static function validateModel($modelAttributes)
    {
        $rules = self::getRulesModel();
        $validation = Validator::make($modelAttributes, $rules);
        $success = $validation->passes();
        $errors = [];
        if (!$success) {
            $errors = $validation->errors()->all();
        }
        $result = array("success" => $success, "errors" => $errors);
        return $result;
    }

    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'name';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.name ,$this->table.type_item,$this->table.parent_id,$this->table.weight,$this->table.icon,$this->table.type,$this->table.description
   ";

        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = null;
        if (isset($params['filters']['business_id'])) {
            $business_id = ($params['filters']['business_id']);
            $query->where($this->table . '.business_id', '=', $business_id);
        }

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.name', 'like', $likeSet)
                    ->orWhere($this->table . '.icon', 'like', $likeSet)
                    ->orWhere($this->table . '.weight', 'like', $likeSet);

            });
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

    public function getActionParent($params)
    {
        $parent_id = $params["parent_id"];
        $query = DB::table($this->table);
        $selectString = "*";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("id", '=', $parent_id);
        $data = $query->get()->first();
        return $data;
    }

    public function getAdminData($params)
    {
        $result = $this->getAdmin($params);
        $model = new HumanResourcesOrganizationalChartArea();
        foreach ($result["rows"] as $key => $row) {
            $parent_id = $row->parent_id;
            $setPush = json_decode(json_encode($row), true);
            $result["rows"][$key] = $setPush;
            $parent = "";
            if ($parent_id) {
                $resultParent = $model->getActionParent(array("parent_id" => $parent_id));
                $parent = $resultParent->name;
            }
            $result["rows"][$key]["parent"] = $parent;


        }


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

            $model = new HumanResourcesOrganizationalChartArea();
            $createUpdate = true;
            if (isset($attributesPost["HumanResourcesOrganizationalChartArea"]["id"]) && $attributesPost["HumanResourcesOrganizationalChartArea"]["id"] != "null" && $attributesPost["HumanResourcesOrganizationalChartArea"]["id"] != "-1") {
                $model = HumanResourcesOrganizationalChartArea::find($attributesPost["HumanResourcesOrganizationalChartArea"]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost["HumanResourcesOrganizationalChartArea"];
            $attributesSet = array(
                "name" => $postData["name"],
                "parent_id" => $postData["parent_id"],
                "weight" => $postData["weight"],
                "icon" => $postData["icon"],
                "type" => $postData["type"],
                "type_item" => $postData["type_item"],
                "description" => $postData["description"],
                "business_id" => $postData["business_id"],
            );


            $validateResult = HumanResourcesOrganizationalChartArea::validateModel($attributesSet);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $model->save();

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
    public function getListData($params)
    {

        $query = DB::table($this->table);
        $conditionLevelThree = "IF($this->table.type=" . self::typeLevelThree . ",'" . self::typeLevelThreeText . "','BOLA')";
        $conditionLevelTwo = "IF($this->table.type=" . self::typeLevelTwo . ",'" . self::typeLevelTwoText . "',$conditionLevelThree)";
        $conditionLevelOne = "IF($this->table.type=" . self::typeLevelOne . ",'" . self::typeLevelOneText . "',$conditionLevelTwo)";
        $conditionText = "CONCAT(IF($this->table.type=" . self::typeNotChild . ",'" . self::typeNotChildText . "',$conditionLevelOne),' - ',$this->table.name) text";
        $conditionText = "$this->table.name text";

        $selectString = "$this->table.id ,$this->table.name ,$conditionText ,$this->table.business_id";

        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = ($params['filters']["business_id"]);
        if (isset($params['filters']["search_value"]["term"])) {
            $like = $params['filters']["search_value"]["term"];

            $query->where('name', 'like', '%' . $like . '%');
        }
        $query->where('business_id', '=', $business_id);
        $query->limit(10)->orderBy('type', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
    public function getListActionsParent($params)
    {

        $query = DB::table($this->table);
        $conditionLevelThree = "IF($this->table.type=" . self::typeLevelThree . ",'" . self::typeLevelThreeText . "','BOLA')";
        $conditionLevelTwo = "IF($this->table.type=" . self::typeLevelTwo . ",'" . self::typeLevelTwoText . "',$conditionLevelThree)";
        $conditionLevelOne = "IF($this->table.type=" . self::typeLevelOne . ",'" . self::typeLevelOneText . "',$conditionLevelTwo)";
        $conditionText = "CONCAT(IF($this->table.type=" . self::typeNotChild . ",'" . self::typeNotChildText . "',$conditionLevelOne),' - ',$this->table.name) text";
        $conditionText = "$this->table.name text";

        $selectString = "$this->table.id ,$this->table.name ,$conditionText ,$this->table.business_id";

        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = ($params['filters']["businessId"]);
        $type = 2;

        if (isset($params['filters']["search_value"]["term"])) {

            $like = $params['filters']["search_value"]["term"];

            $query->where('name', 'like', '%' . $like . '%');
        }
        $query->where('business_id', '=', $business_id);
        /*$query->where(function ($query) {
            $query->where('campo1', '=', 'valor1')
                ->orWhere('campo2', '=', 'valor2');
        });*/

        $query->limit(10)->orderBy('type', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }

    public function getAdminMenuBusiness($params)
    {
        $sort = 'asc';
        $field = 'weight';
        $query = DB::table($this->table);
        $conditionLevelThree = "IF($this->table.type=" . self::typeLevelThree . ",'" . self::typeLevelThreeText . "','BOLA')";
        $conditionLevelTwo = "IF($this->table.type=" . self::typeLevelTwo . ",'" . self::typeLevelTwoText . "',$conditionLevelThree)";
        $conditionLevelOne = "IF($this->table.type=" . self::typeLevelOne . ",'" . self::typeLevelOneText . "',$conditionLevelTwo)";
        $conditionText = "CONCAT(IF($this->table.type=" . self::typeNotChild . ",'" . self::typeNotChildText . "',$conditionLevelOne),' - ',$this->table.name) text_menu";

        $selectString = "$this->table.id ,$this->table.name,$this->table.name title ,$this->table.type_item,$this->table.parent_id,$this->table.weight,$this->table.icon,$this->table.type,$this->table.description,$conditionText
   ";
        $select = DB::raw($selectString);
        $query->select($select);
        $business_id = null;
        if (isset($params['filters']['business_id'])) {
            $business_id = ($params['filters']['business_id']);
            $query->where($this->table . '.business_id', '=', $business_id);
        }
        $parent_id = null;
        $query->where('parent_id', '=', $parent_id);

        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();

        return $result;
    }

    public function getAdminMenuBusinessParent($params)
    {
        $sort = 'asc';
        $field = 'weight';
        $query = DB::table($this->table);
        $conditionLevelThree = "IF($this->table.type=" . self::typeLevelThree . ",'" . self::typeLevelThreeText . "','BOLA')";
        $conditionLevelTwo = "IF($this->table.type=" . self::typeLevelTwo . ",'" . self::typeLevelTwoText . "',$conditionLevelThree)";
        $conditionLevelOne = "IF($this->table.type=" . self::typeLevelOne . ",'" . self::typeLevelOneText . "',$conditionLevelTwo)";
        $conditionText = "CONCAT(IF($this->table.type=" . self::typeNotChild . ",'" . self::typeNotChildText . "',$conditionLevelOne),' - ',$this->table.name) text_menu";

        $selectString = "$this->table.id ,$this->table.name ,$this->table.name title,$this->table.type_item,$this->table.parent_id,$this->table.weight,$this->table.icon,$this->table.type,$this->table.description,$conditionText
   ";
        $select = DB::raw($selectString);
        $query->select($select);
        $parent_id = $params['filters']['parent_id'];
        $query->where('parent_id', '=', $parent_id);

        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();

        return $result;
    }

    public function managementMenuBusiness($params)
    {
        $menuRoots = $this->getAdminMenuBusiness($params);

        $result = [];
        $allowLevelOne = false;
        $allowLevelTwo = false;
        $allowLevelThree = false;
        $allowPush = false;
        foreach ($menuRoots as $key => $row) {
            $type = $row->type;
            $setPush = [];
            $allowPush = false;

            if ($type == self::typeNotChild) {
                $setPushLevelOne = $row;
                $setPushLevelOne = (array)$setPushLevelOne;
                $setPush = $setPushLevelOne;
                $setPush['typeDesign'] = self::typeDesignOne;
                $setPush['active'] = false;
                $allowPush = true;

            } else {
                $parent_id = $row->id;
                $menuRootsLevel2 = $this->getAdminMenuBusinessParent(
                    ['filters' => [
                        'parent_id' => $parent_id
                    ]]
                );
                if ($menuRootsLevel2) {
                    $dataSetPush = [];
                    $typeDesign = null;
                    foreach ($menuRootsLevel2 as $key2 => $row2) {
                        $parent_id = $row2->id;
                        $menuRootsLevel3 = $this->getAdminMenuBusinessParent(
                            ['filters' => [
                                'parent_id' => $parent_id
                            ]]);
                        if ($menuRootsLevel3) {
                            $dataLevel3 = [];
                            foreach ($menuRootsLevel3 as $key3 => $row3) {
                                $setPushData = (array)$row3;
                                $setPushData['active'] = false;
                                $dataLevel3[] = $setPushData;
                                /* if ($typeDesign == null) {
                                     $typeDesign = self::typeDesignThree;
                                     $parent_id = $row3->id;
                                     $menuRootsLevel4 = $this->getAdminMenuBusinessParent(
                                         ['filters' => [
                                             'parent_id' => $parent_id
                                         ]]);
                                     if ($menuRootsLevel4) {

                                     }

                                 }*/

                            }


                        } else {
                            if ($typeDesign == null) {
                                $typeDesign = self::typeDesignTwo;
                            }
                            $dataSetPush[$key2] = (array)$row2;
                            $dataSetPush[$key2]['active'] = false;


                        }
                    }
                    $setPushLevelOne = $row;
                    $setPushLevelOne = (array)$setPushLevelOne;
                    $setPush = $setPushLevelOne;
                    $setPush['typeDesign'] = $typeDesign;
                    $setPush['active'] = false;
                    $setPush['data'] = $dataSetPush;
                    $allowPush = true;
                }

            }
            if ($allowPush) {
                $result[$key] = $setPush;
            }

            $allowLevelOne = false;
            $allowLevelTwo = false;
            $allowLevelThree = false;

            $dataLevelTwo = [];
            $dataLevelThree = [];
            $allowPush = false;
        }

        return $result;
    }

}



