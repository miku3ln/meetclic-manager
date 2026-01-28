<?php

namespace App\Models\Gamification;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

/**
 * Tabla: gamification_country_reference
 *
 * Campos:
 * - id
 * - country_id (FK countries.id)
 * - currency
 * - yapitas_per_unit
 * - unit_value
 * - unit_label
 * - state
 * - created_at, updated_at, deleted_at (opcionales)
 */
class GamificationCountryReference extends ModelManager
{
    protected $table = 'gamification_country_reference';
    public $timestamps = false;

    // States (mantén el mismo patrón que tus tablas)
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_INACTIVE = 'INACTIVE';

    protected $fillable = [
        'country_id',
        'currency',
        'yapitas_per_unit',
        'unit_value',
        'unit_label',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $attributesData = [
        ['column' => 'country_id', 'type' => 'integer', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'currency', 'type' => 'string', 'defaultValue' => 'USD', 'required' => 'true'],
        ['column' => 'yapitas_per_unit', 'type' => 'integer', 'defaultValue' => 100, 'required' => 'true'],
        ['column' => 'unit_value', 'type' => 'decimal', 'defaultValue' => 1.00, 'required' => 'true'],
        ['column' => 'unit_label', 'type' => 'string', 'defaultValue' => 'USD', 'required' => 'true'],
        ['column' => 'state', 'type' => 'string', 'defaultValue' => self::STATE_ACTIVE, 'required' => 'true'],
    ];

    public static function getRulesModel()
    {
        return [
            "country_id" => "required|numeric",
            "currency" => "required|string|max:10",
            "yapitas_per_unit" => "required|numeric|min:1",
            "unit_value" => "required|numeric|min:0",
            "unit_label" => "required|string|max:10",
            "state" => "required|in:" . self::STATE_ACTIVE . "," . self::STATE_INACTIVE,
        ];
    }

    /* =========================================================
     * QUERIES (OBTENER DATA)
     * ========================================================= */

    /**
     * Trae la referencia activa por country_id.
     */
    public static function findActiveByCountryId(int $countryId): ?object
    {
        return DB::table('gamification_country_reference as gcr')
            ->where('gcr.country_id', $countryId)
            ->where('gcr.state', self::STATE_ACTIVE)
            ->whereNull('gcr.deleted_at')
            ->first();
    }

    /**
     * Trae la referencia activa por ISO (countries.iso_codes).
     * Recomendado para no depender de que Ecuador sea siempre 18.
     */
    public static function findActiveByIsoCode(string $isoCode): ?object
    {
        $iso = strtoupper(trim($isoCode));

        return DB::table('gamification_country_reference as gcr')
            ->join('countries as c', 'c.id', '=', 'gcr.country_id')
            ->where('c.iso_codes', $iso)
            ->where('gcr.state', self::STATE_ACTIVE)
            ->whereNull('gcr.deleted_at')
            ->first();
    }

    /**
     * Lista referencias activas (para panel admin o debug).
     */
    public static function getAllActive(): array
    {
        return DB::table('gamification_country_reference as gcr')
            ->join('countries as c', 'c.id', '=', 'gcr.country_id')
            ->select([
                'gcr.id',
                'gcr.country_id',
                'c.name as country_name',
                'c.iso_codes as country_iso',
                'gcr.currency',
                'gcr.yapitas_per_unit',
                'gcr.unit_value',
                'gcr.unit_label',
                'gcr.state',
            ])
            ->where('gcr.state', self::STATE_ACTIVE)
            ->whereNull('gcr.deleted_at')
            ->orderBy('c.name', 'asc')
            ->get()
            ->toArray();
    }

    /* =========================================================
     * CONVERSIONES (YAPITAS <-> MONEDA)
     * Reglas:
     * - "yapitas_per_unit" define cuántas yapitas equivalen a "unit_value" de la moneda
     *   Ej:
     *     Ecuador: 100 yapitas = 1.00 USD
     *     Colombia: 100 yapitas = 4000 COP
     * ========================================================= */

    /**
     * Convierte YAPITAS a monto en moneda local del país.
     *
     * Fórmula:
     * money = (yapitas / yapitas_per_unit) * unit_value
     */
    public static function convertYapitasToMoney(int $yapitas, int $countryId, int $precision = 2): array
    {
        if ($yapitas < 0) $yapitas = 0;

        $ref = self::findActiveByCountryId($countryId);
        if (!$ref) {
            return [
                'ok' => false,
                'message' => 'No existe configuración activa de conversión para este país.',
                'country_id' => $countryId,
                'yapitas' => $yapitas,
                'money' => 0,
                'currency' => null,
                'unit_label' => null,
                'rate' => null,
            ];
        }

        $ppu = (int)$ref->yapitas_per_unit;
        $unitValue = (float)$ref->unit_value;

        if ($ppu <= 0) $ppu = 100; // fallback seguro
        if ($unitValue <= 0) $unitValue = 1.0;

        $money = ($yapitas / $ppu) * $unitValue;

        return [
            'ok' => true,
            'country_id' => (int)$ref->country_id,
            'yapitas' => (int)$yapitas,
            'money' => round($money, $precision),
            'currency' => (string)$ref->currency,
            'unit_label' => (string)$ref->unit_label,
            // rate informativo: cuanto dinero vale 1 yapita
            'rate' => round(($unitValue / $ppu), 8),
        ];
    }

    /**
     * Convierte monto de moneda local a YAPITAS.
     *
     * Fórmula:
     * yapitas = (money / unit_value) * yapitas_per_unit
     */
    public static function convertMoneyToYapitas(float $money, int $countryId): array
    {
        if ($money < 0) $money = 0;

        $ref = self::findActiveByCountryId($countryId);
        if (!$ref) {
            return [
                'ok' => false,
                'message' => 'No existe configuración activa de conversión para este país.',
                'country_id' => $countryId,
                'money' => $money,
                'yapitas' => 0,
                'currency' => null,
                'unit_label' => null,
                'rate' => null,
            ];
        }

        $ppu = (int)$ref->yapitas_per_unit;
        $unitValue = (float)$ref->unit_value;

        if ($ppu <= 0) $ppu = 100;
        if ($unitValue <= 0) $unitValue = 1.0;

        $yapitas = ($money / $unitValue) * $ppu;

        return [
            'ok' => true,
            'country_id' => (int)$ref->country_id,
            'money' => (float)$money,
            'yapitas' => (int)round($yapitas), // yapitas como entero
            'currency' => (string)$ref->currency,
            'unit_label' => (string)$ref->unit_label,
            // rate informativo: cuantas yapitas vale 1 unidad de dinero
            'rate' => round(($ppu / $unitValue), 8),
        ];
    }

    /**
     * Convierte entre dos países usando yapitas como "puente":
     * money(from) -> yapitas -> money(to)
     */
    public static function convertMoneyBetweenCountries(float $money, int $fromCountryId, int $toCountryId, int $precision = 2): array
    {
        $step1 = self::convertMoneyToYapitas($money, $fromCountryId);
        if (!$step1['ok']) return $step1;

        $step2 = self::convertYapitasToMoney($step1['yapitas'], $toCountryId, $precision);
        if (!$step2['ok']) return $step2;

        return [
            'ok' => true,
            'from' => [
                'country_id' => $fromCountryId,
                'money' => $money,
                'currency' => $step1['currency'],
                'unit_label' => $step1['unit_label'],
            ],
            'bridge' => [
                'yapitas' => $step1['yapitas'],
            ],
            'to' => [
                'country_id' => $toCountryId,
                'money' => $step2['money'],
                'currency' => $step2['currency'],
                'unit_label' => $step2['unit_label'],
            ],
        ];
    }

    /**
     * Helper rápido para Ecuador (si en tu BD Ecuador es 18).
     * OJO: mejor usar ISO para no depender del 18.
     */
    public static function convertYapitasToUsdEcuador(int $yapitas, int $precision = 2): array
    {
        return self::convertYapitasToMoney($yapitas, 18, $precision);
    }
}
