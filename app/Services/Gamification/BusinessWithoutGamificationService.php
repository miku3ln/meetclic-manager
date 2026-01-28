<?php

namespace App\Services\Gamification;

use Illuminate\Support\Facades\DB;

class BusinessWithoutGamificationService
{
    /**
     * Retorna negocios ACTIVE que NO tienen configuración de gamificación.
     *
     * Output:
     * [
     *   ["id" => 10, "name" => "Antonio Males"],
     *   ...
     * ]
     */
    public function getActiveBusinessesWithoutGamification(): array
    {
        $rows = DB::table('business as b')
            ->leftJoin('business_by_gamification as bbg', 'bbg.business_id', '=', 'b.id')
            ->whereNull('bbg.id')
            ->select(['b.id', 'b.title'])
            ->orderBy('b.id', 'asc')
            ->get();

        return $rows
            ->map(fn ($r) => [
                'id' => (int) $r->id,
                'name' => (string) $r->title,
            ])
            ->toArray();
    }

    /**
     * Variante: si quieres filtrar por un set de business IDs específicos.
     */
    public function getBusinessesWithoutGamificationByIds(array $businessIds): array
    {
        $businessIds = $this->normalizeIds($businessIds);
        if (empty($businessIds)) return [];
        $rows = DB::table('business as b')
            ->leftJoin('business_by_gamification as bbg', 'bbg.business_id', '=', 'b.id')
            ->whereIn('b.id', $businessIds)
            ->where('b.status', '=', 'ACTIVE')
            ->whereNull('bbg.id')
            ->select(['b.id', 'b.title'])
            ->orderBy('b.id', 'asc')
            ->get();

        return $rows
            ->map(fn ($r) => [
                'id' => (int) $r->id,
                'name' => (string) $r->title,
            ])
            ->toArray();
    }

    private function normalizeIds(array $ids): array
    {
        // limpia ["10", 10, "alex"] => [10]
        $out = [];
        foreach ($ids as $v) {
            if (is_int($v)) {
                $out[] = $v;
                continue;
            }
            if (is_string($v) && ctype_digit($v)) {
                $out[] = (int) $v;
                continue;
            }
        }

        $out = array_values(array_unique($out));
        sort($out);
        return $out;
    }
}
