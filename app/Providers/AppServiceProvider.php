<?php

namespace App\Providers;

use App\Youtube\YoutubeService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share('flash', function(){
            return [
                'success' => Session::get('success')
            ];
        });

        Inertia::share('errors',function(){
            return Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages(): (object)[];
        });

        $this->app->singleton("App\Youtube\YoutubeService",function (){
            return new YoutubeService(env("YOUTUBE_API_KEY"));
        });
    }
}
