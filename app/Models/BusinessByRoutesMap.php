<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\RoutesMapByRoutesDrawing;
use App\Models\RouteMapByAdventureTypes;

class BusinessByRoutesMap extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'business_by_routes_map';

    protected $fillable = array('business_id', 'routes_map_id', 'status');

    public $timestamps = true;


    public function getAdminBusiness($params)
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
        $selectString = "$this->table.id ,$this->table.routes_map_id,$this->table.status,$this->table.type_shortcut
        ,routes_map.name,routes_map.description,routes_map.options_map,routes_map.src";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('routes_map', 'business_by_routes_map.routes_map_id', '=', 'routes_map.id');
        if ($business_id) {

            $query->where("business_id", $business_id);
        }


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where('routes_map.name', 'like', $likeSet)
                ->orWhere('routes_map.description', 'like', $likeSet);
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

    public function getAdminBusinessData($params)
    {
        $result = $this->getAdminBusiness($params);
        $modelRMBRD = new RoutesMapByRoutesDrawing;
        $modelRMBAT = new RouteMapByAdventureTypes();
        foreach ($result["rows"] as $key => $row) {


            $setPush = json_decode(json_encode($row), true);
            $result["rows"][$key] = $setPush;
            $routes_map_id = $row->routes_map_id;
            $routes_drawing_data = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
            $business_by_routes_map_id = $row->id;
            $adventure_type_data = $modelRMBAT->getAdventureTypes(array("business_by_routes_map_id" => $business_by_routes_map_id));
            $result["rows"][$key]["routes_drawing_data"] = $routes_drawing_data;
            $result["rows"][$key]["adventure_type_data"] = $adventure_type_data;

        }

        return $result;

    }

    public function getAdminRoutes($params)
    {
        $sort = 'asc';
        $field = 'status';
        $query = DB::table($this->table);

        $business_id = isset($params["filters"]["business_id"]) ? $params["filters"]["business_id"] : null;
        $allowFilters = ($params["filters"]["categories"]["keys"] == "" && $params["filters"]["categories"]["all"] == "false" && $params["filters"]["subcategories"]["keys"] == "") ? false : true;

        if (isset($params['sort'])) {
            $field = $column = array_keys($params['sort']);
            $field = $field[0];
            $sort = $params['sort'][$column[0]];

        }
        $page = isset($params['current']) ? (int)$params['current'] : 0;
        $perpage = isset($params['rowCount']) ? $params['rowCount'] : 10;
        $selectString = "$this->table.id ,$this->table.routes_map_id,$this->table.status,$this->table.type_shortcut
        ,routes_map.name,routes_map.description,routes_map.options_map,routes_map.src";

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('routes_map', 'business_by_routes_map.routes_map_id', '=', 'routes_map.id');
        if ($business_id) {
            $query->where("business_id", $business_id);
        }
        $query->where("$this->table.status", "ACTIVE");
        $allowCondition = false;
        $nameColumn = "";
        $dataIn = array();
        if ($allowFilters) {

            if ($params["filters"]["categories"]["keys"] != "") {//only categories


            } else {//only subcategories


            }
            $categoriesIn = explode(',', $params["filters"]["subcategories"]["keys"]);
            $dataIn = $categoriesIn;
            $allowCondition = true;
            $nameColumn = "$this->table.type_shortcut";
            if ($allowCondition) {
                $query->whereIn($nameColumn, $dataIn);
            }

        }


        if ($params['searchPhrase'] != null) {
            $searchValue = $params['searchPhrase'];
            $likeSet = "%" . $searchValue . "%";
            $query->where('routes_map.name', 'like', $likeSet)
                ->orWhere('routes_map.description', 'like', $likeSet);
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

    public function getAdminRoutesData($params)
    {
        $result = $this->getAdminRoutes($params);
        $modelRMBRD = new RoutesMapByRoutesDrawing;

        /*  foreach ($result["rows"] as $key => $row) {


              $setPush = json_decode(json_encode($row), true);
              $result["rows"][$key] = $setPush;
              $routes_map_id = $row->routes_map_id;
              $routes_drawing_data = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
              $result["rows"][$key]["routes_drawing_data"] = $routes_drawing_data;
          }*/

        return $result;

    }

    public function getRouteById($params = array())
    {
        $select = "*";
        $id = $params["id"];
        $query = BusinessByRoutesMap::query()->select($select);
        $query->where("status", '=', self::STATUS_ACTIVE);
        $query->where("id", '=', $id);
        $data = $query->get()->toArray();

        return $data;
    }

    public function getListSelect2($params)
    {
        $business_id = $params["filters"]['business_id'];
        $selectString = "$this->table.routes_map_id,$this->table.status,$this->table.type_shortcut
        ,routes_map.id ,routes_map.name,routes_map.name text,routes_map.description,routes_map.options_map,routes_map.src";
        $query = DB::table($this->table);

        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('routes_map', 'business_by_routes_map.routes_map_id', '=', 'routes_map.id');
        if ($business_id) {
            $query->where("business_id", $business_id);
        }
        $query->where("$this->table.status", "ACTIVE");
        if (isset($params["filters"]['search_value']["term"])) {

            $likeSet = $params["filters"]['search_value']["term"];
            $query->where(function ($query) use ($likeSet
            ) {
                $query->orWhere($this->table . '.id', 'like', '%' . $likeSet . '%');
                $query->orWhere("routes_map.name", 'like', '%' . $likeSet . '%');
                $query->orWhere("routes_map.description", 'like', '%' . $likeSet . '%');

            });;

        }

        $query->limit(10)->orderBy('routes_map.name', 'asc');
        $resultData = $query->get()->toArray();

        $modelRMBRD = new RoutesMapByRoutesDrawing;
        $modelRMBAT = new RouteMapByAdventureTypes();
        $modelBBP = new \App\Models\BusinessByPanorama();
        $result=[];
        foreach ($resultData as $key => $row) {


            $setPush = (array)$row;

            $routes_map_id = $row->routes_map_id;
            $business_by_routes_map_id = $row->id;
            $adventure_type_data = $modelRMBAT->getAdventureTypes(array("business_by_routes_map_id" => $business_by_routes_map_id));
            $routes_drawing_data_management = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
            $routes_drawing_data = [];

            foreach ($routes_drawing_data_management as $key => $value) {
                $setPushRoute = (array)$value;
                if ($value->rd_type == 'marker') {
                    $routes_map_id = $value->routes_map_id;
                    $routes_drawing_id = $value->routes_drawing_id;
                    $dataMarkerMultimedia = $modelBBP->getMultimedia([
                        'filters' => [
                            'routes_map_id' => $routes_map_id,
                            'routes_drawing_id' => $routes_drawing_id,

                        ]
                    ]);
                    if (count($dataMarkerMultimedia)) {

                        $setPushRoute['data'] = $dataMarkerMultimedia;
                    }
                }
                $routes_drawing_data[] = $setPushRoute;


            }
            $setPush["routes_drawing_data"]=$routes_drawing_data ;
            $setPush["adventure_type_data"] =$adventure_type_data;

            $result[] = $setPush;


        }


        return $result;

    }

    public function getDataRoute($params)
    {
        $routes_map_id = $params['filters']['id'];
        $selectString = "$this->table.id business_by_routes_map_id ,$this->table.routes_map_id,$this->table.status,$this->table.type_shortcut
        ,routes_map.id id ,routes_map.name,routes_map.name text,routes_map.description,routes_map.options_map,routes_map.src";
        $query = DB::table($this->table);
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('routes_map', 'business_by_routes_map.routes_map_id', '=', 'routes_map.id');
        $query->where("routes_map.id", '=', $routes_map_id);

        $row = $query->get()->first();

        $modelRMBRD = new RoutesMapByRoutesDrawing;
        $modelRMBAT = new RouteMapByAdventureTypes();
        $modelBBP = new \App\Models\BusinessByPanorama();

        $setPush = (array)$row;
        $result = $setPush;
        $routes_map_id = $row->routes_map_id;
        $routes_drawing_data_management = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
        $routes_drawing_data = [];

        foreach ($routes_drawing_data_management as $key => $value) {
            $setPush = (array)$value;
            if ($value->rd_type == 'marker') {
                $routes_map_id = $value->routes_map_id;
                $routes_drawing_id = $value->routes_drawing_id;
                $dataMarkerMultimedia = $modelBBP->getMultimedia([
                    'filters' => [
                        'routes_map_id' => $routes_map_id,
                        'routes_drawing_id' => $routes_drawing_id,

                    ]
                ]);
                if (count($dataMarkerMultimedia)) {

                    $setPush['data'] = $dataMarkerMultimedia;
                }
            }
            $routes_drawing_data[] = $setPush;


        }
        $business_by_routes_map_id = $row->id;
        $adventure_type_data = $modelRMBAT->getAdventureTypes(array("business_by_routes_map_id" => $business_by_routes_map_id));
        $result["routes_drawing_data"] = $routes_drawing_data;
        $result["adventure_type_data"] = $adventure_type_data;


        return $result;

    }
}
