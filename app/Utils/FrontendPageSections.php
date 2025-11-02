<?php

namespace App\Utils;


use App\Models\TemplateConfigMailingByEmails;
use App\Models\TemplateContactUs;
use Auth;
use Cookie;

class FrontendPageSections
{
    const ALLIED_BRANDS_ALLOW = false;
    const POLICIES_ALLOW = true;
    const TERMS_ALLOW = true;

    const PROJECT_TYPE_EVENT = false;
    const POLICIES_TYPE = 0;
    const TERM_TYPE = 1;
    const MAILING_TYPE_PAGE_CONTACT_US = 0;
    const MAILING_TYPE_PAGE_SERVICES = 1;
    const MAILING_TYPE_PAGE_ABOUT_US = 2;
    const MAILING_TYPE_PAGE_FOOTER = 3;
    const MAILING_TYPE_PAGE_CHECKOUT = 4;

    public static function getPageCookies($params)
    {

        $timeCurrent = date("Y-m-d H:i");
        $init_cart = Cookie::get('init_cart');
        $init_cart_time = Cookie::get('init_cart_time');
        $end_cart_time = Cookie::get('end_cart_time');
        $timeCurrentValue = strtotime($timeCurrent);
        $end_cart_timeValue = strtotime($end_cart_time);
        $result = [
            'init_cart' => $init_cart,
            'end_cart_time' => $end_cart_time,
            'timeCurrentValue' => $timeCurrentValue,
            'end_cart_timeValue' => $end_cart_timeValue,
            'init_cart_time' => $init_cart_time,

        ];
        return $result;
    }

    public static function getDataContactUs($params)
    {
        $dataBusiness= $params['dataBusiness'];
        $page= $params['page'];
        $publicAsset= $params['publicAsset'];
        $allowTemplate= $params['allowTemplate'];
        $template_information_id= $params['template_information_id'];
        $business_id= $params['business_id'];
        $resultPageData= $params['resultPageData'];
        $jpgNameCurrent= $params['jpgNameCurrent'];
       $resourcePathServer= $params['resourcePathServer'];
        $dataManagerPage=[];
        if ($dataBusiness != false) {
            $socialNetwork = [];
            $dataManagerPage['allowPlugins']['googleMaps'] = true;
            $dataManagerPage['currentPage'] = $page;
            $dataManagerPage['allowVue'] = true;
            $primary = $dataBusiness->street_1;
            $secondary = $dataBusiness->street_2;
            $phone = $dataBusiness->phone_value;
            $mail = $dataBusiness->email;
            $lng = $dataBusiness->street_lng;
            $lat = $dataBusiness->street_lat;
            $name = $dataBusiness->title;
            $iconMarker = asset($publicAsset . "templates/cityBookHtml/images/marker.png");
            $information = [
                'name' => $name,
                'address' => [
                    'primary' => $primary,
                    'secondary' => $secondary,
                ],
                'phone' => $phone,
                'mail' => $mail,
                'location' => [
                    'lat' => $lat,
                    'lng' => $lng,
                    'icon' => $iconMarker
                ]
            ];
            if ($dataBusiness->page_url && $dataBusiness->page_url != 'null') {
                $information['web'] = $dataBusiness->page_url;
            }
            if ($dataBusiness->options_map && $dataBusiness->options_map != 'null') {
                $information['location']['options_map'] = $dataBusiness->options_map;
            }
            $dataContactUs['dataBusiness'] = $dataBusiness;

            $socialNetwork = [];
            $configFormContactUs = [];
            if ($allowTemplate) {
                $modelTCU = new TemplateContactUs();
                $contactUsMap = $modelTCU->getContactUsFrontend(
                    [
                        'filters' => [
                            'template_information_id' => $template_information_id
                        ]
                    ]
                );
                if ($contactUsMap) {
                    $information['location']['icon'] = asset($publicAsset . $contactUsMap->source);
                }
                $modelTCU = new TemplateContactUs();
                $socialNetwork = $modelTCU->getSocialNetworkData([
                    'filters' => [
                        'business_id' => $business_id,
                        'template_information_id' => $template_information_id,
                    ]
                ]);
                //CONTACT US
                $configFormContactUs = FrontendPageSections::getPageContactFormConfig([
                    'page' => $page,
                    'getData' => $allowTemplate,
                    'business_id' => $business_id,
                ]);

                $configFormContactUs = $resultPageData["dataManagerPage"]['sectionPage']["formContactUs"];

            }


            $dataManager = [
                'information' => $information,
                'socialNetwork' => $socialNetwork,
                'configFormContactUs' => $configFormContactUs,

            ];
            if (count($socialNetwork) > 0) {
                $dataManager['socialNetwork'] = $socialNetwork;
            }
            $dataManagerPage['dataPage'] = $dataManager;
            $pageCurrent = "contact-us";
            //slider MAIN
            $sourceImageCurrent = "/uploads/web/" . $pageCurrent . "/not-manager/slider-one." . $jpgNameCurrent;
            $urlImageCurrent = URL($resourcePathServer . $sourceImageCurrent);
            $dataManagerPage['sliderMainImage'] = $urlImageCurrent;
        }
        return $dataManagerPage;

    }

    //breadcrumb
    public static function getPageHeaderConfig($params)
    {
        $page = $params['page'];

        $inactiveName = '';
        $linksCurrent = [];
        $title = '';
        $activeName = '';
        if ($page == 'home') {
            $title = __('page.' . $page);
            $activeName = __('page.' . $page);
        } else if ($page == 'aboutUs') {
            $title = __('page.' . $page);
            $activeName = __('page.' . $page);
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],
            ];
        } else if ($page == 'contactUs') {
            $title = __('page.' . $page);
            $activeName = __('page.' . $page);
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],
            ];
        } else if ($page == 'services') {
            $title = __('page.' . $page);
            $activeName = __('page.' . $page);
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],
            ];
        } else if ($page == 'wishList') {
            $title = __('page.' . $page);
            $activeName = __('page.' . $page);
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],
            ];
        } else if ($page == 'shop') {
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],
            ];

            $title = __('page.' . $page . '.productsServices');
            $activeName = __('page.' . $page . '.productsServices');
        } else if ($page == 'shopBalances') {
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],
            ];

            $title = __('page.' . $page . '.productsServices');
            $activeName = __('page.' . $page . '.productsServices');
        } else if ($page == 'shopOutlets') {
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],
            ];

            $title = __('page.' . $page . '.productsServices');
            $activeName = __('page.' . $page . '.productsServices');
        } else if ($page == 'productDetails') {
            if (env('allowAllInOne')) {
                $productId = $params['productId'];
                $modelProduct = new \App\Models\Products\Product();
                $resultProduct = $modelProduct->getProductDetailsById([
                    'filters' => [
                        'product_id' => $productId

                    ]
                ]);

                $linksCurrent = [];
                if ($resultProduct) {
                    $routeBusiness = route('businessDetails', app()->getLocale()) . '/' . $resultProduct->business_id;
                    $linksCurrent = [
                        [
                            'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                            'title' => __('page.home')
                        ],
                        [
                            'href' => route('search', app()->getLocale()),
                            'title' => __('labels.forty-five')
                        ],
                        [
                            'href' => $routeBusiness,
                            'title' => $resultProduct->business_title
                        ],


                    ];
                } else {
                    $linksCurrent = [
                        [
                            'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                            'title' => __('page.home')
                        ],
                        [
                            'href' => route('search', app()->getLocale()),
                            'title' => __('labels.forty-five')
                        ],
                    ];
                }

            } else {

                $linksCurrent = [
                    [
                        'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                        'title' => __('page.home')
                    ],
                    [
                        'href' => route('shop', app()->getLocale()),
                        'title' => __('page.shop.productsServices')
                    ],
                ];
            }

            $title = __('page.shop.productDetails');
            $activeName = __('page.shop.productDetails');
        } else if ($page == 'orderService') {
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],

            ];

            $title = __('labels.forty-six');
            $activeName = __('labels.forty-six');
        } else if ($page == 'ourStores') {
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],

            ];

            $title = __('labels.thirty-two');
            $activeName = __('labels.thirty-two');
        } else if ($page == 'eventDetails') {
            $linksCurrent = [
                [
                    'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                    'title' => __('page.home')
                ],
                [
                    'href' => route('shop', app()->getLocale()),
                    'title' => __('page.shop.productsServices')
                ],
            ];

            $title = __('page.shop.eventDetails');
            $activeName = __('page.shop.eventDetails');
        } else if ($page == 'cart') {

            if (env('allowAllInOne')) {
                $linksCurrent = [
                    [
                        'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                        'title' => __('page.home')
                    ],
                    [
                        'href' => route('search', app()->getLocale()),
                        'title' => __('labels.forty-five')
                    ],
                ];
            } else {
                $linksCurrent = [
                    [
                        'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                        'title' => __('page.home')
                    ],
                    [
                        'href' => route('shop', app()->getLocale()),
                        'title' => __('page.shop.productsServices')
                    ],
                ];
            }


            $title = __('page.shop.cart');
            $activeName = __('page.shop.cart');
        } else if ($page == 'checkout') {

            if (env('allowAllInOne')) {

                $linksCurrent = [
                    [
                        'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                        'title' => __('page.home')
                    ],
                    [
                        'href' => route('search', app()->getLocale()),
                        'title' => __('labels.forty-five')
                    ],

                ];
            } else {
                $linksCurrent = [
                    [
                        'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                        'title' => __('page.home')
                    ],
                    [
                        'href' => route('shop', app()->getLocale()),
                        'title' => __('page.shop.productsServices')
                    ],
                    [
                        'href' => route('cart', app()->getLocale()),
                        'title' => __('page.shop.cart')
                    ],
                ];
            }
            $title = __('page.shop.checkout');
            $activeName = __('page.shop.checkout');
        } else if ($page == 'checkoutDetails') {
            $linksCurrent = [];
            if (env('allowAllInOne')) {
                $linksCurrent = [
                    [
                        'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                        'title' => __('page.home')
                    ],
                    [
                        'href' => route('search', app()->getLocale()),
                        'title' => __('labels.forty-five')
                    ],
                ];
            } else {
                $linksCurrent = [
                    [
                        'href' => route('homeIndexFrontendWeb', app()->getLocale()),
                        'title' => __('page.home')
                    ],
                    [
                        'href' => route('shop', app()->getLocale()),
                        'title' => __('page.shop.productsServices')
                    ],
                ];
            }
            $title = __('page.shop.checkoutDetails');
            $activeName = __('page.shop.checkoutDetails');
        }
        foreach ($linksCurrent as $key => $link) {

            $inactiveName .= '<li>';
            $inactiveName .= '    <a href="' . $link['href'] . '">';
            $inactiveName .= '   ' . $link['title'];
            $inactiveName .= '    </a>';
            $inactiveName .= '</li>';

        }

        $breadCrumb = ['active' => $activeName, 'inactive' => $inactiveName];
        $result = [
            'title' => $title,
            'breadCrumb' => $breadCrumb,

        ];
        return $result;
    }

    public static function getPageContactFormConfig($params)
    {
        $page = $params['page'];
        $getData = $params['getData'];
        $business_id = $params['business_id'];
        $result['title'] = __('formContactUs.title');
        $result['subtitle'] = __('formContactUs.subtitle');
        $result['field1'] = __('formContactUs.field1') . ' *';
        $result['field2'] = __('formContactUs.field2') . ' *';
        $result['field3'] = __('formContactUs.field3') . '*';
        $result['field4'] = __('formContactUs.field4') . '*';
        $result['buttonSend'] = __('formContactUs.buttonSend');
        $viewFormSection = false;

        if ($getData) {
            if ($page == 'contactUsBee' || $page == 'contactUs' || $page == 'aboutUs' || $page == 'services') {
                $type = null;
                if ($page == 'services') {


                    $type = self::MAILING_TYPE_PAGE_SERVICES;
                } else if ($page == 'aboutUs') {


                    $type = self::MAILING_TYPE_PAGE_ABOUT_US;
                } else if ($page == 'contactUs') {


                    $type = self::MAILING_TYPE_PAGE_CONTACT_US;
                } else if ($page == 'contactUsBee') {


                    $type = self::MAILING_TYPE_PAGE_CONTACT_US;
                }

                $model = new TemplateConfigMailingByEmails();

                $viewFormSection = $model->getEmailByBusiness([
                    'filters' => [
                        'business_id' => $business_id,
                        'type' => $type,

                    ]
                ]);

                $result['viewFormSection'] = $viewFormSection;
            }


        }

        $result['viewFormSection'] = $viewFormSection;

        return $result;

    }
}
