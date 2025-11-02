<?php

namespace App\Http\Controllers\Odontogram;

use App\Http\Controllers\MyBaseController;
use App\Models\ReferencePiece;
use App\Models\ReferencePiecePosition;
use App\Models\ReferencePieceType;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ReferencePieceController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public $table = "reference_piece";
    public $name_manager = "Piezas Referencia";

    public function index()
    {
        $model = new ReferencePiece();
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
    public function getListReferencePieces()
    {
        $data = Request::all();
        $query = ReferencePiece::query();
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);

        //TODO: implement functionality to search
        // search filter by keywords
        //        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch']) ? $datatable['query']['generalSearch'] : '';
        //        if (!empty($filter)) {
        //            $data = array_filter($data, function ($a) use ($filter) {
        //                return (boolean)preg_grep("/$filter/i", (array)$a);
        //            });
        //            unset($datatable['query']['generalSearch']);
        //        }
        //
        //// filter by field query
        //        $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
        //        if (is_array($query)) {
        //            $query = array_filter($query);
        //            foreach ($query as $key => $val) {
        //                $data = list_filter($data, [$key => $val]);
        //            }
        //        }

        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'name';
        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = $recordsTotal; // total items in array
    $query->select(
        "reference_piece.id","reference_piece.name","reference_piece.status","reference_piece.type","reference_piece_type.name as name_type",
       "reference_piece_type.color"

            );
        $query->join('reference_piece_type', 'reference_piece_type.id', '=', 'reference_piece.reference_type_id');
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

    public function getFormReferencePiece($id = null)
    {
        $method = 'POST';
        $model = isset($id) ? ReferencePiece::find($id) : new ReferencePiece();

        $camerCase = $model->getCamelCase();
        $model_entity = $model->getTable();
        $renderView = $camerCase . '.loads._form';
        $dataReferencePiece=ReferencePieceType::all();
        $reference_type_id_data=array();
        foreach ($dataReferencePiece as $key){
            $reference_type_id_data[$key->id]=[
                'text'=>$key->name,
                                'id'=>$key->id,
                'color'=>$key->color,

            ];

        }
        $view = View::make($renderView, [
            'method' => $method,
            'model' => $model,
            "reference_type_id_data"=>$reference_type_id_data ,
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
        $type = isset($data["type"]) ?$data["type"]: $data["type"];
        $query = ReferencePiece::query()->select('reference_piece.id', 'reference_piece.name as text', "reference_piece_type.color",'type',"reference_piece.status");
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('reference_piece.name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        if ($type) {
            $query->where('type', '=', $type);
        }
        $query->join('reference_piece_type', 'reference_piece_type.id', '=', $this->table . '.reference_type_id');
        $query->where('reference_piece.status', '=', ReferencePiece::STATUS_ACTIVE);

        $query->limit(10)->orderBy('reference_piece.name', 'asc');
        $modelList = $query->get()->toArray();
        return Response::json(
            $modelList
        );
    }

    public function postSave()
    {

        try {
            $model = new ReferencePiece();
            $attributesPost = Request::all();
            if ($attributesPost[$model->getTable() . '_id'] == '') { //Create

                // $model->status = 'ACTIVE';
            } else { //Update
                $model = ReferencePiece::find($attributesPost[$model->getTable() . '_id']);

            }
            $model->fill($attributesPost);
            $model->reference_type_id=$attributesPost["reference_type_id"];
            $model->save();
            return Response::json(true);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }


}
