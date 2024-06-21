<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('downloadAndDelete', function ($path, $name = null, $headers = []) {
            return response()->download($path, $name, $headers)->deleteFileAfterSend(true);
        });
    }
}
