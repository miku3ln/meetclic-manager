<?php

namespace App\Http\Controllers\DeliveryByBusinessManager;

use App\Http\Controllers\MyBaseController;
use App\Models\Customer;
use App\Models\CRM\DeliveryByBusinessManager;
use App\Models\InformationAddress;
use App\Models\InformationPhone;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class DeliveryByBusinessManagerController extends MyBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new DeliveryByBusinessManager();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new DeliveryByBusinessManager();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListCustomer()
    {

        $attributesPost = Request::all();

        $model = new Customer();
        $filters = [
            "business_id" => 1,

        ];
        if (isset($attributesPost["filters"]["search_value"]["term"])) {
            $filters["search_value"] = $attributesPost["filters"]["search_value"]["term"];
        }

        $result = $model->getListCustomers(["filters" => $filters]);
        return Response::json($result);
    }

    public function getListAddressByCustomer()
    {

        $attributesPost = Request::all();
        $model = new  InformationAddress();
        $customer_id = isset($attributesPost["filters"]["customer_id"]) ? $attributesPost["filters"]["customer_id"] : null;
        $entity_type = 0;
        $filters = [
            "filters" => ["business_id" => 1,
                "entity_id" => $customer_id,
                "entity_type" => $entity_type]


        ];
        $result = [];
        if ($customer_id == null) {

        } else {
            if (isset($attributesPost["filters"]["search_value"]["term"])) {
                $filters["search_value"] = $attributesPost["filters"]["search_value"]["term"];
            }

            $result = $model->getListDataEntity($filters);
        }
        return Response::json($result);
    }

    public function getListPhoneByCustomer()
    {

        $attributesPost = Request::all();
        $model = new  InformationPhone();
        $customer_id = isset($attributesPost["filters"]["customer_id"]) ? $attributesPost["filters"]["customer_id"] : null;
        $entity_type = 0;
        $filters = [
            "filters" => [
                "business_id" => 1,
                "entity_id" => $customer_id,
                "entity_type" => $entity_type
            ]
        ];
        $result = [];
        if ($customer_id == null) {

        } else {
            if (isset($attributesPost["filters"]["search_value"]["term"])) {
                $filters["search_value"] = $attributesPost["filters"]["search_value"]["term"];
            }
            $result = $model->getListDataEntity($filters);
        }

        return Response::json($result);
    }

    public function getUniqueNumberInvoice()
    {
        $inputPost = Request::all();

        $managerId = Request::input('id');
        $validations = $managerId ? 'unique:delivery_by_business_manager,number_invoice,' . $managerId : 'unique:delivery_by_business_manager,number_invoice';
        $inputsValidations = $managerId ? array(
            "number_invoice" => $inputPost['number_invoice'],
            "id" => $inputPost['id'],

        ) : array(
            "number_invoice" => $inputPost['number_invoice']
        );

        $validation = Validator::make($inputsValidations, ['number_invoice' => $validations]);
        return Response::json($validation->passes() ? true : false);
    }
}
