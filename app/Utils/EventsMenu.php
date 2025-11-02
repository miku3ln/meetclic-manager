<?php

namespace App\Utils;


use App\Models\Order;
use App\Models\Role;
use App\Models\UsersHasRoles;
use Auth;


class EventsMenu
{
    /*  ----manager events ----*/

    public static function getManagerViewMainEventsTrails($params)
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


    public static function getMenuConfigByRoleEventsTrails($params)
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
        $modulesManager = self::getModulesEventsTrails($paramsManager);

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

    public static function getModulesEventsTrails($params)
    {
        $result = array();
        $managerViewMain = $params['managerViewMain'];
        $typeManager = $params['typeManager'];
        $user = $params['user'];
        $id = $params['id'];
        $urlParent = 'eventsTrailsProject/manager/' . $id;

        $menuRoleManagerBusiness = array(
            'dashboard' => array(
                'title' => 'Dashboard',
                'allow' => true,
                'active' => false,
                'icon' => 'remixicon-dashboard-line',
                'isParent' => false,
                'link' => 'eventsTrailsProject/dashboard',
                'typeManager' => 'managerDashboard',
                'urlCurrent' => url($urlParent . '/' . 'managerDashboard')
            ),
            'eventsTrails' => array(
                'title' => 'Configuracion',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-cog',
                'isParent' => true,
                'parentData' => array(
                    'eventsTrailsTypeTeams' => array(
                        'title' => 'Equipos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'eventsTrailsTypeTeams/admin',
                        'typeManager' => 'managerEventsTrailsTypeTeams',
                        'urlCurrent' => url($urlParent . '/' . 'managerEventsTrailsTypeTeams')
                    ),
                    'eventsTrailsTypeOfCategories' => array(
                        'title' => 'Categorias',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'eventsTrailsTypeOfCategories/admin',
                        'typeManager' => 'managerEventsTrailsTypeOfCategories',
                        'urlCurrent' => url($urlParent . '/' . 'managerEventsTrailsTypeOfCategories')
                    ),
                    'eventsTrailsDistances' => array(
                        'title' => 'Distancias',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'eventsTrailsDistances/admin',
                        'typeManager' => 'managerEventsTrailsDistances',
                        'urlCurrent' => url($urlParent . '/' . 'managerEventsTrailsDistances')
                    ),
                    'eventsTrailsByKit' => array(
                        'title' => 'Kits',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'eventsTrailsByKit/admin',
                        'typeManager' => 'managerEventsTrailsByKit',
                        'urlCurrent' => url($urlParent . '/' . 'managerEventsTrailsByKit')
                    ),
                    'eventsTrailsRegistrationPoints' => array(
                        'title' => 'Puntos de Venta',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'eventsTrailsRegistrationPoints/admin',
                        'typeManager' => 'managerEventsTrailsRegistrationPoints',
                        'urlCurrent' => url($urlParent . '/' . 'managerEventsTrailsRegistrationPoints')
                    ),
                )
            ),

        );
        $menuRoleReceptionist =$menuRoleManagerBusiness;

        $user_id = $user->id;
        $managerRoles = array();
        $menuConfigCurrent = array();
        if ($user_id != 1) {
            $managerRoles = self::getRolesManagerEventsTrails($params);
            $paramsCurrent = $params;
            $paramsCurrent['managerRoles'] = $managerRoles;
            $modulesCurrent = self::getModuleAllowEventsTrails($paramsCurrent);

            $menuCurrent = array();
            if ($managerRoles['roleManager'] == 'managerBusinessRole') {
                $menuCurrent = $menuRoleManagerBusiness;

            } else if ($managerRoles['roleManager'] == 'managerReceptionRole') {
                $menuCurrent = $menuRoleReceptionist;
            }

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

    public static function getRolesManagerEventsTrails($params)
    {

        $user = $params['user'];
        $user_id = $user->id;
        $actions = array();
        $roleManager = 'managerAdminTotal';
        $roles = array();
        if ($user_id != 1) {

            $actionsMenu = UsersHasRoles::getRolesActionsByUser($user_id);
            $actions = $actionsMenu;

            foreach ($actionsMenu as $value) {
                $role_id = $value->role_id;
                if (!in_array($role_id, $roles)) {
                    array_push($roles, $role_id);
                    if ($role_id == Role::ROL_BUSINESS) {
                        $managerBusinessRole = true;
                        $roleManager = 'managerBusinessRole';
                        break;
                    } else if ($role_id == Role::ROL_RECEPTIONIST) {
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

    public static function getModuleAllowEventsTrails($params)
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
                    'eventsTrailsTypeTeams',
                    'eventsTrailsRegistrationPoints',
                )
            ),


        );
        $result = $modules;


        return $result;


    }
}
