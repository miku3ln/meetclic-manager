<?php

namespace App\Http\Controllers;

use App\Services\Gamification\BusinessGamificationInitializer;
use App\Services\Gamification\BusinessWithoutGamificationService;
use App\Utils\Util;
use Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class HomeController extends MyBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $redirectTo = Util::getUrlManager();
        $user = Auth::user();
        $paramsSend = ['urlManager' => $redirectTo, 'user' => $user];
        $renderView = 'home';

        $this->layout->content = view($renderView)->with($paramsSend);;

    }

    public function initConfigurationBusinessGamification(BusinessGamificationInitializer $initializer,BusinessWithoutGamificationService $service)
    {
        $user = Auth::user();
        $userId = $user->id;
        // Ejemplo: luego esto vendrá de DB o request

        $businessData = $service->getActiveBusinessesWithoutGamification();
        $urlBase = asset("");
        $result = $initializer->run(
            businessData: $businessData,
            urlBase: $urlBase,
            userId: $userId
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }


}
