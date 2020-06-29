<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Models\{ Shop, Page };
use Cart;
use ConsoleTVs\Charts\Registrar as Charts;
use App\Charts\{ OrdersChart, UsersChart };
use DB;
use Illuminate\Support\Facades\Schema; 


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
    public function boot(Charts $charts)
    {

        Schema::defaultStringLength(191);
        DB::statement("SET lc_time_names = 'fr_FR'");

        $charts->register([
            OrdersChart::class,
            UsersChart::class
        ]);

        View::share('shop', Shop::firstOrFail());
        View::share('pages', Page::all());

        Route::resourceVerbs([
            'edit' => 'modification',
            'create' => 'creation',
        ]);
    
        View::composer(['layouts.app', 'products.show'], function ($view) {
            $view->with([
                'cartCount' => Cart::getTotalQuantity(), 
                'cartTotal' => Cart::getTotal(),
            ]);
        });
        
        View::composer('back.layout', function ($view) {
            $title = config('titles.' . Route::currentRouteName());
            $view->with(compact('title'));
        });
    }
}
