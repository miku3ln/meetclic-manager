<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Business;
use App\Models\BusinessByRoutesMap;
use App\Models\RouteMapByAdventureTypes;
use App\Models\RoutesMap;
use App\Models\RoutesMapByRoutesDrawing;
use App\Models\TemplateBySource;
use App\Models\Whatsapp\WhatsappConfigs;
use App\Utils\TrackingUtil;
use Illuminate\Http\Request;

class FrontendPagesOwnerCmsController extends Controller
{
    public function businessOwner(Request $request)
    {
        $slug = $request->route('slug');
        $section = $request->route('section');

        $dataModelBRR = BusinessByRoutesMap::find(1);
        $logoHtmlMeetclic = "";
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }

        $paramsSend = [
            "gamificationDataTask" => [],
            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section
        ];
        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.mikuy-yachak', $paramsSend);
    }

    public function chasqui($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = BusinessByRoutesMap::find($id);

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);

        $logoHtmlMeetclic = "";
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }
        if ($dataModelBRR) {
            $business_id = $dataModelBRR->business_id;
            $routes_map_id = $dataModelBRR->routes_map_id;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));
            $modelRMBRD = new RoutesMapByRoutesDrawing();
            $routes_drawing_data = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
            $routesDrawingGroup = $modelRMBRD->getRoutesDrawingGroupedBySubcategory(["rows" => $routes_drawing_data]);
            $routesDrawingGroupHtml = $modelRMBRD->getRoutesDrawingStatsHtml(["grouped" => $routesDrawingGroup]);


            $business_by_routes_map_id = $id;
            $modelRMBAT = new RouteMapByAdventureTypes();
            $adventure_type_data = $modelRMBAT->getAdventureTypes(array("business_by_routes_map_id" => $business_by_routes_map_id));
            $modelInformation = RoutesMap::find($routes_map_id);
            $information = array();
            if ($modelInformation) {
                $information = $modelInformation->getAttributes();
            }
            $modelWhats = new WhatsappConfigs();
            $dataPhoneWhatsapp = $modelWhats->getConfigsByBusinessAndSection(["businessId" => $business_id, "sectionId" => 9]);
            $variables = [
                'name_chasqui' => $information["name"],
            ];
            $urlWhatsapp = $modelWhats->generateFromConfig($dataPhoneWhatsapp, $variables);
            $dataPhoneWhatsapp["urlWhatsapp"] = $urlWhatsapp;
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                    //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(
                "information" => $information,
                'socialNetwork' => $resultCurrentData,
                "routes_drawing_data" => $routes_drawing_data,
                "routesDrawingGroup" => $routesDrawingGroup,
                "adventure_type_data" => $adventure_type_data,
                "routesDrawingGroupHtml" => $routesDrawingGroupHtml,

            );
            $dataBusiness["dataPhoneWhatsapp"] = $dataPhoneWhatsapp;
        }

        $paramsSend = [
            "gamificationDataTask" => [],
            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]
        ];

        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.chasqui-nian-business', $paramsSend);
    }

    public function getParamsPage($params)
    {
        $type = 1;
        $request = request();
        $route = $request->route();
        $routeName = $route->getName();
        $tracking = new TrackingUtil();

        $gamificationDataTask = ["success" => false, "type" => 96, "message" => "No existe configuracion para esta url en yapitas"];


        if (!in_array($routeName, ["ourAllies","authorSingle","contactUsBee", "traductor", "diccionario", "apuntes", "yachashun", "ricksichishun", "howItWorks", "homeBackLine", "bee", "aboutUsBee", "reviewsTo", "pointsSales", "boardingEmbarkation",


            "boarding-embarkation-management", "orders", "listingsQueen", "businessEmployer", "business", "managerProductBusiness", "homeIndexFrontend", "getAdminGamificationFrontend", "myProfile", "profileAccount", "password", "suggestionsMailBox"])) {
            if ($request->isMethod('get')) {

                $resultTracking = $tracking->managerGamingTask($request, $type);
                $gamificationDataTask = $resultTracking;
            }
        } else {

        }

        return $gamificationDataTask;
    }

    public function rimayByBusiness($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = true;

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
        $logoHtmlMeetclic = "";
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }
        if ($dataModelBRR) {
            $business_id = 1;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));


            $modelWhats = new WhatsappConfigs();
            $dataPhoneWhatsapp = $modelWhats->getConfigsByBusinessAndSection(["businessId" => $business_id, "sectionId" => 9]);
            $variables = [
                'nameForm' => "hol",
            ];
            $urlWhatsapp = $modelWhats->generateFromConfig($dataPhoneWhatsapp, $variables);
            $dataPhoneWhatsapp["urlWhatsapp"] = $urlWhatsapp;
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                    //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(

                'socialNetwork' => $resultCurrentData,

            );
            $dataBusiness["dataPhoneWhatsapp"] = $dataPhoneWhatsapp;
        }

        $paramsSend = [
            "gamificationDataTask" => [],
            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]

        ];
        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.rimay-business', $paramsSend);
    }

    public function suggestionsMailBoxByBusiness($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = true;

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
        $logoHtmlMeetclic = "";
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }
        if ($dataModelBRR) {
            $business_id = 1;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));


            $modelWhats = new WhatsappConfigs();
            $dataPhoneWhatsapp = $modelWhats->getConfigsByBusinessAndSection(["businessId" => $business_id, "sectionId" => 9]);
            $variables = [
                'nameForm' => "hol",
            ];
            $urlWhatsapp = $modelWhats->generateFromConfig($dataPhoneWhatsapp, $variables);
            $dataPhoneWhatsapp["urlWhatsapp"] = $urlWhatsapp;
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                    //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(

                'socialNetwork' => $resultCurrentData,

            );
            $dataBusiness["dataPhoneWhatsapp"] = $dataPhoneWhatsapp;
        }


        $paramsSend = [
            "gamificationDataTask" => [],
            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]

        ];
        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.rimay-business', $paramsSend);
    }

    public function shopByBusiness($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = true;

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
        $logoHtmlMeetclic = "";
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }
        if ($dataModelBRR) {
            $business_id = 1;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));
            $modelWhats = new WhatsappConfigs();
            $dataPhoneWhatsapp = $modelWhats->getConfigsByBusinessAndSection(["businessId" => $business_id, "sectionId" => 9]);
            $variables = [
                'nameForm' => "hol",
            ];
            $urlWhatsapp = $modelWhats->generateFromConfig($dataPhoneWhatsapp, $variables);
            $dataPhoneWhatsapp["urlWhatsapp"] = $urlWhatsapp;
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                    //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(
                'socialNetwork' => $resultCurrentData,
            );
            $dataBusiness["dataPhoneWhatsapp"] = $dataPhoneWhatsapp;
        }


        $paramsSend = [
            "gamificationDataTask" => [],
            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]


        ];
        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.shop-business', $paramsSend);
    }

    public function rimayRegistersByBusiness($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = true;

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
        $logoHtmlMeetclic = "";
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }
        if ($dataModelBRR) {
            $business_id = 1;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));


            $modelWhats = new WhatsappConfigs();
            $dataPhoneWhatsapp = $modelWhats->getConfigsByBusinessAndSection(["businessId" => $business_id, "sectionId" => 9]);
            $variables = [
                'nameForm' => "hol",
            ];
            $urlWhatsapp = $modelWhats->generateFromConfig($dataPhoneWhatsapp, $variables);
            $dataPhoneWhatsapp["urlWhatsapp"] = $urlWhatsapp;
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                    //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(

                'socialNetwork' => $resultCurrentData,

            );
            $dataBusiness["dataPhoneWhatsapp"] = $dataPhoneWhatsapp;
        }

        $paramsSend = [
            "gamificationDataTask" => [],

            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]


        ];
        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.rimay-registers-business', $paramsSend);
    }

    public function rewardsRegistersByBusiness($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = true;

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
        $logoHtmlMeetclic = "";
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }
        if ($dataModelBRR) {
            $business_id = 1;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));


            $modelWhats = new WhatsappConfigs();
            $dataPhoneWhatsapp = $modelWhats->getConfigsByBusinessAndSection(["businessId" => $business_id, "sectionId" => 9]);
            $variables = [
                'nameForm' => "hol",
            ];
            $urlWhatsapp = $modelWhats->generateFromConfig($dataPhoneWhatsapp, $variables);
            $dataPhoneWhatsapp["urlWhatsapp"] = $urlWhatsapp;
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                    //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(

                'socialNetwork' => $resultCurrentData,

            );
            $dataBusiness["dataPhoneWhatsapp"] = $dataPhoneWhatsapp;
        }

        $paramsSend = [
            "gamificationDataTask" => [],

            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]


        ];
        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.rewards-registers-business', $paramsSend);
    }

    public function ratesRegistersByBusiness($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = true;

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
        $logoHtmlMeetclic = "";
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }
        if ($dataModelBRR) {
            $business_id = 1;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));


            $modelWhats = new WhatsappConfigs();
            $dataPhoneWhatsapp = $modelWhats->getConfigsByBusinessAndSection(["businessId" => $business_id, "sectionId" => 9]);
            $variables = [
                'nameForm' => "hol",
            ];
            $urlWhatsapp = $modelWhats->generateFromConfig($dataPhoneWhatsapp, $variables);
            $dataPhoneWhatsapp["urlWhatsapp"] = $urlWhatsapp;
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                    //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(

                'socialNetwork' => $resultCurrentData,

            );
            $dataBusiness["dataPhoneWhatsapp"] = $dataPhoneWhatsapp;
        }


        $paramsSend = [
            "gamificationDataTask" => [],

            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]


        ];
        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.rates-registers-business', $paramsSend);
    }

    public function rateRegisterByBusiness($id = null)
    {
        $slug = "";
        $section = "";

        $dataModelBRR = true;

        $business_id = null;
        $routes_map_id = null;
        $allow = false;
        $dataBusiness = null;
        $dataRoute = null;
        $modelTBS = new TemplateBySource();
        $template_information_id = 1;
        $filtersManager = [
            'filters' => [
                "template_information_id" => $template_information_id
            ]
        ];
        $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
        $logoHtmlMeetclic = "";
        if ($resultResources["logoMain"]) {
            $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

            $data = $resultResources["logoMain"];
            $logoHtmlMeetclic .= '<div class="main-header">';
            $rootUrl = route("homePage");
            $logoHtmlMeetclic .= ' <a href="' . $rootUrl . '">  <img  id="main-header__logo" src="' . URL($resourcePathServer . $data->source) . '" class="img-fluid" alt=""></a>';
            $logoHtmlMeetclic .= '</div>';

        }
        if ($dataModelBRR) {
            $business_id = 1;
            $allow = true;
            $model = new Business();
            $dataBusiness = $model->getBusinessData(array("id" => $business_id));


            $modelWhats = new WhatsappConfigs();
            $dataPhoneWhatsapp = $modelWhats->getConfigsByBusinessAndSection(["businessId" => $business_id, "sectionId" => 9]);
            $variables = [
                'nameForm' => "hol",
            ];
            $urlWhatsapp = $modelWhats->generateFromConfig($dataPhoneWhatsapp, $variables);
            $dataPhoneWhatsapp["urlWhatsapp"] = $urlWhatsapp;
            $modelManager = new \App\Models\InformationSocialNetwork();
            $entity_id = $business_id;
            $resultCurrentData = $modelManager->getInformationData([
                'filters' => [
                    'state' => $modelManager::STATE_ACTIVE,
                    'main' => $modelManager::MAIN,
                    'entity_type' => $modelManager::ENTITY_TYPE_BUSINESS,
                    //    'information_social_network_type_id' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                    'entity_id' => $entity_id,
                ]
            ]);
            $dataRoute = array(

                'socialNetwork' => $resultCurrentData,

            );
            $dataBusiness["dataPhoneWhatsapp"] = $dataPhoneWhatsapp;
        }

        $paramsSend = [
            "gamificationDataTask" => [],

            'slug' => $slug,
            "logoHtmlMeetclic" => $logoHtmlMeetclic,
            'section' => $section,
            'dataManager' => [
                'allow' => $allow,
                'business' => $dataBusiness,
                'dataRoute' => $dataRoute,

            ]


        ];
        $paramsSend["gamificationDataTask"] = $this->getParamsPage([]);
        $paramsSend["TASK_TOAST"] =  TrackingUtil::TASK_TOAST;

        return view('cityBook.web.businessOwner.rate-register-business', $paramsSend
        );
    }
}
