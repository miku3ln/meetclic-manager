<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    const IMBABURA_ID=15;
    protected $table = 'provinces';

    protected $fillable = array('name', 'country_id', 'status');

    public $timestamps = true;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function getListStatesProvinces($params = [])
    {
        $country_id = isset($params['filters']['country_id']) ? $params['filters']['country_id'] : null;
        $status = isset($params['filters']['status']) ? $params['filters']['status'] : self::STATUS_ACTIVE;

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("status", '=', $status);
        if ($country_id) {
            $query->where("country_id", '=', $country_id);
        }

        $query->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
}
