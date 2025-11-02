<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\UtilModelManager;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiLoginController extends Controller
{

    use UtilModelManager;

    public function loginRest(Request $request)
    {
        $userData = $request->all();

        $payLoad = json_decode(request()->getContent(), true);
        $userData = $payLoad['params'];
        $success = false;
        $data = [];
        $rules = [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
        $validateData = $this->validateModel([
            'rules' => $rules,
            'inputs' => $userData
        ]);

        $success = $validateData['success'];
        if (!$success) {
            $msg = 'Errors';
            $errors = $validateData['errorsFields'];
            $data['msg'] = $msg;
            $data['errors'] = $errors;
            $errorsFields = [];
        } else {
//create
            $success = true;
            $loginParams = Auth::attempt($userData);
            if ($loginParams) {
                $user = Auth::user();
                $accessToken = 'none';
                if (env('AUTH_BY_TOKEN')) {
                } else {
                    $accessToken = $user->createToken('restApiToken')->accessToken;//save to oauth_access_tokens
                    $userData['api_token'] = $accessToken;
                    $data['accessToken'] = $accessToken;
                    $model = $user;
                    $model->api_token = $accessToken;
                    $success = $model->save();
                }
                $data['user'] = $user;


            } else {

                $data['msg'] = 'Usuario o Contraseña erronea.';
            }
        }

        $result = [
            'success' => $success,
            'data' => $data,

        ];

        return Response::json(
            $result
        );

    }

    public function registerRest(Request $request)
    {
        $userData = $request->all();
        $payLoad = json_decode(request()->getContent(), true);
        $userData = $payLoad['params'];
        $success = false;
        $data = [];
        $rules = [
            "name" => 'required',
            "username" => 'required|unique:users,username',
            "email" => 'required|unique:users,email',
            "password" => 'required',
        ];

        $validateData = $this->validateModel([
            'rules' => $rules,
            'inputs' => $userData
        ]);
        $success = $validateData['success'];

        if (!$success) {
            $msg = 'Errors';
            $errors = $validateData['errorsFields'];
            $data['msg'] = $msg;
            $data['errors'] = $errors;

        } else {
//create
            $userData['password'] = Hash::make($userData['password']);
            $user = User::create($userData);
            $accessToken = 'none';
            if (env('AUTH_BY_TOKEN')) {

            } else {

                $accessToken = $user->createToken('restApiToken')->accessToken;//save to oauth_access_tokens
                $userData['api_token'] = $accessToken;
                $model = $user;
                $model->fill($userData);
                $success = $model->save();
            }
            $data['user'] = $user;
            $data['accessToken'] = $accessToken;

        }
        $result = [
            'success' => $success,
            'data' => $data,
            '$payLoad' => $payLoad['params']

        ];
        return Response::json(
            $result
        );
    }

    public function viewDataRest(Request $request)
    {
        $userData = $request->all();
        $success = true;
        $data = [];

        $data['user'] = $userData;
        $data['users'] = User::orderBy('name', 'desc')
            ->get();
        $result = [
            'success' => $success,
            'data' => $data,

        ];
        return Response::json(
            $result
        );

    }

    public function getEmailUniqueCheckout()
    {

        $inputPost = \Illuminate\Support\Facades\Request::all();

        $userData = $inputPost;
        $user_id = isset($inputPost['id']) ? $inputPost['id'] : null;
        $inputsValidations = $user_id ? array(
            "email" => $inputPost['email'],
            "id" => $inputPost['id'],

        ) : array(
            "email" => $inputPost['email']
        );

        $rules = [
            "email" => 'required|unique:users,email',
        ];

        $validateData = $this->validateModel([
            'rules' => $rules,
            'inputs' => $inputsValidations
        ]);
        $result = $validateData['success'];
        return Response::json($result);
    }

    public function loginMeetclic(Request $request)
    {
        try {
            $payload = $request->json()->all();
            $userData = $payload['params'] ?? [];

            // ✅ Validar inputs
            $validator = Validator::make($userData, [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'success' => false,
                    'message' => 'Campos inválidos.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // ✅ Intentar autenticación
            $allowLogin = Auth::attempt([
                'email' => $userData['email'],
                'password' => $userData['password']
            ]);

            if ($allowLogin) {
                $user = Auth::user();

                // $accessToken = $user->createToken('restApiToken')->accessToken;

                $accessToken = $user->createToken('google_token');
                return Response::json([
                    'success' => true,
                    'message' => 'Inicio de sesión correcto.',
                    'user' => $user,
                    'access_token' => $accessToken,
                ]);
            }
            return Response::json([
                'success' => false,
                'message' => 'Usuario o contraseña incorrectos.',
            ], 401);

        } catch (\Throwable $e) {

            // ✅ Retornar respuesta controlada
            return Response::json([
                'success' => false,
                'message' => 'Error interno del servidor.',
                'error' => $e->getMessage(), // ⚠️ Omitir en producción si quieres ocultar el detalle técnico
            ], 500);
        }
    }
}
