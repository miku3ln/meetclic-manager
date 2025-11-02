<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Http\Request;

use App\Utils\UtilUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Services\UserService;

class MeetclicController extends Controller
{
    protected $serviceUser;

    public function __construct(UserService $service)
    {
        $this->serviceUser = $service;
    }

    public function login(Request $request)
    {
        try {
            $type = -1;
            $payload = $request->json()->all();
            $userData = $payload;
            $validator = Validator::make($userData, [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            if ($validator->fails()) {
                return Response::json([
                    "type" => $type,
                    'success' => false,
                    "data" => ["errors" => $validator->errors()],
                    'message' => 'Campos inválidos.',
                ]);
            }
            $allowLogin = Auth::attempt([
                'email' => $userData['email'],
                'password' => $userData['password']
            ]);

            if ($allowLogin) {
                $user = Auth::user();
                if (is_null($user->email_verified_at)) {
                    Auth::logout(); // cerramos sesión si no está verificado
                    return Response::json([
                        "type" => $type,
                        'success' => false,
                        "data" => [],
                        'message' => 'Debes verificar tu correo electrónico antes de iniciar sesión.',
                    ]);
                }
                if (!$user->is_active) {
                    Auth::logout();
                    return Response::json([
                        "type" => $type,
                        'success' => false,
                        "data" => [],
                        'message' => 'Tu cuenta aún no ha sido activada.',
                    ]);
                }

                $accessToken = Str::uuid()->toString();
                $user->api_token = $accessToken;
                $user->save();
                $user_id = $user->id;
                $userData = $this->serviceUser->getUserInfoForFlutter($user_id);
                $gamificationLogData = $this->serviceUser->getGamificationLog($user_id);
                $data['userData'] = $userData;
                $data['userData']["access_token"] = $accessToken;
                $data['userData']["gamificationLogData"] = $gamificationLogData;


                return Response::json([
                    "type" => $type,
                    'success' => true,
                    'message' => 'Inicio de sesión correcto.',
                    'data' => $data,
                ]);
            } else {
                return Response::json([
                    "type" => $type,
                    'success' => false,
                    "data" => [],
                    'message' => 'Usuario o contraseña incorrectos.',
                ]);
            }


        } catch (\Throwable $e) {
            return Response::json([
                "type" => $type,
                'success' => false,
                "data" => [
                    "errors" => $e->getMessage()
                ],
                'message' => 'Error interno del servidor.',
            ], 500);
        }
    }


    public function register(Request $request)
    {
        try {

            $payload = $request->json()->all();
            $userData = $payload;
            $accessToken = Str::uuid()->toString();
            $userData["identification_document"] = $accessToken;
            $userData["people_type_identification_id"] = 3;
            $userData["birthdate"] = "1987-07-24";
            $userData["gender"] = 1;
            $type = -1;
            // ✅ Crear usuario
            $user = null;
            $managerSave = new UtilUser();

            $resultSave = $managerSave->saveUserApp(array(
                'typeSave' => UtilUser::TYPE_SAVE_CUSTOMER_APP,
                'request' => $userData
            ));
            if ($resultSave["success"]) {
                $user = $resultSave["data"]["User"];
                $user_id = $user->id;
                $userData = $this->serviceUser->getUserInfoForFlutter($user_id);
                $user->api_token = $accessToken;
                $user->save();
                if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
                    $user->sendEmailVerificationNotification();
                }
                $resultData = json_encode([
                    'userData' => $userData,
                    'access_token' => $accessToken,
                ]);
                $type = 1;
                return Response::json([
                    'type' => $type,
                    'success' => true,
                    'message' => 'Usuario registrado correctamente , revise su correo para activar su correo.',
                    'data' => $resultData,
                ]);
            } else {
                $resultData = json_encode($resultSave["data"]);
                $type = 2;
                return Response::json([
                    'type' => $type,
                    'success' => false,
                    'message' => $resultSave["message"],
                    'data' => $resultData,
                ]);
            }


        } catch (\Throwable $e) {
            $type = 3;
            return Response::json([
                'type' => $type,
                'success' => false,
                'message' => 'Error interno del servidor.',
                'error' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function resendVerificationByEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Correo inválido.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Este correo ya fue verificado.',
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => 'Correo de verificación reenviado correctamente.',
        ]);
    }
}
