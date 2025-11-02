<?php

namespace App\Http\Controllers\Routes;

use App\Http\Controllers\MyBaseController;
use App\Models\BusinessByRoutesMap;
use App\Models\RoutesMap;
use App\Models\RoutesMapByRoutesDrawing;
use App\Models\RoutesDrawing;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\Multimedia;

class RoutesMapByRoutesDrawingController extends MyBaseController
{
    public function getListSelect2()
    {
        $data =Request::all();
        $tbl = "routes_map_by_routes_drawing";

        $query = DB::table($tbl)
            ->select(
                DB::raw("routes_map_by_routes_drawing.id "),
                DB::raw("CONCAT(routes_drawing.name,'-',routes_drawing.description ) as text ,(routes_drawing.name) as label")
            )
            ->join('routes_drawing', $tbl . '.routes_drawing_id', '=', 'routes_drawing.id')
            ->join('routes_map', $tbl . '.routes_map_id', '=', 'routes_map.id')
            ->join('business_by_routes_map', 'routes_map.id', '=', 'business_by_routes_map.routes_map_id');
        $query->where("routes_drawing.type", "=", 0);
        $business_id = $data['filters']['business_id'];
        $query->where("business_by_routes_map.business_id", "=", $business_id);


        if (isset($data['filters']['search_value']['term']) && !empty($data['filters']['search_value']['term'])) {

            $query->where('routes_drawing.name', 'like', '%' . $data['filters']['search_value']['term'] . '%');
        }
        $query->limit(10)->orderBy('routes_drawing.name', 'asc');
        $result = $query->get()->toArray();

        return Response::json(
            $result
        );
    }

}
