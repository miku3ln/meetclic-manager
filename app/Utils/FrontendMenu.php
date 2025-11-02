<?php

namespace App\Utils;

use App\Utils\Util;
use Auth;

class FrontendMenu
{


    /*-----frontend menu----------*/


    public static function getManagerViewMainFrontend($params)
    {
        $model = $params['model'];
        $user = $params['user'];
        $managerViewMain = 'Dashboard';
        $isParent = false;
        $keyParent = 'dashboard';
        $keyChildren = 'dashboard';
        $result = array(
            'viewMain' => $managerViewMain,
            'keyParent' => $keyParent,
            'keyChildren' => $keyChildren,
            'isParent' => $isParent,
        );
        return $result;

    }

//STEP ONE
    public static function getMenuConfigByRoleFrontend($params)
    {
        $user = $params['user'];
        $id = $params['id'];

        $dataManager = $params['dataManager'];
        $model = $dataManager['model'];
        $managerViewMain = $params['managerViewMain'];
        $typeManager = $params['typeManager'];
        $user_id = $user->id;
        $paramsManager = array(
            'model' => $model,
            'user' => $user,
            'managerViewMain' => $managerViewMain,
            'typeManager' => $typeManager,
            'id' => $id

        );
        $modulesManager = self::getModulesFrontend($paramsManager);
        $menuConfigCurrent = $modulesManager['menuConfigCurrent'];

        $menuCurrent = array();


        if ($user_id != 1) {

            $managerRoles = $modulesManager['managerRoles'];
            $actionsMenu = $managerRoles['actions'];
            $isParentManager = false;
            $allowModules = false;
            $configModules = array();
            $haystack = $actionsMenu;


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
                        $searchResult = Util::searchInArray(array("haystack" => $haystack, "needle" => $needle, "keyCompare" => $keyCompare, "isObject" => true));
                        if (!empty($searchResult)) {
                            $submenu['allow'] = true;
                            $children[$keyChildren] = $submenu;
                            if ($submenu['active']) {
                                $keyChildrenActive = $keyChildren;

                            }
                        }
                    }
                    if (!empty($children)) {
                        $setPush = $menu;
                        $setPush['allow'] = true;
                        $setPush['parentData'] = $children;
                        $allowPush = true;
                        if ($menu['active']) {

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
                    $searchResult = Util::searchInArray(array("haystack" => $haystack, "needle" => $needle, "keyCompare" => $keyCompare, "isObject" => true));

                    if (!empty($searchResult)) {
                        $allowPush = true;
                        $setPush = $menu;
                        $typeManager = 'manager' . ucfirst($key);
                        $setPush['typeManager'] = $typeManager;
                        $setPush['allow'] = true;
                        if ($menu['active']) {
                            $isParentManager = true;
                            $configModules = array(
                                'keyParent' => $key
                            );
                            $allowModules = true;

                        }
                    }


                }
                if ($allowPush) {
                    $menuCurrent[$key] = $setPush;
                }
            }
        } else {
            $menuCurrent = $menuConfigCurrent;
            $isParentManager = $managerViewMain['isParent'];
            $allowModules = true;
            $configModules = array(
                'keyChildren' => $managerViewMain['keyChildren'],
                'keyParent' => $managerViewMain['keyParent'],

            );

        }

        $result = array(
            'menuCurrent' => $menuCurrent,
            'isParentManager' => $isParentManager,
            'configModules' => $configModules,
            'managerViewMain' => $managerViewMain,
            'allowModules' => $allowModules,
            'modulesManager' => $modulesManager
        );
        return $result;
    }

//STEP TWO
    public static function getModulesFrontend($params)
    {
        $result = array();
        $managerViewMain = $params['managerViewMain'];
        $typeManager = $params['typeManager'];
        $user = $params['user'];
        $id = $params['id'];
        $urlParent = 'frontend/manager/' . $id;
        $menuRoleReceptionist =
            array(
                'dashboard' => array(
                    'title' => 'Dashboard',
                    'allow' => true,
                    'active' => false,
                    'icon' => 'fa fa-bar-chart-o',
                    'isParent' => false,
                    'link' => 'frontend/dashboard',
                    'typeManager' => 'managerDashboard',
                    'urlCurrent' => url($urlParent . '/' . 'managerDashboard')
                )
            );
        $menuRoleManagerBusiness = array(
            'dashboard' => array(
                'title' => 'Dashboard',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-bar-chart-o',
                'isParent' => false,
                'link' => 'frontend/dashboard',
                'typeManager' => 'managerDashboard',
                'urlCurrent' => url($urlParent . '/' . 'managerDashboard')
            ),
            'sliders' => array(
                'title' => 'Sliders',
                'allow' => true,
                'active' => false,
                'icon' => ' far fa-images',
                'isParent' => true,
                'parentData' => array(
                    'templateSlider' => array(
                        'title' => 'Principal',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateSlider/admin',
                        'typeManager' => 'managerTemplateSlider',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplateSlider')
                    ),
                    'activitiesGamification' => array(
                        'title' => 'Actividades Gamificacion',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateSlider/adminActivitiesGamification',
                        'typeManager' => 'managerActivitiesGamification',
                        'urlCurrent' => url($urlParent . '/' . 'managerActivitiesGamification')
                    ),
                    'rewardsGamification' => array(
                        'title' => 'Premios Gamificacion',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateSlider/adminRewardsGamification',
                        'typeManager' => 'managerRewardsGamification',
                        'urlCurrent' => url($urlParent . '/' . 'managerRewardsGamification')
                    ),
                )
            ),
            'frontend' => array(
                'title' => 'Secciones Pagina',
                'allow' => true,
                'active' => false,
                'icon' => 'fas fa-sitemap',
                'isParent' => true,
                'parentData' => array(

                    'templateAboutUs' => array(
                        'title' => 'Quienes Somos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateAboutUs/admin',
                        'typeManager' => 'managerTemplateAboutUs',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplateAboutUs')
                    ),

                    'templatePolicies' => array(
                        'title' => 'Politicas/Terminos ',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templatePolicies/admin',
                        'typeManager' => 'managerTemplatePolicies',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplatePolicies')
                    ),
                    'templateServices' => array(
                        'title' => 'Servicios',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateServices/admin',
                        'typeManager' => 'managerTemplateServices',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplateServices')
                    ),
                    'templateNews' => array(
                        'title' => 'Noticias',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateNews/admin',
                        'typeManager' => 'managerTemplateNews',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplateNews')
                    ),
                    'templateContactUs' => array(
                        'title' => 'Contáctanos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateContactUs/getContactUsData',
                        'typeManager' => 'managerTemplateContactUs',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplateContactUs')
                    ),
                )
            ),
            'config' => array(
                'title' => 'Configuraciones',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-cog',
                'isParent' => true,
                'parentData' => array(
                    'templateBySource' => array(
                        'title' => 'Imagenes',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateBySource/save',
                        'typeManager' => 'managerTemplateBySource',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplateBySource')
                    ),
                    'templatePayments' => array(
                        'title' => 'Formas de Pagos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templatePayments/admin',
                        'typeManager' => 'managerTemplatePayments',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplatePayments')
                    ),
                  /*  'templateConfigMailing' => array(
                        'title' => 'Mail',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'templateConfigMailing/save',
                        'typeManager' => 'managerTemplateConfigMailing',
                        'urlCurrent' => url($urlParent . '/' . 'managerTemplateConfigMailing')
                    ),*/


                )
            ),
        );
        $user_id = $user->id;
        $managerRoles = array();
        $menuConfigCurrent = array();

        if ($user_id != 1) {
            $managerRoles = self::getRolesManagerFrontend($params);
            $paramsCurrent = $params;
            $paramsCurrent['managerRoles'] = $managerRoles;
            /*  $modulesCurrent = self::getModuleAllowFrontend($paramsCurrent);*/
            $modulesCurrent = [];
            $menuCurrent = array();
            if ($managerRoles['roleManager'] == 'managerBusinessRole') {
                $menuCurrent = $menuRoleManagerBusiness;

            } else if ($managerRoles['roleManager'] == 'managerReceptionRole') {
                $menuCurrent = $menuRoleReceptionist;
            }
            $modulesCurrent = $menuCurrent;
            $menuConfigCurrent = $modulesCurrent;
            if (false) {


                foreach ($modulesCurrent as $key => $value) {
                    $setPush = array();
                    $isParent = $value['isParent'];
                    $allowPush = false;
                    if ($isParent) {
                        $parentData = $value['parentData'];
                        $parentDataSet = array();
                        $parentInfo = array();

                        foreach ($parentData as $valueSubMenu) {
                            $resultData = Util::searchModules(array(
                                'haystack' => $menuCurrent,
                                'needle' => $valueSubMenu,
                                'isParent' => $isParent
                            ));
                            if (isset($resultData['parentData'])) {
                                $parentDataSet[$valueSubMenu] = $resultData['parentData'];
                                if (count($parentInfo) == 0) {
                                    $parentInfo = $resultData['parent'];
                                }
                            }

                        }
                        $setPush = $parentInfo;
                        $setPush['parentData'] = $parentDataSet;
                        if (count($parentDataSet) > 0) {
                            $allowPush = true;
                        }

                    } else {
                        $setPush = Util::searchModules(array(
                            'haystack' => $menuCurrent,
                            'needle' => $key,
                            'isParent' => $isParent
                        ));

                        if (is_array($setPush) && count($setPush) > 0) {
                            $allowPush = true;
                        }
                    }
                    if ($allowPush) {

                        $menuConfigCurrent[$key] = $setPush;
                    }
                }
            }


        } else {
            $menuConfigCurrent = $menuRoleManagerBusiness;
        }

        $isParent = $managerViewMain['isParent'];
        $needle = $isParent ? $managerViewMain['keyChildren'] : $managerViewMain['keyParent'];


        $menuConfigCurrent = Util::searchModulesSetActive(array(
            'haystack' => $menuConfigCurrent,
            'needle' => $needle,
            'isParent' => $isParent
        ));

        $result = array(
            'menuRoleManagerBusiness' => $menuRoleManagerBusiness,
            'menuRoleReceptionist' => $menuRoleReceptionist,
            'managerRoles' => $managerRoles,
            'menuConfigCurrent' => $menuConfigCurrent
        );

        return $result;
    }

    public static function getRolesManagerFrontend($params)
    {

        $user = $params['user'];
        $user_id = $user->id;
        $actions = array();
        $roleManager = 'managerAdminTotal';
        $roles = array();
        if ($user_id != 1) {

            $actionsMenu = \App\Models\UsersHasRoles::getRolesActionsByUser($user_id);
            $actions = $actionsMenu;

            foreach ($actionsMenu as $value) {
                $role_id = $value->role_id;
                if (!in_array($role_id, $roles)) {
                    array_push($roles, $role_id);
                    if ($role_id == \App\Models\Role::ROL_BUSINESS) {
                        $managerBusinessRole = true;
                        $roleManager = 'managerBusinessRole';
                        break;
                    } else if ($role_id == \App\Models\Role::ROL_RECEPTIONIST) {
                        $managerReceptionRole = true;
                        $roleManager = 'managerReceptionRole';
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

    public static function getModuleAllowFrontend($params)
    {
        $managerRoles = $params['managerRoles'];
        $roleManager = $managerRoles['roleManager'];
        $modules = array(
            'dashboard' => array(
                'isParent' => false,
            ),
            'eventsTrails' => array(
                'isParent' => true,
                'parentData' => array(
                    'eventsTrailsProject',
                    'eventsTrailsTypeOfCategories',
                    'eventsTrailsDistances',

                    'eventsTrailsByKit',
                    'eventsTrailsRegistrationPoints'
                )
            ),


        );
        $result = $modules;


        return $result;


    }

    public function getFormatArraySelect($arrayDataTypeModel, $arrayConfig = array("key" => "id", "text" => array("name")))
    {
        $result = array();
        foreach ($arrayDataTypeModel as $row) {
            $valueView = "";
            if (isset($arrayConfig["text"])) {
                foreach ($arrayConfig["text"] as $keyView) {
                    $valueView .= $row[$keyView] . " ";
                }
            }
            $result[$row[$arrayConfig["key"]]] = $valueView;
        }
        return $result;
    }

    public function getArrayByObject($object)
    {
        $setPush = json_decode(json_encode($object), true);
    }
}
