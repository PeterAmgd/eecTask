<?php

namespace App\Providers;

use App\Services\PharmacyService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PharmacyRepository;

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
        // $this->app->bind(PharmacyRepository::class, function () {
        //     return new PharmacyRepository();
        // });

        // $this->app->bind(PharmacyService::class, function () {
        //     return new PharmacyService(app(PharmacyRepository::class));
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (! $this->app->runningInConsole()) {
            // 'key' => 'value'

        }

        Paginator::useBootstrap();
    }
}
