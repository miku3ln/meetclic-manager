<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\MyBaseController;
use App\Models\Doctor;

use App\Models\TreatmentPlan;
use App\Models\TreatmentPlanByPatient;
use App\Models\TreatmentDetailByTreatment;
use App\Models\Treatment;
use App\Models\HistoryClinic;
use App\Models\DentalPieceByOdontogram;
use App\Models\ReferencePieceType;
use App\Models\OdontogramByPatient;
use App\Models\Patient;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use DB;


use DateTime;

class TreatmentPlanByPatientController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public $name_manager = "Gestion Planes Tratamiento";

    public function index()
    {
        $model = new TreatmentPlanByPatient();
        $camerCase = $model->getCamelCase();
        $renderView = $camerCase . ".index";
        $model_entity = $camerCase;
        $actions = $model->getActionsManager();
        $paramsSend = [
            "model_entity" => $model_entity,
            "name_manager" => $this->name_manager,
            "icon_manager" => "flaticon-cogwheel-2",
            "actions" => $actions
        ];
        $this->layout->content = View::make($renderView, $paramsSend);
    }

//Change
    public function getListTreatmentPlanByPatients()
    {
        $data = Request::all();


        $query = TreatmentPlanByPatient::query();
        $model = new TreatmentPlanByPatient;
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);
        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'status';
        $page = !empty($datatable['current']) ? (int)$datatable['current'] : 1;
        $perpage = !empty($datatable['rowCount']) ? (int)$datatable['rowCount'] : -1;
        $current_page = isset($datatable['current']) ? (int)$datatable['current'] : 0;
        $pages = 1;
        $total = $recordsTotal; // total items in array
        if (isset($data["current"])) {
            $page = $data["current"];
            $current_page = $page;

        }
        if (isset($data["rowCount"])) {
            $perpage = $data["rowCount"];
        }
        if (isset($data["sort"])) {
            $column = array_keys($data['sort']);
            $columnName = $column[0];
            $sortType = $data['sort'][$column[0]];
            $sort = $sortType;
            $field = $columnName;
        }
        if ($data['searchPhrase'] != null && $data['searchPhrase'] != "") {//para la busqueda segun la tabla
            $search_value = $data['searchPhrase'];
            $searchLike = "%" . $search_value . "%";
            $query->where($model->getTable() . ".status", 'like', $searchLike)
                ->orWhere("total_price", 'like', $searchLike)
                ->orWhere("tax", 'like', $searchLike)
                ->orWhere("subtotal", 'like', $searchLike)
                ->orWhere("discount", 'like', $searchLike)
                ->orWhere("doctor.name", 'like', $searchLike)
                ->orWhere("doctor.document", 'like', $searchLike)
                ->orWhere("treatment_plan.name", 'like', $searchLike)
                ->orWhere("treatment_plan.description", 'like', $searchLike);
        }
        $query->select($model->getTable() . ".id as id", $model->getTable() . ".patient_id", $model->getTable() . ".status", $model->getTable() . ".treatment_plan_id", "total_price", "tax", "subtotal", "discount", "doctor_id"
            , "doctor.id as doctor_id", "doctor.name as doctor_name", "doctor.document as doctor_document",
            "treatment_plan.id as treatment_plan_id", "treatment_plan.name as treatment_plan_name", "treatment_plan.description as treatment_plan_description"
        );
        // sort
        $query->orderBy($field, $sort);
        $query->join("doctor", $model->getTable() . ".doctor_id", "=", "doctor.id");
        $query->join("treatment_plan", $model->getTable() . ".treatment_plan_id", "=", "treatment_plan.id");
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
        $limit = isset($datatable['rowCount']) ? $datatable['rowCount'] : 10;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $result['rowCount'] = $limit;
        $result['total'] = (int)$total;
        return Response::json(
            $result
        );
    }

    public function getFormTreatmentPlanByPatient()
    {
        $method = 'POST';
        $data = Request::all();
        $model = isset($data["id"]) ? TreatmentPlanByPatient::find($data["id"]) : new TreatmentPlanByPatient();
        if (isset($data["patient_id"])) {
            $model->patient_id = $data["patient_id"];
        }
        $camerCase = $model->util_component->getCamelCase($model->getTable());
        $model_entity = $model->getTable();
        $renderView = $camerCase . '.loads._form';
        $view = View::make($renderView, [
            'method' => $method,
            'model' => $model,
            "model_entity" => $model_entity,
            "frmId" => $camerCase//debe d ser igual al del boton save
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getListSelect2()
    {
        $data = Request::all();
        $query = TreatmentPlanByPatient::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', TreatmentPlanByPatient::STATUS_ACTIVE);
        $query->limit(10)->orderBy('name', 'asc');
        $modelList = $query->get()->toArray();
        return Response::json(
            $modelList
        );
    }

    public function postSaveByConsultation()
    {
        DB::beginTransaction();
        $transactionGenerate = false;
        $modelTP = new TreatmentPlan();
        $success = true;
        $error_msj = "";
        $success_msj = "Informacion Guardada";
        $result = array(
            "success" => $success,
            "error_msj" => $error_msj,
            "success_msj" => $success_msj
        );
        $treatment_plan_by_patient_id = null;
        $data = array();
        try {
            $model = new TreatmentPlanByPatient();
            $history_clinic_id = null;
            $modelHC = new HistoryClinic();
            $new_record = false;
            $attributesPost = Request::all();
            $attributesT = array();

            $attributesTP = array();
            $attributesTPBP = array();
            $attributesTDBT = array();
            $attributesT = $attributesPost;
            $keyGetModel = "treatment_plan_";
            $attributesTP = array(
                "name" => $attributesPost[$keyGetModel . "name"],
                "description" => $attributesPost[$keyGetModel . "description"],
            );
            $id = null;
            if ($attributesPost[$model->getTable() . '_id'] == '') { //Create
                $new_record = true;

            } else { //Update
                $model = TreatmentPlanByPatient::find($attributesPost[$model->getTable() . '_id']);
                $id = $attributesPost[$model->getTable() . '_id'];
                $new_record = false;

                $keyGetModel = "treatment_plan_";
                $modelTP = TreatmentPlan::find($attributesPost[$keyGetModel . "id"]);

            }

            $modelTP->fill($attributesTP);
            $transactionGenerate = $modelTP->save();

            if ($transactionGenerate) {
                $treatment_plan_id = $modelTP->id;
                $attributesTPBP = array(
                    "name" => $attributesPost["patient_id"],
                    "treatment_plan_id" => $treatment_plan_id,
                    "total_price" => $attributesPost["total_price"],
                    "tax" => $attributesPost["tax"],
                    "subtotal" => $attributesPost["subtotal"],
                    "discount" => $attributesPost["discount"],
                    "doctor_id" => $attributesPost["doctor_id"],
                    "patient_id" => $attributesPost["patient_id"],
                    "status" => isset($attributesPost["status"])?$attributesPost["status"]:"ACTIVE",


                );
                $model->fill($attributesTPBP);
                $transactionGenerate = $model->save();
                if ($transactionGenerate) {
                    $treatment_plan_by_patient_id = $model->id;
                    $treatment_detail_by_treatment_data = json_decode($attributesPost["treatment_detail_by_treatment_data"], true);
                    foreach ($treatment_detail_by_treatment_data as $row) {
                        $attributesTDBT = array();
                        $attributesTDBT = $row;
                        $attributesTDBT["treatment_plan_by_patient_id"] = $treatment_plan_by_patient_id;
                        $modelTDBT = new TreatmentDetailByTreatment();
                        if (isset($row["treatment_plan_by_patient_id"])) {
                            $modelTDBT = TreatmentDetailByTreatment::find($row["id"]);
                        }
                        $modelTDBT->fill($attributesTDBT);
                        if (!$modelTDBT->save()) {
                            $error_msj = "Error al guardar un detalle de Tratamiento";
                            throw new Exception($error_msj);
                        }
                    }
                    if (!$new_record) {//los q fueron eliminados
                        $treatment_detail_by_treatment_data = array();
                        $treatment_detail_by_treatment_data = json_decode($attributesPost["treatment_detail_by_treatment_data_aux"], true);

                        foreach ($treatment_detail_by_treatment_data as $row) {
                            $attributesTDBT = array();
                            $attributesTDBT = $row;
                            $modelTDBT = TreatmentDetailByTreatment::find($row["id"]);
                            $modelTDBT->fill($attributesTDBT);
                            if (!$modelTDBT->save()) {
                                $error_msj = "Error al guardar el status un detalle de Tratamiento";
                                throw new Exception($error_msj);
                            }
                        }
                    }

                } else {
                    $error_msj = "Error al guardar Encabezado Plan Tratamiento";
                    throw new Exception($error_msj);
                }
            } else {
                $error_msj = "Error al guardar Plan Tratamiento";
                throw new Exception($error_msj);
            }
            $model->fill($attributesPost);
            $success = $transactionGenerate;
            if ($transactionGenerate) {
                DB::commit();
                $modelTDBT = new TreatmentDetailByTreatment;
                $treatment_detail_by_treatment_data = $modelTDBT->getDetailsTreatmentByTreatmentPlanByPatientId($treatment_plan_by_patient_id);
                $treatment_detail_by_treatment_data = json_encode($treatment_detail_by_treatment_data);
                $data["TreatmentDetailByTreatment"]["treatment_detail_by_treatment_data"]=$treatment_detail_by_treatment_data;
            } else {

                DB::rollBack();
            }
            $result = array(
                "success" => $success,
                "error_msj" => $error_msj,
                "success_msj" => $success_msj,
                "data" => $data
            );
            return Response::json($result);
        } catch (Exception $e) {
            DB::rollBack();
            $result = array(
                "success" => $success,
                "error_msj" => $error_msj,
                "success_msj" => $success_msj
            );
            return Response::json($result);
        }


    }

    public function getManagementByPatient($id)
    {
        $modelPatient = Patient::find($id);
        $patient_id = $id;
        $model = new TreatmentPlanByPatient();
        $id_table = "admin_treatment_plan_by_patient";
        $columns = $model->getColumnsNameAdmin();
        $dataOdontogram = $modelPatient->getDataOdontogram($id);
        $tableConfig = array(
            "id" => $id_table,
            "thead" => array(
                "columns" => $columns
            )
        );
        $configPortlet = array("title" => "Gestion de Tratamientos", "icon" => "flaticon-placeholder-2");
        $dataLegendOdontogram = ReferencePieceType::where('status', '=', "ACTIVE")->get();
        $odontogramConfiguration = $dataLegendOdontogram;
        $view = View::make('treatmentPlanByPatient.loads._managementByPatient', [
            'modelPatient' => $modelPatient,
            "tableConfig" => $tableConfig,
            "configPortlet" => $configPortlet,
            "odontogramConfiguration" => $odontogramConfiguration,

        ])->render();


        return Response::json(array(
            'html' => $view,
            "data" => $dataOdontogram
        ));
    }

    public function getManagementByPatientForm($id, $treatment_plan_by_patient_id = null)
    {
        $modelPatient = Patient::find($id);
        $patient_id = $id;
        $model = new TreatmentPlanByPatient();
        $model->patient_id = $id;
        $id_table = "admin_treatment_plan_by_patient";
        $columns = $model->getColumnsNameDetailsTreatment();
        $dataDentalPiece = array();
        $method = 'POST';
        $camerCase = $model->util_component->getCamelCase($model->getTable());
        $model_entity = $model->getTable();
        $configPortlet = array(
            "title" => "Crear Plan Tratamiento",
            "icon" => "flaticon-placeholder-2",
        );
        $data = Doctor::where('status', '=', "ACTIVE")->get();
        $doctorsData = $model->util_component->getFormatArraySelect($data, array("key" => "id", "text" => array("name")));
        $dataTreatment = Treatment::where('status', '=', "ACTIVE")->get();
        $treatmentsData = $model->util_component->getFormatArraySelect($dataTreatment, array("key" => "id", "text" => array("name")));
        $updateData = array();
        $dataOdontogram = $modelPatient->getDataOdontogram($id);
        $tbody = array();
        if ($treatment_plan_by_patient_id) {//UPDATE
            $configPortlet["title"] = "Actualizar Plan Tratamiento";

            $modelTPBP = TreatmentPlanByPatient::find($treatment_plan_by_patient_id);
            if ($modelTPBP) {
                $model->id = $treatment_plan_by_patient_id;
                $model->patient_id = $modelTPBP->patient_id;
                $model->total_price = $modelTPBP->total_price;
                $model->tax = $modelTPBP->tax;
                $model->subtotal = $modelTPBP->subtotal;
                $model->discount = $modelTPBP->discount;
                $model->treatment_plan_id = $modelTPBP->treatment_plan_id;
                $model->doctor_id = $modelTPBP->doctor_id;
            }

            $modelTP = TreatmentPlan::find($modelTPBP->treatment_plan_id);
            if ($modelTP) {
                $model->treatment_plan_id = $modelTP->id;
                $model->treatment_plan_name = $modelTP->name;
                $model->treatment_plan_description = $modelTP->description;

            }
            /* --DETAILS--*/
            $modelTDBT = new TreatmentDetailByTreatment;
            $treatment_detail_by_treatment_data = $modelTDBT->getDetailsTreatmentByTreatmentPlanByPatientId($treatment_plan_by_patient_id);
            $tbody = $treatment_detail_by_treatment_data;
            $treatment_detail_by_treatment_data = json_encode($treatment_detail_by_treatment_data);
            $model->treatment_detail_by_treatment_data = $treatment_detail_by_treatment_data;

        }
        $tableConfig = array(
            "id" => $id_table,
            "thead" => array(
                "columns" => $columns
            ),
            "tbody" => $tbody
        );
        $dataLegendOdontogram = ReferencePieceType::where('status', '=', "ACTIVE")->get();
        $odontogramConfiguration = $dataLegendOdontogram;

        $formConfiguration = array(
            "frmId" => $camerCase . '_form',//debe d ser igual al del boton save
            "method" => $method,
            "model_entity" => $model_entity,
            "model" => $model,
            "doctorsData" => $doctorsData,
            "treatmentsData" => $treatmentsData
        );

        $view = View::make('treatmentPlanByPatient.loads._managementByPatientForm', [
            'modelPatient' => $modelPatient,
            "tableConfig" => $tableConfig,
            "configPortlet" => $configPortlet,
            "formConfiguration" => $formConfiguration,
            "odontogramConfiguration" => $odontogramConfiguration,
            "model" => $model

        ])->render();


        return Response::json(array(
            'html' => $view,
            "data" => $dataOdontogram,
            "updateData" => $updateData
        ));
    }
}
