<?php

namespace App\Http\Controllers\Geography;

use App\Http\Controllers\MyBaseController;
use App\Models\City;
use App\Models\Order;
use App\Services\FirebaseService;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Services\PointService;

class CityController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = View::make('city.index', [

        ]);
    }

    public function getListCities()
    {
        $data = Request::all();

        $query = City::query()->selectRaw('cities.*, ST_Y(location) as lat, ST_X(location) as lng');

        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);

        // filter by field query
        $queryParams = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
        if (is_array($queryParams)) {
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
        $total = $recordsTotal;

        // sort
        $query->orderBy($field, $sort);

        if ($perpage > 0) {
            $pages = ceil($total / $perpage);
            $page = max($page, 1);
            $page = min($page, $pages);
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }

        // ✅ Mapea solo el campo location
        $data = $query->get()->map(function ($city) {
            $array = $city->toArray();
            $array['location'] = [
                'lat' => $city->lat,
                'lng' => $city->lng,
            ];
            unset($array['lat'], $array['lng']);
            return $array;
        })->toArray();

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

        return Response::json($result);
    }


    public function getFormCity($id = null)
    {
        $method = 'POST';
        $city = isset($id) ? City::selectRaw('cities.*, ST_Y(location) as lat, ST_X(location) as lng')->find($id)
            : new City();
        $view = View::make('city.loads._form', [
            'method' => $method,
            'city' => $city,

        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function postSave()
    {
        try {
            $data = Request::all();
            if ($data['city_id'] == '') { //Create
                $city = new City();
                $city->status = 'ACTIVE';
            } else { //Update
                $city = City::find($data['city_id']);
                if (isset($data['status']))
                    $city->status = $data['status'];
            }
            $city->name = trim($data['name']);
            $latitude = (float)$data['latitude'];
            $longitude = (float)$data['longitude'];
            $modelReady=new PointService($latitude, $longitude);
            $city->location = $modelReady->latLngToPoint($latitude, $longitude);
            $city->province_id = $data['province_id'];
            $city->save();
            return Response::json(true);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }

    public function postIsNameUnique()
    {
        $validation = Validator::make(Request::all(), ['name' => 'unique:cities,name,' . Request::input('id') . ',id']);
        return Response::json(true);
    }

    public function getListSelect2()
    {
        $data = Request::all();

        try {

        $query = City::query()->select('cities.id', 'cities.name as text',
            DB::raw(
                'ST_Y(cities.location) AS latitude,
                 ST_X(cities.location) AS longitude'
            )
        )
            ->join('provinces', 'provinces.id', '=', 'cities.province_id')
            ->join('countries', 'countries.id', '=', 'provinces.country_id');

        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('cities.name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('cities.id', '=', $data['id']);
        }
        if (isset($data['ids']) && !empty($data['ids'])) {
            $query->whereIn('cities.id', json_decode($data['ids']));
        }
        if (isset($data['province_id']) && !empty($data['province_id'])) {
            $query->where('province_id', '=', $data['province_id']);
        }
        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $query->where('countries.id', $data['country_id']);
        }

        $query->where('cities.status', '=', City::STATUS_ACTIVE);
        $query->limit(10)->orderBy('cities.name', 'asc');

        $citiesList = $query->get()->toArray();
        $result = Response::json(
            $citiesList
        );

        } catch (Exception $e) {
            $msj = $e->getMessage();
            dd($msj);
            $result=[];
        }
        return $result;
    }

    public function setPointCities()
    {
        $cities = City::all();
        foreach ($cities as $city) {
            $city->location = new PointService($city->latitude, $city->longitude);
            $city->save();
        }
    }
}
