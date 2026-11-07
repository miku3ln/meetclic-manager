<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\TaskRewardInputDTO;
use App\Infrastructure\Cms\Application\Gamification\Wallet\UseCases\RewardUserByTaskUseCase;
use App\Mail\Gamification\TaskRewardMail;
use App\Mail\RewardByBusiness\PrizeWinnerMail;
use App\Models\Events\EventBusinessPrize;
use App\Models\Gamification\GamificationByProcessTracking;
use App\Models\User;
use App\Utils\TrackingUtil;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Utils\UtilUser;
use Google\Client as GoogleClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Throwable;

class SocialNetworkController extends Controller
{
    use AuthenticatesUsers;

    public function handleServerModal(Request $request): JsonResponse
    {
        $step = 'VALIDATION';

        try {

            // ==========================================
            // 1. VALIDATE REQUEST
            // ==========================================

            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:128',
                ],
            ]);

            if ($validator->fails()) {

                return $this->googleModalError(
                    'VALIDATION_FAILED',
                    $step,
                    'Los datos ingresados no son válidos.',
                    422,
                    $validator->errors()->toArray()
                );
            }

            // ==========================================
            // 2. NORMALIZE DATA
            // ==========================================

            $step = 'USER_NORMALIZATION';

            $email = strtolower(trim($request->input('email')));
            $password = $request->input('password');

            // Nombre provisional
            $name = explode('@', $email)[0];

            // ==========================================
            // 3. VERIFY EXISTING USER
            // ==========================================

            $step = 'USER_EXISTENCE_VALIDATION';

            $existingUser = User::query()
                ->where('email', $email)
                ->exists();

            if ($existingUser) {

                throw new \DomainException(
                    'EMAIL_ALREADY_REGISTERED'
                );
            }

            // ==========================================
            // 4. PREPARE USER
            // ==========================================

            $step = 'USER_PREPARATION';

            $create = [
                'name' => $name,
                'username' => $email,
                'status' => User::STATUS_ACTIVE,

                'provider' => User::PROVIDER_OWNER_SERVER,
                'provider_id' => null,
                'user_id' => null,

                'email' => $email,
                'avatar' => null,

                // Contraseña recibida en texto plano
                // y almacenada mediante hash.
                'password' => Hash::make($password),
            ];

            // ==========================================
            // 5. REGISTER USER
            // ==========================================

            $step = 'USER_REGISTRATION';

            $userManager = DB::transaction(function () use (
                $create,
                &$step
            ) {

                $step = 'USER_PROVIDER_MANAGER';

                $managerSave = new UtilUser();

                $result = $managerSave->managerUserProvider([
                    'typeSave' => UtilUser::TYPE_SAVE_NORMAL,
                    'data' => $create,
                ]);

                if (!($result['success'] ?? false)) {

                    $typeError = $result['data']['errors']['typeError']
                        ?? null;

                    $errorCode = match ($typeError) {
                        1 => 'USER_REGISTRATION_FAILED',
                        2 => 'ROLE_ASSIGNMENT_FAILED',
                        default => 'USER_PROVIDER_FAILED',
                    };

                    throw new \DomainException($errorCode);
                }

                $user = $result['data']['user'] ?? null;

                $userManager = $result['data']['userManager'] ?? null;

                if (!$user instanceof User) {

                    throw new \DomainException(
                        'USER_NOT_RETURNED'
                    );
                }

                // ======================================
                // ACCOUNT STATUS
                // ======================================

                $step = 'ACCOUNT_STATUS';

                if ($user->status !== User::STATUS_ACTIVE) {

                    throw new \DomainException(
                        'ACCOUNT_INACTIVE'
                    );
                }

                return $userManager;
            });

            // ==========================================
            // 6. INITIALIZE SESSION
            // ==========================================

            $step = 'SESSION_INITIALIZATION';

            $userCurrent = $userManager['user'];

            $isCreate = $userManager['isCreate'];

            $this->initSession($userCurrent, $request);

            // ==========================================
            // 7. GAMIFICATION
            // ==========================================

            $step = 'GAMIFICATION';

            $gamification = $this->creditRegisterUser(
                $userCurrent,
                $isCreate,
                UtilUser::PROVIDER_OWNER_SERVER
            );

            // ==========================================
            // 8. SUCCESS RESPONSE
            // ==========================================

            return response()->json([
                'success' => true,
                'msg' => 'Usuario registrado correctamente.',
                'data' => [
                    'user' => [
                        'id' => $userCurrent->id,
                        'name' => $userCurrent->name,
                        'isCreate' => $isCreate,
                    ],
                    'gamification' => $gamification,
                    'provider' => User::PROVIDER_OWNER_SERVER,
                ],
            ], 200);

        } catch (\DomainException $exception) {

            // ==========================================
            // DOMAIN ERRORS
            // ==========================================

            $messages = [
                'EMAIL_ALREADY_REGISTERED' =>
                    'Este correo electrónico ya se encuentra registrado.',

                'USER_REGISTRATION_FAILED' =>
                    'No se pudo registrar el usuario.',

                'ROLE_ASSIGNMENT_FAILED' =>
                    'No se pudo asignar el rol del usuario.',

                'USER_PROVIDER_FAILED' =>
                    'No se pudo gestionar la cuenta.',

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
                $messages[$code] ?? 'No se pudo completar el registro.',
                $status
            );

        } catch (\Throwable $exception) {

            // ==========================================
            // INTERNAL ERRORS
            // ==========================================

            $this->logGoogleModalException(
                $exception,
                $step
            );

            return $this->googleModalError(
                'SERVER_REGISTRATION_INTERNAL_ERROR',
                $step,
                'No se pudo completar el registro.',
                500
            );
        }
    }

    public function handleSendRewardEmailUser(
        Request $request
    ): JsonResponse
    {
        $modelRewards= new EventBusinessPrize();
        $users=   $modelRewards-> getUsersEvent(1);

        $rewards=   $modelRewards-> getPrizesByEventId(1);

        // ==========================================
        // 1. VALIDAR DATOS RECIBIDOS
        // ==========================================


// ==========================================
// 1. DATOS HARDCODEADOS PARA PRUEBAS
// ==========================================
       $reward= $rewards[0];
       $addressBusiness=$reward["business_street_1"]." y ".$reward["business_street_2"];
        $latitude = $reward["business_street_lat"];
$longitude =$reward["business_street_lng"];

$businessMapsUrl = "https://www.google.com/maps/search/?api=1&query={$latitude}%2C{$longitude}";
        $data = [
            // GANADOR
            'email' => 'empresasistemaxytab@gmail.com',
            'userName' => 'Alex Miguel Alba Ayala',
            // PREMIO
            'prizeName' => $reward['name'],
            'prizeDescription' => $reward['description'],
            'prizeImage' =>  $reward['source'],
            'prizeCode' => $reward['id'],
            'redeemUntil' => '30 de noviembre de 2026',
            // EMPRESA AUSPICIANTE
            'businessName' =>$reward["business_name"],
            'businessAddress' =>$addressBusiness,
            'businessMapsUrl' => $businessMapsUrl,
            'businessPhone' => $reward["business_phone"],

            // YAPITA
            'yapitaPhone' => '593985339457',
            // EVENTO
            'eventName' => 'Halloween Otavalo - 7.ª edición',
        ];

// ==========================================
// 2. VALIDAR DATOS HARDCODEADOS
// ==========================================

        $validator = Validator::make(
            $data,
            [
                'email' => 'required|email|max:255',
                'userName' => 'required|string|max:255',
                'prizeName' => 'required|string|max:255',
                'prizeDescription' => 'required|string',
                'prizeImage' => 'nullable|url|max:2048',
                'prizeCode' => 'required',
                'redeemUntil' => 'nullable|string|max:100',
                'businessName' => 'required|string|max:255',
                'businessAddress' => 'required|string|max:500',
                'businessMapsUrl' => 'nullable|url|max:2048',
                'businessPhone' => 'nullable|string|max:25',
                'yapitaPhone' => 'nullable|string|max:25',
                'eventName' => 'nullable|string|max:255',
            ]
        );

// ==========================================
// 3. VERIFICAR VALIDACIÓN
// ==========================================
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Los datos de prueba no son válidos.',
                'error_code' => 'VALIDATION_ERROR',
                'data' => [
                    'errors' => $validator->errors()->toArray(),
                ],
            ], 422);
        }

        $paramsTask = $data;
        unset(
            $paramsTask['email'],
            $paramsTask['userName']
        );
        $emailSend = $data['email'];
        $userName = $data['userName'];
        $paramsTask = [
            'prizeName' => $data['prizeName'],
            'prizeDescription' => $data['prizeDescription'],

            'prizeImage' => $data['prizeImage']
                ?? null,

            'prizeCode' => $data['prizeCode'],

            'redeemUntil' => $data['redeemUntil']
                ?? null,

            'businessName' => $data['businessName'],

            'businessAddress' => $data['businessAddress'],

            'businessMapsUrl' => $data['businessMapsUrl']
                ?? null,

            'businessPhone' => $data['businessPhone']
                ?? null,

            'yapitaPhone' => $data['yapitaPhone']
                ?? null,

            'eventName' => $data['eventName']
                ?? 'Sorteo Yapita',
        ];

        try {

            $result = $this->sendRewardUsers(
                $emailSend,
                $userName,
                $paramsTask
            );
            $result['users']=$users;
            $result['rewards']=$rewards;

            // ==========================================
            // 6. DEFINIR CÓDIGO HTTP
            // ==========================================

            if ($result['success'] === true) {
                return response()->json(
                    $result,
                    200
                );
            }
            $errorCode = $result['error_code']
                ?? 'REWARD_EMAIL_ERROR';

            $httpStatus = match ($errorCode) {
                'REWARD_VALIDATION_ERROR' => 422,
                'SMTP_AUTH_ERROR',
                'SMTP_ACCOUNT_BLOCKED' => 503,
                'SMTP_CONNECTION_ERROR',
                'SMTP_TEMPORARY_ERROR' => 503,
                'SMTP_RECIPIENT_REJECTED' => 422,
                'SMTP_ERROR',
                'REWARD_EMAIL_ERROR' => 500,
                default => 500,
            };

            // ==========================================
            // 7. RESPUESTA DE ERROR
            // ==========================================

            return response()->json(
                $result,
                $httpStatus
            );

        } catch (Throwable $e) {


            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado al enviar la notificación del premio.',
                'error_code' => 'INTERNAL_SERVER_ERROR',
                'smtp_code' => null,
                'data' => [
                    'email' => $emailSend,
                    'status' => 'FAILED',
                ],
            ], 500);
        }
    }

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

            $providerId = (string)$payload['sub'];
            $email = (string)$payload['email'];

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

            $userManager = DB::transaction(function () use (
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
                $userManager = $result['data']['userManager'];


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

                return $userManager;
            });

            // ==========================================
            // 6. INITIALIZE SESSION
            // ==========================================

            $step = 'SESSION_INITIALIZATION';
            $userCurrent = $userManager["user"];
            $isCreate = $userManager["isCreate"];
            $userId = $userCurrent->id;

            $this->initSession($userCurrent, $request);
            $gamification = $this->creditRegisterUser($userCurrent, $isCreate, UtilUser::PROVIDER_GOOGLE);
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
                        "isCreate" => $isCreate
                    ],
                    'gamification' => $gamification,
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
                'No se pudo completar el inicio de sesión.' . $exception->getMessage(),
                500
            );
        }
    }

    public function getGamificationProcessById(int $processId): ?array
    {
        $result = DB::table('gamification_by_process as gp')
            ->leftJoin(
                'gamification_by_points as gpt',
                'gpt.gamification_by_process_id',
                '=',
                'gp.id'
            )
            ->where('gp.id', $processId)
            ->select([
                'gp.*',
                'gpt.id as points_id',
                'gpt.gamification_by_process_id as points_process_id',
                'gpt.points as points_value',
            ])
            ->first();

        if (!$result) {
            return null;
        }

        $data = (array)$result;
        if (!empty($data['source'])) {
            $data['source'] = asset('public/' . ltrim($data['source'], '/'));
        }
        // Separar los campos de gamification_by_points
        $points = [
            'id' => $data['points_id'],
            'gamification_by_process_id' => $data['points_process_id'],
            'points' => $data['points_value'],
        ];

        // Eliminar los campos auxiliares del JOIN
        unset(
            $data['points_id'],
            $data['points_process_id'],
            $data['points_value']
        );

        return [
            'process' => $data,
            'points' => $points['id'] !== null ? $points : null,
        ];
    }


    protected function sendRewardUsers(
        $emailSend,
        $userName,
        $paramsTask
    ): array {

        // ==========================================
        // 1. VALIDAR DATOS
        // ==========================================

        $validator = Validator::make(
            [
                'email' => $emailSend,
                'user_name' => $userName,
                'params' => $paramsTask,
            ],
            [
                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],
                'user_name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'params' => [
                    'required',
                    'array',
                ],
                'params.prizeName' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'params.prizeDescription' => [
                    'required',
                    'string',
                ],
                'params.prizeImage' => [
                    'nullable',
                    'url',
                    'max:2048',
                ],
                'params.prizeCode' => [
                    'required',
                ],
                'params.businessName' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'params.businessAddress' => [
                    'required',
                    'string',
                    'max:500',
                ],
                'params.businessMapsUrl' => [
                    'nullable',
                    'url',
                    'max:2048',
                ],
                'params.businessPhone' => [
                    'nullable',
                    'string',
                    'max:25',
                ],
                'params.yapitaPhone' => [
                    'nullable',
                    'string',
                    'max:25',
                ],
                'params.eventName' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
                'params.redeemUntil' => [
                    'nullable',
                    'string',
                    'max:100',
                ],
            ]
        );

        if ($validator->fails()) {

            return [
                'success' => false,
                'message' => 'Los datos para enviar el premio no son válidos.',
                'error_code' => 'REWARD_VALIDATION_ERROR',
                'smtp_code' => null,
                'data' => [
                    'email' => $emailSend,
                    'status' => 'FAILED',
                    'errors' => $validator->errors()->toArray(),
                ],
            ];
        }

        // ==========================================
        // 2. VERIFICAR TRANSPORTE DE CORREO
        // ==========================================

        $mailer = config('mail.default');



        // ==========================================
        // 3. PREPARAR CORREO
        // ==========================================

        try {

            $mail = new PrizeWinnerMail(
                winnerName: $userName,
                winnerEmail: $emailSend,

                prizeName: $paramsTask['prizeName'],

                prizeDescription:
                $paramsTask['prizeDescription'],

                prizeImage:
                $paramsTask['prizeImage'] ?? null,

                prizeCode:
                $paramsTask['prizeCode'],

                businessName:
                $paramsTask['businessName'],

                businessAddress:
                $paramsTask['businessAddress'],

                businessMapsUrl:
                $paramsTask['businessMapsUrl'] ?? null,

                businessPhone:
                $paramsTask['businessPhone'] ?? null,

                yapitaPhone:
                $paramsTask['yapitaPhone'] ?? null,

                logoUrl:"https://meetclic.com/public/uploads/frontend/templateBySource/1750454099_logo-one.png",

                eventName:
                $paramsTask['eventName']
                ?? 'Sorteo Yapita',

                redeemUntil:
                $paramsTask['redeemUntil'] ?? null
            );


            // ==========================================
            // 5. ENVIAR CORREO
            // ==========================================

            Mail::to($emailSend)->send($mail);



            return [
                'success' => true,
                'message' => 'El transporte de correo terminó sin errores. La entrega al destinatario todavía no está confirmada.',
                'error_code' => null,
                'smtp_code' => null,
                'data' => [
                    'email' => $emailSend,
                    'winner' => $userName,
                    'prize_code' => $paramsTask['prizeCode'],
                    'mailer' => $mailer,
                    'status' => 'TRANSPORT_ACCEPTED',
                ],
            ];

        } catch (TransportExceptionInterface $e) {

            // ==========================================
            // 7. OBTENER ERROR SMTP
            // ==========================================

            $errorMessage = $e->getMessage();

            $errorLower = strtolower($errorMessage);

            $smtpCode = null;

            // ==========================================
            // 8. EXTRAER CÓDIGO SMTP
            // ==========================================

            // Solo códigos de error 4xx y 5xx.
            // No utilizar el historial getDebug()
            // para obtener el último código.

            if (preg_match(
                '/(?:code|response|replied with|returned)[^\r\n]{0,120}?\b([45]\d{2})\b/i',
                $errorMessage,
                $matches
            )) {
                $smtpCode = (int) $matches[1];
            }

            // ==========================================
            // 9. CLASIFICAR ERROR SMTP
            // ==========================================

            $errorCode = 'SMTP_ERROR';

            $message = 'No se pudo enviar el correo del premio.';

            // CUENTA BLOQUEADA
            if (
                str_contains(
                    $errorLower,
                    'outbound sending is disabled'
                )
            ) {

                $errorCode = 'SMTP_ACCOUNT_BLOCKED';

                $message = 'La cuenta SMTP tiene deshabilitado el envío de correos.';

            }

            // AUTENTICACIÓN
            elseif (
                $smtpCode === 535 ||
                str_contains(
                    $errorLower,
                    'authentication failed'
                ) ||
                str_contains(
                    $errorLower,
                    'username and password not accepted'
                )
            ) {

                $errorCode = 'SMTP_AUTH_ERROR';

                $message = 'El servidor SMTP rechazó las credenciales de autenticación.';

            }

            // DESTINATARIO RECHAZADO
            elseif (
                in_array(
                    $smtpCode,
                    [550, 551, 553],
                    true
                )
            ) {

                $errorCode = 'SMTP_RECIPIENT_REJECTED';

                $message = 'El servidor SMTP rechazó el destinatario.';

            }

            // ERROR TEMPORAL
            elseif (
                in_array(
                    $smtpCode,
                    [421, 450, 451, 452],
                    true
                )
            ) {

                $errorCode = 'SMTP_TEMPORARY_ERROR';

                $message = 'El servidor SMTP presenta un problema temporal.';

            }

            // CONEXIÓN
            elseif (
                str_contains(
                    $errorLower,
                    'connection could not be established'
                ) ||
                str_contains(
                    $errorLower,
                    'connection timed out'
                ) ||
                str_contains(
                    $errorLower,
                    'connection refused'
                )
            ) {

                $errorCode = 'SMTP_CONNECTION_ERROR';

                $message = 'No se pudo establecer conexión con el servidor SMTP.';

            }

            // SEGURIDAD SSL/TLS
            elseif (
                str_contains(
                    $errorLower,
                    'certificate'
                ) ||
                str_contains(
                    $errorLower,
                    'starttls'
                ) ||
                str_contains(
                    $errorLower,
                    'ssl operation failed'
                )
            ) {

                $errorCode = 'SMTP_TLS_ERROR';

                $message = 'Error de seguridad SSL/TLS durante la conexión SMTP.';

            }

            // ==========================================
            // 11. RESPUESTA SMTP
            // ==========================================

            $response = [
                'success' => false,
                'message' => $message,
                'error_code' => $errorCode,
                'smtp_code' => $smtpCode,
                'data' => [
                    'email' => $emailSend,
                    'status' => 'FAILED',
                ],
            ];

            // Solo mostrar detalles en desarrollo.
            if (config('app.debug')) {

                $response['debug'] = [
                    'exception' => get_class($e),
                    'message' => $errorMessage,
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];
            }

            return $response;

        } catch (Throwable $e) {


            $response = [
                'success' => false,
                'message' => 'Ocurrió un error al preparar o enviar el correo del premio.',
                'error_code' => 'REWARD_EMAIL_ERROR',
                'smtp_code' => null,
                'data' => [
                    'email' => $emailSend,
                    'status' => 'FAILED',
                ],
            ];

            if (config('app.debug')) {

                $response['debug'] = [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];
            }

            return $response;
        }
    }


    protected function sendReward($emailSend, $userName, $paramsTask)
    {
        $taskName = $paramsTask['taskName'];
        $taskDescription = $paramsTask['taskDescription'];
        $taskImage = $paramsTask['taskImage'];
        $points = $paramsTask['points'];

        try {
            $mail = new TaskRewardMail(
                userName: $userName,
                taskName: $taskName,
                taskDescription: $taskDescription,
                taskImage: $taskImage,
                points: $points,
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

            return [
                "success" => true,
                "message" => "Notificación de recompensa enviada correctamente.",
                "data" => [
                    "email" => $emailSend,
                    "status" => "SENT"
                ]
            ];

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

            } // Error de autenticación
            elseif (
                str_contains($errorMessage, '535') ||
                str_contains($errorMessage, 'Authentication failed')
            ) {

                $errorCode = "SMTP_AUTH_ERROR";

                $message = "Error de autenticación del servidor de correo.";

            } // Error de conexión
            elseif (
                str_contains($errorMessage, 'Connection could not be established')
            ) {

                $errorCode = "SMTP_CONNECTION_ERROR";

                $message = "No se pudo establecer conexión con el servidor de correo.";

            }

            return [
                "success" => false,
                "message" => $message,
                "error_code" => $errorCode,
                "data" => [
                    "email" => $emailSend,
                    "status" => "FAILED"
                ]
            ];

        } catch (Throwable $e) {


            return [
                "success" => false,
                "message" => "Ocurrió un error al procesar la notificación de recompensa.",
                "error_code" => "REWARD_EMAIL_ERROR",
                "data" => [
                    "email" => $emailSend,
                    "status" => "FAILED"
                ]
            ];
        }
    }

    protected function creditRegisterUser($user, $isCreate, $type)
    {
        $gamification = [
            'success' => false,
            'message' => '',
            'type' => TrackingUtil::TYPE_ERROR_SAVE_GAMIFICATION,
            'data' => [
                'user_id' => $user->id ?? null,
                'business_id' => 1,
                'process_id' => null,
                'points_id' => null,
                'points' => 0,
                'tracking_id' => null,
                'reward' => null,
            ],
        ];

        try {
            if ($isCreate) {
                // ==========================================
                // 1. VALIDATE USER
                // ==========================================

                if (!$user || !$user->id) {
                    throw new \RuntimeException(
                        'No se encontró un usuario válido.'
                    );
                }

                $userId = (int)$user->id;

                $processId = match ($type) {
                    UtilUser::PROVIDER_GOOGLE => 673,
                    UtilUser::PROVIDER_FACEBOOK => 674,
                    UtilUser::PROVIDER_OWNER_SERVER => 675,
                    default => null,
                };

                if ($processId === null) {
                    throw new \InvalidArgumentException(
                        'Proveedor de registro no válido.'
                    );
                }

                $gamification['data']['process_id'] = $processId;

                // ==========================================
                // 4. GET GAMIFICATION PROCESS
                // ==========================================

                $taskData = $this->getGamificationProcessById(
                    $processId,
                    $userId
                );

                if (
                    !$taskData ||
                    empty($taskData['process']) ||
                    empty($taskData['points'])
                ) {
                    throw new \RuntimeException(
                        'No se encontró el proceso de gamificación o sus puntos.'
                    );
                }
                $rowDataProcess = $taskData['process'];
                $rowDataPoints = $taskData['points'];
                $processManager = (array)$rowDataProcess;
                $pointsData = (array)$rowDataPoints;
                $pointsId = $pointsData['id'] ?? null;
                $pointsValue = (float)($pointsData['points'] ?? 0);
                if ($pointsId === null || $pointsValue <= 0) {
                    throw new \RuntimeException(
                        'El proceso no tiene puntos válidos para acreditar.'
                    );
                }


                $gamification['data']['process_id'] = (int)$processManager['id'];
                $gamification['data']['points_id'] = (int)$pointsId;
                $gamification['data']['points'] = $pointsValue;

                $existingTracking = GamificationByProcessTracking::query()
                    ->where('user_id', $userId)
                    ->whereIn('gamification_by_process_id', [673, 674, 675])
                    ->where('status', GamificationByProcessTracking::STATE_COMPLETED)
                    ->first();

                if ($existingTracking) {
                    $gamification['success'] = true;
                    $gamification['message'] =
                        'La recompensa de registro ya fue completada.';
                    $gamification['type'] = 200;
                    $gamification['data']['tracking_id'] = $existingTracking->id;

                    return $gamification;
                } else {
                    $paramsTask = [
                        'taskName' => $processManager["title"],
                        'taskDescription' => $processManager["title"] . ",Por realizar el registro participas a un sorteo de los premios auspiciantes ,estaremos enviando un correo para poder emitir al ganador o en nuestras redes sociales",
                        'taskImage' => asset('public/uploads/yapita/rewards/1/register.png'),
                        'points' => $pointsValue,
                    ];
                    $emailSend = $user->email;
                    $userName = $user->username;
                    $resultSend = $this->sendReward($emailSend, $userName, $paramsTask);
                    $gamification['mailSendReward'] = $resultSend;

                }

                // ==========================================
                // 6. CREATE TRACKING
                // ==========================================

                $now = Carbon::now('America/Guayaquil')
                    ->format('Y-m-d H:i:s');

                $model = new GamificationByProcessTracking();

                $model->fill([
                    'user_id' => $userId,
                    'gamification_by_process_id' => (int)$processManager['id'],
                    'status' => $model::STATE_COMPLETED,
                    'assigned_at' => $now,
                    'completed_at' => $now,
                ]);

                if (!$model->save()) {
                    throw new \RuntimeException(
                        'No se pudo guardar el seguimiento de la tarea.'
                    );
                }

                $gamification['data']['tracking_id'] = $model->id;

                // ==========================================
                // 7. CREDIT REWARD
                // ==========================================

                $useCase = app(RewardUserByTaskUseCase::class);

                $dto = new TaskRewardInputDTO(
                    userId: $userId,
                    process: $processManager,
                    amount: $pointsValue,
                    typeMoney: 0,
                    referenceCode: 'business-code',
                    performedById: null,
                    business_id: 1
                );

                $result = $useCase->execute($dto);

                $rewardSuccess = (bool)($result['success'] ?? false);

                if (!$rewardSuccess) {
                    throw new \RuntimeException(
                        $result['message']
                        ?? 'No se pudo acreditar la recompensa de registro.'
                    );
                }

                // ==========================================
                // 8. SUCCESS RESPONSE
                // ==========================================

                $gamification['success'] = true;
                $gamification['message'] =
                    'Registro completado. Yapitas acreditadas correctamente.';
                $gamification['type'] = 420;
                $gamification['data']['rewardInformation'] = $taskData;
                $gamification['data']['reward'] = $result;

            }


        } catch (Throwable $e) {


            $gamification['success'] = false;
            $gamification['message'] =
                'No se pudo completar la acreditación de Yapitas.' . $e->getMessage();
            $gamification['type'] =
                TrackingUtil::TYPE_ERROR_SAVE_GAMIFICATION;

        }

        return $gamification;
    }

    protected function initSession($user, Request $request)
    {

        // Iniciar sesión con el usuario existente o recién creado
        $this->guard()->login($user);

        // Regenerar el ID de sesión por seguridad
        $request->session()->regenerate();


    }

    private function googleModalError(
        string $code,
        string $step,
        string $message,
        int    $status = 500,
        array  $details = []
    ): JsonResponse
    {
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
        string     $step
    ): void
    {
        Log::error('Google modal authentication failed', [
            'step' => $step,
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }
}
