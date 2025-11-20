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

        // Alias para que no haya ambigüedad
        $table = $this->table; // routes_map_by_routes_drawing
        $query = DB::table($table . ' as rmbrd');

        // Mapeo de type numérico a string (marker, polygon, etc.)
        $comparate = "IF(rd.type=0,'marker',
                    IF(rd.type=1,'polygon',
                    IF(rd.type=2,'rectangle',
                    IF(rd.type=3,'circle',
                    IF(rd.type=4,'polyline',2))))) as rd_type";

        $selectString = "
        rmbrd.id,
        rmbrd.routes_drawing_id,
        rmbrd.routes_map_id,
        rd.id as rd_id,
        $comparate,
        rd.name as rd_name,
        rd.subtitle as rd_subtitle,
        rd.src as rd_src,
        rd.src_glb as rd_src_glb,
        rd.description as rd_description,
        rd.options_type as rd_options_type,
        rd.totem_subcategory_id,

        -- Subcategoría (puede ser NULL)
        rts.id   as totem_subcategory_real_id,
        rts.code as totem_subcategory_code,
        rts.name as totem_subcategory_name,

        -- Categoría (puede ser NULL si no hay subcategoría)
        rtc.id   as totem_category_id,
        rtc.code as totem_category_code,
        rtc.name as totem_category_name
    ";

        $select = DB::raw($selectString);
        $query->select($select);

        // JOIN principal: siempre debe existir el drawing
        $query->join('routes_drawing as rd', 'rmbrd.routes_drawing_id', '=', 'rd.id');

        // LEFT JOIN: si no hay subcategoría, igual devuelve el drawing con NULL
        $query->leftJoin('routes_totem_subcategories as rts', 'rd.totem_subcategory_id', '=', 'rts.id');

        // LEFT JOIN: si no hay categoría asociada (o no hay subcat), sigue devolviendo NULL
        $query->leftJoin('routes_totem_categories as rtc', 'rts.category_id', '=', 'rtc.id');

        // Filtro por ruta
        $query->where('rmbrd.routes_map_id', '=', $routes_map_id);

        $data = $query->get()->toArray();

        return $data;
    }



}
