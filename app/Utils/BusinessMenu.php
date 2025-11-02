<?php

namespace App\Utils;


use App\Models\Order;
use App\Utils\Util;
use App\Models\Role;
use App\Models\BusinessByEmployeeProfile;
use App\Models\UsersHasRoles;

use Auth;

class BusinessMenu
{
    public static function structureActiveMenu($params)
    {
        $menuConfigCurrent = $params['menuConfigCurrent'];
        $haystack = $params['haystack'];
        $isChildren = $params['isChildren'];
        $keyChildrenCurrent = $params['keyChildrenCurrent'];
        $keyParentCurrent = $params['keyParentCurrent'];


        foreach ($menuConfigCurrent as $key => $menu) {
            $isParentCurrent = $menu['isParent'];
            $allowPush = false;
            $setPush = array();
            if ($isParentCurrent) {
                $parentData = $menu['parentData'];
                $children = array();
                $keyChildrenActive = null;
                foreach ($parentData as $keyChildren => $submenu) {
                    $link = $submenu['link'];
                    $needle = $link;
                    $keyCompare = 'link';
                    $searchResultConfig = Util::searchInArray(array("haystack" => $haystack, "needle" => $needle, "keyCompare" => $keyCompare, "isObject" => true));
                    $searchResult = array();
                    if (!empty($searchResultConfig)) {
                        $isArray = is_array($searchResultConfig);
                        $count = null;
                        if ($isArray) {
                            $valueCurrent = (array)($searchResultConfig[0]);
                            $searchResult = $valueCurrent['value'];

                        } else {
                            $searchResult = $searchResultConfig['value'];
                        }
                    }
                    if (!empty($searchResult)) {
                        $submenu['allow'] = true;
                        $children[$keyChildren] = $submenu;

                        if ($isChildren && $keyChildrenCurrent == $keyChildren) {
                            $submenu['active'] = true;
                            $keyChildrenActive = $keyChildren;
                        }

                    }
                }
                if (!empty($children)) {
                    $setPush = $menu;
                    $setPush['allow'] = true;
                    $setPush['parentData'] = $children;
                    $allowPush = true;
                    if ($isChildren && $keyParentCurrent == $key) {
                        $setPush['active'] = true;
                        $isParentManager = false;
                        $allowModules = true;
                        $configModules = array(
                            'keyChildren' => $keyChildrenActive,
                            'keyParent' => $key,
                        );
                    }


                }

            } else {
                $link = $menu['link'];
                $needle = $link;
                $keyCompare = 'link';
                $searchResultConfig = Util::searchInArray(array("haystack" => $haystack, "needle" => $needle, "keyCompare" => $keyCompare, "isObject" => true));

                $searchResult = array();
                if (!empty($searchResultConfig)) {
                    $isArray = is_array($searchResultConfig);
                    $count = null;

                    if ($isArray) {
                        $valueCurrent = (array)($searchResultConfig[0]);

                        $searchResult = $valueCurrent['value'];

                    } else {
                        $searchResult = $searchResultConfig['value'];
                    }


                }
                if (!empty($searchResult)) {
                    $allowPush = true;
                    $setPush = $menu;
                    $typeManager = 'manager' . ucfirst($key);
                    $setPush['typeManager'] = $typeManager;
                    $setPush['allow'] = true;
                    if ($isChildren == false && $keyParentCurrent == $key) {
                        $setPush['active'] = true;
                        $isParentManager = true;
                        $configModules = array(
                            'keyParent' => $key
                        );
                        $allowModules = true;
                    }


                }


            }
            if ($allowPush) {
                $menuCurrentManager[$key] = $setPush;
            }
        }

        return $menuCurrentManager;
    }

    public static function getDataForAppVariables($params)
    {
        $nameProcess = $params['typeManager'];
        $modelDataManager = $params['modelDataManager'];
        $business = $modelDataManager['business'][0];
        $user = $params['user'];

        $actionsCurrentProcess = [//BUSINESS-MANAGER-MENU-ACTION

            'managerMailingTemplate' => [
                'isChildren' => true,
                'keyParent' => 'marketing',
                'keyChildren' => 'mailingTemplate',
                'action' => 'mailingTemplate/admin'
            ],
            'managerDashboard' => [
                'isChildren' => false,
                'keyChildren' => 'dashboard',
                'action' => 'managerBusiness'
            ],
            'managerBusinessByShippingRate' => [
                'isChildren' => true,
                'keyParent' => 'store',
                'keyChildren' => 'businessByShippingRate',
                'action' => 'businessByShippingRate/admin'
            ],
            'managerInvoiceSaleManager' => [
                'isChildren' => true,
                'keyParent' => 'store',
                'keyChildren' => 'invoiceSaleManager',
                'action' => 'invoiceSaleManager/save'
            ],
            'managerInvoiceSale' => [
                'isChildren' => true,
                'keyParent' => 'store',
                'keyChildren' => 'invoiceSale',
                'action' => 'invoiceSale/admin'
            ],
            /* 'managerInformation' => [
                 'isChildren' => true,
                 'keyParent' => 'business',
                 'keyChildren' => 'information',
                 'action' => 'business/saveBusiness'
             ],*/
            'managerBusinessByLanguage' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByLanguage',
                'action' => 'businessByLanguage/admin'
            ],
            'managerBusinessByHistory' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByHistory',
                'action' => 'businessByHistory/admin'
            ],
            'managerBusinessByMenuManagementFrontend' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByMenuManagementFrontend',
                'action' => 'businessByMenuManagementFrontend/admin'
            ],
            'managerBusinessByAcademicOfferings' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByAcademicOfferings',
                'action' => 'businessByAcademicOfferings/admin'
            ],
            'managerBusinessByAcademicOfferingsInstitution' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByAcademicOfferingsInstitution',
                'action' => 'businessByAcademicOfferingsInstitution/admin'
            ],
            'managerBusinessByInformationCustom' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByInformationCustom',
                'action' => 'businessByInformationCustom/admin'
            ],
            'managerBusinessCounterCustom' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessCounterCustom',
                'action' => 'businessCounterCustom/admin'
            ],
            'managerBusinessByFrequentQuestion' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByFrequentQuestion',
                'action' => 'businessByFrequentQuestion/admin'
            ],
            'managerBusinessByRequirements' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByRequirements',
                'action' => 'businessByRequirements/admin'
            ],
            'managerBusinessByPartnerCompanies' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessByPartnerCompanies',
                'action' => 'businessByPartnerCompanies/admin'
            ],
            'managerTaxByBusiness' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'taxByBusiness',
                'action' => 'taxByBusiness/admin'
            ],
            'managerEventsTrailsProject' => [
                'isChildren' => false,
                'keyChildren' => 'eventsTrailsProject',
                'action' => 'eventsTrailsProject/admin'
            ],
            'managerOrderPaymentsManager' => [
                'isChildren' => true,
                'keyParent' => 'store',
                'keyChildren' => 'orderPaymentsManager',
                'action' => 'orderPaymentsManager/admin'
            ],
            'managerTemplateInformation' => [
                'isChildren' => false,
                'keyChildren' => 'templateInformation',
                'action' => 'templateInformation/admin'
            ],
            'managerProduct' => [
                'isChildren' => true,
                'keyParent' => 'store',
                'keyChildren' => 'product',
                'action' => 'product/admin'
            ],
            'managerProductManager' => [//BUSINESS-MANAGER-DATA-MENU--PRODUCT-MANAGER
                'isChildren' => true,
                'keyParent' => 'store',
                'keyChildren' => 'productManager',
                'action' => 'productManager/admin'
            ],
            'managerProductService' => [
                'isChildren' => true,
                'keyParent' => 'store',
                'keyChildren' => 'productService',
                'action' => 'productService/admin'
            ],
            'managerBusinessByDiscount' => [
                'isChildren' => true,
                'keyParent' => 'store',
                'keyChildren' => 'businessByDiscount',
                'action' => 'businessByDiscount/admin'
            ],
            'managerBusinessBySchedule' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'businessBySchedule',
                'action' => 'business/schedules'
            ],
            'managerGallery' => [
                'isChildren' => true,
                'keyParent' => 'business',
                'keyChildren' => 'gallery',
                'action' => 'business/gallery/adminBusiness'
            ],
            'managerRoutes' => [
                'isChildren' => true,
                'keyParent' => 'routes',
                'keyChildren' => 'routes',
                'action' => 'business/routes/adminBusiness'
            ],
            'managerPanorama' => [
                'isChildren' => true,
                'keyParent' => 'routes',
                'keyChildren' => 'panorama',
                'action' => 'business/panorama/adminBusiness'
            ],
            'managerHumanResourcesDepartment' => [
                'isChildren' => true,
                'keyParent' => 'humanResources',
                'keyChildren' => 'humanResourcesDepartment',
                'action' => 'business/humanResourcesDepartment/admin'
            ],
            'managerHumanResourcesEmployeeProfile' => [
                'isChildren' => true,
                'keyParent' => 'humanResources',
                'keyChildren' => 'humanResourcesEmployeeProfile',
                'action' => 'business/humanResourcesEmployeeProfile/admin'
            ],
            'managerCustomer' => [
                'isChildren' => true,
                'keyParent' => 'crm',
                'keyChildren' => 'customer',
                'action' => 'business/customer/admin'
            ],
            'managerCustomerPresentation' => [
                'isChildren' => true,
                'keyParent' => 'prosecutorOffice',
                'keyChildren' => 'customerPresentation',
                'action' => 'business/customer/adminPresentation'
            ],
            'managerRepairProductByBusiness' => [
                'isChildren' => true,
                'keyParent' => 'repair',
                'keyChildren' => 'repairProductByBusiness',
                'action' => 'repairProductByBusiness/admin'
            ],
            'managerRepair' => [
                'isChildren' => true,
                'keyParent' => 'repair',
                'keyChildren' => 'repair',
                'action' => 'repair/admin'
            ],
            'managerLodgingTypeOfRoom' => [
                'isChildren' => true,
                'keyParent' => 'housing',
                'keyChildren' => 'lodgingTypeOfRoom',
                'action' => 'business/lodgingTypeOfRoom/admin'
            ],
            'managerLodgingRoomLevels' => [
                'isChildren' => true,
                'keyParent' => 'housing',
                'keyChildren' => 'lodgingRoomLevels',
                'action' => 'business/lodgingRoomLevels/admin'
            ],
            'managerLodgingRoomFeatures' => [
                'isChildren' => true,
                'keyParent' => 'housing',
                'keyChildren' => 'lodgingRoomFeatures',
                'action' => 'business/lodgingRoomFeatures/admin'
            ],
            'managerLodgingTypeOfRoomByPrice' => [
                'isChildren' => true,
                'keyParent' => 'housing',
                'keyChildren' => 'lodgingTypeOfRoomByPrice',
                'action' => 'business/lodgingTypeOfRoomByPrice/admin'
            ],
            'managerLodgingStatisticalData' => [
                'isChildren' => true,
                'keyParent' => 'housing',
                'keyChildren' => 'lodgingStatisticalData',
                'action' => 'business/lodging/results'
            ],
            'managerLodging' => [
                'isChildren' => true,
                'keyParent' => 'housing',
                'keyChildren' => 'lodging',
                'action' => 'business/lodging/adminBusiness'
            ],
            'managerEducationalInstitutionAskwerType' => [
                'isChildren' => true,
                'keyParent' => 'askwer',
                'keyChildren' => 'educationalInstitutionAskwerType',
                'action' => 'business/educationalInstitutionAskwerType/admin'
            ],
            'managerEducationalInstitutionByBusiness' => [
                'isChildren' => true,
                'keyParent' => 'askwer',
                'keyChildren' => 'educationalInstitutionByBusiness',
                'action' => 'business/educationalInstitutionByBusiness/admin'
            ],
            'managerBusinessByGamification' => [
                'isChildren' => true,
                'keyParent' => 'gamification',
                'keyChildren' => 'businessByGamification',
                'action' => 'businessByGamification/admin'
            ],
            'managerGamificationTypeActivity' => [
                'isChildren' => true,
                'keyParent' => 'gamification',
                'keyChildren' => 'gamificationTypeActivity',
                'action' => 'gamificationTypeActivity/admin'
            ],

            /*  'managerAntecedent' => [
                  'isChildren' => true,
                  'keyParent' => 'hospital',
                  'keyChildren' => 'antecedent',
                  'action' => 'antecedent/admin'
              ],*/
            /*     'managerClinicalExam' => [
                     'isChildren' => true,
                     'keyParent' => 'hospital',
                     'keyChildren' => 'clinicalExam',
                     'action' => 'clinicalExam/admin'
                 ],*/
            'managerAllergies' => [
                'isChildren' => true,
                'keyParent' => 'hospital',
                'keyChildren' => 'allergies',
                'action' => 'allergies/admin'
            ],
            'managerHabits' => [
                'isChildren' => true,
                'keyParent' => 'hospital',
                'keyChildren' => 'habits',
                'action' => 'habits/admin'
            ],
            'managerPatient' => [
                'isChildren' => true,
                'keyParent' => 'hospital',
                'keyChildren' => 'patient',
                'action' => 'patient/admin'
            ],
            'managerHumanResourcesOrganizationalChartArea' => [
                'isChildren' => true,
                'keyParent' => 'humanResources',
                'keyChildren' => 'humanResourcesOrganizationalChartArea',
                'action' => 'business/humanResourcesOrganizationalChartArea/admin'
            ],

            'managerHelpDeskTypes' => [
                'isChildren' => true,
                'keyParent' => 'helpDesk',
                'keyChildren' => 'helpDeskTypes',
                'action' => 'helpDesk/helpDeskTypes/admin'
            ],

            'managerHelpDeskHeader' => [
                'isChildren' => true,
                'keyParent' => 'helpDesk',
                'keyChildren' => 'helpDeskHeader',
                'action' => 'helpDesk/helpDeskHeader/admin'
            ],
            //CPP-001
            'managerWorkPlanningHeader' => [
                'isChildren' => true,
                'keyParent' => 'workPlanning',
                'keyChildren' => 'workPlanningHeader',
                'action' => 'workPlanning/workPlanningHeader/admin'
            ],
            'managerProjectHeader' => [
                'isChildren' => true,
                'keyParent' => 'projects',
                'keyChildren' => 'projectHeader',
                'action' => 'project/projectHeader/admin'
            ],
            'managerHumanResourcesPermissionType' => [
                'isChildren' => true,
                'keyParent' => 'attendance',
                'keyChildren' => 'humanResourcesPermissionType',
                'action' => 'attendance/humanResourcesPermissionType/admin'
            ],
            'managerHumanResourcesShift' => [
                'isChildren' => true,
                'keyParent' => 'attendance',
                'keyChildren' => 'humanResourcesShift',
                'action' => 'attendance/humanResourcesShift/admin'
            ],
            'managerHumanResourcesScheduleType' => [
                'isChildren' => true,
                'keyParent' => 'attendance',
                'keyChildren' => 'humanResourcesScheduleType',
                'action' => 'attendance/humanResourcesScheduleType/admin'
            ],
            'managerHumanResourcesEmployeeProfileByPermission' => [
                'isChildren' => true,
                'keyParent' => 'attendance',
                'keyChildren' => 'humanResourcesEmployeeProfileByPermission',
                'action' => 'attendance/humanResourcesEmployeeProfileByPermission/admin'
            ],
        ];

        $configModulesAllow = array(
            "humanResourcesPermissionType" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "humanResourcesScheduleType" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "dashboard" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "educationalInstitutionAskwerType" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "information" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "productManager" => array(//BUSINESS-MANAGER-MENU-DATA--PRODUCT-MANAGER
                "title" => "Productos Administracion",
                "allow" => true,
                "active" => false
            ),
            "products" => array(
                "title" => "Productos",
                "allow" => false,
                "active" => false
            ),
            "productsService" => array(
                "title" => "Productos",
                "allow" => false,
                "active" => false
            ),
            "businessBySchedule" => array(
                "title" => "Horarios",
                "allow" => true,
                "active" => false
            ),
            "gallery" => array(
                "title" => "Galeria",
                "allow" => true,
                "active" => false
            ),
            "panorama" => array(
                "title" => "Galeria Panoramica",
                "allow" => true,
                "active" => false
            ),
            "routes" => array(
                "title" => "Chakiñanes & Atractivos Turisticos",
                "allow" => true,
                "active" => false
            ),
            "lodgingStatisticalData" => array(
                "title" => "Reportes Estadisticos",
                "allow" => true,
                "active" => false
            ),
            "lodging" => array(
                "title" => "Registro de Huespedes",
                "allow" => true,
                "active" => false
            ),
            "lodgingTypeOfRoom" => array(
                "title" => "Tipos de Habitaciones",
                "allow" => true,
                "active" => false
            ),
            "lodgingRoomLevels" => array(
                "title" => "Niveles de Habitaciones",
                "allow" => true,
                "active" => false
            ),
            "lodgingRoomFeatures" => array(
                "title" => "Caracteristicas de Habitaciones",
                "allow" => true,
                "active" => false
            ),
            "lodgingTypeOfRoomByPrice" => array(
                "title" => "Habitaciones",
                "allow" => true,
                "active" => false
            ),
            "lodgingTypeOfRoomByPriceReception" => array(
                "title" => "Habitaciones",
                "allow" => true,
                "active" => false
            ),
            "humanResourcesEmployeeProfile" => array(
                "title" => "Personal",
                "allow" => true,
                "active" => false
            ),
            "humanResourcesDepartment" => array(
                "title" => "Departamentos",
                "allow" => true,
                "active" => false
            ),
            "humanResourcesOrganizationalChartArea" => array(
                "title" => "Areas",
                "allow" => true,
                "active" => false
            ),
            "customer" => array(
                "title" => "Clientes",
                "allow" => true,
                "active" => false
            ),
            "customerPresentation" => array(
                "title" => "Presentaciones",
                "allow" => true,
                "active" => false
            ),
            "customerData" => array(
                "title" => "Clientes",
                "allow" => true,
                "active" => false
            ),
            "educationalInstitutionByBusiness" => array(
                "title" => "Clientes",
                "allow" => true,
                "active" => false
            ),
            "eventsTrailsProject" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "templateInformation" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "taxByBusiness" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByLanguage" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByHistory" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByMenuManagementFrontend" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByAcademicOfferings" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByAcademicOfferingsInstitution" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByPartnerCompanies" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByInformationCustom" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessCounterCustom" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByFrequentQuestion" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByRequirements" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "product" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "productService" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "orderPaymentsManager" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "repairProductByBusiness" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByDiscount" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByShippingRate" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "businessByGamification" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "gamificationTypeActivity" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "allergies" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "habits" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "patient" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "mailingTemplate" => array(
                "title" => "Plantillas",
                "allow" => true,
                "active" => false
            ),
            "invoiceSale" => array(
                "title" => "Plantillas",
                "allow" => true,
                "active" => false,
                "configData" => array(
                    "title" => "Product",
                    "data" => [],
                    "titleEvent" => "",
                    "business_id" => $business->id
                )
            ),
            "invoiceSaleManager" => array(
                "title" => "Plantillas",
                "allow" => true,
                "active" => false,
                "configData" => array(
                    "title" => "Product",
                    "data" => [],
                    "titleEvent" => "",
                    "business_id" => $business->id
                )
            ),
            "mikrotikRateLimit" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "mikrotikTypeConection" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "mikrotikDhcpServer" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "mikrotikByCustomerEngagement" => array(
                "title" => "Información",
                "allow" => true,
                "active" => false
            ),
            "workPlanningHeader" => array(
                "title" => "Planificacion",
                "allow" => true,
                "active" => false
            ),
            "projectHeader" => array(
                "title" => "Planificacion",
                "allow" => true,
                "active" => false
            )
        );
        $managerProcessBusiness = array(
            "configGallery" => array(
                "title" => "Hola",
                "subtitle" => "Lola",
                "business_id" => $business->id
            ),
            "configDataSchedules" => array(
                "schedules" => [],
                "business_id" => $business->id
            ),
            "configDataMikrotikRateLimit" => array(
                "title" => "MikrotikRateLimit",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataMikrotikTypeConection" => array(
                "title" => "MikrotikTypeConection",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataMikrotikDhcpServer" => array(
                "title" => "MikrotikDhcpServer",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataMikrotikByCustomerEngagement" => array(
                "title" => "MikrotikByCustomerEngagement",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataProducts" => array(
                "user" => array(
                    "id" => $user->id
                ),
                "business_id" => $business->id
            ),
            "configDataProductsService" => array(
                "user" => array(
                    "id" => $user->id
                ),
                "business_id" => $business->id
            ),
            "configDataPanorama" => array(
                "title" => "hola",
                "data" => array(
                    array("src" => "")
                ),
                "business_id" => $business->id
            ),
            "configDataRoutes" => array(
                "title" => "Rutas",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataHumanResourcesPermissionType" => array(
                "title" => "Tipos de Permiso",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataHumanResourcesScheduleType" => array(
                "title" => "Tipos de Permiso",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "dashboard" => array(
                "title" => "Dashboard",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataOrderPaymentsManager" => array(
                "title" => "OrderPaymentsManager",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataEventsTrailsProject" => array(
                "title" => "EventsTrailsProject",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataEducationalInstitutionAskwerType" => array(
                "title" => "EducationalInstitutionAskwerType",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataHumanResourcesDepartment" => array(
                "title" => "Departamentos87",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataHumanResourcesOrganizationalChartArea" => array(
                "title" => "Areas",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataWorkPlanningHeader" => array(
                "title" => "Planificacion",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataProjectHeader" => array(
                "title" => "Planificacion",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataHumanResourcesEmployeeProfile" => array(
                "title" => "Personal",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataLodging" => array(
                "title" => "Registro de Huespedes",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataLodgingTypeOfRoom" => array(
                "title" => "Registro de habitaciones",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataLodgingRoomLevels" => array(
                "title" => "Registro de Niveles",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataLodgingRoomFeatures" => array(
                "title" => "Registro de Caracteristicas",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataLodgingTypeOfRoomByPrice" => array(
                "title" => "Registro de Habitaciones",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataLodgingTypeOfRoomByPriceReception" => array(
                "title" => "Receptcion de Habitaciones",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataLodgingStatisticalData" => array(
                "title" => "Reportes Estadisticos",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "uploadConfig" => array(
                "uploadElementsSelectors" => array(
                    "file" => "#file_upload_img"
                )
            ),
            "configDataCustomer" => array(
                "title" => "Registro de Clientes",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataCustomerPresentation" => array(
                "title" => "Registro de Presentacion ",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataCustomerData" => array(
                "title" => "Registro de Clientes",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataEducationalInstitutionByBusiness" => array(
                "title" => "Gestion de Formularios",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataTemplateInformation" => array(
                "title" => "Gestion de Pagina Web",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataTaxByBusiness" => array(
                "title" => "TaxByBusiness",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByLanguage" => array(
                "title" => "TaxByBusiness",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataProduct" => array(
                "title" => "Product",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataProductManager" => array(   //BUSINESS-MANAGER-MENU-DATA--PRODUCT-MANAGER
                "title" => "Product Manager",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataProductService" => array(
                "title" => "Product",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataRepairProductByBusiness" => array(
                "title" => "RepairProductByBusiness",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByDiscount" => array(
                "title" => "BusinessByDiscount",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByShippingRate" => array(
                "title" => "BusinessByShippingRate",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByGamification" => array(
                "title" => "BusinessByGamification",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataGamificationTypeActivity" => array(
                "title" => "GamificationTypeActivity",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "managerChat" => array(
                array(
                    "text" => "WhatsApp",
                    "span" => "Contáctanos",
                    "msg" => "",
                    "img" => "https://cuponcity.ec/img/whatsappbtn.png",
                    "url" => ""
                )
            ),
            "configDataBusinessCounterCustom" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByRequirements" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByFrequentQuestion" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByPartnerCompanies" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByInformationCustom" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByHistory" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByMenuManagementFrontend" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByAcademicOfferings" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataBusinessByAcademicOfferingsInstitution" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataAllergies" => array(
                "title" => "Allergies",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataHabits" => array(
                "title" => "Habits",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business->id
            ),
            "configDataPatient" => array(
                "title" => "Pacientes",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business
            ),
            "configDataMailingTemplate" => array(
                "title" => "MailingTemplate",
                "data" => [],
                "titleEvent" => "",
                "business_id" => $business
            )
        );
        $result = [
            'configModulesAllow' => $configModulesAllow,
            'managerProcessBusiness' => $managerProcessBusiness,
            'actionsCurrentProcess' => $actionsCurrentProcess

        ];
        return $result;
    }

    public static function getDataMenuManager($params)//BUSINESS-MANAGER-MENU
    {
        $user = Auth::user();
        $params['user']=$user ;
        $nameProcess = $params['typeManager'];
        $modelDataManager = $params['modelDataManager'];
        $business = $modelDataManager['business'][0];
        $resultDataMenu=self::getDataForAppVariables($params);
        $configModulesAllow=$resultDataMenu['configModulesAllow'];
        $managerProcessBusiness=$resultDataMenu['managerProcessBusiness'];
        $actionsCurrentProcess=$resultDataMenu['actionsCurrentProcess'];


        $typeError = 'anyone';
        $msg = 'anyone';
        $success = true;
        $keyCurrentProcess = null;
        $managerViewMain = null;
        $rolesManager = [];
        $isAdmin = false;
        $menuCurrentManager = array();
        $configModules = [];

        $isParentManager = false;
        $allowModules = false;
        $modulesManager = [];

        if ($nameProcess == null) {

            $keyCurrentProcess = 'managerInformation';
            $managerViewMain = $keyCurrentProcess;


        } else {
            $keyCurrentProcess = $nameProcess;
            $managerViewMain = $keyCurrentProcess;

        }

        $menuConfigCurrent = array();


        $user_id = $user->id;

        $actionExist = isset($actionsCurrentProcess[$keyCurrentProcess]['action']);
        $managerKeyMenu = [];
        $isChildren = false;

        $case = null;
        if (!$actionExist) {//BUSINESS-MANAGER-MENU-ACTION-ACCESS

            $msg = 'No existe este proceso.';
            $success = false;
            $typeError = '404';//anyone
            $case = 01;
        } else {

            $managerKeyMenu = $actionsCurrentProcess[$keyCurrentProcess];
            $keyChildrenCurrent = '';
            $keyParentCurrent = '';
            $isChildren = $actionsCurrentProcess[$keyCurrentProcess]['isChildren'];
            if ($isChildren) {
                $keyParentCurrent = $actionsCurrentProcess[$keyCurrentProcess]['keyParent'];
                $keyChildrenCurrent = $actionsCurrentProcess[$keyCurrentProcess]['keyChildren'];
            } else {
                $keyParentCurrent = $actionsCurrentProcess[$keyCurrentProcess]['keyChildren'];
            }
            if ($user_id != 1) {
                $isAdmin = false;
                $modulesManager = self::getRolesManager([
                    'user' => $user
                ]);
                //OBTENER MENU SIN VALIDACIONES

                $menuCurrent = array();


                $menuCurrent = self::getModulesMenuByRole($modulesManager['roleManager']);
                $managerRoles = $modulesManager;
                $actionsMenu = $managerRoles['actions'];
                $haystack = $actionsMenu;
                $menuConfigCurrent = $menuCurrent;

                $menuConfigCurrent = BusinessMenu::structureActiveMenu([
                    'menuConfigCurrent' => $menuConfigCurrent,
                    'haystack' => $haystack,
                    'isChildren' => $isChildren,
                    'keyChildrenCurrent' => $keyChildrenCurrent,
                    'keyParentCurrent' => $keyParentCurrent,


                ]);
                $menuCurrentManager=$menuConfigCurrent;

            } else {
                $isAdmin = true;
                $menuCurrentManager = self::getModulesMenuByRole('GOD');

            }

        }


        if ($success) {
            $isParentManager = $actionsCurrentProcess[$keyCurrentProcess]['isChildren'];

            if ($isParentManager) {

                if (!isset($menuCurrentManager[$actionsCurrentProcess[$keyCurrentProcess]['keyParent']]['parentData'][$actionsCurrentProcess[$keyCurrentProcess]['keyChildren']])) {
                    $success = false;
                    $typeError = '401';
                    $msg = 'No tiene Acceso a este Proceso.';
                } else {
                    $success = true;
                    $typeError = '202';
                    $msg = 'Acceso al sistema.';
                }
            } else {

                if (!isset($menuCurrentManager[$actionsCurrentProcess[$keyCurrentProcess]['keyChildren']])) {
                    $success = false;
                    $typeError = '401';
                    $msg = 'No tiene Acceso a este Proceso.';
                } else {
                    $success = true;
                    $typeError = '202';
                    $msg = 'Acceso al sistema.';
                }
            }
        }
        $result = [
            'typeError' => $typeError,
            'msg' => $msg,
            'success' => $success,
            'isAdmin' => $isAdmin,
            'rolesManager' => $rolesManager,
            'menuCurrent' => $menuCurrentManager,
            'managerKeysMenu' => $managerKeyMenu,
            'isChildren' => $isChildren,
            'configModulesAllow' => $configModulesAllow,
            'managerProcessBusiness' => $managerProcessBusiness
        ];


        return $result;

    }

//STEP MENU 6
    public static function getModulesHumanResources()//CPP
    {


        $result = array(
            'dashboard' => array(
                'title' => 'Tablero',
                'allow' => true,
                'active' => false,
                'icon' => 'remixicon-dashboard-line',
                'isParent' => false,
                'link' => 'managerBusiness'
            ),
            'business' => array(
                'title' => 'Empresa',
                'allow' => false,
                'active' => false,
                'icon' => 'fas fa-business-time',
                'isParent' => true,
                'parentData' => array(
                    /*    'information' => array(
                            'title' => 'Informacion Empresa',
                            'allow' => true,
                            'active' => false,
                            'icon' => 'fa  fa-building',
                            'isParent' => false,
                            'link' => 'business/saveBusiness'
                        ),*/
                    'businessByLanguage' => array(
                        'title' => 'Idiomas',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'businessByLanguage/admin'
                    ),
                    'taxByBusiness' => array(
                        'title' => 'Iva',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'taxByBusiness/admin'
                    ),
                    'gallery' => array(
                        'title' => 'Galeria Empresa',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'fa fa-camera',
                        'isParent' => false,
                        'link' => 'business/gallery/adminBusiness'

                    ),
                    'businessBySchedule' => array(
                        'title' => 'Horarios',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'business/schedules'

                    ),
                    'businessByMenuManagementFrontend' => array(
                        'title' => 'Menu Frontend',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessByMenuManagementFrontend/admin'

                    ),
                    'businessByHistory' => array(
                        'title' => 'Historia',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessByHistory/admin'

                    ),

                    'businessByAcademicOfferings' => array(
                        'title' => 'Ofertas Academicas Slider',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessByAcademicOfferings/admin'

                    ),
                    'businessByAcademicOfferingsInstitution' => array(
                        'title' => 'Ofertas Academicas',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessByAcademicOfferingsInstitution/admin'

                    ),
                    'businessByInformationCustom' => array(
                        'title' => 'Mision/Vision',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessByInformationCustom/admin'

                    ),

                    'businessCounterCustom' => array(
                        'title' => 'Counters',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessCounterCustom/admin'

                    ),
                    'businessByPartnerCompanies' => array(
                        'title' => 'Empresas Aliadas',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessByPartnerCompanies/admin'

                    ),

                    'businessByFrequentQuestion' => array(
                        'title' => 'Preguntas Frecuentes',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessByFrequentQuestion/admin'

                    ),

                    'businessByRequirements' => array(
                        'title' => 'Requerimientos',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'businessByRequirements/admin'

                    ),
                )
            ),
            'attendance' => array(
                'title' => 'Asistencia ',
                'allow' => true,
                'active' => false,
                'icon' => 'fa  fa-users',
                'isParent' => true,
                'parentData' => array(
                    'humanResourcesPermissionType' => array(
                        'title' => 'Tipos Permiso ',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'attendance/humanResourcesPermissionType/admin'
                    ),
                    'humanResourcesShift' => array(
                        'title' => 'Turnos ',//horarioEmpleado
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'attendance/humanResourcesShift/admin'
                    ),
                    'humanResourcesScheduleType' => array(
                        'title' => 'Tipo de Permisos ',//horarioEmpleado
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'attendance/humanResourcesScheduleType/admin'
                    ),
                    'humanResourcesEmployeeProfileByPermission' => array(
                        'title' => 'Permisos ',//horarioEmpleado
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'attendance/humanResourcesEmployeeProfileByPermission/admin'
                    ),
                )
            ),
            'humanResources' => array(
                'title' => 'RRHH',
                'allow' => true,
                'active' => false,
                'icon' => 'fa  fa-sitemap',
                'isParent' => true,
                'parentData' => array(
                    'humanResourcesOrganizationalChartArea' => array(
                        'title' => 'Areas',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/humanResourcesOrganizationalChartArea/admin'
                    ),
                    'humanResourcesDepartment' => array(
                        'title' => 'Departamentos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/humanResourcesDepartment/admin'
                    ),
                    'humanResourcesEmployeeProfile' => array(
                        'title' => 'Personal',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/humanResourcesEmployeeProfile/admin'
                    ),
                )
            ),
            'marketing' => array(
                'title' => 'Marketing',
                'allow' => true,
                'active' => false,
                'icon' => 'fa  fa-sitemap',
                'isParent' => true,
                'parentData' => array(
                    'mailingTemplate' => array(
                        'title' => 'Plantillas',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'mailingTemplate/admin'
                    ),

                )
            ),
            'askwer' => array(
                'title' => 'Gestion Formularios',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-list',
                'isParent' => true,
                'parentData' => array(
                    'educationalInstitutionAskwerType' => array(
                        'title' => 'Tipos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/educationalInstitutionAskwerType/admin'
                    ),
                    'educationalInstitutionByBusiness' => array(
                        'title' => 'Formularios',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/educationalInstitutionByBusiness/admin'
                    ),

                )
            ),
            'crm' => array(
                'title' => 'CRM',
                'allow' => true,
                'active' => false,
                'icon' => 'fas fa-users',
                'isParent' => true,
                'parentData' => array(
                    'customer' => array(
                        'title' => 'Clientes',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/customer/admin'
                    )
                )
            ),
            'prosecutorOffice' => array(
                'title' => 'Fiscalia',
                'allow' => true,
                'active' => false,
                'icon' => 'fas fa-users',
                'isParent' => true,
                'parentData' => array(
                    'customerPresentation' => array(
                        'title' => 'Presentaciones ',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/customer/adminPresentation'
                    )
                )
            ),
            'routes' => array(
                'title' => 'Rutas-Mapas',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-map-signs',
                'isParent' => true,
                'parentData' => array(
                    'routes' => array(
                        'title' => 'Chakiñanes',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'fa fa-map-signs',
                        'link' => 'business/routes/adminBusiness',
                    ),
                    'panorama' => array(
                        'title' => 'Galeria Markers',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-images',
                        'isParent' => false,
                        'link' => 'business/panorama/adminBusiness'
                    ),
                )
            ),
            'store' => array(
                'title' => 'Tienda',
                'allow' => true,
                'active' => false,
                'icon' => 'fas fa-clipboard',
                'isParent' => true,
                'parentData' => array(
                    'product' => array(
                        'title' => 'Productos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'product/admin',
                    ),
                    'productManager' => array(
                        'title' => 'Gestion Productos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'productManager/admin',
                    ),
                    'businessByDiscount' => array(
                        'title' => 'Desc. Productos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'businessByDiscount/admin',
                    ),
                    'productService' => array(
                        'title' => 'Servicios',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'productService/admin',
                    ),
                    'businessByShippingRate' => array(
                        'title' => 'Configuracion Envio',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'fas fa-shipping-fast',
                        'isParent' => false,
                        'link' => 'businessByShippingRate/admin'
                    ),
                    'orderPaymentsManager' => array(
                        'title' => 'Eccomerce',
                        'allow' => true,
                        'active' => false,
                        'icon' => ' fas fa-clipboard',
                        'isParent' => false,
                        'link' => 'orderPaymentsManager/admin'
                    ),

                    'invoiceSaleManager' => array(
                        'title' => 'Punto de Venta',
                        'allow' => true,
                        'active' => false,
                        'icon' => ' fas fa-clipboard',
                        'isParent' => false,
                        'link' => 'invoiceSaleManager/save'
                    ),
                    'invoiceSale' => array(
                        'title' => 'Facturas Ventas',
                        'allow' => true,
                        'active' => false,
                        'icon' => ' fas fa-clipboard',
                        'isParent' => false,
                        'link' => 'invoiceSale/admin'
                    ),

                )
            ),

            'gamification' => array(
                'title' => 'Gamificacion',
                'allow' => true,
                'active' => false,
                'icon' => 'fas fa-gamepad',
                'isParent' => true,
                'parentData' => array(
                    'gamificationTypeActivity' => array(
                        'title' => 'Tipos de Actividad',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'gamificationTypeActivity/admin',
                    ),
                    'businessByGamification' => array(
                        'title' => 'Administración',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'businessByGamification/admin',
                    ),
                )
            ),
            'templateInformation' => array(
                'title' => 'Pagina Web',
                'allow' => true,
                'active' => false,
                'icon' => 'fab fa-html5',
                'isParent' => false,
                'link' => 'templateInformation/admin'
            ),
            'repair' => array(
                'title' => 'Gestion Reparacion',
                'allow' => true,
                'active' => false,
                'icon' => ' fas fa-toolbox',
                'isParent' => true,
                'parentData' => array(
                    'repairProductByBusiness' => array(
                        'title' => 'Partes/Otros',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'repairProductByBusiness/admin'
                    ),
                    'repair' => array(
                        'title' => 'Reparaciones',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'repair/admin'
                    ),
                )

            ),
            'hospital' => array(
                'title' => 'Consultorio',
                'allow' => true,
                'active' => false,
                'icon' => 'far fa-hospital',
                'isParent' => true,
                'parentData' => array(
                    /*   'antecedent' => array(
                           'title' => 'Antecedentes',
                           'allow' => true,
                           'active' => false,
                           'icon' => 'far fa-clock',
                           'isParent' => false,
                           'link' => 'antecedent/admin'
                       ),*/
                    /*  'clinicalExam' => array(
                          'title' => 'Examenes Clinicos',
                          'allow' => true,
                          'active' => false,
                          'icon' => 'far fa-clock',
                          'isParent' => false,
                          'link' => 'clinicalExam/admin'
                      ),*/
                    'allergies' => array(
                        'title' => 'Alergias',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'allergies/admin'
                    ),
                    'habits' => array(
                        'title' => 'Habitos',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'habits/admin'
                    ),
                    'patient' => array(
                        'title' => 'Pacientes',
                        'allow' => true,
                        'active' => false,
                        'icon' => 'far fa-clock',
                        'isParent' => false,
                        'link' => 'historyClinic/admin'
                    ),
                )
            ),
            'housing' => array(
                'title' => 'Hoteleria',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-building',
                'isParent' => true,
                'parentData' => array(
                    'lodgingTypeOfRoom' => array(
                        'title' => 'Tipos de Habitaciones',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/lodgingTypeOfRoom/admin'
                    ),
                    'lodgingRoomLevels' => array(
                        'title' => 'Niveles de Habitacion',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/lodgingRoomLevels/admin'
                    ),
                    'lodgingRoomFeatures' => array(
                        'title' => 'Caracteristicas Habitacion',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/lodgingRoomFeatures/admin'
                    ),
                    'lodgingTypeOfRoomByPrice' => array(
                        'title' => 'Habitaciones',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/lodgingTypeOfRoomByPrice/admin'
                    ),

                    'lodging' => array(
                        'title' => 'Recepción',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/lodging/adminBusiness'
                    ),
                    'lodgingStatisticalData' => array(
                        'title' => 'Reportes Estadisticos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/lodging/results'
                    ),

                )
            ),

            'eventsTrailsProject' => array(
                'title' => 'Eventos-Deportes',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-calendar',
                'isParent' => false,
                'link' => 'eventsTrailsProject/admin'
            ),
        );
        return $result;
    }

    public static function getModulesMenuByRole($roleName)//BUSINESS-MANAGER-MENU-DATA
    {
        $result = BusinessMenu::getModulesHumanResources();

        return $result;

    }

    public static function getUrlManager()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $redirectTo = '';
        $businessProfile = new BusinessByEmployeeProfile();
        $resultBusiness = $businessProfile->getUserBusiness(
            array(
                'user_id' => $user_id
            )
        );


        if ($resultBusiness) {
            $redirectTo = "/managerBusiness/" . $resultBusiness->business_id . '/managerDashboard';
        } else {
            $role = new Role();
            $redirectTo = $role->getUrlCurrentUser();
        }

        return $redirectTo;
    }

    const MANAGER_DEFAULT_MENU = 'Information';
    const MANAGER_LODGING_MENU = 'Lodging';

    const HOUSING_SUBCATEGORIES = array(
        31, 26, 24, 25, 23

    );

//STEP1
    public static function getManagerViewMainBusiness($params)
    {
        $business = $params['business'];
        $user = $params['user'];
        $isHousing = false;
        if ($user->id != 1) {
            $isHousing = in_array($business->business_subcategories_id, self::HOUSING_SUBCATEGORIES);
            $managerViewMain = self::MANAGER_DEFAULT_MENU;
            $isParent = false;
            $keyParent = 'information';
            $keyChildren = '';

            if ($isHousing) {
                $managerViewMain = self::MANAGER_LODGING_MENU;
                $keyParent = 'housing';
                $keyChildren = 'lodging';
                $isParent = true;

            }
        } else {
            $isHousing = true;
            $managerViewMain = self::MANAGER_LODGING_MENU;
            $keyParent = 'housing';
            $keyChildren = 'lodging';
            $isParent = true;
        }

        $result = array(
            'viewMain' => $managerViewMain,
            'keyParent' => $keyParent,
            'keyChildren' => $keyChildren,
            'isParent' => $isParent,
            'isHousing' => $isHousing
        );
        return $result;

    }

//STEP


    public static function getModuleAllowSubcategory($params)
    {
        $managerRoles = $params['managerRoles'];
        $roleManager = $managerRoles['roleManager'];
        $modules = array(
            'information' => array(
                'isParent' => false,

            ),
            'eventsTrailsProject' => array(
                'isParent' => false,
            ),
            'products' => array(
                'isParent' => false,


            ),
            'schedules' => array(
                'isParent' => false,


            ),
            'gallery' => array(
                'isParent' => false,

            ),
            'routes' => array(
                'isParent' => false,

            ),
            'panorama' => array(

                'isParent' => false,

            ),


        );

        $business_subcategories_id = isset($params['business']) ? $params['business']->business_subcategories_id : null;
        $result = array();
        $housingSubcategories = self::HOUSING_SUBCATEGORIES;
        $accessHousing = in_array($business_subcategories_id, $housingSubcategories);
        if ($accessHousing) {
            $modules = array(
                'information' => array(
                    'isParent' => false,

                ),
                'schedules' => array(
                    'isParent' => false,
                ),
                'gallery' => array(
                    'isParent' => false,
                ),
                'routes' => array(
                    'isParent' => false,

                ),
                'panorama' => array(
                    'isParent' => false,
                ),
                'humanResources' => array(
                    'isParent' => true,
                    'parentData' => array(
                        'humanResourcesDepartment',
                        'humanResourcesEmployeeProfile'
                    )
                ),
                'crm' => array(
                    'isParent' => true,
                    'parentData' => array(
                        'customer'
                    )
                ),
                'housing' => array(
                    'isParent' => true,
                    'parentData' => array(
                        'lodgingTypeOfRoom',
                        'lodgingRoomLevels',
                        'lodgingRoomFeatures',
                        'lodgingTypeOfRoomByPrice',
                        'lodgingStatisticalData',
                        'lodging'
                    )
                )
            );
            if ($roleManager == 'managerReceptionRole') {
                $modules = array(
                    'information' => array(
                        'isParent' => false,

                    ),
                    'crm' => array(
                        'isParent' => true,
                        'parentData' => array(
                            'customer'
                        )
                    ),
                    'housing' => array(
                        'isParent' => true,
                        'parentData' => array(
                            'lodgingTypeOfRoom',
                            'lodgingRoomLevels',
                            'lodgingRoomFeatures',
                            'lodgingTypeOfRoomByPrice',
                            'lodgingStatisticalData',
                            'lodging'
                        )
                    )
                );
            }
            $result = $modules;

        } else {
            $result = $modules;
        }


        return $result;


    }

//STEP

    public static function searchModules($params)
    {
        $haystack = $params['haystack'];
        $needle = $params['needle'];
        $isParentManager = $params['isParent'];
        $result = array();
        foreach ($haystack as $key => $value) {
            $isParent = $value['isParent'];
            if ($isParent) {

                if ($isParentManager) {
                    if ($isParent) {
                        $parentData = $value['parentData'];
                        foreach ($parentData as $keySubMenu => $valueMenu) {

                            if ($keySubMenu == $needle) {
                                $result = array(
                                    'parentData' => $valueMenu,
                                    'parent' => $value
                                );
                                break;
                            }
                        }

                    }
                }
            } else {
                if ($key == $needle) {
                    $result = $value;
                    break;
                }
            }

        }

        return $result;
    }

    public static function searchModulesSetActive($params)
    {
        $haystack = $params['haystack'];
        $needle = $params['needle'];
        $isParentManager = $params['isParent'];

        foreach ($haystack as $key => $value) {
            $isParent = $value['isParent'];
            if ($isParent) {

                if ($isParentManager) {
                    if ($isParent) {
                        $parentData = $value['parentData'];
                        foreach ($parentData as $keySubMenu => $valueMenu) {

                            if ($keySubMenu == $needle) {

                                $haystack[$key]['parentData'][$keySubMenu]['active'] = true;
                                $haystack[$key]['active'] = true;

                                break;
                            }
                        }

                    }
                }
            } else {
                if ($key == $needle) {
                    $haystack[$key]['active'] = true;
                    break;
                }
            }
        }

        return $haystack;
    }

//STEP MENU 3


    public static function getRolesManager($params)
    {

        $user = $params['user'];
        $user_id = $user->id;
        $actions = array();
        $roleManager = 'managerAdminTotal';
        $roles = array();
        if ($user_id != 1) {

            $actionsMenu = UsersHasRoles::getRolesActionsByUser($user_id);//modifier
            $actions = $actionsMenu;
            foreach ($actionsMenu as $value) {
                $role_id = $value->role_id;
                if (!in_array($role_id, $roles)) {
                    array_push($roles, $role_id);
                    if ($role_id == Role::ROL_BUSINESS) {

                        $roleManager = Role::ROL_BUSINESS_MANAGER;

                        break;
                    } else if ($role_id == Role::ROL_RECEPTIONIST) {

                        $roleManager = Role::ROL_RECEPTIONIST_MANAGER;

                        break;
                    } else if ($role_id == Role::ROL_CUSTOMER) {

                        $roleManager = Role::ROL_CUSTOMER_MANAGER;
                        break;
                    } else if ($role_id == Role::ROL_EMPLOYER) {
                        $roleManager = Role::ROL_EMPLOYER_MANAGER;
                        break;
                    }
                }
            }
        }

        $result = array(
            'roles' => $roles,
            'roleManager' => $roleManager,
            'actions' => $actions

        );
        return $result;
    }

//STEP MENU 1


    public static function getMenuManager($params)
    {
        $result = array();
        $id = $params['id'];
        $urlInit = isset($params['urlInit']) ? $params['urlInit'] : null;

        $typeManagerCurrent = $params['typeManager'];
        $configModules = array();
        $isParentManager = false;
        $allowModules = false;

        $keyParentManagerActive = null;
        $keyChildrenManagerActive = null;
        $msg = 'Not Message';
        $menuConfigByRole = $params['menuConfigByRole'];
        $menuCurrent = $menuConfigByRole['menuCurrent'];

        if ($urlInit) {

            foreach ($menuCurrent as $key => $menu) {
                $isParentCurrent = $menu['isParent'];
                if ($isParentCurrent) {
                    $parentData = $menu['parentData'];
                    foreach ($parentData as $keyChildren => $submenu) {
                        $typeManager = 'manager' . ucfirst($keyChildren);
                        $menuCurrent[$key]['parentData'][$keyChildren]['typeManager'] = $typeManager;
                        $urlCurrent = url($urlInit . '/' . $id . '/' . $typeManager);
                        $menuCurrent[$key]['parentData'][$keyChildren]['urlCurrent'] = $urlCurrent;

                    }
                } else {
                    $typeManager = 'manager' . ucfirst($key);
                    $menuCurrent[$key]['typeManager'] = $typeManager;
                    $urlCurrent = url($urlInit . '/' . $id . '/' . $typeManager);
                    $menuCurrent[$key]['urlCurrent'] = $urlCurrent;

                }
            }

        }

        $managerViewMain = $menuConfigByRole;

        $isParentManager = $managerViewMain['managerKeysMenu']['isChildren'];
        $configModules = [];
        if ($isParentManager) {

            $configModules = [
                'keyParent' => $managerViewMain['managerKeysMenu']['keyChildren'],
                'keyChildren' => $managerViewMain['managerKeysMenu']['keyParent'],
            ];
        } else {
            $configModules = [

                'keyChildren' => $managerViewMain['managerKeysMenu']['keyChildren'],
            ];
        }
        $modulesAllow = array(
            'isParent' => $isParentManager,
            'config' => $configModules,
            'allow' => true,
            'msg' => $msg
        );
        $success = true;
        $result = array(
            'menu' => $menuCurrent,
            'configModulesAllow' => $modulesAllow,
            'success' => $success,
            'managerViewMain' => $managerViewMain

        );
        return $result;
    }


}
