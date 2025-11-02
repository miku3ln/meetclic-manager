<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\MyBaseController;
use App\Models\Patient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Mockery\Exception;

class PatientController extends MyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->layout->content = View::make('patient.index', []);
    }

    public function getListPatients()
    {
        $data = Request::all();
        $query = Patient::query();
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
//        dd($data);
        return Response::json(
            $result
        );
    }

    public function getDetailsPatient($id)
    {
        $patient = Patient::find($id);
        $view = View::make('patient.loads._details', [
            'patient' => $patient,
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }
    public function getManagament($id)
    {
        $model = Patient::find($id);
        $dataOdontogram = $model->getDataOdontogram($id);
        $params=array(

            "dataOdontogram"=>$dataOdontogram
        );

        $view = View::make('patient.loads._management', [
            'model' => $model,
            'patient' => $model,
            "params"=>$params
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getDetailsPatientStep1($id)
    {
        $patient = Patient::find($id);
        $view = View::make('medicalConsultationByPatient.loads.wizards.step1_details', [
            'patient' => $patient,
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getFormPatient($id = null)
    {
        $method = 'POST';
        $patient = isset($id) ? Patient::find($id) : new Patient();
        $view = View::make('patient.loads._form', [
            'method' => $method,
            'patient' => $patient,
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function getFormPatientModal($id = null)
    {
        $method = 'POST';
        $patient = isset($id) ? Patient::find($id) : new Patient();
        $view = View::make('patient.loads._form_modal', [
            'method' => $method,
            'patient' => $patient,
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }


    public function getListSelect2()
    {
        $data = Request::all();
        $query = Patient::query()->select('id', DB::raw('CONCAT(name) as text'));
        if (isset($data['q']) && !empty($data['q'])) {
            $query->orWhere('name', 'like', '%' . $data['q'] . '%');
            $query->orWhere('document', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', Patient::STATUS_ACTIVE);
        $query->limit(10)->orderBy('name', 'asc');
        $countriesList = $query->get()->toArray();
        return Response::json(
            $countriesList
        );
    }

    public function postSave()
    {
        DB::beginTransaction();
        try {
            $data = Request::all();
//            dd($data);
            $result = [];
            if ($data['patient_id'] == null) { //Create
                $patient = new Patient();
                $patient->status = 'ACTIVE';
            } else { //Update
                $patient = Patient::find($data['patient_id']);
                if (isset($data['status']))
                    $patient->status = $data['status'];
            }
            $patient->name = isset($data['name']) ? trim($data['name']) : null;
            $patient->document = isset($data['document']) ? trim($data['document']) : null;
            $patient->gender = isset($data['gender']) ? trim($data['gender']) : null;
            $patient->birthday_date = isset($data['birthday_date']) ? trim($data['birthday_date']) : null;
            $patient->address = isset($data['address']) ? trim($data['address']) : null;
            $patient->latitude = isset($data['latitude']) ? trim($data['latitude']) : null;
            $patient->longitude = isset($data['longitude']) ? trim($data['longitude']) : null;
            $patient->phone = isset($data['phone']) ? trim($data['phone']) : null;
            $patient->movil = isset($data['movil']) ? trim($data['movil']) : null;
            $patient->email = isset($data['email']) ? trim($data['email']) : null;
//            dd($patient->toArray());
            $result['success'] = $patient->save();
            if ($result['success']) {
                DB::commit();
                $result['data'] = $patient;
            } else {
                DB::rollback();
            }
            return Response::json($result);
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(false);
        }
    }

    public function postIsCodeUnique()
    {
        $validation = Validator::make(Request::all(), ['code' => 'unique:patients,code,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

    public function postIsRucValid()
    {
        $validation = Validator::make(Request::all(), ['ruc' => 'unique:patients,ruc,' . Request::input('id') . ',id']);
        $validation_ruc = Validator::make(Request::all(), ['ruc' => 'ecuador:ruc']);
        $validation_spub = Validator::make(Request::all(), ['ruc' => 'ecuador:ruc_spub']);
        $validation_spriv = Validator::make(Request::all(), ['ruc' => 'ecuador:ruc_spriv']);
        return Response::json(($validation->passes() && ($validation_ruc->passes() || $validation_spub->passes() || $validation_spriv->passes())) ? true : false);
    }

    public function postIsLicenseUnique()
    {
        $validation = Validator::make(Request::all(), ['license' => 'unique:motorized,license,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

    public function postIsDocumentValid()
    {
        $input = Request::all();
        $validation = Validator::make($input, ['document' => 'unique:patient,document,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

    public function postIsEmailUnique()
    {
        $validation = Validator::make(Request::all(), ['email' => 'unique:delivery_men,email,' . Request::input('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }


    public function getClinicalDocuments($id)
    {
        $model = Patient::find($id);
//        $id_table = "admin_odontogram_by_patient";
        $view = View::make('patient.loads._clinical_documents', [
            'model' => $model,
//            "id_table" => $id_table
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

}
