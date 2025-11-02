<?php

namespace App\Http\Controllers\Geography;

use App\Http\Controllers\MyBaseController;
use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use DB;

class ZoneController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = View::make('zone.index', [

        ]);
    }

    public function getListZones()
    {
        $data = Request::all();

        $query = Zone::query()->select('id','name', 'city_id', 'color', 'zip_code',"polygon_coordinates","status","place_id",DB::raw('ST_AsText(polygon_spatial) as polygon_spatial'));

        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);
        $queryParams = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
        if (is_array($queryParams)) {
//            $queryParams = array_filter($queryParams);
            foreach ($queryParams as $key => $val) {
                $query->where($key, '=', $val);
            }
        }
        $recordsTotal = $query->get()->count();
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

    public function getListZonesMap()
    {
        $city_id = (Request::input('city_id'));
        $zones = Zone::where('city_id', '=', $city_id)
            ->where('status', Zone::STATUS_ACTIVE)
            ->orderBy('name', 'ASC')
            ->get();

        return Response::json(
            $zones
        );
    }

    public function getFormZone($id = null)
    {
        $method = 'POST';
        $zone = isset($id) ? Zone::selectRaw('zones.*, ST_Y(location) as lat, ST_X(location) as lng') : new Zone();
        $view = View::make('zone.loads._form', [
            'method' => $method,
            'zone' => $zone
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function postSaveZones()
    {
        if (Request::ajax()) {
            try {
                DB::beginTransaction();

                $data =Request::input('data');
                $zones = json_decode($data, true);

                foreach ($zones as $zone) {
                    $new_zone = isset($zone['id']) ? Zone::find($zone['id']) : new Zone();
                    $new_zone->name = $zone['name'];
                    $new_zone->color = $zone['color'];
                    $new_zone->polygon_coordinates = str_replace('"', '', json_encode($zone['polygon_coordinates']));
                    $coordinates = json_decode($new_zone->polygon_coordinates);
                    $points = [];
                    $ban = true;
                    $coordinate_last = null;
                    foreach ($coordinates as $coordinate) {
                        $lat = $coordinate[0];
                        $lng = $coordinate[1];
                        if ($ban) {
                            $coordinate_last = $coordinate;
                            $ban = false;
                        }
                        $points[] = new Point($lat, $lng);
                    }
                    if ($coordinate_last) {
                        $lat = $coordinate_last[0];
                        $lng = $coordinate_last[1];
                        $points[] = new Point($lat, $lng);
                    }

                    $new_zone->polygon_spatial = new Polygon([new LineString($points)]);
                    $new_zone->city_id = Request::input('city_id');;
                    $new_zone->status = 'ACTIVE';
                    $new_zone->save();
                }
                DB::commit();
                return Response::json(true);
            } catch (Exception $e) {
                DB::rollback();
                return Response::json(false);
            }
        }
    }

    public function postSave()
    {
        try {
            $data = Request::all();
            if ($data['zone_id'] == '') { //Create
                $zone = new Zone();
                $zone->status = 'ACTIVE';
            } else { //Update
                $zone = Zone::find($data['zone_id']);
                if (isset($data['status']))
                    $zone->status = $data['status'];
            }
            $zone->name = trim($data['name']);
            $zone->city_id = $data['city_id'];
            $zone->zip_code = $data['zip_code'];
            $zone->save();
            return Response::json(true);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }
//
    public function postIsNameUnique()
    {
        $validation = Validator::make(Request::all(), ['name' => 'unique:zones,name,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

    public function poligonSpatial()
    {
        $zones = Zone::all();
        foreach ($zones as $zone) {
            $coordinates = json_decode($zone->polygon_coordinates);
            $points = [];
            $ban = true;
            $coordinate_last = null;
            foreach ($coordinates as $coordinate) {
                $lat = $coordinate[0];
                $lng = $coordinate[1];
                if ($ban) {
                    $coordinate_last = $coordinate;
                    $ban = false;
                }
                $points[] = new Point($lat, $lng);
            }
            if ($coordinate_last) {
                $lat = $coordinate_last[0];
                $lng = $coordinate_last[1];
                $points[] = new Point($lat, $lng);
            }
            $zone->polygon_spatial = new Polygon([new LineString($points)]);
            $zone->save();
        }
    }
}
