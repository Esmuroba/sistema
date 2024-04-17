<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer(['*'],'App\Http\ViewComposers\MenuComposer');
    }
}
