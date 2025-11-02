<?php

namespace App\Http\Controllers\WulpyView;

use App\Http\Controllers\WulpyViewBaseController;
use App\Models\RouteMapByAdventureTypes;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Services\FirebaseService;


use App\Models\Business;
use App\Models\BusinessBySchedule;

use App\Models\BusinessSubcategories;
use App\Models\Country;
use App\Models\BusinessByRoutesMap;
use App\Models\RoutesMapByRoutesDrawing;
use App\Models\RoutesMap;


use Auth;

class WulpyViewController extends WulpyViewBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public $table = "WulpyView";
    public $name_manager = "Negocio";

    public function index($id)
    {
        $model = new Business();

        $renderView = "wulpyView.index";
        $model_entity = "wulpyView";
        $dataBusiness = $model->getBusinessData(array("id" => $id));
        $info1 = asset('images/frontend/panorama/01.svg');
        $info2 = asset('images/frontend/panorama/02.jpg');
        $info3 = asset('images/frontend/panorama/01.jpg');

        $close1 = asset('images/frontend/panorama/btn_close_map.png');
        $open1 = asset('images/frontend/panorama/btn_open_map.png');
        $view1 = asset('images/frontend/panorama/map.png');
        $current1 = asset('images/frontend/panorama/current_location_map.gif');

        $dataResourcesPanorama = array(
            "map" => array(
                "close" => array(
                    $close1
                ),
                "open" => array(
                    $open1
                ),
                "info" => array(
                    $info1,
                    $info2,
                    $info3
                ),
                "viewAll" => array(
                    $view1
                ),
                "currentPoint" => array(
                    $current1
                )
            )
        );
        $configFirebase = "";
        $paramsSend = [
            "model_entity" => $model_entity,
            "name_manager" => $this->name_manager,
            "icon_manager" => "flaticon-cogwheel-2",
            "configFirebase" => $configFirebase,
            "dataBusiness" => $dataBusiness,
            "dataResourcesPanorama" => $dataResourcesPanorama

        ];
        $this->layout->content = View::make($renderView, $paramsSend);

    }

    public function tary()
    {


        $renderView = "business.index";
        $model_entity = "wulpy";

        $configFirebase = "";
        $paramsSend = [
            "model_entity" => $model_entity,
            "name_manager" => $this->name_manager,
            "icon_manager" => "flaticon-cogwheel-2",

            "configFirebase" => $configFirebase
        ];
        $this->layout->content = View::make("business.tary", $paramsSend);
    }

    public function routeView($id)//CMS-TEMPLATE-ROUTES-VIEW
    {
        $model = new Business();
        $attributesPost = Request::all();
        $paramsUser = array(
            "business_by_routes_map_id" => $id,
            "attributesPost" => $attributesPost
        );
        /*Config*/
        $moduleMain = "wulpyView";
        $moduleFolder = "routeView";
        $moduleResource = "index";
        $user = Auth::user();
        $renderView = "$moduleMain.$moduleFolder.$moduleResource";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $dataModelBRR = BusinessByRoutesMap::find($id);

        $business_id = null;
        $routes_map_id = null;
        if ($dataModelBRR) {
            $business_id = $dataModelBRR->business_id;
            $routes_map_id = $dataModelBRR->routes_map_id;
        }
        $model_entity = "wulpyView";
        $dataBusiness = $model->getBusinessData(array("id" => $business_id));
        $info1 = asset('images/frontend/panorama/01.svg');
        $info2 = asset('images/frontend/panorama/02.jpg');
        $info3 = asset('images/frontend/panorama/01.jpg');

        $close1 = asset('images/frontend/panorama/btn_close_map.png');
        $open1 = asset('images/frontend/panorama/btn_open_map.png');
        $view1 = asset('images/frontend/panorama/map.png');
        $current1 = asset('images/frontend/panorama/current_location_map.gif');
        $pathData = 'images/frontend/panorama/data/';
        $data1 = asset($pathData . "1.jpg");
        $data2 = asset($pathData . "2.jpg");
        $data3 = asset($pathData . "3.png");
        $data4 = asset($pathData . "4.jpg");
        $data5 = asset($pathData . "5.jpg");

        $dataResourcesPanorama = array(
            "data" => array(
                $data1,
                $data2,
                $data3,
                $data4,
                $data5

            ),
            "map" => array(
                "close" => array(
                    $close1
                ),
                "open" => array(
                    $open1
                ),
                "info" => array(
                    $info1,
                    $info2,
                    $info3
                ),
                "viewAll" => array(
                    $view1
                ),
                "currentPoint" => array(
                    $current1
                ),

            )
        );

        $modelRMBRD = new RoutesMapByRoutesDrawing();
        $routes_drawing_data = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
        $business_by_routes_map_id = $id;
        $modelRMBAT = new RouteMapByAdventureTypes();

        $adventure_type_data = $modelRMBAT->getAdventureTypes(array("business_by_routes_map_id" => $business_by_routes_map_id));

        $modelInformation = RoutesMap::find($routes_map_id);
        $information = array();
        if ($modelInformation) {
            $information = $modelInformation->getAttributes();
        }

        $dataRoute = array(
            "information" => $information,
            "routes_drawing_data" => $routes_drawing_data,
            "adventure_type_data" => $adventure_type_data
        );
        $configFirebase = "";
        $paramsSend = [
            "model_entity" => $model_entity,
            "name_manager" => $this->name_manager,
            "icon_manager" => "flaticon-cogwheel-2",
            "configFirebase" => $configFirebase,
            "dataBusiness" => $dataBusiness,
            "dataResourcesPanorama" => $dataResourcesPanorama,
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
            ),
            "pathCurrent" => $pathCurrent,
            "dataRoute" => $dataRoute,
            "user" => $user,
            "paramsUser" => $paramsUser
        ];
        $this->layout->content = View::make($renderView, $paramsSend);
    }

}
