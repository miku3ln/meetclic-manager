<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoutesMapByRoutesDrawing extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'routes_map_by_routes_drawing';

    protected $fillable = array('routes_map_id', 'routes_drawing_id','id');

    public $timestamps = false;


    public function getRoutesDrawing($params)
    {

        $routes_map_id = $params["routes_map_id"];
        $query = DB::table($this->table);
        $comparate = "IF(routes_drawing.type=0,'marker',IF(routes_drawing.type=1,'polygon',IF(routes_drawing.type=2,'rectangle',IF(routes_drawing.type=3,'circle',IF(routes_drawing.type=4,'polyline',2))))) as rd_type";
        $selectString = "$this->table.id ,$this->table.routes_drawing_id,$this->table.routes_map_id
        ,routes_drawing.id rd_id,$comparate,routes_drawing.name rd_name,routes_drawing.subtitle rd_subtitle,routes_drawing.src rd_src,routes_drawing.src_glb rd_src_glb,routes_drawing.description rd_description,routes_drawing.options_type rd_options_type";
        $select = DB::raw($selectString);
        $query->select($select);
        $query->join('routes_drawing', "$this->table.routes_drawing_id", '=', 'routes_drawing.id');

        $query->where("routes_map_id", '=', $routes_map_id);

        $data = $query->get()->toArray();

        return $data;
    }


}
