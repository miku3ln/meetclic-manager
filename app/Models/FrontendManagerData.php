<?php

namespace App\Models;

use App\Utils\FrontendPageSections;
use Auth;
use Frontend;
use Illuminate\Support\HtmlString;
use Route;


class FrontendManagerData extends ModelManager
{
    const BUSINESS_ID = 1;//MANAGER MAIN BUSINESS
    public $resourcePathServer = '';

    function __construct()
    {
        $this->resourcePathServer = env('APP_IS_SERVER') ? "public" : '';
    }

    public function getItemsManagerFrontend()
    {
        return [
            'business' => [//Mis Negocios Manager
                'text' => __('frontend.account.menu.my-business'),
                'link' => route('business', app()->getLocale()),
                'icon' => 'fa fa-briefcase',
                'allowManager' => env('allowMenuLeftMyBusinessFrontEnd'),
                'active' => false,
            ],
            'businessEmployer' => [//Mis Negocios Manager
                'text' => __('frontend.account.menu.my-businessEmployer'),
                'link' => route('businessEmployer', app()->getLocale()),
                'icon' => 'fa fa-briefcase',
                'allowManager' => env('allowMenuLeftMyBusinessFrontEnd'),
                'active' => false,
            ],
            'listings' => [
                'text' => __('frontend.account.menu.my-queens'),
                'link' => route('listingsQueen', app()->getLocale()),
                'icon' => 'fa fa-building',
                'allowManager' => env('allowMenuLeftBusinessFriendFrontEnd'),
                'active' => false,
            ],
            'bee' => [
                'text' => __('frontend.account.menu.my-bees'),
                'link' => route('bee', app()->getLocale()),
                'icon' => 'fa fa-users',
                'allowManager' => env('allowMenuLeftFriendsFrontEnd'),
                'active' => false,
            ],
            'reviewsTo' => [
                'text' => __('frontend.account.menu.reviews'),
                'link' => route('reviewsTo', app()->getLocale()),
                'icon' => 'fa fa-comments-o',
                'allowManager' => env('allowMenuLeftMySuggestionFrontEnd'),
                'active' => false,
            ], 'pointsSales' => [
                'text' => __('frontend.account.menu.records.two'),
                'link' => route('pointsSales', app()->getLocale()),
                'icon' => 'fa fa-calendar-times-o',
                'allowManager' => env('allowMenuLeftMyPointOfSaleFrontEnd'),
                'active' => false,
            ],
        ];
    }
    public function getArrayByData($params)
    {
        $haystack = $params['haystack'];
        $result=[];
        foreach ($haystack as $key => $value) {
            $result[] = $value;
        }
        return $result;
    }
    public function getAllowAction($params)
    {
        $roles = $params['roles'];
        $actionVerify = $params['needle'];
        $keyCompare = $params['keyCompare'];

        $result = false;
        foreach ($roles as $key => $role) {
            $actions = $role->actions;


            foreach ($actions as $keyAction => $action) {

                if ($action->$keyCompare == $actionVerify) {
                    $result = true;
                    return $result;
                }
            }
        }
        return $result;
    }

    public function getMenuAccountManagementUser($params, $page)

    {
        $success = true;
        $msg = '';
        $error = [];
        $typeView = 'OK';
        $data = [];

        $pageConfig = [
            'account', 'myProfile', 'password', 'business', 'businessEmployer', 'orders', 'suggestionsMailBox', 'listings', 'bee', 'reviewsTo', 'pointsSales'
        ];
        $profileConfig = $params;

        if (in_array($page, $pageConfig)) {
            $user = isset($profileConfig['data']['user']) ? $profileConfig['data']['user'] : null;
            if ($user) {
                $actionCurrent = $page;
                $roles = $profileConfig['data']['rolesObject'];
                $menuOne = [];
                $menuTwo = [];
                $menuThree = [];
                $menuItemsOne = [
                    'account' => [
                        'text' => __('frontend.account.menu.dashboard'),
                        'link' => route('profileAccount', app()->getLocale()),
                        'icon' => 'fa fa-gears',
                        'allowManager' => env('allowMenuLeftDashboardFrontEnd'),
                        'active' => false,
                    ],
                    'myProfile' => [
                        'text' => __('frontend.account.menu.profile'),
                        'link' => route('myProfile', app()->getLocale()),
                        'icon' => 'fa fa-user-o',
                        'allowManager' => env('allowMenuLeftProfileFrontEnd'),
                        'active' => false,
                    ],
                    'password' => [
                        'text' => __('frontend.account.menu.change-password'),
                        'link' => route('password', app()->getLocale()),
                        'icon' => 'fa fa-unlock-alt',
                        'allowManager' => env('allowMenuLeftChangePasswordFrontEnd'),
                        'active' => false,
                    ],
                    'suggestionsMailBox' => [
                        'text' => __('frontend.account.menu.suggestions-mailbox'),
                        'link' => route('suggestionsMailBox', app()->getLocale()),
                        'icon' => 'fa fa-envelope-o',
                        'allowManager' => env('allowMenuLeftSuggestionFrontEnd'),
                        'active' => env('allowMenuLeftDashboardFrontEnd'),
                    ],
                ];

                $menuCurrentItems = $menuItemsOne;
                foreach ($menuCurrentItems as $key => $pageRow) {
                    if ($pageRow["allowManager"]) {


                        $actionAllowConfig = false;

                        $actionMenuCurrent = $key;
                        if ($user->id != 1) {

                            $actionAllowConfig = $this->getAllowAction([
                                'roles' => $roles,
                                'needle' => $actionMenuCurrent,
                                'keyCompare' => 'link',
                            ]);
                        } else if ($user->id == 1) {
                            $actionAllowConfig = true;
                        }
                        if ($actionAllowConfig) {
                            $setPush = $pageRow;
                            if ($actionMenuCurrent == $actionCurrent) {
                                $success = true;
                            }
                            $setPush['active'] = $actionMenuCurrent == $actionCurrent;
                            $menuOne[] = $setPush;
                        }
                    }
                }

                $allowPointsSalesEvents = false;
                if (env('allowRoutes')) {
                    $modelEventPoints = new \App\Models\EventsTrailsRegistrationPoints();
                    $user_id = $user->id;
                    $countEventsCurrent = $modelEventPoints->getCountDataPoints([
                        'filters' => [
                            'user_id' => $user_id
                        ]
                    ]);

                    $allowPointsSalesEvents = $countEventsCurrent > 0 ? true : false;
                }
                $menuItemsTwo = $this->getItemsManagerFrontend();


                $menuCurrentItems = $menuItemsTwo;
                foreach ($menuCurrentItems as $key => $pageRow) {
                    if ($pageRow["allowManager"]) {
                        $actionAllowConfig = false;
                        $actionMenuCurrent = $key;
                        if ($key == 'listings') {
                            $actionMenuCurrent = $key;
                        }

                        if ($user->id != 1) {


                            $actionAllowConfig = $this->getAllowAction([
                                'roles' => $roles,
                                'needle' => $actionMenuCurrent,
                                'keyCompare' => 'link',
                            ]);

                            if ($key == 'pointsSales') {
                                $actionAllowConfig = $allowPointsSalesEvents && $actionAllowConfig;
                            }
                        } else if ($user->id == 1) {
                            $actionAllowConfig = true;
                        }

                        if ($actionAllowConfig) {

                            $setPush = $pageRow;
                            if ($actionMenuCurrent == $actionCurrent) {
                                $success = true;
                            }


                            $setPush['active'] = $actionMenuCurrent == $actionCurrent;
                            $menuTwo[] = $setPush;
                        }
                    }

                }
                $menuItemsThree = [
                    'orders' => [
                        'text' => __('frontend.account.menu.records.one'),
                        'link' => route('orders', app()->getLocale()),
                        'icon' => 'fa fa-shopping-cart',
                        'allowManager' => env('allowMenuLeftMyOrdersFrontEnd'),
                        'active' => false,
                    ],

                ];
                $menuCurrentItems = $menuItemsThree;
                foreach ($menuCurrentItems as $key => $pageRow) {
                    if ($pageRow["allowManager"]) {
                        $actionAllowConfig = false;
                        $actionMenuCurrent = $key;
                        if ($user->id != 1) {

                            $actionAllowConfig = $this->getAllowAction([
                                'roles' => $roles,
                                'needle' => $actionMenuCurrent,
                                'keyCompare' => 'link',
                            ]);
                        } else if ($user->id == 1) {
                            $actionAllowConfig = true;
                        }
                        if ($actionAllowConfig) {
                            $setPush = $pageRow;
                            if ($actionMenuCurrent == $actionCurrent) {
                                $success = true;
                            }
                            $setPush['active'] = $actionMenuCurrent == $actionCurrent;
                            $menuThree[] = $setPush;
                        }
                    }

                }
                $menu = [
                    'one' => $menuOne,
                    'two' => $menuTwo,
                    'three' => $menuThree,

                ];

                $data['menu'] = $menu;
            } else {
            }
        } else {
        }

        $result = [
            'success' => $success,
            'msg' => $msg,
            'data' => $data,
            'error' => $error,
            'typeView' => $typeView
        ];
        return $result;
    }

    public function getSourceShopConfig($dataPaymentsConfig)
    {
        $source = '';
        $resourcePathServer = $this->resourcePathServer;

        if ($dataPaymentsConfig['api-credit-cards'] && $dataPaymentsConfig['pay-pal'] && $dataPaymentsConfig['bank-deposit']) {
            $source = 'case-1.png';
        } else if ($dataPaymentsConfig['api-credit-cards'] && $dataPaymentsConfig['pay-pal'] && $dataPaymentsConfig['bank-deposit'] == null) {
            $source = 'case-2.png';
        } else if ($dataPaymentsConfig['api-credit-cards'] && $dataPaymentsConfig['pay-pal'] == null && $dataPaymentsConfig['bank-deposit']) {
            $source = 'case-3.png';
        } else if ($dataPaymentsConfig['api-credit-cards'] == null && $dataPaymentsConfig['pay-pal'] && $dataPaymentsConfig['bank-deposit']) {
            $source = 'case-4.png';
        } else if ($dataPaymentsConfig['api-credit-cards'] && $dataPaymentsConfig['pay-pal'] == null && $dataPaymentsConfig['bank-deposit'] == null) {
            $source = 'case-5.png';
        } else if ($dataPaymentsConfig['api-credit-cards'] == null && $dataPaymentsConfig['pay-pal'] && $dataPaymentsConfig['bank-deposit'] == null) {
            $source = 'case-6.png';
        } else if ($dataPaymentsConfig['api-credit-cards'] == null && $dataPaymentsConfig['pay-pal'] == null && $dataPaymentsConfig['bank-deposit']) {
            $source = 'case-7.png';
        }
        $source = asset($resourcePathServer . '/images/payments/' . $source);
        return $source;
    }

    public function getShopConfig($params)
    {
        $result = [
            'allow' => false,
            'data' => [],
            'msg' => ''
        ];
        if (isset($params['filters']['template_information_id'])) {

            $modelTP = new TemplatePayments();
            $filtersManager = $params;
            $filtersManager['filters']['status'] = 'ACTIVE';
            $dataPaymentsConfig = $modelTP->getTypesPaymentsData($filtersManager);

            if ($dataPaymentsConfig['api-credit-cards'] || $dataPaymentsConfig['pay-pal'] || $dataPaymentsConfig['bank-deposit'] || $dataPaymentsConfig['pay-phone']) {
                $result = [
                    'allow' => true,
                    'data' => $dataPaymentsConfig,
                    'source' => $this->getSourceShopConfig($dataPaymentsConfig)
                ];

                if (!env('allowShopManager')) {
                    $result['allow'] = false;
                    $result['msg'] = 'Not Allow by Env.';
                }
            }
        } else {

            if (!env('allowShopManager')) {
                $result['allow'] = false;
                $result['msg'] = 'Not Allow by Env.';
            } else {
                $result['allow'] = true;
            }
        }

        return $result;
    }

    public function getPageData($params)
    {
        $page = $params['page'];
        $paramsRequest = $params['paramsRequest'];
        $template_information_id = isset($params['paramsRequest']['template_information_id']) ? $params['paramsRequest']['template_information_id'] : null;
        $business_id = isset($paramsRequest['business_id']) ? $paramsRequest['business_id'] : self::BUSINESS_ID;

        $modelCBP = new CustomerByProfile();//CMS-TEMPLATE-MY-PROFILE-DATA
        $user = Auth::user();

        $utilManagerUser = new \App\Utils\UtilUser;


        $profileConfig = $modelCBP->getProfileUser([
            'user' => $user
        ]);
        $profileConfig['menu'] = $modelCBP->getMenuTopRight([
            'user' => $user,
            'profileConfig' => $profileConfig,
            'resourcePathServer' => $this->resourcePathServer


        ]);

        $result = [];
        $modelB = new Business();
        $modelT = new TemplateInformation();
        $entity_id = $business_id;

        $entity_type_business = 4;
        $paramsTemplate = array('business_id' => $entity_id);
        if ($template_information_id) {
            $paramsTemplate['template_information_id'] = $template_information_id;
        }
        $templateInformation = $modelT->getTemplateMainFrontend($paramsTemplate);
        $dataSliderHtml = '';
        $dataSocialNetworksHtml = '';
        $dataFooter = array();
        $allowTemplate = false;
        $template_information_id = null;
        $dataMenu = array();
        $socialNetworkShop = '';
        $socialNetworkMenuMobile = '';

        $language = $paramsRequest['language'];
        $dataManagerPage = [];

        $paramsSetHeader = [
            'page' => $page,
        ];
        if ($page == 'productDetails') {
            $productId = $params['productId'];
            $paramsSetHeader = [
                'page' => $page,
                'productId' => $productId
            ];
        }


        $dataManagerPage['header'] = FrontendPageSections::getPageHeaderConfig($paramsSetHeader);

        $dataManagerPage['currentPage'] = $page;
        $dataManagerPage['profileConfig'] = $profileConfig;
        $dataManagerPage['sectionPage']['formContactUs'] = FrontendPageSections::getPageContactFormConfig([
            'page' => $page,
            'getData' => $templateInformation != false,
            'business_id' => $business_id,

        ]);

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
        $dataManagerPage['pluginsAllow'] = [
            'slider' => [
                'allow' => false
            ]
        ];
        $dataBusiness = $modelB->getBusinessFrontend([
            'filters' => [
                'business_id' => $entity_id
            ]
        ]);

        $allowBusiness = $dataBusiness != false;

        $businessMainInformation = $dataBusiness;
        $pageSectionsConfig = [
            'alliedBrands' => ['allow' => FrontendPageSections::ALLIED_BRANDS_ALLOW],
            'policies' => ['allow' => FrontendPageSections::POLICIES_ALLOW, "data" => [], 'msj' => 'No existe valores Gestionados.!', 'view' => false],
            'terms' => ['allow' => FrontendPageSections::TERMS_ALLOW, "data" => [], 'msj' => 'No existe valores Gestionados.!', 'view' => false],
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

        $pageSectionsConfig['cookies'] = FrontendPageSections::getPageCookies([
            'page' => $page
        ]);
        $dataLanguages = [];

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
                $modelLCM = new \App\Models\LanguageConfigManager();
                $dataManagerPage['languageHeader'] = $modelLCM->getLanguageMenu(
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
                    'typeData' => [FrontendPageSections::POLICIES_TYPE, FrontendPageSections::TERM_TYPE]
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
                    if ($type == FrontendPageSections::POLICIES_TYPE) {
                        $pageSectionsConfig['policies']['view'] = true;
                        $pageSectionsConfig['policies']['data'] = $value;
                    } else if ($type == FrontendPageSections::TERM_TYPE) {
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
                ]
            ]);
            if (count($dataSocialNetwork) > 0) {

                $dataSocialNetworksHtml = Frontend::getHtmlSocialNetwork([
                    'data' => $dataSocialNetwork,
                    'type' => 'footer',
                    'title' => 'Siguenos.',
                    "resourcePathServer" => $this->resourcePathServer
                ]);

                $socialNetworkMenuMobile = Frontend::getHtmlSocialNetwork([
                    'data' => $dataSocialNetwork,
                    'type' => 'menu-mobile',
                    'title' => 'Please view our FAQ to find answers to your questions or send us an email for general questions! Due to unexpected volumes, it is taking us a little longer than we would like to respond to emails. Our current email response time is 3 business days.',
                    "resourcePathServer" => $this->resourcePathServer
                ]);
                $socialNetworkShop = Frontend::getHtmlSocialNetwork([
                    'data' => $dataSocialNetwork,
                    'type' => 'menu-shop',
                    'title' => 'SHARE ON',
                    "resourcePathServer" => $this->resourcePathServer
                ]);
                if ($page == 'contactUs') {
                    $dataSocialNetworksContactUsHtml = Frontend::getHtmlSocialNetwork([
                        'data' => $dataSocialNetwork,
                        'type' => 'contact-us',
                        'title' => 'Please view our FAQ to find answers to your questions or send us an email for general questions! Due to unexpected volumes, it is taking us a little longer than we would like to respond to emails. Our current email response time is 3 business days.',
                        "resourcePathServer" => $this->resourcePathServer
                    ]);
                }
            }


            $modelTCP = new TemplateChatApi();
            $resultChat = $modelTCP->getChatsTypesData($filtersManager);
            if ($resultChat['facebook'] != false) {
                $dataManagerPage['chat'] = Frontend::getHtmlChat([
                    'data' => $resultChat['facebook'],
                    "resourcePathServer" => $this->resourcePathServer
                ]);
            }
            $modelTBS = new TemplateBySource();
            $resultResources = $modelTBS->getSourcesTypesData($filtersManager);//logoMain

            $sourceLogoFooter = "/uploads/frontend/templateBySource/logo_footer.svg";
            $htmlRowLogoFooter = '<img  class="center center--image-logo-footer" id="img-first-manager-footer" src="' . URL($this->resourcePathServer . $sourceLogoFooter) . '" class="img-fluid" alt="">';

            $dataManagerPage['logoMainFooter'] = new HtmlString($htmlRowLogoFooter);

            $sourceLogoFooter = "/uploads/frontend/home/mundi-box.svg";
            $htmlRowLogoFooter = '<img  class="center center--image-home"  src="' . URL($this->resourcePathServer . $sourceLogoFooter) . '" class="img-fluid" alt="">';
            $dataManagerPage['homeImageOne'] = new HtmlString($htmlRowLogoFooter);
            $sourceLogoFooter = "/uploads/frontend/home/mundi-flower.svg";
            $htmlRowLogoFooter = '<img  class="center center--image-home"  src="' . URL($this->resourcePathServer . $sourceLogoFooter) . '" class="img-fluid" alt="">';
            $dataManagerPage['homeImageTwo'] = new HtmlString($htmlRowLogoFooter);
            $sourceLogoFooter = "/uploads/frontend/home/mundi-fruits.svg";
            $htmlRowLogoFooter = '<img  class="center center--image-home"  src="' . URL($this->resourcePathServer . $sourceLogoFooter) . '" class="img-fluid" alt="">';
            $dataManagerPage['homeImageThree'] = new HtmlString($htmlRowLogoFooter);
            $sourceLogoFooter = "/uploads/frontend/home/mundi-product.svg";
            $htmlRowLogoFooter = '<img  class="center center--image-home"  src="' . URL($this->resourcePathServer . $sourceLogoFooter) . '" class="img-fluid" alt="">';
            $dataManagerPage['homeImageFour'] = new HtmlString($htmlRowLogoFooter);


            if ($resultResources['logoMain'] != false) {
                $dataManagerPage['logoMainData'] = $resultResources['logoMain'];
                $dataManagerPage['logoMain'] = Frontend::getHtmlLogoHeader([
                    'data' => $resultResources['logoMain'],
                    'page' => $page,
                    "resourcePathServer" => $this->resourcePathServer
                ]);
                $dataManagerPage['logoMainMobile'] = Frontend::getHtmlLogoHeaderMobile([
                    'data' => $resultResources['logoMain'],
                    'page' => $page,
                    "resourcePathServer" => $this->resourcePathServer

                ]);
            }
            if ($resultResources['favicon'] != false) {
                $dataManagerPage['faviconData'] = $resultResources['favicon'];
                $dataManagerPage['favicon'] = Frontend::getHtmlFaviconHeader([
                    'data' => $resultResources['favicon'],
                    "resourcePathServer" => $this->resourcePathServer
                ]);
            }
            $dataFooter['socialNetwork'] = $dataSocialNetworksHtml;
            $dataMenu['socialNetworkShop'] = $socialNetworkShop;
            $dataMenu['socialNetworkMenuMobile'] = $socialNetworkMenuMobile;
            $filtersManager['filters']['status'] = 'ACTIVE';
            $dataManagerPage['shopConfig'] = $this->getShopConfig($filtersManager);
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

        $result['dataFooter'] = $dataFooter;
        $result['dataManagerPage'] = $dataManagerPage;
        $result['dataMenu'] = $dataMenu;
        $result['pageSectionsConfig'] = $pageSectionsConfig;
        $result["resourceRoot"] = URL($this->resourcePathServer);
        $result["allowTemplate"] = $allowTemplate;
        $result["allowBusiness"] = $allowBusiness;
        $result["template_information_id"] = $template_information_id;
        $result["entity_id"] = $entity_id;
        $result["entity_type_business"] = $entity_type_business;
        $result["dataBusiness"] = $dataBusiness;
        $result["profileConfig"] = $profileConfig;
        $result["profileConfig"]['user'] = $user;
        $result["profileConfig"]['utilUser'] = $utilManagerUser;

        $result["businessMainInformation"] = [
            'allow' => $allowBusiness,
            'data' => [
                'information' => $businessMainInformation
            ]
        ];

        return $result;
    }
}
