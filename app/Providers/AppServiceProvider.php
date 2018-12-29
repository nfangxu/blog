<?php

namespace App\Providers;

use App\Contracts\LaravelChinaSpider;
use App\Services\Spiders\LaravelAcademyPost;
use App\Services\Spiders\LaravelChinaTopic;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LaravelChinaSpider::class, LaravelAcademyPost::class);
    }
}
