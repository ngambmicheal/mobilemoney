<?php

namespace Ngambmicheal\MobileMoney;

use Illuminate\Support\ServiceProvider;

class MobileMoneyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //

         $this->publishes([
            __DIR__ . '/../config' => config_path('mobilemoney.php'),            
            __DIR__ . '/../database' => base_path('/database/migrations/'),
            __DIR__ . '/../models'   => base_path('/app/model'),
            ]);
          
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
         $this->mergeConfigFrom(
                __DIR__ . '/../config/mobilemoney.php', 'mobilemoney'
         );
    }
}
