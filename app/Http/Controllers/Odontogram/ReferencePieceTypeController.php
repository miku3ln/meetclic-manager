<?php

namespace App\Http\Controllers\Odontogram;

use App\Http\Controllers\MyBaseController;
use App\Models\ReferencePieceType;
use App\Models\ReferencePieceTypePosition;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ReferencePieceTypeController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public $table = "reference_piece";
    public $name_manager = "Tipos de Referencia";

    public function index()
    {
        $model = new ReferencePieceType();
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
    public function getListReferencePieceTypes()
    {
        $data = Request::all();
        $query = ReferencePieceType::query();
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

    public function getFormReferencePieceType($id = null)
    {
        $method = 'POST';
        $model = isset($id) ? ReferencePieceType::find($id) : new ReferencePieceType();
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
        $type = isset($data["type"]) ?$data["type"]: $data["type"];
        $query = ReferencePieceType::query()->select('id', 'name as text', "color",'type',"status");
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        if ($type) {
            $query->where('type', '=', $type);
        }
        $query->where('status', '=', ReferencePieceType::STATUS_ACTIVE);

        $query->limit(10)->orderBy('name', 'asc');
        $modelList = $query->get()->toArray();
        return Response::json(
            $modelList
        );
    }

    public function postSave()
    {

        try {
            $model = new ReferencePieceType();
            $attributesPost = Request::all();
            if ($attributesPost[$model->getTable() . '_id'] == '') { //Create

                // $model->status = 'ACTIVE';
            } else { //Update
                $model = ReferencePieceType::find($attributesPost[$model->getTable() . '_id']);

            }
            $model->fill($attributesPost);
            $model->save();
            return Response::json(true);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }


}
