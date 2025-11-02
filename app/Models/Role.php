<?php

namespace App\Models;

//use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\UsersHasRoles;
use Auth;
use Ekko;

use Illuminate\Support\Facades\DB;

class Role extends Model
{
//    use ModelEventLogger;
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /*   CONFIG ROLES SING UP*/
    const ROL_SUPERADMIN = 1;
    const ROL_BUSINESS = 2;
    const ROL_BUSINESS_MANAGER = 'Business';
    const ROL_RECEPTIONIST = 5;
    const ROL_RECEPTIONIST_MANAGER = 'Receptionist';
    const ROL_EMPLOYER = 3;
    const ROL_EMPLOYER_MANAGER = 'Employer';

    const ROL_CUSTOMER = 4;
    const ROL_CUSTOMER_MANAGER = 'Customer';

    const VIEW_BUSINESS = "/business/manager";
    const VIEW_CUSTOMER = "/customer/manager";

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';
    /*
     * primary key used by the model
     */
    protected $primaryKey = 'id';
    /*
     * this parameter add or remove timestamps columns depending its status
     */
    public $timestamps = true;

    protected $fillable = array('name', 'status');
    public static $status_list = array("ACTIVE" => 'Activo', "INACTIVE" => 'Inactivo');

    /*
     * RELATIONSHIPS
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_has_roles', 'role_id', 'user_id');
    }

    public function actions()
    {

        //If its superuser
        if ($this->id === 1) {
            return Action::query();
        } //Rest of roles
        else {
            return $this->belongsToMany(Action::class, 'actions_by_role', 'role_id', 'action_id');
        }
    }

    public function getItemsByParent($params)
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

    public function getMenuCurrent($roles_id)
    {

        $level = 0;
        //$environment = Parameter::where('name', '=', 'environment')->first()->value;
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
                    $setPush = json_decode(json_encode($action), true);
                    $setPush["items"] = $itemsResult["data"];

                }
            } else {
                $setPush = json_decode(json_encode($action), true);
                $allowPush = true;
            }
            if ($allowPush) {
                array_push($result, $setPush);
            }
        }
        return $result;
    }

    public function getStructureMenuCurrent($roles_id)
    {
        $menuItems = self::getMenuCurrent($roles_id);
       // $environment = Parameter::where('name', '=', 'environment')->first()->value;
        $result = "";
        $level = 0;
        $cont = 1;
        foreach ($menuItems as $currentAction) {

            $link = $currentAction["link"];
            $type_item = $currentAction["type_item"];
            $menu = '';
            $nextItems = "";
            $nameItem = $currentAction["name"];
            $link = $currentAction["link"];
            $activeClass = Ekko::isActiveURL($link);


            $active_class = 'm-menu__item' . ($activeClass ? " m-menu__item--{$activeClass}" : '');

            if ($type_item == 1) {
                $liParent = "    <li id='action_{$level}_{$cont}' class='{$active_class} type_item_1' aria-haspopup='true' data-menu-submenu-toggle='hover'>
                                      <a href='#' class='m-menu__link m-menu__toggle'>
                                        <i class='m-menu__link-icon {$currentAction["icon"]}'></i>
                                            <span class='m-menu__link-text'> {$currentAction["name"]}</span>
                                            <span class='m-menu__ver-arrow la la-angle-right'></span>
                                      </a>";
                $subItems = "";
                foreach ($currentAction["items"] as $item) {
                    $subLink = url($item->link);
                    $subText = $item->name;

                    $activeClass = Ekko::isActiveURL($subLink);


                    $active_class = 'm-menu__item' . ($activeClass ? " m-menu__item--{$activeClass}" : '');
                    $subItems .= "<li id='action_{$level}_{$cont}' class='{$active_class}'  aria-haspopup='true'>
                                     <a href='{$subLink}' class='m-menu__link'>
                                     <i class='m-menu__link-bullet m-menu__link-bullet--dot'>
                                       <span></span>
                                     </i>
                                     <span class='m-menu__link-text'>{$subText}</span>
                                     </a>
                                   </li>";
                }

                $submenu = "    <div class='m-menu__submenu'>
                                      <span class='m-menu__arrow'></span>
                                      <ul class='m-menu__subnav'>" . $subItems . "</ul>
                                 </div>";
                $submenu .= "   </li>";
                $liParent .= $submenu;
                $menu .= $liParent;
            } else {
                $link = url($link);

                $liParent = "    <li id='action_{$level}_{$cont}' class='{$active_class}' aria-haspopup='true' data-menu-submenu-toggle='hover'>
                                      <a href='$link' class='m-menu__link m-menu__toggle'>
                                        <i class='m-menu__link-icon {$currentAction["icon"]}'></i>
                                            <span class='m-menu__link-text'> {$currentAction["name"]}</span>
                                      </a>";
                $menu .= $liParent;
            }
            $result .= $menu;
            $cont++;


        }


        return $result;

    }

    public function getActionsByRoles($params)
    {
        $rolesId = $params['rolesId'];
        $query = DB::table("actions");
        $selectString = "actions.id,actions.name,actions.link,actions.parent_id,actions.weight,actions.icon,actions.type,actions.description,actions.type_item";
        $select = DB::raw($selectString);
        $query->select($select);
        $query
            ->join('actions_by_role', 'actions.id', '=', 'actions_by_role.action_id')
            ->whereIn('actions_by_role.role_id', $rolesId);
        return $query->get()->toArray();
    }

    public function getActionsMenu($roles_id)
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

    public function get_menu($option = null, $roles_id = null, $level = 0)
    {
        $result = '';
        /*
        $environment = Parameter::where('name', '=', 'environment')->first()->value;
        //get actions by role

        $this_level_items = self::get_action_by_role($option, $roles_id);

        $level++;
        $cont = 1;
        $result = '';
        if ($this_level_items !== false) {//if exist this level
            foreach ($this_level_items as $currentAction) {
                if ($environment === 'staging') {

                    $link = $currentAction->link;
                    if ($link !== '#') {
                        $link = url($currentAction->link);
                    }


                    $activeClass = Ekko::isActiveURL($link);


                    $active_class = 'm-menu__item' . ($activeClass ? " m-menu__item--{$activeClass}" : '');

                    //Get the submenu
                    $next = $this->get_menu($currentAction->id, $roles_id, $level);
                    $submenu = '';
                    if ($next != '') {
                        $parent_pop_up = "<li class='m-menu__item  m-menu__item--parent next-allow' aria-haspopup='true'><a href='#' class='m-menu__link'>
                            <span class='m-menu__link-text'>$currentAction->name</span></a></li>";

                        $submenu = "<div class='m-menu__submenu'>
                    <span class='m-menu__arrow'></span><ul class='m-menu__subnav'>" . $parent_pop_up . $next . "</ul></div>";
                    }

                    //First level menu item
                    if ($level === 1) {

                        //Check if the submenu is not empty
                        if ($submenu) {

                            $result .= "<li id='action_{$level}_{$cont}' class='{$active_class} level-1-submenu' aria-haspopup='true'
                                data-menu-submenu-toggle='hover' ><a href='{$link}' class='m-menu__link m-menu__toggle'>
                                <i class='m-menu__link-icon {$currentAction->icon}'></i><span class='m-menu__link-text'>
                                {$currentAction->name}</span><span class='m-menu__ver-arrow la la-angle-right'></span></a>";
                        }

                    } //Submenu item
                    else {
                        $result .= "<li id='action_{$level}_{$cont}' class='{$active_class} level-1-submenu-else'  aria-haspopup='true'>
                            <a href='{$link}' class='m-menu__link'><i class='m-menu__link-bullet m-menu__link-bullet--dot'>
                            <span></span></i><span class='m-menu__link-text'>{$currentAction->name}</span></a>";
                    }

                    //Add the submenu
                    $result .= $submenu;

                    $result .= "</li>";
                    $cont++;
                }

            }
        } else {
            return $result;
        }
*/
        return $result;
    }


    /*
     * get actions by logged role
     */
    public function get_action_by_role($parent_id, $roles_id)
    {
        $types = array(Action::typeManager, Action::typeRoot);

        // role by id
        //get relationship actions
        if (is_array($roles_id)) {//Init 1
            if (in_array(1, $roles_id)) {//IS ADMIN
                $actions = Action::query();

            } else {//OTHER ROLE
                $actions = Action::select('actions.*')
                    ->join('actions_by_role', 'actions.id', '=', 'actions_by_role.action_id')
                    ->whereIn('actions_by_role.role_id', $roles_id);
            }
        } else {
            $role = Role::find($roles_id);
            $actions = $role->actions();
        }

        if ($parent_id) {//PARENT BY ACTIONS
            $actions = $actions->where('actions.parent_id', '=', $parent_id)
                ->whereIn("actions.type", $types)
                ->orderBy("actions.weight", 'ASC')->distinct('actions.id')->get();
        } elseif ($parent_id === null) {//Init METHOD


            $actions = $actions->where('actions.parent_id', '=', null)
                ->whereIn("actions.type", $types)
                ->orderBy("actions.weight", 'ASC')->distinct('actions.id')->get();
        } else {
            $actions = $actions->distinct('actions.id')->get();
        }
        //result
        if ($actions->count() > 0) {
            return $actions;
        } else {
            return false;
        }
    }

    public static function get_actions($parent_id)
    {

        $actions = Action::select('id', 'name', "link", 'parent_id', 'weight', 'icon',"type",'description','type_item')->where('parent_id', '=',
            $parent_id)->orderBy("actions.weight", 'ASC')->get()->toArray();

        for ($i = 0; $i < count($actions); $i++) {
            $helper = new Role();
            $son_actions = $helper->get_actions($actions[$i]['id']);
            $actions[$i]['son_actions'] = $son_actions;
        }

        return $actions;
    }

    public static function getInitView($roles)
    {

        $view = "/home222222";

        foreach ($roles as $role) {
            if ($role->role_id == self::ROL_BUSINESS) {
                $view = self::VIEW_BUSINESS;
            } else if ($role->role_id == self::ROL_CUSTOMER) {
                $view = self::VIEW_CUSTOMER;
            }
        }

        return $view;
    }


    public static function getUrlCurrentUser()
    {
        $hasRolesUser = new UsersHasRoles();
        $role = new Role();
        $user = Auth::user();
        $modelUtil = new \App\Utils\UtilUser();
        $redirectPage = $modelUtil->getUrlUser($user);
        $redirectTo = $redirectPage;
        return $redirectTo;
    }

    public static function getActionsCurrent($parent_id, $roles_id)
    {


        // role by id
        //get relationship actions
        if (is_array($roles_id)) {//Init 1
            if (in_array(1, $roles_id)) {
                $actions = Action::query();

            } else {
                $actions = Action::select('actions.*')
                    ->join('actions_by_role', 'actions.id', '=', 'actions_by_role.action_id')
                    ->whereIn('actions_by_role.role_id', $roles_id);
            }
        } else {

            $role = Role::find($roles_id);
            $actions = $role->actions();

        }
        //control to parent actions
        if ($parent_id) {
            $actions = $actions->where('actions.parent_id', '=', $parent_id)
                ->orderBy("actions.weight", 'ASC')->distinct('actions.id')->get();
        } elseif ($parent_id === null) {//Init 2
            if (is_array($roles_id)) {
                $actions = Action::select('actions.*')
                    ->join('actions_by_role', 'actions.id', '=', 'actions_by_role.action_id')
                    ->whereIn('actions_by_role.role_id', $roles_id)->get();
            } else {
                $actions = Action::select('actions.*')
                    ->join('actions_by_role', 'actions.id', '=', 'actions_by_role.action_id')
                    ->whereIn('actions_by_role.role_id', [$roles_id])->get();
            }
        } else {
            $actions = $actions->distinct('actions.id')->get();
        }
        //result
        if ($actions->count() > 0) {
            return $actions;
        } else {
            return false;
        }
    }


    public static function getListAll($params)
    {

        $query = Role::query()->select('id', 'name as text');

        if (isset($params['id']) && !empty($params['id'])) {
            $query->where('id', '=', $params['id']);
        }
        if (isset($params['filters']['search_value']['term']) && !empty($params['filters']['search_value']['term'])) {
            $query->orWhere('name', 'like', '%' . $params['filters']['search_value']['term'] . '%');
        }
        $query->where('status', '=', self::STATUS_ACTIVE);
        $query->where('id', '!=', self::ROL_SUPERADMIN);
        $query->limit(10)->orderBy('name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
}
