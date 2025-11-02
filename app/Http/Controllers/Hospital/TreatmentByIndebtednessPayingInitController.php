<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\MyBaseController;
use App\Models\TreatmentByIndebtednessPayingInit;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class TreatmentByIndebtednessPayingInitController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new TreatmentByIndebtednessPayingInit();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new TreatmentByIndebtednessPayingInit();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  TreatmentByIndebtednessPayingInit();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }


    public function getManagement()
    {

        $attributesPost = Request::all();
        $model = new  TreatmentByIndebtednessPayingInit();
        $data = $model->getManagement($attributesPost);

        if ($data == null) {
            $data = [];
        } else {

            $treatment_by_indebtedness_paying_init_id = $data->id;
            $modelBreakdown = new \App\Models\TreatmentByBreakdownPayment();
            $treatment_by_patient_id=$data->treatment_by_patient_id;
            $existPaymentsManagement = $modelBreakdown->getExistPayments(['filters' => [
                'treatment_by_indebtedness_paying_init_id' => $treatment_by_indebtedness_paying_init_id
            ]]);

           $number_payments= $data->number_payments;

            $allowUpdate = $number_payments == $existPaymentsManagement['numberPayments'];
            $existPaymentsManagement['success'] = $allowUpdate;

            $data = [
                'id'=>$data->id,
                'number_payments'=>$data->number_payments,
                'treatment_by_indebtedness_paying_init_id'=>$data->number_payments,
                'ExistPaymentsManagement'=>$existPaymentsManagement,

            ];
        }
        $data = $data == null ? [] : $data;
        $result = ['success' => true, 'data' => $data];
        return Response::json($result);
    }
}
