<?php

namespace App\Models;

use App\Models\Products\Product;
use App\Utils\FrontendPageSections;
use App\Utils\Util;
use Auth;
use Frontend;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Route;
use URL;


class FrontendManager extends ModelManager
{
    const BUSINESS_ID = 1;
    public $resourcePathServer = '';
    public $modelFMD = null;
    const TEMPLATE_VARKALA = 1;

    function __construct()
    {
        $this->resourcePathServer = (env('APP_IS_SERVER') ? "public" : '');

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
                $categoriesCurrentManagement  [] = $setPushCurrent;


            }

        }

        $categoriesData = $categoriesCurrentManagement;
        return $categoriesData;
    }

    public function getPageData($params)
    {
        $page = $params['page'];
        $paramsRequest = $params['paramsRequest'];
        $business_id = isset($paramsRequest['business_id']) ? $paramsRequest['business_id'] : self::BUSINESS_ID;

        $modelCBP = new CustomerByProfile();
        $user = Auth::user();
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
        $templateInformation = $modelT->getTemplateMainFrontend(array('business_id' => $entity_id));
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
        $allowBusiness = ($dataBusiness != false ? true : false);


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
            $resultResources = $modelTBS->getSourcesTypesData($filtersManager);
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


        return $result;
    }

    public static function getHtmlEventDetails($params)
    {
        $htmlRow = '';
        $product = $params['data'];
        $multimedia = isset($params['multimedia']) ? $params['multimedia'] : [];
        $allowShop = $params['allowShop'];
        $language = $params['language'] == 'es' ? null : $params['language'];
        $resourcePathServer = $params["resourcePathServer"];

        $discount = true;
        $hot = true;
        $imagesString = '';
        $imagesString .= '<div class="single-image">';
        $imagesString .= '  <img src="' . URL($resourcePathServer . $product->source) . '" class="img-fluid" >';
        $imagesString .= '</div>';

        $productName = $language == null ? $product->name : (isset($product->name_lang) && $product->name_lang ? $product->name_lang : $product->name);
        $productDescription = $language == null ? $product->description : (isset($product->description_lang) && $product->description_lang ? $product->description_lang : $product->description);
        $product_id_whishlist = null;
        if (count($multimedia) > 0) {
            foreach ($multimedia as $key => $valueRow) {

                $imagesString .= '<div class="single-image">';
                $imagesString .= '  <img src="' . URL($resourcePathServer . $valueRow->source) . '" class="img-fluid" >';
                $imagesString .= '</div>';

            }
        }

        $htmlRow .= ' <div class="single-product-slider-details-area">';
        $htmlRow .= '    <div class="container">';
        $htmlRow .= '         <div class="row">';
        $htmlRow .= '            <div class="col-lg-6">';
        $htmlRow .= '                 <div class="product-details-slider-area product-details-slider-area--side-move">';

        if ($hot) {
            $htmlRow .= '                <div class="product-badge-wrapper">';
            $htmlRow .= '                    <span class="hot">' . $product->events_trails_types . '</span>';
            $htmlRow .= '                </div>';

        }
        $htmlRow .= '                    <div class="row row-5">';
        $htmlRow .= '                       <div class="col-md-9 order-1 order-md-2">';
        $htmlRow .= '                            <div class="big-image-wrapper">';
        $htmlRow .= '                                 <div class="enlarge-icon">';
        $htmlRow .= '                                         <a class="btn-zoom-popup" href="javascript:void(0)"';
        $htmlRow .= '                                             data-tippy="Click to enlarge" data-tippy-placement="left"';
        $htmlRow .= '                                             data-tippy-inertia="true" data-tippy-animation="shift-away"';
        $htmlRow .= '                                             data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">';
        $htmlRow .= '                                             <i class="pe-7s-expand1"></i>';
        $htmlRow .= '                                          </a>';
        $htmlRow .= '                               </div>';//enlarge-icon
        $htmlRow .= '                                   <div class="product-details-big-image-slider-wrapper product-details-big-image-slider-wrapper--side-space theme-slick-slider"';
        $htmlRow .= '                                       data-slick-setting=\'{';
        $htmlRow .= '                                       "slidesToShow": 1,';
        $htmlRow .= '                                       "slidesToScroll": 1,';
        $htmlRow .= '                                       "arrows": false,';
        $htmlRow .= '                                       "autoplay": false,';
        $htmlRow .= '                                       "autoplaySpeed": 5000,';
        $htmlRow .= '                                       "fade": true,';
        $htmlRow .= '                                       "speed": 500,';
        $htmlRow .= '                                       "prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-angle-left" },';
        $htmlRow .= '                                        "nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-angle-right" }';
        $htmlRow .= '                                         }\' data-slick-responsive=\'[';
        $htmlRow .= '                                          {"breakpoint":1501, "settings": {"slidesToShow": 1, "arrows": false} },';
        $htmlRow .= '                                           {"breakpoint":1199, "settings": {"slidesToShow": 1, "arrows": false} },';
        $htmlRow .= '                                            {"breakpoint":767, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} },';
        $htmlRow .= '                                            {"breakpoint":575, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} },';
        $htmlRow .= '                                             {"breakpoint":479, "settings": {"slidesToShow": 1, "arrows": false, "slidesToScroll": 1} }';
        $htmlRow .= '                                        ]\'>';
        $htmlRow .= '                                        ' . $imagesString;
        $htmlRow .= '                                  </div>';//product-details-big-image-slider-wrapper
        $htmlRow .= '                            </div>';//big-image-wrapper
        $htmlRow .= '                      </div>';//col-md-9 order-1 order-md-2
        $htmlRow .= '                          <div class="col-md-3 order-2 order-md-1">';
        $htmlRow .= '                               <div class="product-details-small-image-slider-wrapper product-details-small-image-slider-wrapper--vertical-space theme-slick-slider"';
        $htmlRow .= '                                       data-slick-setting=\'{';
        $htmlRow .= '                                       "slidesToShow": 3,';
        $htmlRow .= '                                         "slidesToScroll": 1,  ';
        $htmlRow .= '                                           "centerMode": false,';
        $htmlRow .= '                                           "arrows": true,';
        $htmlRow .= '                                           "vertical": true,';
        $htmlRow .= '                                           "autoplay": false,';
        $htmlRow .= '                                            "autoplaySpeed": 5000,';
        $htmlRow .= '                                           "speed": 500, ';
        $htmlRow .= '                                             "asNavFor": ".product-details-big-image-slider-wrapper",';
        $htmlRow .= '                                            "focusOnSelect": true,';
        $htmlRow .= '                                           "prevArrow": {"buttonClass": "slick-prev", "iconClass": "fa fa-angle-up" },';
        $htmlRow .= '                                            "nextArrow": {"buttonClass": "slick-next", "iconClass": "fa fa-angle-down" }';
        $htmlRow .= '                                            }\' data-slick-responsive=\'[';
        $htmlRow .= '                                            {"breakpoint":1501, "settings": {"slidesToShow": 3, "arrows": true} },';
        $htmlRow .= '                                             {"breakpoint":1199, "settings": {"slidesToShow": 3, "arrows": true} },';
        $htmlRow .= '                                            {"breakpoint":991, "settings": {"slidesToShow": 3, "arrows": true, "slidesToScroll": 1} },';
        $htmlRow .= '                                            {"breakpoint":767, "settings": {"slidesToShow": 3, "arrows": false, "slidesToScroll": 1, "vertical": false, "centerMode": true} },';
        $htmlRow .= '                                          {"breakpoint":575, "settings": {"slidesToShow": 3, "arrows": false, "slidesToScroll": 1, "vertical": false, "centerMode": true} }, ';
        $htmlRow .= '                                           {"breakpoint":479, "settings": {"slidesToShow": 2, "arrows": false, "slidesToScroll": 1, "vertical": false, "centerMode": true} }';
        $htmlRow .= '                                         ]\'>';
        $htmlRow .= '                                       ' . $imagesString;
        $htmlRow .= '                                </div>';//product-details-small-image-slider-wrapper
        $htmlRow .= '                         </div>';//col-md-3 order-2 order-md-1
        $htmlRow .= '                     </div>';//row row-5
        $htmlRow .= '                      </div>';//product-details-slider-area
        $htmlRow .= '                 </div>';//col-lg-6

        $salePrice = 0;
        $salePrice = (float)$salePrice;
        $valueWithoutDiscount = 0;
        $valueWithDiscount = 0;

        $htmlRow .= '                 <div class="col-lg-6">';
        $htmlRow .= '                      <div class="product-details-description-wrapper">';
        $htmlRow .= '                            <h2 class="item-title">' . $productName . '</h2>';
        $htmlRow .= '                            <h4 class="item-title-date-init"> Inicio de Inscripciones : ' . $product->date_init_project . '</h4>';
        $htmlRow .= '                            <h4 class="item-title-date-end">Fecha maxima de inscripcion : ' . $product->date_end_project . '</h4>';

        $htmlRow .= '                            <p class="price not-view">';
        $htmlRow .= '                               <span class="main-price ' . ($discount ? 'discounted' : '') . '">$' . $salePrice . '</span>';
        if ($discount) {
            $htmlRow .= '                                <span class="discounted-price">' . $product->business . '</span>';
        }
        $htmlRow .= '                             </p> ';
        $htmlRow .= '                            <p class="description"> ';
        $htmlRow .= '                           ' . $productDescription;
        $htmlRow .= '                            </p>';


        $managementTakePart = true;
        $nameColCurrent = __('config.routes.titles.two');
        $haystack = $params['teams'];
        $countCurrent = count($haystack);
        $detailsEvent = '';
        if ($countCurrent > 0) {
            $setColCurrent = '';
            foreach ($haystack as $k => $v) {
                $setColCurrent .= '<div>' . $v->value . '</div>';
            }

            $detailsEvent .= '                                         <tr class="single-info">';
            $detailsEvent .= '                                             <td class="quickview-title">' . $nameColCurrent . ':</td>';
            $detailsEvent .= '                                             <td class="quickview-value">' . $setColCurrent . '</td> ';
            $detailsEvent .= '                                         </tr>';
        } else {
            $managementTakePart = false;
        }
        $nameColCurrent = __('config.routes.titles.three');
        $haystack = $params['categories'];
        $countCurrent = count($haystack);
        if ($countCurrent > 0) {
            $setColCurrent = '';
            foreach ($haystack as $k => $v) {
                $setColCurrent .= '<div>' . $v->value . ' Limite ' . $v->init_limit . ' a ' . $v->end_limit . '</div>';
            }

            $detailsEvent .= '                                         <tr class="single-info">';
            $detailsEvent .= '                                             <td class="quickview-title">' . $nameColCurrent . ':</td>';
            $detailsEvent .= '                                             <td class="quickview-value">' . $setColCurrent . '</td> ';
            $detailsEvent .= '                                         </tr>';
        } else {
            $managementTakePart = false;
        }

        $nameColCurrent = __('config.routes.titles.four');
        $haystack = $params['kits'];
        $countCurrent = count($haystack);
        if ($countCurrent > 0) {
            $setColCurrent = '';

            foreach ($haystack as $k => $v) {

                $currentLink = URL('productDetails') . '/' . $v['id'];
                $setPush = '<a target="_blank" class="management-view-link" href="' . $currentLink . '">' . $v['name'] . ' </a> <br>';
                $sizesCurrent = $v['sizes'];
                $sizesManager = '';
                $countCurrentChild = count($sizesCurrent);
                if ($countCurrentChild) {
                    $setColCurrentChild = '';
                    $countAux = 0;
                    foreach ($sizesCurrent as $k2 => $v2) {

                        $setColCurrentChild .= '<span>' . $v2->value . '</span>' . (($countAux == $countCurrentChild - 1) ? '.' : ',');
                        $countAux++;
                    }
                    $sizesManager = '<div class="sizes__content">Tallas:' . $setColCurrentChild . '</div>';
                }
                $setColCurrent .= $setPush . ' ' . $sizesManager;

            }

            $detailsEvent .= '                                         <tr class="single-info">';
            $detailsEvent .= '                                             <td class="quickview-title">' . $nameColCurrent . ':</td>';
            $detailsEvent .= '                                             <td class="quickview-value">' . $setColCurrent . '</td> ';
            $detailsEvent .= '                                         </tr>';
        } else {
            $managementTakePart = false;
        }
        $nameColCurrent = __('config.routes.titles.five');
        $haystack = $params['distances'];
        $countCurrent = count($haystack);
        if ($countCurrent > 0) {
            $setColCurrent = '';
            foreach ($haystack as $k => $v) {
                $setColCurrent .= '<div>' . $v->value . ' - ' . $v->events_trails_type_teams . ' - <span  class="price-event">' . $v->price . '</span></div>';
            }

            $detailsEvent .= '                                         <tr class="single-info">';
            $detailsEvent .= '                                             <td class="quickview-title">' . $nameColCurrent . ':</td>';
            $detailsEvent .= '                                             <td class="quickview-value">' . $setColCurrent . '</td> ';
            $detailsEvent .= '                                         </tr>';
        } else {
            $managementTakePart = false;
        }


        if ($allowShop) {
            if ($managementTakePart) {

                $htmlRow .= '                               <div class="add-to-cart-btn d-inline-block">';
                $htmlRow .= '                                    <button  v-on:click="_managementTakePart()" class="theme-button theme-button--alt add-cart add-cart--product-details">' . __('config.buttons.three') . '</button> ';
                $htmlRow .= '                               </div>';
            }

        }
        $htmlRow .= '                                <div class="quick-view-other-info">';
        $nameColCurrent = __('config.routes.titles.one');
        $htmlRow .= '                                     <table>';
        $htmlRow .= '                                         <tr class="single-info">';
        $htmlRow .= '                                             <td class="quickview-title">' . $nameColCurrent . ':</td>';
        $htmlRow .= '                                             <td class="quickview-value">' . $product->business . '</td> ';
        $htmlRow .= '                                         </tr>';
        $nameColCurrent = __('config.routes.titles.six');

        $htmlRow .= '                                         <tr class="single-info">';
        $htmlRow .= '                                             <td class="quickview-title">' . $nameColCurrent . ':</td>';
        $htmlRow .= '                                             <td class="quickview-value">' . $product->events_trails_types . '</td> ';

        $htmlRow .= '                                         </tr>';
        $htmlRow .= $detailsEvent;
        $htmlRow .= '                                         <tr class="single-info">';
        $htmlRow .= '                                             <td class="quickview-title">Compartir:</td>';
        $htmlRow .= '                                             <td class="quickview-value">';
        $htmlRow .= '                                                 <ul class="quickview-social-icons">';
        if (env('shareAllowFacebook')) {

            $htmlRow .= '                                                     <li><a  v-on:click="_shareInformation(0)"><i class="fa fa-facebook"></i></a></li>';
        }

        if (env('shareAllowTwitter')) {

            $htmlRow .= '                                                     <li><a  v-on:click="_shareInformation(1)"><i class="fa fa-twitter"></i></a></li>';
        }
        if (env('shareAllowGoogle')) {

            $htmlRow .= '                                                     <li><a  v-on:click="_shareInformation(2)"><i class="fa fa-google-plus"></i></a></li>';
        }
        if (env('shareAllowPinterest')) {

            $htmlRow .= '                                                     <li><a  v-on:click="_shareInformation(3)"><i class="fa fa-pinterest"></i></a></li>';
        }

        $htmlRow .= '                                                 </ul>';
        $htmlRow .= '                                         </tr>';
        $htmlRow .= '                                       </table>';
        $htmlRow .= '                                   </div>';//quick-view-other-info
        $htmlRow .= '                                </div>';//product-details-description-wrapper
        $htmlRow .= '                            </div>';//col-lg-6
        $htmlRow .= '                         </div>';//row
        $htmlRow .= '                     </div>';//container


        $htmlRow .= '              </div>';//single-product-slider-details-area


        $htmlRow .= '        <div class="single-product-description-tab-area section-space  not-view">         ';

        $htmlRow .= '          <div class="description-tab-navigation"> ';
        $htmlRow .= '                      <div class="nav nav-tabs justify-content-center" id="nav-tab2" role="tablist"> ';
        $htmlRow .= '                           <a class="nav-item nav-link active" id="description-tab" data-toggle="tab"';
        $htmlRow .= '                               href="#product-description"';
        $htmlRow .= '                               role="tab" aria-selected="true">DESCRIPTION';
        $htmlRow .= '                            </a>';


        $htmlRow .= '                   </div>';//nav nav-tabs
        $htmlRow .= '          </div>';//description-tab-navigation

        $htmlRow .= '          <div class="single-product-description-tab-content">';
        $htmlRow .= '           <div class="tab-content">';
        $htmlRow .= '            <div class="tab-pane fade show active" id="product-description" role="tabpanel"';
        $htmlRow .= '                           aria-labelledby="description-tab">';
        $htmlRow .= '                 <div class="container">';
        $htmlRow .= '                     <div class="row">';
        $htmlRow .= '                     <div class="col-lg-12">';
        $htmlRow .= '                        <div class="description-content">';
        $htmlRow .= '                            ' . $productDescription;
        $htmlRow .= '                     </div>';//description-content
        $htmlRow .= '                 </div>';//col-lg-12
        $htmlRow .= '                </div>';//row
        $htmlRow .= '               </div>';//container
        $htmlRow .= '              </div>';//tab-pane product-description


        $htmlRow .= '      </div>';//tab-content
        $htmlRow .= '  </div>';//single-product-description-tab-area section-space


        $htmlRow = new HtmlString($htmlRow);
        return $htmlRow;
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

    public function getParamsPage($params)//CMS-TEMPLATE
    {
        $page = $params['page'];
        $paramsRequest = $params['paramsRequest'];
        $language = $paramsRequest['language'];
        $resultPageData = $this->modelFMD->getPageData($params);
        $allowRoutes = env('allowRoutes');
        $modelCategories = FrontendPageSections::PROJECT_TYPE_EVENT ? new EventsTrailsTypes() : new ProductCategory();
        $modelB = new Business();
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

        $dataCategoriesResult = [];
        if ($allowTemplate) {
            if (!$allowRoutes) {
                if (FrontendPageSections::PROJECT_TYPE_EVENT) {
                    $dataCategoriesResult = $modelCategories->getAllTypesFrontend();
                } else {
                    $dataCategoriesResult = $modelCategories->getListCategoriesFrontend([
                        'filters' => [
                            'business_id' => $business_id,
                            'language' => $language
                        ]
                    ]);
                }

                if (!FrontendPageSections::PROJECT_TYPE_EVENT) {
                    $dataCategoriesResult = Util::objectToArrayRecursive($dataCategoriesResult);
                }
            }

        } else {
            $dataCategoriesResult = [];
        }
        $categoriesData = [];
        $dataCategories = $dataCategoriesResult;

        $categoriesData = $this->getStructureCategories([
            'dataCategories' => $dataCategories
        ]);
        if (env('allowBusinessOwner')) {
            $result['dataCategoriesMenuTop'] = $categoriesData;

        } else {
            $dataCategoriesHtml = Frontend::getHtmlCategories(array(
                'dataCategories' => $dataCategories,
                'typeCategory' => FrontendPageSections::PROJECT_TYPE_EVENT,
                'language' => $language,
                "resourcePathServer" => $this->resourcePathServer
            ));
            $result['dataCategoriesHtml'] = $dataCategoriesHtml;
        }


        if ($page == 'home') {//CMS-TEMPLATE-home

            $modelParent = new TemplateSlider();
            $modelISN = new InformationSocialNetwork();
            $dataSliderHtml = '';
            if ($allowTemplate) {
                $dataSlider = $modelParent->getSliderMainFrontend(array(
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer
                ));
                if (count($dataSlider) > 0) {
                    $dataSliderHtml = Frontend::getHtmlSlider($dataSlider);

                }
            }
            $dataSocialNetwork = $modelISN->getAllFrontend([
                'filters' => [
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type_business
                ]]);
            if (count($dataSocialNetwork) > 0) {
                $dataSocialNetworksHtml = Frontend::getHtmlSocialNetwork([
                    'data' => $dataSocialNetwork,
                    'type' => 'footer',
                    'title' => 'Siguenos en :',
                    "resourcePathServer" => $this->resourcePathServer
                ]);
            }
            $dataSliderLogo = [];

            if ($pageSectionsConfig['alliedBrands']['allow']) {
                $dataSliderLogo = $modelB->getAllBusinessFrontend();
            }


            $dataCategoriesHtml = '';


            $dataFooter['socialNetwork'] = $dataSocialNetworksHtml;
            $result['dataSliderLogo'] = $dataSliderLogo;
            $result['dataCategories'] = $dataCategories;


            $result['dataSliderHtml'] = $dataSliderHtml;
            $dataManagerPage['pluginsAllow'] ['slider']['allow'] = true;


            if (env('allowBusinessOwner')) {
                $modelProduct = new Products\Product;
                $dataOutlet = $modelProduct->getDataOutlet([
                    'filters' => [
                        'business_id' => $business_id
                    ]
                ]);
                $dataBalances = $modelProduct->getDataBalances([
                    'filters' => [
                        'business_id' => $business_id
                    ]
                ]);

                $result['dataOutlet'] = $dataOutlet;
                $result['dataBalances'] = $dataBalances;


            } else {
                $dataCategoriesHtml = Frontend::getHtmlCategories(array(
                    'dataCategories' => $dataCategories,
                    'typeCategory' => FrontendPageSections::PROJECT_TYPE_EVENT,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer
                ));

                $result['dataCategoriesHtml'] = $dataCategoriesHtml;
            }

            if ($allowRoutes) {
                //GET EVENTS
                $modelEventTrails = new \App\Models\EventsTrailsProject();
                $dataManagerPage['eventsCarouse'] = $modelEventTrails->getEventsRoutesHome([
                    'filters' => [
                        'business_id' => $business_id
                    ]
                ]);

            }


        } else if ($page == 'aboutUs') {
            $dataManagerPage['sectionPage']['parentHtml'] = '';
            $dataManagerPage['sectionPage']['childrenHtml'] = '';
            $parentHtml = '';
            $childrenHtml = '';
            if ($allowTemplate) {
                $modelTAU = new TemplateAboutUs();
                $dataParent = $modelTAU->getAboutUsFrontend(
                    [
                        'filters' => [
                            'template_information_id' => $template_information_id,
                            'language' => $language
                        ]
                    ]
                );
                if ($dataParent != false) {
                    $modelChildren = new TemplateAboutUsByData();

                    $parentHtml = Frontend::getHtmlAboutUsParent([
                        'data' => $dataParent,
                        'language' => $language,
                        "resourcePathServer" => $this->resourcePathServer

                    ]);
                    $parent_id = $dataParent->id;
                    $childrenData = $modelChildren->getAboutUsDataFrontend([
                        'filters' => [
                            'template_about_us_id' => $parent_id,
                            'language' => $language
                        ]
                    ]);
                    if (count($childrenData) > 0) {
                        $childrenFormatData = Util::getRowsByDataBS3(
                            [
                                'haystack' => $childrenData,
                                'columnsDiv' => 4,

                            ]
                        );

                        $childrenHtml = Frontend::getHtmlAboutUsChildren([
                            'data' => $childrenFormatData,
                            'language' => $language,
                            "resourcePathServer" => $this->resourcePathServer
                        ]);
                    }
                }
            }
            $dataManagerPage['sectionPage']['parentHtml'] = $parentHtml;
            $dataManagerPage['sectionPage']['childrenHtml'] = $childrenHtml;
        } else if ($page == 'services') {

            $dataManagerPage['sectionPage']['parentHtml'] = '';
            $dataManagerPage['sectionPage']['childrenHtml'] = '';
            $parentHtml = '';
            $childrenHtml = '';
            if ($allowTemplate) {

                $modelParent = new TemplateServices();
                $dataParent = $modelParent->getServiceFrontend(
                    [
                        'filters' => [
                            'template_information_id' => $template_information_id,
                            'language' => $language
                        ]
                    ]
                );


                if ($dataParent != false) {
                    $modelChildren = new TemplateServicesByData();

                    $parentHtml = Frontend::getHtmlServiceParent(['data' => $dataParent,
                        'language' => $language,
                        "resourcePathServer" => $this->resourcePathServer

                    ]);
                    $parent_id = $dataParent->id;
                    $childrenData = $modelChildren->getServiceDataFrontend([
                        'filters' => [
                            'template_services_id' => $parent_id,
                            'language' => $language
                        ]
                    ]);
                    if (count($childrenData) > 0) {
                        $childrenFormatData = Util::getRowsByDataBS3(
                            [
                                'haystack' => $childrenData,
                                'columnsDiv' => 2,

                            ]
                        );

                        $childrenHtml = Frontend::getHtmlServiceChildren([
                            'data' => $childrenFormatData,
                            'language' => $language,
                            "resourcePathServer" => $this->resourcePathServer
                        ]);
                    }
                }
            }
            $dataManagerPage['sectionPage']['parentHtml'] = $parentHtml;
            $dataManagerPage['sectionPage']['childrenHtml'] = $childrenHtml;
        } else if ($page == 'shop') {
            $categoriesShop = '';
            $allowViewProducts = false;
            if (env('allowRoutes')) {
                $modelPC = new \App\Models\EventsTrailsTypes();
                $categoriesData = $modelPC->getListCategoriesManagerFrontend([
                    'filters' => [
                        'business_id' => $entity_id,
                        'language' => $language
                    ]
                ]);
                $allowViewProducts = count($categoriesData) > 0;
                $categoriesShop = '';
                $categoriesShop = Frontend::getHtmlCategoriesEventsShop([
                    'data' => $categoriesData,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer,
                    'paramsRequest' => $paramsRequest


                ]);
            } else {
                $modelPC = new ProductCategory();


                $allowViewProducts = count($categoriesData) > 0;
                $categoriesShop = '';
                $categoriesShop = Frontend::getHtmlCategoriesShop([
                    'data' => $categoriesData,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer,
                    'paramsRequest' => $paramsRequest

                ]);
            }

            $dataManagerPage['categoriesShop'] = $categoriesShop;
            $dataManagerPage['allowViewProducts'] = $allowViewProducts;


        } else if ($page == 'shopBalances') {
            $categoriesShop = '';
            $allowViewProducts = false;

            $modelPC = new ProductCategory();
            $allowViewProducts = count($categoriesData) > 0;
            $categoriesShop = '';
            $categoriesShop = Frontend::getHtmlCategoriesShop([
                'data' => $categoriesData,
                'language' => $language,
                "resourcePathServer" => $this->resourcePathServer,
                'paramsRequest' => $paramsRequest

            ]);


            $dataManagerPage['categoriesShop'] = $categoriesShop;
            $dataManagerPage['allowViewProducts'] = $allowViewProducts;


        } else if ($page == 'shopOutlets') {
            $categoriesShop = '';
            $allowViewProducts = false;

            $modelPC = new ProductCategory();
            $allowViewProducts = count($categoriesData) > 0;
            $categoriesShop = '';
            $categoriesShop = Frontend::getHtmlCategoriesShop([
                'data' => $categoriesData,
                'language' => $language,
                "resourcePathServer" => $this->resourcePathServer,
                'paramsRequest' => $paramsRequest

            ]);


            $dataManagerPage['categoriesShop'] = $categoriesShop;
            $dataManagerPage['allowViewProducts'] = $allowViewProducts;


        } else if ($page == 'contactUs') {
            $dataSocialNetworksContactUsHtml = '';
            $dataContactUs = array();

            if ($dataBusiness != false) {
                $dataContactUs['informationContactUs'] = Frontend::getHtmlInformationBusiness([
                    'data' => $dataBusiness,
                    'type' => 'contact-us',
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer
                ]);
                $dataContactUs['dataBusiness'] = $dataBusiness;

            } else {
                $dataContactUs['informationContactUs'] = '';
                $dataContactUs['dataBusiness'] = [];

            }
            $contactUsMap = [];
            if ($allowTemplate) {
                $modelTCU = new TemplateContactUs();
                $contactUsMap = $modelTCU->getContactUsFrontend(
                    [
                        'filters' => [
                            'template_information_id' => $template_information_id
                        ]
                    ]
                );
            }
            $dataContactUs['contactUsMap'] = $contactUsMap;
            $dataContactUs['socialNetworkContactUs'] = $dataSocialNetworksContactUsHtml;
            $result['dataContactUs'] = $dataContactUs;

        } else if ($page == 'ourStores') {
            $ourStoresData = [];
            if ($pageSectionsConfig['business']['view']) {
                $address = $pageSectionsConfig['business']['data']->street_1 .
                    ' Y ' . $pageSectionsConfig['business']['data']->street_2;
                $lat = $pageSectionsConfig['business']['data']->street_lat;
                $lng = $pageSectionsConfig['business']['data']->street_lng;
                $source = URL::asset($this->resourcePathServer . '/assets/images/business/our-stores/our-01.PNG');
                $setPush = [
                    'title' => __('labels.thirty-four'),
                    'address' => $address,
                    'position' => ['lat' => $lat, 'lng' => $lng],
                    'source' => $source,
                    'button' => __('labels.thirty-five') . ' Google Maps',

                ];
                $ourStoresData[] = $setPush;
            }

            $address = 'AV. Jaime Rivadeneira 5-22 y Pedro Moncayo Referencia Frente al Hotel Montecarlo';
            $lat = 0.3503584;
            $lng = -78.1255217;
            $source = URL::asset($this->resourcePathServer . '/assets/images/business/our-stores/our-02.PNG');
            $setPush = [
                'title' => __('labels.thirty-three'),
                'address' => $address,
                'position' => ['lat' => $lat, 'lng' => $lng],
                'source' => $source,
                'button' => __('labels.thirty-five') . ' Google Maps',

            ];
            $ourStoresData[] = $setPush;
            $result['ourStoresData'] = $ourStoresData;

        } else if ($page == 'productDetails') {

            $modelP = new Product();
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

        } else if ($page == 'eventDetails') {

            $modelP = new \App\Models\EventsTrailsProject();
            $resultEvents = $modelP->getManagerDataDetails([
                'id' => $params['eventsId'],
                'language' => $language,
                "resourcePathServer" => $this->resourcePathServer,
                'business_id' => $business_id
            ]);
            if ($resultEvents['success']) {
                $resultEvents['allowShop'] = $dataManagerPage['shopConfig']['allow'];
                $dataManagerPage['eventDetails'] = '';
                $dataManagerPage['eventDetails'] = $this->getHtmlEventDetails($resultEvents);
                $dataManagerPage['eventData'] = $resultEvents;


            }


        } else if ($page == 'cart') {

        } else if ($page == 'checkout') {

            $modelC = new Country();
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

        } else if ($page == 'paymentSend') {

        } else if ($page == 'terms') {


        } else if ($page == 'policies') {


        } else if ($page == 'checkoutDetails') {

            $modelCurrent = new OrderShoppingCart();
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

        } else if ($page == 'activitiesGame') {
            $modelParent = new TemplateSlider();
            $modelGTA = new \App\Models\GamificationTypeActivity();
            $dataSliderHorizontal = $modelGTA->getDataFrontend([]);
            $dataSliderHtml = '';
            $dataSliderHorizontalMainHtml = '';

            if ($allowTemplate) {
                $dataSlider = $modelParent->getSliderMainFrontend(array(
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer,
                    'position_section' => 1
                ));
                if (count($dataSlider) > 0) {
                    $dataSliderHtml = Frontend::getHtmlSlider($dataSlider);

                }
            }

            if ($dataSliderHorizontal) {

                $dataSliderHorizontalMainHtml = Frontend::getSliderSimpleHorizontal([
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    'data' => $dataSliderHorizontal,
                    "resourcePathServer" => $this->resourcePathServer

                ]);
                $dataManagerPage['dataSliderHorizontal']['main'] = $dataSliderHorizontalMainHtml;

            }
            $result['dataSliderHtml'] = $dataSliderHtml;
            $dataManagerPage['pluginsAllow'] ['slider']['allow'] = true;
            $modelGamification = new \App\Models\BusinessByGamification;
            $gamificationData = $modelGamification->getGamificationFrontend([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);


            if ($gamificationData) {
                $modelGBP = new \App\Models\GamificationByProcess();
                $activitiesData = $modelGBP->getActivitiesGamificationFrontend(
                    [

                        'filters' => [
                            'gamification_id' => $gamificationData->gamification_id
                        ]
                    ]
                );


                if ($activitiesData) {

                    $bannerTwoColumnMain = Frontend::getBannerColumnTwo([
                        'template_information_id' => $template_information_id,
                        'language' => $language,
                        'data' => $activitiesData,
                        "resourcePathServer" => $this->resourcePathServer,
                        'positionLanguage' => 'frontend.gamification.activities'

                    ]);
                    $dataManagerPage['banner-two-column']['main'] = $bannerTwoColumnMain;

                }

            }


        } else if ($page == 'rewardsGame') {
            $modelParent = new TemplateSlider();
            $modelGTA = new \App\Models\GamificationTypeActivity();
            $dataSliderHorizontal = $modelGTA->getDataFrontend([]);
            $dataSliderHtml = '';
            $dataSliderHorizontalMainHtml = '';

            if ($allowTemplate) {
                $dataSlider = $modelParent->getSliderMainFrontend(array(
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    "resourcePathServer" => $this->resourcePathServer,
                    'position_section' => 2
                ));
                if (count($dataSlider) > 0) {
                    $dataSliderHtml = Frontend::getHtmlSlider($dataSlider);

                }
            }
            if ($dataSliderHorizontal) {
                $dataSliderHorizontalMainHtml = Frontend::getSliderSimpleHorizontal([
                    'template_information_id' => $template_information_id,
                    'language' => $language,
                    'data' => $dataSliderHorizontal,
                    "resourcePathServer" => $this->resourcePathServer

                ]);
                $dataManagerPage['dataSliderHorizontal']['main'] = $dataSliderHorizontalMainHtml;

            }
            $result['dataSliderHtml'] = $dataSliderHtml;
            $dataManagerPage['pluginsAllow'] ['slider']['allow'] = true;
            $modelGamification = new \App\Models\BusinessByGamification;
            $gamificationData = $modelGamification->getGamificationFrontend([
                'filters' => [
                    'business_id' => $business_id
                ]
            ]);
            if ($gamificationData) {
                $modelGBP = new \App\Models\GamificationByRewards();
                $activitiesData = $modelGBP->getRewardsGamificationFrontend(
                    [

                        'filters' => [
                            'gamification_id' => $gamificationData->gamification_id
                        ]
                    ]
                );
                if ($activitiesData) {
                    $bannerTwoColumnMain = Frontend::getBannerColumnTwo([
                        'template_information_id' => $template_information_id,
                        'language' => $language,
                        'data' => $activitiesData,
                        "resourcePathServer" => $this->resourcePathServer,
                        'positionLanguage' => 'frontend.gamification.rewards',
                        'managerType' => 'rewards'

                    ]);
                    $dataManagerPage['banner-two-column'] ['main'] = $bannerTwoColumnMain;
                }

            }
        } else if ($page == 'listingOne') {
            $resultManagerProcess = $this->getDataShop($params);

            $dataManagerPage = array_merge($resultManagerProcess, $dataManagerPage);

        }


        $result['dataFooter'] = $dataFooter;
        $result['dataManagerPage'] = $dataManagerPage;
        $result['dataMenu'] = $dataMenu;
        $result['pageSectionsConfig'] = $pageSectionsConfig;
        $result["resourceRoot"] = URL($this->resourcePathServer);
        $result["paramsRequest"] = $paramsRequest;
        $type = $params["templateInitType"] ?? 0;
        $result ["resourcesTemplateInit"] = $this->getResourcesManagerTemplate($type);
        return array_merge($resultPageData, $result);

    }


    public function getDataShop($params)
    {
        $paramsRequest = $params["paramsRequest"];
        $templateInitType = $params["templateInitType"] ?? 0;
        $language = $paramsRequest["language"];

        $viewPage = false;
        $messagePage = "";
        $inventoryConfig = [];
        $typeShopView = [];
        $dataCategoriesResult = [];
        $modelCategories = new ProductCategory();
        $dataManagerPage['type'] = $paramsRequest['type'];
        $modelBusiness = new \App\Models\Business;
        $business_id = null;
        $paramId = $paramsRequest['id'];
        $information = $modelBusiness->getDetailsBee([
            'filters' => [
                'business_id' => $paramId
            ]
        ]);
        $typePage = -1;
        $publicAsset = env('APP_IS_SERVER') ? "public" : '';
        if ($information) {
            $viewPage = true;
            $business_id = $information->id;
            $resourcePathServer = $publicAsset;
            $dataCategoriesResult = $modelCategories->getListCategoriesManager([
                'filters' => [
                    'language' => $language,
                    'business_id' => $business_id,
                    'resourcePathServer' => $resourcePathServer

                ]
            ]);
            $colorDefault = '#FACC39';
            $dataManagerPage['allowVue'] = true;
            $dataManagerPage['categories'] = $dataCategoriesResult;
            $dataManagerPage['business_id'] = $business_id;

            $dataCategoriesResult = $modelCategories->getListCategoriesManager([
                'filters' => [
                    'language' => $language,
                    'business_id' => $business_id,
                    'resourcePathServer' => $resourcePathServer

                ]
            ]);

            if (count($dataCategoriesResult) > 0) {
                $viewPage = true;

                $colorDefault = '#FACC39';
                $dataManagerPage['allowVue'] = true;
                $dataManagerPage['categories'] = $dataCategoriesResult;
                $dataManagerPage['business_id'] = $business_id;
                $inventoryConfig = [
                    'type' => 0,
                    'management' => null,
                    'not-manager' => true,
                    'config_management_inventory' => [
                        'header_subcategories' => [
                            'content' => [
                                'styles' => [
                                    'background_color' => $colorDefault
                                ]
                            ]
                        ]
                    ]
                ];
                $modelCurrent = new \App\Models\BusinessByInventoryManagement();
                $inventoryConfigCurrent = $modelCurrent->getDataProfileBusiness([
                    'filters' => [
                        'business_id' => $business_id
                    ]
                ]);
                $typeShopView = 0;//default
                if ($inventoryConfigCurrent) {
                    $config_management_inventory = [
                        'header_subcategories' => [
                            'content' => [
                                'styles' => [
                                    'background_color' => $colorDefault
                                ]
                            ]
                        ]
                    ];

                    $typeShopView = $inventoryConfigCurrent->type;
                    if ($inventoryConfigCurrent->type == 1) {
                        if ($inventoryConfigCurrent->config_management_inventory == "'{}'") {
                            $config_management_inventory = [
                                'header_subcategories' => [
                                    'content' => [
                                        'styles' => [
                                            'background_color' => $colorDefault
                                        ]
                                    ]
                                ]
                            ];
                        } else {
                            $config_management_inventory_data = json_decode($inventoryConfigCurrent->config_management_inventory, true);
                            $config_management_inventory = $config_management_inventory_data;
                        }
                    } else {

                    }

                    $inventoryConfig = [
                        'type' => $inventoryConfigCurrent->type,
                        'management' => $inventoryConfigCurrent,
                        'not-manager' => false,
                        'config_management_inventory' => $config_management_inventory
                    ];
                }
            } else {
                $messagePage = "No Existe Inventario.!";
                $typePage = 2;
                $viewPage = false;
            }

        } else {
            $typePage = 1;
            $messagePage = "Empresa no Existe.";
        }

        $dataManagerPage['inventory-config'] = $inventoryConfig;
        $dataManagerPage['typeShopView'] = $typeShopView;

        if (count($dataCategoriesResult) > 0) {


            $categoriesHtml = Util::getSliderCategoriesTypeOne([
                'data' => $dataCategoriesResult
            ], $resourcePathServer, 1);
            $dataManagerPage['categoriesHtml'] = $categoriesHtml;

        }
        $dataManagerPage["viewPage"] = $viewPage;
        $dataManagerPage["typePage"] = $typePage;

        $dataManagerPage["messagePage"] = $messagePage;

        return $dataManagerPage;

    }

    public function getResourcesManagerTemplate($type = 0)
    {
        $result = "";
        switch ($type) {
            case self::TEMPLATE_VARKALA:
                $result = "templates/varkala/";
                break;
        }
        return $result;
    }

    public static function getLayoutByTypeTemplate($type = 0)
    {
        $result = "";
        switch ($type) {
            case self::TEMPLATE_VARKALA:
                $result = "layouts.varkala.app";
                break;
        }
        return $result;
    }

    public static function getBusinessMainId($type = 0)
    {
        $result = -1;
        switch ($type) {
            case self::TEMPLATE_VARKALA:
                $result = self::BUSINESS_ID;
                break;
        }
        return $result;
    }
}
