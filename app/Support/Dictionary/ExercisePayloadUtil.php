<?php

declare(strict_types=1);

namespace App\Support\Dictionary;

use Illuminate\Support\Facades\DB;

final class ExercisePayloadUtil
{
    /**
     * Genera payload para Front (como el formato de tus BLOCKS).
     *
     * - Si NO envías language_course_unit_id / language_course_unit_section_id => retorna TODO.
     *
     * Options:
     * - language_course_unit_id (int|null)
     * - language_course_unit_section_id (int|null)
     * - include_inactive (bool) default false
     * - output (string) 'array'|'js' default 'array'
     * - block_prefix (string) default 'BLOCK_'
     */
    public static function buildBlocks(array $options = []): array|string
    {

        $includeInactive = (bool)($options['include_inactive'] ?? false);

        $unitId = array_key_exists('language_course_unit_id', $options) && $options['language_course_unit_id'] !== null
            ? (int)$options['language_course_unit_id']
            : null;

        $unitSectionId = array_key_exists('language_course_unit_section_id', $options) && $options['language_course_unit_section_id'] !== null
            ? (int)$options['language_course_unit_section_id']
            : null;

        $output = (string)($options['output'] ?? 'array');

        // 1) Steps (sin filtros si unitId/sectionId son null)
        $steps = self::getSteps($includeInactive, $unitId, $unitSectionId);

        if (!$steps) {
            $emptyBlocks = [];
            return $output === 'js'
                ? self::toJsConstants($emptyBlocks, $options)
                : self::wrapMeta($emptyBlocks);
        }

        // 2) Exercises grouped by step_id
        $stepIds = array_values(array_unique(array_map(fn($s) => (int)$s['id'], $steps)));
        $exercisesByStep = self::getExercisesByStepIds($stepIds);

        // 3) Collect exercise ids
        $exerciseIds = [];
        foreach ($exercisesByStep as $byStep) {
            foreach ($byStep as $ex) $exerciseIds[] = (int)$ex['id'];
        }
        $exerciseIds = array_values(array_unique($exerciseIds));

        // 4) Preload terms/hotspots for fallback payload building
        $termsByExercise = $exerciseIds ? self::getTermsByExerciseIds($exerciseIds) : [];
        $hotspotsByExercise = $exerciseIds ? self::getHotspotsByExerciseIds($exerciseIds) : [];

        // 5) Build flat list steps (front format)
        $flatSteps = [];
        foreach ($steps as $step) {
            $sid = (int)$step['id'];
            $stepExercises = $exercisesByStep[$sid] ?? [];

            // no exercise => send step alone
            if (!$stepExercises) {
                $flatSteps[] = self::mapStep($step, null, [], []);
                continue;
            }

            // N exercises supported
            foreach ($stepExercises as $ex) {
                $eid = (int)$ex['id'];
                $flatSteps[] = self::mapStep(
                    $step,
                    $ex,
                    $termsByExercise[$eid] ?? [],
                    $hotspotsByExercise[$eid] ?? []
                );
            }
        }

        // 6) Group into blocks (unit->section->block title)
        $blocks = self::groupIntoBlocks($flatSteps);

        // 7) Output
        if ($output === 'js') {
            return self::toJsConstants($blocks, $options);
        }

        return self::wrapMeta($blocks);
    }

    // =========================================================
    // DB READERS
    // =========================================================

    /**
     * Reads from: language_exercise_step (tabla nueva que creamos).
     * Si unitId/unitSectionId son null => NO filtra => retorna todo.
     */
    private static function getSteps(bool $includeInactive, ?int $unitId, ?int $unitSectionId): array
    {
        $q = DB::table('language_exercise_step as s')
            ->leftJoin('language_course_unit as u', 'u.id', '=', 's.language_course_unit_id')
            ->leftJoin('language_course_unit_section as sec', 'sec.id', '=', 's.language_course_unit_section_id')
            ->leftJoin('language_course_unit_section_item as i', 'i.id', '=', 's.language_course_unit_section_item_id')

            // UI/UX (si tu tabla se llama diferente, ajusta)
            ->leftJoin('configuracion_ui_ux as ui_step', 'ui_step.id', '=', 's.configuracion_ui_ux_id')
            ->leftJoin('configuracion_ui_ux as ui_unit', 'ui_unit.id', '=', 'u.configuracion_ui_ux_id')
            ->leftJoin('configuracion_ui_ux as ui_sec', 'ui_sec.id', '=', 'sec.configuracion_ui_ux_id')
            ->leftJoin('configuracion_ui_ux as ui_item', 'ui_item.id', '=', 'i.configuracion_ui_ux_id')

            ->select([
                // ====== LO QUE YA TENÍAS (NO SE OMITE) ======
                's.id',
                's.id as exercise_lvl_one_id',

                's.step_code',
                's.language_course_unit_id',
                's.language_course_unit_section_id',
                's.configuracion_ui_ux_id',
                's.title',
                's.activity_label',
                's.description',
                's.status',
                's.weight',
                's.source',
                's.language_course_unit_section_item_id',

                // ====== RELACIONES EXTRA ======
                // Unit
                'u.id as unit_lvl_one_id',
                'u.value as unit_lvl_one',

                'u.value as unit_value',
                'u.subtitle as unit_subtitle',
                'u.description as unit_description',
                'u.status as unit_status',
                'u.weight as unit_weight',
                'u.configuracion_ui_ux_id as unit_uiux_id',

                // Section
                'sec.id as unit_lvl_two_id',
                'sec.title as unit_lvl_two',

                'sec.section_type as section_type',
                'sec.title as section_title',
                'sec.subtitle as section_subtitle',
                'sec.description as section_description',
                'sec.status as section_status',
                'sec.weight as section_weight',
                'sec.source as section_source',
                'sec.configuracion_ui_ux_id as section_uiux_id',

                // Item
                'i.id as unit_lvl_three_id',
                'i.title as unit_lvl_three',
                'i.item_kind as item_kind',
                'i.title as item_title',
                'i.subtitle as item_subtitle',
                'i.description as item_description',
                'i.status as item_status',
                'i.weight as item_weight',
                'i.source as item_source',
                'i.configuracion_ui_ux_id as item_uiux_id',

                // UI/UX rows (solo IDs y value/description por ahora)
                'ui_step.value as ui_step_value',
                'ui_step.description as ui_step_description',

                'ui_unit.value as ui_unit_value',
                'ui_unit.description as ui_unit_description',

                'ui_sec.value as ui_section_value',
                'ui_sec.description as ui_section_description',

                'ui_item.value as ui_item_value',
                'ui_item.description as ui_item_description',
            ])
            ->orderBy('s.language_course_unit_id')
            ->orderBy('s.language_course_unit_section_id')
            ->orderBy('s.weight')
            ->orderBy('s.id');

        if (!$includeInactive) {
            $q->where('s.status', 'ACTIVE');
        }

        if ($unitId !== null) {
            $q->where('s.language_course_unit_id', $unitId);
        }

        if ($unitSectionId !== null) {
            $q->where('s.language_course_unit_section_id', $unitSectionId);
        }

        $rows = $q->get();

        return $rows->map(function ($r) {
            $r = (array)$r;

            // Estructura anidada (más limpia para frontend)
            return [
                // Step (igual que tu select base)
                'id' => $r['id'],
                'exercise_lvl_one_id' => $r['exercise_lvl_one_id'],

                'step_code' => $r['step_code'],
                'language_course_unit_id' => $r['language_course_unit_id'],
                'language_course_unit_section_id' => $r['language_course_unit_section_id'],
                'language_course_unit_section_item_id' => $r['language_course_unit_section_item_id'],
                'configuracion_ui_ux_id' => $r['configuracion_ui_ux_id'],
                'title' => $r['title'],
                'activity_label' => $r['activity_label'],
                'description' => $r['description'],
                'status' => $r['status'],
                'weight' => $r['weight'],
                'source' => $r['source'],

                // Unit relation
                'unit' => [
                    'id' => $r['language_course_unit_id'],
                    'unit_lvl_one_id' => $r['unit_lvl_one_id'],
                    'unit_lvl_one' => $r['unit_lvl_one'],

                    'value' => $r['unit_value'],
                    'subtitle' => $r['unit_subtitle'],
                    'description' => $r['unit_description'],
                    'status' => $r['unit_status'],
                    'weight' => $r['unit_weight'],
                    'configuracion_ui_ux_id' => $r['unit_uiux_id'],
                    'ui_ux' => $r['unit_uiux_id'] ? [
                        'id' => $r['unit_uiux_id'],
                        'value' => $r['ui_unit_value'],
                        'description' => $r['ui_unit_description'],
                    ] : null,
                ],

                // Section relation
                'section' => [
                    'id' => $r['language_course_unit_section_id'],
                    'unit_lvl_two_id' => $r['unit_lvl_two_id'],
                    'unit_lvl_two' => $r['unit_lvl_two'],
                    'section_type' => $r['section_type'],
                    'title' => $r['section_title'],
                    'subtitle' => $r['section_subtitle'],
                    'description' => $r['section_description'],
                    'status' => $r['section_status'],
                    'weight' => $r['section_weight'],
                    'source' => $r['section_source'],
                    'configuracion_ui_ux_id' => $r['section_uiux_id'],
                    'ui_ux' => $r['section_uiux_id'] ? [
                        'id' => $r['section_uiux_id'],
                        'value' => $r['ui_section_value'],
                        'description' => $r['ui_section_description'],
                    ] : null,
                ],

                // Item relation (puede ser null)
                'item' => $r['language_course_unit_section_item_id'] ? [
                    'id' => $r['language_course_unit_section_item_id'],
                    'unit_lvl_three_id' => $r['unit_lvl_three_id'],
                    'unit_lvl_three' => $r['unit_lvl_three'],
                    'item_kind' => $r['item_kind'],
                    'title' => $r['item_title'],
                    'subtitle' => $r['item_subtitle'],
                    'description' => $r['item_description'],
                    'status' => $r['item_status'],
                    'weight' => $r['item_weight'],
                    'source' => $r['item_source'],
                    'configuracion_ui_ux_id' => $r['item_uiux_id'],
                    'ui_ux' => $r['item_uiux_id'] ? [
                        'id' => $r['item_uiux_id'],
                        'value' => $r['ui_item_value'],
                        'description' => $r['ui_item_description'],
                    ] : null,
                ] : null,

                // UI/UX directo del step
                'ui_ux' => $r['configuracion_ui_ux_id'] ? [
                    'id' => $r['configuracion_ui_ux_id'],
                    'value' => $r['ui_step_value'],
                    'description' => $r['ui_step_description'],
                ] : null,
            ];
        })->all();
    }


    private static function getExercisesByStepIds(array $stepIds): array
    {
        $rows = DB::table('language_exercise as e')
            ->select([
                'e.id',
                'e.id as exercise_lvl_two_id',
                'e.step_id',
                'e.exercise_code',
                'e.type',
                'e.title',
                'e.prompt',
                'e.payload_json',
            ])
            ->whereIn('e.step_id', $stepIds)
            ->orderBy('e.step_id')
            ->orderBy('e.id')
            ->get()
            ->map(fn($r) => (array)$r)
            ->all();

        $byStep = [];
        foreach ($rows as $r) {
            $byStep[(int)$r['step_id']][] = $r;
        }
        return $byStep;
    }

    private static function getTermsByExerciseIds(array $exerciseIds): array
    {
        $rows = DB::table('language_exercise_term as t')
            ->select([
                't.id',
                't.id as exercise_lvl_three_id',
                't.exercise_id',
                't.exercise_id as exercise_lvl_two_id',
                't.role',
                't.term_side',
                't.group_index',
                't.sort_order',
                't.dictionary_word_id',
                't.text_value',
                't.is_correct',
                't.image_url',
                't.extra_json',
            ])
            ->whereIn('t.exercise_id', $exerciseIds)
            ->orderBy('t.exercise_id')
            ->orderBy('t.group_index')
            ->orderBy('t.sort_order')
            ->orderBy('t.id')
            ->get()
            ->map(fn($r) => (array)$r)
            ->all();

        $byEx = [];
        foreach ($rows as $r) {
            $byEx[(int)$r['exercise_id']][] = $r;
        }
        return $byEx;
    }

    private static function getHotspotsByExerciseIds(array $exerciseIds): array
    {
        $rows = DB::table('language_exercise_hotspot as h')
            ->select([
                'h.id',
                'h.exercise_id',
                'h.hotspot_code',
                'h.x_pct',
                'h.y_pct',
                'h.radius_pct',
                'h.label',
                'h.dictionary_word_id',
                'h.is_correct',
                'h.sort_order',
            ])
            ->whereIn('h.exercise_id', $exerciseIds)
            ->orderBy('h.exercise_id')
            ->orderBy('h.sort_order')
            ->orderBy('h.id')
            ->get()
            ->map(fn($r) => (array)$r)
            ->all();

        $byEx = [];
        foreach ($rows as $r) {
            $byEx[(int)$r['exercise_id']][] = $r;
        }
        return $byEx;
    }

    // =========================================================
    // MAPPERS
    // =========================================================

    private static function mapStep(array $step, ?array $exercise, array $terms, array $hotspots): array
    {

        $out = [
            'step_id' => (string)$step['step_code'],
            'unit_lvl_one_id' => $step["unit"]['unit_lvl_one_id'],
            'unit_lvl_two_id' => $step["section"]['unit_lvl_two_id'],
            'unit_lvl_three_id' => $step["item"]['unit_lvl_three_id'],
            'unit_lvl_one' => $step["unit"]['unit_lvl_one'],
            'unit_lvl_two' => $step["section"]['unit_lvl_two'],
            'unit_lvl_three' => $step["item"]['unit_lvl_three'],



            'unidad_seccion_id' => (int)$step['language_course_unit_section_id'],
            'unidad_id' => (int)$step['language_course_unit_id'],
            'configuracion_ui_ux_id' => (int)$step['configuracion_ui_ux_id'],
            'language_course_unit_section_item_id' => $step['language_course_unit_section_item_id'],
            'title' => (string)$step['title'],
            'activity' => (string)$step['activity_label'],
            'description' => (string)$step['activity_label'],
            'status' => (string)$step['status'],
            'weight' => (int)$step['weight'],
            'source' => (string)($step['source'] ?? ''),
        ];

        if (!$exercise) return $out;

        $payload = self::resolvePayload($exercise, $terms, $hotspots, $step);

        $out['exercise'] = [
            'exercise_id' => (string)$exercise['exercise_code'],
            'type' => (string)$exercise['type'],
            'title' => (string)$exercise['title'],
            'prompt' => (string)($exercise['prompt'] ?? ''),
            'payload' => $payload,
        ];

        return $out;
    }

    /**
     * Source of truth:
     *  - if payload_json exists => return it (most faithful, scalable for new types)
     *  - else fallback to build from terms/hotspots
     */
    private static function resolvePayload(array $exercise, array $terms, array $hotspots, array $step): array
    {
        $payloadJson = $exercise['payload_json'] ?? null;

        if ($payloadJson !== null) {
            if (is_string($payloadJson)) {
                $decoded = json_decode($payloadJson, true);
                return is_array($decoded) ? $decoded : [];
            }
            if (is_array($payloadJson)) {
                return $payloadJson;
            }
        }

        $type = (string)$exercise['type'];

        return match ($type) {
            'DRAG_MATCH' => self::payloadDragMatch($terms),
            'FILL_BLANK' => self::payloadFillBlank($terms),
            'HAYSTACK_PICK' => self::payloadHaystackPick($terms),
            'MULTI_SELECT', 'MULTI_SELECT_IMAGE' => self::payloadMultiSelect($terms, $type),
            'ORDER_WORDS' => self::payloadOrderWords($terms),
            'IMAGE_HOTSPOT_PICK' => self::payloadImageHotspotPick($hotspots, $step),
            default => [], // new type: if no payload_json, we can't rebuild
        };
    }

    // ===== Type builders (fallback) =====

    private static function payloadDragMatch(array $terms): array
    {
        // expects: role LEFT/RIGHT, same group_index
        $left = [];
        $right = [];

        foreach ($terms as $t) {
            $gi = (int)($t['group_index'] ?? 0);
            if (($t['role'] ?? '') === 'LEFT') $left[$gi] = (string)$t['text_value'];
            if (($t['role'] ?? '') === 'RIGHT') $right[$gi] = (string)$t['text_value'];
        }

        $pairs = [];
        $keys = array_unique(array_merge(array_keys($left), array_keys($right)));
        sort($keys);

        foreach ($keys as $k) {
            $pairs[] = [
                'left' => $left[$k] ?? '',
                'right' => $right[$k] ?? '',
            ];
        }

        return ['pairs' => $pairs];
    }

    private static function payloadFillBlank(array $terms): array
    {
        $text = '';
        $answer = '';
        $trim = true;
        $ignoreCase = true;

        foreach ($terms as $t) {
            if (($t['role'] ?? '') === 'TEXT') $text = (string)$t['text_value'];
            if (($t['role'] ?? '') === 'ANSWER') $answer = (string)$t['text_value'];

            $extra = self::decodeJson($t['extra_json'] ?? null);
            if (is_array($extra)) {
                if (array_key_exists('trim', $extra)) $trim = (bool)$extra['trim'];
                if (array_key_exists('ignoreCase', $extra)) $ignoreCase = (bool)$extra['ignoreCase'];
            }
        }

        return [
            'text' => $text,
            'answer' => $answer,
            'trim' => $trim,
            'ignoreCase' => $ignoreCase,
        ];
    }

    private static function payloadHaystackPick(array $terms): array
    {
        $question = ['es' => '', 'ki' => ''];
        $haystack = [];
        $correct = [];

        foreach ($terms as $t) {
            $role = (string)($t['role'] ?? '');

            if ($role === 'QUESTION') {
                $side = (string)($t['term_side'] ?? '');
                if ($side === 'SPANISH') $question['es'] = (string)$t['text_value'];
                if ($side === 'KICHWA') $question['ki'] = (string)$t['text_value'];
            }

            if ($role === 'WORD') {
                $haystack[] = (string)$t['text_value'];
                if ((int)($t['is_correct'] ?? 0) === 1) $correct[] = (string)$t['text_value'];
            }
        }

        return [
            'question' => $question,
            'haystack' => $haystack,
            'correct' => $correct,
        ];
    }

    private static function payloadMultiSelect(array $terms, string $type): array
    {
        $options = [];
        $correctIds = [];

        $image = '';
        $alt = '';
        $showImageFirst = true;

        foreach ($terms as $t) {
            $role = (string)($t['role'] ?? '');

            if ($role === 'OPTION') {
                $extra = self::decodeJson($t['extra_json'] ?? null);
                $optId = is_array($extra) && isset($extra['id']) ? (string)$extra['id'] : null;

                if (!$optId) {
                    // fallback a,b,c...
                    $optId = chr(ord('a') + max(0, (int)($t['sort_order'] ?? 0)));
                }

                $options[] = [
                    'id' => $optId,
                    'text' => (string)$t['text_value'],
                ];

                if ((int)($t['is_correct'] ?? 0) === 1) $correctIds[] = $optId;
            }

            // for image type (fallback only)
            if ($type === 'MULTI_SELECT_IMAGE') {
                if (!empty($t['image_url'])) $image = (string)$t['image_url'];

                $extra = self::decodeJson($t['extra_json'] ?? null);
                if (is_array($extra)) {
                    if (isset($extra['alt'])) $alt = (string)$extra['alt'];
                    if (isset($extra['showImageFirst'])) $showImageFirst = (bool)$extra['showImageFirst'];
                }
            }
        }

        $payload = [
            'options' => $options,
            'correctIds' => $correctIds,
        ];

        if ($type === 'MULTI_SELECT_IMAGE') {
            $payload['image'] = $image;
            $payload['alt'] = $alt;
            $payload['showImageFirst'] = $showImageFirst;
        }

        return $payload;
    }

    private static function payloadOrderWords(array $terms): array
    {
        $items = [];
        $correctOrder = [];

        foreach ($terms as $t) {
            if (($t['role'] ?? '') !== 'WORD') continue;

            $text = (string)$t['text_value'];
            $items[] = $text;

            $extra = self::decodeJson($t['extra_json'] ?? null);
            if (is_array($extra) && isset($extra['correctOrderIndex'])) {
                $idx = (int)$extra['correctOrderIndex'];
                $correctOrder[$idx] = $text;
            }
        }

        ksort($correctOrder);
        $correctOrder = array_values($correctOrder);

        return [
            'correctOrder' => $correctOrder,
            'items' => $items,
        ];
    }

    private static function payloadImageHotspotPick(array $hotspots, array $step): array
    {
        $hs = [];
        foreach ($hotspots as $h) {
            $hs[] = [
                'id' => (string)$h['hotspot_code'],
                'xPct' => (float)$h['x_pct'],
                'yPct' => (float)$h['y_pct'],
                'label' => (string)($h['label'] ?? ''),
                'isCorrect' => (bool)$h['is_correct'],
            ];
        }

        // image usually lives in payload_json; fallback uses step.source
        return [
            'image' => (string)($step['source'] ?? ''),
            'mode' => 'MULTI',
            'maxPick' => null,
            'showLabels' => true,
            'hotspots' => $hs,
        ];
    }

    // =========================================================
    // GROUPING (unit -> section -> blocks) + OUTPUT
    // =========================================================

    /**
     * Returns:
     * [
     *   [
     *     'language_course_unit_id' => 1,
     *     'language_course_unit_section_id' => 1,
     *     'block_title' => 'RIKISIRISHUN-PRESENTACION',
     *     'steps' => [ ... ],
     *   ],
     *   ...
     * ]
     */
    private static function groupIntoBlocks(array $flatSteps): array
    {
        $groups = [];

        foreach ($flatSteps as $s) {
            $blockTitle = self::normalizeBlockTitle((string)($s['title'] ?? ''));

            $key = (int)$s['unidad_id'].'-'.(int)$s['unidad_seccion_id'].'-'.$blockTitle;

            if (!isset($groups[$key])) {
                $groups[$key] = [
                    'language_course_unit_id' => (int)$s['unidad_id'],
                    'unit_lvl_one' =>$s['unit_lvl_one'],
                    'unit_lvl_two' => $s["unit_lvl_two"],
                    'unit_lvl_three' => $s["unit_lvl_three"],
                    'unit_lvl_one_id' =>$s['unit_lvl_one_id'],
                    'unit_lvl_two_id' => $s["unit_lvl_two_id"],
                    'unit_lvl_three_id' => $s["unit_lvl_three_id"],
                    'language_course_unit_section_id' => (int)$s['unidad_seccion_id'],
                    'block_title' => $blockTitle,
                    'steps' => [],
                ];

            }

            $groups[$key]['steps'][] = $s;

        }

        $list = array_values($groups);

        usort($list, function($a, $b) {
            return [$a['language_course_unit_id'], $a['language_course_unit_section_id'], $a['block_title']]
                <=> [$b['language_course_unit_id'], $b['language_course_unit_section_id'], $b['block_title']];
        });

        return $list;
    }

    private static function normalizeBlockTitle(string $title): string
    {
        $t = trim($title);
        if ($t === '') return '';

        // Split by bullet "•"
        $parts = preg_split('/\s*•\s*/u', $t);
        if ($parts && count($parts) > 1) {
            return trim($parts[0]);
        }

        // fallback: remove trailing " 01" like patterns (optional)
        return $t;
    }

    private static function wrapMeta(array $blocks): array
    {
        return [
            'meta' => [
                'generated_at' => now()->toIso8601String(),
                'source' => 'language_exercises',
                'version' => 1,
            ],
            'blocks' => $blocks,
        ];
    }

    /**
     * JS output:
     * const BLOCK_1 = [...steps...];
     * const BLOCK_2 = [...steps...];
     */
    private static function toJsConstants(array $blocks, array $options): string
    {
        $prefix = (string)($options['block_prefix'] ?? 'BLOCK_');

        $lines = [];
        $lines[] = "// Auto-generated at: ".now()->toIso8601String();
        $lines[] = "";

        $i = 1;
        foreach ($blocks as $b) {
            $constName = $prefix.$i;

            $json = json_encode(
                $b['steps'] ?? [],
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            );

            $lines[] = "const {$constName} = {$json};";
            $lines[] = "";
            $i++;
        }

        return implode("\n", $lines);
    }

    private static function decodeJson(mixed $value): mixed
    {
        if ($value === null) return null;
        if (is_array($value)) return $value;
        if (!is_string($value) || trim($value) === '') return null;

        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : null;
    }
}
