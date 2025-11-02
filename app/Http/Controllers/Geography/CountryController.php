<?php

namespace App\Http\Controllers\Geography;

use App\Http\Controllers\MyBaseController;
use App\Models\Country;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CountryController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = View::make('country.index', [

        ]);
    }

    public function getListCountries()
    {
        $data = Request::all();
        $query = Country::query();
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

    public function getFormCountry($id = null)
    {
        $method = 'POST';
        $country = isset($id) ? Country::find($id) : new Country();
        $view = View::make('country.loads._form', [
            'method' => $method,
            'country' => $country
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getListSelect2()
    {
        $data = Request::all();
        $query = Country::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', Country::STATUS_ACTIVE);
        $query->limit(10)->orderBy('name', 'asc');
        $countriesList = $query->get()->toArray();
        return Response::json(
            $countriesList
        );
    }

    public function postSave()
    {
        try {
            $data = Request::all();
            $update = false;
            if ($data['country_id'] == '') { //Create
                $country = new Country();
                $country->status = 'ACTIVE';
            } else { //Update
                $country = Country::find($data['country_id']);
                if (isset($data['status']))
                    $country->status = $data['status'];
                $update = true;

            }

            $country->fill($data);
            $validationsRules = [
                'name' => 'unique:countries,name',
                "iso_codes" => "required|max:8",
                "phone_code" => "required|max:15",
            ];
            $errors = [];
            $dataResult = [];
            if ($update) {
                $validationsRules['name'] = 'unique:countries,name,' . $data['country_id'] . ',id';

            }

            $validation = Validator::make($data, $validationsRules);
            $success = $validation->passes() ? true : false;
            if (!$success) {
                $errors = $validation->errors()->all();
            } else {

                $country->name = trim($data['name']);
                $country->place_id = isset($data['place_id']) ? $data['place_id'] : "ChIJ1UuaqN2HI5ARAjecEQSvdp0";
                $country->save();
                $dataResult['model'] = $country;
            }

            $result = [
                'success' => $success,
                'data' => $dataResult,
                'errors' => $errors
            ];
            return Response::json($result);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }

    public function postIsNameUnique()
    {
        $validation = Validator::make(Request::all(), ['name' => 'unique:countries,name,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

    public function getListS2Countries()
    {

        $model = new Country();
        $dataPost = Request::all();
        $result = $model->getListS2Countries($dataPost);
        return Response::json(
            $result
        );
    }
}
