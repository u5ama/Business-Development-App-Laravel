<?php

namespace App\Providers;

use App\Services\SessionService;
use Illuminate\Support\ServiceProvider;
use Config;
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
        \Illuminate\Support\Facades\View::share('appFileVersion', scriptVersion());
        
        view()->composer('*', function ($view) {
            $stripeKey = config::get('apikeys.STRIPE_KEY');

//            $view->with('your_var', \Session::get('var') );
//            echo "hi";
//            exit;
            $sessionService = new SessionService();
            $userSession = $sessionService->getAuthUserSession();

            $userCredits = !empty($userSession['credits']) ? $userSession['credits'] : 0;

            $view->with('userCredits', $userCredits);
            $view->with('stripeKey', $stripeKey);
//            print_r($ettt);
//            exit;

        });
    }
}
