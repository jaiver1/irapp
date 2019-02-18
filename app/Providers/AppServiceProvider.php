<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_ALL,"es_ES");
        Carbon::setlocale(config('app.locale'));
        Schema::defaultStringLength(191);
        Blade::directive('money', function ($amount) {
            return "<?php echo '<i class=\"fas fa-dollar-sign\"></i> ' . number_format($amount, 0); ?>";
        });

        Blade::directive('cantidad', function ($amount) {
            return "<?php echo number_format($amount, 0); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
