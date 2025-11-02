<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\FrontendBaseController;
use App\Models\FrontendCityBookManager;
use App\Models\FrontendManager;
use App;
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

class ChaskishimiController extends FrontendBaseController
{
    const LAYOUT_MAIN = 'chaskishimi';
    const PROJECT_NAME_FOLDER = "";

    public $modelInit = null;
    public $modelInitLanguage = null;
    public $typeTemplate = null;

    public function __construct()
    {
        $this->modelInit = new FrontendCityBookManager();
        $this->modelInitLanguage = new App\Models\LanguageConfigManager();

    }



    public function index($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {



        $renderView = self::LAYOUT_MAIN . '.web.homePage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>2
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'homeChaskiPage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }

    public function yachaSun($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {



        $renderView = self::LAYOUT_MAIN . '.web.yachasunPage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>2
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'yachasunPage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }
    public function apuntes($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {



        $renderView = self::LAYOUT_MAIN . '.web.apuntesPage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>2
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'apuntesPage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }
    public function diccionario($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {



        $renderView = self::LAYOUT_MAIN . '.web.diccionarioPage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>2
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'diccionarioPage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }
    public function traductor($language = 'es', $type = 1)//MAIN HOME CMS-TEMPLATE-home
    {



        $renderView = self::LAYOUT_MAIN . '.web.traductorPage';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [
            'template_information_id'=>2
        ];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;

        $modelPage = $this->modelInit;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'traductorPage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);

    }

}
