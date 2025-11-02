<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class EntityAuthorizationConfiguration extends ModelManager
{
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    const INVOICE_SALES_TYPE = "INVOICE";
    const REMISSION_GUIDE_TYPE = "REFERENCE GUIDE";
    const RETENTION_TYPE = "RETENTIONS";
    const RETENTION_RECEIPT_TYPE = "RETENTION RECEIPT";
    const DEBIT_NOTES_TYPE = "DEBIT NOTES";
    const CREDIT_NOTES_TYPE = "CREDIT NOTES";
    protected $table = 'entity_authorization_configuration';
    const ROLE_MANAGEMENT = "ROL_GERENCIA";
    const ROLE_ADMINISTRATION = "ROL_ADMINISTRADOR";
    protected $fillable = array(
        'authorization_code',//*
        'entity_data_id',//*
        'description',
        'type',//*
        'state',
        'establishment_number',
        'expiration_date',//*
        'allow_authorization_code',//*
        'type_of_document_issuance',//*
        'type_process'//*

    );
    protected $attributesData = [
        ['column' => 'authorization_code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'entity_data_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'description', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'type', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'establishment_number', 'type' => 'integer', 'defaultValue' => '', 'required' => 'false'],
        ['column' => 'expiration_date', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'allow_authorization_code', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
        ['column' => 'type_of_document_issuance', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true'],
        ['column' => 'type_process', 'type' => 'integer', 'defaultValue' => '0', 'required' => 'true']

    ];
    public $timestamps = false;

    protected $field_main = 'authorization_code';

    public static function getRulesModel()
    {
        $rules = ["authorization_code" => "required|max:700",
            "entity_data_id" => "required|numeric",
            "type" => "required",
            "establishment_number" => "numeric",
            "expiration_date" => "required",
            "allow_authorization_code" => "required|numeric",
            "type_of_document_issuance" => "required|numeric",
            "type_process" => "required|numeric"
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

        $selectString = "$this->table.id,$this->table.authorization_code,$this->table.entity_data_id,$this->table.description,$this->table.type,$this->table.state,$this->table.establishment_number,$this->table.expiration_date,$this->table.allow_authorization_code,$this->table.type_of_document_issuance,$this->table.type_process";

        $select = DB::raw($selectString);
        $query->select($select);
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = $searchValue;
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.authorization_code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity_data_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.establishment_number', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.expiration_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.allow_authorization_code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_of_document_issuance', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_process', 'like', '%' . $likeSet . '%');
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
            $modelName = 'EntityAuthorizationConfiguration';
            $model = new EntityAuthorizationConfiguration();
            $createUpdate = true;

            if (isset($attributesPost[$modelName]["id"]) && $attributesPost[$modelName]["id"] != "null" && $attributesPost[$modelName]["id"] != "-1") {
                $model = EntityAuthorizationConfiguration::find($attributesPost[$modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;
            }


            $entityAuthorizationConfigurationData = $attributesPost[$modelName];
            $attributesSet = $this->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $entityAuthorizationConfigurationData, 'attributesData' => $this->attributesData));
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
                $msj = "Problemas al guardar  EntityAuthorizationConfiguration.";
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
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.authorization_code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.entity_data_id', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.description', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.state', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.establishment_number', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.expiration_date', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.allow_authorization_code', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_of_document_issuance', 'like', '%' . $likeSet . '%');
                $query->orWhere($this->table . '.type_process', 'like', '%' . $likeSet . '%');
            });;

        }

        $query->limit(10)->orderBy($field, 'asc');
        $result = $query->get()->toArray();
        return $result;

    }

    public static function getSubtractDeadlines($params)
    {
        $dateInit = $params['dateInit'];// <
        $dateCurrent = \App\Utils\Util::DateCurrent();//>
        $dateCurrent = new DateTime($dateCurrent);//>
        $dateInit = new DateTime($dateInit);// > - <
        $diffDates = $dateCurrent->diff($dateInit);
        $result = $diffDates;
        return $result;
    }


    public static function getValuesConfigByModel($params)
    {
        $model = $params['model'];
        $managerType = $params['managerType'];
        $typeProcess = $params['type'];
        $value = "";
        $allow = false;
        $case = -1;
        $expiration_date = '';
        $diff = 0;
        $allow_authorization_code = -1;
        $type_of_document_issuance = -1;
        $type_of_document_issuance_text = "";
        $type_process = -1;
        $type_process_text = "";
        $establishment_number = "";
        if ($model) {

            $establishment_number = $model->establishment_number;
            $allow_authorization_code = $model->allow_authorization_code;
            $type_of_document_issuance = $model->type_of_document_issuance;
            $type_process = $model->type_process;

            $allow = true;
            if ($model->allow_authorization_code == 1 && $model->type_of_document_issuance == 0 && $model->type_process == 1) {//101

                $value = $model->codigo_autorizacion;
                $expiration_date = $model->expiration_date;
                if ($expiration_date == '0000-00-00 00:00:00') {
                    $allow = false;
                    $expiration_date = \App\Utils\Util::FormatDate($expiration_date, "d-m-Y");

                    $value = 'FECHA INVALIDA ' . $expiration_date . '.';
                    $case = 1.4;
                } else {
                    $diff = self::getSubtractDeadlines(array('dateInit' => $expiration_date));
                    if ($diff->invert == 1) {
                        $allow = false;
                        $expiration_date = \App\Utils\Util::FormatDate($expiration_date, "d-m-Y");

                        $value = 'NO PUEDE ACCEDER AL VIEW VENTA DEBIDO A FECHA CADUCADA ' . $expiration_date . '.';
                        $case = 1.2;
                    } else {

                        if ($diff->days <= 20 && $diff->days >= 0) {
                            $case = 1.3;
                        } else {
                            $case = 1.1;

                        }
                    }
                }

            } else if ($model->allow_authorization_code == 1 && $model->type_of_document_issuance == 0 && $model->type_process == 0) {//100
                $value = $model->codigo_autorizacion;
                $expiration_date = $model->expiration_date;
                if ($expiration_date == '0000-00-00 00:00:00') {//
                    $allow = false;
                    $expiration_date = \App\Utils\Util::FormatDate($expiration_date, "d-m-Y");
                    $value = 'FECHA INVALIDA ' . $expiration_date . '.';
                    $case = 2.4;
                } else {//
                    $diff = self::getSubtractDeadlines(array('dateInit' => $expiration_date));
                    if ($diff->invert == 1) {//
                        $allow = false;
                        $expiration_date = \App\Utils\Util::FormatDate($expiration_date, "d-m-Y");
                        $value = 'NO PUEDE ACCEDER AL VIEW VENTA DEBIDO A FECHA CADUCADA ' . $expiration_date . '.';
                        $case = 2.2;
                    } else {//
                        if ($diff->days <= 20 && $diff->days >= 0) {
                            $case = 2.3;
                        } else {
                            $case = 2.1;

                        }
                    }
                }
            } else if ($model->allow_authorization_code == 1 && $model->type_of_document_issuance == 1 && $model->type_process == 1) {//111
                $value = "ELECTRONICO";
                $case = 3;
            } else if ($model->allow_authorization_code == 1 && $model->type_of_document_issuance == 1 && $model->type_process == 0) {//110
                $value = 'CONFIGURACION MAL ESTABLECIDA';
                $case = 4;
                $allow = false;

            } else if ($model->allow_authorization_code == 0 && $model->type_of_document_issuance == 0 && $model->type_process == 1) {//001
                $value = 'FISICO';
                $case = 5;
            } else if ($model->allow_authorization_code == 0 && $model->type_of_document_issuance == 0 && $model->type_process == 0) {//000
                $value = 'FISICO';
                $case = 6;
            } else if ($model->allow_authorization_code == 0 && $model->type_of_document_issuance == 1 && $model->type_process == 0) {//010
                $value = 'CONFIGURACION MAL ESTABLECIDA';
                $case = 7;
                $allow = false;

            } else if ($model->allow_authorization_code == 0 && $model->type_of_document_issuance == 1 && $model->type_process == 1) {//011
                $value = 'CONFIGURACION MAL ESTABLECIDA';
                $case = 8;
                $allow = false;
            }
        } else {
            $value = $managerType;
        }

        if ($type_of_document_issuance == 0) {
            $type_of_document_issuance_text = 'FISICO';
        } else if ($type_of_document_issuance == 1) {
            $type_of_document_issuance_text = 'DIGITAL';

        }

        if ($type_process == 0) {
            $type_process_text = 'MANUAL';
        } else if ($type_process == 1) {
            $type_process_text = 'SECUENCIAL';

        }
        $result = array(
            "value" => $value,
            "type" => $typeProcess,
            "allow" => $allow,
            'expiration_date' => $expiration_date,
            'case' => $case,
            'diffDates' => $diff,
            "allow_authorization_code" => $allow_authorization_code,
            "type_of_document_issuance" => $type_of_document_issuance,
            "type_of_document_issuance_text" => $type_of_document_issuance_text,
            "type_process" => $type_process,
            "type_process_text" => $type_process_text,
            "establishment_number" => $establishment_number

        );


        return $result;

    }


    public static function getDocumentAllConfig($entityBusinessId)
    {
        $comprobanteDeRetencion = 'NO CONFIGURADO';
        $modelEAC = new \App\Models\EntityAuthorizationConfiguration();
        $tipo = self::INVOICE_SALES_TYPE;
        $estado = self::STATE_ACTIVE;
        $factura = "NO CONFIGURADO";
        $guiaRemision = "NO CONFIGURADO";
        $notasDeCredito = "NO CONFIGURADO";
        $notasDeDebito = "NO CONFIGURADO";
        $filtersData = array();
        $imgsData = array();
        $modelER = new  EntityResources();
        $resultModel = $modelEAC->findByAttributes(array("type" => $tipo, "state" => $estado, "entity_data_id" => $entityBusinessId));
        $result = self::getValuesConfigByModel(array(
            'model' => $resultModel,
            'type' => $tipo,
            'managerType' => $factura
        ));
        $filtersData[] = $result;

        /* SOURCE*/
        $modelImages = $modelER->getDataFirst(array("entity" => $tipo, "main" => 1, "business_id" => $entityBusinessId));
        $paramsSetImg = array("value" => "-1", "id" => "-1");
        if ($modelImages) {
            $paramsSetImg = array("value" => $modelImages->url_img, "id" => $modelImages->id);
        }
        $imgsData[] = $paramsSetImg;

        $tipo = self::RETENTION_RECEIPT_TYPE;
        $resultModel = $modelEAC->findByAttributes(array("type" => $tipo, "state" => $estado, "entity_data_id" => $entityBusinessId));
        $result = self::getValuesConfigByModel(array(
            'model' => $resultModel,
            'type' => $tipo,
            'managerType' => $comprobanteDeRetencion
        ));
        $filtersData[] = $result;

        /* SOURCE*/
        $modelImages = $modelER->getDataFirst(array("entity" => $tipo, "main" => 1, "business_id" => $entityBusinessId));
        $paramsSetImg = array("value" => "-1", "id" => "-1");
        if ($modelImages) {
            $paramsSetImg = array("value" => $modelImages->url_img, "id" => $modelImages->id);
        }
        $imgsData[] = $paramsSetImg;

        $tipo = self::REMISSION_GUIDE_TYPE;
        $resultModel = $modelEAC->findByAttributes(array("type" => $tipo, "state" => $estado, "entity_data_id" => $entityBusinessId));
        $result = self::getValuesConfigByModel(array(
            'model' => $resultModel,
            'type' => $tipo,
            'managerType' => $guiaRemision
        ));
        $filtersData[] = $result;

        /* SOURCE*/
        $modelImages = $modelER->getDataFirst(array("entity" => $tipo, "main" => 1, "business_id" => $entityBusinessId));
        $paramsSetImg = array("value" => "-1", "id" => "-1");
        if ($modelImages) {
            $paramsSetImg = array("value" => $resultModel->url_img, "id" => $resultModel->id);
        }
        $imgsData[] = $paramsSetImg;


        $tipo = self::CREDIT_NOTES_TYPE;
        $resultModel = $modelEAC->findByAttributes(array("type" => $tipo, "state" => $estado, "entity_data_id" => $entityBusinessId));
        $result = self::getValuesConfigByModel(array(
            'model' => $resultModel,
            'type' => $tipo,
            'managerType' => $notasDeCredito
        ));
        $filtersData[] = $result;
        /* SOURCE*/
        $modelImages = $modelER->getDataFirst(array("entity" => $tipo, "main" => 1, "business_id" => $entityBusinessId));
        $paramsSetImg = array("value" => "-1", "id" => "-1");
        if ($modelImages) {
            $paramsSetImg = array("value" => $modelImages->url_img, "id" => $modelImages->id);
        }
        $imgsData[] = $paramsSetImg;

        $tipo = self::DEBIT_NOTES_TYPE;
        $resultModel = $modelEAC->findByAttributes(array("type" => $tipo, "state" => $estado, "entity_data_id" => $entityBusinessId));
        $result = self::getValuesConfigByModel(array(
            'model' => $resultModel,
            'type' => $tipo,
            'managerType' => $notasDeDebito
        ));
        $filtersData[] = $result;
        /* SOURCE*/
        $modelImages = $modelER->getDataFirst(array("entity" => $tipo, "main" => 1, "business_id" => $entityBusinessId));
        $paramsSetImg = array("value" => "-1", "id" => "-1");
        if ($modelImages) {
            $paramsSetImg = array("value" => $modelImages->url_img, "id" => $modelImages->id);
        }
        $imgsData[] = $paramsSetImg;


        /*------------SOURCES------------*/
        $result = array(
            "filtersData" => $filtersData,
            "imgsData" => $imgsData
        );
        return $result;
    }

    /* ------MANAGER PROCESS ----*/
    public static function initAllowManagerProcess($params)
    {
        $modelED = new \App\Models\Business();
        $dataUserManager = \App\Utils\Util::getDataManagerCurrentUser();

        $entityData = $modelED->getEntityManager($params);
        $roles = array();
        $allowProcess = false;
        $errors = array();
        $rolesAllow = array();
        $managerUserId = null;
        $isSuperAdmin = false;
        if ($dataUserManager['success']) {
            $managerUserId = $dataUserManager['user']->id;
            $isSuperAdmin = $dataUserManager['isSuperAdmin'];
        }

        if (!$isSuperAdmin) {
            $roles = $dataUserManager['roles'];
            $allowPlanes = false;
            if ($entityData) {
                if ($entityData['entity_plans_id'] == EntityPlans::LINE_PLAN_ID) {
                    $allowPlanes = true;
                } else if ($entityData['entity_plans_id'] == EntityPlans::SIMPLE_PLAN_ID) {
                    $allowPlanes = true;

                } else if ($entityData['entity_plans_id'] == EntityPlans::PRO_PLAN_ID) {
                    $allowPlanes = true;

                }
            }

            $needle = self::ROLE_MANAGEMENT;
            $resultSearch = \App\Utils\Util::searchRolesUser(array("needle" => $needle, "roles" => $roles));
            $allowRoleManagement = false;
            if ($resultSearch['success']) {

                $allowRoleManagement = true;
                $rolesAllow[] = $resultSearch['data'];
            } else {
                $errors[] = 'Not has role ' . $needle;
                $allowRoleManagement = false;


            }

            $needle = self::ROLE_ADMINISTRATION;
            $resultSearch = \App\Utils\Util::searchRolesUser(array("needle" => $needle, "roles" => $roles));
            $allowRoleAdministration = false;
            if ($resultSearch['success']) {

                $allowRoleAdministration = true;

                $rolesAllow[] = $resultSearch['data'];
            } else {
                $errors[] = 'Not has role ' . $needle;
                $allowRoleAdministration = false;

            }
            $needle = CrugeConstants::ROLE_ACCOUNTING_FINANCE;
            $resultSearch = \App\Utils\Util::searchRolesUser(array("needle" => $needle, "roles" => $roles));
            $allowRoleAccountingFinance = false;
            if ($resultSearch['success']) {
                $allowRoleAccountingFinance = true;
                $rolesAllow[] = $resultSearch['data'];
            } else {
                $errors[] = 'Not has role ' . $needle;
                $allowRoleAccountingFinance = false;

            }

            if (($allowPlanes && $allowRoleAccountingFinance) || ($allowPlanes && $allowRoleAdministration) || ($allowPlanes && $allowRoleManagement)) {
                $allowProcess = true;
            }
        } else {
            $allowProcess = true;
            $rolesAllow[] = 'Is Role Admin Root';
        }
        $result = array(
            'entityData' => $entityData,
            'roles' => $roles,
            'rolesAllow' => $rolesAllow,
            'allowProcess' => $allowProcess,
            'errors' => $errors,
        );

        return $result;

    }

}
