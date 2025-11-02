<?php
/**
 * Created by PhpStorm.
 * User: alexi5h
 * Date: 27/2/2018
 * Time: 16:07
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AllowedAction extends Model
{
    protected $table = 'allowed_actions';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }
}