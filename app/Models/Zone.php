<?php

namespace App\Models;

//use Grimzy\LaravelMysqlSpatial\Eloquent\Traits\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use DB;

class Zone extends Model
{

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    const SAN_LUIS_ID = 5;
    protected $spatialFields = [
        'polygon_spatial',
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'zones';

    protected $fillable = array('name', 'city_id', 'color', 'zip_code', 'poligon_coordinates', 'status');

    public $timestamps = true;

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getListZones($params = [])
    {
        $province_id = isset($params['filters']['city_id']) ? $params['filters']['city_id'] : null;
        $status = isset($params['filters']['status']) ? $params['filters']['status'] : self::STATUS_ACTIVE;

        $query = DB::table($this->table);
        $selectString = "$this->table.id ,$this->table.name";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->where("status", '=', $status);
        if ($province_id) {
            $query->where("city_id", '=', $province_id);
        }

        $query->orderBy($this->table . '.name', 'asc');
        $result = $query->get()->toArray();
        return $result;
    }
}
