<?php

namespace App\Support\Dictionary;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DictionaryCountsNumbersUtil
{
    /**
     * Devuelve el payload completo para:
     * - scopes (rangos/ámbitos)
     * - contexts (contextos + allowed scopes)
     * - numbers (números + pronunciaciones por notation_type)
     */
    public static function payload(bool $useCache = true): array
    {
        $cacheKey = 'dictionary:counts_numbers:v1';

        if ($useCache) {
            return Cache::remember($cacheKey, now()->addHours(24), function () {
                return self::buildPayload();
            });
        }

        return self::buildPayload();
    }

    /**
     * Limpia cache (útil si actualizas tablas desde panel admin).
     */
    public static function forgetCache(): void
    {
        Cache::forget('dictionary:counts_numbers:v1');
    }

    private static function buildPayload(): array
    {
        return [
            'meta' => [
                'generated_at' => now()->toIso8601String(),
                'source' => 'dictionary_counts_and_numbers',
                'version' => 1,
            ],
            'scopes' => self::getScopes(),
            'contexts' => self::getContexts(),
            'numbers' => self::getNumbers(),
        ];
    }

    private static function getScopes(): array
    {
        return DB::table('dictionary_by_count_scope')
            ->select([
                'id',
                'code',
                'title_es',
                'description_es',
                'min_value',
                'max_value',
                'is_active',
            ])
            ->where('is_active', 1)
            ->orderBy('id')
            ->get()
            ->map(fn($r) => [
                'id' => (int) $r->id,
                'code' => (string) $r->code,
                'title_es' => (string) $r->title_es,
                'description_es' => (string) $r->description_es,
                'min_value' => (int) $r->min_value,
                'max_value' => $r->max_value === null ? null : (int) $r->max_value,
                'is_active' => (int) $r->is_active,
            ])
            ->all();
    }

    private static function getContexts(): array
    {
        /**
         * MySQL 8+ soporta JSON_ARRAYAGG
         */
        $rows = DB::table('dictionary_by_count_context as c')
            ->leftJoin('dictionary_by_count_context_scope as cs', 'cs.context_id', '=', 'c.id')
            ->selectRaw("
                c.id,
                c.code,
                c.title_es,
                c.description_es,
                c.default_scope_id,
                c.is_active,
                COALESCE(JSON_ARRAYAGG(cs.scope_id), JSON_ARRAY()) as allowed_scopes_json
            ")
            ->where('c.is_active', 1)
            ->groupBy('c.id', 'c.code', 'c.title_es', 'c.description_es', 'c.default_scope_id', 'c.is_active')
            ->orderBy('c.id')
            ->get();

        return $rows->map(function ($r) {
            $allowed = json_decode($r->allowed_scopes_json ?? '[]', true) ?: [];
            // JSON_ARRAYAGG puede traer null si no hubo join: filtramos
            $allowed = array_values(array_filter($allowed, fn($v) => $v !== null));

            return [
                'id' => (int) $r->id,
                'code' => (string) $r->code,
                'title_es' => (string) $r->title_es,
                'description_es' => (string) $r->description_es,
                'default_scope_id' => $r->default_scope_id === null ? null : (int) $r->default_scope_id,
                'is_active' => (int) $r->is_active,
                'allowed_scopes' => array_map('intval', $allowed),
            ];
        })->all();
    }

    private static function getNumbers(): array
    {
        /**
         * MySQL 8+ soporta JSON_OBJECTAGG.
         * Genera pron como objeto: { "custom":"...", "ipa":"...", ... }
         */
        $rows = DB::table('dictionary_by_numbers_kichwa as n')
            ->leftJoin('dictionary_by_numbers_kichwa_pronunciation as p', 'p.number_id', '=', 'n.id')
            ->selectRaw("
                n.number_value,
                n.id,
                n.kichwa_word,
                n.spanish_word,
                n.is_base,
                n.notes,
                COALESCE(
                  JSON_OBJECTAGG(p.notation_type, p.phonetic_value),
                  JSON_OBJECT()
                ) as pron_json
            ")
            ->groupBy('n.id', 'n.number_value', 'n.kichwa_word', 'n.spanish_word', 'n.is_base', 'n.notes')
            ->orderBy('n.number_value')
            ->get();

        return $rows->map(function ($r) {
            $pron = json_decode($r->pron_json ?? '{}', true) ?: [];

            return [
                'number_value' => (int) $r->number_value,
                'id' => (int) $r->id,
                'kichwa_word' => (string) $r->kichwa_word,
                'spanish_word' => $r->spanish_word === null ? null : (string) $r->spanish_word,
                'is_base' => (int) $r->is_base,
                'notes' => $r->notes === null ? null : (string) $r->notes,
                'pron' => $pron,
            ];
        })->all();
    }
}
