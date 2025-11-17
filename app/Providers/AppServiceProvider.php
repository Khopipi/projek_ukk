<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $name = $user->name;
                $role = $user->role;
                $avatar = $user->provider == null
                    ? url('assets/images/user/' . $user->avatar)
                    : $user->avatar;

                $view->with(compact('user', 'name', 'role', 'avatar'));
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
        });

        //         if ($this->app->environment('local')) {
        //         URL::forceRootUrl(config('app.url'));
        //         URL::forceScheme('https');
        // }

    }


}
