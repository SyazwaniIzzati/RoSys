<?php

namespace App\Providers;

use App\Models\CartItems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('components.florist-layout', function ($view) {

            $cartCount = 0;

            if (Auth::check()) {
                $cartCount = CartItems::whereHas('cart', function ($query) {
                    $query->where('user_id', Auth::id());
                })->sum('quantity');
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
