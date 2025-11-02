<?php

namespace App\Http\Controllers\Api;

use App\Processes\OrderProcess;
use App\Transformers\OrderTransformer;
use App\Validators\OrderValidator;

use Illuminate\Support\Facades\Request;
/**
 * Class ProductController
 * @package App\Http\Controllers\Api
 */
class OrderController extends ApiBaseController
{
    /**
     * @var OrderProcess
     */
    private $orderProcess;

    /**
     * @var OrderTransformer
     */
    private $orderTransformer;

    /**
     * @var OrderValidator
     */
    private $orderValidator;

    /**
     * OrderController constructor.
     * @param OrderProcess $orderProcess
     * @param OrderTransformer $orderTransformer
     * @param OrderValidator $orderValidator
     */
    public function __construct(OrderProcess $orderProcess, OrderTransformer $orderTransformer, OrderValidator $orderValidator)
    {
        $this->orderProcess = $orderProcess;
        $this->orderTransformer = $orderTransformer;
        $this->orderValidator = $orderValidator;
    }

    public function create()
    {
        $data = Request::all();
        $order = $this->orderProcess->createOrder($data);
        return $this->response->item($order, $this->orderTransformer);
    }

    public function changeStatus($order_id, $status_id)
    {
        $data = ['order_id' => $order_id, 'status_id' => $status_id];
        $order = $this->orderProcess->changeStatus($data);
        return $this->response->array(['message' => "El estado de gestión de la orden '{$order_id}' fue cambiada correctamente"]);
    }

    public function cancel($order_id)
    {
        $data = Request::all();
        $data['order_id'] = $order_id;
        $this->orderProcess->cancelOrder($data);
        return $this->response->array(['message' => 'La orden fue cancelada']);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $order_id['order_id'] = $id;
        $order_data = $this->orderProcess->showOrder($order_id);
        return $this->response->array([
            'status' => 'success',
            'data' => $this->orderTransformer->transform($order_data)
        ]);
    }
    /**
     * @param $customer_id
     * @return mixed
     */
    public function getOrdersByCustomerId($customer_uid)
    {
        $customer['customer_uid'] = $customer_uid;
        $order_data = $this->orderProcess->getOrdersByCustomerId($customer);
        return $this->response->array([
            'status' => 'success',
            'data' => $this->orderTransformer->transformCollection($order_data)
        ]);
    }
}
