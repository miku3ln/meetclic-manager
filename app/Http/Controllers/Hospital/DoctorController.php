<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\MyBaseController;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class DoctorController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->layout->content = View::make('doctor.index', [

        ]);
    }

    public function getListDoctors()
    {
        $data = Request::all();
        $query = Doctor::query();
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

    public function getFormDoctor($id = null)
    {
        $method = 'POST';
        $doctor = isset($id) ? Doctor::find($id) : new Doctor();
        $view = View::make('doctor.loads._form', [
            'method' => $method,
            'doctor' => $doctor
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getListSelect2()
    {
        $data = Request::all();
        $query = Doctor::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', Doctor::STATUS_ACTIVE);
        $query->limit(10)->orderBy('name', 'asc');
        $doctorsList = $query->get()->toArray();
        return Response::json(
            $doctorsList
        );
    }

    public function postSave()
    {
        DB::beginTransaction();
        try {
            $data = Request::all();
//            dd($data);
            $result = [];
            if ($data['doctor_id'] == '') { //Create
                $doctor = new Doctor();
                $doctor->status = 'ACTIVE';

            } else { //phone
                $doctor = Doctor::find($data['doctor_id']);
                if (isset($data['status']))
                    $doctor->status = $data['status'];
            }
            $doctor->name = trim($data['name']);
            $doctor->document = trim($data['document']);
            $doctor->gender = isset($data['gender']) ? $data['gender'] : null;
            $doctor->birthday_date = isset($data['birthday_date']) ? $data['birthday_date'] : null;
            $doctor->address = isset($data['address']) ? trim($data['address']) : null;
            $doctor->email = isset($data['email']) ? trim($data['email']) : null;
            $doctor->latitude = isset($data['latitude']) ? $data['latitude'] : null;
            $doctor->longitude = isset($data['longitude']) ? $data['longitude']:null;
            $doctor->movil = isset($data['movil']) ? $data['movil'] : null;
            $doctor->phone = isset($data['phone']) ? $data['phone'] : null;

            $result['success'] =  $doctor->save();
            if ($result['success']) {
                DB::commit();
            } else {
                DB::rollback();
            }
            return Response::json($result['success']);
        } catch (Exception $e) {
            return Response::json(false);
        }
    }

    public function postIsNameUnique()
    {
        $validation = Validator::make(Request::all(), ['name' => 'unique:doctors,name,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

    public function postIsDocumentValid()
    {
        $input = Request::all();
        $validation = Validator::make($input, ['document' => 'unique:doctor,document,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }
}
