<?php

namespace App\Utils;

use App;


use App\Infrastructure\Cms\Application\Gamification\Routing\UseCases\ResolveRouteContextUseCase;
use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\FindProcessInputDTO;
use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\TaskPreviewInputDTO;
use App\Infrastructure\Cms\Application\Gamification\Wallet\UseCases\FindProcessForBusinessTrackingUseCase;
use App\Infrastructure\Cms\Application\Gamification\Wallet\UseCases\PreviewTaskRewardUseCase;
use App\Infrastructure\Cms\Application\Gamification\Wallet\UseCases\RewardUserByTaskUseCase;
use App\Infrastructure\Cms\Application\Gamification\Wallet\DTOs\TaskRewardInputDTO;
use App\Infrastructure\Cms\Domain\Gamification\Routing\DTOs\RouteResolveInputDTO;
use App\Models\Gamification\GamificationByProcessTracking;
use App\Models\GamificationByProcess;
use App\Services\GeoIpLocalService;

use Carbon\Carbon;
use Cassandra\Date;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

use Cookie;


class TrackingUtil
{
    public $cookies = [];

    const URL_MANY = 1;
    const URL_NOT_MANY = 2;
    const URL_EMPTY = 0;

    public $allowLanguage = [
        'es', 'en', 'ki'
    ];

    public $actionsAllows = [
        'login', 'register', 'password/reset', 'password/email', 'password',
        'loginBusiness', 'registerBusiness', 'logout',
        'activitiesGame', 'rewardsGame',
        'web', 'aboutUs', 'contactUs', 'services', 'shop', 'productDetails', 'wishList', 'cart', 'paymentSend', 'product',
        'checkout', 'payment', 'policies', 'terms', 'checkoutDetails',
        'refundCreditCard', 'refundCreditCardSave',
        'eventDetails', 'eventsTrailsProject', 'users',
        'eventsTrailsRegistrationPoints',
        'shopOutlets',
        'shopBalances',
        'ourStores',
        'orderService',
        'translateKichwa',

        // FREE
        'homeTest',

        // news frontend
        // SET ALLOW ACTIONS
        'indexOne', 'listingOne',
        'signPdfLocalF',
        'signPdfLocal',
        'signPdf',
        'signPdfF',
    ];

    public $actionsAllows2 = [
        'homePage',
        'profile',
        'aboutUs',
        'contactUsBee',
        'howItWorks',
        'search',
        'prices',
        'shopBee',
        'activities',
        'rewards',
        'businessDetails',
        'searchBusinessBee',

        // user
        'account',
        'myProfile',
        'suggestionsMailBox',
        'password',
        'business',
        'bee',
        'reviewsTo',
        'listingsQueen',
        'authorSingle',
        'categoriesSearchBee',
        'pointsSales',
        'orders',
        'translateKichwa',
        'managerInvitationOtavalo',

        // FREE
        'productFlowers',
        'productFrozen',
        'productFruits',
        'productBox',
        'FAQ',
    ];

    public function validateActionsTrackingGaming($request, $next, $type)
    {
        $result = [
            "success" => false,
            "message" => "Algun error .!",
            "type" => -1,
            "data" => null
        ];
        // tracking type / source / campaign
        $typeProcess = $request->query('typeProcess', '');     // 'share', 'click', 'view', 'referral', 'web_tracking'
        $sourceProcess = $request->query('sourceProcess', '');   // 'facebook', 'whatsapp', 'meetclick', etc.
        $campaign_code = $request->query('campaign_code', '');   // 'fb_234', 'campaign-00-web-tracking'
        $codeProcess = $request->query('codeProcess', '');   // 'fb_234', 'campaign-00-web-tracking'

        if ($typeProcess == "" && $sourceProcess == "" && $campaign_code == "" && $codeProcess == "") {
            $result["success"] = false;
            $result["message"] = "No existe datos que procesar de tracking.!";
        } else if ($typeProcess !== "" && $sourceProcess !== "" && $campaign_code !== "" && $codeProcess !== "") {
            $result["success"] = true;
            $result["message"] = "Datos Obtenidos desde tracking!";
            $referer = $request->headers->get('referer') ?: 'internal';
            // SOURCE
            $modelSource = new \App\Models\Tracking\TrackingSources();
            $source_origin = $sourceProcess;
            $resultSource = $modelSource->findByAttribute('code', $source_origin);
            if (!$resultSource) {
                $result["success"] = false;
                $result["message"] = "Source no existe informacion!";
                return $result;
            }
            $source_id = $resultSource->id;
            // TYPE
            $modelTypes = new \App\Models\Tracking\TrackingClickTypes();
            $type_process = $typeProcess;
            $resultTypes = $modelTypes->findByAttribute('code', $type_process);
            $click_type_id = $resultTypes->id;
            if (!$resultTypes) {
                $result["success"] = false;
                $result["message"] = "Type no existe informacion!";
                return $result;
            }
            $referer_url = $request->headers->get('referer');
            $managerClick = [
                'type' => $typeProcess,
                'type_process' => $typeProcess,
                'click_type_id' => $click_type_id,
                'id' => $source_id, // OJO: este es el id de la fuente
                'source_origin' => $sourceProcess,
                'source_id' => $source_id,
                'referer' => $referer,
                'referer_url' => $referer_url ?: 'not-referral',
                'campaign_code' => $campaign_code,
                'code_process' => $codeProcess,


            ];
            $result["data"]["managerClick"] = $managerClick;

        }


        return $result;

    }
    // =========================================
    //  PUBLIC: MANAGER ALLOW ROUTES
    // =========================================
    public function managerAllowRoutes($request, $next, $type)//CMS TRACKING
    {
        // type == 1  => lógica vieja con segments + permisos + casos 1..8
        // type != 1  => lógica de tracking por route name / action name
        $this->managerGamingTask($request, $next, $type);
        if ($type == 1) {
            return $this->handleTypeOneRoutes($request);
        }
        $result = $this->handleNonTypeOneRoutes($request);//CMS TRACKING

        return $result;
    }

    public function managerSaveRegisterGamingTaskLog($userId, $processId, $reference_code = null)
    {
        $useCase = app(PreviewTaskRewardUseCase::class);
        $dto = new TaskPreviewInputDTO(
            processId: $processId,
            nowEpochSeconds: time(),   // o el que tú envíes
            userId: (int)$userId,
        );

        return $useCase->execute($dto);


    }

    public function resolveRouteParamsForGamification($request)
    {
        $route = $request->route();
        $routeName = $route ? (string)$route->getName() : '';
        $routeParams = $route ? (array)$route->parameters() : [];
        $queryParams = (array)$request->query();

        $useCase = app(ResolveRouteContextUseCase::class);

        $dto = new RouteResolveInputDTO(
            routeName: $routeName,
            routeParams: $routeParams,
            queryParams: $queryParams,

        );
        return $useCase->execute($dto);
    }

    public function findProcess($params)
    {
        $useCase = app(FindProcessForBusinessTrackingUseCase::class);

        $dto = new FindProcessInputDTO(
            businessId: $params['business_id'],
            trackingSourceId: $params['tracking_source_id'],
            trackingClickTypeId: $params['tracking_click_type_id'],
            campaignCode: $params['campaign_code'],
            codeProcess: $params['code_process'],

        );

        return $useCase->execute($dto);
    }

    public function managerGamingTask($request, $next, $type)
    {

        $resultDataByParams = $this->resolveRouteParamsForGamification($request, $type);

        $res = $resultDataByParams;
        if ($res->success) {

            $routingData = $res->data["routing"];
            $relationManager = $res->data["relationManager"];
            $typeProcess = $relationManager["typeProcess"];
            $resultManager = $this->validateActionsTrackingGaming($request, $next, $type);
            $user = $request->user();
            if ($resultManager["success"] && $typeProcess == "business") {
                $managerClick = $resultManager["data"]["managerClick"];
                $dataRelation = $relationManager["relation"];
                $business_id = $dataRelation["business_id"];
                $tracking_source_id = $managerClick["source_id"];
                $campaign_code = $managerClick["campaign_code"];
                $tracking_click_type_id = $managerClick["click_type_id"];

                $code_process = $managerClick["code_process"];
                $findParamsProcess = [
                    "business_id" => $business_id,
                    "tracking_source_id" => $tracking_source_id,
                    "tracking_click_type_id" => $tracking_click_type_id,
                    "campaign_code" => $campaign_code,
                    "code_process" => $code_process,

                ];

                $processDataGet = $this->findProcess($findParamsProcess);
                if ($processDataGet->success) {
                    $rowDataProcess = $processDataGet->data["row"];
                    $userId = 1;
                    $processId = $rowDataProcess["id"];
                    $resultAllowDepositLog = $this->managerSaveRegisterGamingTaskLog($userId, $processId);
                    dd($resultAllowDepositLog);
                    if ($resultAllowDepositLog->success) {
                        $model = new GamificationByProcessTracking();
                        $tz = 'America/Guayaquil';
                        $now = Carbon::now($tz)->format('Y-m-d H:i:s');
                        $assigned_at = $now;
                        $completed_at = $now;

                        $attributesSet = [
                            "user_id" => $userId,
                            "gamification_by_process_id" => $processId,
                            "status" => $model::STATE_COMPLETED,
                            "assigned_at" => $assigned_at,
                            "completed_at" => $completed_at,
                        ];
                        $model->fill($attributesSet);
                        $success = $model->save();
                        $processData = $rowDataProcess;
                        $processManager = $processData;
                        $typeMoney = 0;
                        $reference_code = "business-code";
                        $performed_by_id = null;
                        $amount = $processData["points"];
                        $useCase = app(RewardUserByTaskUseCase::class);
                        $dto = new TaskRewardInputDTO(
                            userId: $userId,
                            process: $processManager,
                            amount: $amount,
                            typeMoney: $typeMoney,
                            referenceCode: $reference_code,
                            performedById: $performed_by_id
                        );

                        $result = $useCase->execute($dto);

                    }
                }


            }

        }
    }
    // =========================================
    //  PUBLIC: MANAGER COUNTERS
    // =========================================
    public function managerCounters($params)//CMS TRACKING
    {
        $hasToken = Session::has('_token');
        $token = $hasToken ? Session::get('_token') : null;

        $type = $params['type'];

        $urlSegments = isset($params['data']['urlSegments'])
            ? $params['data']['urlSegments']
            : [];
        $user = isset($params['data']['user'])
            ? $params['data']['user']
            : null;

        $is_guest = $user == null;
        $user_id = $is_guest ? 0 : $user->id;
        $businessIdCurrent = null;
        $business_id = null;
        $allowManagerProcess = false;

        // -------------------------
        // DETERMINAR NEGOCIO
        // -------------------------
        if ($type == 'businessDetails') {
            if (isset($urlSegments[2])) {
                $allowManagerProcess = true;
                $business_id = $urlSegments[2];
            } else {
                $allowManagerProcess = false;
            }
        } else {
            $modelBusiness = new \App\Models\Business();
            $business_id = $modelBusiness::BUSINESS_MAIN_ID;
            $businessIdCurrent = $business_id;
        }

        $modelBusiness = new \App\Models\Business();
        $information = $modelBusiness->getDetailsBee([
            'filters' => [
                'business_id' => $business_id
            ]
        ]);

        if ($information) {
            $allowManagerProcess = true;
            if ($type == 'businessDetails') {
                $businessIdCurrent = $information->id;
            }
        } else {
            $allowManagerProcess = false;
        }

        // -------------------------
        // EXTRAER DATA DE MANAGER CLICK
        // -------------------------
        $clickContext = $this->extractManagerClickContextFromParams($params);
//dd($params,$clickContext);
        $sendParams = [
            'business_id' => $businessIdCurrent,
            'user_id' => $user_id,
            'is_guess' => $is_guest,
            'token' => $token,
            'user' => $user,
            'manager_click_id' => $clickContext['manager_click_id'],//tracking_click_types-typeProcess
            'manager_click_type' => $clickContext['manager_click_type'],
            'action_name' => $type,
            'source_origin' => $clickContext['source_origin'],
            'referer' => $clickContext['referer'],
            'device_agent' => $clickContext['device_agent'],
            'ip_address' => $clickContext['ip_address'],
            'campaign_code' => $clickContext['campaign_code'],
            'referer_url' => $clickContext['referer_url'],
            'country' => $clickContext['country'],
            'region' => $clickContext['region'],
            'city' => $clickContext['city'],
            'latitude' => $clickContext['latitude'],
            'longitude' => $clickContext['longitude'],
            'type_process' => $clickContext['type_process'],
            'click_type_id' => $clickContext['click_type_id'],
            'source_id' => $clickContext['source_id'],
        ];

        if ($allowManagerProcess) {
            $modelCounter = new \App\Models\BusinessByCounter();

            $modelCounter->managerCounter([
                'filters' => $sendParams
            ]);
        }
    }

    // ==================================================
    //  PRIVATE: LÓGICA TYPE == 1 (ROUTES CON SEGMENTS)
    // ==================================================
    private function handleTypeOneRoutes($request)
    {
        $url = Request::segments();
        $language = $request->language;
        $success = true;
        $typeRender = '';
        $params = [];
        $case = null;
        $actionCurrent = '';

        $input = $request->all();
        $user = $request->user();

        // tracking type / source / campaign
        $typeProcess = $request->query('typeProcess', '');     // 'share', 'click', 'view', 'referral', 'web_tracking'
        $sourceProcess = $request->query('sourceProcess', '');   // 'facebook', 'whatsapp', 'meetclick', etc.
        $campaign_code = $request->query('campaign_code', '');   // 'fb_234', 'campaign-00-web-tracking'

        // fbclid sobrescribe -> usar códigos válidos en BDD
        if (isset($input['fbclid'])) {
            $code = $input['fbclid'];
            $sourceProcess = 'facebook';     // tracking_sources.code
            $typeProcess = 'click';        // tracking_click_types.code
            $campaign_code = $code;
        }

        // tracking (tipo, source, location, etc.)
        $tracking = $this->buildTrackingContext($request, $typeProcess, $sourceProcess, $campaign_code);
        $managerClick = $tracking['managerClick'];


        $typeUrl = $this->getUrlType($url);

        $actionsTotal = $this->getAllAllowedActions();

        // -------------------------
        // LÓGICA DE CASOS URL / IDIOMA / ACTION
        // -------------------------
        if (
            $typeUrl == self::URL_EMPTY ||
            $typeUrl == self::URL_MANY ||
            $typeUrl == self::URL_NOT_MANY
        ) {
            if ($typeUrl == self::URL_MANY && $language != null) {
                // case 01
                $success = in_array($url[1], $actionsTotal) && in_array($url[0], $this->allowLanguage);
                $actionCurrent = $url[1];
                $case = 1;
            } elseif ($typeUrl == self::URL_NOT_MANY && $language) {
                $success = false;

                $allowActionsFrontend = in_array($url[0], $actionsTotal);
                if ($allowActionsFrontend) {
                    // case 02
                    $typeRender = '202';
                    $params = ['language' => 'es'];
                    $case = 2;
                } else {
                    $success = in_array($url[0], $this->allowLanguage);
                    if ($success) {
                        // case 03
                        $case = 3;
                    } else {
                        // case 04
                        $case = 4;
                    }
                }
                $actionCurrent = $url[0];
            }
        } else {
            // case 05 => 404
            $typeRender = '404';
            $case = 5;
        }

        // Definir acción actual si aún no se ha definido
        if ($case === null && $actionCurrent === '') {
            if (count($url) == 2) {
                $actionCurrent = $url[0];
            }
            if (count($url) == 0) {
                $actionCurrent = 'homeInit';
            }
        }

        // -------------------------
        // CONTROL DE ACCESO POR ROL
        // -------------------------

        if ($success) {
            if ($this->isProtectedUserAction($actionCurrent)) {

                $allowManager = false; // comportamiento actual

                if ($user) {
                    if ($user->id == 1) {
                        // super admin
                        $success = true;
                        $case = 6;
                    } else {
                        $band = $this->userHasAccessToAction($user, $actionCurrent, $allowManager);

                        if ($band == 0) {
                            // no tiene permiso
                            $typeRender = '401';
                            $success = false;
                            $case = 7;
                        }
                    }
                } else {
                    // no autenticado, mandar a login
                    $typeRender = 'login';
                    $success = false;
                    $case = 8;
                }
            }
        }else{
            if ($this->isProtectedUserAction($actionCurrent)) {

                $allowManager = false; // comportamiento actual

                if ($user) {
                    if ($user->id == 1) {
                        // super admin
                        $success = true;
                        $case = 6;
                    } else {
                        $band = $this->userHasAccessToAction($user, $actionCurrent, $allowManager);

                        if ($band == 0) {
                            // no tiene permiso
                            $typeRender = '401';
                            $success = false;
                            $case = 7;
                        }
                    }
                } else {
                    // no autenticado, mandar a login
                    $typeRender = 'login';
                    $success = false;
                    $case = 8;
                }
            }
        }

        $data = [
            'url' => $actionCurrent,
            'params' => $params,
            'case' => $case,
            'urlSegments' => $url,
            'user' => $user,
            'managerClick' => $managerClick,
        ];

        return [
            'success' => $success,
            'typeRender' => $typeRender,
            'data' => $data,
        ];
    }

    // ==================================================
    //  PRIVATE: LÓGICA TYPE != 1 (ROUTES MODERNAS)
    // ==================================================
    private function handleNonTypeOneRoutes($request)
    {
        $url = Request::segments();
        $success = true;
        $typeRender = '';

        $input = $request->all();
        $user = $request->user();

        // tracking type / source / campaign
        $typeProcess = $request->query('typeProcess', '');
        $sourceProcess = $request->query('sourceProcess', '');
        $campaign_code = $request->query('campaign_code', '');

        // fbclid sobrescribe -> usar códigos válidos en BDD
        if (isset($input['fbclid'])) {
            $code = $input['fbclid'];
            $sourceProcess = 'facebook';     // tracking_sources.code
            $typeProcess = 'click';        // tracking_click_types.code
            $campaign_code = $code;
        }

        // tracking (tipo, source, location, etc.)
        $tracking = $this->buildTrackingContext($request, $typeProcess, $sourceProcess, $campaign_code);
        $managerClick = $tracking['managerClick'];
        $typeProcess = $tracking['typeProcess'];
        $sourceProcess = $tracking['sourceProcess'];
        $campaign_code = $tracking['campaign_code'];

        // -----------------------------------------
        // INFORMACIÓN DE RUTA / CONTROLLER / MÉTODO
        // -----------------------------------------
        $route = $request->route();
        $routeName = $route ? $route->getName() : null;
        $actionName = $route ? $route->getActionName() : null;
        $actionMethod = $route ? $route->getActionMethod() : null;
        $params = $route ? $route->parameters() : [];

        // Si quieres valores específicos:
        $slug = $request->route('slug');
        $section = $request->route('section');
        $id = $request->route('id');

        $actionCurrent = $routeName ?: $actionMethod ?: 'homeInit';

        $data = [
            'url' => $actionCurrent,
            'route_name' => $routeName,
            'action_name' => $actionName,
            'action_method' => $actionMethod,
            'params' => $params,
            'urlSegments' => $url,
            'user' => $user,
            'managerClick' => $managerClick,
        ];

        return [
            'success' => $success,
            'typeRender' => $typeRender,
            'data' => $data,
        ];
    }

    // ==================================================
    //  PRIVATE: HELPERS GENERALES
    // ==================================================

    private function getUrlType($segments)
    {
        $count = count($segments);

        if ($count > 1) {
            return self::URL_MANY;
        }

        if ($count == 0) {
            return self::URL_EMPTY;
        }

        return self::URL_NOT_MANY;
    }

    private function getAllAllowedActions()
    {
        return array_merge($this->actionsAllows, $this->actionsAllows2);
    }

    private function isProtectedUserAction($actionCurrent)
    {
        $actionsUserLogin = [
            'account',
            'myProfile',
            'suggestionsMailBox',
            'password',
            'business',
            'bee',
            'reviewsTo',
            'listingsQueen',
            'orders',
            'pointsSales',
            'boardingEmbarkation'
        ];

        return in_array($actionCurrent, $actionsUserLogin);
    }

    private function userHasAccessToAction($user, $actionCurrent, $allowManager)
    {
        $band = 0;
        $roles = $user->roles;
        $urlSetCompare = $actionCurrent;

        foreach ($roles as $role) {
            $actions = $role->actions;

            foreach ($actions as $action) {
                if ($allowManager) {
                    // comportamiento original, con AllowedAction
                    $allowed_actions = \App\Models\AllowedAction::where('action_id', '=', $action->id)->get();
                    foreach ($allowed_actions as $all_act) {
                        if ($all_act->url == $urlSetCompare) {
                            $band = 1;
                        }
                    }
                } else {
                    // comportamiento original: comparar link directo
                    if ($action->link == $urlSetCompare) {
                        $band = 1;
                    }
                }
            }
        }

        return $band;
    }

    // ==================================================
    //  PRIVATE: TRACKING / GEO / SOURCE / TYPE
    // ==================================================
    private function buildTrackingContext($request, $typeProcess, $sourceProcess, $campaign_code)
    {
        // Normalizar nulos a string vacío para comparar
        $typeProcess = $typeProcess ?? '';
        $sourceProcess = $sourceProcess ?? '';
        $campaign_code = $campaign_code ?? '';

        // Si no vino nada, defaults -> usar códigos válidos en BDD
        if ($typeProcess === '' && $sourceProcess === '' && $campaign_code === '') {
            $typeProcess = 'web_tracking';                 // tracking_click_types.code
            $sourceProcess = 'meetclick';                    // tracking_sources.code
            $campaign_code = 'campaign-00-web-tracking';
        }

        $referer = $request->headers->get('referer') ?: 'internal';
        $agent = $request->userAgent() ?: 'unknown';
        $ip = $request->ip() ?: 'unknown';
        $geo = new GeoIpLocalService();
        // SOURCE
        $modelSource = new \App\Models\Tracking\TrackingSources();
        $source_origin = $sourceProcess;
        $resultSource = $modelSource->findByAttribute('code', $source_origin);
        $source_id = $resultSource ? $resultSource->id : 1;

        // TYPE
        $modelTypes = new \App\Models\Tracking\TrackingClickTypes();
        $type_process = $typeProcess;
        $resultTypes = $modelTypes->findByAttribute('code', $type_process);
        $click_type_id = $resultTypes ? $resultTypes->id : 1;

        // GEOLOCATION
        $country = 'none';
        $region = 'none';
        $city = 'none';
        $latitude = 0;
        $longitude = 0;

        $location = $geo->locate($ip);
        if ($location) {
            $country = $location['countryName'];
            $region = $location['regionName'];
            $city = $location['cityName'];
            $latitude = $location['latitude'];
            $longitude = $location['longitude'];
        }

        $referer_url = $request->headers->get('referer');

        $managerClick = [
            'type' => $typeProcess,
            'type_process' => $typeProcess,
            'click_type_id' => $click_type_id,
            'id' => $source_id, // OJO: este es el id de la fuente
            'source_origin' => $sourceProcess,
            'source_id' => $source_id,
            'referer' => $referer,
            'device_agent' => $agent,
            'ip_address' => $ip,
            'referer_url' => $referer_url ?: 'not-referral',
            'campaign_code' => $campaign_code ?: '00-web-tracking',
            'country' => $country,
            'region' => $region,
            'city' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        return [
            'typeProcess' => $typeProcess,
            'sourceProcess' => $sourceProcess,
            'campaign_code' => $campaign_code,
            'managerClick' => $managerClick,
        ];
    }

    private function extractManagerClickContextFromParams($params)//CMS TRACKING
    {
        $defaults = [
            'source_origin' => 'NONE',
            'referer' => 'NONE',
            'device_agent' => 'NONE',
            'ip_address' => 'NONE',
            'campaign_code' => 'NONE',
            'referer_url' => 'NONE',
            'type_process' => 'NONE',
            'country' => 'NONE',
            'region' => 'NONE',
            'city' => 'NONE',
            'latitude' => 0,
            'longitude' => 0,
            'click_type_id' => 1,//tracking_click_types
            'manager_click_type' => 'default',//tracking_click_types
            'source_id' => 1,//tracking_sources
            'manager_click_id' => '1',//tracking_sources
        ];

        if (!isset($params['data']['managerClick']) || !is_array($params['data']['managerClick'])) {
            return $defaults;
        }

        $mc = $params['data']['managerClick'];

        $defaults['manager_click_type'] = isset($mc['type']) ? $mc['type'] : $defaults['manager_click_type'];
        $defaults['manager_click_id'] = isset($mc['id']) ? $mc['id'] : $defaults['manager_click_id'];
        $defaults['source_origin'] = isset($mc['source_origin']) ? $mc['source_origin'] : $defaults['source_origin'];
        $defaults['referer'] = isset($mc['referer']) ? $mc['referer'] : $defaults['referer'];
        $defaults['device_agent'] = isset($mc['device_agent']) ? $mc['device_agent'] : $defaults['device_agent'];
        $defaults['ip_address'] = isset($mc['ip_address']) ? $mc['ip_address'] : $defaults['ip_address'];
        $defaults['campaign_code'] = isset($mc['campaign_code']) ? $mc['campaign_code'] : $defaults['campaign_code'];
        $defaults['referer_url'] = isset($mc['referer_url']) ? $mc['referer_url'] : $defaults['referer_url'];
        $defaults['type_process'] = isset($mc['type_process']) ? $mc['type_process'] : $defaults['type_process'];

        $defaults['country'] = isset($mc['country']) ? $mc['country'] : $defaults['country'];
        $defaults['region'] = isset($mc['region']) ? $mc['region'] : $defaults['region'];
        $defaults['city'] = isset($mc['city']) ? $mc['city'] : $defaults['city'];
        $defaults['latitude'] = isset($mc['latitude']) ? $mc['latitude'] : $defaults['latitude'];
        $defaults['longitude'] = isset($mc['longitude']) ? $mc['longitude'] : $defaults['longitude'];
        $defaults['source_id'] = isset($mc['source_id']) ? $mc['source_id'] : $defaults['source_id'];
        $defaults['click_type_id'] = isset($mc['click_type_id']) ? $mc['click_type_id'] : $defaults['click_type_id'];

        return $defaults;
    }
}
