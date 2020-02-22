<?php
namespace Sheld\Contentbox;

use Illuminate\Support\ServiceProvider;

class ContentboxServiceProvider extends ServiceProvider{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton('content', function () {
            return new Content;
        });
    }
}