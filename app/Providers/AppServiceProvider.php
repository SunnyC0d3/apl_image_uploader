<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\HandleImages;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HandleImages::class, function ($app) {
            return new HandleImages(new ImageManager(Driver::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
