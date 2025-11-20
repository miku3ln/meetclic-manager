<?php

namespace App\Http\Controllers\Business;

use App\Components\Twilio\Client;
use App\Http\Controllers\BusinessBaseController;
use App\Http\Controllers\Products\SecretaryProcessesByCustomerPresentationController;
use App\Models\AskwerForm;
use App\Models\Business;
use App\Models\BusinessBySchedule;
use App\Models\BusinessSubcategories;
use App\Models\Country;
use App\Models\LodgingRoomLevels as LodgingRoomLevels;
use App\Models\PeopleNationality as PeopleNationality;
use App\Models\PeopleProfession as PeopleProfession;
use App\Models\PeopleTypeIdentification as PeopleTypeIdentification;
use App\Models\Repair;
use App\Models\RucType as RucType;
use App\Models\TaxByBusiness;
use App\Models\Routes\RoutesTotemSubcategories;

use App\Utils\BusinessManager;
use App\Utils\BusinessMenu;
use App\Utils\Util;
use Auth;


class BusinessManagerController extends BusinessBaseController
{

    public $typeManager = null;
    public $id = null;

    public function getDataManagerProcess($params)
    {
        $result = [];
        $processName = $params['processName'];
        if ($processName == 'managerBusinessByDiscount') {
            $modelCurrent = new \App\Models\BusinessByDiscount;
            $getTypes = $modelCurrent->getTypes();
            $result['typesData'] = $getTypes;
            $getCurrent = $modelCurrent->getTypesApply();
            $result['typesApplyData'] = $getCurrent;

        }

        return $result;

    }

    public function managerBusiness($id = null, $typeManager = null)//BUSINESS-MANAGER-PROCESS-ROOT
    {


        $managerDefaultData = [

        ];
        $allowPlugins = [];
        $managerProcessCurrent = [];

        if ($id) {
            $model = new Business();
            $modelDataManager = $model->getManagerBusinessData($id);
            $success = $modelDataManager["success"];

            if ($success) {
                $configProcess = [];
                $menuConfigByRole = [];

                $allowViewsResult = BusinessMenu::getDataMenuManager([
                    'modelDataManager' => $modelDataManager,
                    'typeManager' => $typeManager
                ]);

                $successView = $allowViewsResult['success'];
                if ($successView) {
                    $menuConfigByRole = $allowViewsResult;
                    $renderView = "";
                    $paramsSend = array();

                    $business_id = $id;
                    $dataManagerPage = [];
                    $modelBBS = new BusinessBySchedule();
                    $modelS = new BusinessSubcategories();
                    $modelC = new Country();
                    $modelPTI = new PeopleTypeIdentification();
                    $modelPN = new PeopleNationality();
                    $modelPP = new PeopleProfession();
                    $modelRT = new RucType();
                    $modelLRL = new LodgingRoomLevels();

                    $dataManagerCurrent = [];
                    $user = Auth::user();
                    $camerCase = $model->getCamelCase();
                    $moduleMain = "business";
                    $moduleResource = "manager";
                    $moduleFolder = "manager";

                    $renderView = "$moduleMain.$moduleFolder.index";
                    $model_entity = $camerCase;
                    $pathCurrent = "$moduleMain/$moduleFolder";
                    $subcategories = $modelS->getSubcategories();
                    $countries = $modelC->getStructureDrop($modelC->getCountries());

                    $peopleTypeIdentification = $modelPTI->getDataListAll();
                    $peopleProfession = $modelPP->getDataListAll();
                    $peopleNationality = $modelPN->getDataListAll();
                    $rucType = $modelRT->getDataListAll();
                    $lodgingRoomLevels = $modelLRL->getDataListAll(array("business_id" => $id));

                    $dataCatalogue = array(
                        "peopleTypeIdentification" => $peopleTypeIdentification,
                        "peopleProfession" => $peopleProfession,
                        "peopleNationality" => $peopleNationality,
                        "rucType" => $rucType,
                        "lodgingRoomLevels" => $lodgingRoomLevels,

                    );
                    $business = $modelDataManager['business'][0];
                    $managerViewMain = BusinessMenu::getManagerViewMainBusiness(array(
                        'business' => $business,
                        'user' => $user,
                    ));
                    $typeManager = $typeManager == null ? 'managerInformation' : $typeManager;
//Menu
                    $paramsMenu = array(
                        'managerViewMain' => $managerViewMain,
                        'id' => $id,
                        'user' => $user,
                        'dataManager' => $modelDataManager,
                        'typeManager' => $typeManager,
                        'urlInit' => 'managerBusiness'

                    );


                    $paramsMenu['menuConfigByRole'] = $menuConfigByRole;
                    $menuCurrentConfig = BusinessMenu::getMenuManager($paramsMenu);

                    $menuCurrent = $menuCurrentConfig['menu'];
                    $menuItems = Util::getMenuFormat($menuCurrent);
                    $menuHtml = Util::getStructureMenuCurrent($menuItems);
                    $rootView = "$moduleMain." . $moduleFolder . "." . $moduleFolder;
                    $modelsManager = array();
                    if ($typeManager == 'managerEducationalInstitutionByBusiness') {
                        $modelAF = new AskwerForm();
                        $modelsManager = $modelAF->getModelsProcess();
                    } else if ($typeManager == 'managerRepair') {
                        $modelCurrent = new Repair;
                        $dataManagerCurrent = $modelCurrent->getResults(['filters' => ['business_id' => $business_id]]);

                    }

                    $typeManager = $typeManager == null ? ('managerInformation') : $typeManager;

                    $dataManagerProcess = $this->getDataManagerProcess([
                        'processName' => $typeManager
                    ]);
                    $paramsSend = [
                        "configPartial" => array(
                            "dataManagerProcess" => $dataManagerProcess,
                            "moduleMain" => $moduleMain,
                            "moduleFolder" => $moduleFolder,
                            "moduleResource" => $moduleResource,
                            "dataCatalogue" => $dataCatalogue,
                            'menuCurrent' => $menuCurrentConfig,
                            'typeManager' => $typeManager,
                            'modelsManager' => $modelsManager,
                            'user' => $user,
                            'menuHtml' => $menuHtml,
                            'dataManagerCurrent' => $dataManagerCurrent
                        ),
                        "modelDataManager" => $modelDataManager,
                        "rootView" => $rootView,
                        'managerViewMain' => $managerViewMain,
                        "model_entity" => $model_entity,
                        'model' => $model,
                        'modelBBS' => $modelBBS,
                        "pathCurrent" => $pathCurrent,
                        "user" => $user,
                        "step1" => array(
                            "subcategories" => $subcategories,
                            "frmId" => $camerCase,
                            "model" => $model,
                            "countries" => $countries
                        )
                    ];

                    if ($typeManager == 'managerRoutes') {
                        $modelSubcategories = new RoutesTotemSubcategories();
                        $subcategoriesTotems = $modelSubcategories->getSubcategoriesHtmlDrop();
                        $paramsSend['subcategoriesTotemsDataHtml'] = $subcategoriesTotems;


                    }
                    if ($typeManager == 'managerProduct') {


                        $modelTax = new TaxByBusiness();
                        $manageTaxReady = $modelTax->getAllowManagementTax(['filters' =>
                            [
                                'business_id' => $business->id,
                                'taxConfig' => true

                            ]
                        ]);
                        $allow = false;
                        $paramsConfigTax = [];
                        $taxConfiguration = [];

                        if (!$manageTaxReady['success']) {
                            $allow = false;
                            $paramsConfigTax = $manageTaxReady['errors'];
                            $paramsSend['configPartial'][$typeManager]['partial'] = 'partials.errors.warning';
                        } else {
                            $allow = true;
                            $taxConfiguration = $manageTaxReady['data'];

                        }
                        $paramsSend['configPartial'][$typeManager]['allow'] = $allow;
                        $paramsSend['configPartial'][$typeManager]['params'] = $paramsConfigTax;
                        $paramsSend['configPartial'][$typeManager]['data'] = $taxConfiguration;
                        $modelProduct = new \App\Models\Products\Product();
                        $valuesDefaultForm = $modelProduct->configManagementProductServiceDefault();
                        $paramsSend['configPartial']['valuesDefaultForm'] = $valuesDefaultForm;

                    } else if ($typeManager == 'managerProductService') {
                        $modelTax = new TaxByBusiness();
                        $manageTaxReady = $modelTax->getAllowManagementTax(['filters' =>
                            [
                                'business_id' => $business->id,
                                'taxConfig' => true

                            ]
                        ]);
                        $allow = false;
                        $paramsConfigTax = [];
                        $taxConfiguration = [];

                        if (!$manageTaxReady['success']) {
                            $allow = false;
                            $paramsConfigTax = $manageTaxReady['errors'];
                            $paramsSend['configPartial'][$typeManager]['partial'] = 'partials.errors.warning';
                        } else {
                            $allow = true;
                            $taxConfiguration = $manageTaxReady['data'];

                        }
                        $paramsSend['configPartial'][$typeManager]['allow'] = $allow;
                        $paramsSend['configPartial'][$typeManager]['params'] = $paramsConfigTax;
                        $paramsSend['configPartial'][$typeManager]['data'] = $taxConfiguration;
                        $modelProduct = new \App\Models\Products\Product();
                        $valuesDefaultForm = $modelProduct->configManagementProductServiceDefault();
                        $paramsSend['configPartial']['valuesDefaultForm'] = $valuesDefaultForm;
                    } else if ($typeManager == 'managerProductManager') {//BUSINESS-MANAGER-RENDER--PRODUCT-MANAGER
                        $allowPlugins = [
                            'bootstrap5' => true
                        ];
                        $configProcess['model'] = 'ProductManager';
                        $configProcess['entityCamel'] = 'productManager';
                        $configProcess['entity-process'] = 'product-manager';
                        $modelTax = new TaxByBusiness();
                        $manageTaxReady = $modelTax->getAllowManagementTax(['filters' =>
                            [
                                'business_id' => $business->id,
                                'taxConfig' => true

                            ]
                        ]);
                        $allTax = $modelTax->getBusinessTaxAll(['filters' =>
                            [
                                'business_id' => $business->id,


                            ]
                        ]);

                        $allow = false;
                        $paramsConfigTax = [];
                        $taxConfiguration = [];

                        if (!$manageTaxReady['success']) {
                            $allow = false;
                            $paramsConfigTax = $manageTaxReady['errors'];
                            $paramsSend['configPartial'][$typeManager]['partial'] = 'partials.errors.warning';
                        } else {
                            $allow = true;
                            $taxConfiguration = $manageTaxReady['data'];
                            if (isset($manageTaxReady['data']['taxCurrentZero'])) {
                                array_push($allTax, $manageTaxReady['data']['taxCurrentZero']);
                            }
                        }

                        $paramsSend['configPartial'][$typeManager]['allow'] = $allow;
                        $paramsSend['configPartial'][$typeManager]['params'] = $paramsConfigTax;
                        $paramsSend['configPartial'][$typeManager]['data'] = $taxConfiguration;
                        $paramsSend['configPartial'][$typeManager]['allTax'] = $allTax;

                        $modelProduct = new \App\Models\Products\Product();
                        $valuesDefaultForm = $modelProduct->configManagementProductServiceDefault();
                        $paramsSend['configPartial']['valuesDefaultForm'] = $valuesDefaultForm;
                    } else if ($typeManager == 'managerCustomerPresentation') {
                        $modelCurrentManager = new \App\Models\ProsecutorOffice\SecretaryProcessesByCustomerPresentation();
                        $generateEntityNames = $modelCurrentManager->generateEntityNames();
                        $configProcess = $generateEntityNames;
                        $configProcess['data'] = ['stateData' => $modelCurrentManager->getStatesData()];


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
                            'locationData' => $locationData,

                        );

                        $dataManagerPage["dataCatalogue"] = $dataCatalogue;

                    } else if ($typeManager == 'managerPatient') {
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
                            'people_nationality_id_data' => \App\Models\PeopleNationality:: TYPE_ANYONE,
                            'people_profession_id_data' => \App\Models\PeopleProfession::TYPE_ANYONE,
                            'countries_id' => \App\Models\Country::ECUADOR_ID,//ecuador
                            'provinces_id' => \App\Models\Province:: IMBABURA_ID,//imbabura
                            'cities_id' => \App\Models\City:: OTAVALO_ID,//otavalo
                            'zones_id' => \App\Models\Zone::SAN_LUIS_ID,//san luis
                            'information_address_type_id_data' => \App\Models\InformationAddressType::TYPE_HOME,//domicilio
                            'information_phone_operator_id' => \App\Models\InformationPhoneOperator:: OPERATOR_NOT_SPECIFIC_ID,//sin definir
                            'information_phone_type_id' => \App\Models\InformationPhoneType:: TYPE_WORKFORCE_ID,//personal
                            'information_social_network_type_id_one' => \App\Models\InformationSocialNetworkType:: TYPE_FACEBOOK_ID,
                            'information_social_network_type_id_two' => \App\Models\InformationSocialNetworkType:: TYPE_TWITTER_ID,
                            'typeIdentificationRuc' => \App\Models\PeopleTypeIdentification::TYPE_IDENTIFICATION_RUC,
                        ];


                        $dataLegendOdontogram = \App\Models\ReferencePieceType::where('status', '=', "ACTIVE")->get();
                        $odontogramConfiguration = $dataLegendOdontogram;
                        $dataManagerPage["odontogramConfiguration"] = $odontogramConfiguration;


                    } else if ($typeManager == 'managerPointOfSale' || $typeManager == 'managerOrderPaymentsManager') {
                        $utilProcess = new \App\Utils\ProcessManagerView();
                        $resultProcess = $utilProcess->getManagerByProcess(
                            [
                                'processName' => $utilProcess::PROCESS_SALES,
                                'filters' => [
                                    'business_id' => $business_id
                                ]
                            ]
                        );
                        $paramsSend['configPartial']['resultProcess'] = $resultProcess;


                    } else if ($typeManager == 'managerInvoiceSale') {
                        $utilProcess = new \App\Utils\ProcessManagerView();
                        $resultProcess = $utilProcess->getManagerByProcess(
                            [
                                'processName' => $utilProcess::PROCESS_SALES,
                                'filters' => [
                                    'business_id' => $business_id
                                ]
                            ]
                        );

                        $paramsSend['configPartial']['resultProcess'] = $resultProcess;


                    } else if ($typeManager == 'managerCustomer') {
                        $utilProcess = new \App\Utils\ProcessManagerView();
                        $resultProcess = $utilProcess->getManagerByProcess(
                            [
                                'processName' => $utilProcess::PROCESS_CRM_MANAGER,
                                'filters' => [
                                    'business_id' => $business_id
                                ]
                            ]
                        );
                        $paramsSend['configPartial']['resultProcess'] = $resultProcess;


                    }

                    $paramsSend['dataManagerPage'] = $dataManagerPage;
                    $modelUtilManager = new BusinessManager();
                    $configManagementPage = $modelUtilManager->getDataManager([
                        'id' => $id, 'typeManager' => $typeManager,
                        'modelDataManager' => $modelDataManager
                    ]);
                    $paramsSend['configManagementPage'] = $configManagementPage;
                    $allowProcessAngular = [
                        'managerRepair',
                        'managerPointOfSale', 'managerInvoiceSale'
                    ];

                    $managerDefaultData = $modelUtilManager->getDataManagerDefault();
                    $paramsSend['allowProcessAngular'] = $allowProcessAngular;
                    $paramsSend['managerDefaultData'] = $managerDefaultData;
                    $paramsSend['menuConfigByRole'] = $menuConfigByRole;
                    $paramsSend['configProcess'] = $configProcess;
                    $paramsSend['allowPlugins'] = $allowPlugins;



                    return view($renderView, $paramsSend);
                } else {
                    if ($allowViewsResult['typeError'] == '404') {
                        return view('errors.modelsView.404', ['msg' => $allowViewsResult['msg']]);
                    } else if ($allowViewsResult['typeError'] == '401') {
                        return view('errors.modelsView.401', ['msg' => $allowViewsResult['msg']]);
                    }
                }


            } else {


                return view('errors.modelsView.404', ['msg' => 'No existe informacion de esta Empresa.']);

            }
        } else {
            return view('errors.modelsView.404', ['msg' => 'No se envio los parametros correctos.']);

        }


    }

}
