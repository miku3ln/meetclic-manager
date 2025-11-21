<?php

namespace App\Models;

use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Auth;


class BusinessByCounter extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';
    protected $table = 'business_by_counter';

    protected $fillable = array(
        'count',//*
        'business_id',//*
        'action_name',

        "source_origin",
        "referer_url",
        "campaign_code",
        "device_agent",
        "ip_address",
        "type_process",

    );
    protected $attributesData = [
        ['column' => 'count', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'business_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],

        ['column' => 'source_origin', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'referer_url', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'campaign_code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'device_agent', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'ip_address', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'type_process', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],

    ];
    public $timestamps = false;

    protected $field_main = 'id';

    public static function getRulesModel()
    {
        $rules = ["count" => "required|numeric",
            "business_id" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.count,business.title as business,
business.id as business_id
";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.count', 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
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
            $modelName = 'BusinessByCounter';
            $model = new BusinessByCounter();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = BusinessByCounter::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $businessByCounterData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $businessByCounterData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  BusinessByCounter.";
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
        $query->join('business', 'business.id', '=', $this->table . '.business_id');
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.count', 'like', '%' . $likeSet . '%');
                $query->orWhere("business.title", 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

//COUNTER-001
    public function getCounterBusiness($params)
    {

        $business_id = $params['filters']['business_id'];
        $action_name = $params['filters']['action_name'];
        $source_origin = $params['filters']['source_origin'];
        $ip_address = $params['filters']['ip_address'];
        $type_process = $params['filters']['type_process'];
        $device_agent = $params['filters']['device_agent'];
        $token = $params['filters']['token'];
        $source_id = $params['filters']['source_id'];
        $click_type_id = $params['filters']['click_type_id'];

        $is_guess = $params['filters']['is_guess'] ? 1 : 0;
        $user_id = $params['filters']['user_id'];
        $dateCurrent = date('Y-m-d');

        $tableMain = "tracking_events";
        $query = DB::table($tableMain);
        $selectString = "$tableMain.id ,$tableMain.count";
        $select = DB::raw($selectString);
        $query->select($select);
        $joinOne = "tracking_sessions";
        $joinOneRelationField = "session_id";
        $joinTwo = "tracking_sources";
        $joinTwoRelationField = "source_id";
        $joinThree = "tracking_click_types";
        $joinThreeRelationField = "click_type_id";
        $query->join($joinOne, $joinOne . '.id', '=', $tableMain . '.' . $joinOneRelationField);
        $query->join($joinTwo, $joinTwo . '.id', '=', $joinOne . '.' . $joinTwoRelationField);
        $query->join($joinThree, $joinThree . '.id', '=', $tableMain . '.' . $joinThreeRelationField);
        $query->where($joinOne . '.business_id', '=', $business_id);
        $query->where($tableMain . '.action_name', '=', $action_name);
        $query->where($joinTwo . '.id', '=', $source_id);//CHANGE
        $query->where($joinOne . '.ip_address', '=', $ip_address);
        $query->where($joinThree . '.id', '=', $click_type_id);
        $query->where($joinOne . '.user_id', '=', $user_id);
        $query->where($joinOne . '.device_agent', '=', $device_agent);
        $query->where($joinOne . '.token', '=', $token);

        $query->where(DB::raw("DATE($tableMain.created_at)"), '=', $dateCurrent);
        $result = $query->first();

        return $result;

    }

//COUNTER-001
    public function managerCounter($params)
    {

        $counterBusiness = $this->getCounterBusiness($params);

        $is_guess = $params['filters']['is_guess'] ? 1 : 0;
        if ($counterBusiness == null) {
            $managerData = [
                'attributesPost' => [
                    'TrackingSessions' => [
                        'token' => $params['filters']['token'],
                        'user_id' => $params['filters']['user_id'],
                        'business_id' => $params['filters']['business_id'],
                        'business_by_counter_id' => 1,
                        'is_guest' => $is_guess,
                        'source_origin' => $params['filters']['source_origin'],
                        'referer_url' => $params['filters']['referer_url'],
                        'campaign_code' => $params['filters']['campaign_code'],
                        'device_agent' => $params['filters']['device_agent'],//
                        'ip_address' => $params['filters']['ip_address'],//
                        "country" => $params['filters']['country'],
                        "region" => $params['filters']['region'],
                        "city" => $params['filters']['city'],
                        "latitude" => $params['filters']['latitude'],
                        "longitude" => $params['filters']['longitude'],
                        'source_id' => $params['filters']['source_id'],


                    ],
                    'TrackingEvents' => [
                        'type_process' => $params['filters']['type_process'],
                        'action_name' => $params['filters']['action_name'],
                        'manager_click_id' => $params['filters']['manager_click_id'],
                        'manager_click_type' => $params['filters']['manager_click_type'],
                        'count' => 1,//
                        'url' => $params['filters']['referer_url'],
                        'section' => $params['filters']['action_name'],
                        'click_type_id' => $params['filters']['click_type_id'],

                    ],
                ]];

            $resultAll = $this->saveDataCounter($managerData);


        } else {//
            $modelCounter = \App\Models\Tracking\TrackingEvents::find($counterBusiness->id);
            if ($modelCounter) {//only new user(anonymous or register)
                $modelCounter->fill([
                    'count' => $modelCounter->count + 1
                ]);
                $modelCounter->save();
            }
        }

        $modelLog = new \App\Models\CounterByLogUserToBusiness();
        $resultSaveLog = $modelLog->saveData([
            'attributesPost' => [
                'CounterByLogUserToBusiness' => [
                    'is_guess' => $is_guess,
                    'token' => $params['filters']['token'],
                    'business_id' => $params['filters']['business_id'],
                    'user_id' => $params['filters']['user_id'],
                    'manager_click_type' => $params['filters']['manager_click_type'],
                    'manager_click_id' => $params['filters']['manager_click_id'],
                    'action_name' => $params['filters']['action_name'],
                    'source_origin' => $params['filters']['source_origin'],
                    'referer_url' => $params['filters']['referer_url'],
                    'campaign_code' => $params['filters']['campaign_code'],
                    'device_agent' => $params['filters']['device_agent'],
                    'ip_address' => $params['filters']['ip_address'],
                    'type_process' => $params['filters']['type_process'],


                ]
            ]
        ]);
        $location = [
            "country" => $params['filters']['country'],
            "region" => $params['filters']['region'],
            "city" => $params['filters']['city'],
            "latitude" => $params['filters']['latitude'],
            "longitude" => $params['filters']['longitude']
        ];

        //SAVE DATA LOCATION
        $modelLocation = new \App\Models\Tracking\CounterTrackingRegistry();
        $attributesSetLocation = $location;
        $attributesSetLocation['source_id'] = $resultSaveLog["model"]->id;
        $attributesSetLocation['source_table'] = $modelLocation::TYPE_SOURCE_TABLE_CBLUTB;
        $paramsValidateLocation = array(
            'modelAttributes' => $attributesSetLocation,
            'rules' => $modelLocation::getRulesModel(),

        );
        $validateResultLocation = $modelLocation->validateModel($paramsValidateLocation);
        $success = $validateResultLocation["success"];
        if ($success) {
            $modelLocation->fill($attributesSetLocation);
            $success = $modelLocation->save();


        } else {
            $success = false;
            $msj = "Problemas al guardar Location BusinessByCounter.";
            $errors = $validateResultLocation["errors"];
        }
    }


//COUNTER-001
    public function saveDataCounter($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'TrackingSessions';
            $model = new  \App\Models\Tracking\TrackingSessions();
            $attributesSet = $attributesPost[$modelName];
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => $model::getRulesModel(),

            );

            //type_process
            $validateResult = $this->validateModel($paramsValidate);

            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();

                $session_id = $model->id;
                $modelParent = new \App\Models\Tracking\TrackingEvents();
                $attributesSetParent = $attributesPost["TrackingEvents"];
                $attributesSetParent["session_id"] = $session_id;
                if (!is_string($attributesSetParent["manager_click_id"])) {

                    $attributesSetParent["manager_click_id"] = (string)$attributesSetParent["manager_click_id"];
                }
                $paramsValidateParent = array(
                    'modelAttributes' => $attributesSetParent,
                    'rules' => $modelParent::getRulesModel(),
                );

                $validateResultParent = $modelParent->validateModel($paramsValidateParent);
                $success = $validateResultParent["success"];

                if ($success) {
                    $modelParent->fill($attributesSetParent);
                    $success = $modelParent->save();


                } else {
                    $success = false;
                    $msj = "Problemas al guardar Events.";
                    $errors = $validateResultParent["errors"];
                }


            } else {
                $success = false;
                $msj = "Problemas al guardar  .";
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

        }

        return ($result);
    }


    //COUNTER-001
    public function managerCounter2($params)
    {


        //is new
        $counterBusiness = $this->getCounterBusiness($params);
        $is_guess = $params['filters']['is_guess'] ? 1 : 0;

        if ($counterBusiness == null) {
            $managerData = [
                'attributesPost' => [
                    'BusinessByCounter' => [
                        'count' => 1,
                        'business_id' => $params['filters']['business_id'],
                        'manager_click_type' => $params['filters']['manager_click_type'],
                        'manager_click_id' => $params['filters']['manager_click_id'],
                        'action_name' => $params['filters']['action_name'],
                        'source_origin' => $params['filters']['source_origin'],
                        'referer_url' => $params['filters']['referer_url'],
                        'campaign_code' => $params['filters']['campaign_code'],
                        'device_agent' => $params['filters']['device_agent'],
                        'ip_address' => $params['filters']['ip_address'],
                        'type_process' => $params['filters']['type_process'],
                        "CounterTrackingRegistry" => [
                            "country" => $params['filters']['country'],
                            "region" => $params['filters']['region'],
                            "city" => $params['filters']['city'],
                            "latitude" => $params['filters']['latitude'],
                            "longitude" => $params['filters']['longitude']
                        ]
                    ],
                    'CounterByEntity' => [
                        'is_guess' => $is_guess,
                        'token' => $params['filters']['token'],
                        'user_id' => $params['filters']['user_id'],
                        'manager_click_type' => $params['filters']['manager_click_type'],
                        'manager_click_id' => $params['filters']['manager_click_id'],
                        'action_name' => $params['filters']['action_name'],
                        'source_origin' => $params['filters']['source_origin'],
                        'referer_url' => $params['filters']['referer_url'],
                        'campaign_code' => $params['filters']['campaign_code'],
                        'device_agent' => $params['filters']['device_agent'],
                        'ip_address' => $params['filters']['ip_address'],
                        'type_process' => $params['filters']['type_process'],
                        "CounterTrackingRegistry" => [
                            "country" => $params['filters']['country'],
                            "region" => $params['filters']['region'],
                            "city" => $params['filters']['city'],
                            "latitude" => $params['filters']['latitude'],
                            "longitude" => $params['filters']['longitude']
                        ]

                    ],
                ]];
            $resultAll = $this->saveDataCounter($managerData);

        } else {//

            $business_by_counter_id = $counterBusiness->id;
            $modelEntity = new \App\Models\CounterByEntity();
            $params['filters']['business_by_counter_id'] = $business_by_counter_id;
            $resultEntity = $modelEntity->getAllowCounter($params);
            if (!$resultEntity) {//only new user(anonymous or register)
                $modelCounter = \App\Models\BusinessByCounter::find($counterBusiness->id);
                $modelCounter->fill([
                    'count' => $modelCounter->count + 1
                ]);
                $modelCounter->save();

                $modelName = 'CounterByEntity';
                $model = new \App\Models\CounterByEntity();
                $attributesSet = [
                    'is_guess' => $is_guess,
                    'token' => $params['filters']['token'],
                    'user_id' => $params['filters']['user_id'],
                    'manager_click_type' => $params['filters']['manager_click_type'],
                    'manager_click_id' => $params['filters']['manager_click_id'],
                    'action_name' => $params['filters']['action_name'],
                    'source_origin' => $params['filters']['source_origin'],
                    'referer_url' => $params['filters']['referer_url'],
                    'campaign_code' => $params['filters']['campaign_code'],
                    'device_agent' => $params['filters']['device_agent'],
                    'ip_address' => $params['filters']['ip_address'],
                    'type_process' => $params['filters']['type_process'],
                ];
                $attributesSet['business_by_counter_id'] = $business_by_counter_id;
                $paramsValidate = array(
                    'modelAttributes' => $attributesSet,
                    'rules' => $model::getRulesModel(),

                );

                $validateResult = $model->validateModel($paramsValidate);
                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                } else {
                    $success = false;
                    $msj = "Problemas al guardar Counter Entity.";
                    $errors = $validateResult["errors"];
                }

            }


        }

        $modelLog = new \App\Models\CounterByLogUserToBusiness();
        $resultSaveLog = $modelLog->saveData([
            'attributesPost' => [
                'CounterByLogUserToBusiness' => [
                    'is_guess' => $is_guess,
                    'token' => $params['filters']['token'],
                    'business_id' => $params['filters']['business_id'],
                    'user_id' => $params['filters']['user_id'],
                    'manager_click_type' => $params['filters']['manager_click_type'],
                    'manager_click_id' => $params['filters']['manager_click_id'],
                    'action_name' => $params['filters']['action_name'],
                    'source_origin' => $params['filters']['source_origin'],
                    'referer_url' => $params['filters']['referer_url'],
                    'campaign_code' => $params['filters']['campaign_code'],
                    'device_agent' => $params['filters']['device_agent'],
                    'ip_address' => $params['filters']['ip_address'],
                    'type_process' => $params['filters']['type_process'],


                ]
            ]
        ]);
        $location = [
            "country" => $params['filters']['country'],
            "region" => $params['filters']['region'],
            "city" => $params['filters']['city'],
            "latitude" => $params['filters']['latitude'],
            "longitude" => $params['filters']['longitude']
        ];

        //SAVE DATA LOCATION
        $modelLocation = new \App\Models\Tracking\CounterTrackingRegistry();
        $attributesSetLocation = $location;
        $attributesSetLocation['source_id'] = $resultSaveLog["model"]->id;
        $attributesSetLocation['source_table'] = $modelLocation::TYPE_SOURCE_TABLE_CBLUTB;
        $paramsValidateLocation = array(
            'modelAttributes' => $attributesSetLocation,
            'rules' => $modelLocation::getRulesModel(),

        );
        $validateResultLocation = $modelLocation->validateModel($paramsValidateLocation);
        $success = $validateResultLocation["success"];
        if ($success) {
            $modelLocation->fill($attributesSetLocation);
            $success = $modelLocation->save();


        } else {
            $success = false;
            $msj = "Problemas al guardar Location BusinessByCounter.";
            $errors = $validateResultLocation["errors"];
        }
    }

    public function getCounterBusiness2($params)
    {

        $business_id = $params['filters']['business_id'];
        $action_name = $params['filters']['action_name'];
        $source_origin = $params['filters']['source_origin'];
        $ip_address = $params['filters']['ip_address'];
        $type_process = $params['filters']['type_process'];

        $is_guess = $params['filters']['is_guess'] ? 1 : 0;
        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.count";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where($this->table . '.business_id', '=', $business_id);
        $query->where($this->table . '.action_name', '=', $action_name);
        $query->where($this->table . '.source_origin', '=', $source_origin);
        $query->where($this->table . '.ip_address', '=', $ip_address);
        $query->where($this->table . '.type_process', '=', $type_process);


        $result = $query->first();
        return $result;

    }

//COUNTER-001
    public function saveDataCounter2($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        DB::beginTransaction();
        try {
            $modelName = 'BusinessByCounter';
            $model = new BusinessByCounter();
            $businessByCounterData = $attributesPost[$modelName];

            $attributesSet = $businessByCounterData;
            $paramsValidate = array(
                'modelAttributes' => $attributesSet,
                'rules' => self::getRulesModel(),

            );
            $validateResult = $this->validateModel($paramsValidate);
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $success = $model->save();
                $business_by_counter_id = $model->id;

                //SAVE DATA LOCATION
                $modelLocation = new \App\Models\Tracking\CounterTrackingRegistry();
                $attributesSetLocation = $attributesPost[$modelName]["CounterTrackingRegistry"];
                $attributesSetLocation['source_id'] = $business_by_counter_id;
                $attributesSetLocation['source_table'] = $modelLocation::TYPE_SOURCE_TABLE_BC;
                $paramsValidateLocation = array(
                    'modelAttributes' => $attributesSetLocation,
                    'rules' => $modelLocation::getRulesModel(),

                );
                $validateResultLocation = $modelLocation->validateModel($paramsValidateLocation);
                $success = $validateResultLocation["success"];
                if ($success) {
                    $modelLocation->fill($attributesSetLocation);
                    $success = $modelLocation->save();


                } else {
                    $success = false;
                    $msj = "Problemas al guardar Location BusinessByCounter.";
                    $errors = $validateResultLocation["errors"];
                }


                $modelName = 'CounterByEntity';
                $model = new \App\Models\CounterByEntity();
                $attributesSet = $attributesPost[$modelName];
                $attributesSet['business_by_counter_id'] = $business_by_counter_id;
                $paramsValidate = array(
                    'modelAttributes' => $attributesSet,
                    'rules' => $model::getRulesModel(),

                );
                $validateResult = $model->validateModel($paramsValidate);


                //SAVE DATA LOCATION

                $success = $validateResult["success"];
                if ($success) {
                    $model->fill($attributesSet);
                    $success = $model->save();
                    $source_id = $model->id;


                    //SAVE DATA LOCATION
                    $modelLocation = new \App\Models\Tracking\CounterTrackingRegistry();
                    $attributesSetLocation = $attributesPost[$modelName]["CounterTrackingRegistry"];
                    $attributesSetLocation['source_id'] = $source_id;
                    $attributesSetLocation['source_table'] = $modelLocation::TYPE_SOURCE_TABLE_CBE;
                    $paramsValidateLocation = array(
                        'modelAttributes' => $attributesSetLocation,
                        'rules' => $modelLocation::getRulesModel(),

                    );
                    $validateResultLocation = $modelLocation->validateModel($paramsValidateLocation);
                    $success = $validateResultLocation["success"];
                    if ($success) {
                        $modelLocation->fill($attributesSetLocation);
                        $success = $modelLocation->save();


                    } else {
                        $success = false;
                        $msj = "Problemas al guardar Location BusinessByCounter.";
                        $errors = $validateResultLocation["errors"];
                    }


                } else {
                    $success = false;
                    $msj = "Problemas al guardar Counter Entity.";
                    $errors = $validateResult["errors"];
                }


            } else {
                $success = false;
                $msj = "Problemas al guardar  BusinessByCounter.";
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

}
