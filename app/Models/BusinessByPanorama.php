<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Panorama;
use App\Models\BusinessPanoramaByPoints;

class BusinessByPanorama extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    protected $table = 'business_by_panorama';

    protected $fillable = array(
        "id",//*
        "business_id",//*
        "status",//*
        "panorama_id",//*
        "routes_map_by_routes_drawing_id"

    );
    public $attributesData = array(

        "business_id",//*
        "status",//*
        "panorama_id",//*
        "routes_map_by_routes_drawing_id"
    );
    public $timestamps = false;

    public function getActionsManager()
    {
        $model_entity = $this->getUpperCaseTable($this->table);
        $action_get_form = $model_entity . "'\'" . $model_entity . "Controller" . "@getForm" . $model_entity;
        $action_get_form = str_replace("'", "", $action_get_form);
        $action_save = $model_entity . "'\'" . $model_entity . "Controller" . "@postSave";
        $action_save = str_replace("'", "", $action_save);
        $action_load = $model_entity . "'\'" . $model_entity . "Controller" . "@getList" . $model_entity;
        $action_load = str_replace("'", "", $action_load);
        $model_entity = $this->getCamelCase();
        return [
            "action_get_form" => $action_get_form,
            "action_save_" . $model_entity => $action_save,
            "action_load_" . $model_entity . "s" => $action_load];
    }

    public function getUpperCaseTable($name_change)
    {
        $table = $name_change;
        $arrayNames = explode("_", $table);
        $model_entity = "";
        foreach ($arrayNames as $name) {
            // your code
            $model_entity .= ucfirst($name);
        }

        return $model_entity;
    }

    public function getCamelCase()
    {

        return lcfirst($this->getUpperCaseTable($this->table));
    }

    public function findAllByAttributes($attributes = array(), $values = array(), $columns = array('*'))
    {
        $response = DB::table($this->table)
            ->select($columns);
        if (!is_array($attributes) || !is_array($values)) {
            throw new Exception('$attributes and $values should be array.');
        }
        if (count($attributes) < 1 || count($values) < 1) {
            throw new Exception('$attributes and $values can not be empty.');
        }
        if (count($attributes) != count($values)) {
            throw new Exception('$attributes and $values must have the same length.');
        }
        foreach ($attributes as $key => $attribute) {
            $response->where($attribute, "=", $values[$key]);
        }
        return $response->get();
    }


    public function getPanoramaByBusiness($params)
    {

        $business_id = $params["business_id"];
        $query = DB::table($this->table)
            ->select(
                $this->table . '.*',
                DB::raw("routes_map_by_routes_drawing.routes_map_id,routes_map_by_routes_drawing.routes_drawing_id "),

                DB::raw("(panorama.title) as `p_title` ,(panorama.subtitle) as `p_subtitle`,(panorama.description) as `p_description`,(panorama.type_panorama) as `p_type_panorama`,(panorama.points_allow) as `p_points_allow`,(panorama.src) as `p_src`,(panorama.type_breakdown) as `p_type_breakdown`")
            )
            ->join('panorama', $this->table . '.panorama_id', '=', 'panorama.id')
            ->join('routes_map_by_routes_drawing', $this->table . '.routes_map_by_routes_drawing_id', '=', 'routes_map_by_routes_drawing.id');
        $query->where("business_id", $business_id);

        return $query->get()->toArray();
    }

    public function getDataPanoramaByBusiness($params)
    {
        $modelBPBP = new BusinessPanoramaByPoints;

        $dataPanorama = $this->getPanoramaByBusiness($params);
        $result = array();
        foreach ($dataPanorama as $key => $row) {
            $id = $row->id;
            $dataPoints = array();
            if ($row->p_points_allow == 1) {
                $dataPoints = $modelBPBP->getPointsByPanorama(array("business_by_panorama_id" => $id));

            }
            $setPush = array(
                "dataPoints" => $dataPoints,
                'id' => $row->id,
                'business_id' => $row->business_id,
                'status' => $row->status,
                'panorama_id' => $row->panorama_id,
                'p_title' => $row->p_title,
                'p_subtitle' => $row->p_subtitle,
                'p_description' => $row->p_description,
                'p_type_panorama' => $row->p_type_panorama,
                'p_points_allow' => $row->p_points_allow,
                'p_src' => $row->p_src,
                'p_type_breakdown' => $row->p_type_breakdown,
                'routes_map_by_routes_drawing_id' => $row->routes_map_by_routes_drawing_id,
                "routes_map_id" => $row->routes_map_id,
                "routes_drawing_id" => $row->routes_drawing_id,

            );
            array_push($result, $setPush);
        }
        return $result;

    }


    public function getMultimedia($params)
    {

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.business_id,$this->table.status,$this->table.panorama_id,$this->table.routes_map_by_routes_drawing_id
        ,panorama.title p_title,panorama.subtitle p_subtitle,panorama.description p_description,panorama.type_panorama p_type_panorama,panorama.points_allow p_points_allow,panorama.src p_src,panorama.type_breakdown p_type_breakdown
        ,routes_drawing.name rd_name,routes_drawing.description rd_description
        ,routes_map.name rm_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('panorama', "$this->table.panorama_id", '=', 'panorama.id');
        $query->join('routes_map_by_routes_drawing', "$this->table.routes_map_by_routes_drawing_id", '=', 'routes_map_by_routes_drawing.id');
        $query->join('routes_drawing', "routes_map_by_routes_drawing.routes_drawing_id", '=', 'routes_drawing.id');
        $query->join('routes_map', "routes_map_by_routes_drawing.routes_map_id", '=', 'routes_map.id');

        $query->where("$this->table.status", "=", 'ACTIVE');
        $routes_map_id=$params['filters']['routes_map_id'];
        $routes_drawing_id=$params['filters']['routes_drawing_id'];

        $query->where("routes_map_by_routes_drawing.routes_map_id", "=", $routes_map_id);
        $query->where("routes_map_by_routes_drawing.routes_drawing_id", "=", $routes_drawing_id);

        $query->orderBy('routes_map.id', 'asc');

        $data = $query->get()->toArray();

        $result = $data;

        return $result;
    }

    public function getAdminPanoramaData($params)
    {
        $result = $this->getAdminPanorama($params);
        /*  $modelRMBRD = new RoutesMapByRoutesDrawing;*/

        /*    foreach ($result["rows"] as $key => $row) {


                $setPush = json_decode(json_encode($row), true);
                $result["rows"][$key] = $setPush;
                $routes_map_id = $row->routes_map_id;
                $routes_drawing_data = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
                $result["rows"][$key]["routes_drawing_data"] = $routes_drawing_data;
            }*/

        return $result;

    }

    public function getAdminPanorama($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);

        $business_id = isset($params["filters"]["business_id"]) ? $params["filters"]["business_id"] : null;
        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.business_id,$this->table.status,$this->table.panorama_id,$this->table.routes_map_by_routes_drawing_id
        ,panorama.title p_title,panorama.subtitle p_subtitle,panorama.description p_description,panorama.type_panorama p_type_panorama,panorama.points_allow p_points_allow,panorama.src p_src,panorama.type_breakdown p_type_breakdown
        ,routes_drawing.name rd_name,routes_drawing.description rd_description
        ,routes_map.name rm_name";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('panorama', "$this->table.panorama_id", '=', 'panorama.id');
        $query->join('routes_map_by_routes_drawing', "$this->table.routes_map_by_routes_drawing_id", '=', 'routes_map_by_routes_drawing.id');
        $query->join('routes_drawing', "routes_map_by_routes_drawing.routes_drawing_id", '=', 'routes_drawing.id');
        $query->join('routes_map', "routes_map_by_routes_drawing.routes_map_id", '=', 'routes_map.id');

        if ($business_id) {
            $query->where("business_id", $business_id);
        }
        $query->where("$this->table.status", "ACTIVE");
        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where('panorama.title', 'like', $likeSet)
                ->orWhere('panorama.subtitle', 'like', $likeSet)
                ->orWhere('panorama.description', 'like', $likeSet)
                ->orWhere('routes_map.name', 'like', $likeSet);
        }
        $query->orderBy('routes_map.id', 'asc');
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
}
