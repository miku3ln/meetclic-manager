<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoutesDrawing extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    const typeMarker = 0;
    const typePolygon = 1;
    const typeRectangle = 2;
    const typeCircle = 3;
    const typePolyline = 4;
    const typeManagerMarker = "marker";
    const typeManagerPolygon = "polygon";
    const typeManagerRectangle = "rectangle";
    const typeManagerCircle = "circle";
    const typeManagerPolyline = "polyline";
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'routes_drawing';

    protected $fillable = array('type', 'name', 'description', 'options_type','subtitle','src','src_glb','totem_subcategory_id');

    public $timestamps = false;

    public function routesMapByRoutes()
    {
        return $this->belongsTo(RoutesMapByRoutesDrawing::class, 'routes_map_id','routes_drawing_id');
    }
    public function totemSubcategory()
    {
        return $this->belongsTo(RoutesMapByRoutesDrawing::class, 'totem_subcategory_id');
    }
}
