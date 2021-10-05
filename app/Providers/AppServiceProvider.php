<?php

declare(strict_types=1);

namespace App\Providers;

use Faker\Generator as FakerGenerator;
use Illuminate\Support\ServiceProvider;
use PhpCfdi\Rfc\RfcFaker;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend(FakerGenerator::class, function (FakerGenerator $generator) {
            $generator->addProvider(new RfcFaker());
            return $generator;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
