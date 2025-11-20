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

    public function getRoutesDrawingGroupedBySubcategory($params)
    {
        // 1) Obtener la data cruda
        $rows =$params["rows"];

        $grouped = array();

        foreach ($rows as $row) {
            // Si no tiene subcategoría, lo puedes mandar a 0 o dejar null.
            // Aquí uso 0 como "Sin clasificar".
            $sid = isset($row->totem_subcategory_id) ? intval($row->totem_subcategory_id) : 0;

            if (!isset($grouped[$sid])) {
                $grouped[$sid] = array(
                    'totem_subcategory_id'   => $sid,
                    'totem_category_id'      => isset($row->totem_category_id) ? intval($row->totem_category_id) : null,
                    'totem_category_code'    => isset($row->totem_category_code) ? $row->totem_category_code : null,
                    'totem_category_name'    => isset($row->totem_category_name) ? $row->totem_category_name : null,
                    'totem_subcategory_code' => isset($row->totem_subcategory_code) ? $row->totem_subcategory_code : null,
                    'totem_subcategory_name' => isset($row->totem_subcategory_name) ? $row->totem_subcategory_name : null,
                    'count'                  => 0,
                    'data'                   => array() // aquí van los items de esa subcategoría
                );
            }

            // Incrementar contador
            $grouped[$sid]['count']++;

            // Agregar el row original a la lista "data"
            $grouped[$sid]['data'][] = $row;
        }

        return $grouped;
    }

    public function getRoutesDrawingStatsHtml($params)
    {
        // 1) Rows viene desde fuera
        $grouped = $params['grouped'];
        $html  = '<div class="company-panel__section company-panel__section--stats">';
        $html .= '<div class="stats company-panel__stats">';

        foreach ($grouped as $sid => $group) {

            $totemSubcategoryId   = isset($group['totem_subcategory_id']) ? intval($group['totem_subcategory_id']) : 0;
            $totemCategoryId      = isset($group['totem_category_id']) ? intval($group['totem_category_id']) : 0;
            $totemCategoryCode    = isset($group['totem_category_code']) ? $group['totem_category_code'] : '';
            $totemCategoryName    = isset($group['totem_category_name']) ? $group['totem_category_name'] : '';
            $totemSubcategoryCode = isset($group['totem_subcategory_code']) ? $group['totem_subcategory_code'] : '';
            $totemSubcategoryName = isset($group['totem_subcategory_name']) ? $group['totem_subcategory_name'] : '';
            $count                = isset($group['count']) ? intval($group['count']) : 0;

            // Label visible
            // Ej: "Tótems Educativos – Cosmovisión andina – Apus"
            $labelParts = array();

            if ($totemCategoryName !== '') {
                $labelParts[] = $totemCategoryName;
            }
            if ($totemSubcategoryName !== '') {
                $labelParts[] = $totemSubcategoryName;
            }

            $labelText = 'Tótems';
            if (!empty($labelParts)) {
                $labelText .= ' ' . implode(' – ', $labelParts);
            }

            // ID para el <span> count
            $statId = 'statSubcategory' . $totemSubcategoryId;

            // params: JSON de todo el grupo (incluye data y count)
            $paramsJson = htmlspecialchars(json_encode($group), ENT_QUOTES, 'UTF-8');

            // 4) Construimos el bloque stat
            $html .= '<div class="stat company-panel__stat"'
                . ' data-key="' . $totemSubcategoryId . '"'
                . ' data-count="' . $count . '"'
                . ' data-params="' . $paramsJson . '"'
                . ' data-totem_category_code="' . htmlspecialchars($totemCategoryCode, ENT_QUOTES, 'UTF-8') . '"'
                . ' data-totem_category_id="' . $totemCategoryId . '"'
                . ' data-totem_category_name="' . htmlspecialchars($totemCategoryName, ENT_QUOTES, 'UTF-8') . '"'
                . ' data-totem_subcategory_code="' . htmlspecialchars($totemSubcategoryCode, ENT_QUOTES, 'UTF-8') . '"'
                . ' data-totem_subcategory_id="' . $totemSubcategoryId . '"'
                . ' data-totem_subcategory_name="' . htmlspecialchars($totemSubcategoryName, ENT_QUOTES, 'UTF-8') . '"'
                . '>';

            $html .= '<span class="stat__label company-panel__stat-label">'
                . htmlspecialchars($labelText, ENT_QUOTES, 'UTF-8')
                . '</span>';

            $html .= '<span class="stat__value company-panel__stat-value" id="' . $statId . '">'
                . $count
                . '</span>';

            $html .= '</div>';
        }

        $html .= '</div>'; // .company-panel__stats
        $html .= '</div>'; // .company-panel__section

        return $html;
    }

}
