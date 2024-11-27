<?php

namespace App\Providers;

use Dcat\Admin\Admin;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }
    protected function authorization()
    {
//        $this->gate();

        Horizon::auth(function ($request) {
            if(Admin::user()){
                return Admin::user()->isAdministrator();
            }else{
                return abort(403);
            }
//            dump(Admin::user());exit;

//            return Gate::check('viewHorizon', [$request->user()]);
        });
    }
}
