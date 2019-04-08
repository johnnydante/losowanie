<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Tools\Globals;


class ToolsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Globals', function () {
            return new Globals();
        });
    }
}
