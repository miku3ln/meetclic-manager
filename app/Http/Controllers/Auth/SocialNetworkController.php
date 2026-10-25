<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Utils\UtilUser;
use Symfony\Component\Console\Input\Input;
use Google\Client as GoogleClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class SocialNetworkController extends Controller
{
    use AuthenticatesUsers;


    public function handleFacebookCallback(Request $request)
    {
        $providerName = 'facebook';

        $providerSet = UtilUser::PROVIDER_FACEBOOK;
        $typeSave = UtilUser::TYPE_SAVE_CUSTOMER_FACEBOOK;
        $provider = null;
        if (Input::has('code')) {
            /*       session()->put('state', Input::has('state'));
                   session()->put('code', Input::has('code'));*/
            $provider = Socialite::driver($providerName)->stateless()->user();

        } else {
            $provider = Socialite::driver($providerName)->user();
        }


        DB::beginTransaction();
        try {

            $create = [];
            $user_id = $provider->getId();
            $name = $provider->getName();
            $email = $provider->getEmail();
            $username = $provider->getNickname();
            $avatar = $provider->getAvatar();
            $provider_id = $user_id;
            $create['name'] = $name;
            $create['username'] = $username;
            $create['status'] = 'ACTIVE';
            $create['provider'] = $providerSet;
            $create['user_id'] = $user_id;
            $create['avatar'] = $avatar;

            $create['email'] = $email;
            $create['provider_id'] = $provider_id;
            $password = Hash::make(trim($user_id));
            $create['password'] = $password;
            $managerSave = new UtilUser();
            $result = $managerSave->managerUserProvider(array(
                'typeSave' => $typeSave,
                'data' => $create
            ));
            $success = $result['success'];
            if (!$success) {
                DB::rollBack();
                return $this->sendFailedResponse($result['msg']);

            } else {
                DB::commit();
                $userCurrent = $result['data']['user'];
                $this->initSession($userCurrent, $request);
                return $this->sendSuccessResponse(1);
            }
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

    }

    public function handleGoogleCallback(Request $request)
    {
        $providerName = 'google';
        $providerSet = UtilUser::PROVIDER_GOOGLE;
        $typeSave = UtilUser::TYPE_SAVE_CUSTOMER_GOOGLE;
        $provider = null;

        if (Input::has('code')) {
            /*  session()->put('state', Input::has('state'));
              session()->put('code', Input::has('code'));*/
            $provider = Socialite::driver($providerName)->stateless()->user();
        } else {
            $provider = Socialite::driver($providerName)->user();
        }

        DB::beginTransaction();
        try {

            $create = [];
            $user_id = $provider->getId();
            $name = $provider->getName();
            $email = $provider->getEmail();
            $username = $provider->getNickname();
            $avatar = $provider->getAvatar();
            $provider_id = $user_id;
            $create['name'] = $name;
            $create['username'] = $username;
            $create['status'] = 'ACTIVE';
            $create['provider'] = $providerSet;
            $create['user_id'] = $user_id;
            $create['email'] = $email;
            $create['avatar'] = $avatar;


            $create['provider_id'] = $provider_id;
            $password = Hash::make(trim($user_id));
            $create['password'] = $password;
            $managerSave = new UtilUser();
            $result = $managerSave->managerUserProvider(array(
                'typeSave' => $typeSave,
                'data' => $create
            ));
            $success = $result['success'];
            if (!$success) {
                DB::rollBack();

                return $this->sendFailedResponse($result['msg']);

            } else {
                DB::commit();
                $userCurrent = $result['data']['user'];
                $this->initSession($userCurrent, $request);

                return $this->sendSuccessResponse(1);
            }
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

    }


    protected function initSession($user, Request $request)
    {

        $this->guard()->login($user);

        $request->session()->regenerate();

    }


    public function verifyGoogleModalCredential(Request $request)
    {
        $validated = $request->validate([
            'credential' => ['required', 'string', 'max:8192'],
        ]);

        $clientId = config('services.google_modal_register.client_id');

        if (empty($clientId)) {
            return response()->json([
                'success' => false,
                'msg' => 'Google no está configurado.',
            ], 500);
        }

        try {
            $client = new GoogleClient([
                'client_id' => $clientId,
            ]);

            $payload = $client->verifyIdToken(
                $validated['credential']
            );

            if (
                !is_array($payload) ||
                empty($payload['sub']) ||
                empty($payload['email']) ||
                ($payload['email_verified'] ?? false) !== true
            ) {
                throw ValidationException::withMessages([
                    'credential' => 'La identidad de Google no es válida.',
                ]);
            }

            // Identidad comprobada por Google.
            // En la siguiente etapa llamaremos a
            // UtilUser::managerUserProvider() y a initSession().

            return response()->json([
                'success' => true,
                'msg' => 'Identidad de Google verificada.',
            ]);

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'msg' => 'No se pudo verificar la identidad de Google.',
            ], 401);
        }
    }

    /**
     * Authenticate a user through Google Identity Services.
     *
     * Receives a Google ID token from the frontend,
     * verifies it, creates or retrieves the user,
     * and initializes the Laravel session.
     */

    public function handleGoogleModal(Request $request): JsonResponse
    {
        $step = 'VALIDATION';

        try {
            // ==========================================
            // 1. VALIDATE REQUEST
            // ==========================================

            $validator = Validator::make($request->all(), [
                'credential' => ['required', 'string', 'max:8192'],
            ]);

            if ($validator->fails()) {
                return $this->googleModalError(
                    'VALIDATION_FAILED',
                    $step,
                    'No se recibió una credencial válida.',
                    422,
                    ['credential' => $validator->errors()->first('credential')]
                );
            }

            // ==========================================
            // 2. GOOGLE CONFIGURATION
            // ==========================================

            $step = 'GOOGLE_CONFIGURATION';

            $clientId = config(
                'services.google_modal_register.client_id'
            );

            if (empty($clientId)) {
                return $this->googleModalError(
                    'GOOGLE_NOT_CONFIGURED',
                    $step,
                    'Google no está configurado correctamente.',
                    500
                );
            }

            // ==========================================
            // 3. VERIFY GOOGLE CREDENTIAL
            // ==========================================

            $step = 'GOOGLE_VERIFICATION';

            $googleClient = new GoogleClient([
                'client_id' => $clientId,
            ]);

            try {
                $payload = $googleClient->verifyIdToken(
                    $validator->validated()['credential']
                );
            } catch (\Throwable $exception) {
                $this->logGoogleModalException($exception, $step);

                return $this->googleModalError(
                    'GOOGLE_VERIFICATION_FAILED',
                    $step,
                    'No se pudo verificar la autenticación con Google.',
                    401
                );
            }

            if (!is_array($payload)) {
                return $this->googleModalError(
                    'INVALID_GOOGLE_TOKEN',
                    $step,
                    'La credencial de Google es inválida o expiró.',
                    401
                );
            }

            if (
                empty($payload['sub']) ||
                empty($payload['email']) ||
                ($payload['email_verified'] ?? false) !== true
            ) {
                return $this->googleModalError(
                    'INVALID_GOOGLE_PROFILE',
                    $step,
                    'No se pudo verificar la identidad o el correo electrónico.',
                    401
                );
            }

            // ==========================================
            // 4. NORMALIZE USER DATA
            // ==========================================

            $step = 'USER_NORMALIZATION';

            $providerId = (string) $payload['sub'];
            $email = (string) $payload['email'];

            $create = [
                'name' => $payload['name'] ?? $email,
                'username' => null,
                'status' => 'ACTIVE',

                'provider' => UtilUser::PROVIDER_GOOGLE,

                // ID externo de Google
                'provider_id' => $providerId,

                // No guardar el SUB de Google en un INT
                'user_id' => null,

                'email' => $email,
                'email_verified_at' => now(),
                'avatar' => $payload['picture'] ?? null,

                // Contraseña aleatoria para cuentas sociales nuevas
                'password' => Hash::make(Str::random(64)),
            ];

            // ==========================================
            // 5. FIND OR CREATE USER
            // ==========================================

            $step = 'USER_REGISTRATION';

            $userCurrent = DB::transaction(function () use (
                $create,
                $providerId,
                $email,
                &$step
            ) {
                // Look up an existing Google identity first.
                $existingGoogleUser = User::query()
                    ->where('provider', UtilUser::PROVIDER_GOOGLE)
                    ->where('provider_id', $providerId)
                    ->first();

                if (!$existingGoogleUser) {
                    // Never attach Google automatically to
                    // another account solely by matching email.
                    $existingEmailUser = User::query()
                        ->where('email', $email)
                        ->first();

                    if ($existingEmailUser) {
                        throw new \DomainException(
                            'EMAIL_ALREADY_REGISTERED'
                        );
                    }
                }

                // ======================================
                // USER PROVIDER MANAGER
                // ======================================

                $step = 'USER_PROVIDER_MANAGER';

                $managerSave = new UtilUser();

                $result = $managerSave->managerUserProvider([
                    'typeSave' => UtilUser::TYPE_SAVE_CUSTOMER_GOOGLE,
                    'data' => $create,
                ]);

                if (!($result['success'] ?? false)) {
                    $typeError = $result['data']['errors']['typeError'] ?? null;

                    $errorCode = match ($typeError) {
                        1 => 'USER_REGISTRATION_FAILED',
                        2 => 'ROLE_ASSIGNMENT_FAILED',
                        default => 'USER_PROVIDER_FAILED',
                    };

                    Log::warning('Google user manager rejected login', [
                        'step' => $step,
                        'error_code' => $errorCode,
                        'manager_message' => $result['msg'] ?? null,
                    ]);

                    throw new \DomainException($errorCode);
                }

                $user = $result['data']['user'] ?? null;

                if (!$user instanceof User) {
                    throw new \DomainException(
                        'USER_NOT_RETURNED'
                    );
                }

                // ======================================
                // ACCOUNT STATUS
                // ======================================

                $step = 'ACCOUNT_STATUS';

                if ($user->status !== 'ACTIVE') {
                    throw new \DomainException(
                        'ACCOUNT_INACTIVE'
                    );
                }

                return $user;
            });

            // ==========================================
            // 6. INITIALIZE SESSION
            // ==========================================

            $step = 'SESSION_INITIALIZATION';

            $this->initSession($userCurrent, $request);

            $request->session()->regenerate();

            // ==========================================
            // 7. SUCCESS RESPONSE
            // ==========================================

            return response()->json([
                'success' => true,
                'msg' => 'Inicio de sesión correcto.',
                'data' => [
                    'user' => [
                        'id' => $userCurrent->id,
                        'name' => $userCurrent->name,
                    ],
                    'provider' => 'google',
                ],
            ], 200);

        } catch (\DomainException $exception) {

            $messages = [
                'EMAIL_ALREADY_REGISTERED' =>
                    'Este correo ya pertenece a otra cuenta. Inicia sesión para vincular Google.',

                'USER_REGISTRATION_FAILED' =>
                    'No se pudo registrar el usuario de Google.',

                'ROLE_ASSIGNMENT_FAILED' =>
                    'No se pudo asignar el rol del usuario.',

                'USER_PROVIDER_FAILED' =>
                    'No se pudo gestionar la cuenta de Google.',

                'USER_NOT_RETURNED' =>
                    'No se pudo recuperar la cuenta registrada.',

                'ACCOUNT_INACTIVE' =>
                    'Esta cuenta se encuentra inactiva.',
            ];

            $code = $exception->getMessage();

            $status = match ($code) {
                'EMAIL_ALREADY_REGISTERED' => 409,
                'ACCOUNT_INACTIVE' => 403,
                default => 422,
            };

            return $this->googleModalError(
                $code,
                $step,
                $messages[$code] ?? 'No se pudo completar la autenticación.',
                $status
            );

        } catch (\Throwable $exception) {

            $this->logGoogleModalException($exception, $step);

            return $this->googleModalError(
                'GOOGLE_LOGIN_INTERNAL_ERROR',
                $step,
                'No se pudo completar el inicio de sesión.'.$exception->getMessage(),
                500
            );
        }
    }
    private function googleModalError(
        string $code,
        string $step,
        string $message,
        int $status = 500,
        array $details = []
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'msg' => $message,
            'error' => [
                'code' => $code,
                'step' => $step,
                'details' => $details,
            ],
        ], $status);
    }
    private function logGoogleModalException(
        \Throwable $exception,
        string $step
    ): void {
        Log::error('Google modal authentication failed', [
            'step' => $step,
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
}
}
