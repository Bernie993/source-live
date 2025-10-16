<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\MenuComposer;
use App\View\Composers\PostComposer;

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
        // Share menus with header and footer components
        View::composer(['components.header', 'components.footer'], MenuComposer::class);
        
        // Share posts with homepage
        View::composer(['homepage', 'live-room'], PostComposer::class);
    }
}
