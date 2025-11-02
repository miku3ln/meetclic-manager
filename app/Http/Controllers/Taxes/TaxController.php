<?php

namespace App\Http\Controllers\Taxes;

use App\Http\Controllers\MyBaseController;
use App\Models\City;
use App\Models\Country;
use App\Models\Province;
use App\Models\Tax;
use App\Models\TaxByCity;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use DB;

class TaxController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = View::make('tax.index', [

        ]);
    }

    public function getListTaxes()
    {
        $data = Request::all();

        $query = Tax::query()->select('taxes.*', DB::raw("(GROUP_CONCAT(cities.name)) as `city`"))
            ->leftjoin('taxes_by_cities', 'taxes.id', '=', 'taxes_by_cities.tax_id')
            ->leftjoin('cities', 'taxes_by_cities.city_id', '=', 'cities.id')
            ->groupBy('taxes.id');
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

    public function getFormTax($id = null)
    {
        $method = 'POST';
        $tax = isset($id) ? Tax::find($id) : new Tax();
        $countries = isset($id) ? $this->getCountryTax($id):Country::where('status',Country::STATUS_ACTIVE)->get()->toArray();
        $cities = isset($id) ? $tax->citiesByTax->pluck('city_id')->toArray():[];
        $cities= json_encode($cities);

        $province_id = isset($id) ? City::where('id',$cities[0])->pluck('province_id')->toArray()[0] :null;
        $country_id = isset($id) ? $countries[0]['id'] :null;
        $view = View::make('tax.loads._form', [
            'method' => $method,
            'tax' => $tax,
            'cities' =>$cities,
            'province_id' => $province_id,
            'country_id' => $country_id
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getCitiesTax($idTax)
    {
        $taxByCity = TaxByCity::where('tax_id',$idTax)
            ->get()->toArray();
        return $taxByCity;

    }

    public function getCountryTax($idTax)
    {
        $taxByCity = TaxByCity::where('tax_id', $idTax)->first()->toArray();
        $cityId = City::where('id', $taxByCity['city_id'])->first()->toArray();
        $provinceId = Province::where('id', $cityId['province_id'])->first()->toArray();
        $countryId = Country::where('id', $provinceId['country_id'])->get()->toArray();
        return $countryId;

    }

    public function getListCountrySelect2()
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

    public function unshift_select_item($array, $word = '- Seleccione -', $value = '')
    {
        $result = array();
        if (is_array($array)) {
            foreach ($array as $value) {
                array_push($result, array('id' => $value['id'], 'text' => $value['name']));
            }

        } else {
            return array($value => $word);
        }
        return $result;

    }

    public function getListSelect2()
    {
        $data = Request::all();
        $query = Tax::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', Tax::STATUS_ACTIVE);
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
            $result =[];
            $cities = explode(",", $data['cities_id']);
            if ($data['tax_id'] == '') { //Create
                $update = false;
                $tax = new Tax();
                $tax->status = 'ACTIVE';
            } else { //Update
                $update = true;
                $tax = Tax::find($data['tax_id']);
                $taxByCities = $this->getCitiesTax($data['tax_id']);
                $country_tax = $this->getCountryTax($data['tax_id']);
                if (isset($data['status']))
                    $tax->status = $data['status'];
            }
            $tax->name = trim($data['name']);
            $tax->value = trim($data['value']);
            $result['success'] = $tax->save();
            if ($result['success']) {
                if (!$update) {
                    foreach ($cities as $city) {
                        $taxByCity = new TaxByCity();
                        $taxByCity->tax_id = $tax->id;
                        $taxByCity->city_id = $city;
                        $taxByCity->save();
                    }
                } else {
                    if ($country_tax[0]['id'] != $data['country_id']) {
                        $dataTaxByCities = [];
                        foreach ($taxByCities as $key => $value) {
                            $dataTaxByCities[$value['id']] = $value['id'];
                        }
                        TaxByCity::whereIn('id', $dataTaxByCities)->delete();
                        foreach ($cities as $city) {
                            $taxByCity = new TaxByCity();
                            $taxByCity->tax_id = $tax->id;
                            $taxByCity->city_id = $city;
                            $taxByCity->save();
                        }
                    }
                    $tax->cities()->sync($cities);
                }

            }
            return Response::json($result['success']);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }

    public function postIsNameUnique()
    {
        $validation = Validator::make(Request::all(), ['name' => 'unique:taxes,name,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

    public function getListCitiesByTax()
    {
        $data = Request::all();
        $query = TaxByCity::query()->select('cities.*')
            ->leftjoin('cities', 'taxes_by_cities.city_id', '=', 'cities.id');
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
}
