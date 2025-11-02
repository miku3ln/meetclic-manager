<?php

namespace App\Providers;

use App\Models\BusinessByEmployeeProfile;
use App\Models\Parameter;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\UsersHasRoles;
use App\Models\Business;

use App\Models\Action;
use Blade;
use Request;
use Auth;
use Ekko;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\HtmlString;

class MenuProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::directive('getMenu', function () {
            $menu = '';
            $user = Auth::user();
            $roles = $user->roles->pluck('id')->toArray();
            $menu = '  <li class="menu-title">Navigation</li>';
            $menuItems = self::getMenuCurrentManager($roles);
            $menu .= self::getStructureMenuCurrent($menuItems);
            $msg = 'Not is nothing';
            if ($user) {
                $user_id = $user->id;
                $msg = $user_id == 1 ? 'Is Admin Root' : "Is other";

            }
            return $menu;
        });
        Blade::directive('getMenuBusiness', function () {
            $url = Request::segments();

            $menu = '  <li class="menu-title">Navigation</li>';
            if (is_array($url)) {
                $id = isset($url[1]) ? $url[1] : null;

                $typeManager = isset($url[2]) ? $url[2] : null;

                if ($id) {
                    $user = Auth::user();
                    $modelBusiness = new Business();
                    $business = $modelBusiness->getBusinessByIdManager(array("id" => $id));
                    if ($business) {
                        $managerViewMain = self::getManagerViewMainBusiness(array(
                            'business' => $business,
                            'user' => $user,
                        ));
                        $modelDataManager = array('business' => $business);
                        $menuCurrentConfig = self::getMenuManagerBusiness(
                            array(
                                'managerViewMain' => $managerViewMain,
                                'business_id' => $id,
                                'user' => $user,
                                'dataManager' => $modelDataManager,
                                'typeManager' => $typeManager,

                            ));
                        $menuCurrent = $menuCurrentConfig['menu'];
                        $menuItems = self::getMenuFormat($menuCurrent);
                        $menu .= self::getStructureMenuCurrent($menuItems);
                    } else {
                        $menu = '  <li class="menu-title">No existe Business</li>';

                    }

                } else {
                    $menu = '  <li class="menu-title">Sin Id Business</li>';
                }


            } else {

            }

            return $menu;

        });
        Blade::if('featured', function () {
            $post = 'hgol';
            return "<?php echo  <div class='menu-init'>($post)</div> ?>";
        });

        view()->composer('layouts.masterMinton', function ($view) {

            $menuStringHtml = '';
            $user = Auth::user();
            if ($user) {


                $roles = $user->roles->pluck('id')->toArray();
                $menuStringHtml = '  <li class="menu-title">Navigation</li>';
                $menuItems = self::getMenuCurrentManager($roles);
                $menuStringHtml .= self::getStructureMenuCurrent($menuItems);
                $menuStringHtml = new HtmlString($menuStringHtml);
                $msg = 'Not is nothing';
                if ($user) {
                    $user_id = $user->id;
                    $msg = $user_id == 1 ? 'Is Admin Root' : "Is other";

                }
                $view->with('menuStringHtml', $menuStringHtml);
            }
        });
        view()->composer('layouts.business', function ($view) {

            $managerMenu = self::getMenuLoginAccount();
            $menuAccount = $managerMenu['menu'];
            $urlAvatar = $managerMenu['urlAvatar'];

            $resourcePathServer = $managerMenu['resourcePathServer'];

            $view->with('menuAccount', $menuAccount)->with('urlAvatar', $urlAvatar)->with('resourcePathServer', $resourcePathServer);

        });
        view()->composer('layouts.chasqui', function ($view) {

            $managerMenu = self::getMenuLoginAccount();
            $menuAccount = $managerMenu['menu'];
            $urlAvatar = $managerMenu['urlAvatar'];
            $resourcePathServer = $managerMenu['resourcePathServer'];

            $view->with('menuAccount', $menuAccount)->with('urlAvatar', $urlAvatar)->with('resourcePathServer', $resourcePathServer);

        });
        view()->composer('layouts.eventsTrailsBackend', function ($view) {

            $managerMenu = self::getMenuLoginAccount();
            $menuAccount = $managerMenu['menu'];
            $urlAvatar = $managerMenu['urlAvatar'];
            $resourcePathServer = $managerMenu['resourcePathServer'];

            $view->with('menuAccount', $menuAccount)->with('urlAvatar', $urlAvatar)->with('resourcePathServer', $resourcePathServer);

        });
        view()->composer('layouts.masterMinton', function ($view) {//layout main backend

            $managerMenu = self::getMenuLoginAccount();
            $menuAccount = $managerMenu['menu'];
            $urlAvatar = $managerMenu['urlAvatar'];
            $resourcePathServer = $managerMenu['resourcePathServer'];

            $view->with('menuAccount', $menuAccount)->with('urlAvatar', $urlAvatar)->with('resourcePathServer', $resourcePathServer);

        });

        view()->composer('layouts.minton.master-blank', function ($view) {

            $managerMenu = self::getMenuLoginAccount();
            $menuAccount = $managerMenu['menu'];
            $urlAvatar = $managerMenu['urlAvatar'];
            $resourcePathServer = $managerMenu['resourcePathServer'];
            $view->with('menuAccount', $menuAccount)->with('urlAvatar', $urlAvatar)->with('resourcePathServer', $resourcePathServer);

        });
    }

    public static function getMenuLoginAccount($type = 1)
    {
        $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
        if ($type == 1) {
            $themePath = $resourcePathServer . 'templates/cityBookHtml/';
        }
        $resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';

        $urlAvatar = $resourcePathServer . 'assets/images/users/avatar-1.jpg';
        $user = Auth::user();

        $menuCurrentItemsManagement = [];
        if ($user) {
            $roles = $user->roles;
            $modelFrontendManager = new  \App\Models\FrontendManagerData;
        }
        $menu = '';
        if ($user) {
            $providerCurrent = $user->provider;
            $avatar = $user->avatar;
            if ($providerCurrent == 'server' || $providerCurrent == null) {
                if (!$avatar) {

                    $urlAvatar = $resourcePathServer . 'assets/images/users/avatar-1.jpg';//BUSINESS-MANAGER-MENU-TOP
                } else {
                    $urlAvatar = $resourcePathServer . $avatar;

                }
            } else {
                if (!$avatar) {

                    $urlAvatar = $resourcePathServer . 'assets/images/users/avatar-1.jpg';
                } else {
                    $urlAvatar = $resourcePathServer . $avatar;

                }
            }
            $menuCurrentItemsManagement = [

                [
                    'actionName' => 'myProfile',
                    'routeName' => 'myProfile',
                    'icon' => 'remixicon-account-circle-line',
                    'text' => __('frontend.account.menu.profile'),
                    'url' => route('myProfile', app()->getLocale()),
                    'allowManager' => env("allowMenuTopProfile"),
                    'active' => false,
                ],
                [
                    'actionName' => 'business',
                    'routeName' => 'business',
                    'icon' => 'fa fa-building',
                    'text' => __('frontend.account.menu.my-business'),
                    'url' => route('business', app()->getLocale()),
                    'allowManager' => env("allowMenuLeftMyBusinessFrontEnd"),
                    'active' => false,
                ], [
                    'actionName' => 'listingsQueen',
                    'routeName' => 'listingsQueen',
                    'icon' => 'fas fa-briefcase',
                    'text' => __('frontend.account.menu.my-queens'),
                    'url' => route('listingsQueen', app()->getLocale()),
                    'allowManager' => env("allowMenuLeftBusinessFriendFrontEnd"),
                    'active' => false,
                ], [
                    'actionName' => 'reviewsTo',
                    'routeName' => 'reviewsTo',
                    'icon' => 'fas fa-address-card',
                    'text' => __('frontend.account.menu.reviews'),
                    'url' => route('listingsQueen', app()->getLocale()),
                    'allowManager' => env("allowMenuLeftMySuggestionFrontEnd"),
                    'active' => false,
                ],
            ];


            $menuCurrentItemsCurrent = [];
            if ($user) {
                if ($user->id != 1) {
                    foreach ($menuCurrentItemsManagement as $key => $menu) {
                        if ($menu["allowManager"]) {
                            $actionMenuCurrent = $menu['actionName'];
                            $actionAllowConfig = $modelFrontendManager->getAllowAction([
                                'roles' => $roles,
                                'needle' => $actionMenuCurrent,
                                'keyCompare' => 'link',
                            ]);
                            if ($actionAllowConfig) {
                                $menuCurrentItemsCurrent[] = $menu;
                            }
                        }

                    }
                } else {
                    $menuCurrentItemsCurrent = $menuCurrentItemsManagement;
                }
            }

            $menuConfig = '';
            foreach ($menuCurrentItemsCurrent as $key => $menu) {
                if ($menu["allowManager"]) {

                $menuConfig .= '<a href="' . $menu['url'] . '" class="dropdown-item notify-item">';
                $menuConfig .= '        <i class="' . $menu['icon'] . '"></i>';
                $menuConfig .= '        <span>' . $menu['text'] . '</span>';
                $menuConfig .= ' </a>';
                }


            }
            $menuConfig .= '<div class="dropdown-divider"></div>';
            $menuConfig .= '<a href="' . route('logout', app()->getLocale()) . '" class="dropdown-item notify-item">';
            $menuConfig .= '    <i class="remixicon-logout-box-line"></i>';
            $menuConfig .= '     <span> ' . __('frontend.buttons.logout') . ' </span>';
            $menuConfig .= '</a>';
            $menu = $menuConfig;

        }


        $result = [
            'menu' => $menu,
            'urlAvatar' => $urlAvatar,
            'resourcePathServer' => $resourcePathServer
        ];
        return $result;

    }


    public
    static function getStructureMenuCurrent($menuItems)
    {

        $result = "";
        $level = 0;
        $cont = 1;

        foreach ($menuItems as $currentAction) {

            $type_item = $currentAction["type_item"];
            $menu = '';
            $nextItems = "";
            $nameItem = $currentAction["name"];
            $link = $currentAction["link"];
            $activeClass = isset($currentAction['active']) ? $currentAction['active'] : false;
            $active_class = 'm-menu__item' . ($activeClass ? " m-menu__item-parent--active  mm-active active" : '');
            if ($type_item == 1) {
                $liParent = "    <li id='action_{$level}_{$cont}' class='{$active_class}' >
                                      <a href='javascript: void(0);' class='waves-effect'>
                                        <i class='{$currentAction["icon"]}'></i>
                                            <span class=''> {$currentAction["name"]}</span>
                                            <span class='menu-arrow'></span>
                                      </a>";
                $subItems = "";
                foreach ($currentAction["items"] as $item) {
                    $subLink = url($item['link']);
                    $subText = $item['name'];

                    $activeClass = isset($item['active']) ? $item['active'] : false;

                    $activeClassCurrent = $activeClass ? "active" : '';
                    $active_class = 'm-menu__item-children' . ($activeClass ? " m-menu__item-children--active " . $activeClassCurrent : '');

                    $subItems .= "<li id='action_{$level}_{$cont}' class='{$active_class}'>
                                     <a href='{$subLink}' class='m-menu__link {$activeClassCurrent}'>{$subText}
                                     </a>
                                   </li>";
                }
                $submenu = "      <ul class='nav-second-level' aria-expanded=\"false\">" . $subItems . "</ul>";
                $submenu .= " </li>";
                $liParent .= $submenu;
                $menu .= $liParent;
            } else {
                $link = url($link);

                $liParent = "    <li id='action_{$level}_{$cont}' class='{$active_class}' class='waves-effect'>
                                      <a href='$link' class='waves-effect'>
                                        <i class='{$currentAction["icon"]}'></i>
                                            <span > {$currentAction["name"]}</span>
                                      </a>
                                </li>";
                $menu .= $liParent;
            }
            $result .= $menu;
            $cont++;


        }


        return $result;

    }

    public
    static function getMenuCurrentManager($roles_id)
    {

        $level = 0;

        $actions = self::getActionsMenu($roles_id);
        $result = array();
        foreach ($actions as $action) {
            $setPush = array();
            $allowPush = false;
            if ($action->type_item == 1) {//has children
                $parent_id = $action->id;
                $itemsResult = self:: getItemsByParent(array("parent_id" => $parent_id, "roles_id" => $roles_id));

                $allowPush = $itemsResult["success"];
                if ($allowPush) {

                    $items = json_decode(json_encode($itemsResult["data"]), true);
                    foreach ($items as $keyItem => $item) {
                        $items[$keyItem] = $item;
                        $items[$keyItem]['active'] = false;

                    }
                    $setPush["items"] = $items;
                    $setPush["id"] = $action->id;
                    $setPush["name"] = $action->name;
                    $setPush["link"] = $action->link;
                    $setPush["parent_id"] = $action->parent_id;
                    $setPush["weight"] = $action->weight;
                    $setPush["icon"] = $action->icon;
                    $setPush["type"] = $action->type;
                    $setPush["description"] = $action->description;
                    $setPush["type_item"] = $action->type_item;
                    $setPush["active"] = false;


                }
            } else {
                $setPush = json_decode(json_encode($action), true);
                $setPush['active'] = false;
                $allowPush = true;
            }
            if ($allowPush) {
                array_push($result, $setPush);
            }
        }
        return $result;
    }

    public
    static function getActionsMenu($roles_id)
    {
        $types = array(Action::typeManager, Action::typeRoot);
        $sort = 'asc';
        $field = 'weight';
        $allActions = false;
        $query = DB::table("actions");
        $selectString = "actions.id,actions.name,actions.link,actions.parent_id,actions.weight,actions.icon,actions.type,actions.description,actions.type_item";
        $select = DB::raw($selectString);
        $query->select($select);
        if (is_array($roles_id)) {
            if (in_array(1, $roles_id)) {//IS ADMIN all
                $allActions = true;
            } else {//OTHER ROLE
                $allActions = false;
            }
        }


        if (!$allActions) {
            $query
                ->join('actions_by_role', 'actions.id', '=', 'actions_by_role.action_id')
                ->whereIn('actions_by_role.role_id', $roles_id);
        }
        $query->whereIn("actions.type", $types);
        $query->whereNull('actions.parent_id');
        $query->orderBy($field, $sort);
        $result = $query->get()->toArray();

        return $result;

    }

    public
    static function getItemsByParent($params)
    {
        $parent_id = $params["parent_id"];
        $roles_id = $params["roles_id"];
        $allActions = true;
        if (is_array($roles_id)) {
            if (in_array(1, $roles_id)) {//IS ADMIN all
                $allActions = true;
            } else {//OTHER ROLE
                $allActions = false;
            }
        }


        $types = array(Action::typeManager);
        $sort = 'asc';
        $field = 'weight';
        $query = DB::table("actions");
        $selectString = "actions.id,actions.name,actions.link,actions.parent_id,actions.weight,actions.icon,actions.type,actions.description,actions.type_item";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->whereIn("actions.type", $types);
        $query->orderBy($field, $sort);
        $query->where('actions.parent_id', '=', $parent_id);

        if (!$allActions) {
            $query
                ->join('actions_by_role', 'actions.id', '=', 'actions_by_role.action_id')
                ->whereIn('actions_by_role.role_id', $roles_id);
        }

        $data = $query->get()->toArray();
        $success = false;
        if ($query->count() > 0) {
            $success = true;
        }

        $result = array(
            "success" => $success,
            "data" => $data,
        );
        return $result;
    }

    public
    static function getUrlManager()
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


    public
    static function getManagerViewMainBusiness($params)
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

    public
    static function getModuleAllowSubcategory($params)//CPP-002
    {
        $managerRoles = $params['managerRoles'];
        $roleManager = $managerRoles['roleManager'];
        $modules = array(
            'information' => array(
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

        $business_subcategories_id = $params['business']->business_subcategories_id;
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
                        'humanResourcesOrganizationalChartArea',
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

    public
    static function getMenuFormat($menu)
    {
        $result = array();
        foreach ($menu as $key => $item) {
            $setPush = array();
            $title = $item['title'];
            $allow = $item['allow'];
            $active = $item['active'];
            $icon = $item['icon'];
            $isParent = $item['isParent'];

            if ($isParent) {
                $parentData = $item['parentData'];
                $itemsAll = array();
                foreach ($parentData as $keyData => $itemData) {
                    $urlCurrent = $itemData['urlCurrent'];
                    $setPushItems = array(
                        'type_item' => 0,
                        'active' => $itemData['active'],
                        'name' => $itemData['title'],
                        'icon' => isset($itemData['icon']) ? $itemData['icon'] : '',
                        'link' => $urlCurrent,

                    );
                    $itemsAll[] = $setPushItems;
                }

                $urlCurrent = isset($item['urlCurrent']) ? $item['urlCurrent'] : '';
                $setPush = array(
                    'type_item' => 1,
                    'active' => $active,
                    'name' => $title,
                    'icon' => $icon,
                    'link' => $urlCurrent,
                    'items' => $itemsAll,

                );
            } else {
                $urlCurrent = $item['urlCurrent'];
                $setPush = array(
                    'type_item' => 0,
                    'active' => $active,
                    'name' => $title,
                    'icon' => $icon,
                    'link' => $urlCurrent,

                );
            }
            $result[] = $setPush;
            /*   urlCurrent*/
        }

        return $result;

    }

    public
    static function getModulesBySubcategory($params)//CPP-001
    {
        $result = array();
        $managerViewMain = $params['managerViewMain'];
        $typeManager = $params['typeManager'];
        $user = $params['user'];


        $menuRoleReceptionist =
            array(
                'crm' => array(
                    'title' => 'CRM',
                    'allow' => true,
                    'active' => false,
                    'icon' => 'glyphicon glyphicon-copyright-mark',
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
                'housing' => array(
                    'title' => 'Hoteleria',
                    'allow' => true,
                    'active' => false,
                    'icon' => 'fa fa-building',
                    'isParent' => true,
                    'parentData' => array(
                        'lodgingStatisticalData' => array(
                            'title' => 'Reportes Estadisticos',
                            'allow' => true,
                            'active' => false,
                            'isParent' => false,
                            'link' => 'business/lodging/results'
                        ),
                        'lodging' => array(
                            'title' => 'Recepción',
                            'allow' => true,
                            'active' => false,
                            'isParent' => false,
                            'link' => 'business/lodging/adminBusiness'
                        ),
                    )
                ),

            );
        $menuRoleManagerBusiness = array(
            'information' => array(
                'title' => 'Informacion Empresa',
                'allow' => true,
                'active' => false,
                'icon' => 'fa  fa-building',
                'isParent' => false,
                'link' => 'managerBusiness'
            ),
            'products' => array(
                'title' => 'Productos',
                'allow' => true,
                'active' => false,
                'icon' => 'fa  fa-barcode',
                'isParent' => false,
                'link' => 'business/product'

            ),
            'schedules' => array(
                'title' => 'Horarios',
                'allow' => true,
                'active' => false,
                'icon' => 'fa  fa-clock-o',
                'isParent' => false,
                'link' => 'business/schedules'

            ),
            'gallery' => array(
                'title' => 'Galeria Empresa',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-camera',
                'isParent' => false,
                'link' => 'business/gallery/adminBusiness'

            ),
            'routes' => array(
                'title' => 'Chakiñanes',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-map-signs',
                'isParent' => false,
                'link' => 'business/gallery/adminBusiness'
            ),
            'panorama' => array(
                'title' => 'Galeria Chakiñanes',
                'allow' => true,
                'active' => false,
                'icon' => 'fa fa-picture-o',
                'isParent' => false,
                'link' => 'business/panorama/adminBusiness'
            ),
            'humanResources' => array(
                'title' => 'RRHH',
                'allow' => true,
                'active' => false,
                'icon' => 'fa  fa-sitemap',
                'isParent' => true,
                'parentData' => array(
                    'humanResourcesOrganizationalChartArea' => array(
                        'title' => 'Area',
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

            'crm' => array(
                'title' => 'CRM',
                'allow' => true,
                'active' => false,
                'icon' => 'glyphicon glyphicon-copyright-mark',
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
            ), 'askwer' => array(
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

                    'lodgingStatisticalData' => array(
                        'title' => 'Reportes Estadisticos',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/lodging/results'
                    ),

                    'lodging' => array(
                        'title' => 'Recepción',
                        'allow' => true,
                        'active' => false,
                        'isParent' => false,
                        'link' => 'business/lodging/adminBusiness'
                    ),
                )
            ),

        );
        $user_id = $user->id;
        $managerRoles = array();
        $menuConfigCurrent = array();
        if ($user_id != 1) {
            $managerRoles = self::getRolesManager($params);
            $paramsCurrent = $params;
            $paramsCurrent['managerRoles'] = $managerRoles;
            $modulesCurrent = self::getModuleAllowSubcategory($paramsCurrent);

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
                        $resultData = self::searchModules(array(
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
                    $setPush = self::searchModules(array(
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
        $menuConfigCurrent = self::searchModulesSetActive(array(
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

    public
    static function searchModules($params)
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

    public
    static function searchModulesSetActive($params)
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

    public
    static function getRolesManager($params)
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

    public
    static function getMenuConfigByRole($params)
    {
        $user = $params['user'];
        $dataManager = $params['dataManager'];
        $business = $dataManager['business'];
        $managerViewMain = $params['managerViewMain'];
        $typeManager = $params['typeManager'];
        $user_id = $user->id;
        $paramsManager = array(
            'business' => $business,
            'user' => $user,
            'managerViewMain' => $managerViewMain,
            'typeManager' => $typeManager,

        );
        $modulesManager = self::getModulesBySubcategory($paramsManager);
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
                        $searchResultConfig = self::searchInArray(array("haystack" => $haystack, "needle" => $needle, "keyCompare" => $keyCompare, "isObject" => true));
                        $searchResult = array();
                        if (!empty($searchResultConfig)) {
                            $searchResult = $searchResultConfig['value'];
                        }
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
                    $searchResult = self::searchInArray(array("haystack" => $haystack, "needle" => $needle, "keyCompare" => $keyCompare, "isObject" => true));

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
            $isParentManager = false;
            $allowModules = true;
            $configModules = array(
                'keyChildren' => 'lodging',
                'keyParent' => 'housing',

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

    public
    static function getMenuManagerBusiness($params)
    {
        $result = array();
        $business_id = $params['business_id'];
        $typeManagerCurrent = $params['typeManager'];
        $configModules = array();
        $isParentManager = false;
        $allowModules = false;

        $keyParentManagerActive = null;
        $keyChildrenManagerActive = null;
        $msg = 'Not Message';
        $menuConfigByRole = self::getMenuConfigByRole($params);
        $menuCurrent = $menuConfigByRole['menuCurrent'];
        foreach ($menuCurrent as $key => $menu) {
            $isParentCurrent = $menu['isParent'];
            if ($isParentCurrent) {
                $parentData = $menu['parentData'];
                foreach ($parentData as $keyChildren => $submenu) {
                    $typeManager = 'manager' . ucfirst($keyChildren);
                    $menuCurrent[$key]['parentData'][$keyChildren]['typeManager'] = $typeManager;
                    $urlCurrent = url('managerBusiness/' . $business_id . '/' . $typeManager);
                    $menuCurrent[$key]['parentData'][$keyChildren]['urlCurrent'] = $urlCurrent;

                }
            } else {
                $typeManager = 'manager' . ucfirst($key);
                $menuCurrent[$key]['typeManager'] = $typeManager;
                $urlCurrent = url('managerBusiness/' . $business_id . '/' . $typeManager);
                $menuCurrent[$key]['urlCurrent'] = $urlCurrent;

            }
        }

        if ($typeManagerCurrent) {
            $configModulesParent = self::searchInArray(array("haystack" => $menuCurrent, "needle" => $typeManagerCurrent, "keyCompare" => 'typeManager'));
            $searchParent = false;
            $searchChildren = false;
            $configModulesChildren = array();
            if (empty($configModulesParent)) {//Not parent has manager
                foreach ($menuCurrent as $key => $menu) {
                    $isParent = $menu['isParent'];
                    if ($isParent) {
                        $parentData = $menu['parentData'];
                        $searchManagerTypeChildren = self::searchInArray(array("haystack" => $parentData, "needle" => $typeManagerCurrent, "keyCompare" => 'typeManager'));

                        if (!empty($searchManagerTypeChildren)) {
                            $searchChildren = true;
                            $keyChildren = $searchManagerTypeChildren[0]['key'];
                            $configModulesChildren = array(
                                'keyParent' => $key,
                                'keyChildren' => $keyChildren,
                                'valueChildren' => $searchManagerTypeChildren[0]['value']
                            );
                            break;
                        }
                    }
                }
            } else {//parent manager
                $searchParent = true;
            }

            if ($searchParent || $searchChildren) {
//CHANGES ACTIVES TO PARENT AND CHILDREN
                $menuCurrent = self::resetMenuManager(array('menuCurrent' => $menuCurrent));

                $allowModules = true;
                if ($searchParent) {
                    $isParentManager = true;
                    $menuCurrent [$configModulesParent[0]['key']]['active'] = true;
                    $configModules = array(
                        'keyParent' => $configModulesParent[0]['key'],

                    );
                } else if ($searchChildren) {

                    $isParentManager = false;
                    $menuCurrent [$configModulesChildren['keyParent']]['active'] = true;
                    $menuCurrent [$configModulesChildren['keyParent']]['parentData'][$configModulesChildren['keyChildren']]['active'] = true;
                    $configModules = array(
                        'keyChildren' => $configModulesChildren['keyChildren'],
                        'keyParent' => $configModulesChildren['keyParent'],

                    );
                }

            } else if ($searchParent == false && $searchChildren == false) {
                $msg = 'not found managerType in parent not children';
                $allowModules = false;
            }
        } else {
            $isParentManager = $menuConfigByRole['isParentManager'];
            $configModules = $menuConfigByRole['configModules'];
            $allowModules = $menuConfigByRole['allowModules'];
        }
        $managerViewMain = $menuConfigByRole['managerViewMain'];
        $modulesAllow = array(
            'isParent' => $isParentManager,
            'config' => $configModules,
            'allow' => $allowModules,
            'msg' => $msg
        );
        $success = false;
        $result = array(
            'menu' => $menuCurrent,
            'configModulesAllow' => $modulesAllow,
            'success' => $success,
            'managerViewMain' => $managerViewMain

        );
        return $result;
    }

    public
    static function getModulesInit($params)
    {
        $result = array();
        return $result;
    }

    public
    static function resetMenuManager($params)
    {
        $menuCurrent = $params['menuCurrent'];
        foreach ($menuCurrent as $key => $menu) {
            $isParentCurrent = $menu['isParent'];

            if ($isParentCurrent) {
                $menuCurrent[$key]['active'] = false;
                $parentData = $menu['parentData'];
                foreach ($parentData as $keyChildren => $submenu) {

                    $menuCurrent[$key]['parentData'][$keyChildren]['active'] = false;

                }
            } else {

                $menuCurrent[$key]['active'] = false;


            }
        }
        return $menuCurrent;
    }

    public
    static function SortByKeyValue($data, $sortKey, $sort_flags = SORT_ASC)
    {
        if (empty($data) or empty($sortKey)) return $data;

        $ordered = array();
        foreach ($data as $key => $value)
            $ordered[$value[$sortKey]] = $value;

        ksort($ordered, $sort_flags);

        return array_values($ordered); // array_values() added for identical result with multisort*
    }

    public
    function getFormatArraySelect($arrayDataTypeModel, $arrayConfig = array("key" => "id", "text" => array("name")))
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

    public
    static function searchInArray($params)
    {
        $needle = $params["needle"];
        $haystack = $params["haystack"];
        $keyCompare = $params["keyCompare"];
        $isObject = isset($params["isObject"]) ? $params["isObject"] : false;

        $result = array();

        foreach ($haystack as $key => $value) {

            if (!$isObject) {

                if (isset($value[$keyCompare])) {
                    if ($value[$keyCompare] == $needle) {
                        array_push($result, array('value' => $value, 'key' => $key));
                    }
                } else {
                    break;
                }

            } else {
                if ($value->$keyCompare == $needle) {

                    array_push($result, array('value' => $value, 'key' => $key));

                }
            }
        }
        return $result;
    }
}
