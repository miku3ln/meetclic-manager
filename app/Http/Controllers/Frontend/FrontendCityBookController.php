<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\FrontendBaseController;
use App\Models\FrontendCityBookManager;
use App;
use Auth;
use App\Models\TemplateInformation;
use App\Utils\Util;


use App\Utils\FrontendMenu;

use App\Components\EmailUtil;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class FrontendCityBookController extends FrontendBaseController
{
    const LAYOUT_MAIN = 'cityBook';
    const LAYOUT_PRESENTATION_CARD = 'presentationCard';

    const PROJECT_NAME_FOLDER = "managerSystemTest";
    public $modelInit = null;
    public $modelInitLanguage = null;

    public function __construct()
    {
        $this->modelInit = new FrontendCityBookManager();
        $this->modelInitLanguage = new App\Models\LanguageConfigManager();

    }

    public function managerInvitationOtavalo($language = 'es', $document = null)
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        if ($document == null) {

            $renderView = "errors.modelsView.404";
            return view($renderView, ['error' => 'Parametros mal enviados.!']);

        } else {

            $renderView = self::LAYOUT_MAIN . '.web.invitations.otavalo';
            $modelPage = $this->modelInit;
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $document;

            $paramsSend = $modelPage->getParamsPage([
                'page' => 'managerInvitationOtavalo',
                'id' => $document,
                'paramsRequest' => $paramsRequest

            ]);

            if ($paramsSend['viewPage']) {
                return view($renderView, $paramsSend);
            } else {
                return view('errors.modelsView.404', ['msg' => 'No existe informacion de esta persona.']);
            }

            return view($renderView, $paramsSend);
        }
    }

    public function homePage($language = 'es', $type = 1)
    {


        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.homePage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'homePage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);
    }

    public function account($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.web.account';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'account',
            'paramsRequest' => $paramsRequest

        ]);
        if ($paramsSend['dataManagerPage']['menuAccountManagementUser']['success']) {

            return view($renderView, $paramsSend);

        } else {


        }
        return view($renderView, $paramsSend);
    }

    public function orders($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.web.account';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'orders',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function pointsSales($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.management.pointsSales.index';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'pointsSales',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function myProfile($language = 'es')//CMS-TEMPLATE-MY-PROFILE-ACTION
    {

        $renderView = self::LAYOUT_MAIN . '.web.account';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'myProfile',
            'paramsRequest' => $paramsRequest
        ]);
        return view($renderView, $paramsSend);

    }

    public function suggestionsMailBox($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.web.account';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'suggestionsMailBox',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function password($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.web.account';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'password',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function bee($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.web.account';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'bee',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function business($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.management.business.index';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'business',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function businessEmployer($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.management.businessEmployer.index';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'businessEmployer',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function reviewsTo($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.web.account';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'reviewsTo',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function listingsQueen($language = 'es')
    {

        $renderView = self::LAYOUT_MAIN . '.web.account';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'listings',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function prices($language = 'es', $type = 1)
    {

        $renderView = self::LAYOUT_MAIN . '.web.prices';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'prices',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function search($language = 'es')
    {
        $dataPost = Request::all();
        $search_term = isset($dataPost['keywords']) ? $dataPost['keywords'] : null;
        $category = isset($dataPost['category']) ? $dataPost['category'] : null;

        $renderView = self::LAYOUT_MAIN . '.web.search';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['keywords'] = $search_term;
        $paramsRequest['category'] = $category;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'search',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function searchBusinessBee($language = 'es')
    {

        $dataPost = Request::all();
        $modelPage = $this->modelInit;
        $result = $modelPage->getValuesBusiness($dataPost);
        $result = ['items' => $result];
        return Response::json(
            $result
        );
    }

    public function businessDetails($language = 'es', $id = null, $type = 2)
    {
        if ($id) {
            $nameProcess = 'businessDetails';
            $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
            $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
            $language = $languageManager['language'];
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $id;
            $paramsRequest['type'] = $type;

            $modelPage = $this->modelInit;
            $paramsSend = $modelPage->getParamsPage([
                'page' => $nameProcess,
                'paramsRequest' => $paramsRequest

            ]);

            if ($paramsSend['viewPage']) {
                return view($renderView, $paramsSend);
            } else {
                return view('errors.modelsView.404', ['msg' => 'No existe informacion de esta Empresa.']);
            }

        } else {
            return view('errors.modelsView.404', ['msg' => 'No se envio los parametros correctos.']);

        }
    }


    public function categoriesSearchBee($language = 'es')
    {
        $model = new App\Models\BusinessCategories();
        $dataPost = Request::all();

        $result = $model->getCategoriesSearchBee($dataPost);
        return Response::json(
            $result
        );
    }


    public function blog($language = 'es')
    {
        $nameProcess = 'blog';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

//new
    public function contactUs($language = 'es')
    {
        $nameProcess = 'contactUs';
        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.contactUs';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function contactUsBee($language = 'es')
    {
        $nameProcess = 'contactUs';
        $renderView = self::LAYOUT_MAIN . '.web.contactUs';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    //new
    public function productFlowers($language = 'es')
    {
        $nameProcess = 'productFlowers';
        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.productFlowers';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    //new
    public function productProducts($language = 'es')
    {
        $nameProcess = 'productProducts';
        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.productProducts';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    //new
    public function productFrozen($language = 'es')
    {
        $nameProcess = 'productProducts';
        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.productProducts';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    //new
    public function productFruits($language = 'es')
    {
        $nameProcess = 'productFruits';
        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.productFruits';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    //new
    public function productBox($language = 'es')
    {
        $nameProcess = 'productBox';
        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.productBox';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    //new
    public function FAQ($language = 'es')
    {
        $nameProcess = 'contactUs';

        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.contactUs';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function howItWorks($language = 'es')
    {
        $nameProcess = 'howItWorks';
        $renderView = self::LAYOUT_MAIN . '.web.howItWorks';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function getDictionaryType($language = 'es', $type = -1)//CMS-TEMPLATE-MENU-CONTROLLER---KICHWA-CASTILIAN
    {
        $nameProcess = 'dictionaryType';
        $renderView = self::LAYOUT_MAIN . '.web.dictionaryType';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $dataPost = Request::all();

        $paramsRequest = $dataPost;
        $paramsRequest['type'] = $type;
        $paramsRequest['language'] = $language;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);

    }

    public function getDictionaryKichwaToCastilianAdmin()//CMS-TEMPLATE-MENU-CONTROLLER---KICHWA-CASTILIAN
    {

        $dataPost = Request::all();
        $model = new App\Models\Dictionary\DictionaryByWords();
        $result = $model->getDictionaryData($dataPost);

        return Response::json(
            $result
        );
    }

    public function getApuntesAdmin($language = 'es')//CMS-TEMPLATE-MENU-CONTROLLER---KICHWA-CASTILIAN
    {

        $dataPost = Request::all();
        $model = new App\Models\LanguageCourses\LanguageCourseBySection();
        $result = $model->getApuntesChaskishimiData($dataPost);

        return Response::json(
            $result
        );
    }

//new

    public function aboutUs($language = 'es')
    {
        $nameProcess = 'aboutUs';
        $project = self::PROJECT_NAME_FOLDER;
        $renderView = self::LAYOUT_MAIN . '.web.' . $project . '.aboutUs';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    //news
    public function rewards($language = 'es')
    {
        $nameProcess = 'rewards';

        $allowViewGaming = env('allowGaming');
        $renderView = $allowViewGaming ? self::LAYOUT_MAIN . '.web.rewards' : self::LAYOUT_MAIN . '.web.coming-soon';

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function aboutUsBee($language = 'es')
    {
        $nameProcess = 'aboutUs';
        $renderView = self::LAYOUT_MAIN . '.web.aboutUs';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function ourServicesBee($language = 'es')
    {
        $nameProcess = 'ourServicesBee';
        $renderView = self::LAYOUT_MAIN . '.web.ourServices';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }


    public function activities($language = 'es')
    {
        $nameProcess = 'activities';
        $allowViewGaming = env('allowGaming');
        $renderView = $allowViewGaming ? self::LAYOUT_MAIN . '.web.activities' : self::LAYOUT_MAIN . '.web.coming-soon';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function shopBee($language = 'es')
    {
        $nameProcess = 'shop';

        $allowViewGaming = env('allowGaming');
        $renderView = $allowViewGaming ? self::LAYOUT_MAIN . '.web.shop' : self::LAYOUT_MAIN . '.web.coming-soon';

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function authorSingle($language = 'es', $id = null)
    {
        $nameProcess = 'authorSingle';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['id'] = $id;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }


    public function pricing($language = 'es')
    {
        $nameProcess = 'pricing';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function dashboardMyProfile($language = 'es')
    {
        $nameProcess = 'dashboardMyProfile';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function blogSingle($language = 'es')
    {
        $nameProcess = 'blogSingle';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function dashboardMyProfileAddListing($language = 'es')
    {
        $nameProcess = 'dashboardMyProfileAddListing';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function comingSoon($language = 'es')
    {
        $nameProcess = 'comingSoon';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function header2($language = 'es')
    {
        $nameProcess = 'header2';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function footerFixed($language = 'es')
    {
        $nameProcess = 'footerFixed';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function listingSingle($language = 'es')
    {
        $nameProcess = 'listingSingle';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function listingSingle2($language = 'es')
    {
        $nameProcess = 'listingSingle2';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function listingSingle3($language = 'es')
    {
        $nameProcess = 'listingSingle3';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function listingSingle4($language = 'es')
    {
        $nameProcess = 'listingSingle4';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function listing5($language = 'es')
    {
        $nameProcess = 'listing5';
        $renderView = self::LAYOUT_MAIN . '.web.' . $nameProcess;
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $nameProcess,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    //ECCOMERCE
    public function productDetails($language = 'es', $id = null)
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        if ($id == null) {
            $renderView = "errors.modelsView.404";
            return view($renderView, ['error' => 'Parametros mal enviados.!']);

        } else {

            $renderView = self::LAYOUT_MAIN . '.web.productDetails';
            $modelPage = $this->modelInit;
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $id;
            $paramsSend = $modelPage->getParamsPage([
                'page' => 'productDetails',
                'productId' => $id,
                'paramsRequest' => $paramsRequest

            ]);
            return view($renderView, $paramsSend);
        }

    }

    public function cart($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $renderView = self::LAYOUT_MAIN . '.web.cart';
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'cart',
            'paramsRequest' => $paramsRequest
        ]);
        return view($renderView, $paramsSend);
    }

    public function checkout($language = 'es')
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];


        $renderView = self::LAYOUT_MAIN . '.web.checkout';

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'checkout',
            'paramsRequest' => $paramsRequest
        ]);
        return view($renderView, $paramsSend);
    }

    public function checkoutDetails($language = 'es', $id = null, $checkout = null)
    {
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        if ($id == null) {

            $renderView = "errors.modelsView.404";
            return view($renderView, ['error' => 'Parametros mal enviados.!']);

        } else {


            $renderView = self::LAYOUT_MAIN . '.web.checkoutDetails';

            $modelPage = $this->modelInit;
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $id;
            $paramsRequest['checkout'] = $checkout;

            $paramsSend = $modelPage->getParamsPage([
                'page' => 'checkoutDetails',
                'id' => $id,
                'paramsRequest' => $paramsRequest

            ]);
            return view($renderView, $paramsSend);
        }

    }

    public function presentationCard($language = 'es', $id = null, $type = 2)
    {
        if ($id) {
            $nameProcess = 'businessDetails';
            $renderView = self::LAYOUT_PRESENTATION_CARD . '.web.' . $nameProcess;
            $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
            $language = $languageManager['language'];
            $paramsRequest = [];
            $paramsRequest['language'] = $language;
            $paramsRequest['id'] = $id;
            $paramsRequest['type'] = $type;

            $modelPage = $this->modelInit;
            $paramsSend = $modelPage->getParamsPage([
                'page' => $nameProcess,
                'paramsRequest' => $paramsRequest

            ]);

            if ($paramsSend['viewPage']) {
                return view($renderView, $paramsSend);
            } else {
                return view('errors.modelsView.404', ['msg' => 'No existe informacion de esta Empresa.']);
            }

        } else {
            return view('errors.modelsView.404', ['msg' => 'No se envio los parametros correctos.']);

        }
    }

}
