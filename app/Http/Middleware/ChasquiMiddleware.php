<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Request;
use Cookie;

use Illuminate\Contracts\Cookie\Factory;

class ChasquiMiddleware
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

        'chasqui', 'nianes', 'routeView'

    ];

    public function managerAllowRoutes($request, $next)
    {

        $url = Request::segments();
        $isGetMethod = $request->isMethod('get');
        $typeUrl = null;
        $success = true;
        $language = $request->language;
        $typeRender = '404';
        $data = [];
        $countParams = count($url);
        if ($countParams > 1) {

            $typeUrl = self::URL_MANY;
        } elseif ($countParams == 0) {
            $typeUrl = self::URL_EMPTY;
        } elseif ($countParams == 1) {
            $typeUrl = self::URL_NOT_MANY;
        }
        $allowView = true;
        $urlManager = '';
        $allowRedirect = false;

        if ($typeUrl == self::URL_EMPTY || $typeUrl == self::URL_MANY || $typeUrl == self::URL_NOT_MANY) {

            if ($typeUrl == self::URL_MANY && $language != null) {
                if ($countParams > 2) {

                $success = in_array($url[2], $this->actionsAllows) && in_array($url[1], $this->allowLanguage);
                }else{

                    $success = in_array($url[1], $this->actionsAllows) && in_array($url[0], $this->allowLanguage);

                }

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
            $success = false;
        }

        $result = ['success' => $success, 'typeRender' => $typeRender, 'data' => $data];


        return $result;
    }

    public function handle($request, Closure $next, $plan = null)
    {

        $response = $next($request);

        $url = Request::segments();
        $isGetMethod = $request->isMethod('get');
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

        return $response;

    }
}
