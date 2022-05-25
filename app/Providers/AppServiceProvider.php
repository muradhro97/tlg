<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

//        Blade::if('canany', function ($abilities) {
//            return app(\Illuminate\Contracts\Auth\Access\Gate::class)->any($abilities);
//        });
        view()->composer('*', function ($view) {

            $main_settings = Setting::findOrNew(1);
            $view->with('website_name', $main_settings->name)
//                ->with('website_image',$main_settings->image)
                ->with('main_settings',$main_settings)
            ;
        });
    }
}
