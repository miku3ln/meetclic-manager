<?php

namespace App\Infrastructure\Cms\Infrastructure\Adapters\Persistence\Repositories;

use Illuminate\Support\Facades\DB;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessReadPort;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessFilter;

class DbProcessReadRepository implements ProcessReadPort
{
    public function findProcessWithPointsAndBusiness(int $processId): ?array
    {
        $row = DB::table('gamification_by_process as p')
            ->join('gamification_by_points as pts', 'pts.gamification_by_process_id', '=', 'p.id')
            ->join('business_by_gamification as bg', 'bg.gamification_id', '=', 'p.gamification_id')
            ->join('business as b', 'b.id', '=', 'bg.business_id')
            ->leftJoin('tracking_click_types as tct', 'tct.id', '=', 'p.tracking_click_type_id')
            ->leftJoin('tracking_sources as ts', 'ts.id', '=', 'p.tracking_source_id')
            ->where('p.id', $processId)
            ->select([
                'p.*',
                'pts.id as gamification_by_points_id',
                'pts.points as points',
                'b.id as business_id',
                'b.title as business_name',
                'tct.code as tracking_type_code',
                'ts.code as tracking_source_code',
            ])
            ->limit(1)
            ->first();

        return $row ? (array)$row : null;
    }

    public function findProcessByBusinessAndTracking(ProcessFilter $filter): ?array
    {

        $q = DB::table('business_by_gamification as bg')
            ->join('gamification as g', 'g.id', '=', 'bg.gamification_id')
            ->join('business as b', 'b.id', '=', 'bg.business_id')
            ->join('gamification_by_process as p', 'p.gamification_id', '=', 'g.id')
            ->join('tracking_click_types as tct', 'tct.id', '=', 'p.tracking_click_type_id')
            ->join('tracking_sources as ts', 'ts.id', '=', 'p.tracking_source_id')
            // ✅ recomendado si quieres puntos (si NO quieres, elimina este join + selects)
            ->join('gamification_by_points as gp', 'gp.gamification_by_process_id', '=', 'p.id')
            ->where('bg.business_id', $filter->businessId)
            ->where('p.tracking_source_id', $filter->trackingSourceId)
            ->where('p.tracking_click_type_id', $filter->trackingClickTypeId);


        $q->where('p.campaign_code_template', $filter->campaignCode);
        $q->where('p.id', $filter->codeProcess);



        $row = $q->select([
            // --- PROCESO ---
            'p.id',
            'p.source',
            'p.title',
            'p.subtitle',
            'p.description',
            'p.state',
            'p.valid_from',
            'p.valid_until',
            'p.frequency_limit_type',
            'p.frequency_limit_value',
            'p.has_source',
            'p.entity',
            'p.entity_id',
            'p.url_manager',
            'p.gamification_id',
            'p.gamification_type_activity_id',
            'p.is_url',
            'p.type_manager',
            'p.execution_channel',
            'p.user_id',
            'p.unique_code',
            'p.allow_golden',
            'p.icon_class',
            'p.campaign_code_template',
            'p.tracking_click_type_id',
            'p.tracking_source_id',

            // --- POINTS (si aplica) ---
            'gp.id as gamification_by_points_id',
            'gp.points',
            // --- GAMIFICATION ---
            'g.id as gamification_id',
            'g.value as gamification_name',

            // --- TRACKING CLICK TYPE ---
            'tct.id as tracking_click_type_id',
            'tct.code as tracking_type_code',
            'tct.uid as tracking_click_type_uid',

            // --- TRACKING SOURCE ---
            'ts.id as tracking_source_id',
            'ts.code as tracking_source_code',
            'ts.uid as tracking_source_uid',

        ])->orderBy('p.id', 'asc') // si hay varios, tomará el menor id
        ->first();
        if (!$row) return null;

        return (array)$row; // ✅ stdClass -> array
    }
}
