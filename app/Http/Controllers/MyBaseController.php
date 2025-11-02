<?php

namespace App\Http\Controllers;

use View;
use Auth;
use App\Models\Role;
use App\Models\User;

use Redirect;
use Closure;

class MyBaseController extends Controller
{

    /**
     * Define the layout the controllers are going to use
     */
    protected $layout = 'layouts.masterMinton';
    public $title = 'Hola';

    /**
     * Set the necessary filters
     */
    public function __construct()
    {
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function getRouteInit()
    {

    }

    protected function setupLayout()
    {
        if (!is_null($this->layout)) {

            $user = Auth::user();
            if ($user) {
                $user_id = $user->id;
                $userModel = User::find($user_id);
                $role = new Role();
                $roles = $userModel->roles->pluck('id')->toArray();

                $menu = $role->getStructureMenuCurrent($roles);

                $log_in_name = $user;
                $urlCurrentInit = $role->getUrlCurrentUser();
                $paramsUser = array(
                    "url" => $urlCurrentInit
                );;
                $this->layout = view($this->layout, ['menu' => $menu, 'log_in_name' => $log_in_name, "paramsUser" => $paramsUser]);
            } else {
                $this->layout = view($this->layout);

                return Redirect::to('/');
            }

        }


    }

    public function callAction($method, $parameters)
    {

        $this->setupLayout();

        $response = call_user_func_array(array($this, $method), $parameters);

        if (is_null($response) && !is_null($this->layout)) {

            $response = $this->layout;
        }
        return $response;
    }
}
