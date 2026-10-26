<?php

namespace App\Http\Controllers\Api;
use App;
use App\Mail\Gamification\TaskRewardMail;
use App\Models\Customer;
use App\Models\MaritimeOperationsManagement\MaritimeDepartures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Services\BusinessAppService;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

use App\Utils\Meetclic\UtilApis;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Throwable;

class CustomerAppController extends Controller
{
    protected $serviceBusiness;

    public function __construct(BusinessAppService $service)
    {
        $this->serviceUser = $service;
    }


    public function sendReward()
    {
        try {


            $emailSend = "kalexmiguelalba@gmail.com";

            $mail = new TaskRewardMail(
                userName: "Alex Miguel Alba Ayala",
                taskName: "Registro exitoso",
                taskDescription: "Gracias por registrarte en Yapita. Has recibido tus primeros puntos de bienvenida.",
                taskImage: asset('public/uploads/yapita/rewards/1/register.png'),
                points: 50,
                logoUrl: asset('public/uploads/frontend/templateBySource/1750454099_logo-one'),
                walletUrl: route('profileAccount', 'es')
            );

            // ==========================================
            // 3. ENVIAR CORREO
            // ==========================================

            Mail::to($emailSend)->send($mail);

            // ==========================================
            // 4. RESPUESTA EXITOSA
            // ==========================================

            return response()->json([
                "success" => true,
                "message" => "Notificación de recompensa enviada correctamente.",
                "data" => [
                    "email" => $emailSend,
                    "status" => "SENT"
                ]
            ], 200);

        } catch (TransportExceptionInterface $e) {

            // ==========================================
            // 5. ERROR SMTP
            // ==========================================

            $errorMessage = $e->getMessage();

            $errorCode = "SMTP_ERROR";

            $message = "No se pudo enviar la notificación de recompensa.";

            // Cuenta SMTP bloqueada
            if (
                str_contains($errorMessage, '554') &&
                str_contains($errorMessage, 'Outbound sending is disabled')
            ) {

                $errorCode = "SMTP_ACCOUNT_BLOCKED";

                $message = "La cuenta de correo tiene deshabilitado el envío de mensajes.";

            }

            // Error de autenticación
            elseif (
                str_contains($errorMessage, '535') ||
                str_contains($errorMessage, 'Authentication failed')
            ) {

                $errorCode = "SMTP_AUTH_ERROR";

                $message = "Error de autenticación del servidor de correo.";

            }

            // Error de conexión
            elseif (
                str_contains($errorMessage, 'Connection could not be established')
            ) {

                $errorCode = "SMTP_CONNECTION_ERROR";

                $message = "No se pudo establecer conexión con el servidor de correo.";

            }

            return response()->json([
                "success" => false,
                "message" => $message,
                "error_code" => $errorCode,
                "data" => [
                    "email" => $emailSend,
                    "status" => "FAILED"
                ]
            ], 503);

        } catch (Throwable $e) {


            return response()->json([
                "success" => false,
                "message" => "Ocurrió un error al procesar la notificación de recompensa.",
                "error_code" => "REWARD_EMAIL_ERROR",
                "data" => [
                    "email" => $emailSend,
                    "status" => "FAILED"
                ]
            ], 500);
        }
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
    public function getDictionaryByLanguage()//CMS-TEMPLATE-MENU-CONTROLLER---KICHWA-CASTILIAN
    {

        $dataPost = \Illuminate\Support\Facades\Request::all();
        $model = new App\Models\Dictionary\DictionaryByWords();
        $result = $model->getDictionaryData($dataPost);

        return Response::json(
            $result
        );
    }
}
