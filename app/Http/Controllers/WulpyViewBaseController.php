<?php

namespace App\Http\Controllers;

use View;
use Redirect;
use App\Models\Business;
use App\Models\BusinessByRoutesMap;
use App\Models\RoutesMap;

class WulpyViewBaseController extends Controller
{


    /**
     * Define the layout the controllers are going to use
     */
    protected $layout = 'layouts.wulpyView';
    protected $paramsControllers = array();

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

    protected function setupLayout($method, $parameters)
    {
        if (!is_null($this->layout)) {
            $data = array();
            if ($method == "routeView") {
                $model = new Business();
                $id = $parameters["id"];
                $dataModelBRR = BusinessByRoutesMap::find($id);
                $business_id = null;
                $modelInformation = null;
                $information = array();
                if ($dataModelBRR) {
                    $business_id = $dataModelBRR->business_id;
                    $routes_map_id = $dataModelBRR->routes_map_id;
                    $modelInformation = RoutesMap::find($routes_map_id);
                    $information = $modelInformation->getAttributes();
                }

                $data = array(
                    "information" => $information
                );;

            }

            $parametersCurrent = array(
                "method" => $method,
                "parameters" => $parameters,
                "data" => $data
            );


            $this->layout = view($this->layout, $parametersCurrent);
            return Redirect::to('/');


        }


    }

    public function callAction($method, $parameters)
    {

        $this->setupLayout($method, $parameters);
        $response = call_user_func_array(array($this, $method), $parameters);
        if (is_null($response) && !is_null($this->layout)) {
            $response = $this->layout;
        }

        return $response;
    }
}
