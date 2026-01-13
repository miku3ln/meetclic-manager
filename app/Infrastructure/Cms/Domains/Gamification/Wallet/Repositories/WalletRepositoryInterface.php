<?php

namespace App\Infrastructure\Cms\Domains\Gamification\Wallet\Repositories;

interface WalletRepositoryInterface
{
    /**
     * Obtiene o crea una subcuenta (wallet) para un usuario.
     *
     * business_id:
     *  - null => wallet global del usuario (tipo banco principal)
     *  - int  => wallet asociada a una empresa
     */
    public function getOrCreate(
        int $userId,
        ?int $businessId,
        int $typeMoney = 0
    ): int;
}
