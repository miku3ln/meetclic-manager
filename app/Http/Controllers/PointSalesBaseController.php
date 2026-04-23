<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Carbon;

class PointSalesBaseController extends Controller
{
    protected $requireToken = false;
    protected $user = null;


    public function __construct(Request $request)
    {

        // 👇 solo leer lo que el middleware ya validó
        $this->user = $request->get('auth_user');
    }
}
