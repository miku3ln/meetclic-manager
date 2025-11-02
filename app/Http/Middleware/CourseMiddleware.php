<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Request;
use Cookie;
use App\Services\FirebaseService;


use Illuminate\Contracts\Cookie\Factory;

class CourseMiddleware
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
        //user
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
        'translateKichwa','managerInvitationOtavalo',

        //FREE


    ];


    public
    function handle($request, Closure $next, $plan = null)
    {

        $response = $next($request);


        if (!$request->secure() && env('APP_ENV') === 'production') {
            if (env('ssl_secure')) {
                return redirect()->secure($request->getRequestUri());

            }
        }
        return $response;

    }
}
