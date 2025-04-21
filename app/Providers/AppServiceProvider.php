<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Blade::component('layouts.app', 'app-layout');
        
        // Partager le nombre d'articles dans le panier avec toutes les vues
        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->role === 'professional') {
                try {
                    $cart = Cart::where('professional_id', Auth::id())
                            ->where('is_active', true)
                            ->first();
                    
                    $cartItemsCount = $cart ? $cart->items()->count() : 0;
                } catch (\Exception $e) {
                    $cartItemsCount = 0;
                }
                
                $view->with('cartItemsCount', $cartItemsCount);
            }
        });
    }
}
