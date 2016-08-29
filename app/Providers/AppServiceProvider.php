<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if ($this->app->environment('production')) {
            $url->forceSchema('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Symfony\Component\Console\Output\OutputInterface',
            'Symfony\Component\Console\Output\ConsoleOutput'
        );
    }

    public function provides()
    {
        return [
            'Symfony\Component\Console\Output\ConsoleOutputInterface',
        ];
    }
}
