<?php

namespace App\Providers;

//use Firebase\Auth\Token\Verifier;
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
        //
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
