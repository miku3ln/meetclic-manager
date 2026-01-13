<?php

namespace App\Infrastructure\Cms\Infrastructure\Adapters\Persistence\Sql;

use Carbon\Carbon;

class FrequencyWindow
{
    /**
     * @return array{0:string,1:string,2:string} [from,to,mode]
     * mode: "WINDOW" (whereBetween) | "TOTAL" (count total) | "NONE" (sin límite)
     */
    public static function resolve(?string $type, int $nowEpochSeconds, string $tz = 'America/Guayaquil'): array
    {
        $type = strtoupper(trim((string)$type));

        // Carbon desde epoch con TZ (CLAVE)
        $now = Carbon::createFromTimestamp($nowEpochSeconds, $tz);

        // sin límite
        if ($type === '' || $type === 'NONE' || $type === 'UNLIMITED' || $type === 'NULL') {
            return ['', '', 'NONE'];
        }

        // total en toda la vida
        if ($type === 'TOTAL_LIMIT' || $type === 'ONCE') {
            return ['', '', 'TOTAL'];
        }

        return match ($type) {
            'DAILY' => [
                $now->copy()->startOfDay()->toDateTimeString(),
                $now->copy()->endOfDay()->toDateTimeString(),
                'WINDOW'
            ],

            // Semana ISO: lunes a domingo
            'WEEKLY' => [
                $now->copy()->startOfWeek(Carbon::MONDAY)->toDateTimeString(),
                $now->copy()->endOfWeek(Carbon::SUNDAY)->toDateTimeString(),
                'WINDOW'
            ],

            'MONTHLY' => [
                $now->copy()->startOfMonth()->toDateTimeString(),
                $now->copy()->endOfMonth()->toDateTimeString(),
                'WINDOW'
            ],

            'YEARLY' => [
                $now->copy()->startOfYear()->toDateTimeString(),
                $now->copy()->endOfYear()->toDateTimeString(),
                'WINDOW'
            ],

            'HOURLY' => [
                $now->copy()->startOfHour()->toDateTimeString(),
                $now->copy()->endOfHour()->toDateTimeString(),
                'WINDOW'
            ],

            'MINUTELY' => [
                $now->copy()->startOfMinute()->toDateTimeString(),
                $now->copy()->endOfMinute()->toDateTimeString(),
                'WINDOW'
            ],

            default => ['', '', 'TOTAL'], // fallback seguro
        };
    }
}
