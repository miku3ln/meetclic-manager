<?php

namespace App\Models\InvoiceSales;

use App\Models\ModelManager;
use Illuminate\Support\Facades\DB;

class PosPaymentMethod extends ModelManager
{
    protected $table = 'pos_payment_method';

    // 🔥 CONSTANTES (codes)
    const CODE_CASH     = 'CASH';
    const CODE_TRANSFER = 'TRANSFER';
    const CODE_CARD     = 'CARD';
    const CODE_DEPOSIT  = 'DEPOSIT';

    // 🔥 OPCIONAL: IDS FIJOS (solo si estás 100% seguro que no cambiarán)
    const ID_CASH     = 1;
    const ID_TRANSFER = 4;
    const ID_CARD     = 2;
    const ID_DEPOSIT  = 13;

    protected $fillable = [
        'code',
        'name',
        'is_active'
    ];

    protected $attributesData = [
        ['column' => 'code', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'name', 'type' => 'string', 'defaultValue' => '', 'required' => 'true'],
        ['column' => 'is_active', 'type' => 'integer', 'defaultValue' => '1', 'required' => 'true'],
    ];

    public $timestamps = false;

    protected $field_main = 'code';

    // 🔒 VALIDACIONES
    public static function getRulesModel()
    {
        return [
            "code" => "required|max:50",
            "name" => "required|max:100",
            "is_active" => "required|numeric"
        ];
    }

    // 🚀 =========================
    // 🔽 HELPERS IMPORTANTES
    // 🚀 =========================

    // 🔹 Obtener ID por código
    public static function getIdByCode($code)
    {
        return DB::table('pos_payment_method')
            ->where('code', $code)
            ->value('id');
    }

    // 🔹 Obtener mapa [code => id]
    public static function getMap()
    {
        return DB::table('pos_payment_method')
            ->where('is_active', 1)
            ->pluck('id', 'code')
            ->toArray();
    }

    // 🔹 Resolver ID (con validación)
    public static function resolveId($code)
    {
        $map = self::getMap();

        if (!isset($map[$code])) {
            throw new \Exception("Método de pago inválido: " . $code);
        }

        return $map[$code];
    }

    // 🔹 Validar si existe
    public static function existsCode($code)
    {
        return DB::table('pos_payment_method')
            ->where('code', $code)
            ->exists();
    }

    // 🔹 Obtener lista activa
    public static function getActive()
    {
        return DB::table('pos_payment_method')
            ->where('is_active', 1)
            ->get();
    }
}
