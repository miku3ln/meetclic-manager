<?php

declare(strict_types=1);

namespace App\Support\Dictionary;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final class DictionaryPayloadUtil
{
    /**
     * Options:
     * - diccionary_language_id (int) REQUIRED   // 1 o 2
     * - class_ids (int|int[]|null) OPTIONAL     // uno o varios IDs
     * - include_inactive (bool) default false
     * - output (string) 'array'|'json' default 'array'
     * - pagination (array|null) ['page'=>1,'per_page'=>500] OPTIONAL
     */
    public static function buildWords(array $options = []): array|string
    {
        if (!array_key_exists('diccionary_language_id', $options) || $options['diccionary_language_id'] === null) {
            throw new InvalidArgumentException('diccionary_language_id is required');
        }

        $langId = (int)$options['diccionary_language_id'];
        if (!in_array($langId, [1, 2], true)) {
            throw new InvalidArgumentException('diccionary_language_id must be 1 or 2');
        }

        $includeInactive = (bool)($options['include_inactive'] ?? false);
        $output = (string)($options['output'] ?? 'array');

        $classIds = DictionaryGrammaticalClassIds::normalizeIds($options['class_ids'] ?? null);

        $pagination = is_array($options['pagination'] ?? null) ? $options['pagination'] : null;
        $page = max(1, (int)($pagination['page'] ?? 1));
        $perPage = max(0, (int)($pagination['per_page'] ?? 0));

        $q = DB::table('dictionary_by_words as w')
            // ✅ 1 palabra = 1 clase
            ->join('dictionary_word_by_class as wc', 'wc.dictionary_by_words_id', '=', 'w.id')
            ->join('dictionary_grammatical_class as gc', 'gc.id', '=', 'wc.dictionary_grammatical_class_id')
            // ✅ info del idioma (opcional pero útil)
            ->join('dictionary_language as dl', 'dl.id', '=', 'w.diccionary_language_id')

            ->select([
                // Word
                'w.id',
                'w.value',
                'w.description',
                'w.status',
                'w.diccionary_language_id',
                'w.translation_value',
                'w.phonetic',
                'w.usage_context',
                'w.letters_of_the_alphabet',

                // Word-Class bridge
                'wc.id as word_class_id',
                'wc.dictionary_grammatical_class_id as class_id',

                // Class details
                'gc.short_code as class_short_code',
                'gc.category as class_category',
                'gc.name as class_name',
                'gc.name_en as class_name_en',
                'gc.description as class_description',
                'gc.aliases as class_aliases',
                'gc.status as class_status',
                'gc.display_order as class_display_order',

                // Dictionary language details
                'dl.value as dictionary_language_value',
                'dl.description as dictionary_language_description',
                'dl.status as dictionary_language_status',
                'dl.from_language_id as dictionary_language_from_id',
                'dl.to_language_id as dictionary_language_to_id',
            ])
            ->where('w.diccionary_language_id', $langId)
            ->orderBy('w.letters_of_the_alphabet')
            ->orderBy('w.value')
            ->orderBy('w.id');

        if (!$includeInactive) {
            $q->where('w.status', 'ACTIVE');
        }

        if ($classIds) {
            $q->whereIn('wc.dictionary_grammatical_class_id', $classIds);
        }

        // pagination
        $total = null;
        if ($perPage > 0) {
            $countQ = clone $q;
            $total = (int)$countQ->count();

            $offset = max(0, ($page - 1) * $perPage);
            $rows = $q->offset($offset)->limit($perPage)->get();
        } else {
            $rows = $q->get();
        }

        $words = $rows->map(function ($r) {
            $r = (array)$r;

            // aliases viene como JSON string en tu tabla (longtext bin)
            $aliases = null;
            if (!empty($r['class_aliases']) && is_string($r['class_aliases'])) {
                $decoded = json_decode($r['class_aliases'], true);
                $aliases = is_array($decoded) ? $decoded : null;
            }

            return [
                'id' => (int)$r['id'],
                'value' => (string)$r['value'],
                'description' => $r['description'],
                'status' => (string)$r['status'],
                'diccionary_language_id' => (int)$r['diccionary_language_id'],
                'translation_value' => (string)$r['translation_value'],
                'phonetic' => (string)($r['phonetic'] ?? 'N/A'),
                'usage_context' => $r['usage_context'],
                'letters_of_the_alphabet' => (string)$r['letters_of_the_alphabet'],

                // ✅ clase completa
                'class' => [
                    'id' => (int)$r['class_id'],
                    'short_code' => (string)$r['class_short_code'],
                    'category' => (string)$r['class_category'],
                    'name' => (string)$r['class_name'],
                    'name_en' => $r['class_name_en'],
                    'description' => $r['class_description'],
                    'aliases' => $aliases,
                    'status' => (string)$r['class_status'],
                    'display_order' => (int)$r['class_display_order'],
                ],

                // ✅ info del par de idioma (dl)
                'dictionary_language' => [
                    'id' => (int)$r['diccionary_language_id'],
                    'value' => (string)$r['dictionary_language_value'],
                    'description' => $r['dictionary_language_description'],
                    'status' => (string)$r['dictionary_language_status'],
                    'from_language_id' => (int)$r['dictionary_language_from_id'],
                    'to_language_id' => (int)$r['dictionary_language_to_id'],
                ],
            ];
        })->all();

        $payload = self::wrapMeta($words, $langId, $classIds, $includeInactive, $total, $page, $perPage);

        if ($output === 'json') {
            return json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        return $payload;
    }

    private static function wrapMeta(
        array $words,
        int $langId,
        array $classIds,
        bool $includeInactive,
        ?int $total,
        int $page,
        int $perPage
    ): array {
        $meta = [
            'generated_at' => now()->toIso8601String(),
            'source' => 'dictionary_by_words + dictionary_word_by_class + dictionary_grammatical_class + dictionary_language',
            'version' => 3,
            'required' => [
                'diccionary_language_id' => $langId,
            ],
            'filters' => [
                'class_ids' => $classIds ?: null,
                'include_inactive' => $includeInactive,
            ],
        ];

        if ($perPage > 0) {
            $meta['pagination'] = [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total ?? count($words),
                'total_pages' => (int)ceil(($total ?? count($words)) / $perPage),
            ];
        }

        return [
            'meta' => $meta,
            'words' => $words,
        ];
    }
}
