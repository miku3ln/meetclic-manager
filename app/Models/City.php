<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Grimzy\LaravelMysqlSpatial\Eloquent\Traits\SpatialTrait;
use DB;

class City extends Model
{


    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
const OTAVALO_ID=1;
    protected $spatialFields = [
        'location',
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

    protected $fillable = array('name', 'latitude', 'longitude', 'province_id', 'status');

    public $timestamps = true;

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'taxes_by_cities', 'city_id', 'tax_id');
    }
    public function getListCities($params = [])
    {
        $province_id = isset($params['filters']['province_id']) ? $params['filters']['province_id'] : null;
        $status = isset($params['filters']['status']) ? $params['filters']['status'] : self::STATUS_ACTIVE;

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("status", '=', $status);
        if ($province_id) {
            $query->where("province_id", '=', $province_id);
        }

        $query->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
}
