<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\MyBaseController;
use App\Models\Action;
use Auth;
use Hash;
use Illuminate\Support\Facades\Request;
use Lang;
use League\Flysystem\Exception;
use Mail;
use Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class ActionsController extends MyBaseController
{


    public function getManager()
    {
        $model = new Action();
        $moduleMain = "users";
        $moduleResource = "actions";
        $moduleFolder = "actions";
        $renderView = "$moduleMain.$moduleFolder.index";
        $model_entity = "action";
        $pathCurrent = "$moduleMain/$moduleFolder";
        $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
        $paramsSend = [
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
            ),
            "rootView" => $rootView,
            "model_entity" => $model_entity,
            'model' => $model,
            "pathCurrent" => $pathCurrent,

        ];


        $this->layout->content = View::make($renderView, $paramsSend);
    }

    public function getAdmin()
    {


        $dataPost =Request::all();
        $model = new Action();
        $result = $model->getAdminData($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveData()
    {

        $attributesPost = Request::all();
        $model = new Action();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }
    public function getListActionsParent()
    {

        $attributesPost = Request::all();
        $model = new Action();
        $result = $model->getListActionsParent($attributesPost);
        return Response::json($result);
    }
}
