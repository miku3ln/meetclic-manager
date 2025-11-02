<?php

namespace App\Http\Controllers\Mikrotik;
use App\Http\Controllers\MyBaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use App\Models\MikrotikManager\Mikrotik;
class MikrotikController extends MyBaseController
{


    public function getManagerEvents()
    {

        $renderView = "mikrotik.managerEvents.all";
        $modelMM = new \App\Utils\Mikrotik\MikrotickManager();
        $typeEventData = $modelMM->getEventsManager();
        $mikrotikData = $modelMM->mikrotiksManager;

        $paramsSend = [
            'managerViewData' => [
                'mikrotikData' => [
                    'typeEventData' => $typeEventData,
                    'mikrotikData' => $mikrotikData,

                ]
            ]
        ];
        $this->layout->content = View::make($renderView, $paramsSend);
    }


    public function getManagerEventResults()
    {
        $attributesPost = Request::all();

        $model = new  Mikrotik();
        $result = $model->getManagerEventResults($attributesPost);
        return Response::json($result);
    }

}
