<?php
//CPP-010
namespace App\Models\Helpdesk;

use App\Models\Exception;
use App\Models\ModelManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HelpdeskTypes extends ModelManager
{


    protected $table = 'help_desk_types';
    /*
     * primary key used by the model
     */
    protected $primaryKey = 'id';

    public $timestamps = false;
    public $modelName = 'HelpDeskTypes';

    protected $fillable = array(
        "id",//*
        "name",//*
        "description",//
        "business_id",
        "status",
        "predetermined",
        "year",

    );
    public $attributesData = array(
        "id",//*
        "name",//*
        "description",//
        "business_id",
        "status",
        "predetermined",
        "year"

    );


    public static function getRulesModel()
    {
        $rules = [
            "name" => 'required',
            "business_id" => 'required',
            "status" => 'required',

        ];
        return $rules;
    }


    public function getAdmin($params)
    {
        $sort = 'asc';
        $field = 'name';
        $query = DB::table($this->table);

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }

        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.name ,$this->table.description ,$this->table.status,$this->table.predetermined,$this->table.year,$this->table.business_id
   ";

        $select = DB::raw($selectString);
        $query->select($select);

        $business_id = null;
        if (isset($params['filters']['business_id'])) {
            $business_id = ($params['filters']['business_id']);
            $query->where($this->table . '.business_id', '=', $business_id);
        }

        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where(function ($query) use (
                $likeSet
            ) {
                $query->where($this->table . '.name', 'like', $likeSet)
                    ->orWhere($this->table . '.description', 'like', $likeSet);

            });
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


    public function getAdminData($params)
    {
        $result = $this->getAdmin($params);
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

            $model = new HelpdeskTypes();
            $createUpdate = true;
            if (isset($attributesPost[$this->modelName]["id"]) && $attributesPost[$this->modelName]["id"] != "null" && $attributesPost[$this->modelName]["id"] != "-1") {
                $model = HelpdeskTypes::find($attributesPost[$this->modelName]['id']);
                $createUpdate = false;
            } else {
                $createUpdate = true;

            }
            $postData = $attributesPost[$this->modelName];
            $attributesSet = array(
                "name" => $postData["name"],
                "year" => 2023,
                "predetermined" => 1,
                "description" => $postData["description"],
                "business_id" => $postData["business_id"],
            );

            $model->attributes = $attributesSet;
            $validateResult = $model->validate();
            $success = $validateResult["success"];
            if ($success) {
                $model->fill($attributesSet);
                $model->save();

            } else {
                $success = false;
                $msj = "Problemas al guardar .";
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


}



