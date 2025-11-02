<?php

namespace App\Http\Middleware;

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

    public function managerAllowRoutes($request, $next)
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

        $url = Request::segments();
        $isGetMethod = $request->isMethod('get');
        $this->setLanguage($request,  $next);
        $result = $this->managerAllowRoutes($request, $next);
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
