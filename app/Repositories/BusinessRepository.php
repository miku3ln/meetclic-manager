<?php

namespace App\Repositories;

use App\DTOs\GamificationSummary;
use App\DTOs\Reputation;
use App\DTOs\Trophies;
use App\DTOs\Yapitas;
use App\DTOs\Visits;
use App\DTOs\Rating;

use App\Models\InformationSocialNetwork;
use App\Models\InformationSocialNetworkType;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;

class BusinessRepository
{
    public function businessDetails($businessId)
    {


        $query = DB::table('business as b')
            ->leftJoin('entity_position_fiscal as epf', 'epf.id', '=', 'b.entity_position_fiscal_id')
            ->leftJoin('business_subcategories as bs', 'bs.id', '=', 'b.business_subcategories_id')
            ->select([
                'b.id',
                'b.title',
                'b.description',
                'b.source',
                'b.business_name',
                'b.email',
                'b.phone_value',
                'b.page_url',
                'b.street_1',
                'b.street_2',
                'b.street_lat',
                'b.street_lng',
                'b.status',
                'b.qualification',
                'b.business_subcategories_id',
                'bs.name as subcategory_name',
                'epf.value as fiscal_position',
            ])
            ->where('b.status', 'ACTIVE')
            ->whereNotNull('b.street_lat')
            ->whereNotNull('b.street_lng');
            $query->whereIn('b.id', [$businessId]);
        $results = $query->get();
        foreach ($results as $business) {

            $publicAsset = asset('public') . $business->source;
            $business->source = $publicAsset;
            $business_id = $business->id;
            $weekVisit = $this->getCountersBusiness([
                'filters' => [
                    'business_id' => $business_id,
                    'isWeek' => true,
                ]
            ]);
            $reputationData= $this->getReputationLogForBusiness($business_id);
            $getRatingSummaryForBusiness= $this->getRatingSummaryForBusiness($business_id);
            $reputationScore = $reputationData["summary"]["total_reputation"];
            $totalTrophies = 0;
            $totalVisits = 0;
            $positiveClients = 0;
            $averageStars = $getRatingSummaryForBusiness["average_stars"];
            $communityScore = 0;
            $totalEntradaYapitas = 0;
            $totalSalidaYapitas = 0;
            $balance_available_bee = 0;
            $totalEntradaYapitasPremium = 0;
            $totalSalidaYapitasPremium = 0;
            $balance_available_queen = 0;
            $summary = new GamificationSummary(
                new Yapitas($totalEntradaYapitas, $totalSalidaYapitas, $balance_available_bee),
                new Yapitas($totalEntradaYapitasPremium, $totalSalidaYapitasPremium, $balance_available_queen),
                new Reputation($reputationScore),
                new Trophies($totalTrophies),
                new Visits($totalVisits),
                new Rating($positiveClients, $averageStars, $communityScore)
            );
            $schedules = $this->getShedulingByBusinessData([
                'business_id' => $business_id,
            ]);
            $business->summary = $summary;
            $business->schedules = $schedules;
            $business->reputationData = $reputationData;
            $business->getRatingSummaryForBusiness = $getRatingSummaryForBusiness;
            $socialNetworksData=    $this->getSocialNetwork(["filters"=>["business_id"=>$business_id]]);
            $business->socialNetworksData = $socialNetworksData;

        }

        return $results->toArray();
    }
    public function searchNearbyBusinesses($latitude, $longitude, $radiusKm = 10, $subcategoryIds = [])
    {
        $haversine = "(6371 * acos(
        cos(radians(?)) *
        cos(radians(b.street_lat)) *
        cos(radians(b.street_lng) - radians(?)) +
        sin(radians(?)) *
        sin(radians(b.street_lat))
    ))";

        $query = DB::table('business as b')
            ->leftJoin('entity_position_fiscal as epf', 'epf.id', '=', 'b.entity_position_fiscal_id')
            ->leftJoin('business_subcategories as bs', 'bs.id', '=', 'b.business_subcategories_id')
            ->select([
                'b.id',
                'b.title',
                'b.description',
                'b.source',
                'b.business_name',
                'b.email',
                'b.phone_value',
                'b.page_url',
                'b.street_1',
                'b.street_2',
                'b.street_lat',
                'b.street_lng',
                'b.status',
                'b.qualification',
                'b.business_subcategories_id',
                'bs.name as subcategory_name',
                'epf.value as fiscal_position',
            ])
            ->selectRaw("$haversine as distance", [$latitude, $longitude, $latitude]) // ✅ Muestra distancia
            ->where('b.status', 'ACTIVE')
            ->whereNotNull('b.street_lat')
            ->whereNotNull('b.street_lng')
            ->whereRaw("$haversine <= ?", [$latitude, $longitude, $latitude, $radiusKm]); // ✅ Filtrado por rango

        // Si filtras por subcategoría
        if (!empty($subcategoryIds) && !(count($subcategoryIds) === 1 && $subcategoryIds[0] == 0)) {
            $query->whereIn('b.business_subcategories_id', $subcategoryIds);
        }

        $results = $query->get();

        foreach ($results as $business) {
            $business->distance_km = round($business->distance, 2) . " km";

            $publicAsset = asset('public') . $business->source;
            $business->source = $publicAsset;
            $business_id = $business->id;
            $weekVisit = $this->getCountersBusiness([
                'filters' => [
                    'business_id' => $business_id,
                    'isWeek' => true,
                ]
            ]);
            $reputationData= $this->getReputationLogForBusiness($business_id);
            $reputationCustomer= $this->getReputationLogForClient(1);
            $socialFollowDataCustomer= $this->getSocialFollowLogForClient(1);
            $getRatingSummaryForClientData= $this->getRatingSummaryForClient(1);
            $getRatingSummaryForBusiness= $this->getRatingSummaryForBusiness($business_id);



            $reputationScore = $reputationData["summary"]["total_reputation"];
            $totalTrophies = 0;
            $totalVisits = 0;
            $positiveClients = 0;
            $averageStars = 0;
            $communityScore = 0;
            $totalEntradaYapitas = 0;
            $totalSalidaYapitas = 0;
            $balance_available_bee = 0;
            $totalEntradaYapitasPremium = 0;
            $totalSalidaYapitasPremium = 0;
            $balance_available_queen = 0;

            $summary = new GamificationSummary(
                new Yapitas($totalEntradaYapitas, $totalSalidaYapitas, $balance_available_bee),
                new Yapitas($totalEntradaYapitasPremium, $totalSalidaYapitasPremium, $balance_available_queen),
                new Reputation($reputationScore),
                new Trophies($totalTrophies),
                new Visits($totalVisits),
                new Rating($positiveClients, $averageStars, $communityScore)
            );
            $schedules = $this->getShedulingByBusinessData([
                'business_id' => $business_id,
            ]);
            $business->summary = $summary;
            $business->schedules = $schedules;
            $business->reputationData = $reputationData;
            $business->reputationDataCustomer = $reputationCustomer;
            $business->socialFollowDataCustomer = $socialFollowDataCustomer;
            $business->getRatingSummaryForClientData = $getRatingSummaryForClientData;
            $business->getRatingSummaryForBusiness = $getRatingSummaryForBusiness;
            $socialNetworksData=    $this->getSocialNetwork(["filters"=>["business_id"=>$business_id]]);
            $business->socialNetworksData = $socialNetworksData;





        }

        return $results->toArray();
    }
    public function getReputationLogForClient(int $userId): array
    {
        // Verificar si existen movimientos de reputación para el usuario
        $hasReputation = DB::table('reputation_movement_client')
            ->where('user_id', $userId)
            ->exists();

        if (!$hasReputation) {
            return [
                'movements' => [],
                'summary' => [
                    'total_reputation' => 0,
                    'incoming' => 0,
                    'outgoing' => 0,
                ],
            ];
        }

        // Obtener movimientos de reputación del cliente
        $movements = DB::table('reputation_movement_client as rm')
            ->leftJoin('gamification_by_process as process', 'process.id', '=', 'rm.gamification_by_process_id')
            ->orderByDesc('rm.created_at')
            ->select([
                'rm.id',
                'rm.created_at as timestamp',
                'rm.description',
                'rm.type_manager',
                'rm.reputation_points',
                'rm.user_id',
                'process.title as process_name',
            ])
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'timestamp' => $record->timestamp,
                    'description' => $record->description,
                    'direction' => $record->type_manager === 1 ? 'IN' : 'OUT',
                    'reputation_points' => (float) $record->reputation_points,
                    'user_id' => $record->user_id,
                    'process_name' => $record->process_name ?? 'Unknown',
                ];
            });

        // Calcular sumatorias
        $incoming = $movements->where('direction', 'IN')->sum('reputation_points');
        $outgoing = $movements->where('direction', 'OUT')->sum('reputation_points');
        $totalReputation = $incoming - $outgoing;

        return [
            'movements' => $movements,
            'summary' => [
                'total_reputation' => $totalReputation,
                'incoming' => $incoming,
                'outgoing' => $outgoing,
            ],
        ];
    }
    public function getSocialFollowLogForClient(int $userId): array
    {
        // Verificar si existe resumen social para este usuario
        $summary = DB::table('social_follow_summary')
            ->where('user_id', $userId)
            ->first();

        if (!$summary) {
            return [
                'movements' => [],
                'summary' => [
                    'followers' => 0,
                    'following' => 0,
                    'business_following' => 0,
                ],
            ];
        }

        // Obtener movimientos de seguimiento asociados al resumen
        $movements = DB::table('social_follow_movement as sfm')
            ->leftJoin('gamification_by_process as process', 'process.id', '=', 'sfm.gamification_by_process_id')
            ->where('sfm.social_follow_summary_id', $summary->id)
            ->orderByDesc('sfm.created_at')
            ->select([
                'sfm.id',
                'sfm.created_at as timestamp',
                'sfm.description',
                'sfm.input_movement',
                'sfm.type_process',
                'sfm.manager_id',
                'sfm.is_active',
                'process.title as process_name',
            ])
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'timestamp' => $record->timestamp,
                    'description' => $record->description,
                    'direction' => $record->input_movement === 1 ? 'Follow' : 'Unfollow',
                    'type_process' => $record->type_process === 1 ? 'Client-to-Client' : 'Client-to-Business',
                    'manager_id' => $record->manager_id,
                    'is_active' => $record->is_active === 1,
                    'process_name' => $record->process_name ?? 'Unknown',
                ];
            });

        return [
            'movements' => $movements,
            'summary' => [
                'followers' => $summary->followers,
                'following' => $summary->following,
                'business_following' => $summary->business_following,
            ],
        ];
    }
    public function getRatingSummaryForBusiness(int $businessId): array
    {
        $ratings = DB::table('rating_movement_business as rmb')
            ->leftJoin('rating_scale_config as rsc', 'rmb.stars', '=', 'rsc.stars')
            ->where('rmb.business_id', $businessId)
            ->select([
                'rmb.stars',
                'rsc.label',
                'rsc.color_hex',
                'rsc.description',
            ])
            ->get();

        if ($ratings->isEmpty()) {
            return [
                'total_ratings' => 0,
                'average_stars' => 0,
                'distribution' => [],
            ];
        }

        $total = $ratings->count();
        $average = round($ratings->avg('stars'), 2);

        $distribution = $ratings->groupBy('stars')->map(function ($group) use ($total) {
            $first = $group->first();
            return [
                'count' => $group->count(),
                'percentage' => round(($group->count() / $total) * 100, 2),
                'label' => $first->label,
                'description' => $first->description,
                'color_hex' => $first->color_hex,
            ];
        });

        return [
            'total_ratings' => $total,
            'average_stars' => $average,
            'distribution' => $distribution,
        ];
    }

    public function getRatingSummaryForClient(int $userId): array
    {
        $ratings = DB::table('rating_movement_client as rmc')
            ->leftJoin('rating_scale_config as rsc', 'rmc.stars', '=', 'rsc.stars')
            ->where('rmc.user_id', $userId)
            ->select([
                'rmc.stars',
                'rsc.label',
                'rsc.color_hex',
                'rsc.description',
            ])
            ->get();

        if ($ratings->isEmpty()) {
            return [
                'total_ratings' => 0,
                'average_stars' => 0,
                'distribution' => [],
            ];
        }

        $total = $ratings->count();
        $average = round($ratings->avg('stars'), 2);

        $distribution = $ratings->groupBy('stars')->map(function ($group) use ($total) {
            $first = $group->first();
            return [
                'count' => $group->count(),
                'percentage' => round(($group->count() / $total) * 100, 2),
                'label' => $first->label,
                'description' => $first->description,
                'color_hex' => $first->color_hex,
            ];
        });

        return [
            'total_ratings' => $total,
            'average_stars' => $average,
            'distribution' => $distribution,
        ];
    }

    public function getReputationLogForBusiness(int $businessId): array
    {
        $reputationAccount = DB::table('reputation_movement_business')
            ->where('business_id', $businessId)
            ->first();

        if (!$reputationAccount) {
            return [
                'movements' => [],
                'summary' => [
                    'total_reputation' => 0,
                    'incoming' => 0,
                    'outgoing' => 0,
                ],
            ];
        }

        $movements = DB::table('reputation_movement_business as rm')
            ->leftJoin('gamification_by_process as process', 'process.id', '=', 'rm.gamification_by_process_id')
            ->orderByDesc('rm.created_at')
            ->select([
                'rm.id',
                'rm.created_at as timestamp',
                'rm.description',
                'rm.type_manager',
                'rm.reputation_points',
                'rm.user_id',
                'process.title as process_name',
            ])
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'timestamp' => $record->timestamp,
                    'description' => $record->description,
                    'direction' => $record->type_manager === 1 ? 'IN' : 'OUT',
                    'reputation_points' => (float) $record->reputation_points,
                    'user_id' => $record->user_id,
                    'process_name' => $record->process_name ?? 'Unknown',
                ];
            });

        $incoming = $movements->where('direction', 'IN')->sum('reputation_points');
        $outgoing = $movements->where('direction', 'OUT')->sum('reputation_points');
        $totalReputation = $incoming - $outgoing;

        return [
            'movements' => $movements,
            'summary' => [
                'total_reputation' => $totalReputation,
                'incoming' => $incoming,
                'outgoing' => $outgoing,
            ],
        ];
    }
    public function getCountersBusiness($params)
    {
        $limitDays = Util::getDatesInitWeek();
        $query = "";
        $business_id = isset($params['filters']['business_id']) ? $params['filters']['business_id'] : null;
        $actionName = isset($params['filters']['actionName']) ? $params['filters']['actionName'] : 'businessDetails';
        $getData = isset($params['filters']['allData']) ? $params['filters']['allData'] : false;
        $allVisit = isset($params['filters']['allVisit']) ? $params['filters']['allVisit'] : false;

        if ($allVisit) {
            $subquery = DB::table('tracking_sessions')
                ->select([
                    DB::raw("DATE(created_at) as fecha"),
                    DB::raw("CASE WHEN user_id IS NULL OR user_id = 0 THEN token ELSE CAST(user_id AS CHAR) END AS visitante"),
                    'id',
                    'user_id',
                    'token',
                    'created_at'
                ])
                ->whereBetween('created_at', [$limitDays['from'], $limitDays['to']]);
            $query = DB::table(DB::raw("({$subquery->toSql()}) as sesiones"))
                ->mergeBindings($subquery)
                ->select([
                    'fecha',
                    'visitante',
                    DB::raw('MIN(id) as id'),
                    DB::raw('MIN(user_id) as user_id'),
                    DB::raw('MIN(token) as token'),
                    DB::raw('MIN(created_at) as primer_ingreso')
                ])
                ->groupBy('fecha', 'visitante')
                ->orderBy('fecha');


        } else {
            $tableCurrent = "tracking_events";
            $query = DB::table($tableCurrent);
            $tableMain = "tracking_sessions";
            $selectString = "tracking_sessions.token,$tableCurrent.id,tracking_sessions.is_guest,tracking_sessions.user_id,$tableCurrent.action_name,tracking_sessions.business_id";
            $select = DB::raw($selectString);
            $query->select($select);
            $query->join('tracking_sessions', $tableCurrent . '.session_id', '=', 'tracking_sessions.id');
            if ($business_id) {
                $query->where('tracking_sessions.business_id', '=', $business_id);
            }
            if (isset($params["filters"]['isWeek'])) {
                $field = 'tracking_sessions.created_at';
                $query->where($field, '>=', $limitDays['from']);
                $query->where($field, '<=', $limitDays['to']);
            }
            if ($actionName) {
                $query->where($tableCurrent . '.action_name', '=', $actionName);
            } else {

            }
        }


        if ($getData) {
            $result = $query->get()->toArray();
        } else {
            $result = $query->get()->count();
        }


        return $result;
    }

    public function getBreakdownScheduleStructure($params)
    {
        $result = array();
        $haystack = $params["haystack"];
        foreach ($haystack as $key => $row) {
            // your code
            $modelStartTime = $row->start_time;
            $modelEndTime = $row->end_time;
            $setPush = array(
                "start_time" => array("id" => $row->id, "modelBreakdown" => $modelStartTime, "error" => true, "msj" => "", "init" => true),
                "end_time" => array("id" => $row->id, "modelBreakdown" => $modelEndTime, "error" => true, "msj" => "", "init" => true),

            );
            array_push($result, $setPush);
        }


        return $result;
    }

    public function getBreakdownSchedule($params)
    {

        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $tableCurrent = "business_schedule_by_breakdown";
        $columns = "*";
        $business_by_schedule_id = $params["business_by_schedule_id"];
        $query = DB::table($tableCurrent)
            ->select($columns);
        $query->where("business_by_schedule_id", $business_by_schedule_id);
        $result = $query->get();

        return $result;
    }

    public function getShedulingByBusinessData($params)
    {
        $schedules = $this->getSchedulesByBusiness($params);
        $result = [];
        foreach ($schedules as $key => $row) {

            $business_by_schedule_id = $row->id;
            $dataBreakdownCurrent = $row->type == 1 ? $this->getBreakdownScheduleStructure(array("haystack" => $this->getBreakdownSchedule(array("business_by_schedule_id" => $business_by_schedule_id)))) : array();
            $setPush = array(
                "id" => $row->id,
                "name" => "element-" . $row->id,
                "text" => $row->name,//*
                "type" => $row->type,//*
                "modelDay" => $row->open == 1 ? true : false,//*
                "business_id" => $row->business_id,//*
                "status" => $row->status,//*
                "weight_day" => $row->weight_day,
                "configTypeSchedule" => array(
                    "type" => $row->type == 1 ? true : false,//*
                    "data" => $dataBreakdownCurrent
                )
            );

            array_push($result, $setPush);
        }

        return $result;
    }

    public function getSchedulesByBusiness($params)
    {
        $tableCurrent = "business_by_schedule";
        $sort = isset($params['sort']) ? $params['sort'] : 'asc';
        $field = isset($params['field']) ? $params['field'] : 'schedule_days_category.weight_day';
        $select = "$tableCurrent.id,$tableCurrent.open,$tableCurrent.status,$tableCurrent.schedule_days_category_id,$tableCurrent.type,$tableCurrent.business_id
        ,schedule_days_category.name schedule_days_category_day,schedule_days_category.name,schedule_days_category.weight_day,schedule_days_category.description schedule_days_category_description";
        $business_id = $params["business_id"];
        $select = DB::raw($select);
        $query = DB::table($tableCurrent)
            ->select($select);
        $query->join('schedule_days_category', "$tableCurrent.schedule_days_category_id", '=', 'schedule_days_category.id');
        $query->where("business_id", $business_id);
        $query->orderBy($field, $sort);
        return $query->get();
    }

    public function getSocialNetwork($params)
    {
        $modelISN = new InformationSocialNetwork();
        $entity_id = $params['filters']['business_id'];
        $entity_type = InformationSocialNetwork::ENTITY_TYPE_BUSINESS;
        $facebook = $modelISN->getSocialNetworkInformation([
            'filters' => [
                'information_social_network_type_id' => InformationSocialNetworkType::TYPE_FACEBOOK_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type
            ]
        ]);
        $instagram = $modelISN->getSocialNetworkInformation([
            'filters' => ['information_social_network_type_id' => InformationSocialNetworkType::TYPE_INSTAGRAM_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type,
            ]
        ]);
        $twitter = $modelISN->getSocialNetworkInformation([
            'filters' => ['information_social_network_type_id' => InformationSocialNetworkType::TYPE_TWITTER_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type,
            ]
        ]);
        $youtube = $modelISN->getSocialNetworkInformation([
            'filters' => ['information_social_network_type_id' => InformationSocialNetworkType::TYPE_YOUTUBE_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type,
            ]
        ]);
        $whatsapp = $modelISN->getSocialNetworkInformation([
            'filters' => ['information_social_network_type_id' => InformationSocialNetworkType::TYPE_WHATSAPP_ID,
                'entity_id' => $entity_id,
                'entity_type' => $entity_type,
            ]
        ]);
        $information_social_network = [];
        $information_social_network['facebook'] = $facebook;
        $information_social_network['instagram'] = $instagram;
        $information_social_network['twitter'] = $twitter;
        $information_social_network['youtube'] = $youtube;
        $information_social_network['whatsapp'] = $whatsapp;

        return $information_social_network;
    }
}
