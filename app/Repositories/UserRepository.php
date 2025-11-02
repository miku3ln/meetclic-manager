<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\DTOs\GamificationSummary;
use App\DTOs\Reputation;
use App\DTOs\Trophies;
use App\DTOs\Yapitas;
use App\DTOs\Visits;
use App\DTOs\Rating;
class UserRepository
{
    public function getUserCompleteInfo($userId)
    {
        $data = DB::table('users as u')
            ->leftJoin('users_has_roles as ur', 'ur.user_id', '=', 'u.id')
            ->leftJoin('roles as r', 'r.id', '=', 'ur.role_id')
            ->leftJoin('customer_by_profile as cbp', 'cbp.user_id', '=', 'u.id')
            ->leftJoin('customer as c', 'c.id', '=', 'cbp.customer_id')
            ->leftJoin('ruc_type as ruc', 'ruc.id', '=', 'c.ruc_type_id')
            ->leftJoin('people_type_identification as pti', 'pti.id', '=', 'c.people_type_identification_id')
            ->leftJoin('people as p', 'p.id', '=', 'c.people_id')
            ->where('u.id', $userId)
            ->select([
                // Datos principales del usuario
                'u.id as user_id',
                'u.name as user_name',
                'u.email',
                'u.username',
                'u.status as user_status',
                'u.avatar',

                // Roles
                'r.id as role_id',
                'r.name as role_name',

                // Customer
                'c.id as customer_id',
                'c.identification_document',
                'c.business_name',
                'c.business_reason',
                'c.has_representative',
                'c.representative_fullname',

                // Tipo de RUC
                'ruc.id as ruc_type_id',
                'ruc.name as ruc_type_name',

                // Tipo de identificación
                'pti.id as people_type_id',
                'pti.name as people_type_name',
                'pti.code as people_type_code',

                // Persona asociada
                'p.id as person_id',
                'p.last_name',
                'p.name as person_name',
                'p.birthdate',
                'p.age',
                'p.gender',
            ])
            ->first();
        return $data ? (array)$data : [];
    }

    private const INPUT = 1;
    private const OUTPUT = 0;

    private const TYPE_MONEY_YAPITAS = 0;
    private const TYPE_MONEY_PREMIUM = 1;

    private array $typeMoneyNames = [
        self::TYPE_MONEY_YAPITAS => 'Yapitas',
        self::TYPE_MONEY_PREMIUM => 'Yapitas Premium',
    ];

    private array $transactionTypeNames = [
        0 => 'Depósito efectivo',
        1 => 'Retiro efectivo',
        2 => 'Gasto bancario',
        3 => 'Canje cupones',
        4 => 'Cheque negociado',
    ];

    public function getGamificationLog(int $userId): array
    {
        // Obtener cuenta gamificada
        $account = DB::table('account_gamification')
            ->where('user_id', $userId)
            ->first();

        if (!$account) {
            return [
                'movimientos' => [],
                'resumen' => []
            ];
        }


        $movimientos = DB::table('account_gamification_by_movement as agm')
            ->leftJoin('gamification_by_process as gbp', 'gbp.id', '=', 'agm.gamification_by_process_id')
            ->leftJoin('gamification as g', 'g.id', '=', 'gbp.gamification_id')
            ->leftJoin('gamification_type_activity as gta', 'gta.id', '=', 'gbp.gamification_type_activity_id')
            ->where('agm.account_gamification_id', $account->id)
            ->orderByDesc('agm.created_at')
            ->select([
                'agm.id',
                'agm.created_at as fecha',
                'agm.description',
                'agm.input_movement',
                'agm.type',
                'agm.amount',
                'agm.type_money',
                'gbp.title as process_name',
                'gbp.source as source_process',
                'gta.title as activity_name'
            ])
            ->get()
            ->map(function ($item) {


                return [
                    'id' => $item->id,
                    'date_register' => $item->fecha,
                    'description' => $item->description,
                    'input_movement_name' => $item->input_movement == self::INPUT ? 'Entrada' : 'Salida',
                    'input_movement_value' => $item->input_movement,
                    'tipo_transaction_value' => $item->type,
                    'tipo_transaction_name' => $this->transactionTypeNames[$item->type] ?? 'Desconocido',
                    'amount' => (float)$item->amount,
                    'type_money_value' => $item->type_money,
                    'type_money_name' => $this->typeMoneyNames[$item->type_money] ?? 'Desconocido',
                    'process_name' => $item->process_name ?? 'Sin proceso',
                    'source_process' => asset('public' ). $item->source_process,

                    'activity_name' => $item->activity_name ?? 'Sin tipo',
                ];
            });

        // Totales por tipo y dirección
        $totalEntradaYapitas = $movimientos
            ->where('input_movement_value', self::INPUT)
            ->where('type_money_value', self::TYPE_MONEY_YAPITAS)
            ->sum('amount');

        $totalSalidaYapitas = $movimientos
            ->where('input_movement_value', self::OUTPUT)
            ->where('type_money_value', self::TYPE_MONEY_YAPITAS)
            ->sum('amount');

        $totalEntradaYapitasPremium = $movimientos
            ->where('input_movement_value', self::INPUT)
            ->where('type_money_value', self::TYPE_MONEY_PREMIUM)
            ->sum('amount');

        $totalSalidaYapitasPremium = $movimientos
            ->where('input_movement_value', self::OUTPUT)
            ->where('type_money_value', self::TYPE_MONEY_PREMIUM)
            ->sum('amount');




        $reputationScore=0;
        $totalTrophies=0;
        $totalVisits=0;
        $positiveClients=0;
        $averageStars=0;
        $communityScore=0;
        $summary = new GamificationSummary(
            new Yapitas($totalEntradaYapitas, $totalSalidaYapitas, $account->balance_available_bee),
            new Yapitas($totalEntradaYapitasPremium, $totalSalidaYapitasPremium, $account->balance_available_queen),
            new Reputation($reputationScore),
            new Trophies($totalTrophies),
            new Visits($totalVisits),
            new Rating($positiveClients, $averageStars, $communityScore)
        );

        return [
            'movimientos' => $movimientos,
            'summary' => $summary->toArray()
        ];
    }

    public function getReputationLogForClient(int $userId): array
    {
        // Verificar si existen movimientos de reputación para el usuario
        $hasReputation = DB::table('reputation_movement_client')
            ->where('user_id', $userId)
            ->exists();

        if (!$hasReputation) {
            return [
                'movements' => [],
                'summary' => [
                    'total_reputation' => 0,
                    'incoming' => 0,
                    'outgoing' => 0,
                ],
            ];
        }

        // Obtener movimientos de reputación del cliente
        $movements = DB::table('reputation_movement_client as rm')
            ->leftJoin('gamification_by_process as process', 'process.id', '=', 'rm.gamification_by_process_id')
            ->orderByDesc('rm.created_at')
            ->select([
                'rm.id',
                'rm.created_at as timestamp',
                'rm.description',
                'rm.type_manager',
                'rm.reputation_points',
                'rm.user_id',
                'process.title as process_name',
            ])
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'timestamp' => $record->timestamp,
                    'description' => $record->description,
                    'direction' => $record->type_manager === 1 ? 'IN' : 'OUT',
                    'reputation_points' => (float) $record->reputation_points,
                    'user_id' => $record->user_id,
                    'process_name' => $record->process_name ?? 'Unknown',
                ];
            });

        // Calcular sumatorias
        $incoming = $movements->where('direction', 'IN')->sum('reputation_points');
        $outgoing = $movements->where('direction', 'OUT')->sum('reputation_points');
        $totalReputation = $incoming - $outgoing;

        return [
            'movements' => $movements,
            'summary' => [
                'total_reputation' => $totalReputation,
                'incoming' => $incoming,
                'outgoing' => $outgoing,
            ],
        ];
    }



}
