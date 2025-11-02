<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\MyBaseController;
use App\Models\ClinicalByHistoryClinic;
use App\Models\HistoryClinic;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use DB;

class ClinicalByHistoryClinicController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public $table = "clinical_by_history_clinic";
    public $name_manager = "Historial de Examen Clinico";

    public function index()
    {
        $model = new ClinicalByHistoryClinic();
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

//    public function getListClinicalByHistoryClinics()
//    {
//        $data = Request::all();
//
//
//        $query = ClinicalByHistoryClinic::query();
//        $recordsTotal = $query->get()->count();
//        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
//        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);
//
//        //TODO: implement functionality to search
//        // search filter by keywords
//        //        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch']) ? $datatable['query']['generalSearch'] : '';
//        //        if (!empty($filter)) {
//        //            $data = array_filter($data, function ($a) use ($filter) {
//        //                return (boolean)preg_grep("/$filter/i", (array)$a);
//        //            });
//        //            unset($datatable['query']['generalSearch']);
//        //        }
//        //
//        //// filter by field query
//        //        $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
//        //        if (is_array($query)) {
//        //            $query = array_filter($query);
//        //            foreach ($query as $key => $val) {
//        //                $data = list_filter($data, [$key => $val]);
//        //            }
//        //        }
//
//        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
//        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'name';
//        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
//        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;
//
//        $pages = 1;
//        $total = $recordsTotal; // total items in array
//        $query->select($this->table.".id as id",$this->table.".pathology_description as pathology_description","clinical_exam.name as name","clinical_exam.name as clinical_exam_name");
//        // sort
//        $query->orderBy($field, $sort);
//        // Pagination: $perpage 0; get all data
//        if ($perpage > 0) {
//            $pages = ceil($total / $perpage); // calculate total pages
//            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
//            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
//            $offset = ($page - 1) * $perpage;
//            if ($offset < 0) {
//                $offset = 0;
//            }
//            $query->offset((int)$offset);
//            $query->limit((int)$perpage);
//        }
//        $query->join("clinical_exam",$this->table.".clinical_exam_id","=","clinical_exam.id");
//        $data = $query->get()->toArray();
//
//        $meta = [
//            'page' => $page,
//            'pages' => $pages,
//            'perpage' => $perpage,
//            'total' => $total,
//        ];
//        $sort = [
//            'sort' => $sort,
//            'field' => $field,
//        ];
//        $result = array(
//            'meta' => $meta + $sort,
//            'data' => $data
//        );
//        return Response::json(
//            $result
//        );
//    }

    public function getListClinicalByHistoryClinics($id = null)
    {
        $data = Request::all();
        $query = ClinicalByHistoryClinic::query();
        $query->select(
            'clinical_exam.name as name',
            'clinical_by_history_clinic.pathology_description as description',
            'clinical_by_history_clinic.id as id'
        );
//        dd($id);
        $query->join('clinical_exam', 'clinical_by_history_clinic.clinical_exam_id', '=', 'clinical_exam.id');
        $query->join('history_clinic', 'clinical_by_history_clinic.history_clinic_id', '=', 'history_clinic.id');
        $query->join('patient','history_clinic.patient_id','=','patient.id');
        if ($id) {
            $query->where('patient.id',  '=',$id);
        }
        $recordsTotal = $query->get()->count();
        $recordsFiltered = $recordsTotal;
        if (isset($data['search']['value']) && $data['search']['value']) {
            $search = $data['search']['value'];
            $query->where('medical_consultation_by_patient.name', 'like', "$search%");
            $recordsFiltered = $query->get()->count();
        }
        if (isset($data['start']) && $data['start']) {
            $query->offset((int)$data['start']);
        }
        if (isset($data['length']) && $data['length']) {
            $query->limit((int)$data['length']);
        }
        if (isset($data['order']) && $data['order']) {
            $orders = $data['order'];
            foreach ($orders as $order) {
                $column = $order['column'];
                $dir = $order['dir'];
                $column_name = $data['columns'][$column]['data'];
                $query->orderBy('medical_consultation_by_patient.' . $column_name, $dir);
            }
        }
        $products = $query->get()->toArray();
        return Response::json(
            array(
//                'draw' => $data['draw'],
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $products
            )
        );
    }

    public function getFormClinicalByHistoryClinic()
    {
        $method = 'POST';
        $data = Request::all();
        $model = isset($data["id"]) ? ClinicalByHistoryClinic::find($data["id"]) : new ClinicalByHistoryClinic();
        if (isset($data["patient_id"])) {
            $model->patient_id = $data["patient_id"];
        }
        $camerCase = $model->getCamelCase();
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
        $query = ClinicalByHistoryClinic::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', ClinicalByHistoryClinic::STATUS_ACTIVE);
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
            $model = new ClinicalByHistoryClinic();
            $history_clinic_id = null;
            $modelHC = new HistoryClinic();

            $attributesPost = Request::all();

            if ($attributesPost[$model->getTable() . '_id'] == '') { //Create

            } else { //Update
                $model = ClinicalByHistoryClinic::find($attributesPost[$model->getTable() . '_id']);



            }
            $patient_id = $attributesPost["patient_id"];
            $modelHC = $modelHC->findByAttribute("patient_id", $patient_id);

            if ($modelHC) {//obtener datos
                $history_clinic_id = $modelHC->id;
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

            $model->clinical_exam_id = $attributesPost["clinical_exam_id"];
            $model->pathology_description = $attributesPost["pathology_description"];
            $model->history_clinic_id = $history_clinic_id;
            if ($history_clinic_id) {
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


}
