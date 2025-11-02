<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Models\MaritimeOperationsManagement\MaritimeDepartures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Services\BusinessAppService;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

use App\Utils\Meetclic\UtilApis;

class CustomerAppController extends Controller
{
    protected $serviceBusiness;

    public function __construct(BusinessAppService $service)
    {
        $this->serviceUser = $service;
    }


    public function consultarCedula(Request $request)
    {
        $cedula = $request->query('cedula');

        if (!$cedula) {
            return response()->json(['error' => 'Falta parámetro: cedula'], 400);
        }
        try {
            $client = new Client([
                'base_uri' => 'https://www.ecuadorlegalonline.com',
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0',
                ],
            ]);
            $cookieJar = new CookieJar();
            $client->get('/consultas/registro-civil/consultar-el-nombre-con-el-numero-de-cedula/', [
                'cookies' => $cookieJar
            ]);

            // Paso 2: Enviar el POST al endpoint con el formulario
            $response = $client->post('/modulo/consultar-cedula.php', [
                'form_params' => [
                    'name' => $cedula,
                    'tipo' => 'I',
                ],
                'headers' => [
                    'Referer' => 'https://www.ecuadorlegalonline.com/consultas/registro-civil/consultar-el-nombre-con-el-numero-de-cedula/',
                ],
                'cookies' => $cookieJar
            ]);

            $body = (string)$response->getBody();
            $dataCurrent = UtilApis::parseCedulaHtml($body);
            $message= 'Información retornada';
            $success=false;
            if($body==""){
                $success=false;
                $message= 'No existe este ciudadano.!';
            }else{
                $success=true;
            }
            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $dataCurrent
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function saveCustomerApi()
    {

        $attributesPost = \Illuminate\Support\Facades\Request::all();
        $model = new Customer();
        $result = $model->saveCustomerApi(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }
    public function saveMaritimeDepartureApi(Request $request)
    {
        $payloadJsonString = $request->input('data');

        $model = new MaritimeDepartures();
        $result = $model->saveMaritimeDepartureApi($payloadJsonString);
        return Response::json($result);
    }
}
