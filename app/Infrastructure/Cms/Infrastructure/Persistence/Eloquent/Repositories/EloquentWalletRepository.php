<?php

namespace App\Infrastructure\Cms\Infrastructure\Persistence\Eloquent\Repositories;


use App\Infrastructure\Cms\Domains\Gamification\Wallet\Repositories\WalletRepositoryInterface;
use App\Infrastructure\Cms\Infrastructure\Persistence\Eloquent\Models\AccountGamificationModel;
use Illuminate\Support\Facades\DB;

class EloquentWalletRepository implements WalletRepositoryInterface
{
    public function getOrCreate(
        int $userId,
        ?int $businessId,
        int $typeMoney = 0
    ): int {
        // OJO: business_id = NULL no es comparable con "=" en SQL
        // por eso usamos whereNull cuando aplica.

        return DB::transaction(function () use ($userId, $businessId, $typeMoney) {

            $query = AccountGamificationModel::query()
                ->where('user_id', $userId)
                ->where('type_money', $typeMoney);

            if ($businessId === null) {
                $query->whereNull('business_id');
            } else {
                $query->where('business_id', $businessId);
            }

            $wallet = $query->first();

            if ($wallet) {
                return (int)$wallet->id;
            }

            // Creamos usando la restricción UNIQUE como protección extra.
            try {
                $wallet = AccountGamificationModel::create([
                    'user_id' => $userId,
                    'business_id' => $businessId,
                    'type_money' => $typeMoney,
                    'state' => 'ACTIVE',
                ]);

                return (int)$wallet->id;

            } catch (\Throwable $e) {
                // Si hubo carrera (dos requests crearon a la vez), volvemos a leer.
                $query2 = AccountGamificationModel::query()
                    ->where('user_id', $userId)
                    ->where('type_money', $typeMoney);

                if ($businessId === null) {
                    $query2->whereNull('business_id');
                } else {
                    $query2->where('business_id', $businessId);
                }

                $wallet2 = $query2->first();

                if ($wallet2) {
                    return (int)$wallet2->id;
                }

                throw $e;
            }
        });
    }
}
