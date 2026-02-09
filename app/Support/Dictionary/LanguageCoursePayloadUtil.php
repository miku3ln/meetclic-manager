<?php

declare(strict_types=1);

namespace App\Support\Dictionary;

use Illuminate\Support\Facades\DB;

final class LanguageCoursePayloadUtil
{
    /**
     * Payload completo para Front (Flutter/Web).
     *
     * Options:
     *  - include_inactive (bool) default false
     */
    public static function buildPayload(int $languageCourseId, array $options = []): array
    {
        $includeInactive = (bool)($options['include_inactive'] ?? false);

        $course = self::getCourse($languageCourseId);

        if (!$course) {
            return [
                'meta' => [
                    'generated_at' => now()->toIso8601String(),
                    'source' => 'language_course_payload',
                    'version' => 2, // ✅ actualizado
                    'include_inactive' => $includeInactive,
                    'language_course_id' => $languageCourseId,
                ],
                'ok' => false,
                'message' => 'language_course no encontrado',
                'data' => null,
            ];
        }

        // ✅ NUEVO: tablas renombradas coherentes (course -> units -> sections -> items)
        $units = self::getUnits($languageCourseId, $includeInactive);
        $unitIds = array_map(fn($u) => (int)$u['id'], $units);

        $uiUx = self::getUiUxForUnits($unitIds);

        $sections = self::getSectionsByUnits($unitIds, $includeInactive);
        $sectionIds = array_map(fn($s) => (int)$s['id'], $sections);

        $sectionUiUx = self::getUiUxForSections($sectionIds);

        // ✅ NUEVO: items solo para sections TOPIC (FINAL_EXAM no trae items)
        $items = self::getSectionItemsBySections($sectionIds, $includeInactive);

        $itemUiUx = self::getUiUxForItems($items);

        // ===== Index maps =====
        $uiById = self::indexById($uiUx);
        $sectionUiById = self::indexById($sectionUiUx);
        $itemUiById = self::indexById($itemUiUx);

        // ✅ CAMBIO: key correcta (antes unidad_id)
        $sectionsByUnit = [];
        foreach ($sections as $s) {
            $sectionsByUnit[(int)$s['language_course_unit_id']][] = $s;
        }

        // ✅ CAMBIO: key correcta (antes unidad_seccion_id)
        $itemsBySection = [];
        foreach ($items as $it) {
            $itemsBySection[(int)$it['language_course_unit_section_id']][] = $it;
        }

        // ===== Build final payload =====
        foreach ($units as &$u) {
            $uUiId = (int)$u['configuracion_ui_ux_id'];
            $u['ui_ux'] = $uiById[$uUiId] ?? null;

            $uSections = $sectionsByUnit[(int)$u['id']] ?? [];

            foreach ($uSections as &$s) {
                $sUiId = (int)$s['configuracion_ui_ux_id'];
                $s['ui_ux'] = $sectionUiById[$sUiId] ?? null;

                // ✅ FINAL_EXAM no tiene items (y aunque existan ids, la query ya no los devuelve)
                $sItems = $itemsBySection[(int)$s['id']] ?? [];

                foreach ($sItems as &$it) {
                    $itUiId = (int)$it['configuracion_ui_ux_id'];
                    $it['ui_ux'] = $itemUiById[$itUiId] ?? null;
                }
                unset($it);

                usort($sItems, fn($a, $b) => ((int)$a['weight']) <=> ((int)$b['weight']));
                $s['items'] = array_values($sItems); // ✅ CAMBIO: antes "data"
            }
            unset($s);

            usort($uSections, fn($a, $b) => ((int)$a['weight']) <=> ((int)$b['weight']));
            $u['sections'] = array_values($uSections);
        }
        unset($u);

        usort($units, fn($a, $b) => ((int)$a['weight']) <=> ((int)$b['weight']));

        return [
            'meta' => [
                'generated_at' => now()->toIso8601String(),
                'source' => 'language_course_payload',
                'version' => 2, // ✅ actualizado
                'include_inactive' => $includeInactive,
                'language_course_id' => $languageCourseId,
            ],
            'ok' => true,
            'message' => 'Estructura cargada',
            'data' => [
                'course' => $course,
                'units' => array_values($units),
            ],
        ];
    }

    // =========================================================
    // QUERIES (sin modelos)
    // =========================================================

    private static function getCourse(int $languageCourseId): ?array
    {
        $row = DB::table('language_course')
            ->select(['id','value','description','status','dictionary_language_id'])
            ->where('id', $languageCourseId)
            ->first();

        return $row ? (array)$row : null;
    }

    /**
     * ✅ CAMBIO: antes DB::table('unidad')
     */
    private static function getUnits(int $languageCourseId, bool $includeInactive): array
    {
        $q = DB::table('language_course_unit')
            ->select([
                'id','value','subtitle','description','status',
                'language_course_id','configuracion_ui_ux_id','weight'
            ])
            ->where('language_course_id', $languageCourseId)
            ->orderBy('weight')
            ->orderBy('id');

        if (!$includeInactive) $q->where('status', 'ACTIVE');

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    /**
     * ✅ CAMBIO: antes unidad_seccion (fields: unidad_id)
     * ✅ NUEVO: section_type (TOPIC / FINAL_EXAM)
     */
    private static function getSectionsByUnits(array $unitIds, bool $includeInactive): array
    {
        if (empty($unitIds)) return [];

        $q = DB::table('language_course_unit_section')
            ->select([
                'id',
                'language_course_unit_id',
                'section_type',
                'configuracion_ui_ux_id',
                'title','subtitle','description','status','weight','source'
            ])
            ->whereIn('language_course_unit_id', $unitIds)
            ->orderBy('language_course_unit_id')
            ->orderBy('weight')
            ->orderBy('id');

        if (!$includeInactive) $q->where('status', 'ACTIVE');

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    /**
     * ✅ CAMBIO: antes unidad_seccion_data
     * ✅ NUEVO: item_kind (TEACHING / FINAL_TEST)
     * ✅ REGLA: SOLO se devuelven items de secciones TOPIC
     */
    private static function getSectionItemsBySections(array $sectionIds, bool $includeInactive): array
    {
        if (empty($sectionIds)) return [];

        $q = DB::table('language_course_unit_section_item as it')
            ->join('language_course_unit_section as s', 's.id', '=', 'it.language_course_unit_section_id')
            ->select([
                'it.id',
                'it.item_kind',
                'it.language_course_unit_id',
                'it.language_course_unit_section_id',
                'it.configuracion_ui_ux_id',
                'it.title','it.subtitle','it.description',
                'it.status','it.weight','it.source'
            ])
            ->whereIn('it.language_course_unit_section_id', $sectionIds)
            ->where('s.section_type', 'TOPIC') // ✅ FINAL_EXAM nunca trae items
            ->orderBy('it.language_course_unit_section_id')
            ->orderBy('it.weight')
            ->orderBy('it.id');

        if (!$includeInactive) {
            $q->where('it.status', 'ACTIVE')
                ->where('s.status', 'ACTIVE');
        }

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    // =========================================================
    // UI/UX helpers
    // =========================================================

    /**
     * ✅ CAMBIO: antes pluck desde 'unidad'
     */
    private static function getUiUxForUnits(array $unitIds): array
    {
        if (empty($unitIds)) return [];

        $ids = DB::table('language_course_unit')
            ->whereIn('id', $unitIds)
            ->pluck('configuracion_ui_ux_id')
            ->map(fn($v) => (int)$v)
            ->unique()
            ->values()
            ->all();

        return self::getUiUxByIds($ids);
    }

    /**
     * ✅ CAMBIO: antes pluck desde 'unidad_seccion'
     */
    private static function getUiUxForSections(array $sectionIds): array
    {
        if (empty($sectionIds)) return [];

        $ids = DB::table('language_course_unit_section')
            ->whereIn('id', $sectionIds)
            ->pluck('configuracion_ui_ux_id')
            ->map(fn($v) => (int)$v)
            ->unique()
            ->values()
            ->all();

        return self::getUiUxByIds($ids);
    }

    /**
     * ✅ CAMBIO: items en vez de data
     */
    private static function getUiUxForItems(array $items): array
    {
        if (empty($items)) return [];

        $ids = [];
        foreach ($items as $it) {
            $ids[] = (int)$it['configuracion_ui_ux_id'];
        }
        $ids = array_values(array_unique(array_filter($ids)));

        return self::getUiUxByIds($ids);
    }

    private static function getUiUxByIds(array $ids): array
    {
        if (empty($ids)) return [];

        return DB::table('configuracion_ui_ux')
            ->select(['id','value','description','status','flutter_config','web_config'])
            ->whereIn('id', $ids)
            ->orderBy('id')
            ->get()
            ->map(function ($r) {
                $arr = (array)$r;

                $arr['flutter_config'] = self::castJson($arr['flutter_config']);
                $arr['web_config'] = self::castJson($arr['web_config']);

                return $arr;
            })
            ->all();
    }

    private static function castJson($value): array
    {
        if (is_array($value)) return $value;
        if (is_object($value)) return (array)$value;

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    // =========================================================
    // Utils
    // =========================================================

    private static function indexById(array $rows): array
    {
        $out = [];
        foreach ($rows as $r) {
            $out[(int)$r['id']] = $r;
        }
        return $out;
    }
}
