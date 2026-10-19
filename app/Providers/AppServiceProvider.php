<?php

namespace App\Providers;

use App\Services\RickAndMortyApi;
use App\View\Composers\ThemeComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
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
            timeout: config('services.rickandmorty.timeout'),
            cachelifetime: config('services.rickandmorty.cachelifetime'),
            coolofftime: config('services.rickandmorty.coolofftime'),
            dailylimit: config('services.rickandmorty.dailylimit')
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('characters', fn(Request $request) => Limit::perMinute(60)->by($request->ip()));
        View::composer('layouts.main', ThemeComposer::class);
    }
}
