<?php

namespace App\Models;
namespace App\Models\Gamification;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ModelManager;
class GamificationByProcessTracking extends ModelManager
{

    const STATE_PENDING= 'PENDING';
    const STATE_COMPLETED= 'COMPLETED';
    const STATE_CANCELLED= 'CANCELLED';
    const STATE_EXPIRED= 'EXPIRED';

    protected $table = 'gamification_by_process_tracking';
    const MAIN = 1;
    const NOT_MAIN = 0;

    const ENTITY_TYPE_CUSTOMER = 0;
    protected $fillable = array(
        'user_id ',
        'gamification_by_process_id',
        'status',
        'user_id',
        'assigned_at',
        'completed_at',

    );
    protected $attributesData = [
        ['column' => 'user_id ', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'gamification_by_process_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'status', 'type' => 'string', 'defaultValue' => 'COMPLETED', 'required' => 'true'],
        ['column' => 'assigned_at', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'true'],
        ['column' => 'completed_at', 'type' => 'string', 'defaultValue' => '2022-06-27', 'required' => 'true'],

    ];
    public $timestamps = false;
    protected $field_main = 'gamification_by_process_id';
    public static function getRulesModel()
    {
        $rules = [

            "user_id " => "required|numeric",
            "gamification_by_process_id" => "required|numeric",
            "status" => "required",
            "assigned_at" => "required",

            "user_id" => "required"
        ];
        return $rules;
    }


    /*MANAGER MAINS*/




}
