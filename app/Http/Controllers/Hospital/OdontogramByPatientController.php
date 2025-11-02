<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\MyBaseController;
use App\Models\OdontogramByPatient;
use App\Models\DentalPieceByOdontogram;

use App\Models\HistoryClinic;
use App\Models\Patient;
use App\Models\ReferencePieceType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use DB;


use DateTime;

class OdontogramByPatientController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public $name_manager = "Gestion Odontograma";

    public function index()
    {
        $model = new OdontogramByPatient();
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
    public function getListOdontogramByPatients()
    {
        $data = Request::all();


        $query = OdontogramByPatient::query();
        $model = new OdontogramByPatient;
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
            $query->where("description", 'like', $searchLike)
                ->orWhere("date", 'like', $searchLike)
                ->orWhere("status", 'like', $searchLike);
        }
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
        $limit = isset($datatable['rowCount']) ? $datatable['rowCount'] : 10;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $result['rowCount'] = $limit;
        $result['total'] = (int)$total;
        return Response::json(
            $result
        );
    }

    public function getFormOdontogramByPatient()
    {
        $method = 'POST';
        $data = Request::all();
        $model = isset($data["id"]) ? OdontogramByPatient::find($data["id"]) : new OdontogramByPatient();
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
        $query = OdontogramByPatient::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', OdontogramByPatient::STATUS_ACTIVE);
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

        try {
            $model = new OdontogramByPatient();
            $history_clinic_id = null;
            $modelHC = new HistoryClinic();
            $new_record = false;
            $attributesPost = Request::all();
            $id = null;
            if (isset($attributesPost[$model->getTable() . '_id']) && $attributesPost[$model->getTable() . '_id'] == '') { //Create
                $new_record = true;

            } else { //Update
                $model = OdontogramByPatient::find($attributesPost[$model->getTable() . '_id']);
                $id = $attributesPost[$model->getTable() . '_id'];
                $new_record = false;
            }
            $patient_id = $attributesPost["patient_id"];
            $modelHC = $modelHC->findByAttribute("patient_id", $patient_id);

            if ($modelHC) {//obtener datos
                $history_clinic_id = $modelHC->id;
                $transactionGenerate = true;
            } else {//nuevo
                $modelHC = new HistoryClinic();
                $modelHC->patient_id = $patient_id;
                $modelHC->status = "ACTIVE";
                $result = $modelHC->save();
                if ($result) {
                    $history_clinic_id = $modelHC->id;
                    $transactionGenerate = true;
                }

            }

            $date = $attributesPost["date"];
            $model->fill($attributesPost);
            $date = $model->util_component->formatDate($date, "Y-m-d");// Util::FormatDate(Util::FechaActual(), "d/m/Y");
            $model->date = $date;
            $status = isset($attributesPost["status"]) ? $attributesPost["status"] : "ACTIVE";
            if ($history_clinic_id) {
                $model->status = $status;
                if ($status == "ACTIVE") {
                    $modelSearc = new OdontogramByPatient;
                    $modelSearchData = $modelSearc->findAllByAttributes(array("status"), array("ACTIVE"));

                    foreach ($modelSearchData as $value) {
                        $modelNeedle = OdontogramByPatient::find($value->id);
                        /* var_dump($modelNeedle->status,$id,$modelNeedle->id);*/
                        if ($id) {

                            if ($modelNeedle->id !== (int)$id) {
                                $modelNeedle->status = "INACTIVE";
                                $modelNeedle->save();
                            }
                        } else {
                            $modelNeedle->status = "INACTIVE";
                            $modelNeedle->save();
                        }

                    }
                }
                $transactionGenerate = $model->save();
            }

            if ($transactionGenerate) {

                DB::commit();

            } else {
                DB::rollBack();
            }
            return Response::json($transactionGenerate);
        } catch (Exception $e) {

            DB::rollBack();

            return Response::json($transactionGenerate);
        }


    }

    public function getManagementByPatient($id)
    {
        $model = Patient::find($id);
        $patient_id = $id;
        $id_table = "admin_odontogram_by_patient";
        $dataLegendOdontogram = ReferencePieceType::where('status', '=', "ACTIVE")->get();
        $odontogramConfiguration = $dataLegendOdontogram;
        $configPortlet = array("title" => "Gestion de Odontogramas", "icon" => "la la-header");
        $dataOdontogram = $model->getDataOdontogram($patient_id);
        $view = View::make('odontogramByPatient.loads._managementByPatient', [
            'model' => $model,
            "id_table" => $id_table,
            "configPortlet" => $configPortlet,
            "odontogramConfiguration" => $odontogramConfiguration
        ])->render();
        return Response::json(array(
            'html' => $view,
            "data" => $dataOdontogram

        ));
    }

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new OdontogramByPatient();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new OdontogramByPatient();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
}
