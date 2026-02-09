<?php

declare(strict_types=1);

namespace App\Support\Dictionary;


use Illuminate\Support\Facades\DB;

final class PronunciationPayloadUtil
{
    /**
     * Payload completo para Front (JS) para generar pronunciación por reglas.
     *
     * Options:
     *  - include_inactive (bool) default false
     *  - nest_variants (bool) default true  -> phonemes[].variants[]
     */
    public static function buildPayload(array $options = []): array
    {
        $includeInactive = (bool)($options['include_inactive'] ?? false);
        $nestVariants = (bool)($options['nest_variants'] ?? true);

        $phonemes = self::getPhonemes($includeInactive);

        $variants = self::getPhonemeVariants($includeInactive);

        if ($nestVariants) {
            $byPhonemeId = [];
            foreach ($variants as $v) {
                $byPhonemeId[(int)$v['phoneme_id']][] = $v;
            }
            foreach ($phonemes as &$p) {
                $p['variants'] = $byPhonemeId[(int)$p['id']] ?? [];
            }
            unset($p);
        }

        return [
            'meta' => [
                'generated_at' => now()->toIso8601String(),
                'source' => 'dictionary_pronunciation_rules',
                'version' => 1,
                'include_inactive' => $includeInactive,
                'nest_variants' => $nestVariants,
            ],
            'pronunciation_types' => self::getPronunciationTypes($includeInactive),
            'pronunciation_variant_types' => self::getPronunciationVariantTypes($includeInactive),
            'writing_conventions' => self::getWritingConventions($includeInactive),

            // si nest_variants=true, aquí ya vienen dentro
            'phonemes' => $phonemes,
            // si nest_variants=false, se envían aparte
            'phoneme_variants' => $nestVariants ? [] : $variants,

            'syllable_structures' => self::getSyllableStructures($includeInactive),
            'sporadic_phenomena' => self::getSporadicPhenomena($includeInactive),
            'phonology_rules' => self::getPhonologyRulesWithItems($includeInactive),
            'toponyms' => self::getToponyms($includeInactive),
        ];
    }

    private static function getPronunciationTypes(bool $includeInactive): array
    {
        $q = DB::table('dictionary_pronunciation_type')
            ->select(['id', 'code', 'name_es', 'description_es', 'is_active', 'sort_order'])
            ->orderBy('sort_order');

        if (!$includeInactive) $q->where('is_active', 1);

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    private static function getPronunciationVariantTypes(bool $includeInactive): array
    {
        $q = DB::table('dictionary_pronunciation_variant_type')
            ->select(['id', 'code', 'name_es', 'description_es', 'is_active', 'sort_order'])
            ->orderBy('sort_order');

        if (!$includeInactive) $q->where('is_active', 1);

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    private static function getWritingConventions(bool $includeInactive): array
    {
        $q = DB::table('dictionary_writing_convention')
            ->select(['id', 'symbol', 'maps_to_grapheme', 'description_es', 'source_note', 'is_active'])
            ->orderBy('id');

        if (!$includeInactive) $q->where('is_active', 1);

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    private static function getPhonemes(bool $includeInactive): array
    {
        $q = DB::table('dictionary_phoneme')
            ->select(['id','phoneme','category','origin','notes_es','is_active','token_priority'])
            ->orderByDesc('token_priority')
            ->orderByDesc(DB::raw('CHAR_LENGTH(phoneme)'))
            ->orderBy('phoneme')
            ->orderBy('origin')
            ->orderBy('category');

        if (!$includeInactive) $q->where('is_active', 1);

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    private static function getPhonemeVariants(bool $includeInactive): array
    {
        $q = DB::table('dictionary_phoneme_variant')
            ->select([
                'id','phoneme_id','variant',
                'pronunciation_type_code','variant_type_code',
                'example_ipa','example_writing','notes_es',
                'is_active','sort_order'
            ])
            ->orderBy('phoneme_id')
            ->orderBy('sort_order')
            ->orderBy('id');

        if (!$includeInactive) $q->where('is_active', 1);

        return $q->get()->map(fn($r) => (array)$r)->all();
    }
    private static function getSyllableStructures(bool $includeInactive): array
    {
        $q = DB::table('dictionary_syllable_structure')
            ->select(['id', 'code', 'description_es', 'examples_es', 'is_active', 'sort_order'])
            ->orderBy('sort_order');

        if (!$includeInactive) $q->where('is_active', 1);

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    private static function getSporadicPhenomena(bool $includeInactive): array
    {
        $q = DB::table('dictionary_sporadic_phenomenon')
            ->select(['id', 'code', 'name_es', 'description_es', 'is_active', 'sort_order'])
            ->orderBy('sort_order');

        if (!$includeInactive) $q->where('is_active', 1);

        return $q->get()->map(fn($r) => (array)$r)->all();
    }

    private static function getPhonologyRulesWithItems(bool $includeInactive): array
    {
        // ===== Rules =====
        $rq = DB::table('dictionary_phonology_rule as r')
            ->select([
                'r.id','r.code','r.title_es','r.description_es',
                'r.rule_type','r.output_type_code',
                'r.priority','r.is_active','r.source_ref'
            ])
            ->orderBy('r.priority')
            ->orderBy('r.id');

        if (!$includeInactive) $rq->where('r.is_active', 1);

        $rules = $rq->get()->map(fn($row) => (array)$row)->all();

        // ===== Items enriched (JOIN variants + phonemes + toponym) =====
        $iq = DB::table('dictionary_phonology_rule_item as it')
            ->leftJoin('dictionary_phoneme_variant as pv', 'pv.id', '=', 'it.pattern_variant_id')
            ->leftJoin('dictionary_phoneme_variant as rv', 'rv.id', '=', 'it.replacement_variant_id')
            ->leftJoin('dictionary_phoneme as pp', 'pp.id', '=', 'pv.phoneme_id')
            ->leftJoin('dictionary_phoneme as rp', 'rp.id', '=', 'rv.phoneme_id')
            ->leftJoin('dictionary_toponym as topo', 'topo.abbr', '=', 'it.toponym_abbr')
            ->select([
                'it.id',
                'it.rule_id',
                'it.toponym_abbr',
                'it.match_scope',
                'it.pattern_variant_id',
                'it.replacement_variant_id',
                'it.example_input',
                'it.example_output',
                'it.notes_es',
                'it.is_active',
                'it.sort_order',
                'it.apply_when_before',
                'it.apply_when_after',
                'it.is_optional',
                'it.weight',

                // ===== RESUELTO (valores reales) =====
                DB::raw('pv.variant as pattern_value'),
                DB::raw('pv.pronunciation_type_code as pattern_pronunciation_type_code'),
                DB::raw('pv.variant_type_code as pattern_variant_type_code'),
                DB::raw('pv.is_active as pattern_is_active'),
                DB::raw('pv.sort_order as pattern_sort_order'),

                DB::raw('rv.variant as replacement_value'),
                DB::raw('rv.pronunciation_type_code as replacement_pronunciation_type_code'),
                DB::raw('rv.variant_type_code as replacement_variant_type_code'),
                DB::raw('rv.is_active as replacement_is_active'),
                DB::raw('rv.sort_order as replacement_sort_order'),

                // ===== contexto (fonema base) =====
                DB::raw('pp.phoneme as pattern_phoneme'),
                DB::raw('pp.category as pattern_category'),
                DB::raw('pp.origin as pattern_origin'),

                DB::raw('rp.phoneme as replacement_phoneme'),
                DB::raw('rp.category as replacement_category'),
                DB::raw('rp.origin as replacement_origin'),

                // ===== toponym label (opcional, útil para front) =====
                DB::raw('topo.name_es as toponym_name_es'),
                DB::raw('topo.entity_type as toponym_entity_type'),
            ])
            ->orderBy('it.rule_id')
            ->orderBy('it.sort_order')
            ->orderBy('it.id');

        if (!$includeInactive) $iq->where('it.is_active', 1);

        $items = $iq->get()->map(fn($row) => (array)$row)->all();

        // ===== group by rule =====
        $itemsByRule = [];
        foreach ($items as $it) {
            $itemsByRule[(int)$it['rule_id']][] = $it;
        }

        foreach ($rules as &$r) {
            $r['items'] = $itemsByRule[(int)$r['id']] ?? [];
        }
        unset($r);

        return $rules;
    }

    private static function getToponyms(bool $includeInactive): array
    {
        $q = DB::table('dictionary_toponym')
            ->select(['id','abbr','name_es','entity_type','country_id','province_id','meaning_es','description','is_active','sort_order'])
            ->orderBy('sort_order')->orderBy('id');

        if (!$includeInactive) $q->where('is_active', 1);

        return $q->get()->map(fn($r) => (array)$r)->all();
    }
}
