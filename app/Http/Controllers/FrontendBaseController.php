<?php

namespace App\Http\Controllers;

use View;
use Redirect;

class FrontendBaseController extends Controller
{

    /**
     * Define the layout the controllers are going to use
     */
    protected $layout = 'layouts.frontend';
    protected $resourcesPathManager = '';

    public $cookies = [];

    /**
     * Set the necessary filtersº
     */
    public function __construct()
    {
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */

    protected function setupLayout()
    {
        if (!is_null($this->layout)) {

            $this->layout = view($this->layout);

            return Redirect::to('/');


        }


    }

    public function callAction($method, $parameters)
    {
        $this->setupLayout();

    //    $response = call_user_func_array(array($this, $method), $parameters);
        $response = call_user_func_array(array($this, $method), array_values($parameters));

        if (is_null($response) && !is_null($this->layout)) {
            $response = $this->layout;
        }

        return $response;
    }
}
