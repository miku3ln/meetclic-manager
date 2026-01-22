<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Request;
use Cookie;
use App\Services\FirebaseService;
use Input;

use Illuminate\Contracts\Cookie\Factory;
use Stevebauman\Location\Facades\Location;
use App\Services\GeoIpLocalService;
class FrontendCityBookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public $cookies = [];


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

    public function managementCookies($params)
    {
        $request = $params['$request'];
        $response = $params['$response'];

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
    }

    public
    function handle($request, Closure $next, $plan = null)
    {
        $utilTracking = new App\Utils\TrackingUtil();

        $response = $next($request);

        $result = $utilTracking->managerAllowRoutes($request, $next,1);//CMS TRACKING
//dd($result);
        $allowView = $result['success'];
        $actionUrlManagement = $result['data']['url'];
        $this->managementCookies([
            '$response' => $response,
            '$request' => $request,

        ]);
        if ($allowView) {
            $utilTracking->managerCounters([
                'type' => $actionUrlManagement,
                'data' => $result['data']
            ]);
        } else {
            $typeRender = $result['typeRender'];
            if ($typeRender == '404') {
                abort(404);
            } else if ($typeRender == '202') {
                return redirect()->route($result['data']['url'], $result['data']['params']);
            } else if ($typeRender == 'login') {
              //  $urlLogin=route('homePage',app()->getLocale())
                return response()->view('errors.401', [
                    'message' => 'Acceso no autorizado.!',
                    'type'    => 'managerProcess',
                    'reason'  => 'TOKEN_INVALID',
                    'urlLogin'  => 'TOKEN_INVALID',

                ], 401);
            } else if ($typeRender == '401') {

                return response()->view('errors.401', [
                    'message' => 'Acceso no autorizado.!',
                    'type'    => 'managerProcess',
                    'reason'  => 'TOKEN_INVALID',
                ], 401);
            } else if ($typeRender == '') {
                $utilTracking->managerCounters([
                    'type' => $actionUrlManagement,
                    'data' => $result['data']
                ]);
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
