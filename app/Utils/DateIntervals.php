<?php
namespace App\Utils;

use Carbon\Carbon;

class DateIntervals
{
    /**
     * Genera intervalos entre dos fechas.
     *
     * @param string $from 'Y-m-d H:i:s'
     * @param string $to 'Y-m-d H:i:s'
     * @param string|null $mode 'year'|'month'|'day'|'hour'|null (null = auto)
     * @param string $tz
     * @return array { mode, intervals: [ {key,label,from,to} ... ] }
     */
    public static function build(string $from, string $to, ?string $mode = null, string $tz = 'America/Guayaquil'): array
    {
        $start = Carbon::parse($from, $tz);
        $end = Carbon::parse($to, $tz);

        if ($end->lt($start)) {
            // swap si viene invertido
            [$start, $end] = [$end, $start];
        }

        $mode = $mode ?: self::detectMode($start, $end);

        return [
            'mode' => $mode,
            'intervals' => match ($mode) {
                'year' => self::years($start, $end),
                'month' => self::months($start, $end),
                'day' => self::days($start, $end),
                'hour' => self::hours($start, $end),
                default => self::days($start, $end),
            },
        ];
    }

    /**
     * Auto: decide el nivel según el tamaño del rango.
     * Ajusta los umbrales a tu gusto.
     */
    private static function detectMode(Carbon $start, Carbon $end): string
    {
        $hours = $start->diffInHours($end);
        $days = $start->diffInDays($end);
        $months = $start->diffInMonths($end);
        $years = $start->diffInYears($end);

        // 🔥 Reglas simples (tú puedes cambiar):
        if ($years >= 2) return 'year';     // 2+ años => anual
        if ($months >= 2) return 'month';   // 2+ meses => mensual
        if ($days >= 2) return 'day';       // 2+ días => días
        return 'hour';                      // si es corto => horas
    }

    private static function years(Carbon $start, Carbon $end): array
    {
        $cursor = $start->copy()->startOfYear();
        $last = $end->copy()->endOfYear();
        $out = [];

        while ($cursor->lte($last)) {
            $from = $cursor->copy()->startOfYear();
            $to = $cursor->copy()->endOfYear();

            $out[] = [
                'key' => $cursor->format('Y'),
                'label' => $cursor->format('Y'),
                'from' => $from->format('Y-m-d H:i:s'),
                'to' => $to->format('Y-m-d H:i:s'),
            ];

            $cursor->addYear();
        }

        return $out;
    }

    private static function months(Carbon $start, Carbon $end): array
    {
        $cursor = $start->copy()->startOfMonth();
        $last = $end->copy()->endOfMonth();
        $out = [];

        while ($cursor->lte($last)) {
            $from = $cursor->copy()->startOfMonth();
            $to = $cursor->copy()->endOfMonth();

            // label en español (sin depender de locale del servidor)
            $monthName = self::monthEs((int)$cursor->format('n'));
            $label = $monthName . ' ' . $cursor->format('Y'); // "Enero 2025"

            $out[] = [
                'key' => $cursor->format('Y-m'),
                'label' => $label,
                'from' => $from->format('Y-m-d H:i:s'),
                'to' => $to->format('Y-m-d H:i:s'),
            ];

            $cursor->addMonth();
        }

        return $out;
    }

    private static function days(Carbon $start, Carbon $end): array
    {
        $cursor = $start->copy()->startOfDay();
        $last = $end->copy()->endOfDay();
        $out = [];

        while ($cursor->lte($last)) {
            $from = $cursor->copy()->startOfDay();
            $to = $cursor->copy()->endOfDay();

            $out[] = [
                'key' => $cursor->format('Y-m-d'),
                'label' => $cursor->format('d-m-Y'), // "24-01-2025"
                'from' => $from->format('Y-m-d H:i:s'),
                'to' => $to->format('Y-m-d H:i:s'),
            ];

            $cursor->addDay();
        }

        return $out;
    }

    private static function hours(Carbon $start, Carbon $end): array
    {
        $cursor = $start->copy()->startOfHour();
        $last = $end->copy()->endOfHour();
        $out = [];

        while ($cursor->lte($last)) {
            $from = $cursor->copy()->startOfHour();
            $to = $cursor->copy()->endOfHour();

            $out[] = [
                'key' => $cursor->format('Y-m-d H:00'),
                'label' => $cursor->format('H:00'),  // "08:00"
                'from' => $from->format('Y-m-d H:i:s'),
                'to' => $to->format('Y-m-d H:i:s'),
            ];

            $cursor->addHour();
        }

        return $out;
    }

    private static function monthEs(int $month): string
    {
        return match ($month) {
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
            default => 'Mes',
        };
    }
}
