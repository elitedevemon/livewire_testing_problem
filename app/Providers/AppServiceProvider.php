<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
        View::composer('*',function($view){
            $primary_color = "yellow";
            $view->with('primary_color', $primary_color);

            $button_style_grayed = "px-2 py-1 text-base font-black uppercase shadow-xl rounded border text-white bg-gray-300 border-gray-400";
            $view->with('button_style_grayed', $button_style_grayed);

            $basic_button_style = "cursor-pointer px-2 py-1 text-base font-black uppercase hover:bg-".$primary_color."-600 shadow-xl rounded border";

            $button_style = $basic_button_style." text-white bg-".$primary_color."-500 border-".$primary_color."-600";
            $view->with('button_style', $button_style);

            $button_style_inverted = $basic_button_style." bg-white text-".$primary_color."-500 border-2 border-".$primary_color."-500 hover:text-white hover:border-".$primary_color."-600";
            $view->with('button_style_inverted', $button_style_inverted);  

            $button_style_wide = $button_style." m-0 min-w-full py-2";
            $view->with('button_style_wide', $button_style_wide);        
        });

        View::composer(['packages.index', 'packages.show'],function($view){
            $primary_color = "yellow";
            $highlight_package = ["bg-gray-500", "ring-8", "ring-".$primary_color."-600"];
            $view->with('highlight_package', $highlight_package);
        });
 
    }
}
