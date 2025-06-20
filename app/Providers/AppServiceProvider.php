<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
=======
use Illuminate\Routing\UrlGenerator; 
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2

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
<<<<<<< HEAD
    public function boot(): void
    {
        //
    }
}
=======
    public function boot(UrlGenerator $url): void // Inject UrlGenerator
    {
        // if ($this->app->environment('local') && isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        //     $url->forceScheme('https');
        // }
    }
}
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
