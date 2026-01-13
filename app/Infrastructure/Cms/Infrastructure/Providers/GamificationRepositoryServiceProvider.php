<?php


namespace App\Infrastructure\Cms\Infrastructure\Providers;

use App\Infrastructure\Cms\Domains\Gamification\Movement\Repositories\MovementRepositoryInterface;
use App\Infrastructure\Cms\Infrastructure\Persistence\Eloquent\Repositories\EloquentMovementRepository;
use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Cms\Domains\Gamification\Wallet\Repositories\WalletRepositoryInterface;
use App\Infrastructure\Cms\Infrastructure\Persistence\Eloquent\Repositories\EloquentWalletRepository;

class GamificationRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(WalletRepositoryInterface::class, EloquentWalletRepository::class);
        $this->app->bind(MovementRepositoryInterface::class, EloquentMovementRepository::class);
    }
}
