<?php

namespace App\Http\Controllers\Api;

use App\Processes\DeliveryProcess;
use App\Validators\DeliveryValidator;
use Illuminate\Support\Facades\Request;

/**
 * Class DeliveryController
 * @package App\Http\Controllers\Api
 */
class DeliveryController extends ApiBaseController
{
    /**
     * @var DeliveryProcess
     */
    private $deliveryProcess;

    /**
     * @var DeliveryValidator
     */
    private $deliveryValidator;

    /**
     * DeliveryController constructor.
     * @param DeliveryProcess $deliveryProcess
     * @param DeliveryValidator $deliveryValidator
     */
    public function __construct(DeliveryProcess $deliveryProcess, DeliveryValidator $deliveryValidator)
    {
        $this->deliveryProcess = $deliveryProcess;
        $this->deliveryValidator = $deliveryValidator;
    }

    public function assignMotorized()
    {
        $data = Request::all();

        $this->deliveryProcess->assignMotorized($data);
        return $this->response->array(['message' => "El vehículo ha sido asignado correctamente"]);
    }

    public function unassignMotorized()
    {
        $data = Request::all();
        $order = $this->deliveryProcess->unassignMotorized($data);
        return $this->response->array(['message' => "El vehículo ha sido desasignado correctamente"]);
    }
    public function assignDeliveryOrder()
    {
        $data = Request::all();
        $this->deliveryProcess->assignDeliveryOrder($data);
        return $this->response->array(['message' => "La orden se fue asignada al chofer correctamente"]);
    }

    public function loginTokenDeliveryMen()
    {
        try {
            $input = Request::all();
            $process = $this->deliveryProcess->loginTokenDeliveryMen($input);
            if (!isset($process['status_code'])) {
                return $this->response->array([
                    'data' => $process
                ])->setStatusCode(200);
            }
            return $this->response->array($process)->setStatusCode($process['status_code']);
        } catch (\Exception $e) {
            return $this->response->array(
                ['status_code' => 400, 'message' => $e->getMessage()]
            )->setStatusCode(400);
        }

    }
}
