<?php

namespace App\Http\Controllers\Wulpy;

use App\Http\Controllers\WulpyBaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use App\Services\FirebaseService;


use App\Models\Business;
use App\Models\BusinessBySchedule;

use App\Models\BusinessSubcategories;
use App\Models\Country;
use Auth;

class WulpyController extends WulpyBaseController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public $table = "Wulpy";
    public $name_manager = "Negocio";

    public function index()
    {
        $model = new Business();
        $modelS = new BusinessSubcategories();
        $categories = $modelS->getCategoriesSearch();

        /*Config*/
        $moduleMain = "wulpy";
        $moduleResource = "index";
        $moduleFolder = "wulpymes";
        $user = Auth::user();

        $renderView = "$moduleMain.$moduleFolder.$moduleResource";
        $pathCurrent = "$moduleMain/$moduleFolder";

        $model_entity = "wulpy";
        $dataBusiness = $model->getAllBusiness();
        $configFirebase = "";
        $paramsSend = [
            "model_entity" => $model_entity,
            "name_manager" => $this->name_manager,
            "icon_manager" => "flaticon-cogwheel-2",
            "configFirebase" => $configFirebase,
            "dataBusiness" => $dataBusiness,
            "categories" => $categories,
            "configPartial" => array(
                "moduleMain" => $moduleMain,
                "moduleFolder" => $moduleFolder,
                "moduleResource" => $moduleResource,
            ),
            "pathCurrent" => $pathCurrent,
            "user" => $user,

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


}
