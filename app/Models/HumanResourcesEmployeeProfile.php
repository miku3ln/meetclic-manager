<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\People as People;


class HumanResourcesEmployeeProfile extends Model
{

    protected $table = 'human_resources_employee_profile';

    protected $fillable = array(
        'description',
        'summary_web',

        "people_id", //*
        'people_type_identification_id', //*
        "human_resources_schedule_type_id",
        "human_resources_organizational_chart_area_id",
        "identification_document", //*
        "src",
        'date_of_birth', //*
        'people_nationality_id', //*
        'people_profession_id', //*
        'contract_date', //*
        'status',
        'business_id', //*
        'human_resources_department_id', //*
        'allow_view_page_web'
    );
    public $attributesData = array(
        'description',
        'summary_web',
        "people_id", //*
        'people_type_identification_id', //*
        "identification_document", //*
        "src",
        'date_of_birth', //*
        'people_nationality_id', //*
        'people_profession_id', //*
        'contract_date', //*
        'status',
        'business_id', //*
        'human_resources_department_id', //*
        'allow_view_page_web',
        "human_resources_schedule_type_id",
        "human_resources_organizational_chart_area_id",

    );
    public $timestamps = false;

    public static function getRulesModel()
    {
        $rules = [
            "people_id" => 'required',
            "people_type_identification_id" => 'required',
            "identification_document" => 'required',
            "date_of_birth" => 'required',
            "people_nationality_id" => 'required',
            "people_profession_id" => 'required',
            "contract_date" => 'required',
            "business_id" => 'required',
            "human_resources_department_id" => 'required',
            "human_resources_schedule_type_id" => 'required',
            "human_resources_organizational_chart_area_id" => 'required',

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

    public function getAdminData($params)
    {

        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];
        }
        $business_id = $params['filters']['business_id'];
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.description ,$this->table.summary_web ,$this->table.allow_view_page_web,$this->table.people_id ,$this->table.people_type_identification_id,$this->table.people_type_identification_id,$this->table.identification_document,$this->table.src,$this->table.date_of_birth,$this->table.people_nationality_id,$this->table.people_profession_id,$this->table.contract_date,$this->table.status,$this->table.business_id,$this->table.human_resources_department_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,human_resources_department.name human_resources_department
  ,business_by_employee_profile.user_id,business_by_employee_profile.id business_by_employee_profile_id
  ,users.name name_user,users.email,users.username,users.password,users.status status_users
  ,$this->table.human_resources_organizational_chart_area_id ,human_resources_organizational_chart_area.name human_resources_organizational_chart_area
  ,$this->table.human_resources_schedule_type_id,human_resources_schedule_type.name human_resources_schedule_type";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('people_nationality', $this->table . ".people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', $this->table . ".people_profession_id", '=', 'people_profession.id');
        $query->join('human_resources_department', $this->table . ".human_resources_department_id", '=', 'human_resources_department.id');
        $query->join('human_resources_organizational_chart_area', $this->table . ".human_resources_organizational_chart_area_id", '=', 'human_resources_organizational_chart_area.id');
        $query->join('human_resources_schedule_type', $this->table . ".human_resources_schedule_type_id", '=', 'human_resources_schedule_type.id');


        $query->leftJoin('business_by_employee_profile', $this->table . ".id", '=', 'business_by_employee_profile.human_resources_employee_profile_id');
        $query->leftJoin('users', "business_by_employee_profile.user_id", '=', 'users.id');

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";

            $query->where($this->table . '.identification_document', 'like', $likeSet);
            $query->orWhere('people_nationality.name', 'like', $likeSet);
            $query->orWhere('people_profession.name', 'like', $likeSet);
            $query->orWhere('people.name', 'like', $likeSet);
            $query->orWhere('people.last_name', 'like', $likeSet);
            $query->orWhere('human_resources_department.name', 'like', $likeSet);
        }
        $query->where($this->table . '.business_id', '=', $business_id);
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

    public function getAdmin($params)
    {
        $result = $this->getAdminData($params);


        foreach ($result["rows"] as $key => $row) {
            $setPush = json_decode(json_encode($row), true);
            $result["rows"][$key] = $setPush;
            if ($row->user_id) {
                $user_id = $row->user_id;
                $user = User::find($user_id);
                $roles = $user->roles->pluck('name', 'id')->toArray();
                $result["rows"][$key]['roles'] = $roles;
            }
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

            $model = new People();
            $createUpdate = true;

            $modelMultimedia = new Multimedia;
            $auxResource = "";

            if (isset($attributesPost["people_id"]) && $attributesPost["people_id"] != "null" && $attributesPost["people_id"] != "-1") {
                $model = People::find($attributesPost['people_id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }
            $postData = $attributesPost;
            $date_of_birth = $postData["date_of_birth"];
            $attributesSet = array(
                "last_name" => $postData["last_name"],
                "name" => $postData["name"],
                "birthdate" => $date_of_birth,
                "age" => 0,
                "gender" => $postData["gender"],

            );

            $source = $postData["source"];
            $pathSet = "/uploads/humanResourcesEmployeeProfile/profile";
            $change = $postData["change"];
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
                $validateResult = People::validateModel($attributesSet);
                $success = $validateResult["success"];
                if ($success) {
                    $modelC = new HumanResourcesEmployeeProfile();
                    $model->fill($attributesSet);
                    $model->save();
                    $people_id = $model->id;
                    $allow_source = 1;
                    $source = $allow_source == 1 ? $successMultimediaModel['source'] : 'none';

                    $attributesSet = array(
                        'description' => isset($postData["description"]) ? $postData["description"] : '',
                        'summary_web' => isset($postData["summary_web"]) ? $postData["summary_web"] : '',

                        "people_id" => $people_id,
                        "people_type_identification_id" => $postData["people_type_identification_id"],
                        "human_resources_schedule_type_id" => $postData["human_resources_schedule_type_id"],
                        "human_resources_organizational_chart_area_id" => $postData["human_resources_organizational_chart_area_id"],

                        "identification_document" => $postData["identification_document"],
                        "date_of_birth" => $date_of_birth,
                        "people_nationality_id" => $postData["people_nationality_id"],
                        "people_profession_id" => $postData["people_profession_id"],
                        "contract_date" => $postData["contract_date"],
                        "business_id" => $postData["business_id"],
                        "human_resources_department_id" => $postData["human_resources_department_id"],
                        "allow_view_page_web" => $postData["allow_view_page_web"],
                        'src' => $source
                    );
                    if (!$createUpdate) {
                        $modelC = HumanResourcesEmployeeProfile::find($attributesPost['id']);
                    }
                    $validateResult = HumanResourcesEmployeeProfile::validateModel($attributesSet);
                    $success = $validateResult["success"];
                    if ($success) {
                        $modelC->fill($attributesSet);
                        $modelC->save();
                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Empleado .";
                        $errors = $validateResult["errors"];
                    }
                } else {
                    $success = false;
                    $msj = "Problemas al guardar Persona .";
                    $errors = $validateResult["errors"];
                }
            } else {
                $success = false;
                $msj = "Problemas al guardar una imagen .";
                $errors = [
                    'source' => 'error al subir la imagen.'
                ];
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
    public function getManagementProfileFrontend($params)
    {
        $resultData = $this->getProfileData($params);
        $data = [];
        $success = $resultData ? true : false;
        $modelPhone = new \App\Models\InformationPhone();
        $modelEmails = new \App\Models\InformationMail();
        if ($success) {
            $data['parent'] = (array)$resultData;
            $entity_type = 1;
            $entity_id = $resultData->id;
            $main = 1;
            $setParams = [
                'filters' => [
                    'information_phone_type_id' => 2, //work
                    'main' => $main,
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                    'state' => 'ACTIVE',
                ]
            ];
            $dataSet =  $modelPhone->getInformationData($setParams);
            if ($dataSet) {
                $data['phones'] = $dataSet;
            }
            $setParams = [
                'filters' => [
                    'information_mail_type_id' => 1, //coorporativo
                    'main' => $main,
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                    'state' => 'ACTIVE',
                    'main' => 1,

                ]
            ];
            $dataSet =  $modelEmails->getInformationData($setParams);
            if ($dataSet) {
                $data['emails'] = $dataSet;
            }
            $modelSocialNetwork = new \App\Models\InformationSocialNetwork();
            $dataSet = $modelSocialNetwork->getAllFrontend([
                'filters' => [
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                ]

            ]);
            if ($dataSet) {

                $data['social-networks'] = $dataSet;
            }
        }

        $result['success'] = $success;
        $result['data'] = $data;
        return $result;
    }
    public function getManagementFrontend($params)
    {
        $resultData = $this->getData($params);
        $data = [];
        $success = $resultData ? true : false;
        $modelPhone = new \App\Models\InformationPhone();
        $modelEmails = new \App\Models\InformationMail();
        foreach ($resultData as $key => $row) {
            $data[$key]['parent'] = (array)$row;
            $entity_type = 1;
            $entity_id = $row->id;
            $main = 1;
            $setParams = [
                'filters' => [
                    'information_phone_type_id' => 2, //work
                    'main' => $main,
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                    'state' => 'ACTIVE',



                ]
            ];

            $dataSet =  $modelPhone->getInformationData($setParams);

            if ($dataSet) {

                $data[$key]['phones'] = $dataSet;
            }

            $setParams = [
                'filters' => [
                    'information_mail_type_id' => 1, //coorporativo
                    'main' => $main,
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                    'state' => 'ACTIVE',
                    'main' => 1,

                ]
            ];

            $dataSet =  $modelEmails->getInformationData($setParams);
            if ($dataSet) {
                $data[$key]['emails'] = $dataSet;
            }
            if (false) {


                $modelSocialNetwork = new \App\Models\InformationSocialNetwork();
                $dataSet = $modelSocialNetwork->getAllFrontend([
                    'filters' => [
                        'entity_id' => $entity_id,
                        'entity_type' => $entity_type,
                    ]

                ]);
                if ($dataSet) {
                    $data[$key]['social-networks'] = $dataSet;
                }
            }
        }

        $result['success'] = $success;
        $result['data'] = $data;
        return $result;
    }
    public function getProfileData($params)
    {

        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $id = $params['filters']['id'];
        $selectString = "$this->table.id ,$this->table.description ,$this->table.summary_web ,$this->table.allow_view_page_web,$this->table.people_id ,$this->table.people_type_identification_id,$this->table.people_type_identification_id,$this->table.identification_document,$this->table.src,$this->table.date_of_birth,$this->table.people_nationality_id,$this->table.people_profession_id,$this->table.contract_date,$this->table.status,$this->table.business_id,$this->table.human_resources_department_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,human_resources_department.name human_resources_department";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('people_nationality', $this->table . ".people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', $this->table . ".people_profession_id", '=', 'people_profession.id');
        $query->join('human_resources_department', $this->table . ".human_resources_department_id", '=', 'human_resources_department.id');
        $query->where($this->table . '.id', '=', $id);

        $result = $query->first();

        return $result;
    }
    public function getData($params)
    {

        $sort = 'asc';
        $field = 'people.name';
        $query = DB::table($this->table);
        $business_id = $params['filters']['business_id'];
        $selectString = "$this->table.id ,$this->table.description ,$this->table.summary_web ,$this->table.allow_view_page_web,$this->table.people_id ,$this->table.people_type_identification_id,$this->table.people_type_identification_id,$this->table.identification_document,$this->table.src,$this->table.date_of_birth,$this->table.people_nationality_id,$this->table.people_profession_id,$this->table.contract_date,$this->table.status,$this->table.business_id,$this->table.human_resources_department_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,human_resources_department.name human_resources_department";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('people_nationality', $this->table . ".people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', $this->table . ".people_profession_id", '=', 'people_profession.id');
        $query->join('human_resources_department', $this->table . ".human_resources_department_id", '=', 'human_resources_department.id');
        $query->where($this->table . '.business_id', '=', $business_id);
        $query->where($this->table . '.allow_view_page_web', '=', 1);
        $query->where($this->table . '.status', '=', 'ACTIVE');

        // sort
        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();

        return $result;
    }
    public function getFullNameListDataAreaAll($params)
    {


        $query = DB::table($this->table);
        $id = $params['filters']['manager_id'];
        $selectString = "$this->table.id ,$this->table.description ,$this->table.summary_web ,$this->table.allow_view_page_web,$this->table.people_id ,$this->table.people_type_identification_id,$this->table.people_type_identification_id,$this->table.identification_document,$this->table.src,$this->table.date_of_birth,$this->table.people_nationality_id,$this->table.people_profession_id,$this->table.contract_date,$this->table.status,$this->table.business_id,$this->table.human_resources_department_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,CONCAT(people.last_name ,' ',people.name) text
  ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('people_nationality', $this->table . ".people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', $this->table . ".people_profession_id", '=', 'people_profession.id');
       $business_id = ($params['filters']["businessId"]);
        if (isset($params['filters']["search_value"]["term"])) {
            $like = $params['filters']["search_value"]["term"];
            $query->where('people.name', 'like', '%' . $like . '%');
            $query->where('people.last_name', 'like', '%' . $like . '%');

        }
        $query->where($this->table.'.business_id', '=', $business_id);
        $query->limit(10)->orderBy('id', 'asc');
        $result = $query->get()->toArray();

        return $result;
    }
    public function getFullNameListDataDepartmentAll($params)
    {


        $query = DB::table($this->table);
        $id = $params['filters']['manager_id'];
        $selectString = "$this->table.id ,$this->table.description ,$this->table.summary_web ,$this->table.allow_view_page_web,$this->table.people_id ,$this->table.people_type_identification_id,$this->table.people_type_identification_id,$this->table.identification_document,$this->table.src,$this->table.date_of_birth,$this->table.people_nationality_id,$this->table.people_profession_id,$this->table.contract_date,$this->table.status,$this->table.business_id,$this->table.human_resources_department_id
  ,people_type_identification.name people_type_identification
  ,people.last_name ,people.name ,people.birthdate,people.age,people.gender
  ,people_nationality.name people_nationality
  ,people_profession.name people_profession
  ,CONCAT(people.last_name ,' ',people.name) text
  ";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('people_type_identification', $this->table . '.people_type_identification_id', '=', 'people_type_identification.id');
        $query->join('people', $this->table . '.people_id', '=', 'people.id');
        $query->join('people_nationality', $this->table . ".people_nationality_id", '=', 'people_nationality.id');
        $query->join('people_profession', $this->table . ".people_profession_id", '=', 'people_profession.id');
        $business_id = ($params['filters']["businessId"]);
        if (isset($params['filters']["search_value"]["term"])) {
            $like = $params['filters']["search_value"]["term"];
            $query->where('people.name', 'like', '%' . $like . '%');
            $query->where('people.last_name', 'like', '%' . $like . '%');

        }
        $query->where($this->table.'.business_id', '=', $business_id);
        $query->limit(10)->orderBy('id', 'asc');
        $result = $query->get()->toArray();

        return $result;
    }
}
