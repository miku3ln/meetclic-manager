<?php

namespace App\Providers;

//use Firebase\Auth\Token\Verifier;
use App\Infrastructure\Cms\Domain\Gamification\Routing\Ports\BusinessReadPort;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessReadPort;
use App\Infrastructure\Cms\Domain\Gamification\Wallet\Ports\ProcessTrackingPort;
use App\Infrastructure\Cms\Infrastructure\Adapters\Persistence\Repositories\DbBusinessReadRepository;
use App\Infrastructure\Cms\Infrastructure\Adapters\Persistence\Repositories\DbProcessReadRepository;
use App\Infrastructure\Cms\Infrastructure\Adapters\Persistence\Repositories\DbProcessTrackingRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //GAMING NEW
        $this->app->bind(ProcessReadPort::class, DbProcessReadRepository::class);
        $this->app->bind(ProcessTrackingPort::class, DbProcessTrackingRepository::class);
        $this->app->bind(BusinessReadPort::class, DbBusinessReadRepository::class);
        $this->app->bind(ProcessReadPort::class, DbProcessReadRepository::class);


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //CONFIG-INIT
       // Blade::withoutDoubleEncoding();
        Paginator::useBootstrapThree();
        view()->composer('layouts.masterMinton', function ($view) {

        });
        /*Firebase*/
      /*  $this->app->singleton(Verifier::class, function ($app) {
            return new Verifier('firebase-project-name');
        });
*/

        view()->composer('layouts.business', function ($view) {

        });
/*
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
        });*/
    }
}
