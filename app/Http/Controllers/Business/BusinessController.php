<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\MyBaseController;
use App\Models\Business;
use App\Models\Country;
use Illuminate\Support\Facades\Request;


use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Services\FirebaseService;
use App\Models\BusinessSubcategories;
use App\Models\BusinessBySchedule;

use App\Models\Multimedia;

use Auth;

class BusinessController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public $table = "business";
    public $name_manager = "Negocio";

    public function index()
    {
        $model = new Business();
        $camerCase = $model->getCamelCase();
        $renderView = $camerCase . ".index";
        $model_entity = $camerCase;
        $actions = $model->getActionsManager();

        $configFirebase = "";
        $paramsSend = [
            "model_entity" => $model_entity,
            "name_manager" => $this->name_manager,
            "icon_manager" => "flaticon-cogwheel-2",
            "actions" => $actions,
            "configFirebase" => $configFirebase
        ];
        $this->layout->content = View::make($renderView, $paramsSend);
    }

    public function getListBusiness()
    {
        $data = Request::all();
        $query = Business::query();
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);

        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'name';
        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

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
        $data = $query->get()->toArray();
        $meta = [
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total,
        ];
        $sort = [
            'sort' => $sort,
            'field' => $field,
        ];
        $result = array(
            'meta' => $meta + $sort,
            'data' => $data
        );
        return Response::json(
            $result
        );
    }

    public function getFormBusiness($id = null)
    {
        $method = 'POST';
        $dataSnap = array();
        if ($id) {
            $firebaseService = new FirebaseService();
            $params = [
                "reference" => "business",
                "data" => $id
            ];
            $result = $firebaseService->getDataSnap($params);
            $arrayResult = $result->getValue();
            $dataSnap = $arrayResult[$id];

            $dataSnap["id"] = $id;
            $dataSnap["business_id"] = $id;
        }

        $model = new Business();

        $model = new Business($dataSnap);

        if ($id) {
            $model->fill($dataSnap);
        }
        $camerCase = $model->getCamelCase();
        $model_entity = $model->getTable();
        $modelS = new BusinessSubcategories();

        $subcategories = $modelS->getSubcategories();

        $renderView = $camerCase . '.loads._form';

        $view = View::make($renderView, [
            'method' => $method,
            'model' => $model,
            "model_entity" => $model_entity,
            "subcategories" => $subcategories,
            "frmId" => $camerCase//debe d ser igual al del boton save
        ])->render();
        return Response::json(array(
            'html' => $view
        ));


    }

    public function getListSelect2()
    {
        $data = Request::all();
        $query = Business::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', Business::STATUS_ACTIVE);
        $query->limit(10)->orderBy('name', 'asc');
        $modelList = $query->get()->toArray();
        return Response::json(
            $modelList
        );
    }

    public function saveFB()
    {
        $create_update = true;
        try {
            $model = new Business();
            $attributesPost = Request::all();

            if ($attributesPost[$model->getTable() . '_id'] == '') { //Create
                $create_update = true;
                //$model->status = 'ACTIVE';
            } else { //Update
                $create_update = false;

            }
            $firebaseService = new FirebaseService();

            if ($create_update) {
                $params = [
                    "reference" => "business",
                    "data" => $attributesPost
                ];
                $resultReference = $firebaseService->pushData($params);
            } else {
                $params = [
                    "reference" => "business/" . $attributesPost[$model->getTable() . '_id'],
                    "data" => $attributesPost,
                    "key" => "business/" . $attributesPost[$model->getTable() . '_id']
                ];
                $resultReference = $firebaseService->updateData($params);
            }

            $model->fill($attributesPost);
            //$model->save();
            $result = [
                "resultReference" => $resultReference,
                "save" => true
            ];
            return Response::json($result);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }

    public function saveBusiness()
    {
        $create_update = true;
        $dataSchedules = array();
        $success = false;
        $msj = "";
        $result = array();
        DB::beginTransaction();
        $modelMultimedia = new Multimedia;
        try {
            $model = new Business();
            $modelBBS = new BusinessBySchedule();
            $allowSaveProcess = true;
            $createUpdate = true;
            $attributesPost = Request::all();
            $attributes = array();
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "-1") {
                $allowSaveProcess = false;
                $createUpdate = false;
                $model = Business::find($attributesPost['id']);
                $auxResource = $model->source;

            }
            $user = Auth::user();
            $source = $attributesPost["source"];
            $pathSet = "/uploads/business/information";
            $change = $attributesPost["change"];
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
                $attributes = array(
                    "description" => isset($attributesPost["description"]) ? $attributesPost["description"] : "",
                    "title" => $attributesPost["description"],
                    "email" => $attributesPost["email"],
                    "page_url" => $attributesPost["page_url"],
                    "phone_value" => $attributesPost["phone_value"],
                    "street_1" => $attributesPost["street_1"],
                    "street_2" => $attributesPost["street_2"],
                    "street_lat" => $attributesPost["street_lat"],
                    "street_lng" => $attributesPost["street_lng"],
                    "business_subcategories_id" => $attributesPost["business_subcategories_id"],
                    "countries_id" => $attributesPost["countries_id"],
                    "source" => $source,
                    "user_id" => $user->id,
                    "has_document" => isset($attributesPost["has_document"]) ? $attributesPost["has_document"] : 0,
                    "has_about" => isset($attributesPost["has_about"]) ? $attributesPost["has_about"] : 0,

                );
                $model->fill($attributes);
                $success = $model->save();
                if ($success) {
                    $business_id = $model->id;
                    if ($allowSaveProcess) {
                        $dataSchedules = $modelBBS->getSchedulesStructureInit(array("business_id" => $business_id));
                        foreach ($dataSchedules as $key => $attributes) {
                            $modelBBSSave = new BusinessBySchedule();
                            $modelBBSSave->fill($attributes);
                            $success = $modelBBSSave->save();
                            if ($success) {
                                $dataSchedules[$key]["id"] = $modelBBSSave->id;
                            } else {
                                $msj = "Problemas al guardar Negocio Horario";
                                throw new \Exception($msj);
                            }
                        }

                        $modelGamification = new \App\Models\Gamification();
                        $attributesCurrent = [
                            'value' => 'Configuracion Inicial Gamificacion',
                            'description' => 'Configuracion',
                            'state' => 'ACTIVE',
                            'value_unit' => 0,
                        ];

                        $paramsValidate = array(
                            'modelAttributes' => $attributesCurrent,
                            'rules' => $modelGamification::getRulesModel(),

                        );

                        $validateResult = $modelGamification->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if (!$success) {
                            $msj = "Problemas al guardar Gamificacion";
                            throw new \Exception($msj);
                        } else {
                            $modelGamification->fill($attributesCurrent);
                            $success = $modelGamification->save();
                            $gamification_id = $modelGamification->id;

                            $modelGamificationBusiness = new \App\Models\BusinessByGamification();
                            $attributesCurrent = [
                                'gamification_id' => $gamification_id,
                                'business_id' => $business_id,
                                'allow_exchange' => 0,
                                'allow_exchange_business' => 0,
                                'state' => 'ACTIVE',

                            ];

                            $paramsValidate = array(
                                'modelAttributes' => $attributesCurrent,
                                'rules' => $modelGamificationBusiness::getRulesModel(),

                            );

                            $validateResult = $modelGamificationBusiness->validateModel($paramsValidate);
                            $success = $validateResult["success"];
                            if (!$success) {
                                $msj = "Problemas al guardar Gamificacion Business";
                                throw new \Exception($msj);
                            } else {
                                $modelGamificationBusiness->fill($attributesCurrent);
                                $success = $modelGamificationBusiness->save();
                            }
                        }

                    }
                } else {

                    $msj = "Problemas al guardar Negocio";
                    throw new \Exception($msj);
                }


                if (!$success) {
                    $msj = "Problemas al guardar";
                    DB::rollBack();
                    throw new \Exception($msj);
                } else {
                    // Else commit the queries
                    DB::commit();
                    $success = true;
                }

                $modelData = $attributesPost;
                $modelData["id"] = $model->id;
                $modelData["source"] = $source;
                $result = [
                    "modelData" => $modelData,
                    "schedulesData" => $dataSchedules,
                    "success" => $success
                ];
            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }
            return Response::json($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj
            );
            return Response::json($result);
        }
    }

    public static function validateModel($params)
    {
        $messages = [
            'same' => env('validation.same'),
            'size' => env('validation.size'),
            'between' => env('validation.between'),
            'in' => env('validation.in'),
            'required' => env('validation.required'),
            'unique' => env('validation.unique'),
            'email' => env('validation.email'),

        ];

        $modelAttributes = isset($params['inputs']) ? $params['inputs'] : $params['modelAttributes'];

        $rules = $params['rules'];
        $validation = Validator::make($modelAttributes, $rules, $messages);
        $success = $validation->passes();
        $errors = [];
        $errorsFields = [];
        if (!$success) {
            $errors = $validation->errors()->all();
            $errorsObject = $validation->errors();
            foreach ($errorsObject->messages() as $error => $value) {
                $errorsFields[$error] = $value;
            }
        }
        $result = array("success" => $success, "errors" => $errors, 'errorsFields' => $errorsFields);


        return $result;
    }

    public function saveData()
    {
        $create_update = true;
        $dataSchedules = array();
        $success = false;
        $msj = "";
        $result = array();
        $data = [];
        DB::beginTransaction();
        $modelMultimedia = new Multimedia;
        $modelData = [];
        try {
            $model = new Business();


            $modelBBS = new BusinessBySchedule();
            $allowSaveProcess = true;
            $createUpdate = true;
            $attributesPost = Request::all();
            $model->type_business = 0;
            $model->type_manager_payment = 0;
            $model->entity_plans_id = 3;
            $model->business_name = $attributesPost["title"];
            $model->document = "100";
            $model->entity_position_fiscal_id = 1;


            $attributes = array();
            $paramsModelBusiness = [

            ];
            $auxResource = "";
            if (isset($attributesPost["id"]) && $attributesPost["id"] != "-1") {
                $allowSaveProcess = false;
                $createUpdate = false;
                $model = Business::find($attributesPost['id']);
                $auxResource = $model->source;
                $paramsModelBusiness = [
                    'id' => $attributesPost['id']
                ];

            }
            $user = Auth::user();
            $source = $attributesPost["source"];
            $file = $attributesPost["source"];
            $pathSet = "/uploads/business/information";
            $change = $attributesPost["change"];
            $resultMultimedia = array();
            $changeImage = false;

            if ($change != "undefined") {
                if ($createUpdate) {
                    $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
                    $source = $resultMultimedia["uploadedImageData"]["destinationPublic"];
                } else {
                    if ($change == "true") {
                        $resultMultimedia = $modelMultimedia->managerUpload(array("file" => $file, "pathSet" => $pathSet));
                        $source = $resultMultimedia["uploadedImageData"]["destinationPublic"];
                    } else {
                        $changeImage = true;
                    }
                }


            } else {
                $changeImage = true;
            }

            $successMultimedia = isset($resultMultimedia["success"]) ? $resultMultimedia["success"] : $changeImage;
            if ($successMultimedia) {
                if (!$createUpdate) {
                    if ($auxResource != "nothing" && $change == "true") {
                        $modelMultimedia->deleteResource(array("path" => $auxResource));
                    }

                }
                $attributes = array(
                    "description" => isset($attributesPost["description"]) ? $attributesPost["description"] : "",
                    "title" => $attributesPost["title"],
                    "email" => $attributesPost["email"],
                    "page_url" => $attributesPost["page_url"],
                    "phone_value" => $attributesPost["phone_value"],
                    "street_1" => $attributesPost["street_1"],
                    "street_2" => $attributesPost["street_2"],
                    "street_lat" => $attributesPost["street_lat"],
                    "street_lng" => $attributesPost["street_lng"],
                    "business_subcategories_id" => $attributesPost["business_subcategories_id"],
                    "countries_id" => $attributesPost["countries_id"],
                    "source" => $source,
                    "user_id" => $user->id,
                    "has_document" => isset($attributesPost["has_document"]) ? $attributesPost["has_document"] : 0,
                    "has_about" => isset($attributesPost["has_about"]) ? $attributesPost["has_about"] : 0,
                    "has_service_delivery" => isset($attributesPost["has_service_delivery"]) ? $attributesPost["has_service_delivery"] : 0,
                    "type_business" => isset($attributesPost["type_business"]) ? $attributesPost["type_business"] : 0,
                    "type_manager_payment" => isset($attributesPost["type_manager_payment"]) ? $attributesPost["type_manager_payment"] : 0,

                );

                if ($createUpdate) {
                    $attributes['status'] = 'ACTIVE';
                    $attributes['qualification'] = 0;

                } else {
                    $attributes['status'] = isset($attributesPost["status"]) ? $attributesPost["status"] : $model->status;
                    $attributes['qualification'] = $model->qualification;

                }
                $attributesSet = $attributes;
                $paramsValidate = array(
                    'inputs' => $attributesSet,
                    'rules' => Business::getRulesModel(
                        $paramsModelBusiness
                    ),

                );

                $validateResult = $this->validateModel($paramsValidate);
                $success = $validateResult['success'];
                if ($success) {

                    $model->fill($attributesSet);
                    $success = $model->save();
                    $business_id = $model->id;
                    if ($allowSaveProcess) {

                        $dataSchedules = $modelBBS->getSchedulesStructureInit(array("business_id" => $business_id));
                        foreach ($dataSchedules as $key => $attributes) {
                            $modelBBSSave = new BusinessBySchedule();
                            $modelBBSSave->fill($attributes);
                            $success = $modelBBSSave->save();
                            if ($success) {
                                $dataSchedules[$key]["id"] = $modelBBSSave->id;
                            } else {
                                $msj = "Problemas al guardar Negocio Horario";

                                break;
                            }
                        }


                        $modelGamification = new \App\Models\Gamification();
                        $attributesCurrent = [
                            'value' => 'Configuracion Inicial Gamificacion',
                            'description' => 'Configuracion',
                            'state' => 'ACTIVE',
                            'value_unit' => 0,
                        ];

                        $paramsValidate = array(
                            'modelAttributes' => $attributesCurrent,
                            'rules' => $modelGamification::getRulesModel(),

                        );

                        $validateResult = $modelGamification->validateModel($paramsValidate);
                        $success = $validateResult["success"];
                        if (!$success) {
                            $msj = "Problemas al guardar Gamificacion";
                            throw new \Exception($msj);
                        } else {
                            $modelGamification->fill($attributesCurrent);
                            $success = $modelGamification->save();
                            $gamification_id = $modelGamification->id;

                            $modelGamificationBusiness = new \App\Models\BusinessByGamification();
                            $attributesCurrent = [
                                'gamification_id' => $gamification_id,
                                'business_id' => $business_id,
                                'allow_exchange' => 0,
                                'allow_exchange_business' => 0,
                                'state' => 'ACTIVE',

                            ];

                            $paramsValidate = array(
                                'modelAttributes' => $attributesCurrent,
                                'rules' => $modelGamificationBusiness::getRulesModel(),

                            );

                            $validateResult = $modelGamificationBusiness->validateModel($paramsValidate);
                            $success = $validateResult["success"];
                            if (!$success) {
                                $msj = "Problemas al guardar Gamificacion Business";
                                throw new \Exception($msj);
                            } else {
                                $modelGamificationBusiness->fill($attributesCurrent);
                                $success = $modelGamificationBusiness->save();
                            }
                        }

                    }

                    $bank_id = $attributesPost["bank_id"];
                    $type_account = $attributesPost["type_account"];
                    $account_number = $attributesPost["account_number"];
                    $business_disbursement_id = $attributesPost["business_disbursement_id"];
                    $modelDis = null;

                    if ($business_disbursement_id == 'null') {
                        $modelDis = new \App\Models\BusinessDisbursement();

                    } else {
                        $modelDis = \App\Models\BusinessDisbursement::find($business_disbursement_id);

                    }
                    $setPush = [
                        'bank_id' => $bank_id,
                        'account_number' => $account_number,
                        'type_account' => $type_account,
                        'business_id' => $business_id
                    ];
                    $paramsValidate = array(
                        'inputs' => $setPush,
                        'rules' => \App\Models\BusinessDisbursement::getRulesModel(),

                    );

                    $validateResult = $modelDis->validateModel($paramsValidate);
                    $success = $validateResult['success'];
                    if ($success) {
                        $modelDis->fill($setPush);
                        $success = $modelDis->save();
                    } else {
                        $msj = "Problemas al guardar Reembolso";
                        $errorsFields = $validateResult['errorsFields'];
                        $data['errors'] = $errorsFields;
                    }


                    $countries_id = $attributesPost["countries_id"];
                    $cities_id = $attributesPost["cities_id"];
                    $zones_id = $attributesPost["zones_id"];
                    $provinces_id = $attributesPost["provinces_id"];
                    $business_location_id = $attributesPost["business_location_id"];

                    $modelLocation = null;
                    if ($business_location_id == 'null') {
                        $modelLocation = new \App\Models\BusinessLocation();
                    } else {
                        $modelLocation = \App\Models\BusinessLocation::find($business_location_id);

                    }
                    $setPush = [
                        'cities_id' => $cities_id,
                        'zones_id' => $zones_id,
                        'countries_id' => $countries_id,
                        'provinces_id' => $provinces_id,
                        'business_id' => $business_id
                    ];
                    $paramsValidate = array(
                        'inputs' => $setPush,
                        'rules' => \App\Models\BusinessLocation::getRulesModel(),

                    );
                    $validateResult = $modelLocation->validateModel($paramsValidate);
                    $success = $validateResult['success'];
                    if ($success) {
                        $modelLocation->fill($setPush);
                        $success = $modelLocation->save();
                    } else {
                        $msj = "Problemas al guardar Location";
                        $errorsFields = $validateResult['errorsFields'];
                        $data['errors'] = $errorsFields;
                    }


                    $keys_manager = $attributesPost['business_by_amenities_data'];
                    $keys_manager = $keys_manager == null ? [] : explode(',', $keys_manager);
                    $model->amenities()->sync($keys_manager);

                } else {
                    $msj = "Problemas al guardar Negocio";
                    foreach ($validateResult['errors'] as $key => $value) {
                        $msj .= '<br>' . $value;
                    }

                    $errorsFields = $validateResult['errorsFields'];
                    $data['errors'] = $errorsFields;

                }
                if (!$success) {
                    DB::rollBack();
                } else {
                    // Else commit the queries
                    DB::commit();
                    $success = true;
                    $modelData = $attributesPost;
                    $modelData["id"] = $model->id;
                    $modelData["source"] = $source;

                }
                $result = [
                    "modelData" => $modelData,
                    "schedulesData" => $dataSchedules,
                    "success" => $success,
                    'msg' => $msj,
                    "message" => $msj,

                    'data' => $data
                ];
                return Response::json($result);

            } else {
                $msj = "Problemas al guardar la imagen.";
                DB::rollBack();
                throw new \Exception($msj);
            }
            return Response::json($result);
        } catch (Exception $e) {
            $msj = $e->getMessage();
            $success = false;
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "message" => $msj,

                'data' => $data
            );
            DB::rollBack();
            return Response::json($result);
        }
    }

    public function getWulpymesAdmin()
    {
        $dataPost = Request::all();
        $model = new Business();
        $result = $model->getBusinessAdminData($dataPost);

        return Response::json(
            $result
        );
    }

    public function getManager()
    {
        $model = new Business();
        $modelS = new BusinessSubcategories();
        $modelC = new Country();
        $modelBBS = new BusinessBySchedule();

        $subcategories = $modelS->getSubcategories();
        $countries = $modelC->getStructureDrop($modelC->getCountries());
        $moduleMain = "business";
        $moduleResource = "business";
        $moduleFolder = "business";
        $renderView = "$moduleMain.$moduleFolder.index";
        $model_entity = "business";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $camerCase = $model->getCamelCase();
        $user = Auth::user();
        $dataCatalogue = array(
            "subcategories" => $subcategories,
            "countries" => $countries

        );
        $paramsSend = [
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
                "dataCatalogue" => $dataCatalogue
            ),
            "rootView" => $rootView,
            "model_entity" => $model_entity,
            'model' => $model,
            'modelBBS' => $modelBBS,
            "pathCurrent" => $pathCurrent,
            "user" => $user,
            "step1" => array(
                "subcategories" => $subcategories,
                "frmId" => $camerCase,
                "model" => $model,
                "countries" => $countries
            )

        ];


        $this->layout->content = View::make($renderView, $paramsSend);
    }

    public function getAdmin()
    {
        $dataPost = Request::all();

        $model = new Business();
        $result = $model->getAdmin($dataPost);
        return Response::json(
            $result
        );
    }

    public function getAdminEmployer()
    {
        $dataPost = Request::all();

        $model = new Business();
        $result = $model->getAdminEmployer($dataPost);
        return Response::json(
            $result
        );
    }
    public function saveDataFrontend()
    {

        $attributesPost = Request::all();
        $model = new Business();
        $result = $model->saveDataFrontend(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }

    public function getManagementBusinessEvents()
    {

        $attributesPost = Request::all();
        $model = new  Business();
        $result = $model->getManagementBusinessEvents($attributesPost);
        return Response::json($result);
    }
}

