<?php

namespace App\Providers;

use App\Services\RickAndMortyApi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RickAndMortyApi::class, fn() => new RickAndMortyApi(
            url: config('services.rickandmorty.url'),
            timeout: config('services.rickandmorty.timeout')
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
