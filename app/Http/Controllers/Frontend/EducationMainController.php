<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\EducationFrontendBaseController;
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

class EducationMainController extends EducationFrontendBaseController
{
    const LAYOUT_MAIN = 'frontend';

    public $modelInit = null;
    public $modelInitLanguage = null;

    public function __construct()
    {
        $this->modelInit = new App\Models\EducationFrontendManager();
        $this->modelInitLanguage = new App\Models\LanguageConfigManager();
    }


    public function index($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_MAIN_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.main.home';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'home',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function homePage($language = 'es', $type = 1)
    {

        $renderView = self::LAYOUT_MAIN . '.web.education.main.home';
        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;


        $modelPage = $this->modelInit;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_MAIN_ID;
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'homePage',
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);
    }

    public function arrayanes($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.main.arrayanes';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'arrayanes',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function aboutUsArrayanes($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.aboutUsArrayanes';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'aboutUsArrayanes',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function contactUsArrayanes($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;
        $renderView = self::LAYOUT_MAIN . '.web.education.contactUsArrayanes';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'contactUsArrayanes',
            'paramsRequest' => $paramsRequest

        ]);
        return view($renderView, $paramsSend);
    }

    public function newArrayanes($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $type = 1;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;
        $paramsRequest['id'] = $id;
        $renderView = self::LAYOUT_MAIN . '.web.education.newArrayanes';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'newArrayanes',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function profileArrayanes($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $type = 1;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;
        $paramsRequest['id'] = $id;

        $renderView = self::LAYOUT_MAIN . '.web.education.profileArrayanes';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'profileArrayanes',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function historyArrayanes($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $type = 1;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;
        $paramsRequest['id'] = $id;

        $renderView = self::LAYOUT_MAIN . '.web.education.historyArrayanes';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'historyArrayanes',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function alamos($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.main.alamos';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'alamos',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function aboutUsAlamos($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.aboutUsAlamos';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'aboutUsAlamos',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function contactUsAlamos($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.contactUsAlamos';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'contactUsAlamos',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function profileAlamos($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $type = 1;
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;
        $paramsRequest['id'] = $id;
        $renderView = self::LAYOUT_MAIN . '.web.education.profileAlamos';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'profileAlamos',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function newAlamos($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $type = 1;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;
        $paramsRequest['id'] = $id;

        $renderView = self::LAYOUT_MAIN . '.web.education.newAlamos';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'newAlamos',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function preescolar($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.main.preescolar';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'preescolar',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function aboutUsPreescolar($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.aboutUsPreescolar';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'aboutUsPreescolar',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function contactUsPreescolar($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;

        $renderView = self::LAYOUT_MAIN . '.web.education.contactUsPreescolar';

        $paramsSend = $modelPage->getParamsPage([
            'page' => 'contactUsPreescolar',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function newPreescolar($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $type = 1;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;
        $paramsRequest['id'] = $id;
        $renderView = self::LAYOUT_MAIN . '.web.education.newPreescolar';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'newPreescolar',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function profilePreescolar($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $type = 1;
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;
        $paramsRequest['id'] = $id;
        $renderView = self::LAYOUT_MAIN . '.web.education.profilePreescolar';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'profilePreescolar',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function historyPreescolar($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $type = 1;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;
        $paramsRequest['id'] = $id;

        $renderView = self::LAYOUT_MAIN . '.web.education.historyPreescolar';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'historyPreescolar',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function historyAlamos($language = 'es', $id)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $type = 1;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;
        $paramsRequest['id'] = $id;

        $renderView = self::LAYOUT_MAIN . '.web.education.historyAlamos';
        $paramsSend = $modelPage->getParamsPage([
            'page' => 'historyAlamos',
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function sendMailEducation()
    {
        $mail = new EmailUtil();
        $dataPost = Request::all();
        $mail = new EmailUtil();
        $dataPost = Request::all();
        $dataCurrent = $dataPost;

        $data = [
            'contactSubject' => 'Contactarse con Institucion',
            'customerPage' => $dataPost['customerPage'],
            'customerName' => $dataPost['name'] . '' . $dataPost['last-name'],
            'customerEmail' => $dataPost['email'],
            'contactMessage' => $dataPost['message'],

        ];
        $typePage = $dataPost['typePage'];
        $business_id = $dataPost['business_id'];
        $result = [];

        $result = $mail->sendMailByPages([
            'typePage' => $typePage,
            'business_id' => $business_id,
            'dataMessage' => $data,
            'typeTemplate' => 'contactUsForm'

        ]);


        return $result;
    }

    public function frequentQuestionArrayanes($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;
        $pageCurrent = 'frequentQuestionArrayanes';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $pageCurrent;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $pageCurrent,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function frequentQuestionPreescolar($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;
        $pageCurrent = 'frequentQuestionPreescolar';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $pageCurrent;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $pageCurrent,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function frequentQuestionAlamos($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;
        $pageCurrent = 'frequentQuestionAlamos';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $pageCurrent;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $pageCurrent,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function requirementsArrayanes($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];
        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;
        $pageCurrent = 'requirementsArrayanes';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $pageCurrent;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $pageCurrent,
            'paramsRequest' => $paramsRequest
        ]);

        return view($renderView, $paramsSend);
    }

    public function requirementsPreescolar($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;
        $pageCurrent = 'requirementsPreescolar';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $pageCurrent;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $pageCurrent,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }

    public function requirementsAlamos($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;
        $pageCurrent = 'requirementsAlamos';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $pageCurrent;
        $paramsSend = $modelPage->getParamsPage([
            'page' => $pageCurrent,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }


    public function academicOfferingArrayanes($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_ONE_ID;
        $managementAction = 'academicOfferingArrayanes';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $managementAction;

        $paramsSend = $modelPage->getParamsPage([
            'page' => $managementAction,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }
    public function academicOfferingAlamos($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_TWO_ID;
        $managementAction = 'academicOfferingAlamos';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $managementAction;

        $paramsSend = $modelPage->getParamsPage([
            'page' => $managementAction,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }
    public function academicOfferingPreescolar($language = 'es', $type = 1)
    {

        $languageManager = $this->modelInitLanguage->managerLanguagePage($language);
        $language = $languageManager['language'];

        $modelPage = $this->modelInit;
        $paramsRequest = [];
        $paramsRequest['language'] = $language;
        $paramsRequest['type'] = $type;
        $paramsRequest['business_id'] = $modelPage::BUSINESS_THREE_ID;
        $managementAction = 'academicOfferingPreescolar';
        $renderView = self::LAYOUT_MAIN . '.web.education.' . $managementAction;

        $paramsSend = $modelPage->getParamsPage([
            'page' => $managementAction,
            'paramsRequest' => $paramsRequest

        ]);

        return view($renderView, $paramsSend);
    }
}
