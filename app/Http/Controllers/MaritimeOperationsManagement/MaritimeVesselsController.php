<?php

namespace App\Http\Controllers\MaritimeOperationsManagement;

use App\Http\Controllers\MyBaseController;
use App\Models\Business;
use App\Models\MaritimeOperationsManagement\MaritimeDepartures;
use App\Models\MaritimeOperationsManagement\MaritimeVessels;
use App\Models\MaritimeOperationsManagement\MaritimeVesselTypes;
use App\Utils\DateIntervals;
use App\Utils\UtilHighcharts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class MaritimeVesselsController extends MyBaseController
{

    public function maritimeVesselsAdmin()
    {
        $dataPost = Request::all();
        $model = new MaritimeVessels();
        $result = $model->getAdmin($dataPost);
        $modelTypes=new MaritimeVesselTypes();
        if ($result["total"] > 0) {

            foreach ($result["rows"] as $key => $row) {

                $maritime_vessel_type_id = $row->maritime_vessel_type_id;
                $setPush = json_decode(json_encode($row), true);
                $result["rows"][$key] = $setPush;
                $result["rows"][$key]["documents"] = $modelTypes->getDocumentsByVesselType(["maritime_vessel_type_id" => $maritime_vessel_type_id]);

            }
        }
        return Response::json(
            $result
        );
    }

    public function saveMaritimeVesselApi()
    {
        $dataPost = Request::all();
        $model = new MaritimeVessels();
        $result = $model->saveMaritimeVesselApi($dataPost);

        return Response::json(
            $result
        );
    }

}
