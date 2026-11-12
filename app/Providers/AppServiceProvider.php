<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

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
        // Mengatur bahasa Indonesia untuk Carbon
        Carbon::setLocale('id');
        
        // Opsional: Untuk mengatasi error database pada versi MySQL tertentu
        Schema::defaultStringLength(191);
    }
}