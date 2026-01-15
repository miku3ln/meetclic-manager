<?php

namespace App\Http\Controllers\MaritimeOperationsManagement;

use App\Http\Controllers\MyBaseController;
use App\Models\Business;
use App\Models\MaritimeOperationsManagement\MaritimeDepartures;
use App\Utils\DateIntervals;
use App\Utils\UtilHighcharts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    public function maritimeDeparturesAssign()
    {
        $table = "business";
        $params = Request::all();

        $selectString = "$table.id ,$table.description ,$table.title text,$table.title alt,$table.email,$table.page_url,$table.phone_value,$table.street_1,$table.street_2,$table.street_lat,$table.street_lng,$table.user_id,$table.business_subcategories_id,$table.status,$table.qualification,$table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id provinces_id
 ";
        $select = DB::raw($selectString);
        $query = Business::query()->select($select);
        $query->join('business_subcategories', $table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->leftJoin('business_location', function ($query)
        use (
            $selectString

        ) {
            $query->on('business_location.business_id', '=', 'business.id');
            $query->join('zones', "business_location.zones_id", '=', 'zones.id');
            $query->join('cities', "zones.city_id", '=', 'cities.id');
            $query->join('provinces', "cities.province_id", '=', 'provinces.id');
            $query->join('countries', "provinces.country_id", '=', 'countries.id');

        });
        if (isset($params["filters"]['search_value']["term"])) {
            $likeSearch = $params["filters"]['search_value']["term"];
            $query->where($table . '.title', 'like', '%' . $likeSearch . '%');


        }

        $query->limit(10);
        $result = $query->get()->toArray();

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
        $business_id = $attributesPost['business_id'];
        if ($dateToInput === $today) {
            // Si es hoy → usar hora actual
            $date_to = Carbon::now($tz)->toDateTimeString(); // 'YYYY-MM-DD HH:MM:SS'
        } else {
            // Si es pasado → cerrar el día completo
            $date_to = $dateToInput . ' 23:59:59';
        }

        $resultTypes = $model->getDeparturesCustomersResumeByType(
            [
                'business_id' => $business_id,
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
                    'companyName' => 'companyName', // si quieres copiarlo explícito, ok
                ],

                'totalKey' => 'total',
                'tz' => 'America/Guayaquil',
                'fillEmpty' => true,
                'defaultGroupValue' => 'Sin empresa',
            ]
        );
        $data = [
            "all"=>$resultTypes,
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
