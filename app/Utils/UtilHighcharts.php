<?php

namespace App\Utils;



use Grimzy\LaravelMysqlSpatial\Types\Point;

use App;
use Illuminate\Support\Carbon;

class UtilHighcharts
{
    public static function isValidCedulaEcuador(?string $doc): bool
    {
        $doc = preg_replace('/\D+/', '', (string)$doc); // solo dígitos

        if (strlen($doc) !== 10) return false;

        $prov = intval(substr($doc, 0, 2));
        if ($prov < 1 || $prov > 24) return false;

        $third = intval($doc[2]);
        if ($third < 0 || $third > 5) return false;

        $coeffs = [2,1,2,1,2,1,2,1,2];
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $val = intval($doc[$i]) * $coeffs[$i];
            if ($val >= 10) $val -= 9;
            $sum += $val;
        }

        $checkDigit = (10 - ($sum % 10)) % 10;
        return $checkDigit === intval($doc[9]);
    }

    public static function  buildMatrixByCompanyId($rows, string $tz = 'America/Guayaquil'): array
    {

        $rows = collect($rows);

        $months = [
            1=>'ENE',2=>'FEB',3=>'MAR',4=>'ABR',5=>'MAY',6=>'JUN',
            7=>'JUL',8=>'AGO',9=>'SEP',10=>'OCT',11=>'NOV',12=>'DIC'
        ];
        $days = [
            'Sunday'=>'Domingo','Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miércoles',
            'Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sábado'
        ];

        $grouped = $rows->groupBy(fn($r) => (int) $r->companyId);

        $matrix = [];

        foreach ($grouped as $companyId => $items) {

            // último registro por created_at (para dia/horario)
            $last = $items->sortByDesc(function ($r) use ($tz) {
                return Carbon::parse($r->created_at, $tz)->timestamp;
            })->first();

            $dt = Carbon::parse($last->created_at, $tz);

            $weekdayEs = $days[$dt->format('l')] ?? $dt->format('l');
            $day = str_pad((string)$dt->day, 2, '0', STR_PAD_LEFT);
            $mon = $months[(int)$dt->month] ?? $dt->format('M');
            $yy  = $dt->format('y');
            $diaLabel = "{$weekdayEs} {$day}-{$mon}-{$yy}";

            // ✅ contar nacionales vs extranjeros (según validación cédula)
            $nationalCount = 0;
            $localCount = 0;

            foreach ($items as $row) {
                $doc = $row->identification_document ?? null;
                if (UtilHighcharts::isValidCedulaEcuador($doc)) {
                    $nationalCount++;
                } else {
                    $localCount++;
                }
            }

            $matrix[] = [
                'codigo_embarcacion' => (int) $companyId,
                'nombre_embarcacion' => (string) ($last->vessel_name ?? ''),
                'dia' => $diaLabel,
                'cant_pasajeros' => $items->count(),
                'horario' => $dt->format('H:i:s'),

                // ✅ nuevos
                'national' => $nationalCount, // cédula válida
                'local' => $localCount,       // NO cédula (extranjeros según tu definición)
                'dataFull' => $items->values()->all(), // todas las filas del grupo
            ];
        }

        usort($matrix, fn($a, $b) => $a['codigo_embarcacion'] <=> $b['codigo_embarcacion']);

        return $matrix;
    }
    /**
     * Agrupa data por una columna y calcula total (COUNT).
     *
     * @param array $rows Array de arrays/objetos (resultado de query)
     * @param string $groupKey Nombre de la columna para agrupar (ej: 'type')
     * @param string $totalKey Nombre del key de salida (default: 'total')
     * @param string|null $labelKey Nombre del key etiqueta en salida (default: usa $groupKey)
     * @return array
     */
    public static function groupCount(array $rows, array $opt): array
    {
        // ✅ requeridos
        $groupKey = (string)($opt['groupKey'] ?? '');
        if ($groupKey === '') {
            return [];
        }

        // ✅ opcionales
        $totalKey     = (string)($opt['totalKey'] ?? 'total');
        $labelKey     = (string)($opt['labelKey'] ?? $groupKey);
        $defaultValue = $opt['defaultValue'] ?? 'No definido';

        // parent (opcional)
        $parentKey    = $opt['parentKey'] ?? null;          // ej: 'companyName'
        $parentOutKey = $opt['parentOutKey'] ?? $parentKey; // ej: 'companyName'

        // extras (opcional)
        // formato: ['companyId', 'created_at'] o ['companyId'=>'companyId', 'created_at'=>'date']
        $extras = $opt['extras'] ?? [];

        $map = [];

        foreach ($rows as $row) {
            $get = static function ($key) use ($row) {
                return is_array($row) ? ($row[$key] ?? null) : ($row->{$key} ?? null);
            };

            $value = $get($groupKey);
            if ($value === null || $value === '') {
                $value = $defaultValue;
            }

            if (!isset($map[$value])) {
                $map[$value] = [
                    $labelKey => $value,
                    $totalKey => 0,
                ];

                // ✅ parent (1 valor por grupo)
                if (!empty($parentKey)) {
                    $map[$value][$parentOutKey] = $get($parentKey);
                }

                // ✅ extras (1 valor por grupo)
                if (!empty($extras)) {
                    // si viene como ['a','b'] => copia igual
                    if (array_is_list($extras)) {
                        foreach ($extras as $k) {
                            $map[$value][$k] = $get($k);
                        }
                    } else {
                        // si viene como ['a'=>'aliasA']
                        foreach ($extras as $k => $alias) {
                            $map[$value][$alias] = $get($k);
                        }
                    }
                }
            }

            $map[$value][$totalKey]++;
        }

        return array_values($map);
    }
    /**
     * Agrupa filas por intervalos de fecha y por series (dataKeyByGroup).
     *
     * @param array $rows data cruda (arrays u objetos)
     * @param array $intervalPack ['mode'=>'month', 'intervals'=>[ ['key','label','from','to'], ... ]]
     * @param array $opt
     *   - dateKey: string (ej 'created_at') [requerido]
     *   - dataKeyByGroup: string|null (ej 'companyName') => series
     *   - groupOutKey: string|null (alias de salida, default = dataKeyByGroup)
     *   - tz: string
     *   - totalKey: string
     *   - extras: array (campos extra a copiar por serie)
     *   - fillEmpty: bool
     *   - defaultGroupValue: string (si viene null/empty) default 'No definido'
     *
     * @return array filas planas: cada fila = (intervalo + serie + total + extras)
     */
    public static function groupCountByIntervals(array $rows, array $intervalPack, array $opt): array
    {
        $dateKey = (string)($opt['dateKey'] ?? '');
        if ($dateKey === '' || empty($intervalPack['intervals'])) {
            return [];
        }

        $tz          = (string)($opt['tz'] ?? 'America/Guayaquil');
        $totalKey    = (string)($opt['totalKey'] ?? 'total');
        $fillEmpty   = (bool)($opt['fillEmpty'] ?? true);

        $groupKey    = $opt['dataKeyByGroup'] ?? null;        // ej companyName
        $groupOutKey = $opt['groupOutKey'] ?? $groupKey;      // alias de salida
        $defaultGroupValue = $opt['defaultGroupValue'] ?? 'No definido';

        $extras = $opt['extras'] ?? [];
        $intervals = $intervalPack['intervals'];

        // helper leer keys
        $get = static function ($row, string $key) {
            return is_array($row) ? ($row[$key] ?? null) : ($row->{$key} ?? null);
        };

        // 1) Precompilar intervalos a Carbon (optimización)
        $intervalCarbon = [];
        foreach ($intervals as $it) {
            $intervalCarbon[$it['key']] = [
                'meta' => $it,
                'from' => Carbon::parse($it['from'], $tz),
                'to'   => Carbon::parse($it['to'], $tz),
            ];
        }

        // 2) Identificar series únicas (si groupKey viene)
        // seriesMap: keySerie => ['value'=>..., 'extras'=>...]
        $seriesMap = [];

        if (!empty($groupKey)) {
            foreach ($rows as $row) {
                $gVal = $get($row, $groupKey);
                if ($gVal === null || $gVal === '') $gVal = $defaultGroupValue;

                $sKey = (string)$gVal;

                if (!isset($seriesMap[$sKey])) {
                    $seriesMap[$sKey] = [
                        'value' => $gVal,
                        'extras' => [],
                    ];

                    // copiar extras por serie (primer match)
                    if (!empty($extras)) {
                        if (array_is_list($extras)) {
                            foreach ($extras as $k) {
                                $seriesMap[$sKey]['extras'][$k] = $get($row, $k);
                            }
                        } else {
                            foreach ($extras as $k => $alias) {
                                $seriesMap[$sKey]['extras'][$alias] = $get($row, $k);
                            }
                        }
                    }
                }
            }
        } else {
            // si no hay groupKey, una sola serie "GLOBAL"
            $seriesMap['__all__'] = [
                'value' => null,
                'extras' => [],
            ];
        }

        // 3) Inicializar buckets (intervalo x serie) con 0 (si fillEmpty)
        // buckets[intervalKey][seriesKey] = rowOut
        $buckets = [];

        if ($fillEmpty) {
            foreach ($intervals as $it) {
                foreach ($seriesMap as $sKey => $sData) {
                    $rowOut = [
                        'key'   => $it['key'],
                        'label' => $it['label'],
                        'from'  => $it['from'],
                        'to'    => $it['to'],
                        $totalKey => 0,
                    ];

                    if (!empty($groupKey)) {
                        $rowOut[$groupOutKey] = $sData['value'];
                    }

                    // extras por serie
                    foreach ($sData['extras'] as $k => $v) {
                        $rowOut[$k] = $v;
                    }

                    $buckets[$it['key']][$sKey] = $rowOut;
                }
            }
        }

        // 4) Recorrer data y sumar en el bucket correcto
        foreach ($rows as $row) {
            $rawDate = $get($row, $dateKey);
            if (empty($rawDate)) continue;

            $dt = Carbon::parse($rawDate, $tz);

            $sKey = '__all__';
            $sVal = null;

            if (!empty($groupKey)) {
                $sVal = $get($row, $groupKey);
                if ($sVal === null || $sVal === '') $sVal = $defaultGroupValue;
                $sKey = (string)$sVal;
            }

            // ubicar intervalo
            foreach ($intervalCarbon as $intervalKey => $it) {
                if ($dt->betweenIncluded($it['from'], $it['to'])) {

                    // si fillEmpty = false, crear bucket dinámico
                    if (!isset($buckets[$intervalKey][$sKey])) {
                        $meta = $it['meta'];
                        $rowOut = [
                            'key'   => $meta['key'],
                            'label' => $meta['label'],
                            'from'  => $meta['from'],
                            'to'    => $meta['to'],
                            $totalKey => 0,
                        ];

                        if (!empty($groupKey)) {
                            $rowOut[$groupOutKey] = $sVal;
                        }

                        // extras (si no existe serieMap aún, se copian del row)
                        if (!empty($extras)) {
                            if (array_is_list($extras)) {
                                foreach ($extras as $k) $rowOut[$k] = $get($row, $k);
                            } else {
                                foreach ($extras as $k => $alias) $rowOut[$alias] = $get($row, $k);
                            }
                        }

                        $buckets[$intervalKey][$sKey] = $rowOut;
                    }

                    $buckets[$intervalKey][$sKey][$totalKey]++;

                    break;
                }
            }
        }

        // 5) Aplanar en array ordenado (por intervalos y luego por serie)
        $final = [];

        foreach ($intervals as $it) {
            $iKey = $it['key'];
            if (!isset($buckets[$iKey])) continue;

            // orden estable de series (como fueron detectadas)
            foreach ($seriesMap as $sKey => $_) {
                if (isset($buckets[$iKey][$sKey])) {
                    $final[] = $buckets[$iKey][$sKey];
                } elseif (!$fillEmpty) {
                    // nada
                }
            }

            // si fillEmpty=false, podrían existir series no registradas en seriesMap
            // (no aplica normalmente)
        }

        return $final;
    }
}


namespace App\Support\Analytics;

use Carbon\Carbon;

