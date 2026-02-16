<?php

declare(strict_types=1);

namespace App\Support\Dictionary;


use Illuminate\Support\Facades\DB;

final class DictionaryMorphemeCatalog
{
    /**
     * Retorna el payload listo para JS (array de objetos).
     *
     * @param  bool        $includeInactive  si false, solo ACTIVE
     * @param  int|null    $morphemeId       filtra por morpheme_id
     * @param  string|null $functionCode     filtra por function_code exacto
     */
    public static function morphemeFunctionsPayload(
        bool $includeInactive = false,
        ?int $morphemeId = null,
        ?string $functionCode = null
    ): array {
        $q = DB::table('dictionary_morpheme_function as mf')
            ->join('dictionary_morpheme as m', 'm.id', '=', 'mf.morpheme_id')
            ->select([
                'mf.id',
                'mf.morpheme_id',
                'm.form as morpheme_form',
                'mf.function_code',
                'mf.description_es',
                'mf.what_is_es',
                'mf.for_what_es',
                'mf.formula_es',
                'mf.use_es',
                'mf.constraints_json',
                'mf.display_order',
                'mf.status',
            ])
            ->orderBy('mf.display_order')
            ->orderBy('mf.id');

        if (!$includeInactive) {
            $q->where('mf.status', 'ACTIVE');
        }

        if ($morphemeId !== null) {
            $q->where('mf.morpheme_id', $morphemeId);
        }

        if ($functionCode !== null && $functionCode !== '') {
            $q->where('mf.function_code', $functionCode);
        }

        $rows = $q->get();

        // Mapea a la forma exacta que necesitas para JS
        return $rows->map(static function ($r): array {
            // constraints_json puede venir como string JSON o null según driver
            $constraints = null;
            if ($r->constraints_json !== null) {
                $constraints = is_string($r->constraints_json)
                    ? json_decode($r->constraints_json, true)
                    : (array) $r->constraints_json;
            }

            return [
                'id' => (int) $r->id,
                'morpheme_id' => (int) $r->morpheme_id,
                'morpheme_form' => (string) $r->morpheme_form, // ej: "-wa-"
                'function_code' => (string) $r->function_code,
                'description_es' => (string) $r->description_es,
                'card' => [
                    'what_is_es'  => $r->what_is_es !== null ? (string) $r->what_is_es : '',
                    'for_what_es' => $r->for_what_es !== null ? (string) $r->for_what_es : '',
                    'formula_es'  => $r->formula_es !== null ? (string) $r->formula_es : '',
                    'use_es'      => $r->use_es !== null ? (string) $r->use_es : '',
                ],
                'constraints' => $constraints, // null o array
                'display_order' => (int) $r->display_order,
                'status' => (string) $r->status,
            ];
        })->all();
    }

    /**
     * Helper: devuelve JSON ya listo para front (con flags para unicode).
     */
    public static function morphemeFunctionsPayloadJson(
        bool $includeInactive = false,
        ?int $morphemeId = null,
        ?string $functionCode = null
    ): string {
        $payload = self::morphemeFunctionsPayload($includeInactive, $morphemeId, $functionCode);

        return json_encode(
            $payload,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        ) ?: '[]';
    }
}
