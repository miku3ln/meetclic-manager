<?php

namespace App\Http\Controllers\Housing;

use App\Http\Controllers\MyBaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\Models\LodgingByTypeOfRoom;
class LodgingByTypeOfRoomController extends MyBaseController
{
    public function saveRoomsLodging()
    {

        $attributesPost =Request::all();
        $model = new LodgingByTypeOfRoom();
        $result = $model->saveData(array("attributesPost"=>$attributesPost));
        return Response::json($result);
    }

}
