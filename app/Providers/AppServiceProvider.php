<?php

namespace App\Providers;

use App\Console\JWTGenerateCommandFix;
use App\Models\Client;
use App\Models\Group;
use App\Observers\ClientObserver;
use App\Observers\GroupObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->instantiateJWTGenerateCommandFix();

        Group::observe(GroupObserver::class);
        Client::observe(ClientObserver::class);
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

    private function instantiateJWTGenerateCommandFix()
    {
        $this->app->singleton('tymon.jwt.generate', function($app) {
            return $app->make(JWTGenerateCommandFix::class);
        });
    }
}
