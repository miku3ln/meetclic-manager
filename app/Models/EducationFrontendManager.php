<?php

namespace App\Models;

use Auth;
use DateTime;
use Frontend;
use Illuminate\Support\HtmlString;
use Route;
use URL;


class EducationFrontendManager extends ModelManager
{
    const BUSINESS_ID = 1;
    public $resourcePathServer = '';
    public $modelFMD = null;
    public $businessManagerId = null;
    const BUSINESS_MAIN_ID = 1;
    const BUSINESS_ONE_ID = 2;
    const BUSINESS_TWO_ID = 3;
    const BUSINESS_THREE_ID = 4;
    const typeDesignOne = 0;//only root
    const typeDesignTwo = 1;//only level 2
    // our
    //    our 01
    //    0ur 02
    const typeDesignThree = 2;
    // our
    //    our 01
    //        our 0.01
    //    0ur 02


    function __construct()
    {
        $this->resourcePathServer = env('APP_IS_SERVER') ? "public" : '';
        $this->modelFMD = new \App\Models\FrontendManagerData();
    }

    public function getStructureCategories($params)
    {
        $dataCategories = $params['dataCategories'];
        $categoriesCurrent = [];
        $categoriesCurrentKeys = [];
        $categoriesCurrentManagement = [];

        foreach ($dataCategories as $key => $value) {
            $needleCurrent = $value['id'];
            $allowPush = in_array($needleCurrent, $categoriesCurrentKeys);
            if (!$allowPush) {
                $categoriesCurrentKeys[] = $needleCurrent;
                $categoriesCurrent[] = $value;
                $categoriesCurrentManagementAux = [];
                foreach ($dataCategories as $keySearch => $valueSearch) {
                    if ($valueSearch['id'] == $needleCurrent) {
                        $categoriesCurrentManagementAux[] = $valueSearch;
                    }
                }

                //DISTRIBUIR
                $subCategoriesCurrentKeys = [];
                $subCategoriesCurrent = [];
                foreach ($categoriesCurrentManagementAux as $keySub => $valueSub) {
                    $needleCurrentSub = $valueSub['product_subcategory_id'];
                    $allowPush = in_array($needleCurrentSub, $subCategoriesCurrentKeys);
                    if (!$allowPush) {
                        $subCategoriesCurrentKeys[] = $needleCurrentSub;
                        $subCategoriesCurrent[] = [
                            'id' => $valueSub['product_subcategory_id'],
                            'value' => $valueSub['product_subcategory_value'],
                            'description' => $valueSub['product_subcategory_description'],
                            'source' => $valueSub['product_subcategory_source'],

                        ];
                    }
                }
                $setPushCurrent = $value;
                $setPushCurrent['data'] = $subCategoriesCurrent;
                $categoriesCurrentManagement[] = $setPushCurrent;
            }
        }

        $categoriesData = $categoriesCurrentManagement;
        return $categoriesData;
    }

    public function getMenuCurrentHtml($params)
    {
        $menuCurrent = $params['menuCurrent'];
        $htmlCurrent = '';
        if (count($menuCurrent) > 0) {
            $htmlCurrent = '<ul class="rd-navbar-nav">';
            $lvlOne = '';
            $lvlTwo = '';
            $lvlThree = '';

            foreach ($menuCurrent as $key => $row) {

                $levelCurrent = $row['typeDesign'];
                if ($levelCurrent == self::typeDesignOne) {
                    $classActive = ' class="level-1 ' . ($row['active'] == true ? 'active' : '') . '"';

                    $htmlCurrent .= '<li ' . $classActive . '>' . '<a href="' . $row['link'] . '">' . $row['title'] . '</a>' . '</li>';
                } else if ($levelCurrent == self::typeDesignTwo) {
                    $dataLvl2 = $row['data'];

                    $classActive = ' class="level-2 ' . ($row['active'] == true ? 'active' : '') . '"';

                    $htmlCurrent .= ' <li ' . $classActive . '>';
                    $htmlCurrent .= '     <a href="#">' . $row['title'] . '</a>';
                    $htmlCurrent .= '    <ul  class="rd-navbar-dropdown">';

                    foreach ($dataLvl2 as $keyLvl2 => $rowLvl2) {

                        $classActive = ' class="' . ($rowLvl2['active'] == true ? 'active' : '') . '"';
                        $htmlCurrent .= '<li ' . $classActive . '>' . '<a href="' . $rowLvl2['link'] . '">' . $rowLvl2['title'] . '</a>' . '</li>';
                    }

                    $htmlCurrent .= '   </ul>';
                    $htmlCurrent .= ' </li>';

                } else if ($levelCurrent == self::typeDesignThree) {
                    $dataLvl2 = $row['data'];
                    $classActive = ' class="level-3 ' . ($row['active'] == true ? 'active' : '') . '"';

                    $htmlCurrent .= ' <li ' . $classActive . '>';
                    $htmlCurrent .= '     <a href="#">' . $row['title'] . '</a>';
                    $htmlCurrent .= '    <div class="rd-navbar-megamenu">';
                    $htmlCurrent .= '       <div class="row section-relative">';
                    $countData = count($dataLvl2);
                    $columnsDiv = 12;
                    $classDistribution = $columnsDiv / $countData;

                    foreach ($dataLvl2 as $keyLvl2 => $rowLvl2) {

                        $classActive = ' class="' . ($rowLvl2['active'] == true ? 'active' : '') . '"';

                        $htmlCurrent .= '       <ul class="col-lg-' . $classDistribution . '">';
                        if (isset($rowLvl2['data'])) {
                            $dataLvl3 = $rowLvl2['data'];
                            $htmlCurrent .= '         <li ' . $classActive . ' ><h6>' . $rowLvl2['title'] . '</h6>';
                            $htmlCurrent .= '            <ul class="list-unstyled offset-lg-top-20">';

                            foreach ($dataLvl3 as $keyLvl3 => $rowLvl3) {
                                $classActive = ' class="' . ($rowLvl3['active'] == true ? 'active' : '') . '"';
                                $htmlCurrent .= '<li ' . $classActive . '>' . '<a href="' . $rowLvl3['link'] . '">' . $rowLvl3['title'] . '</a>' . '</li>';
                            }
                            $htmlCurrent .= '            </ul>';

                            $htmlCurrent .= '         </li>';

                        } else {

                            $htmlCurrent .= '         <li ' . $classActive . ' ><h6><a href="' . $rowLvl2['link'] . '">' . $rowLvl2['title'] . '</a></h6>';
                            $htmlCurrent .= '         </li>';


                        }
                        $htmlCurrent .= '            </ul>';

                    }
                    $htmlCurrent .= '     </div>';
                    $htmlCurrent .= '   </div>';
                    $htmlCurrent .= ' </li>';

                }
            }
            $htmlCurrent .= '</ul>';
        } else {

        }

        return $htmlCurrent;
    }

    public function getAfterMenu()
    {
        $business_id = 1;
        $pageCurrent = 1;

        if ($business_id == self::BUSINESS_MAIN_ID) {

            $result = [
                [
                    'active' => $pageCurrent == 'arrayanes',
                    'link' => route('arrayanes', app()->getLocale()),
                    'title' => 'Los Arrayanes',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => $pageCurrent == 'alamos',
                    'link' => route('alamos', app()->getLocale()),
                    'title' => 'Álamos',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => $pageCurrent == 'preescolar',
                    'link' => route('preescolar', app()->getLocale()),
                    'title' => 'Preescolar',
                    'type' => 1,
                    'isParent' => false,

                ],
            ];
        } else if ($business_id == self::BUSINESS_ONE_ID) {

            $activeParentAdmission = false;
            if ($pageCurrent == 'requirementsArrayanes' || $pageCurrent == 'frequentQuestionArrayanes') {
                $activeParentAdmission = true;

            }
            $dataChildrenAdmission = [
                [

                    'active' => $pageCurrent == 'requirementsArrayanes',
                    'link' => route('requirementsArrayanes', app()->getLocale()),
                    'title' => 'Requisitos de Admisión',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Matriculas Online',
                    'type' => 2,
                    'isParent' => false,
                ],
                [
                    'active' => $pageCurrent == 'frequentQuestionArrayanes',
                    'link' => route('frequentQuestionArrayanes', app()->getLocale()),
                    'title' => 'Preguntas Frecuentes',
                    'type' => 1,
                    'isParent' => false,

                ]
            ];

            $activeParentOur = false;
            if ($pageCurrent == 'aboutUsArrayanes') {
                $activeParentOur = true;

            }
            $dataChildrenOur = [


                [

                    'active' => $pageCurrent == 'aboutUsArrayanes',
                    'link' => route('aboutUsArrayanes', app()->getLocale()),
                    'title' => 'Quienes Somos',
                    'type' => 1,
                    'isParent' => false,

                ],
                [


                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Oferta Educativa',
                    'type' => 2,
                    'isParent' => false,

                ],
                [
                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Opus Dei',
                    'type' => 2,
                    'isParent' => false,
                    'data' => [
                        [
                            'active' => false,
                            'link' => 'https://schoolnet.colegium.com/',
                            'title' => 'Opus Dei',
                            'type' => 2,
                            'isParent' => false,

                        ],
                        [
                            'active' => false,
                            'link' => 'https://schoolnet.colegium.com/',
                            'title' => 'Opus Dei',
                            'type' => 2,
                            'isParent' => false,

                        ],
                    ]

                ],
            ];


            $result = [
                [
                    'typeDesign' => self::typeDesignOne,
                    'active' => $pageCurrent == 'arrayanes',
                    'link' => route('root', app()->getLocale()),
                    'title' => 'Home',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'typeDesign' => self::typeDesignThree,
                    'active' => $activeParentOur,
                    'link' => '#',
                    'title' => 'Nuestro Colegio',
                    'type' => 3,
                    'isParent' => true,
                    'data' => $dataChildrenOur

                ],
                [
                    'typeDesign' => self::typeDesignTwo,
                    'active' => $activeParentAdmission,
                    'link' => '#',
                    'title' => 'Admisiones',
                    'type' => 3,
                    'isParent' => true,
                    'data' => $dataChildrenAdmission

                ],
                [
                    'typeDesign' => self::typeDesignOne,
                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Plataforma',
                    'type' => 2,
                    'isParent' => false,

                ],

                [
                    'typeDesign' => self::typeDesignOne,
                    'active' => $pageCurrent == 'alamos',
                    'link' => route('alamos', app()->getLocale()),
                    'title' => 'Álamos',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'typeDesign' => self::typeDesignOne,
                    'active' => $pageCurrent == 'preescolar',
                    'link' => route('preescolar', app()->getLocale()),
                    'title' => 'Preescolar',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'typeDesign' => self::typeDesignOne,
                    'active' => $pageCurrent == 'contactUsArrayanes',
                    'link' => route('contactUsArrayanes', app()->getLocale()),
                    'title' => 'Contáctanos',
                    'type' => 1,
                    'isParent' => false,

                ],
            ];
        } else if ($business_id == self::BUSINESS_TWO_ID) {

            $activeParentAdmission = false;
            if ($pageCurrent == 'requirementsAlamos' || $pageCurrent == 'frequentQuestionAlamos') {
                $activeParentAdmission = true;

            }
            $dataChildrenAdmission = [
                [
                    'active' => $pageCurrent == 'requirementsAlamos',
                    'link' => route('requirementsAlamos', app()->getLocale()),
                    'title' => 'Requisitos de Admisión',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => false,
                    'link' => 'http://corporacionarrayanes.postulaciones.colegium.com/',
                    'title' => 'Matriculas Online',
                    'type' => 2,
                    'isParent' => false,
                ],
                [
                    'active' => $pageCurrent == 'frequentQuestionAlamos',
                    'link' => route('frequentQuestionAlamos', app()->getLocale()),
                    'title' => 'Preguntas Frecuentes',
                    'type' => 1,
                    'isParent' => false,

                ]
            ];

            $activeParentOur = false;
            if ($pageCurrent == 'aboutUsAlamos') {
                $activeParentOur = true;

            }
            $dataChildrenOur = [


                [
                    'active' => $pageCurrent == 'aboutUsAlamos',
                    'link' => route('aboutUsAlamos', app()->getLocale()),
                    'title' => 'Quienes Somos',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Oferta Educativa',
                    'type' => 2,
                    'isParent' => false,

                ],
                [
                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Opus Dei',
                    'type' => 2,
                    'isParent' => false,

                ],
            ];

            $result = [
                [
                    'active' => $pageCurrent == 'alamos',
                    'link' => route('root', app()->getLocale()),
                    'title' => 'Home',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => $activeParentOur,
                    'link' => '#',
                    'title' => 'Nuestro Colegio',
                    'type' => 3,
                    'isParent' => true,
                    'data' => $dataChildrenOur

                ],
                [
                    'active' => $activeParentAdmission,
                    'link' => '#',
                    'title' => 'Admisiones',
                    'type' => 3,
                    'isParent' => true,
                    'data' => $dataChildrenAdmission

                ],

                [
                    'active' => $pageCurrent == 'arrayanes',
                    'link' => route('arrayanes', app()->getLocale()),
                    'title' => 'Arrayanes',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => $pageCurrent == 'preescolar',
                    'link' => route('preescolar', app()->getLocale()),
                    'title' => 'Preescolar',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => $pageCurrent == 'contactUsAlamos',
                    'link' => route('contactUsAlamos', app()->getLocale()),
                    'title' => 'Contáctanos',
                    'type' => 1,
                    'isParent' => false,

                ],
            ];
        } else if ($business_id == self::BUSINESS_THREE_ID) {
            $activeParentAdmission = false;
            if ($pageCurrent == 'requirementsPreescolar' || $pageCurrent == 'frequentQuestionPreescolar') {
                $activeParentAdmission = true;

            }
            $dataChildrenAdmission = [
                [
                    'active' => $pageCurrent == 'requirementsPreescolar',
                    'link' => route('requirementsPreescolar', app()->getLocale()),
                    'title' => 'Requisitos de Admisión',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => false,
                    'link' => 'http://corporacionarrayanes.postulaciones.colegium.com/',
                    'title' => 'Matriculas Online',
                    'type' => 2,
                    'isParent' => false,
                ],
                [
                    'active' => $pageCurrent == 'frequentQuestionPreescolar',
                    'link' => route('frequentQuestionPreescolar', app()->getLocale()),
                    'title' => 'Preguntas Frecuentes',
                    'type' => 1,
                    'isParent' => false,

                ]
            ];

            $activeParentOur = false;
            if ($pageCurrent == 'aboutUsPreescolar') {
                $activeParentOur = true;

            }
            $dataChildrenOur = [


                [
                    'active' => $pageCurrent == 'aboutUsPreescolar',
                    'link' => route('aboutUsPreescolar', app()->getLocale()),
                    'title' => 'Quienes Somos',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Oferta Educativa',
                    'type' => 2,
                    'isParent' => false,

                ],
                [
                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Opus Dei',
                    'type' => 2,
                    'isParent' => false,

                ],
            ];

            $result = [
                [
                    'active' => $pageCurrent == 'preescolar',
                    'link' => route('root', app()->getLocale()),
                    'title' => 'Home',
                    'type' => 1,
                    'isParent' => false,

                ], [
                    'active' => $activeParentOur,
                    'link' => '#',
                    'title' => 'Nuestro Colegio',
                    'type' => 3,
                    'isParent' => true,
                    'data' => $dataChildrenOur

                ],

                [
                    'active' => $activeParentAdmission,
                    'link' => '#',
                    'title' => 'Admisiones',
                    'type' => 3,
                    'isParent' => true,
                    'data' => $dataChildrenAdmission

                ],

                [
                    'active' => false,
                    'link' => 'https://schoolnet.colegium.com/',
                    'title' => 'Plataforma',
                    'type' => 2,
                    'isParent' => false,

                ],
                [
                    'active' => $pageCurrent == 'arrayanes',
                    'link' => route('arrayanes', app()->getLocale()),
                    'title' => 'Arrayanes',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => $pageCurrent == 'alamos',
                    'link' => route('alamos', app()->getLocale()),
                    'title' => 'Álamos',
                    'type' => 1,
                    'isParent' => false,

                ],
                [
                    'active' => $pageCurrent == 'contactUsPreescolar',
                    'link' => route('contactUsPreescolar', app()->getLocale()),
                    'title' => 'Contáctanos',
                    'type' => 1,
                    'isParent' => false,

                ],
            ];
        }

    }

    public function getMenuCurrent($params)
    {
        $result = [];
        $business_id = $params['business_id'];
        $pageCurrent = $params['pageCurrent'];
        $modelMenu = new \App\Models\BusinessByMenuManagementFrontend();
        $menuCurrent = $modelMenu->managementMenuBusiness([
            'filters' => [
                'business_id' => $business_id
            ]
        ]);
        $result = $menuCurrent;
        return $result;
    }

    public function getParamsPage($params)
    {
        $page = $params['page'];
        $paramsRequest = $params['paramsRequest'];
        $language = $paramsRequest['language'];


        $resultPageData = $this->modelFMD->getPageData($params);

        $modelB = new Business();
        $allowTemplate = $resultPageData['allowTemplate'];
        $template_information_id = $resultPageData['template_information_id'];
        $entity_id = $resultPageData['entity_id'];
        $entity_type_business = $resultPageData['entity_type_business'];
        $pageSectionsConfig = $resultPageData['pageSectionsConfig'];
        $business_id = $paramsRequest['business_id'];
        $dataManagerPage = $resultPageData['dataManagerPage'];
        $dataBusiness = $resultPageData['dataBusiness'];
        $dataFooter = array();
        $dataMenu = array();
        $rootPage = 'coorpar';
        $slogan = 'Dios y Audacia';
        $rootPageCurrent = '';
        $textInformation = env('businessOneTextWhats');

        if ($business_id == 2) {
            $slogan = 'Empieza el futuro';
            $rootPage = 'arrayanes';
            $rootPageCurrent = route('arrayanes', app()->getLocale());
            $textInformation = env('businessTwoTextWhats');

        } else if ($business_id == 3) {
            $slogan = 'Empieza el futuro';
            $rootPage = 'alamos';
            $rootPageCurrent = route('alamos', app()->getLocale());
            $textInformation = env('businessThreeTextWhats');


        } else if ($business_id == 4) {
            $slogan = '';
            $rootPage = 'preescolar';
            $rootPageCurrent = route('preescolar', app()->getLocale());

            $dataManagerPage['allowStyle'] = true;
            $textInformation = env('businessFourTextWhats');

        }
        $title = 'None';

        if ($resultPageData['dataBusiness']) {

            $title = $resultPageData['dataBusiness']->title;
        }
        $business = [
            'title' => $title,
            'slogan' => $slogan,

        ];
        $nameBusiness = 'Arrayanes';
        $allowPageMain = false;
        $pageSectionsConfig['business']['textInformation'] = $textInformation;

        if ($page == 'alamos' || $page == 'contactUsAlamos') {
            $nameBusiness = 'Alamos';
            $allowPageMain = true;
        } else if ($page == 'preescolar' || $page == 'contactUsPreescolar') {
            $nameBusiness = 'Preescolar';
            $allowPageMain = true;
        } else if ($page == 'arrayanes' || $page == 'contactUsArrayanes') {
            $nameBusiness = 'Arrayanes';
            $allowPageMain = true;
        }
        $dataSocialNetworksHtml = '';
        $menuCurrent = $this->getMenuCurrent([
            'business_id' => $business_id,
            'pageCurrent' => $page
        ]);
        $menuCurrentHtml = $this->getMenuCurrentHtml([
            'menuCurrent' => $menuCurrent
        ]);
        $dataManagerPage['rootPageCurrent'] = $rootPageCurrent;
        $dataManagerPage['business_id'] = $business_id;
        $dataManagerPage['nameBusiness'] = $nameBusiness;

        if ($dataBusiness != false) {
            if ($allowPageMain) {
                $modelDataInformation = new \App\Models\HumanResourcesEmployeeProfile();
                $dataProfiles = $modelDataInformation->getManagementFrontend([
                    'filters' => [
                        'business_id' => $business_id
                    ]
                ]);
                if ($dataProfiles['success']) {

                    $dataProfilesHtml = $this->getProfilesHtml([
                        'data' => $dataProfiles['data'],
                        'nameBusiness' => $nameBusiness
                    ]);

                    $dataManagerPage['dataProfilesHtml'] = $dataProfilesHtml;
                }
            }
            $partnerCompaniesModel = new \App\Models\BusinessByPartnerCompanies();
            $partnerCompaniesData = $partnerCompaniesModel->getDataFrontend(['filters' => [
                'business_id' => $business_id
            ]]);

            if ($partnerCompaniesData) {
                $dataPartnerCompaniesHtml = $this->getPartnerCompaniesHtml([
                    'data' => $partnerCompaniesData,
                    'nameBusiness' => $nameBusiness
                ]);
                $dataManagerPage['dataPartnerCompaniesHtml'] = $dataPartnerCompaniesHtml;
            }

            if ($allowTemplate) {
                $dataNewsHtml = '';
                $modelNews = new \App\Models\TemplateNews();
                $dataNews = $modelNews->getDataFrontend([
                    'filters' => [
                        'template_information_id' => $template_information_id
                    ]
                ]);
                if ($dataNews) {
                    $dataNewsHtml = $this->getNewsHtml(['data' => $dataNews, 'nameBusiness' => $nameBusiness]);
                    $dataManagerPage['dataNewsHtml'] = $dataNewsHtml;
                }

                //SLIDER
                $modelParent = new TemplateSlider();
                $dataSliderHtml = '';
                $dataSlider = $modelParent->getSliderMainFrontend(array(
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer
                ));
                if (count($dataSlider) > 0) {

                    $dataSliderHtml = $this->getHtmlSlider($dataSlider);
                    $result['dataSliderHtml'] = $dataSliderHtml;
                }
                //SOCIAL NETWORK
                $modelISN = new InformationSocialNetwork();
                $dataSocialNetwork = $modelISN->getAllFrontend([
                    'filters' => [
                        'entity_id' => $entity_id,
                        'entity_type' => $entity_type_business
                    ]
                ]);

                if (count($dataSocialNetwork) > 0) {

                    $dataSocialNetworkHtml = $this->getHtmlSocialNetwork([
                        'data' => $dataSocialNetwork,
                        'type' => 'footer',
                        'title' => 'Siguenos en :',
                        "resourcePathServer" => $this->resourcePathServer
                    ]);
                    $dataManagerPage['dataSocialNetworkFooterHtml'] = $dataSocialNetworkHtml;

                    $dataSocialNetworkHtml = $this->getHtmlSocialNetwork([
                        'data' => $dataSocialNetwork,
                        'type' => 'contactUs',
                        'title' => 'Siguenos en :',
                        "resourcePathServer" => $this->resourcePathServer
                    ]);
                    $dataManagerPage['dataSocialNetworkContactUsHtml'] = $dataSocialNetworkHtml;
                }

                $modelTCU = new TemplateContactUs();
                $contactUsMap = $modelTCU->getContactUsFrontend(
                    [
                        'filters' => [
                            'template_information_id' => $template_information_id
                        ]
                    ]
                );
            }
        }

        if ($page == 'home') {
        } else if ($page == 'aboutUsArrayanes' || $page == 'aboutUsAlamos' || $page == 'aboutUsPreescolar') {

            $modelDataAcademics = new \App\Models\BusinessByInformationCustom();
            $dataAcademics = $modelDataAcademics->getDataFrontend(['filters' => [
                'business_id' => $business_id
            ]]);
            if ($dataAcademics) {
                $dataAcademicsHtml = $this->getHtmlAcademics([
                    'data' => $dataAcademics
                ]);
                $dataManagerPage['dataAcademicsHtml'] = $dataAcademicsHtml;
            }
        } else if ($page == 'academicOfferingArrayanes' || $page == 'academicOfferingAlamos' || $page == 'academicOfferingPreescolar') {

            $modelDataAcademics = new \App\Models\BusinessByAcademicOfferingsInstitution();
            $dataAcademics = $modelDataAcademics->getDataFrontend(['filters' => [
                'business_id' => $business_id
            ]]);
            if ($dataAcademics) {
                $dataHtmlCurrent = $this->getHtmlAcademicsInstitution([
                    'data' => $dataAcademics
                ]);
                $dataManagerPage['dataAcademicsOfferingHtml'] = $dataHtmlCurrent;
            }
        } else if ($page == 'requirementsArrayanes' || $page == 'requirementsAlamos' || $page == 'requirementsPreescolar') {

            $modelDataCurrent = new \App\Models\BusinessByRequirements();
            $dataCurrent = $modelDataCurrent->getDataFrontend(['filters' => [
                'business_id' => $business_id
            ]]);

            if ($dataCurrent) {
                $dataCurrentHtml = $this->getHtmlRequirements([
                    'data' => $dataCurrent
                ]);
                $dataManagerPage['dataRequirementsHtml'] = $dataCurrentHtml;
            }
        } else if ($page == 'frequentQuestionArrayanes' || $page == 'frequentQuestionAlamos' || $page == 'frequentQuestionPreescolar') {

            $modelDataCurrent = new \App\Models\BusinessByFrequentQuestion();
            $dataCurrent = $modelDataCurrent->getDataFrontend(['filters' => [
                'business_id' => $business_id
            ]]);

            if ($dataCurrent) {
                $dataCurrentHtml = $this->getHtmlFrequentQuestion([
                    'data' => $dataCurrent
                ]);
                $dataManagerPage['dataFrequentQuestionHtml'] = $dataCurrentHtml;
            }
        } else if ($page == 'historyArrayanes' || $page == 'historyAlamos' || $page == 'historyPreescolar') {
            $id = $paramsRequest['id'];
            $modelHistory = new \App\Models\BusinessByHistory();
            $dataHistory = $modelHistory->getManagementFrontend(
                [
                    'filters' => [
                        'id' => $id
                    ]
                ]
            );

            if ($dataHistory['success']) {
                $dataHistoryHtml = $this->getHistoryHtml([
                    'data' => $dataHistory['data'],
                    'nameBusiness' => $nameBusiness
                ]);
                $dataManagerPage['dataHistoryHtml'] = $dataHistoryHtml;
            }
        } else if ($page == 'newArrayanes' || $page == 'newAlamos' || $page == 'newPreescolar') {

            $id = $paramsRequest['id'];
            $modelParent = new \App\Models\TemplateNews();
            $dataHistory = $modelParent->getManagementFrontend(
                [
                    'filters' => [
                        'id' => $id,
                        'template_information_id' => $template_information_id
                    ]
                ]
            );

            if ($dataHistory['success']) {

                $dataNewHtml = $this->getNewHtml([
                    'data' => $dataHistory['data'],
                    'nameBusiness' => $nameBusiness
                ]);
                $dataManagerPage['dataNewHtml'] = $dataNewHtml;
            }
        } else if ($page == 'profileArrayanes' || $page == 'profileAlamos' || $page == 'profilePreescolar') {
            $id = $paramsRequest['id'];

            $modelDataInformation = new \App\Models\HumanResourcesEmployeeProfile();
            $dataProfile = $modelDataInformation->getManagementProfileFrontend([
                'filters' => [
                    'business_id' => $business_id,
                    'id' => $id
                ]
            ]);

            if ($dataProfile['success']) {
                $dataProfileHtml = $this->getProfileHtml([
                    'data' => $dataProfile['data'],
                    'nameBusiness' => $nameBusiness
                ]);

                $dataManagerPage['dataProfileHtml'] = $dataProfileHtml;
            }
        } else if ($page == 'arrayanes' || $page == 'alamos' || $page == 'preescolar') {

            if ($dataBusiness != false) {


                $modelOffering = new \App\Models\BusinessByAcademicOfferings();
                $dataManagementCurrentPage = $modelOffering->getManagementFrontend(['filters' => [
                    'business_id' => $business_id
                ]]);
                if ($dataManagementCurrentPage['success']) {
                    $background = '#253D79';
                    $fill = '#253D79';
                    if ($page == 'arrayanes') {
                        $background = '#253D79';
                        $fill = '#253D79';
                    } else if ($page == 'alamos') {
                        $background = '#253D79';
                        $fill = '#253D79';
                    } else if ($page == 'preescolar') {
                        $background = '#4F6FB3';
                        $fill = '#4F6FB3';
                    }

                    $parent = $dataManagementCurrentPage['data']['parent'];
                    $childrens = $dataManagementCurrentPage['data']['childrens'];

                    $styleCurrent = '    background: ' . $background . ' !important;
    fill: ' . $background . ' !important;';
                    $dataAcademicsOfferingHtml = ' <section class="section  section-xl text-center bg-section" style="' . $styleCurrent . '" >';
                    $dataAcademicsOfferingHtml .= '    <div class="container">';
                    $dataAcademicsOfferingHtml .= '        <h2 class="font-weight-bold text-white view-animate fadeInUpSmall delay-04">' . $parent->value . '</h2>';
                    $dataAcademicsOfferingHtml .= '        <div class="offset-top-35 offset-lg-top-60 text-white view-animate fadeInUpSmall delay-06">';
                    $dataAcademicsOfferingHtml .= '        ' . $parent->description;
                    $dataAcademicsOfferingHtml .= '        </div>';
                    $dataAcademicsOfferingHtml .= '        <div class="row row-30 justify-content-sm-center offset-top-60 text-md-left">';

                    $htmlImages='';
                    $pathRoot = $this->resourcePathServer;

                    foreach ($childrens as $key => $row) {
                        $delay=1;
                        $htmlImages .= '     <div class="col-md-6 col-lg-4 view-animate fadeInRightSm delay-'.$delay.'">';
                        $srcCurrent = URL($pathRoot . $row->source);
                        $htmlImages .= '       <article class="post-news bg-default">';
                        $htmlImages .= '            <a href="'.$row->link.'">';
                        $htmlImages .= '             <img class="img-responsive" src="'.$srcCurrent.'" width="370" height="240" >';
                        $htmlImages .= '            </a>';
                        $htmlImages .= '            <div class="post-news-body-variant-1">';
                        $htmlImages .= '               <h6><a  href="'.$row->link.'">'.$row->title.'</a></h6>';
                        $htmlImages .= '               <div class="offset-top-9">';
                        $htmlImages .= '                  <div class="text-base">'.$row->description;
                        $htmlImages .= '                 </div>';
                        $htmlImages .= '               </div>';

                        $htmlImages .= '            </div>';
                        $htmlImages .= '       </article>';

                        $htmlImages .= '     </div>';
                        $delay++;
                    }

                    $dataAcademicsOfferingHtml .= $htmlImages.'        </div>';
                    $dataAcademicsOfferingHtml .= '    </div>';

                    $dataAcademicsOfferingHtml .= ' </section>';


                    $dataManagerPage['dataAcademicsOfferingHtml'] = $dataAcademicsOfferingHtml;
                }


                $dataHistoryMainHtml = '';
                $modelHistory = new \App\Models\BusinessByHistory();
                $dataHistoryCurrent = $modelHistory->getMainFrontend(['filters' => [
                    'business_id' => $business_id
                ]]);
                if ($dataHistoryCurrent) {

                    $nameRoute = 'history' . $nameBusiness;
                    $paramsRoute = ['language' => app()->getLocale(), 'id' => $dataHistoryCurrent->id];
                    $urlView = route($nameRoute, $paramsRoute);

                    $dataHistoryMainHtml = '<section class="section section-xl bg-default">';
                    $dataHistoryMainHtml .= '<div class="container">';
                    $dataHistoryMainHtml .= '<div class="row row-50 text-lg-left justify-content-md-between">';
                    $dataHistoryMainHtml .= '<div class="col-lg-7 view-animate fadeInRightSm delay-04">';
                    $dataHistoryMainHtml .= '<div class="img-wrap-2">';
                    if ($dataHistoryCurrent->allow_source) {
                        $dataHistoryMainHtml .= '<figure>';
                        $dataHistoryMainHtml .= '<img class="img-responsive d-inline-block" src="' . URL($this->resourcePathServer . $dataHistoryCurrent->source) . '" width="620"';
                        $dataHistoryMainHtml .= 'height="350" alt="">';
                        $dataHistoryMainHtml .= '</figure>';
                    }
                    $dataHistoryMainHtml .= '</div>';
                    $dataHistoryMainHtml .= '</div>';
                    $dataHistoryMainHtml .= '<div class="col-lg-5">';
                    $dataHistoryMainHtml .= '<h2 class="home-headings-custom  view-animate fadeInLeftSm delay-06"><span ';
                    $dataHistoryMainHtml .= 'class="first-word">' . $dataHistoryCurrent->value . '</span> <br><br><br>' . $dataHistoryCurrent->subtitle . '</h2>';

                    $dataHistoryMainHtml .= '<div class="offset-top-35 offset-lg-top-60 view-animate fadeInLeftSm delay-08 description--custom">';

                    $dataHistoryMainHtml .= '</div>';
                    $dataHistoryMainHtml .= '<div class="offset-top-30 view-animate fadeInLeftSm delay-1">';
                    $dataHistoryMainHtml .= '<a class="btn btn-ellipse btn-icon btn-icon-right button-default button-default--custom" href="' . $urlView . '">';
                    $dataHistoryMainHtml .= '<span class="icon fa fa-arrow-right"></span><span>Leer Mas</span>';
                    $dataHistoryMainHtml .= '</a>';
                    $dataHistoryMainHtml .= '</div>';
                    $dataHistoryMainHtml .= '</div>';
                    $dataHistoryMainHtml .= '</div>';
                    $dataHistoryMainHtml .= '</div>';
                    $dataHistoryMainHtml .= '</section>';
                    $dataManagerPage['dataHistoryMainHtml'] = $dataHistoryMainHtml;
                }


                $dataCountersHtml = '';
                $modelCounters = new \App\Models\BusinessCounterCustom();
                $dataCountersManagement = $modelCounters->getDataManagementFrontend([
                    'filters' => [
                        'business_id' => $business_id
                    ]
                ]);
                $gradient = $page == 'preescolar' ? '#F3D745' : '#8D2119';
                $gradientEmpty = $page == 'preescolar' ? '#fff' : '#fff';
                if ($dataCountersManagement['success']) {
                    $dataCountersManager = $dataCountersManagement['data'];

                    $dataCountersHtml = '<section class="section section-lg bg-default" id="counters-business">';
                    $dataCountersHtml .= '   <div class="container">';
                    $dataCountersHtml .= '      <h2 class="">' . $dataCountersManager['parent']->title . '</h2>';

                    $dataCountersHtml .= '     <div class="row row-50 justify-content-sm-center offset-top-60 text-center">';
                    $styleManager = '<style>';
                    foreach ($dataCountersManager['childrens'] as $key => $row) {
                        $percentage = $row->count_percentage / 100;
                        $classManagerSymbol = 'counter__span-management-' . $row->id;
                        $styleManager .= '.' . $classManagerSymbol . ' span:after{content:"' . $row->count . $row->count_symbol . '"!important;}';


                        $styleSymbol = 'class="counter__span-management ' . $classManagerSymbol . '" symbol="' . $row->count_symbol . '"';


                        $dataCountersHtml .= '       <div class="col-md-6 col-lg-3">';
                        $dataCountersHtml .= '        <div class="progress-bar-circle progress-bar-circle-institution ' . $classManagerSymbol . '" data-value="' . $percentage . '" data-gradient="' . $gradient . '" data-empty-fill="' . $gradientEmpty . '" ';

                        $dataCountersHtml .= '         data-size="150"><span ' . $styleSymbol . ' ></span></div>';

                        $dataCountersHtml .= '          <div class="offset-top-20">';
                        $dataCountersHtml .= '                <h6 class="font-weight-bold counter__title">' . $row->title . '</h6>';
                        $dataCountersHtml .= '            </div>';
                        $dataCountersHtml .= '         </div>';
                    }
                    $styleManager = $styleManager . '</style>';

                    $dataCountersHtml .= $styleManager . '     </div>';
                    $dataCountersHtml .= ' </div>';
                    $dataCountersHtml .= '</section>';
                    $dataManagerPage['dataCountersHtml'] = $dataCountersHtml;
                }
            }
        }

        $result['dataFooter'] = $dataFooter;
        $result['dataManagerPage'] = $dataManagerPage;
        $result['dataMenu'] = $dataMenu;
        $result['pageSectionsConfig'] = $pageSectionsConfig;
        $result["resourceRoot"] = URL($this->resourcePathServer);
        $result["paramsRequest"] = $paramsRequest;

        $result = array_merge($resultPageData, $result);
        $result['business'] = $business;
        $result['menuCurrent'] = $menuCurrent;
        $result['menuCurrentHtml'] = $menuCurrentHtml;

        $result['rootPage'] = $rootPage;
        return $result;
    }

    public function getNewHtml($params)
    {

        $data = $params['data'];

        $nameBusiness = $params['nameBusiness'];


        $htmlCols = "";
        $htmlRow = "";
        $pathRoot = $this->resourcePathServer;

        $colTwo = '<div class="col-lg-4 text-left col-sm-8">';
        $dateCurrent = \App\Utils\Util::DateCurrent();
        if (isset($data['fresh-data'])) {

            $colTwo .= '<div class="offset-top-60">';
            $colTwo .= '  <h6 class="font-weight-bold title--new ">Noticias Recientes</h6>';
            $colTwo .= '  <div class="text-subline"></div>';
            $colTwo .= '  <div class="offset-top-20 text-left">';

            foreach ($data['fresh-data'] as $key => $row) {
                $horaInicio = new DateTime($row->created_at);
                $horaTermino = new DateTime($dateCurrent);
                $interval = $horaInicio->diff($horaTermino);
                if ($interval->d > 0) {
                    $dayString = $interval->d == 1 ? 'dia' : 'dias';
                    $resultDay = $interval->format('%d ' . $dayString . ' atras');
                } else {
                    $resultDay = $interval->format('%i minutos %s segundos atras');
                }
                $nameRoute = 'new' . $nameBusiness;
                $paramsRoute = ['language' => app()->getLocale(), 'id' => $row->id];
                $urlView = route($nameRoute, $paramsRoute);

                $colTwo .= '<div class="offset-top-20">';
                $colTwo .= '  <article class="widget-post">';
                $colTwo .= '    <h6 class="font-weight-bold text-primary">';
                $colTwo .= '        <a href="' . $urlView . '">' . $row->value . '</a>';
                $colTwo .= '    </h6>';
                $colTwo .= '    <p class="text-dark">' . $resultDay;
                $colTwo .= '    </p>';
                $colTwo .= '  </article>';
                $colTwo .= '</div>';
            }
            $colTwo .= '  </div>';

            $colTwo .= '</div>';
        }
        $colTwo .= '</div>';

        $horaInicio = new DateTime($data['parent']->created_at);
        $horaTermino = new DateTime($dateCurrent);
        $interval = $horaInicio->diff($horaTermino);
        $resultDay = '';
        if ($interval->d > 0) {
            $dayString = $interval->d == 1 ? 'dia' : 'dias';
            $resultDay = $interval->format('%d ' . $dayString . ' atras');
        } else {
            $resultDay = $interval->format('%i minutos %s segundos atras');
        }
        $colOne = '<div class="col-md-8 col-lg-8 text-lg-left">';
        $colOne .= '    <h2 class="font-weight-bold title--new">' . $data['parent']->value . '</h2>';
        $colOne .= '    <hr class="divider bg-madison divider-lg-0  bg-madison--custom">';
        $colOne .= '    <div class="offset-lg-top-47 offset-top-20">';
        $colOne .= '       <ul class="post-news-meta list list-inline list-inline-xl">';
        $colOne .= '          <li>';
        $colOne .= '              <span class="icon icon-xs mdi mdi-calendar-clock text-middle text-madison text-madison--custom"></span>';
        $colOne .= '              <span class="text-middle inset-left-10 font-italic text-black text-madison--custom">' . $resultDay . '</span>';
        $colOne .= '          </li>';
        $colOne .= '       </ul>';
        $colOne .= '    </div>';
        $colOne .= '    <div class="offset-top-30">';
        if ($data['parent']->allow_source == 1) {
            $srcCurrent = URL($pathRoot . $data['parent']->source);
            $colOne .= '       <img class="img-responsive" src="' . $srcCurrent . '" width="770" height="500" alt="">';
        }
        $colOne .= '       <div class="offset-top-30">';
        $colOne .= '       ' . $data['parent']->description;
        $colOne .= '       </div>';
        $colOne .= '    </div>';
        $colOne .= '</div>';

        $result = '<section class="section section-xl">';
        $result .= '  <div class="container">';
        $result .= '     <div class="row row-85 justify-content-sm-center">';
        $result .= $colOne;
        $result .= $colTwo;
        $result .= '     </div>';
        $result .= '  </div>';
        $result .= '</section>';

        $result = new HtmlString($result);
        return $result;
    }

    public function getHistoryHtml($params)
    {

        $data = $params['data'];

        $nameBusiness = $params['nameBusiness'];


        $htmlCols = "";
        $htmlRow = "";
        $pathRoot = $this->resourcePathServer;

        $titlesOwner = $data['parent']->author_titles;
        $author = $data['parent']->author;
        $description = $data['parent']->description;
        $allow_source = $data['parent']->allow_source;

        $htmlImages = '';
        if (isset($data['childrens'])) {
            $htmlImages .= '<section class="section section-xl bg-default">';
            $htmlImages .= '    <div class="container container-wide">';

            $htmlImages .= '         <div class="row row-30">';
            foreach ($data['childrens'] as $key => $row) {
                $htmlImages .= '     <div class="col-md-4">';
                $srcCurrent = URL($pathRoot . $row->source);
                $htmlImages .= '     <img class="img-responsive d-inline-block" src="' . $srcCurrent . '"
                width="570" height="370" alt="">';

                $htmlImages .= '     </div>';
            }
            $htmlImages .= '        </div>';
            $htmlImages .= '     </div>';
            $htmlImages .= '</section>';
        }

        $result = '        <section class="section section-xl bg-default">';
        $result .= '          <div class="container">';
        $result .= '             <div class="row row-50">';
        $result .= '                 <div class="col-md-4 order-md-2 text-md-left">';
        $result .= '                     <div class="inset-md-left-30">';
        if ($allow_source) {
            $srcImage = URL($pathRoot . $data['parent']->source);

            $result .= '                        <img class="img-responsive d-inline-block img-rounded"  src="' . $srcImage . '" width="340" height="300" alt="">';
        }
        $result .= '                          <div class="offset-top-20">';
        $result .= '                             <h6 class="text-primary font-weight-bold">' . $author . '</h6>';
        $result .= '                         </div>';
        $result .= '                         <p>' . $titlesOwner . '</p>';
        $result .= '                     </div>';
        $result .= '                 </div>'; //end col
        $result .= '                 <div class="col-md-8 order-md-1 text-md-left">';
        $result .= '                    <h2 class="font-weight-bold title-history">' . $data['parent']->value . '</h2>';
        $result .= '                    <hr class="divider bg-madison divider-md-0 bg-madison--custom">';
        $result .= '                    <div class="offset-top-30 offset-sm-top-60">';
        $result .= '                      ' . $description;
        $result .= '                    </div>'; //end div
        $result .= '                </div>'; //end col
        $result .= '             </div>'; //end row
        $result .= '         </div>'; //end container
        $result .= '       </section>';
        $result .= $htmlImages;

        $result = new HtmlString($result);
        return $result;
    }

    public function getHtmlAcademics($params)
    {
        $data = $params['data'];


        $htmlLi = "";
        $htmlNavsPane = "";
        $init = true;
        $classCurrent = 'active show';
        foreach ($data as $key => $row) {


            $htmlLi .= ' <li class="nav-item" role="presentation"> ' . "\n";
            $htmlLi .= '   <a class="nav-link ' . $classCurrent . '" href="#tabs-7-' . $row->id . '" data-toggle="tab">' . $row->value . '</a>  ' . "\n";
            $htmlLi .= '  </li> ' . "\n";
            $htmlNavsPane .= '<div class="tab-pane fade  ' . $classCurrent . '" id="tabs-7-' . $row->id . '">';
            $htmlNavsPane .= '  <h2 class="title-about">' . $row->subtitle . '</h2>';
            $htmlNavsPane .= '  <div class="hr divider bg-madison bg-madison--custom divider-md-0"></div>';
            $htmlNavsPane .= '  <div class="offset-lg-top-60 text-color--custom-about">' . $row->description;
            $htmlNavsPane .= '  </div>';
            if ($row->allow_source) {
                $htmlNavsPane .= '  <div class="offset-top-30">';
                $htmlNavsPane .= '     <img class="img-responsive d-inline-block" src="' . URL($this->resourcePathServer . $row->source) . '" width="770"
            height="480" alt="">';
                $htmlNavsPane .= '   </div>';
            }
            $htmlNavsPane .= '</div>';

            if ($init) {
                $init = false;
                $classCurrent = '';
            }
        }


        $resultLi = '<ul class="nav nav-tabs">';
        $resultLi .= $htmlLi;
        $resultLi .= '</ul>';

        $resultPanes = '<div class="tab-content inset-lg-left-60">';
        $resultPanes .= $htmlNavsPane;
        $resultPanes .= '</div>';
        $result = $resultLi . '' . $resultPanes;
        $result = new HtmlString($result);
        return $result;
    }

    public function getHtmlAcademicsInstitution($params)
    {
        $data = $params['data'];


        $htmlLi = "";
        $htmlNavsPane = "";
        $init = true;
        $classCurrent = 'active show';
        foreach ($data as $key => $row) {


            $htmlLi .= ' <li class="nav-item" role="presentation"> ' . "\n";
            $htmlLi .= '   <a class="nav-link ' . $classCurrent . '" href="#tabs-7-' . $row->id . '" data-toggle="tab">' . $row->value . '</a>  ' . "\n";
            $htmlLi .= '  </li> ' . "\n";
            $htmlNavsPane .= '<div class="tab-pane fade  ' . $classCurrent . '" id="tabs-7-' . $row->id . '">';
            $htmlNavsPane .= '  <h2 class="title-about">' . $row->subtitle . '</h2>';
            $htmlNavsPane .= '  <div class="hr divider bg-madison bg-madison--custom divider-md-0"></div>';
            $htmlNavsPane .= '  <div class="offset-lg-top-60 text-color--custom-about">' . $row->description;
            $htmlNavsPane .= '  </div>';
            if ($row->allow_source) {
                $htmlNavsPane .= '  <div class="offset-top-30">';
                $htmlNavsPane .= '     <img class="img-responsive d-inline-block" src="' . URL($this->resourcePathServer . $row->source) . '" width="770"
            height="480" alt="">';
                $htmlNavsPane .= '   </div>';
            }
            $htmlNavsPane .= '</div>';

            if ($init) {
                $init = false;
                $classCurrent = '';
            }
        }


        $resultLi = '<ul class="nav nav-tabs">';
        $resultLi .= $htmlLi;
        $resultLi .= '</ul>';

        $resultPanes = '<div class="tab-content inset-lg-left-60">';
        $resultPanes .= $htmlNavsPane;
        $resultPanes .= '</div>';
        $result = $resultLi . '' . $resultPanes;
        $result = new HtmlString($result);
        return $result;
    }

    public function getHtmlFrequentQuestion($params)
    {
        $data = $params['data'];


        $htmlLi = "";

        $init = true;
        $classCurrent = '';
        $classCurrentAllow = 'true';
        $classCurrentBody = 'show';

        $parentSelector = 'accordion1';
        foreach ($data as $key => $row) {
            $elementSelector = 'accordion__link-' . $row->id;
            $elementBodySelector = 'accordion__body-' . $row->id;
            if (!$init) {
                $classCurrentAllow = 'false';
                $classCurrentBody = '';
                $classCurrent = 'collapsed';

            } else {
                $init = false;

            }
            $htmlLi .= '<article class="card card-custom card-corporate">';
            $htmlLi .= '    <div class="card-header" role="tab">';
            $htmlLi .= '         <div class="card-title">';
            $htmlLi .= '            <a id="' . $elementSelector . '" data-toggle="collapse"';
            $htmlLi .= '                 data-parent="#' . $parentSelector . '"';
            $htmlLi .= '                 class="' . $classCurrent . '"';
            $htmlLi .= '                 href="#' . $elementBodySelector . '"';
            $htmlLi .= '                 aria-controls="' . $elementBodySelector . '"';
            $htmlLi .= '                 aria-expanded="' . $classCurrentAllow . '" role="button">';
            $htmlLi .= $row->title;
            $htmlLi .= '                  <div class="card-arrow"></div>';
            $htmlLi .= '            </a>';
            $htmlLi .= '         </div>';
            $htmlLi .= '    </div>';
            $htmlLi .= '    <div class="collapse ' . $classCurrentBody . '" id="' . $elementBodySelector . '"';
            $htmlLi .= '       aria-labelledby="' . $elementSelector . '" data-parent="#' . $parentSelector . '"';
            $htmlLi .= '         role="tabpanel">';
            $htmlLi .= '         <div class="card-body">';
            $htmlLi .= $row->description;
            $htmlLi .= '         </div>';
            $htmlLi .= '    </div>';

            $htmlLi .= '</article>';


        }
        $result = $htmlLi;

        $result = new HtmlString($result);
        return $result;
    }

    public function getHtmlRequirements($params)
    {
        $data = $params['data'];


        $htmlLi = "";
        foreach ($data as $key => $row) {

            $htmlLi .= '<div class="row row-30 offset-top-10 text-md-left">';
            $htmlLi .= '    <div class="col-12">';
            $htmlLi .= '       <div class="section-30 inset-left-30 inset-right-30">';
            $htmlLi .= '          <div>';
            $htmlLi .= '               <h6 class="font-weight-bold">' . $row->title . '</h6>';
            $htmlLi .= '               <div>';
            $htmlLi .= $row->description;
            $htmlLi .= '               </div>';
            $htmlLi .= '          </div>';
            $htmlLi .= '       </div>';
            $htmlLi .= '    </div>';
            $htmlLi .= '</div>';


        }
        $result = $htmlLi;

        $result = new HtmlString($result);
        return $result;
    }

    public function getHtmlSlider($params)
    {
        $sliderInformation = $params['slider'];
        $sliderData = $sliderInformation['data'];
        $language = $sliderInformation['language'] == 'es' ? null : $sliderInformation['language'];


        $htmlCols = "";
        $count = count($sliderData);
        $htmlRow = '';
        foreach ($sliderData as $key => $row) {

            $id = 'rs-' . $row['id'];
            $src = $row['source'];
            $type_button = $row['type_button'];
            $options_all = $row['options_all'];
            $type_multimedia = $row['type_multimedia'];
            $type_button = $row['type_button'];

            $title = $language == null ? $row['title'] : (isset($row['title_lang']) && $row['title_lang'] ? $row['title_lang'] : $row['title']);
            $subtitle = $language == null ? $row['subtitle'] : (isset($row['subtitle_lang']) && $row['subtitle_lang'] ? $row['subtitle_lang'] : $row['subtitle']);

            $options_source = $row['options_source'];
            $options_button = $row['options_button'];
            $options_subtitle = $row['options_subtitle'];
            $button_name = $row['button_name'];

            $options_title = $row['options_title'];

            $htmlRow .= '<div  class="swiper-slide"      ' . "\n";
            $htmlRow .= '                     data-slide-bg="' . $src . '"' . "\n";
            $htmlRow .= '                     style="' . 'background-position: 80% center' . '">' . "\n";
            $hrefCurrent = '';


            $htmlRow .= '     <div class="swiper-slide-caption header-transparent-slide-caption">';
            $htmlRow .= '         <div class="container">';
            $htmlRow .= '              <div class="row justify-content-sm-center justify-content-xl-start no-gutters">';
            $htmlRow .= '                  <div class="col-lg-6 text-lg-left col-sm-10">';
            if ($type_multimedia == 1) {


                $htmlRow .= '                      <div data-caption-animate="fadeInUp" data-caption-delay="100"';
                $htmlRow .= '       data-caption-duration="1700">';
                $htmlRow .= '                          <h1 class="font-weight-bold">' . $title . '</h1>';
                $htmlRow .= '                     </div>';
                $htmlRow .= '                  <div class="offset-top-20 offset-xs-top-40 offset-xl-top-60"';
                $htmlRow .= '                        data-caption-animate="fadeInUp" data-caption-delay="150"';
                $htmlRow .= '                         data-caption-duration="1700">';
                $htmlRow .= '                      <h5 class="text-regular font-default">' . $subtitle;
                $htmlRow .= '                   </h5>';
                $htmlRow .= '                  </div>';
            }

            if ($type_button == 1) {
                $htmlRow .= '              <div class="offset-top-20 offset-xl-top-40" data-caption-animate="fadeInUp"';
                $htmlRow .= '                  data-caption-delay="400" data-caption-duration="1700">';
                $options_button = json_decode($options_button, true);
                $buttonsData = $options_button['data'];

                foreach ($buttonsData as $keyButton => $rowButton) {
                    $htmlRow .= '                   <a   class="btn button-madison btn-ellipse"  target="_blank" href="' . $rowButton['link'] . '">' . $rowButton['name'];
                    $htmlRow .= '             </a>';
                }

                //   $htmlRow .=  '                  <div class="inset-sm-left-30 d-xl-inline-block">';
                // $htmlRow .=     '                    <a class="btn button-primary btn-ellipse d-none d-xl-inline-block"';
                // $htmlRow .=      '                    href="academics.html">Learn More</a>';
                // $htmlRow .=  '                  </div>';
                $htmlRow .= '               </div>';
            }
            $htmlRow .= '                   </div>'; //col-lg-6
            $htmlRow .= '              </div>'; //row
            $htmlRow .= '            </div>'; //container
            $htmlRow .= '          </div>'; //swiper-slide-caption
            $htmlRow .= '        </div>' . "\n";
        }

        $result = '        <div class="swiper-container swiper-slider swiper-slider-3" data-autoplay="true" data-height="100vh"
                 data-loop="true" data-dragable="false" data-min-height="480px" data-slide-effect="true">';
        $result = $result . '   <div class="swiper-wrapper">';
        $result = $result . '    ' . $htmlRow;
        $result = $result . '   </div>';
        if ($count > 1) {

            $result = $result . ' <div class="swiper-pagination"></div>';
        }

        $result = $result . '</div>';

        $result = new HtmlString($result);
        return $result;
    }

    public function getProfilesHtml($params)
    {

        $data = $params['data'];
        $nameBusiness = $params['nameBusiness'];

        $nameRoute = 'profile' . $nameBusiness;

        $htmlCols = "";
        $htmlRow = "";
        $pathRoot = $this->resourcePathServer;

        foreach ($data as $key => $row) {
            $paramsRoute = ['language' => app()->getLocale(), 'id' => $row['parent']['id']];
            $urlView = route($nameRoute, $paramsRoute);
            $srcCurrent = URL($pathRoot . $row['parent']['src']);

            $fullName = $row['parent']['name'] . '  ' . $row['parent']['last_name'];
            $htmlRow .= '<div class="col-md-6 col-xl-4">';
            $htmlRow .= '     <div class="unit unit-sm flex-column flex-md-row unit-spacing-lg">';
            $htmlRow .= '         <div class="unit-left">';
            $htmlRow .= '           <img class="img-responsive d-inline-block img-rounded" src="' . $srcCurrent . '"';
            $htmlRow .= '             width="110" height="110" alt="">';
            $htmlRow .= '         </div>';
            $htmlRow .= '       <div class="unit-body">';

            $htmlRow .= '         <h6 class="font-weight-bold text-primary"><a href="' . $urlView . '">' . $fullName . '</a></h6>';
            $allowInformation = isset($row['phones']) || isset($row['emails']);
            if ($allowInformation) {
                $htmlRow .= '          <div class="offset-sm-top-30">';
                $htmlRow .= '             <ul class="list list-unstyled">';
                $htmlRow .= '   <li id="name-profile">';
                $htmlRow .= '   <p class="text-color--three text-color--custome">' . $row['parent']['summary_web'] . '</p>';
                $htmlRow .= '   </li>';


                $liEmails = '';
                if (isset($row['emails'])) {

                    $liEmails .= '               <li>';
                    foreach ($row['emails'] as $keyEmail => $rowEmail) {
                        $liEmails .= '                <a class="d-inline-block inset-left-10 text-color--two text--email" href="mailto:' . $rowEmail->value . '">' . $rowEmail->value . '</a>';
                    }
                    $liEmails .= '                </li>';
                }
                $htmlRow .= $liEmails;


                $htmlRow .= '            </ul>';
                $htmlRow .= '         </div>';
            }
            $htmlRow .= '      </div>';
            $htmlRow .= '    </div>';

            $htmlRow .= ' </div>';
        }

        $result = '        <section class="section section-xl bg-catskill">';
        $result = $result . '   <div class="container">';
        $result = $result . '      <h2 class=" text-color--one">Directivos</h2>';
        //$result = $result . '      <hr class="divider bg-madison">';
        $result = $result . '      <div class="row row-50 text-md-left offset-top-60">';

        $result = $result . '    ' . $htmlRow;
        $result = $result . '      </div>';
        $result = $result . '   </div>';
        $result = $result . '</section>';

        $result = new HtmlString($result);
        return $result;
    }

    public function getProfileHtml($params)
    {

        $data = $params['data'];

        $nameBusiness = $params['nameBusiness'];
        $row = $data;
        $nameRoute = 'profile' . $nameBusiness;
        $pathRoot = $this->resourcePathServer;
        $paramsRoute = ['language' => app()->getLocale(), 'id' => $row['parent']['id']];
        $urlView = route($nameRoute, $paramsRoute);
        $srcCurrent = URL($pathRoot . $row['parent']['src']);

        $htmlColOne = '';
        $htmlColTwo = '';

        $allowInformation = isset($row['phones']) || isset($row['emails']);
        $htmlColOneP0 = '';
        $htmlColOneP1 = '';

        $image = '<img class="img-responsive d-inline-block"
        src="' . $srcCurrent . '" width="340" height="340" alt="">';
        if ($allowInformation) {
            $htmlColOneP0 = '          <div class="offset-top-15 offset-sm-top-30">';
            $htmlColOneP0 .= '             <ul class="list list-unstyled">';
            $htmlColOneP0 .= '';
            $liEmails = '';
            $liPhones = '';
            if (isset($row['phones'])) {
                $liPhones .= '               <li><span class="icon icon-xs mdi mdi-phone text-middle text-madison"     ></span>';

                foreach ($row['phones'] as $keyPhone => $rowPhone) {

                    $liPhones .= '             <a  class="d-inline-block text-dark inset-left-10" href="tel:' . $rowPhone->information_phone . '">' . $rowPhone->information_phone . '</a>';
                }
                $liPhones .= '                </li>';
            }
            if (isset($row['emails'])) {

                $liEmails .= '               <li><span class="icon icon-xs mdi mdi-email-open text-middle text-madison" ></span>';
                foreach ($row['emails'] as $keyEmail => $rowEmail) {

                    $liEmails .= '                <a class="d-inline-block inset-left-10" href="mailto:' . $rowEmail->value . '">' . $rowEmail->value . '</a>';
                }
                $liEmails .= '                </li>';
            }
            $htmlColOneP0 .= $liPhones . $liEmails;
            $htmlColOneP0 .= '            </ul>';
            $htmlColOneP0 .= '         </div>';
        }

        if (isset($data['social-networks'])) {
            $liSocial = '<ul class="list-inline list-inline-xs list-inline-madison">';

            foreach ($row['social-networks'] as $keySocial => $rowSocial) {
                $liSocial .= '               <li>';
                $liSocial .= '                <a  target="_blank" class="icon icon-xxs ' . $rowSocial->icon . ' icon-circle icon-gray-light-filled" href="' . $rowSocial->value . '">' . '' . '</a>';
                $liSocial .= '                </li>';
            }
            $liSocial .= '</ul>';

            $htmlColOneP1 = '<div class="offset-top-15 offset-sm-top-30">';
            $htmlColOneP1 .= $liSocial;
            $htmlColOneP1 .= '</div>';
        }


        $htmlColOne = '<div class="col-md-5 col-lg-4 text-md-left">';
        $htmlColOne .= '    <div class="inset-md-right-30">';
        $htmlColOne .= $image;
        $htmlColOne .= $htmlColOneP0;
        $htmlColOne .= $htmlColOneP1;
        $htmlColOne .= '   </div>';
        $htmlColOne .= '</div>';

        $htmlColTwo = '<div class="col-md-7 col-lg-8 text-left">';
        $htmlColTwo .= '   <div>';
        $htmlColTwo .= '    <h2 class="">' . $row['parent']['name'] . ' ' . $row['parent']['last_name'] . '</h2>';
        $htmlColTwo .= '   </div>';
        $htmlColTwo .= '   <p class="offset-top-10">' . $row['parent']['people_profession'] . '</p>';
        $htmlColTwo .= '   <div class="offset-top-15 offset-sm-top-30">';
        $htmlColTwo .= '      <hr class="divider bg-madison hr-left-0">';
        $htmlColTwo .= '   </div>';
        $htmlColTwo .= $row['parent']['description'];
        $htmlColTwo .= '</div>';

        $result = $htmlColOne . '' . $htmlColTwo;

        $result = new HtmlString($result);
        return $result;
    }

    public function getPartnerCompaniesHtml($params)
    {

        $htmlCols = "";
        $dataInformation = $params['data'];
        $nameBusiness = $params['nameBusiness'];

        $htmlRow = '';

        $resourcePathServer = $this->resourcePathServer;
        foreach ($dataInformation as $key => $row) {
            $sourceCurrent = URL($resourcePathServer . $row->source);
            $htmlRow .= '<div class="col-md-6 col-lg-3">';
            $htmlRow .= '<article class="post-news post-news-mod-1 view-animate fadeInLeftSm delay-04 post-partners-companies">';
            $urlView = $row->subtitle;
            $htmlRow .= '<a target="_blank" href="' . $urlView . '" >';
            if ($row->allow_source) {
                $htmlRow .= '<img class="img-responsive img-fullwidth img--partners-companies"';
                $htmlRow .= 'src="' . $sourceCurrent . '"';
                $htmlRow .= '>';
            }
            $htmlRow .= ' </a>';
            $htmlRow .= ' </article>';
            $htmlRow .= '</div>';
        }

        $result = '           <section class="section bg-catskill section-xl">';
        $result .= '            <div class="container container-wide">';

        $result = $result . '      <div class="row row-30  text-left justify-content-sm-center">';
        $result = $result . '    ' . $htmlRow;
        $result = $result . '      </div>';
        $result = $result . '  </div>';
        $result = $result . '</section>';
        $result = new HtmlString($result);
        return $result;
    }

    public function getNewsHtml($params)
    {

        $htmlCols = "";
        $dataInformation = $params['data'];
        $nameBusiness = $params['nameBusiness'];
        $count = count($dataInformation);
        $htmlRow = '';


        $dateCurrent = \App\Utils\Util::DateCurrent();


        $resourcePathServer = $this->resourcePathServer;
        foreach ($dataInformation as $key => $row) {
            $sourceCurrent = URL($resourcePathServer . $row->source);
            $htmlRow .= '<div class="col-md-6 col-lg-3">';
            $htmlRow .= '<article class="post-news post-news-mod-1 view-animate fadeInLeftSm delay-04">';
            $nameRoute = 'new' . $nameBusiness;
            $paramsRoute = ['language' => app()->getLocale(), 'id' => $row->id];
            $urlView = route($nameRoute, $paramsRoute);
            $htmlRow .= '<a href="' . $urlView . '">';
            if ($row->allow_source) {


                $htmlRow .= '<img class="img-responsive img-fullwidth"';
                $htmlRow .= 'src="' . $sourceCurrent . '"';
                $htmlRow .= 'width="370" height="240" alt="">';
            }
            $htmlRow .= ' </a>';

            $htmlRow .= '<div class="post-news-body">';
            $htmlRow .= '<h6><a href="' . $urlView . '">' . $row->value . '</a></h6>';
            $htmlRow .= '<div class="offset-top-20 text-color--three">';

            $horaInicio = new DateTime($row->created_at);
            $horaTermino = new DateTime($dateCurrent);
            $interval = $horaInicio->diff($horaTermino);

            if ($interval->d > 0) {
                $dayString = $interval->d == 1 ? 'dia' : 'dias';
                $resultDay = $interval->format('%d ' . $dayString . ' atras');
            } else {
                $resultDay = $interval->format('%i minutos %s segundos atras');
            }


            $htmlRow .= $row->subtitle;
            $htmlRow .= '</div>';
            $htmlRow .= '<div class="post-news-meta offset-top-20"><span ';
            $htmlRow .= ' class="icon icon-xs mdi mdi-calendar-clock text-middle text-madison"></span><span';

            $htmlRow .= '  class="text-middle inset-left-10 font-italic text-black">' . $resultDay . '</span></div>';
            $htmlRow .= '</div>';
            $htmlRow .= ' </article>';
            $htmlRow .= '</div>';
        }

        $result = '           <section class="section bg-catskill section-xl">';
        $result .= '            <div class="container container-wide">';
        $result .= '               <h2 class="text-color--one">Noticias</h2>';
        $result = $result . '      <div class="row row-30 offset-top-60 text-left justify-content-sm-center">';
        $result = $result . '    ' . $htmlRow;
        $result = $result . '      </div>';
        $result = $result . '  </div>';
        $result = $result . '</section>';
        $result = new HtmlString($result);
        return $result;
    }

    public static function getHtmlSocialNetwork($params)
    {
        $data = $params['data'];
        $type = $params['type'];
        $title = $params['title'];

        $htmlRow = "";


        foreach ($data as $key => $row) {
            $value = $row->value;
            $information_social_network_type = $row->information_social_network_type;
            $icon = $row->icon;
            $htmlRow .= '<li><a class="icon icon-xxs ' . $icon . ' icon-circle icon-gray-light-filled" href="' . $value . '" target="_blank"></a></li>';
        }

        if ($type == 'footer') {

            $result = '<div class="offset-top-15 text-left">';
            $result .= '<ul class="list-inline list-inline-xs list-inline-madison">';
            $result .= $htmlRow;
            $result .= '</ul>';
            $result .= '</div>';
        } else {

            $result = '';
            $result .= '<ul class="list-inline list-inline-xs list-inline-madison"';
            $result .= $htmlRow;
            $result .= '</ul>';
        }
        $result = new HtmlString($result);
        return $result;
    }
}
