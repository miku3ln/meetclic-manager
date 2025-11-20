<?php

namespace App\Models;

use App\Models\ProductDistributions\ProductParentByProduct;
use App\Models\Products\Product;
use App\Utils\FrontendPageSections;
use App\Utils\Util;
use Auth;
use Frontend;
use Illuminate\Support\HtmlString;
use Route;


class FrontendCityBookManager extends ModelManager
{
    const BUSINESS_ID = 1;
    public $resourcePathServer = '';
    public $modelFMD = null;

    function __construct()
    {
        $this->resourcePathServer = env('APP_IS_SERVER') ? "public" : '';
        $this->modelFMD = new \App\Models\FrontendManagerData();
    }


    public function getParamsPage($params)
    {

        $jpgNameCurrent = "JPG";
        $pngNameCurrent = "PNG";
        $page = $params['page'];
        $paramsRequest = $params['paramsRequest'];
        $language = $paramsRequest['language'];
        $resultPageData = $this->modelFMD->getPageData($params);
        $modelCategories = FrontendPageSections::PROJECT_TYPE_EVENT ? new EventsTrailsTypes() : new ProductCategory();
        $allowTemplate = $resultPageData['allowTemplate'];
        $template_information_id = $resultPageData['template_information_id'];
        $entity_id = $resultPageData['entity_id'];
        $entity_type_business = $resultPageData['entity_type_business'];
        $pageSectionsConfig = $resultPageData['pageSectionsConfig'];
        $business_id = self::BUSINESS_ID;
        $dataManagerPage = $resultPageData['dataManagerPage'];

        $dataBusiness = $resultPageData['dataBusiness'];

        $dataFooter = array();
        $dataMenu = array();
        $dataSocialNetworksHtml = '';
        $categoriesBusiness = [];
        $categoriesByProducts = [];

        $viewPage = true;
        $dataManagerPage['allowPlugins'] = [];
        $dataManagerPage['allowFooterMenu'] = true;

        //MANAGER BUSINESS
        $pathCurrentResources = '';
        $configPartial = [];
        $modelCategoriesBusiness = new \App\Models\BusinessCategories();
        $categoriesBusinessManager = $modelCategoriesBusiness->getAllCategoriesCount([
            'path' => $this->resourcePathServer
        ]);
        $categoriesByProductsManager = $modelCategoriesBusiness->getAllCategoriesByProducts([
            'path' => $this->resourcePathServer,
            "business_id" => $business_id
        ]);


        $shopConfig = $this->modelFMD->getShopConfig([
            'filters' => [
                'status' => 'ACTIVE',
                'template_information_id' => 1
            ]
        ]);

        $dataManagerPage['shopConfig'] = $shopConfig;
        if ($categoriesBusinessManager['success']) {

            $categoriesBusiness = $categoriesBusinessManager['data'];

            $dataManagerPage['categoriesBusiness'] = $categoriesBusiness;
        }
        if ($categoriesByProductsManager['success']) {

            $categoriesByProducts = $categoriesByProductsManager['data'];

            $dataManagerPage['categoriesByProducts'] = $categoriesByProducts;
        }
        $publicAsset = env('APP_IS_SERVER') ? "public" : '';

        $resourcePathServer = $publicAsset;
        $dataManagerPage['menuAccountManagementUser'] = $this->modelFMD->getMenuAccountManagementUser($resultPageData['profileConfig'], $page);

        $allowCounters = ($page == 'home' || $page == 'homePage' || $page == 'aboutUs') ? true : false;

        if ($allowCounters) {
            $modelCounter = new \App\Models\Tracking\TrackingEvents();
//BUSINESS HOME
            $weekVisit = $modelCounter->getCountersBusiness([
                'filters' => [
                    'isWeek' => true,
                    "allVisit" => true,

                ]
            ]);

            $views = 0;
            $customersSatisfied = 0;
            $awards = 0;
            $reviews = 0;
            $rating = 0;
            $hearth = 0;
            $listingWeek = 0;
            $dataManagerPage['counters'] = [
                'weekVisit' => [
                    'title' => '',
                    'count' => $weekVisit
                ],
                'views' => [
                    'title' => '',
                    'count' => $views
                ],
                'reviews' => [
                    'title' => '',
                    'count' => $reviews
                ],
                'rating' => [
                    'title' => '',
                    'count' => $rating
                ],
                'customersSatisfied' => [
                    'title' => '',
                    'count' => $customersSatisfied
                ],
                'awards' => [
                    'title' => '',
                    'count' => $awards
                ],
                'hearth' => [
                    'title' => '',
                    'count' => $hearth
                ],
                'listingWeek' => [
                    'title' => '',
                    'count' => $listingWeek
                ]
            ];
        }

        if ($page == 'homePage' || $page == 'home') {
            $dataManagerPage['allowPlugins']['leafletMaps'] = true;
            $dataManagerPage['allowVue'] = true;

            $dataManagerPage['type'] = $paramsRequest['type'];
            $dataManagerPage['allowPlugins']['googleMaps'] = true;

            if ($allowTemplate) {
                $modelParent = new  \App\Models\TemplateSlider();
                $dataSlider = $modelParent->getSliderMainFrontend(array(
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer
                ));

                if (count($dataSlider) > 0) {
                    $dataManagerPage['sliderMainManager'] = $dataSlider;
                }

                $sliderMainManagerOther = $modelParent->getSliderOneFrontend(array(
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer
                ));

                $dataManagerPage['sliderMainManagerOne']["data"] = $sliderMainManagerOther;


                $sliderMainManagerOther = $modelParent->getSliderTwoFrontend(array(
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer
                ));

                $dataManagerPage['sliderMainManagerTwo']["data"] = $sliderMainManagerOther;

                $sliderMainManagerOther = $modelParent->getSliderThreeFrontend(array(
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer
                ));

                $dataManagerPage['sliderMainManagerThree']["data"] = $sliderMainManagerOther;
                $paramsRequestCurrent = [
                    'filters' => [
                        'language' => $paramsRequest['language']
                    ],
                ];
                $popularList = $this->getPopularList($paramsRequestCurrent);
                if ($popularList['allow-data']) {

                    $dataManagerPage['popularList'] = $popularList;
                }
            }

        } else if ($page == 'search') {
            $dataManagerPage['allowPlugins']['googleMaps'] = true;
            $dataManagerPage['allowVue'] = true;
            $categoryNeedle = $paramsRequest['category'] ? $paramsRequest['category'] : null;

            $categoryId = null;
            $categoryData = [];
            if ($categoryNeedle) {
                $modelBC = new \App\Models\BusinessCategories;
                $resultCategory = $modelBC->getCategoryFilters(
                    [
                        'filters' => [
                            'search_value' => [
                                'term' => $categoryNeedle
                            ]
                        ]
                    ]
                );
                if ($resultCategory) {
                    $categoryId = $resultCategory->id;
                    $categoryData = $resultCategory;
                }
            }

            $paramsRequestCurrent = [
                'searchPhrase' => $paramsRequest['keywords'],
                'filters' => [
                    'language' => $paramsRequest['language'],
                    'category_id' => $categoryId,
                ],
                'categoryData' => $categoryData
            ];
            $dataManagerPage['items'] = $this->getValuesBusiness($paramsRequestCurrent);
            $dataManagerPage['paramsRequestCurrent'] = $paramsRequestCurrent;
            $paramsRequest['categoryData'] = $categoryData;
        } else if ($page == 'listingSingle') {
            $dataManagerPage['allowPlugins']['googleMaps'] = true;
        } else if ($page == 'managerInvitationOtavalo') {

            $viewPage = false;

            $modelBusiness = new \App\Models\Customer();
            $business_id = null;
            $paramId = $paramsRequest['id'];

            $information = $modelBusiness->getCustomerRegisters([
                'filters' => [
                    'identification_document' => $paramId
                ]
            ]);
            if ($information) {

                $viewPage = true;
                $dataManagerPage['information'] = ['customer' => $information,
                    'resources' => [
                        'header' => 'https://www.meistertask.com/embed/at/30230230/large/91a7064d6bd1ebf16b920b944d915f8d5c851603.png'
                    ],
                    'location' => env('locationEventOtavalo'),
                    'one' => 'SEÑOR',
                    'title' => 'SEÑOR',


                ];

            }

        } else if ($page == 'businessDetails') {
            $pageSectionsConfig['business']['viewWhatsAppMain'] = false;
            $resultBusinessDetails = Util::getDataBusinessAll($params);
            $dataManagerPage = array_merge($dataManagerPage, $resultBusinessDetails);
            if ($resultBusinessDetails["viewPage"]) {
                $pageSectionsConfig['head_custom']['business']['data'] = $resultBusinessDetails["pageSectionsConfig"];
            }


        } else if ($page == 'authorSingle') {//CMS-TEMPLATE-AUTHOR-SINGLE-VIEW-DATA
            $dataManagerPage['allowPlugins']['googleMaps'] = true;
            $dataManagerPage['allowVue'] = true;
            $modelCustomerUser = new \App\Models\CustomerByProfile();
            $authorSingeData = $modelCustomerUser->getDataProfileUser([
                'filters' => [
                    'user_id' => $paramsRequest['id'],
                    'isLogin' => false
                ]
            ]);
            $paramsSendMeta = [
                'manager' => $authorSingeData,
                "resourcePathServer" => $this->resourcePathServer
            ];
            $informationCurrent = $modelCustomerUser->getInformationProfile($paramsSendMeta);

            $dataManagerPage['authorSingleData'] = $authorSingeData;
            $dataManagerPage['authorSingleData']['information'] = $informationCurrent;


        } else if ($page == 'orders') {

            $dataManagerPage['allowVue'] = true;
        } else if ($page == 'pointsSales') {

            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.my-business');

            $dataCatalogue = array();
            $pathCurrentResources = 'cityBook/management/pointsSales';
            $configPartial = [
                'moduleFolder' => 'pointsSales',
                'moduleCamel' => 'pointsSales',
                'moduleMain' => 'management',
                'managementNameCurrent' => 'PointsSales',

                'dataCatalogue' => $dataCatalogue,
                'moduleResource' => 'pointsSales',

            ];
            $dataManagerPage['allowVue'] = true;
        } else if ($page == 'howItWorks') {

        } else if ($page == 'dictionaryType') {//CMS-TEMPLATE-MENU-DATA---KICHWA-CASTILIAN


            $dataManagerPage['allowPlugins']['googleMaps'] = true;
            $dataManagerPage['allowVue'] = true;

            $title = '';
            $subtitle = '';

            $themePath = $resourcePathServer . '/templates/cityBookHtml/';
            $dataManagerPage['allowVue'] = true;
            $backgroundData = [
                'url' => '',
                'title' => '',
                'subtitle' => '',

            ];
            if ($paramsRequest['type'] == 1) {
                $title = __('frontend.dictionary.slider.title');
                $subtitle = __('frontend.dictionary.slider.subtitle');

                $backgroundData = [
                    'url' => URL($themePath . 'images/bg/41.png'),
                    'title' => $title,
                    'subtitle' => $subtitle,

                ];
            } else if ($paramsRequest['type'] == 2) {
                $title = __('frontend.dictionaryCastilianToKichwa.slider.title');
                $subtitle = __('frontend.dictionaryCastilianToKichwa.slider.subtitle');

                $backgroundData = [
                    'url' => URL($themePath . 'images/bg/41.png'),
                    'title' => $title,
                    'subtitle' => $subtitle,

                ];
            }

            $informationCurrent = [
                'urlManagerRoot' => route('dictionaryType', [app()->getLocale(), 'type' => $paramsRequest['type']]),
                'urlManager' => route('dictionaryType', [app()->getLocale(), 'type' => $paramsRequest['type']]),

                'title' => $title . '-' . $subtitle,
                'source' => asset($this->resourcePathServer . '/images/frontend/meta-data/dictionaryType/image-main.png'),
                'descriptionData' => '
                Meetclick-Developer(Alex-Alba)
El idioma desempeña un papel esencial en la cultura de un pueblo, ya que actúa como un vehículo para la comunicación y la expresión. A través del lenguaje, las personas pueden compartir sus pensamientos, sentimientos y experiencias, fortaleciendo los lazos sociales y fomentando un sentido de pertenencia y comunidad. Además, el idioma es un componente crucial de la identidad cultural, reflejando la historia, el origen y las relaciones de una comunidad. La transmisión de conocimientos, tradiciones y valores se realiza principalmente a través del idioma, utilizando narrativas orales, literatura y otras formas de expresión artística. La diversidad lingüística refleja la diversidad cultural en el mundo y preservar los idiomas minoritarios es fundamental para proteger esta diversidad y promover la tolerancia intercultural. Además, el idioma influye en el desarrollo cognitivo de las personas, afectando su forma de pensar y percibir el mundo. El dominio del idioma puede influir en las oportunidades de educación, empleo y participación en la sociedad, mientras que la preservación de los idiomas tradicionales es crucial para salvaguardar el patrimonio cultural de la humanidad en un mundo globalizado. ',

            ];
            $dataManagerPage['dictionaryTypeData']['information'] = $informationCurrent;
            $dataManagerPage['dataProcess'] = ['dictionaryLanguageId' => $paramsRequest['type']];
            $dataManagerPage['dataProcess']['backgroundData'] = $backgroundData;

        } else if ($page == 'price') {
        } else if ($page == 'shop') {
            $modelCategories = new \App\Models\ProductCategory;

            $dataCategoriesResult = $modelCategories->getListCategoriesFrontend([
                'filters' => [
                    'language' => $language,
                    'business_id' => $business_id
                ]
            ]);
            $dataManagerPage['allowVue'] = true;
            $dataManagerPage['categories'] = $dataCategoriesResult;

        } else if ($page == 'myProfile') { //ACCOUNT CMS-TEMPLATE-MY-PROFILE-PROCESS
            $modelPTI = new \App\Models\PeopleTypeIdentification();
            $modelPN = new \App\Models\PeopleNationality();
            $modelPP = new \App\Models\PeopleProfession();
            $modelRT = new \App\Models\RucType();
            $modelC = new \App\Models\Country();

            $peopleTypeIdentification = $modelPTI->getDataListAll();
            $peopleProfession = $modelPP->getDataListAll();
            $peopleNationality = $modelPN->getDataListAll();
            $rucType = $modelRT->getDataListAll();
            $countriesData = $modelC->getCountries();

            $locationData = $modelC->getStructureLocation($countriesData);

            $dataCatalogue = array(
                "peopleTypeIdentification" => $peopleTypeIdentification,
                "peopleProfession" => $peopleProfession,
                "peopleNationality" => $peopleNationality,
                "rucType" => $rucType,
                'locationData' => $locationData

            );
            $dataManagerPage["dataCatalogue"] = $dataCatalogue;
            $dataManagerPage['allowPlugins']['googleMaps'] = true;
            $dataManagerPage['allowVue'] = true;
            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.profile');
            $dataManagerPage['attributesFormDefault'] = [
                'gender_data' => \App\Models\PeopleGender::GENDER_MEN,
                'people_type_identification_id_data' => \App\Models\PeopleTypeIdentification::TYPE_IDENTIFICATION_CARD,
                'ruc_type_id_natural' => \App\Models\RucType::RUC_TYPE_NATURAL_PERSON,
                'ruc_type_id_society_public' => \App\Models\RucType::RUC_TYPE_PUBLIC_SOCIETY,
                'ruc_type_id_society_private' => \App\Models\RucType::RUC_TYPE_PRIVATE_SOCIETY,
                'ruc_type_id_any' => \App\Models\RucType::RUC_TYPE_ANY,

                'people_nationality_id_data' => \App\Models\PeopleNationality::TYPE_ANYONE,
                'people_profession_id_data' => \App\Models\PeopleProfession::TYPE_ANYONE,
                'countries_id' => \App\Models\Country::ECUADOR_ID, //ecuador
                'provinces_id' => \App\Models\Province::IMBABURA_ID, //imbabura
                'cities_id' => \App\Models\City::OTAVALO_ID, //otavalo
                'zones_id' => \App\Models\Zone::SAN_LUIS_ID, //san luis
                'information_address_type_id_data' => \App\Models\InformationAddressType::TYPE_HOME, //domicilio
                'information_phone_operator_id' => \App\Models\InformationPhoneOperator::OPERATOR_NOT_SPECIFIC_ID, //sin definir
                'information_phone_type_id' => \App\Models\InformationPhoneType::TYPE_WORKFORCE_ID, //personal
                'information_social_network_type_id_one' => \App\Models\InformationSocialNetworkType::TYPE_FACEBOOK_ID,//CMS-TEMPLATE-MY-PROFILE-DEFAULT
                'information_social_network_type_id_two' => \App\Models\InformationSocialNetworkType::TYPE_INSTAGRAM_ID,//CMS-TEMPLATE-MY-PROFILE-DEFAULT
                'information_social_network_type_id_three' => \App\Models\InformationSocialNetworkType::TYPE_TWITTER_ID,//CMS-TEMPLATE-MY-PROFILE-DEFAULT
                'information_social_network_type_id_four' => \App\Models\InformationSocialNetworkType::TYPE_LINKEDIN_ID,//CMS-TEMPLATE-MY-PROFILE-DEFAULT
                'information_social_network_type_id_five' => \App\Models\InformationSocialNetworkType::TYPE_YOUTUBE_ID,//CMS-TEMPLATE-MY-PROFILE-DEFAULT
                'information_social_network_type_id_six' => \App\Models\InformationSocialNetworkType::TYPE_TIKTOK_ID,//CMS-TEMPLATE-MY-PROFILE-DEFAULT

                'typeIdentificationRuc' => \App\Models\PeopleTypeIdentification::TYPE_IDENTIFICATION_RUC,
            ];
        } else if ($page == 'account') { //ACCOUNT
            $configPartial = [
                'moduleFolder' => 'business',
                'moduleMain' => 'business',
                'moduleResource' => 'business',

            ];
            $dataManagerPage['allowVue'] = true;//TODO REVIEW
            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.dashboard');
        } else if ($page == 'password') { //ACCOUNT

            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.change-password');
            $dataManagerPage['allowVue'] = true;
        } else if ($page == 'suggestionsMailBox') { //ACCOUNT

            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.suggestions-mailbox');
        } else if ($page == 'listings') { //ACCOUNT

            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.my-queens');
        } else if ($page == 'bee') { //ACCOUNT

            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.my-bees');
        } else if ($page == 'reviewsTo') { //ACCOUNT

            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.reviews');
        } //MANAGER BUSINESS
        else if ($page == 'business' || $page == 'businessEmployer') {
            $dataManagerPage['breadcrumb']['active'] = __('frontend.account.menu.my-business');

            $modelS = new \App\Models\BusinessSubcategories();
            $modelC = new \App\Models\Country();
            $modelB = new \App\Models\Bank();

            $subcategories = $modelS->getSubcategories();
            $countriesData = $modelC->getCountries();
            $locationData = $modelC->getStructureLocation($countriesData);
            $bankData = $modelB->getListBank();
            $dataCatalogue = array(
                "subcategories" => $subcategories,
                'locationData' => $locationData,
                'bankData' => $bankData,

            );
            $pathCurrentResources = 'business/business';
            $configPartial = [
                'moduleFolder' => 'business',
                'moduleMain' => 'business',
                'dataCatalogue' => $dataCatalogue,
                'moduleResource' => 'business',

            ];
            $dataManagerPage['allowVue'] = true;
        } /* OWNER BUSINESS*/ else if ($page == 'aboutUs') {
            $pageCurrent = "about-us";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/background-our.jpg";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $htmlImageCurrent = '<img  class="center center--background-about-us"  src="' . $urlImageCurrent . '" class="img-fluid" alt="">';
            $dataManagerPage['backgroundAboutUsHtml'] = new HtmlString($htmlImageCurrent);
            $dataManagerPage['backgroundAboutUsImage'] = $urlImageCurrent;

            //SERVICES
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/habilidades.svg";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['servicesImage'] = $urlImageCurrent;

//ABOUT TEAM
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/team-one." . $pngNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['teamOneImage'] = $urlImageCurrent;
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/team-two." . $pngNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['teamTwoImage'] = $urlImageCurrent;
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/team-three." . $pngNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['teamThreeImage'] = $urlImageCurrent;
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/team-four." . $pngNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['teamFourImage'] = $urlImageCurrent;

            if ($allowTemplate) {

                $modelParent = new TemplateAboutUs();
                $dataParent = $modelParent->getAboutUsFrontend(
                    [
                        'filters' => [
                            'template_information_id' => $template_information_id,
                            'language' => $language
                        ]
                    ]
                );
                if ($dataParent != false) {
                    $dataManager = [];
                    $dataManager['parent'] = $dataParent;
                    $modelChildren = new \App\Models\TemplateAboutUsByData();
                    $parent_id = $dataParent->id;
                    $childrenData = $modelChildren->getAboutUsDataFrontend([
                        'filters' => [
                            'template_about_us_id' => $parent_id,
                            'language' => $language
                        ]
                    ]);
                    if (count($childrenData) > 0) {
                        $dataManager['children'] = $childrenData;
                    }

                    $dataManagerPage['dataPage'] = $dataManager;

                    $modelProfileHuman = new \App\Models\HumanResourcesEmployeeProfile;
                    $profileData = $modelProfileHuman->getData([
                        "filters" => [
                            'business_id' => $business_id
                        ]
                    ]);

                    if (count($profileData)) {

                        $resultRows = Util::getRowsByDataBS3(array("haystack" => $profileData));
                        $htmlRow = '<div class="about-us-process-wrapper">';
                        $htmlRow .= '    <div class="container">';
                        $resourcePathServer = $this->resourcePathServer;
                        $modelProfileInformation = new \App\Models\InformationSocialNetwork();

                        foreach ($resultRows as $key => $valueRow) {
                            $columns = $valueRow['data'];
                            $htmlRow .= '     <div class="team-holder section-team fl-wrap row-number-' . $key . '"  >';
                            $countCurrent = count($columns);

                            foreach ($columns as $keyCol => $column) {

                                $source = URL($resourcePathServer . $column->src);

                                $htmlRow .= '       <div class="team-box">';
                                $htmlRow .= '         <div class="team-photo">';
                                $htmlRow .= '           <img src="' . $source . '" alt="" class="respimg">';

                                $htmlRow .= '          </div>';
                                $htmlRow .= '          <div  class="team-info">';
                                $htmlRow .= '              <h3><a href="#">' . $column->name . ' ' . $column->last_name . '</a></h3>';
                                $htmlRow .= '              <h4>' . $column->name . ' ' . $column->people_profession . '</h4>';
                                $htmlRow .= '              <p>' . $column->description . '</p>';

                                $entity_id = $column->id;
                                $resultCurrentData = $modelProfileInformation->getInformationData([
                                    'filters' => [
                                        'state' => $modelProfileInformation::STATE_ACTIVE,
                                        'main' => $modelProfileInformation::MAIN,
                                        'entity_type' => $modelProfileInformation::ENTITY_TYPE_EMPLOYER,
                                        'entity_id' => $entity_id,

                                    ]
                                ]);

                                if (count($resultCurrentData)) {

                                    $htmlRow .= '              <ul class="team-social">';
                                    foreach ($resultCurrentData as $keySocial => $socialRow) {
                                        $htmlRow .= '                 <li><a href="' . $socialRow->information_social_network . '" target="_blank"><i class="' . $socialRow->social_network_icon . '"></i></a></li>';
                                    }
                                    $htmlRow .= '              </ul>';
                                }

                                $htmlRow .= '          </div>';

                                $htmlRow .= '        </div>';
                            }
                            $htmlRow .= '    </div>';
                        }
                        $htmlRow .= '    </div>';

                        $htmlRow .= '</div>';

                        $dataManagerPage['dataPage']['teamHtml'] = $htmlRow;
                    }
                }
            }
        } else if ($page == 'contactUs') {

            $resultContactUs = FrontendPageSections::getDataContactUs([
                'dataBusiness' => $dataBusiness,
                'page' => $page,
                'publicAsset' => $publicAsset,
                'allowTemplate' => $allowTemplate,
                'template_information_id' => $template_information_id,
                'business_id' => $business_id,
                'resultPageData' => $resultPageData,
                'jpgNameCurrent' => $jpgNameCurrent,
                'resourcePathServer' => $resourcePathServer,

            ]);
            $dataManagerPage = array_merge($dataManagerPage, $resultContactUs);


        } else if ($page == 'productDetails') {
            $modelP = new Products\Product();
            $resultProduct = $modelP->getProductDetailsFrontend([
                'filters' => [
                    'product_id' => $params['productId'],
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer,
                    'business_id' => $business_id
                ]
            ]);
            if ($resultProduct['success']) {
                $resultProduct['allowShop'] = $dataManagerPage['shopConfig']['allow'];
                $dataManagerPage['productDetails'] = Frontend::getHtmlProductDetails($resultProduct);
                $pageSectionsConfig['head']['metaData']['html'] = Frontend::getHtmlMetaDataProduct($resultProduct);
                $pageSectionsConfig['head']['metaData']['view'] = true;
                $dataManagerPage['productData'] = $resultProduct;

            }
            $dataManagerPage['allowVue'] = true;
        } else if ($page == 'checkout') {
            $dataManagerPage['allowVue'] = true;

            $modelC = new \App\Models\Country();
            $dataCountries = $modelC->getListCountries();
            $dataCountriesManager = $modelC->getProvincesByDataCountries($dataCountries);
            $dataManagerPage['countriesBillingAddress'] = Frontend::getHtmlCountriesSelect(
                [
                    'data' => $dataCountries,
                    'id' => 'country_id',
                    'name' => 'OrderBillingCustomer[country_id]',
                    'required' => true,
                    'class' => 'form-control',
                    "resourcePathServer" => $this->resourcePathServer
                ]
            );
            $dataManagerPage['dataCountriesManager'] = $dataCountriesManager;
            if ($dataManagerPage['shopConfig']['allow']) {

                $dataManagerPage['typePayments'] = Frontend::getHtmlPaymentsTypes(['data' => $dataManagerPage['shopConfig']['data'],
                    "resourcePathServer" => $this->resourcePathServer]);
            }

        } else if ($page == 'checkoutDetails') {

            $modelCurrent = new \App\Models\OrderShoppingCart();
            $resultCheckout = $modelCurrent->getCheckoutDetailsFrontend([
                'filters' => [
                    'id' => $paramsRequest['id'],
                    'language' => $language,
                    'checkout' => $paramsRequest['checkout'],
                    "resourcePathServer" => $this->resourcePathServer
                ]
            ]);

            if ($resultCheckout->success) {

                $dataManagerPage['checkoutDetails'] = Frontend::getHtmlCheckoutDetails($resultCheckout);
                $dataManagerPage['checkoutData'] = $resultCheckout;


            }

        } //new
        else if ($page == 'productFlowers') {
            $pageCurrent = "products";
            $sectionProduct = "flowers";
            $dataSlider = [];
            //slider MAIN
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-1." . "png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-2." . "png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-3." . "png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-4." . "png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-5." . "png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-6." . "png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);


            $dataManagerPage['sliderMainImage']["data"] = $dataSlider;

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-one." . $jpgNameCurrent;
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundOne'] = $urlImageCurrent;

            $carouselOneColOne = [];
            $carouselOneColTwo = [];
            $carouselOneColThree = [];
            $carouselOneColFour = [];

            $carouselTwoColOne = [];
            $carouselTwoColTwo = [];
            $carouselTwoColThree = [];
            $carouselTwoColFour = [];

            $carouselThreeColOne = [];
            $carouselThreeColTwo = [];
            $carouselThreeColThree = [];
            $carouselThreeColFour = [];
            $carouselThreeColFive = [];
            $carouselThreeColSix = [];

            $pathCarouselNumber = "carousel/One/col-1";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);
            $dataManagerPage['carouselOneColOne'] = $carouselOneColOne;
//COL 2
            $pathCarouselNumber = "carousel/One/col-2";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/7.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);
            $dataManagerPage['carouselOneColTwo'] = $carouselOneColTwo;

            //COL 3
            $pathCarouselNumber = "carousel/One/col-3";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/7.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $dataManagerPage['carouselOneColThree'] = $carouselOneColThree;

            //COL 4
            $pathCarouselNumber = "carousel/One/col-4";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselOneColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $dataManagerPage['carouselOneColFour'] = $carouselOneColFour;

            //CAROUSEL TWO
            //01
            $pathCarouselNumber = "carousel/Two/col-1";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);
            $dataManagerPage['carouselTwoColOne'] = $carouselTwoColOne;

            //02
            $pathCarouselNumber = "carousel/Two/col-2";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/7.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/8.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);
            $dataManagerPage['carouselTwoColTwo'] = $carouselTwoColTwo;

            //03
            $pathCarouselNumber = "carousel/Two/col-3";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/7.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/8.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);
            $dataManagerPage['carouselTwoColThree'] = $carouselTwoColThree;

            //04
            $pathCarouselNumber = "carousel/Two/col-4";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/7.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/8.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/9.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/10.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/11.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselTwoColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);
            $dataManagerPage['carouselTwoColFour'] = $carouselTwoColFour;


            //CAROUSEL THREE
            //01
            $pathCarouselNumber = "carousel/Three/col-1";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColOne, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $dataManagerPage['carouselThreeColOne'] = $carouselThreeColOne;


            //02
            $pathCarouselNumber = "carousel/Three/col-2";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/7.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColTwo, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $dataManagerPage['carouselThreeColTwo'] = $carouselThreeColTwo;


            //03
            $pathCarouselNumber = "carousel/Three/col-3";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/7.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/8.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColThree, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $dataManagerPage['carouselThreeColThree'] = $carouselThreeColThree;

            //04
            $pathCarouselNumber = "carousel/Three/col-4";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);


            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/6.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFour, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $dataManagerPage['carouselThreeColFour'] = $carouselThreeColFour;


            //05
            $pathCarouselNumber = "carousel/Three/col-5";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFive, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFive, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFive, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFive, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColFive, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);
            $dataManagerPage['carouselThreeColFive'] = $carouselThreeColFive;


            //06
            $pathCarouselNumber = "carousel/Three/col-6";
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/cover.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColSix, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => true]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/1.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColSix, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/2.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColSix, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/3.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColSix, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/4.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColSix, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/" . $pathCarouselNumber . "/5.png";
            $urlImageCurrent = asset($this->resourcePathServer . $sourceImageCurrent);
            array_push($carouselThreeColSix, ["img" => $urlImageCurrent, "title" => "", "subtitle" => "", "class" => "", "isCover" => false]);
            $dataManagerPage['carouselThreeColSix'] = $carouselThreeColSix;

        } else if ($page == 'productFrozen') {

        } else if ($page == 'productProducts') {
            $pageCurrent = "products";
            $sectionProduct = "products";
            //slider MAIN
            $dataSlider = [];
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-1." . "png";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            // array_push($dataSlider, $urlImageCurrent);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-2." . "png";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);


            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-3." . "png";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);
            $dataManagerPage['sliderMainImage']["data"] = $dataSlider;

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-one." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundOne'] = $urlImageCurrent;

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-two." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundTwo'] = $urlImageCurrent;


            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-three." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundThree'] = $urlImageCurrent;

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-four." . "png";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundFour'] = $urlImageCurrent;
        } else if ($page == 'productFruits') {
            $pageCurrent = "products";
            $sectionProduct = "fruits";
            //slider MAIN
            $dataSlider = [];

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-1." . "png";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-2." . "png";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-3." . "png";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            array_push($dataSlider, $urlImageCurrent);

            $dataManagerPage['sliderMainImage']["data"] = $dataSlider;


            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-one." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundOne'] = $urlImageCurrent;

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-two." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundTwo'] = $urlImageCurrent;


            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-three." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundThree'] = $urlImageCurrent;

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-four." . "png";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundFour'] = $urlImageCurrent;
        } else if ($page == 'productBox') {
            $pageCurrent = "products";
            $sectionProduct = "box";
            //slider MAIN
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/slider-one." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['sliderMainImage'] = $urlImageCurrent;

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-one." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundOne'] = $urlImageCurrent;


            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/process-exportacion." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['processExportacion'] = $urlImageCurrent;

            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/process-importacion." . "jpg";
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['processImportacion'] = $urlImageCurrent;


            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/" . $sectionProduct . "/background-two." . $jpgNameCurrent;
            $urlImageCurrent = URL($this->resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['backgroundTwo'] = $urlImageCurrent;
        } else if ($page == 'traductorPage' || $page == 'diccionarioPage' || $page == 'yachasunPage' || $page == 'apuntesPage' || $page == 'homeChaskiPage') {
            $dataManagerPage['type'] = $paramsRequest['type'];

            $title = '';
            $subtitle = '';
            $dataManagerPage['allowVue'] = true;

            if ($page == 'homeChaskiPage') {
                $title = "Riksichishun";
                $subtitle = "Pagina Principal";

                if ($allowTemplate) {
                    $modelParent = new  \App\Models\TemplateSlider();
                    $dataSlider = $modelParent->getSliderMainFrontend(array(
                        'template_information_id' => $template_information_id,
                        'language' => $language,
                        "resourcePathServer" => $this->resourcePathServer
                    ));

                    if (count($dataSlider) > 0) {
                        $dataManagerPage['sliderMainManager'] = $dataSlider;
                    }


                }
            } elseif ($page == 'yachasunPage') {
                $title = "Riksichishun";
                $subtitle = "Yachasun";

                $dataManagerPage['allowVue'] = true;

            } elseif ($page == 'diccionarioPage') {

                $title = "Riksichishun";
                $subtitle = "Diccionarios";

                $dataManagerPage['allowVue'] = true;

            } elseif ($page == 'apuntesPage') {
                $title = "Riksichishun";
                $subtitle = "Temas de Interes";

                $dataManagerPage['allowVue'] = true;

            } elseif ($page == 'traductorPage') {
                $title = "Riksichishun";
                $subtitle = "Traductor Proximamente.!";

                $dataManagerPage['allowVue'] = true;

            }


            $informationCurrent = [
                'urlManagerRoot' => route('homeChaski', app()->getLocale()),
                'urlManager' => route('homeChaski', app()->getLocale()),
                'title' => $title . '-' . $subtitle,
                'source' => asset($this->resourcePathServer . '/images/frontend/meta-data/dictionaryType/image-main.png'),
                'descriptionData' => '
                Meetclick-Developer(Alex-Alba)
El idioma desempeña un papel esencial en la cultura de un pueblo, ya que actúa como un vehículo para la comunicación y la expresión. A través del lenguaje, las personas pueden compartir sus pensamientos, sentimientos y experiencias, fortaleciendo los lazos sociales y fomentando un sentido de pertenencia y comunidad. Además, el idioma es un componente crucial de la identidad cultural, reflejando la historia, el origen y las relaciones de una comunidad. La transmisión de conocimientos, tradiciones y valores se realiza principalmente a través del idioma, utilizando narrativas orales, literatura y otras formas de expresión artística. La diversidad lingüística refleja la diversidad cultural en el mundo y preservar los idiomas minoritarios es fundamental para proteger esta diversidad y promover la tolerancia intercultural. Además, el idioma influye en el desarrollo cognitivo de las personas, afectando su forma de pensar y percibir el mundo. El dominio del idioma puede influir en las oportunidades de educación, empleo y participación en la sociedad, mientras que la preservación de los idiomas tradicionales es crucial para salvaguardar el patrimonio cultural de la humanidad en un mundo globalizado. ',

            ];
            $dataManagerPage['dictionaryTypeData']['information'] = $informationCurrent;


        } else if ($page == 'homeBackLinePage') {

            $dataManagerPage['type'] = $paramsRequest['type'];

            $title = '';
            $subtitle = '';
            $dataManagerPage['allowVue'] = true;
            if ($page == 'homeBackLinePage') {
                $title = "Backline";
                $subtitle = "Pagina Principal";

                if ($allowTemplate) {
                    $modelParent = new  \App\Models\TemplateSlider();
                    $dataSlider = $modelParent->getSliderMainFrontend(array(
                        'template_information_id' => $template_information_id,
                        'language' => $language,
                        "resourcePathServer" => $this->resourcePathServer
                    ));

                    if (count($dataSlider) > 0) {
                        $dataManagerPage['sliderMainManager'] = $dataSlider;
                    }


                }
            }


            $informationCurrent = [
                'urlManagerRoot' => route('homeBackLine', app()->getLocale()),
                'urlManager' => route('homeBackLine', app()->getLocale()),
                'title' => $title . '-' . $subtitle,
                'source' => asset($this->resourcePathServer . '/images/frontend/meta-data/backline/image-main.png'),
                'descriptionData' => 'Hacemos que las empresas sean más eficientes al simplificar procesos,automatizar tareas, desarrollar soluciones inteligentes y analizar datos para una gestión ágil.. ',

            ];
            $dataManagerPage['dictionaryTypeData']['information'] = $informationCurrent;


        } else if ($page == 'homeEatPura') {
            $dataManagerPage['allowVue'] = true;
            $dataManagerPage['isUserMenu'] = false;


            if ($allowTemplate) {
                $modelParent = new  \App\Models\TemplateSlider();
                $dataSlider = $modelParent->getSliderSubSectionCodeByMainFrontend(array(
                    'template_information_id' => $template_information_id,
                    'code' => 'hero-slider-1 slick-slide',
                    'language' => $language,

                    "resourcePathServer" => $this->resourcePathServer
                ));

                if (count($dataSlider) > 0) {
                    $dataManagerPage['sliderHomeTop'] = $dataSlider;
                }


                $dataSliderTwo = $modelParent->getSliderSubSectionCodeByMainFrontend(array(
                    'template_information_id' => $template_information_id,
                    'code' => 'grocery-banner-1',
                    'language' => $language,

                    "resourcePathServer" => $this->resourcePathServer
                ));

                if (count($dataSliderTwo) > 0) {

                    $dataManagerPage['sliderHomeGrocery'] = $dataSliderTwo;
                }
                $dataSliderThree = $modelParent->getSliderSubSectionCodeByMainFrontend(array(
                    'template_information_id' => $template_information_id,
                    'code' => 'adver-banner-1',
                    'language' => $language,

                    "resourcePathServer" => $this->resourcePathServer
                ));

                if (count($dataSliderThree) > 0) {
                    $dataManagerPage['sliderHomeAdver'] = $dataSliderThree;
                }

                $model = new ProductParentByProduct();
                $category_id = 1;
                $sub_category_id = 1;

                $resultRecentProducts = $model->getProductShopRecentAdmin([
                    "filters" => [
                        'business_id' => $business_id,
                        'category_id' => $category_id,
                        'sub_category_id' => $sub_category_id,

                    ],
                    "searchPhrase" => ""

                ]);

                $dataManagerPage['recentProductsHome'] = $resultRecentProducts;
            }

        } else if ($page == 'userAccount') {
            $dataManagerPage['allowVue'] = true;
            $dataManagerPage['isUserMenu'] = false;

        } else if ($page == 'shopPage') {
            $dataManagerPage['allowVue'] = true;
            $dataManagerPage['isUserMenu'] = false;

        } else if ($page == 'checkoutPage') {
            $dataManagerPage['allowVue'] = true;
            $dataManagerPage['isUserMenu'] = false;

            $dataManagerPage['allowFooterMenu'] = false;

            $modelC = new \App\Models\Country();
            $dataCountries = $modelC->getListCountries();
            $dataCountriesManager = $modelC->getProvincesByDataCountries($dataCountries);
            $dataManagerPage['countriesBillingAddress'] = Frontend::getHtmlCountriesSelect(
                [
                    'data' => $dataCountries,
                    'id' => 'country_id',
                    'name' => 'OrderBillingCustomer[country_id]',
                    'required' => true,
                    'class' => 'form-control',
                    "resourcePathServer" => $this->resourcePathServer
                ]
            );
            $dataManagerPage['dataCountriesManager'] = $dataCountriesManager;
            if ($dataManagerPage['shopConfig']['allow']) {

                $dataManagerPage['typePayments'] = Frontend::getHtmlPaymentsTypes(['data' => $dataManagerPage['shopConfig']['data'],
                    "resourcePathServer" => $this->resourcePathServer]);
            }
        }

        if ($page == 'homeEatPura' || $page == "searchProductBusiness" || $page == 'userAccount' || $page == 'shopPage' || $page == 'checkoutPage') {


            $resultContactUs = FrontendPageSections::getDataContactUs([
                'dataBusiness' => $dataBusiness,
                'page' => $page,
                'publicAsset' => $publicAsset,
                'allowTemplate' => $allowTemplate,
                'template_information_id' => $template_information_id,
                'business_id' => $business_id,
                'resultPageData' => $resultPageData,
                'jpgNameCurrent' => $jpgNameCurrent,
                'resourcePathServer' => $resourcePathServer,

            ]);
            $dataManagerPage = array_merge($dataManagerPage, $resultContactUs);

            if ($page == "searchProductBusiness") {
                $dataManagerPage['allowVue'] = true;
                $dataManagerPage['isUserMenu'] = false;

                $dataManagerPage['allowPlugins']['googleMaps']= false;
            }
            else if ($page == 'userAccount') {
                $dataManagerPage['allowPlugins']['googleMaps'] = true;
            }

        }
        $result['dataManagerPage'] = $dataManagerPage;

        $result['pageSectionsConfig'] = $pageSectionsConfig;
        $result['paramsRequest'] = $paramsRequest;

        $result['profileConfig'] = $resultPageData['profileConfig'];

        $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

        $themePath = $resourcePathServer . 'templates/cityBookHtml/';
        $result["resourcePathServer"] = $resourcePathServer;
        $result["themePath"] = $themePath;
        $result = array_merge($resultPageData, $result);
        $nameRoute = Route::currentRouteName();
        $result["nameRoute"] = $nameRoute;


        $result["viewPage"] = $viewPage;

        $result['pathCurrent'] = $pathCurrentResources;
        $result['configPartial'] = $configPartial;
        $result['publicAsset'] = $publicAsset;
        $resourcePathServer = asset($this->resourcePathServer);
        $result['rootAssets'] = $resourcePathServer;
        return $result;
    }

    public function getPopularList($paramsRequest)
    {
        $modelGetData = new \App\Models\Business();
        $paramsFilters = $paramsRequest;
        $itemsListing = $modelGetData->getPopularListBee($paramsFilters);
        $listingHtml = '';
        $countClearFix = 1;
        $urlRoute = route('businessDetails', app()->getLocale());
        $urlRouteUser = route('authorSingle', app()->getLocale());
        $notImage = asset($this->resourcePathServer . '/images/not-image.png');
        $locationsItems = [];
        $allowRating = false;
        $addedBy = __('frontend.menu.search.admin.addedBy');
        $countRoute = 1;
        $urlCurrentSearch = route('search', app()->getLocale());
        foreach ($itemsListing['rows'] as $key => $row) {

            $type = 1;
            if ($countRoute == 4) {
                $countRoute = 1;
            } else {
                $countRoute++;
            }
            $type = $countRoute;
            $urlBusiness = $urlRoute . '/' . $row->title;
            $urlUser = $urlRouteUser . '/' . $row->user_id;
            $typeProvider = $row->provider_id;
            $urlImageUser = "";
            if ($row->avatar == '' || $row->avatar == null) {
                $urlImageUser = $notImage;
            } else {

            }

            if ($typeProvider == 'server') {
                $urlImageUser = public_path("uploads/" . $row->avatar);

            } else {
                $urlImageUser = $row->avatar;
            }

            $address = $row->street_1 . ' , ' . $row->street_2;
            $urlImage = ($row->source == '' || $row->source == null) ? $notImage : asset($this->resourcePathServer . $row->source);
            $rating = ($row->qualification == 0 || $row->qualification == 'null') ? ($allowRating ? 5 : 2) : $row->qualification;
            $reviewCount = $key + 1;
            $locationsItems[$key] = [
                'url' => $urlBusiness,
                'category' => $row->business_categories,
                'img' => $urlImage,
                'title' => $row->title,
                'address' => $address,
                'phone' => $row->phone_value,
                'email' => $row->email,
                'rating' => $rating, //rating
                'reviewCount' => $reviewCount, //counterView
                'location' => [
                    'lat' => $row->street_lat,
                    'lng' => $row->street_lng,
                ]
            ];


            $categoryHtml = '        <div class="geodir-category-img"> ';
            $categoryHtml .= '             <img src="' . $urlImage . '" alt="">';
            $categoryHtml .= '             <div class="overlay"></div>';
            if (env('allowProcessHeart')) {
                $categoryHtml .= '             <div class="list-post-counter">';
                $categoryHtml .= '                <span>2</span><i class="fa fa-heart"></i>';
                $categoryHtml .= '             </div>';
            }

            $categoryHtml .= '        </div> ';
            $listingHtml .= '<div class="slick-slide-item slick-slide-item-popular-lists" >';
            $listingHtml .= '  <div class="listing-item" key-manager="#' . $key . '" >';
            $listingHtml .= '    <article class="geodir-category-listing fl-wrap">';
            $listingHtml .= $categoryHtml;

            $listingHtml .= '        <div class="geodir-category-content fl-wrap alex-alba"> ';
            $listingHtml .= '              <a class="listing-geodir-category"  href="' . $urlCurrentSearch . '?category=' . $row->business_categories_id . '" >' . $row->business_categories . '</a> ';
            $listingHtml .= '              <div class="listing-avatar">';
            $listingHtml .= '                  <a href="' . $urlUser . '" alt="">';
            $listingHtml .= '                    <img src="' . $urlImageUser . '" alt="">';
            $listingHtml .= '                  </a>';
            $listingHtml .= '                  <span  class="avatar-tooltip">';
            $listingHtml .= '                    <strong>' . $addedBy . ' ' . $row->user_name . '</strong>';
            $listingHtml .= '                  </span>';
            $listingHtml .= '              </div>';
            $listingHtml .= '              <h3>';
            $listingHtml .= '                <a href="' . $urlBusiness . '">' . $row->title . '</a>';
            $listingHtml .= '              </h3>';
            if ($row->description && $row->description != 'null') {
                $listingHtml .= '          <p>' . $row->description;
                $listingHtml .= '          </p>';
            }
            $listingHtml .= '              <div class="geodir-category-options fl-wrap">';
            if (env('allowProcessRating') && env('allowProcessPreview')) {

                $listingHtml .= '                 <div class="listing-rating card-popup-rainingvis" data-starrating2="' . $rating . '">';

                if (env('allowProcessPreview')) {

                    $listingHtml .= '                   <span >';
                    $listingHtml .= '                     (' . $reviewCount . ') reviews';
                    $listingHtml .= '                   </span>';
                }
                $listingHtml .= '                 </div>';
            }
            $listingHtml .= '                 <div class="geodir-category-location " >';
            $listingHtml .= '                   <a class="map-item map-item--not-map"  >';
            $listingHtml .= '                        <i class="fa fa-map-marker" aria-hidden="true"></i>  ' . $address;
            $listingHtml .= '                   </a>';
            $listingHtml .= '                 </div>';
            $listingHtml .= '            </div>';
            $listingHtml .= '      </div>';
            $listingHtml .= '    </article>';
            $listingHtml .= '  </div>';
            $listingHtml .= '</div>';

            if ($countClearFix == 2) {

                $countClearFix = 1;
                $allowRating = false;
            } else {
                $countClearFix++;
                $allowRating = true;
            }
        }
        $result = [
            'data' => $locationsItems,
            'dataHtml' => $listingHtml,
            'filters' => $paramsRequest,
            'allow-data' => $itemsListing['total'] > 0
        ];

        return $result;
    }

    public function getValuesBusiness($paramsRequest)//MANAGER-EMPRESAS(CMS)-BUSINESS
    {
        $modelGetData = new \App\Models\Business();
        $paramsFilters = $paramsRequest;
        $itemsListing = $modelGetData->getAdminBee($paramsFilters);
        $listingHtml = '';
        $countClearFix = 1;

        $urlRoute = route('businessDetails', app()->getLocale());
        $urlRouteUser = route('authorSingle', app()->getLocale());

        $notImage = asset($this->resourcePathServer . '/images/not-image.png');
        $locationsItems = [];
        $allowRating = false;
        $addedBy = __('frontend.menu.search.admin.addedBy');
        $countRoute = 1;
        foreach ($itemsListing['rows'] as $key => $row) {
            $type = 1;
            if ($countRoute == 4) {
                $countRoute = 1;
            } else {
                $countRoute++;
            }
            $type = $countRoute;
            $urlBusiness = $urlRoute . '/' . $row->title;
            $urlUser = $urlRouteUser . '/' . $row->user_id;


            $typeProvider = $row->provider;
            $urlImageUser = "";
            if ($row->avatar == '' || $row->avatar == null) {
                $urlImageUser = $notImage;
            } else {

            }

            if ($typeProvider == 'server') {
                $urlImageUser = asset("public/" . $row->avatar);


            } else {
                $urlImageUser = $row->avatar;
            }

            $address = $row->street_1 . ' , ' . $row->street_2;
            $urlImage = ($row->source == '' || $row->source == null) ? $notImage : asset($this->resourcePathServer . $row->source);
            $rating = ($row->qualification == 0 || $row->qualification == 'null') ? ($allowRating ? 5 : 2) : $row->qualification;
            $reviewCount = $key + 1;
            $locationsItems[$key] = [
                'url' => $urlBusiness,
                'category' => $row->business_categories,
                'img' => $urlImage,
                'title' => $row->title,
                'address' => $address,
                'phone' => $row->phone_value,
                'email' => $row->email,
                'rating' => $rating, //rating
                'reviewCount' => $reviewCount, //counterView
                'location' => [
                    'lat' => $row->street_lat,
                    'lng' => $row->street_lng,
                ]
            ];
            $categoryHtml = '        <div class="geodir-category-img"> ';
            $categoryHtml .= '             <img src="' . $urlImage . '" alt="">';
            $categoryHtml .= '             <div class="overlay"></div>';
            if (env('allowProcessHeart')) {
                $categoryHtml .= '             <div class="list-post-counter">';
                $categoryHtml .= '                <span>2</span><i class="fa fa-heart"></i>';
                $categoryHtml .= '             </div>';
            }
            $categoryHtml .= '        </div> ';

            $listingHtml .= '<div class="listing-item listing-item-search" key-manager="#' . $key . '" >';
            $listingHtml .= '    <article class="geodir-category-listing fl-wrap">';
            $listingHtml .= $categoryHtml;

            $listingHtml .= '        <div class="geodir-category-content fl-wrap"> ';
            $listingHtml .= '              <a class="listing-geodir-category" >' . $row->business_categories . '</a> ';
            $listingHtml .= '              <div class="listing-avatar alex-miguel">';
            $listingHtml .= '                  <a href="' . $urlUser . '" alt="">';
            $listingHtml .= '                    <img src="' . $urlImageUser . '" alt=""   ' . $typeProvider . '>';
            $listingHtml .= '                  </a>';
            $listingHtml .= '                  <span  class="avatar-tooltip">';
            $listingHtml .= '                    <strong>' . $addedBy . ' ' . $row->user_name . '</strong>';
            $listingHtml .= '                  </span>';
            $listingHtml .= '              </div>';
            $listingHtml .= '              <h3>';
            $listingHtml .= '                <a href="' . $urlBusiness . '">' . $row->title . '</a>';
            $listingHtml .= '              </h3>';
            if ($row->description && $row->description != 'null') {
                $textView = substr($row->description, 0, 125) . "....";
                $listingHtml .= '          <p>' . $textView;
                $listingHtml .= '          </p>';
            }
            $listingHtml .= '              <div class="geodir-category-options fl-wrap">';

            if (env('allowProcessRating') && env('allowProcessReview')) {

                $listingHtml .= '                 <div class="listing-rating card-popup-rainingvis" data-starrating2="' . $rating . '">';
                $listingHtml .= '                   <span >';
                $listingHtml .= '                     (' . $reviewCount . ') reviews';
                $listingHtml .= '                   </span>';
                $listingHtml .= '                 </div>';
            }

            $listingHtml .= '                 <div class="geodir-category-location" >';
            $listingHtml .= '                   <a class="map-item" href="#' . $key . '" >';
            $listingHtml .= '                        <i class="fa fa-map-marker" aria-hidden="true"></i>  ' . $address;
            $listingHtml .= '                   </a>';
            $listingHtml .= '                 </div>';
            $listingHtml .= '            </div>';
            $listingHtml .= '      </div>';
            $listingHtml .= '    </article>';
            $listingHtml .= '</div>';
            if ($countClearFix == 2) {
                $listingHtml .= '<div class="clearfix"></div>';
                $countClearFix = 1;
                $allowRating = false;
            } else {
                $countClearFix++;
                $allowRating = true;
            }
        }
        $result = [
            'listingHtml' => $listingHtml,
            'listing' => $itemsListing,
            'locationsItems' => $locationsItems,

            'filters' => $paramsRequest,
            'allow-data' => $itemsListing['total'] > 0
        ];

        return $result;
    }


}
