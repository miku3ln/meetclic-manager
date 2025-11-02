<?php

namespace App\Models;

//use App\Traits\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

class UsersHasRoles extends Model
{

    protected $table = 'users_has_roles';
    /*
     * primary key used by the model
     */
    protected $primaryKey = 'id';

    protected $fillable = array('user_id', 'role_id');
    public $timestamps = false;
    public static function getRolesUser($userId)
    {
        $result = array();
        $table="users_has_roles";
        $selectString=$table.".user_id,$table.role_id";
        $select = DB::raw($selectString);
        $query = DB::table($table);
        $rolesUser =$query->select($select)
            ->where('user_id', '=',
            $userId)->get()->toArray();
        return $rolesUser;
    }
    //STEP MENU 3

    public static function getRolesActionsByUser($userId)
    {
        $result = array();
        $table="users_has_roles";
        $selectString=$table.".user_id,$table.role_id,actions.link,actions.parent_id,actions.icon,actions.weight";
        $select = DB::raw($selectString);
        $query = DB::table($table);
        $rolesUser =$query->select($select)
            ->join("actions_by_role",$table.".role_id","=","actions_by_role.role_id")
            ->join("actions","actions_by_role.action_id","=","actions.id")
            ->where('user_id', '=',
                $userId)->get()->toArray();
        return $rolesUser;
    }
}
