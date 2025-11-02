<?php

namespace App\Http\Controllers;

use App\Utils\Util;
use Illuminate\Http\Request;
use Auth;
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
        $paramsSend=['urlManager'=>$redirectTo,'user'=>$user];
        $renderView='home';

        $this->layout->content = view($renderView)->with($paramsSend);;

    }
}
