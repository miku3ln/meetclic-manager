<?php

namespace App\Http\Controllers\MaritimeOperationsManagement;



use App\Exports\MaritimeDeparturesExport;
use App\Http\Controllers\MyBaseController;
use App\Models\Business;
use App\Models\MaritimeOperationsManagement\MaritimeDepartures;
use App\Utils\DateIntervals;
use App\Utils\UtilHighcharts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;



//use Maatwebsite\Excel\Facades\Excel;


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

    public function businessManager()
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
        $business_subcategories_data = [76];
        $query->whereIn($table . '.business_subcategories_id', $business_subcategories_data);


        if (isset($params["filters"]['search_value']["term"])) {
            $likeSearch = $params["filters"]['search_value']["term"];
            $query->where($table . '.title', 'like', '%' . $likeSearch . '%');


        }

        $query->limit(50);
        $result = $query->get()->toArray();

        return Response::json($result);

    }
    public function  maritimeDeparturesVesselList(){
        $table = "business";
        $params = Request::all();


        $selectString = "$table.description ,$table.id business_id,$table.title business_alt,$table.email,$table.page_url,$table.phone_value,$table.street_1,$table.street_2,$table.street_lat,$table.street_lng,$table.user_id owner_user_business_id,$table.business_subcategories_id,$table.status,$table.qualification,$table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id
,maritime_vessels.name text,maritime_vessels.id id


 ";
        $select = DB::raw($selectString);
        $query = Business::query()->select($select);
        $query->join('business_subcategories', $table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('maritime_vessels', $table . ".id", '=', 'maritime_vessels.business_id');

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
            $query->where( 'maritime_vessels.name', 'like', '%' . $likeSearch . '%');


        }

        $query->limit(100);
        $result = $query->get()->toArray();

        return Response::json($result);
    }
    public function maritimeDeparturesAssign()
    {
        $table = "business";
        $params = Request::all();
        $user = Auth::user();
        $userId = $user->id;
        $selectString = "$table.description ,$table.id business_id,$table.title business_alt,$table.email,$table.page_url,$table.phone_value,$table.street_1,$table.street_2,$table.street_lat,$table.street_lng,$table.user_id owner_user_business_id,$table.business_subcategories_id,$table.status,$table.qualification,$table.source
 ,business_subcategories.name business_subcategories
 ,business_categories.name business_categories,business_categories.id business_categories_id
 ,countries.name countries,countries.id countries_id
         ,zones.name zone,zones.id zones_id
        ,cities.name city,cities.id cities_id
 ,provinces.name province,provinces.id
 ,users.id users_id,users.name users_name
,maritime_vessels.name text,maritime_vessels.id id,
maritime_vessel_responsibles.customer_id,maritime_vessel_responsibles.id maritime_vessel_responsibles_id
,CONCAT(people.name,' ',people.last_name)  responsible_name,customer.identification_document

 ";
        $select = DB::raw($selectString);
        $query = Business::query()->select($select);
        $query->join('business_subcategories', $table . ".business_subcategories_id", '=', 'business_subcategories.id');
        $query->join('maritime_vessels', $table . ".id", '=', 'maritime_vessels.id');
        $query->join('maritime_vessel_responsibles', "maritime_vessels.id", '=', 'maritime_vessel_responsibles.maritime_vessel_id');
        $query->join('customer_by_profile', "maritime_vessel_responsibles.customer_id", '=', 'customer_by_profile.customer_id');
        $query->join('customer', "customer_by_profile.customer_id", '=', 'customer.id');
        $query->join('people', "customer.people_id", '=', 'people.id');

        $query->join('users', "customer_by_profile.user_id", '=', 'users.id');
        $query->join('business_categories', "business_subcategories.business_categories_id", '=', 'business_categories.id');
        $query->where('users.id', '=', $userId);

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

    public function maritimeDeparturesReportsDownload($dateFrom, $dateTo, $businessId)
    {
        $model = new MaritimeDepartures();

        $attributesPost = Request::all();
        $date_from = $dateFrom . ' 00:00:00';
        $date_to = "";
        $tz = 'America/Guayaquil';
        $dateToInput = $dateTo; // 'YYYY-MM-DD'
        $today = Carbon::now($tz)->toDateString(); // 'YYYY-MM-DD'
        $maritime_vessels_id = $businessId=='null'?null:$businessId;

        if ($dateToInput === $today) {
            // Si es hoy → usar hora actual
            $date_to = Carbon::now($tz)->toDateTimeString(); // 'YYYY-MM-DD HH:MM:SS'
        } else {
            // Si es pasado → cerrar el día completo
            $date_to = $dateToInput . ' 23:59:59';
        }

        $dataResult = $model->getDeparturesCustomersResumeByType(
            [
                'maritime_vessels_id' => $maritime_vessels_id,
                'date_from' => $date_from,
                'date_to' => $date_to]
        );


        $dataExcelMatrix=UtilHighcharts::buildMatrixByCompanyId($dataResult);

// 2) filas indexadas (sin dataFull)


// 3) primera fila de data = headings + rows
        $excelData =$dataExcelMatrix;

        return Excel::download(
            new MaritimeDeparturesExport ($excelData),
            'matriz_zarpes_san_pablo.xlsx'
        );
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
        $maritime_vessels_id = isset($attributesPost['maritime_vessel_id']) ? $attributesPost['maritime_vessel_id'] : null;
        if ($dateToInput === $today) {
            // Si es hoy → usar hora actual
            $date_to = Carbon::now($tz)->toDateTimeString(); // 'YYYY-MM-DD HH:MM:SS'
        } else {
            // Si es pasado → cerrar el día completo
            $date_to = $dateToInput . ' 23:59:59';
        }

        $resultTypes = $model->getDeparturesCustomersResumeByType(
            [
                'maritime_vessels_id' => $maritime_vessels_id,
                'date_from' => $date_from,
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
            "all" => $resultTypes,
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
