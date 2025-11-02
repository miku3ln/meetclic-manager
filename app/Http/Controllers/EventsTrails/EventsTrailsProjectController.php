<?php

namespace App\Http\Controllers\EventsTrails;

use App\Http\Controllers\EventsTrailsBaseController;
use App\Models\EventsTrailsProject;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\Utils\Util;
use App\Utils\EventsMenu;

use Auth;

class EventsTrailsProjectController extends EventsTrailsBaseController
{

    public function getAdmin()
    {
        $dataPost = Request::all();
        $model = new EventsTrailsProject();
        $result = $model->getAdmin($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new EventsTrailsProject();
        $result = $model->saveData(array("attributesPost" => $attributesPost));
        return Response::json($result);
    }


    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  EventsTrailsProject();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }

    public $typeManager = null;
    public $id = null;

    public function manager($id = null, $typeManager = null)
    {

        $model = new EventsTrailsProject();
        $modelDataManager = $model->getManagerData(array('id' => $id));
        $success = $modelDataManager["success"];
        $renderView = "";
        $paramsSend = array();
        if ($success) {


            $user = Auth::user();

            $moduleMain = "eventsTrails";
            $moduleResource = "manager";
            $moduleFolder = "manager";

            $renderView = "$moduleMain.$moduleFolder.index";

            $pathCurrent = "$moduleMain/$moduleFolder";

            $modelCurrent = $modelDataManager['model'];
            $managerViewMain = EventsMenu::getManagerViewMainEventsTrails(array(
                'model' => $modelCurrent,
                'user' => $user,
            ));
            //Menu
            $paramsMenu =  array(
                'managerViewMain' => $managerViewMain,
                'id' => $id,
                'user' => $user,
                'dataManager' => $modelDataManager,
                'typeManager' => $typeManager,

            );
            $menuConfigByRole = EventsMenu::getMenuConfigByRoleEventsTrails($paramsMenu);
            $paramsMenu['menuConfigByRole'] = $menuConfigByRole;
            $menuCurrentConfig = Util::getMenuManager(
                $paramsMenu
               );
            $menuCurrent=$menuCurrentConfig['menu'];
            $menuItems = Util::getMenuFormat($menuCurrent);
            $menuHtml = Util::getStructureMenuCurrent($menuItems);

            $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
            $typeManager = $typeManager == null ? ('manager' . $menuCurrentConfig['managerViewMain']['viewMain']) : $typeManager;

            $paramsSend = [
                "configPartial" => array(
                    "moduleMain" => $moduleMain,
                    "moduleFolder" => $moduleFolder,
                    "moduleResource" => $moduleResource,
                    'menuCurrent' => $menuCurrentConfig,
                    'typeManager' => $typeManager,
                    'user' => $user,
                    'menuHtml'=>$menuHtml
                ),
                "modelDataManager" => $modelDataManager,
                "rootView" => $rootView,
                'managerViewMain' => $managerViewMain,
                'model' => $model,
                "pathCurrent" => $pathCurrent,
                "user" => $user,

            ];

            $this->layout->content = View::make($renderView, $paramsSend);
        } else {
            $renderView = "errors.modelsView.404";
            return view($renderView, ['name' => 'James']);
        }


    }
    public function getAdminFrontend()
    {
        $dataPost = Request::all();
        $model = new EventsTrailsProject;
        $result = $model->getAdminFrontend($dataPost);

        return Response::json(
            $result
        );
    }
}
