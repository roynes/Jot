<?php

namespace App\Providers;

use App\Console\JWTGenerateCommandFix;
use App\Models\Group;
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
