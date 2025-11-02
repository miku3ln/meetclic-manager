<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\FrontendBaseController;
use App\Models\FrontendCityBookManager;
use App\Models\FrontendManager;
use App;
use App\Models\ProductDistributions\ProductParentByProduct;
use App\Models\Products\Product;
use App\Utils\UtilModelManager;
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

class EatPuraController extends FrontendBaseController
{
    const LAYOUT_MAIN = 'eatPura';
    const PROJECT_NAME_FOLDER = "";

    public $modelInit = null;
    public $modelInitLanguage = null;
    public $typeTemplate = null;
    use UtilModelManager;
    public function __construct()
    {
        $this->modelInit = new FrontendCityBookManager();
        $this->modelInitLanguage = new App\Models\LanguageConfigManager();
        $this->middleware('auth')->only(['userAccount']);

    }



    public function index($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {



        $renderView = self::LAYOUT_MAIN . '.web.homePage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>1
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'homeEatPura',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }

    public function userAccount($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {



        $renderView = self::LAYOUT_MAIN . '.web.userAccount';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>1
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'userAccount',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }
    public function shopPage($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {

        $dataPost = Request::all();
        $search_term = isset($dataPost['keywords']) ? $dataPost['keywords'] : null;
        $category = isset($dataPost['category']) ? $dataPost['category'] : null;

        $renderView = self::LAYOUT_MAIN . '.web.shopPage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>1
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['language'] = $language;
        $paramsRequest['keywords'] = $search_term;
        $paramsRequest['category'] = $category;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'shopPage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }
    public function managerProductsBusiness($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {

        $dataPost = Request::all();
        $search_term = isset($dataPost['keywords']) ? $dataPost['keywords'] : null;
        $category = isset($dataPost['category']) ? $dataPost['category'] : null;

        $renderView = self::LAYOUT_MAIN . '.web.managerProductsBusiness';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>1
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['language'] = $language;
        $paramsRequest['keywords'] = $search_term;
        $paramsRequest['category'] = $category;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'shopPage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }
    public function searchProductBusiness($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {

        $dataPost = Request::all();
        $search_term = isset($dataPost['keywords']) ? $dataPost['keywords'] : null;
        $category = isset($dataPost['category']) ? $dataPost['category'] : null;

        $renderView = self::LAYOUT_MAIN . '.web.searchProductBusiness';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>1
        ];

        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['language'] = $language;
        $paramsRequest['keywords'] = $search_term;
        $paramsRequest['category'] = $category;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'searchProductBusiness',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }
    public function checkoutPage($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {

        $dataPost = Request::all();
        $search_term = isset($dataPost['keywords']) ? $dataPost['keywords'] : null;
        $category = isset($dataPost['category']) ? $dataPost['category'] : null;

        $renderView = self::LAYOUT_MAIN . '.web.checkoutPage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>1
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['language'] = $language;
        $paramsRequest['keywords'] = $search_term;
        $paramsRequest['category'] = $category;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'checkoutPage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }
    public function getProductShopAdmin()
    {
        $dataPost = Request::all();

        $model = new ProductParentByProduct();
        $result = $model->getProductShopAdmin($dataPost);
        return Response::json(
            $result
        );
    }
    public function validateEmailCheckout()
    {
        $inputPost = Request::all();


        $userData = $inputPost;
        $user_id = isset($inputPost['id']) ? $inputPost['id'] : null;
        $inputsValidations = $user_id ? array(
            "email" => $inputPost['email'],
            "id" => $inputPost['id'],

        ) : array(
            "email" => $inputPost['email']
        );

        $rules = [
            "email" => 'required|unique:users,email',
        ];

        $validateData = $this->validateModel([
            'rules' => $rules,
            'inputs' => $inputsValidations
        ]);
        $result = $validateData['success'];
        return Response::json($result);
    }
}
