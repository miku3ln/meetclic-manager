<?php

namespace App\Http\Controllers\MaritimeOperationsManagement;

use App\Http\Controllers\MyBaseController;
use App\Models\MaritimeOperationsManagement\MaritimeDepartures;
use App\Utils\DateIntervals;
use App\Utils\UtilHighcharts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class MaritimeDeparturesController extends MyBaseController
{

    public function adminMaritimeDepartures()
    {
        $dataPost = Request::all();
        $model = new MaritimeDepartures();
        $result = $model->getAdmin($dataPost);
        $total = $result["total"];
        if ($total > 0) {
            foreach ($result['rows'] as $key => $row) {
                $id = $row->id;
                $result['rows'][$key] = (array)$row;

                $details = $model->getByDetailsMaritime(["departureId" => $id]);
                $result['rows'][$key]['details'] = $details;

            }
        }


        return Response::json(
            $result
        );
    }

    public function maritimeDeparturesSave()
    {

        $attributesPost = Request::all();
        $model = new MaritimeDepartures();

        $result = $model->saveMaritimeDepartureApi($attributesPost);
        return Response::json($result);
    }

    public function maritimeDeparturesReports()
    {
        $model = new MaritimeDepartures();

        $attributesPost = Request::all();
        $date_from = $attributesPost["date_from"] . ' 00:00:00';

        $date_to = "";

        $tz = 'America/Guayaquil';

        $dateToInput = $attributesPost['date_to']; // 'YYYY-MM-DD'
        $today = Carbon::now($tz)->toDateString(); // 'YYYY-MM-DD'

        if ($dateToInput === $today) {
            // Si es hoy → usar hora actual
            $date_to = Carbon::now($tz)->toDateTimeString(); // 'YYYY-MM-DD HH:MM:SS'
        } else {
            // Si es pasado → cerrar el día completo
            $date_to = $dateToInput . ' 23:59:59';
        }

        $resultTypes = $model->getDeparturesCustomersResumeByType(
            [
                'business_id' => 1,
                'date_from' => '2025-01-01 00:00:00',
                'date_to' => $date_to]
        );


        $intervalPack = DateIntervals::build(
            $date_from,
            $date_to
        );
        $success = count($resultTypes) > 0;
        $summary = UtilHighcharts::groupCount($resultTypes, [
            'groupKey' => 'type',
            'labelKey' => 'type',
            'totalKey' => 'total',
            'parentKey' => 'companyName',     // toma companyName del primer item del grupo
            'parentOutKey' => 'companyName',
            'extras' => [
                'companyId' => 'companyId',
            ],
        ]);
        $dataInterval = UtilHighcharts::groupCountByIntervals(
            $resultTypes,          // tu data cruda
            $intervalPack,         // haystack
            [
                'dateKey' => 'created_at',
                'dataKeyByGroup' => 'companyName',
                'extras' => ['companyId', 'companyName'],
                'totalKey' => 'total',
                'tz' => 'America/Guayaquil',
                'fillEmpty' => true, // para que meses sin registros salgan en 0
            ]
        );

        $dataIntervalCompany = UtilHighcharts::groupCountByIntervals(
            $resultTypes,
            $intervalPack,
            [
                'dateKey' => 'created_at',
                'dataKeyByGroup' => 'companyName',   // 👈 series
                'groupOutKey' => 'companyName',      // alias (opcional)

                'extras' => [
                    'companyId' => 'companyId',
                    'companyName' => 'companyName', // si quieres copiarlo explícito, ok
                ],

                'totalKey' => 'total',
                'tz' => 'America/Guayaquil',
                'fillEmpty' => true,
                'defaultGroupValue' => 'Sin empresa',
            ]
        );
        $dataIntervalTypePeople = UtilHighcharts::groupCountByIntervals(
            $resultTypes,
            $intervalPack,
            [
                'dateKey' => 'created_at',
                'dataKeyByGroup' => 'type',   // 👈 series
                'groupOutKey' => 'type',      // alias (opcional)
                'extras' => [
                    'companyId' => 'companyId',
                    'type' => 'type',
                    'companyName' => 'companyName', // si quieres copiarlo explícito, ok
                ],

                'totalKey' => 'total',
                'tz' => 'America/Guayaquil',
                'fillEmpty' => true,
                'defaultGroupValue' => 'Sin empresa',
            ]
        );
        $data = [
            "dataInterval" => $dataInterval,
            "attributesPost" => $attributesPost,
            "resultTypes" => $summary, "intervals" => $intervalPack, "dataIntervalCompany" => $dataIntervalCompany, "dataIntervalTypePeople" => $dataIntervalTypePeople];

        $result = ["success" => $success, "data" => $data];
        return Response::json($result);
    }

    public function getListSelect2()
    {

        $attributesPost = Request::all();
        $model = new  MaritimeDepartures();
        $result = $model->getListSelect2($attributesPost);
        return Response::json($result);
    }
}
