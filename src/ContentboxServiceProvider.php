<?php
namespace Sheld\Contentbox;

use Illuminate\Support\ServiceProvider;

class ContentboxServiceProvider extends ServiceProvider{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    public function register()
    {
        $this->app->singleton('contentService', function () {
            return new ContentService;
        });
    }
}
