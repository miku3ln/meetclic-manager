<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\MyBaseController;
use App\Models\OrderPaymentsManager;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class OrderPaymentsManagerController extends MyBaseController
{
    public function getAdminCustomer($params)
    {
        $result = $this->getDataAdminCustomer($params);
        $modelDelivery = new OrderShoppingByDelivery();
        foreach ($result['rows'] as $key => $row) {

            $order_shopping_cart_id = $row->order_shopping_cart_id;
            $same_billing_address = $row->same_billing_address;
            $result['rows'][$key] = (array)$row;

            $orderShoppingCart = OrderShoppingCart::find($order_shopping_cart_id);
            $orderShoppingCartDetails = $orderShoppingCart->orderShoppingCartByDetails;
            $result['rows'][$key]['details'] = $orderShoppingCartDetails;

            if ($same_billing_address == 0) {
                $modelDeliveryData = $modelDelivery->getDelivery(
                    [
                        'filters' => [
                            'order_shopping_cart_id' => $order_shopping_cart_id
                        ]]
                );
                $result['rows'][$key]['billing'] = $modelDeliveryData;
            }


        }

        return $result;
    }

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new OrderPaymentsManager();
        $allowRoutes = env('allowRoutes');
        if(!$allowRoutes){

        $result = $model->getAdmin($dataPost);
        }else{
            $result = $model->getAdminEvent($dataPost);

        }

        return Response::json(
            $result
        );
    }
    public function getAdminCustomers()
    {
        $dataPost =Request::all();
        $model = new OrderPaymentsManager();
        $allowRoutes = env('allowRoutes');
        if(!$allowRoutes){
        $result = $model->getAdminCustomer($dataPost);

        }else{
            $result = $model->getAdminCustomerEvents($dataPost);

        }
        return Response::json(
            $result
        );
    }
    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new OrderPaymentsManager();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost =Request::all();
        $model = new  OrderPaymentsManager();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public function deliverOrder()
    {

        $attributesPost =Request::all();
        $model = new  OrderPaymentsManager();
        $result = $model->deliverOrder($attributesPost);
        return Response::json($result);
    }

    public function changeStateBankOrder()
    {

        $attributesPost = Request::all();
        $model = new  OrderPaymentsManager();
        $result = $model->changeStateBankOrder($attributesPost);
        return Response::json($result);
    }
}
