<?php

declare(strict_types=1);

namespace App\Support\Dictionary;

final class DictionaryGrammaticalClassIds
{
    // =========================
    // CORE (para vocabulario)
    // =========================
    public const SUSTANTIVO = 1;
    public const VERBO = 2;
    public const ADJETIVO = 3;
    public const ADVERBIO = 4;
    public const PRONOMBRE = 5;
    public const ARTICULO = 6;
    public const PREPOSICION = 7;
    public const CONJUNCION = 8;
    public const INTERJECCION = 9;
    public const DETERMINANTE = 10;
    public const NUMERAL = 11;
    public const PARTICULA = 12;
    public const AUXILIAR_VERBAL = 13;

    public const CORE_IDS = [
        self::SUSTANTIVO,
        self::VERBO,
        self::ADJETIVO,
        self::ADVERBIO,
        self::PRONOMBRE,
        self::ARTICULO,
        self::PREPOSICION,
        self::CONJUNCION,
        self::INTERJECCION,
        self::DETERMINANTE,
        self::NUMERAL,
        self::PARTICULA,
        self::AUXILIAR_VERBAL,
    ];

    // =========================
    // CATEGORY MAP (según tu enum)
    // grammatical | functional | toponym | symbol | org
    // =========================
    public const BY_CATEGORY = [
        'grammatical' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'functional'  => [14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35],
        'toponym'     => [36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58],
        'symbol'      => [59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87],
        'org'         => [88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117],
    ];

    /**
     * Para validar/normalizar IDs recibidos.
     */
    public static function normalizeIds(int|array|null $ids): array
    {
        if ($ids === null) return [];

        $arr = is_array($ids) ? $ids : [$ids];
        $out = [];

        foreach ($arr as $id) {
            $id = (int)$id;
            if ($id <= 0) continue;
            $out[] = $id;
        }

        $out = array_values(array_unique($out));
        sort($out);
        return $out;
    }

    /**
     * Retorna IDs por categoría, si existe.
     */
    public static function idsByCategory(?string $category): array
    {
        if (!$category) return [];
        $category = trim($category);
        return self::BY_CATEGORY[$category] ?? [];
    }
}
