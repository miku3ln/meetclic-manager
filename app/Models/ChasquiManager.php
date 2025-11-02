<?php

namespace App\Models;

use App\Utils\ChasquiPageSections;
use Auth;
use Chasqui;
use Illuminate\Support\Facades\DB;
use Route;


//chasqui

class ChasquiManager extends ModelManager
{
    const BUSINESS_ID = 1;
    public $resourcePathServer = '';
    public $languageData = [
        'en', 'es', 'ki'

    ];
    public $routeMaine = 'chasqui';

    public function getLanguageValid($languagePost)
    {
        $languageCurrent = $languagePost;
        $language = 'es';
        if ($languageCurrent == '' || $languageCurrent == null || in_array($language, $this->languageData) == false) {
            $language = 'es';
        } else {
            $language = $languageCurrent;
        }
        return $language;

    }

    function __construct()
    {
        $this->resourcePathServer = env('APP_IS_SERVER') ? "public" : '';
    }

    public function getParamsPage($params)
    {
        $page = $params['page'];
        $paramsRequest = $params['paramsRequest'];

        $modelCBP = new CustomerByProfile();
        $user = Auth::user();

        $profileConfig = $modelCBP->getProfileUser(['user'=>$user]);

        $result = [];
        $modelB = new Business();
        $modelCategories = ChasquiPageSections::PROJECT_TYPE_EVENT ? new EventsTrailsTypes() : new ProductCategory();
        $modelT = new TemplateInformation();
        $entity_id = self::BUSINESS_ID;
        $business_id = $entity_id;
        $entity_type_business = 4;
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => $entity_id));
        $dataSliderHtml = '';
        $dataSocialNetworksHtml = '';
        $dataFooter = array();
        $allowTemplate = false;
        $template_information_id = null;
        $dataMenu = array();
        $socialNetworkShop = '';
        $socialNetworkMenuMobile = '';
        $dataSocialNetworksContactUsHtml = '';
        $language = $paramsRequest['language'];

        $this->setLanguage($language);
        $dataManagerPage = [];
        $dataManagerPage['header'] = ChasquiPageSections::getPageHeaderConfig([
            'page' => $page
        ]);

        $dataManagerPage['currentPage'] = $page;

        $dataManagerPage['profileConfig'] = $profileConfig;
        $dataManagerPage['sectionPage']['formContactUs'] = ChasquiPageSections::getPageContactFormConfig([
            'page' => $page,
            'getData' => $templateInformation != false,
            'business_id' => $business_id,

        ]);;

        $dataManagerPage['sectionPage']['parentHtml'] = '';
        $dataManagerPage['sectionPage']['childrenHtml'] = '';
        $dataManagerPage['language'] = $language;

        $dataManagerPage['countWishList'] = 0;
        $dataManagerPage['paramsRequest'] = $paramsRequest;
        $dataManagerPage['policies'] = ['data' => [], 'onlyPolicies' => '<p>No existe Gestion de Politicas</p>'];

        //allow shop
        $dataManagerPage['shopConfig'] = [
            'allow' => false,
            'data' => []
        ];

        $dataBusiness = $modelB->getBusinessFrontend([
            'filters' => [
                'business_id' => $entity_id
            ]
        ]);
        $allowBusiness = ($dataBusiness != false ? true : false);
        $pageSectionsConfig = [
            'alliedBrands' => ['allow' => ChasquiPageSections::ALLIED_BRANDS_ALLOW],
            'policies' => ['allow' => ChasquiPageSections::POLICIES_ALLOW, "data" => [], 'msj' => 'No existe valores Gestionados.!', 'view' => false],
            'terms' => ['allow' => ChasquiPageSections::TERMS_ALLOW, "data" => [], 'msj' => 'No existe valores Gestionados.!', 'view' => false],
            'use-full-link' => ['view' => false],
            'business' => ['view' => $allowBusiness, 'data' => $dataBusiness],
            'contactTop' => [
                'language' => [
                    'view' => false,
                    'msj' => 'No existe Idiomas Configurados.'
                ]
            ],
            'head' => [
                'metaData' => [
                    'html' => '',
                    'view' => false
                ],
                'business' => [
                    'data' => null,
                    'view' => false
                ]
            ]

        ];

        $pageSectionsConfig['cookies'] = ChasquiPageSections::getPageCookies([
            'page' => $page
        ]);


        if ($allowBusiness) {

            $pageSectionsConfig['head']['business']['data'] = $dataBusiness;
            $pageSectionsConfig['head']['business']['view'] = true;
            $sectionName = 'contactTop';
            $subSectionName = 'language';
            $modelBBL = new BusinessByLanguage;
            $dataLanguages = $modelBBL->getLanguageAllFrontend([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            $allowMain = false;
            $msj = 'No existe un Idioma Principal.';
            foreach ($dataLanguages as $key => $row) {
                if ($row->main == 1) {
                    $allowMain = true;
                    $msj = 'Listo para ver Idiomas';
                }
            }
            $pageSectionsConfig[$sectionName][$subSectionName]['view'] = $allowMain;
            $pageSectionsConfig[$sectionName][$subSectionName]['msj'] = $msj;
            if ($allowMain) {
                $dataManagerPage['languageHeader'] = $this->getLanguageMenu(
                    [
                        'paramsRequest' => $paramsRequest,
                        'dataLanguages' => $dataLanguages
                    ]
                );
            }

        } else {
            $dataManagerPage['languageHeader'] = '';
        }


        if ($templateInformation != false) {

            $modelTP = new TemplatePolicies();
            $allowTemplate = true;
            $template_information_id = $templateInformation->id;
            $filtersManager = [
                'filters' => [
                    'template_information_id' => $template_information_id,
                    'typeData' => [ChasquiPageSections::POLICIES_TYPE, ChasquiPageSections::TERM_TYPE]
                ]
            ];
            $dataRows = $modelTP->getPoliciesFrontend($filtersManager);
            if (!empty($dataRows)) {


                $pageSectionsConfig['use-full-link']['view'] = true;
                $onlyPolicies = '<div class="policies payments-p"  style="display: none;">';
                foreach ($dataRows as $key => $value) {
                    $onlyPolicies .= '<h3>' . ($value->value) . '</h3>';
                    $onlyPolicies .= '<h4>' . ($value->subtitle) . '</h4>';
                    $onlyPolicies .= '<div class="policies-description">' . ($value->description) . '</div>';
                    $type = $value->type;
                    if ($type == ChasquiPageSections::POLICIES_TYPE) {
                        $pageSectionsConfig['policies']['view'] = true;
                        $pageSectionsConfig['policies']['data'] = $value;

                    } else if ($type == ChasquiPageSections::TERM_TYPE) {
                        $pageSectionsConfig['terms']['view'] = true;
                        $pageSectionsConfig['terms']['data'] = $value;

                    }
                }

                $onlyPolicies .= '</div>';
                $dataManagerPage['policies']['onlyPolicies'] = $onlyPolicies;

            }


            $modelISN = new InformationSocialNetwork();
            $dataSocialNetwork = $modelISN->getAllFrontend([
                'filters' => [
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type_business
                ]]);
            if (count($dataSocialNetwork) > 0) {

                $dataSocialNetworksHtml = Chasqui::getHtmlSocialNetwork([
                    'data' => $dataSocialNetwork,
                    'type' => 'footer',
                    'title' => 'Siguenos.',
                    "resourcePathServer" => $this->resourcePathServer
                ]);

                $socialNetworkMenuMobile = Chasqui::getHtmlSocialNetwork([
                    'data' => $dataSocialNetwork,
                    'type' => 'menu-mobile',
                    'title' => 'Please view our FAQ to find answers to your questions or send us an email for general questions! Due to unexpected volumes, it is taking us a little longer than we would like to respond to emails. Our current email response time is 3 business days.',
                    "resourcePathServer" => $this->resourcePathServer
                ]);
                $socialNetworkShop = Chasqui::getHtmlSocialNetwork([
                    'data' => $dataSocialNetwork,
                    'type' => 'menu-shop',
                    'title' => 'SHARE ON',
                    "resourcePathServer" => $this->resourcePathServer
                ]);
                if ($page == 'contactUs') {
                    $dataSocialNetworksContactUsHtml = Chasqui::getHtmlSocialNetwork([
                        'data' => $dataSocialNetwork,
                        'type' => 'contact-us',
                        'title' => 'Please view our FAQ to find answers to your questions or send us an email for general questions! Due to unexpected volumes, it is taking us a little longer than we would like to respond to emails. Our current email response time is 3 business days.'
                        ,
                        "resourcePathServer" => $this->resourcePathServer
                    ]);
                }
            }


            $modelTCP = new TemplateChatApi();
            $resultChat = $modelTCP->getChatsTypesData($filtersManager);
            if ($resultChat['facebook'] != false) {
                $dataManagerPage['chat'] = Chasqui::getHtmlChat([
                    'data' => $resultChat['facebook'],
                    "resourcePathServer" => $this->resourcePathServer
                ]);
            }
            $modelTBS = new TemplateBySource();
            $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
            if ($resultResources['logoMain'] != false) {
                $dataManagerPage['logoMain'] = Chasqui::getHtmlLogoHeader([
                    'data' => $resultResources['logoMain'],
                    'page' => $page,
                    "resourcePathServer" => $this->resourcePathServer
                ]);
                $dataManagerPage['logoMainMobile'] = Chasqui::getHtmlLogoHeaderMobile([
                    'data' => $resultResources['logoMain'],
                    'page' => $page,
                    "resourcePathServer" => $this->resourcePathServer

                ]);
            }
            if ($resultResources['favicon'] != false) {
                $dataManagerPage['favicon'] = Chasqui::getHtmlFaviconHeader([
                    'data' => $resultResources['favicon'],
                    "resourcePathServer" => $this->resourcePathServer
                ]);

            }
            $dataFooter['socialNetwork'] = $dataSocialNetworksHtml;
            $dataMenu['socialNetworkShop'] = $socialNetworkShop;
            $dataMenu['socialNetworkMenuMobile'] = $socialNetworkMenuMobile;

            $modelTP = new TemplatePayments();
            $filtersManager['filters']['status'] = 'ACTIVE';
            $dataPaymentsConfig = $modelTP->getTypesPaymentsData($filtersManager);
            if ($dataPaymentsConfig['api-credit-cards'] || $dataPaymentsConfig['pay-pal'] || $dataPaymentsConfig['bank-deposit']) {
                $dataManagerPage['shopConfig'] = [
                    'allow' => true,
                    'data' => $dataPaymentsConfig
                ];
            }


            if ($profileConfig['success']) {
                $user_id = $profileConfig['data']['user']->id;
                $filters = ['filters' => [

                    'template_information_id' => $template_information_id,
                    'user_id' => $user_id,

                ]];
                $model = new TemplateWishListByUser();
                $dataManagerPage['countWishList'] = $model->getProductsWishListCount($filters);
            }


        } else {
            $dataFooter['socialNetwork'] = '';
            $dataMenu['socialNetworkShop'] = '';
            $dataMenu['socialNetworkMenuMobile'] = '';
        }

        if ($page == 'chasqui') {
            $model = new Business();
            $modelS = new BusinessSubcategories();
            $categories = $modelS->getCategoriesSearch();

            /*Config*/
            $moduleMain = "chasqui";
            $moduleResource = "manager";
            $moduleFolder = "nianes";
            $user = Auth::user();
            $pathCurrent = "$moduleMain/$moduleFolder";

            $model_entity = "chasqui";
            $dataBusiness = $model->getAllBusiness();
            $configFirebase = "";
            $dataManagerPage['viewData'] = [
                "model_entity" => $model_entity,
                "name_manager" => 'Negocio',
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

        } else if ($page == 'routeView') {
            $id = $params['id'];
            $model = new Business();
            $moduleMain = "chasqui";
            $moduleResource = "manager";
            $moduleFolder = "routeView";
            $model_entity = "routeView";

            $attributesPost = [];
            $paramsUser = array(
                "business_by_routes_map_id" => $id,
                "attributesPost" => $attributesPost
            );
            /*Config*/
            $user = Auth::user();
            $pathCurrent = "$moduleMain/$moduleFolder";
            $dataModelBRR = \App\Models\BusinessByRoutesMap::find($id);

            $business_id = null;
            $routes_map_id = null;
            if ($dataModelBRR) {
                $business_id = $dataModelBRR->business_id;
                $routes_map_id = $dataModelBRR->routes_map_id;
            }

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

            $modelRMBRD = new \App\Models\RoutesMapByRoutesDrawing();
            $routes_drawing_data = $modelRMBRD->getRoutesDrawing(array("routes_map_id" => $routes_map_id));
            $business_by_routes_map_id = $id;
            $modelRMBAT = new \App\Models\RouteMapByAdventureTypes();

            $adventure_type_data = $modelRMBAT->getAdventureTypes(array("business_by_routes_map_id" => $business_by_routes_map_id));

            $modelInformation = \App\Models\RoutesMap::find($routes_map_id);
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
                "name_manager" => 'Hola',
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
            $dataManagerPage['viewData'] = $paramsSend;
        }


        $result['dataFooter'] = $dataFooter;
        $result['dataManagerPage'] = $dataManagerPage;
        $result['dataMenu'] = $dataMenu;
        $result['pageSectionsConfig'] = $pageSectionsConfig;
        $result["resourceRoot"] = URL($this->resourcePathServer);

        return $result;

    }

    public function setLanguage($languagePost)
    {

        $language = $this->getLanguageValid($languagePost);

        \App::setLocale($language);
    }

    public function getLanguageMenu($params)
    {

        $nameRoute = Route::currentRouteName();
        $language = $params['paramsRequest']['language'];

        $dataLanguages = $params['dataLanguages'];
        $menuCurrent = '  <div class="header-top-dropdown">' . "\n";
        $menuLanguage = [];
        $languageCurrent = null;
        foreach ($dataLanguages as $key => $row) {
            if ($row->initials != $language) {

                $menuLanguage[] = $row;
            } else {
                $languageCurrent = $row;
            }
        }


        $menuCurrent .= '   <a >' . $languageCurrent->text . ' <i class="pe-7s-angle-down"></i></a>' . "\n";
        $menuCurrent .= '    <ul class="header-top-dropdown__list">' . "\n";

        foreach ($menuLanguage as $key => $row) {
            $urlSetLanguage = '';
            if ($nameRoute == 'chasqui.chasqui') {
                $urlSetLanguage = url($this->routeMaine . '/' . $row->initials . '/nianes');

            } else if ($nameRoute == 'chasqui.routeView') {
                $urlSetLanguage = url($this->routeMaine . '/' . $row->initials . '/routeView');

            }


            $menuCurrent .= '           <li><a href="' . $urlSetLanguage . '">' . $row->text . '</a></li>' . "\n";

        }

        $menuCurrent .= '    </ul>';
        $menuCurrent .= '    </div>' . "\n";

        $result['menuLanguage'] = $menuCurrent;
        $result['language'] = $language;

        return $result;
    }


    public function addWishListProduct($params)
    {
        $success = false;
        $msj = "";
        $result = array();
        $attributesPost = $params["attributesPost"];
        $errors = array();
        $data = [];
        DB::beginTransaction();
        try {
            $user = Auth::user();

            if ($user) {
                $modelT = new TemplateInformation();
                $business_id = self::BUSINESS_ID;
                $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => $business_id));
                if ($templateInformation != false) {

                    $attributesSet = [];
                    $modelName = 'TemplateWishListByUser';
                    $templateWishListByUserData = $attributesPost[$modelName];
                    $template_information_id = $templateInformation->id;
                    $product_id = $templateWishListByUserData['product_id'];
                    $user_id = $user->id;

                    $allowDelete = false;
                    $validateResult = [];
                    $model = new TemplateWishListByUser();
                    $filters = ['filters' => [
                        'product_id' => $product_id,
                        'template_information_id' => $template_information_id,
                        'user_id' => $user_id,

                    ]];
                    $modelData = $model->getProductWishList($filters);

                    if ($modelData != false) {

                        $modelData = TemplateWishListByUser::find($modelData->id);
                        $modelData->delete();
                        $success = true;
                        $allowDelete = true;

                    } else {

                        $attributesSet = $model->getValuesModel(array('fillAble' => $this->fillable, 'haystack' => $templateWishListByUserData, 'attributesData' => $this->attributesData));
                        $attributesSet['user_id'] = $user_id;
                        $attributesSet['template_information_id'] = $template_information_id;
                        $attributesSet['status'] = 'ACTIVE';
                        $attributesSet['product_id'] = $product_id;

                        $paramsValidate = array(
                            'inputs' => $attributesSet,
                            'rules' => $model->getRulesModel(),

                        );
                        $validateResult = $model->validateModel($paramsValidate);
                        $success = $validateResult["success"];

                    }
                    if ($success) {
                        if (!$allowDelete) {

                            $model->fill($attributesSet);
                            $success = $model->save();
                            $msj = "Agregado Correctamente.";
                        }
                        $data['countWishList'] = $model->getProductsWishListCount($filters);
                        $data['allowDelete'] = $allowDelete;
                    } else {
                        if (!$allowDelete) {
                            $success = false;
                            $msj = "Problemas al Agregar a la lista.";
                            $errors = $validateResult["errors"];
                        }

                        $data['countWishList'] = $model->getProductsWishListCount($filters);
                        $data['allowDelete'] = $allowDelete;
                    }
                } else {
                    $success = false;
                    $msj = "Plantilla no asignada a una empresa.";
                }


            } else {
                $success = false;
                $msj = "No se encuentra logeado.";

            }

            if (!$success) {
                DB::rollBack();

            } else {

                DB::commit();
            }
            $result = [
                "errors" => $errors,
                "msj" => $msj,
                "success" => $success,
                'data' => $data
            ];


            return ($result);
        } catch (Exception $e) {

            $msj = $e->getMessage();
            $result = array(
                "success" => $success,
                "msj" => $msj,
                "errors" => $errors,
                'data' => $data
            );
            return ($result);
        }

    }

}
