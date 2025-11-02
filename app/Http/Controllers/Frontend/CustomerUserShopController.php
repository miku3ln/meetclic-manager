<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\FrontendBaseController;
use App\Models\FrontendCityBookManager;
use App\Models\FrontendManager;
use App;
use App\Models\ProductDistributions\ProductParentByProduct;
use App\Models\Products\Product;
use Auth;
use App\Models\TemplateInformation;
use App\Utils\Util;


use App\Utils\FrontendMenu;

use App\Components\EmailUtil;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailContactUs;
use App\Models\TemplateConfigMailingByEmails;
use Illuminate\Support\Facades\Response;

class CustomerUserShopController extends FrontendBaseController
{
    const LAYOUT_MAIN = 'eatPura';
    const PROJECT_NAME_FOLDER = "";

    public $modelInit = null;
    public $modelInitLanguage = null;
    public $typeTemplate = null;

    public function __construct()
    {

        $this->middleware('auth'); //

    }

    public function getCustomerAdminAddresInformationShop()
    {
        $dataPost = Request::all();
        $model = new App\Models\InformationAddress();
        $result = $model->getCustomerAdminAddresInformationShop($dataPost);

        return Response::json(
            $result
        );
    }

    public function saveCustomerAddressInformationShop()
    {
        $dataPost = Request::all();
        $model = new App\Models\InformationAddress();
        $attributes=[];
        $attributes["attributesPost"]=$dataPost;
        $result = $model->saveCustomerAddressInformationShop($attributes);

        return Response::json(
            $result
        );
    }
}
