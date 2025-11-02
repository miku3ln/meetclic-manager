<?php

namespace App\Http\Controllers\Geography;

use App\Http\Controllers\MyBaseController;
use App\Models\Province;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProvinceController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = View::make('province.index', [

        ]);
    }

    public function getListProvinces()
    {
        $data = Request::all();
        $query = Province::query()->select('provinces.*', 'countries.name as country')
            ->join('countries', 'provinces.country_id', '=', 'countries.id');
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

    public function getFormProvince($id = null)
    {
        $method = 'POST';
        $province = isset($id) ? Province::find($id) : new Province();
        $view = View::make('province.loads._form', [
            'method' => $method,
            'province' => $province
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getListSelect2()
    {
        $data = Request::all();
        $query = Province::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $query->where('country_id', '=', $data['country_id']);
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', Province::STATUS_ACTIVE);
        $query->limit(10)->orderBy('name', 'asc');
        $provincesList = $query->get()->toArray();
        return Response::json(
            $provincesList
        );
    }

    public function postSave()
    {
        try {
            $data = Request::all();
            if ($data['province_id'] == '') { //Create
                $province = new Province();
                $province->status = 'ACTIVE';
            } else { //Update
                $province = Province::find($data['province_id']);
                if (isset($data['status']))
                    $province->status = $data['status'];
            }
            $province->name = trim($data['name']);
            $province->country_id = $data['country_id'];
            $province->save();
            return Response::json(true);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }

    public function postIsNameUnique()
    {
        $validation = Validator::make(Request::all(), ['name' => 'unique:provinces,name,' . Request::input('id') . ',id']);
        return Response::json(true);
    }
}
