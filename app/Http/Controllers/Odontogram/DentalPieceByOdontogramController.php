<?php

namespace App\Http\Controllers\Odontogram;

use App\Http\Controllers\MyBaseController;
use App\Models\DentalPieceByOdontogram;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use DB;

use App\Models\ReferencePiecePosition;
use App\Models\ReferencePiece;
use App\Models\ReferencePieceType;
use App\Models\DentalPiece;

use DateTime;

class DentalPieceByOdontogramController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public $name_manager = "Gestion Odontograma Pieza";

    public function index()
    {
        $model = new DentalPieceByOdontogram();
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
    public function getListDentalPieceByOdontograms()
    {
        $data = Request::all();


        $query = DentalPieceByOdontogram::query();
        $model = new DentalPieceByOdontogram;
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);
        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'description';
        $page = !empty($datatable['current']) ? (int)$datatable['current'] : 1;
        $perpage = !empty($datatable['rowCount']) ? (int)$datatable['rowCount'] : -1;
        $current_page = isset($datatable['current']) ? (int)$datatable['current'] : 0;
        $pages = 1;
        $total = $recordsTotal; // total items in array
        // $query->select($model->table . ".id as id", $model->table . ".pathology_description as pathology_description", "clinical_exam.name as name", "clinical_exam.name as clinical_exam_name");
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
        $limit = isset($datatable['rowCount']) ? $datatable['rowCount'] : 10;
        $result['rows'] = $data;
        $result['current'] = $current_page;
        $result['rowCount'] = $limit;
        $result['total'] = (int)$total;
        return Response::json(
            $result
        );
    }

    public function getFormDentalPieceByOdontogram()
    {
        $method = 'POST';
        $data = Request::all();
        $model = isset($data["id"]) ? DentalPieceByOdontogram::find($data["id"]) : new DentalPieceByOdontogram();
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

    public function postSaveByConsultation()
    {
        DB::beginTransaction();
        $transactionGenerate = false;
        $typeComplete = false;
        try {
            $model = new DentalPieceByOdontogram();
            $attributesPost = Request::all();
            if ($attributesPost[$model->getTable() . '_id'] == '') { //Create

            } else { //Update
                $model = DentalPieceByOdontogram::find($attributesPost[$model->getTable() . '_id']);
            }
            $modelRPP = new ReferencePiecePosition();
            $modelRP = new ReferencePiece();
            $modelDP = new DentalPiece();
               /* "dental_piece_id","reference_piece_position_id","reference_piece_id","odontogram_by_patient_id"*/
            $dataRPP = $modelRPP->findByAttribute("position", $attributesPost["reference_piece_position_id"]);
            $reference_piece_position_id = null;
            $dental_piece_id = null;

            if ($dataRPP) {
                $transactionGenerate = true;

                $reference_piece_position_id = $dataRPP->id;
            } else {
                $transactionGenerate = false;
            }
            $dataDP = $modelDP->findByAttribute("piece", $attributesPost["dental_piece_id"]);
            if ($dataDP) {
                $transactionGenerate = true;

                $dental_piece_id = $dataDP->id;
            } else {
                $transactionGenerate = false;
            }

            $dataRP = $modelRP->findByAttribute("id", $attributesPost["reference_piece_id"]);
            $model->fill($attributesPost);
            $type= $attributesPost["typeDPBO"];
            $model->type=$type;
            $model->dental_piece_id = $dental_piece_id;
            $model->reference_piece_position_id = $reference_piece_position_id;
            $result = array();
            $transactionGenerate = $model->save();
            $modelRPT= ReferencePieceType::find($dataRP->reference_type_id);

            if ($transactionGenerate) {
                $result = array(
                    "data" => array(
                        "created_at" => $model->created_at,
                        "dental_piece_dentition" => $dataDP->dentition,
                        "dental_piece_id" => $model->dental_piece_id,
                        "dental_piece_name" => $dataDP->name,
                        "dental_piece_piece" => $dataDP->piece,
                        "description" => $model->description,
                        "reference_piece_id" => $model->reference_piece_id,
                        "id" => $model->id,
                        "reference_piece_color" => $modelRPT->color,
                        "reference_piece_name" => $dataRP->name,
                        "reference_piece_position_id" => $model->reference_piece_position_id,
                        "reference_piece_position_position" => $dataRPP->position,
                        "reference_piece_type" => $dataRP->type,
                        "status" => $model->status,
                        "type"=>$model->type
                    )


                );
                DB::commit();


            } else {
                DB::rollBack();
            }

            return Response::json($result);
        } catch (Exception $e) {

            DB::rollBack();

            return Response::json($transactionGenerate);
        }


    }

    public function getDataDentalPieceByOdontogramId()
    {
        $dataParams = Request::all();
        $odontogram_by_patient_id = $dataParams["odontogram_by_patient_id"];
        $model = new DentalPieceByOdontogram();
        $params = array("odontogram_by_patient_id" => $odontogram_by_patient_id);
        $result = ['success'=>true,'data'=>$model->getDataDentalPieceByOdontogramId($params)];
        return Response::json(
            $result
        );
    }



}
