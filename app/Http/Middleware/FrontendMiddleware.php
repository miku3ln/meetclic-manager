<?php

namespace App\Http\Middleware;

use App\Services\GeoIpLocalService;
use Closure;
use App;
use Request;
use Cookie;
use App\Services\FirebaseService;

use Illuminate\Contracts\Cookie\Factory;
use Illuminate\Support\Facades\Session;
class FrontendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public $cookies = [];
    const URL_MANY = 1;
    const URL_NOT_MANY = 2;
    const URL_EMPTY = 0;
    public $allowLanguage = [
        'es', 'en', 'ki'
    ];
    public $actionsAllows = [
        'login', 'register', 'password/reset', 'password/email', 'password'
        , 'loginBusiness', 'registerBusiness', 'logout',
        'activitiesGame', 'rewardsGame',
        'web', 'aboutUs', 'contactUs', 'services', 'shop', 'productDetails', 'wishList', 'cart', 'paymentSend', 'product', 'checkout', 'payment', 'policies', 'terms', 'checkoutDetails'
        , 'refundCreditCard', 'refundCreditCardSave'
        , 'eventDetails', 'eventsTrailsProject', 'users',
        'eventsTrailsRegistrationPoints',
        'shopOutlets',
        'shopBalances',
        'ourStores',
        'orderService',
        'translateKichwa',

        //FREE
        'homeTest',
        //news frontend
        //SET ALLOW ACTIONS
        'indexOne',"listingOne",
        "signPdfLocalF",
        "signPdfLocal",
        "signPdf",
        "signPdfF",

    ];

    public function managerFirebase()
    {
        $hasToken = \Session::has('_token');
        $_token = \Session::get('_token');
        $firebaseService = new FirebaseService();
        $pathParent = "meetclic/sessionsManager/data";
        $dataSearch = $firebaseService->getDataSnapByKey(
            [
                "haystackReference" => $pathParent,
                "needle" => $_token,
                'fieldRow' => '_token'
            ]
        );

        $valueCurrent = $dataSearch->getValue();
        if (!empty($valueCurrent)) {
            $dataSet = [
                'count' => $valueCurrent[$_token]['count'] + 1
            ];
            $params = [
                "reference" => $pathParent . '/' . $_token,
                "data" => $dataSet,
                "key" => $pathParent . '/' . $_token
            ];
            $resultReference = $firebaseService->updateData($params);
        } else {
            $dataSet = [
                'count' => 0,
                'type' => 0
            ];
            $params = [
                "reference" => $pathParent . '/' . $_token,
                "data" => $dataSet,
                "key" => $pathParent . '/' . $_token
            ];
            $resultReference = $firebaseService->updateData($params);

            //UPDATE PAGES VISIT PEOPLE
            $pathParent = "meetclic/sessionsManager";
            $dataSearch = $firebaseService->getDataSnapByKey(
                [
                    "haystackReference" => $pathParent,
                    "needle" => 'countAllPages',

                ]
            );

            $valueCurrent = $dataSearch->getValue();

        }
    }
    //COUNTER-001
    public function managerCounters($params)
    {
        $hasToken = \Session::has('_token');
        $_token = \Session::get('_token');
        $type = $params['type'];

        $urlSegments = $params['data']['urlSegments'];
        $user = $params['data']['user'];
        $is_guess = $user == null ? true : false;
        $user_id = $is_guess ? 0 : $user->id;
        $business_id = null;
        $businessIdCurrent = null;

        $token = $_token;
        $informationBusiness = null;
        $allowManagerProcess = false;
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
        $manager_click_type = 'NONE';
        $manager_click_id = 'NONE';
        $source_origin = 'NONE';
        $referer = 'NONE';
        $device_agent = 'NONE';
        $ip_address = 'NONE';
        $campaign_code = 'NONE';
        $referer_url = 'NONE';
        $type_process = 'NONE';
        $country = 'NONE';
        $region = 'NONE';
        $city = 'NONE';

        $latitude = 0;
        $longitude = 0;
        $click_type_id = 1;
        $source_id = 1;

        if (isset($params['data']['managerClick']) && count($params['data']['managerClick']) > 0) {
            $manager_click_type = $params['data']['managerClick']['type'];
            $manager_click_id = $params['data']['managerClick']['id'];
            $source_origin = $params['data']['managerClick']['source_origin'];
            $referer = $params['data']['managerClick']['referer'];
            $device_agent = $params['data']['managerClick']['device_agent'];
            $ip_address = $params['data']['managerClick']['ip_address'];
            $campaign_code = $params['data']['managerClick']['campaign_code'];
            $referer_url = $params['data']['managerClick']['referer_url'];
            $type_process = $params['data']['managerClick']['type_process'];

            $country = $params['data']['managerClick']['country'];
            $region = $params['data']['managerClick']['region'];
            $city = $params['data']['managerClick']['city'];
            $latitude = $params['data']['managerClick']['latitude'];
            $longitude = $params['data']['managerClick']['longitude'];
            $source_id = $params['data']['managerClick']['source_id'];
            $click_type_id = $params['data']['managerClick']['click_type_id'];

        }
        $sendParams = [
            'business_id' => $businessIdCurrent,
            'user_id' => $user_id,
            'is_guess' => $is_guess,
            'token' => $token,
            'user' => $user,
            'manager_click_id' => $manager_click_id,
            'manager_click_type' => $manager_click_type,
            'action_name' => $type,
            'source_origin' => $source_origin,
            'referer' => $referer,
            'device_agent' => $device_agent,
            'ip_address' => $ip_address,
            'campaign_code' => $campaign_code,
            'referer_url' => $referer_url,
            'country' => $country,
            'region' => $region,
            'city' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'type_process' => $type_process,
            'click_type_id' => $click_type_id,
            'source_id' => $source_id,

        ];

        $modelCounter = new \App\Models\BusinessByCounter();

        if ($allowManagerProcess) {
            $modelCounter->managerCounter(
                [
                    'filters' => $sendParams
                ]
            );
        }

    }

    function managerAllowRoutes($request, $next)
    {
        $url = \Request::segments();
        $isGetMethod = $request->isMethod('get');
        $typeUrl = null;
        $success = true;
        $language = $request->language;
        $typeRender = '';
        $data = [];
        $params = [];
        $case = null;

        $input = $request->all();
        $user = $request->user();
        $type = $request->query('typeProcess');     // Ej: 'share', 'click','view','referral','web-tracking'
        $source = $request->query('sourceProcess'); // Ej: 'facebook', 'whatsapp','camera','meetclick'
        $campaign_code = $request->query('campaign_code');     // Ej: 'fb_234', "00-web-tracking"

        // -------------------------------
        // TIPO DE URL (como ya tenías)
        // -------------------------------
        if (count($url) > 1) {
            $typeUrl = self::URL_MANY;
        } elseif (count($url) == 0) {
            $typeUrl = self::URL_EMPTY;
        } elseif (count($url) == 1) {
            $typeUrl = self::URL_NOT_MANY;
        }

        // -------------------------------
        // OBTENER RUTA, PARÁMETROS Y NOMBRE
        // -------------------------------
        $route        = $request->route();                 // instancia de Route
        $routeName    = $route ? $route->getName() : null; // 'pages-owner', 'chasqui-routes', etc.
        $actionName   = $route ? $route->getActionName() : null; // 'Frontend\...\FrontendPagesOwnerCmsController@businessOwner'
        $actionMethod = $route ? $route->getActionMethod() : null; // 'businessOwner', 'chasqui', etc.
        $params       = $route ? $route->parameters() : []; // ['slug' => '...', 'section' => '...'] o ['id' => '...']

        // Si quieres valores específicos:
        $slug    = $request->route('slug');    // null si no aplica
        $section = $request->route('section'); // null si no aplica
        $id      = $request->route('id');      // null si no aplica

        // Puedes decidir cómo llamar a tu "acción actual"
        $actionCurrent = $routeName ?: $actionMethod ?: 'homeInit';

        // -------------------------------
        // RESTO DE TU LÓGICA (tracking)
        // -------------------------------
        $id = "-1";
        if (isset($input['fbclid'])) {
            $code = $input['fbclid'];
            $source = 'facebook';
            $type = "click-facebook";
            $campaign_code = $code;
        }
        if ($type == "" && $source == "" && $campaign_code == "") {
            $type = "web-tracking";
            $source = "meetclick";
            $code = "00-web-tracking";
            $campaign_code = "campaign-00-web-tracking";
        }

        $referer = $request->headers->get('referer') ?? 'internal';
        $agent = $request->userAgent() ?? 'unknown';
        $ip = $request->ip() ?? 'unknown';
        $geo = new GeoIpLocalService();
        $location = [];

        $modelSource = new \App\Models\Tracking\TrackingSources();
        $source_origin = $source;
        $resultSource = $modelSource->findByAttribute("code", $source_origin);
        $source_id = $resultSource ? $resultSource->id : 1;

        $modelTypes = new \App\Models\Tracking\TrackingClickTypes();
        $type_process = $type;
        $resultTypes = $modelTypes->findByAttribute("code", $type_process);
        $click_type_id = $resultTypes ? $resultTypes->id : 1;

        $country = "none";
        $region = "none";
        $city = "none";
        $latitude = 0;
        $longitude = 0;

        $location = $geo->locate($ip);
        if ($location) {
            $country = $location["countryName"];
            $region = $location["regionName"];
            $city = $location["cityName"];
            $latitude = $location["latitude"];
            $longitude = $location["longitude"];
        }

        $referer_url = $request->headers->get('referer');
        $managerClick = [
            'type'          => $type,
            'type_process'  => $type,
            'click_type_id' => $click_type_id,
            'id'            => $source_id,
            'source_origin' => $source,
            'source_id'     => $source_id,
            'referer'       => $referer,
            'device_agent'  => $agent,
            'ip_address'    => $ip,
            'referer_url'   => $referer_url ?: "not-referral",
            'campaign_code' => $campaign_code ?: '00-web-tracking',
            'country'       => $country,
            'region'        => $region,
            'city'          => $city,
            'latitude'      => $latitude,
            'longitude'     => $longitude,
        ];

        $data = [
            'url'          => $actionCurrent, // aquí ya va el nombre de la acción / ruta
            'route_name'   => $routeName,
            'action_name'  => $actionName,
            'action_method'=> $actionMethod,
            'params'       => $params,        // aquí van slug, section, id, etc.
            'urlSegments'  => $url,
            'user'         => $user,
            'managerClick' => $managerClick
        ];

        return ['success' => $success, 'typeRender' => $typeRender, 'data' => $data];
    }

    public function managerAllowRoutes2($request, $next)
    {

        $url = Request::segments();
        $isGetMethod = $request->isMethod('get');
        $typeUrl = null;
        $success = true;
        $language = $request->language;
        $typeRender = '404';
        $data = [];
        if (count($url) > 1) {
            $typeUrl = self::URL_MANY;
        } elseif (count($url) == 0) {
            $typeUrl = self::URL_EMPTY;
        } elseif (count($url) == 1) {
            $typeUrl = self::URL_NOT_MANY;
        }
        $allowView = true;
        $urlManager = '';
        $allowRedirect = false;

        if ($typeUrl == self::URL_EMPTY || $typeUrl == self::URL_MANY || $typeUrl == self::URL_NOT_MANY) {
            if ($typeUrl == self::URL_MANY && $language != null) {

                $success = in_array($url[1], $this->actionsAllows) && in_array($url[0], $this->allowLanguage);

            } else if ($typeUrl == self::URL_NOT_MANY && $language) {
                $success = false;
                $allowActionsFrontend = in_array($url[0], $this->actionsAllows);

                if ($allowActionsFrontend) {
                    $typeRender = '202';
                    $data = [
                        'url' => $url[0],
                        'params' => ['language' => 'es']
                    ];

                } else {
                    $success = in_array($url[0], $this->allowLanguage);
                }

            }
        } else {
            $typeRender = '404';

        }
        if ($success) {


        }
        $result = ['success' => $success, 'typeRender' => $typeRender, 'data' => $data];

        return $result;
    }
    public $languageData = [
        'en', 'es', 'ki'

    ];
    public function getLanguageValid($languagePost)
    {
        $languageCurrent = $languagePost;
        $language = 'es';
        if ($languageCurrent == '' || $languageCurrent == null || in_array($language, $this->languageData) == false) {
            $language = 'es';
        } else {
            $language = $languageCurrent;
        }
        return $language;
    }
    public function setLanguage($request, Closure $next)
    {

        $language = $request->route('language');
        $language = $this->getLanguageValid($language);


        // Guardar el idioma en la sesión y aplicarlo en Laravel
        Session::put('applocale', $language);
        App::setLocale($language);


    }

    public function handle($request, Closure $next, $plan = null)
    {
        $response = $next($request);
        $result = $this->managerAllowRoutes($request, $next);
        $allowView = $result['success'];
        $actionUrlManagement = $result['data']['url'];
        $this->managerCounters([
            'type' => $actionUrlManagement,
            'data' => $result['data']
        ]);

        $this->setLanguage($request,  $next);
        $allowView = $result['success'];
        if ($allowView) {
            $allowCookies = $request->hasCookie('init_cart');
            if ($allowCookies) {
                $timeCurrent = date("Y-m-d H:i");
                $init_cart = Cookie::get('init_cart');
                $init_cart_time = Cookie::get('init_cart_time');
                $end_cart_time = Cookie::get('end_cart_time');
                $timeCurrentValue = strtotime($timeCurrent);
                $end_cart_timeValue = strtotime($end_cart_time);

                if ($init_cart == 'allow') {

                    if ($timeCurrentValue >= $end_cart_timeValue) {
                        Cookie::queue(Cookie::make('init_cart', 'not-allow'));

                    }
                } else if ($init_cart == 'not-allow') {
                    $cookie = Cookie::forget('init_cart');
                    $response->withCookie($cookie);
                }
            } else {

                $timeCurrent = date("Y-m-d H:i");
                $time = strtotime($timeCurrent);
                $start_time = date("Y-m-d H:i", strtotime('-30 minutes', $time));
                $end_cart_time = date("Y-m-d H:i", strtotime('+30 minutes', $time));
                Cookie::queue(Cookie::make('init_cart', 'allow'));
                Cookie::queue(Cookie::make('start_time', $start_time));
                Cookie::queue(Cookie::make('end_cart_time', $end_cart_time));
            }

        } else {
            $typeRender = $result['typeRender'];
            if ($typeRender == '404') {
                abort(404);
            } else if ($typeRender == '202') {
                return redirect()->route($result['data']['url'], $result['data']['params']);
            }
        }
        if (!$request->secure() && env('APP_ENV') === 'production') {
            if (env('ssl_secure')) {
                return redirect()->secure($request->getRequestUri());

            }
        }
        return $response;

    }
}
