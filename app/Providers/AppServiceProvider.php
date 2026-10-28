<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('layouts.sidebar', function ($view) {

            if (!Auth::check()) {
                return;
            }

            $user = Auth::user();

            $menus = $user->userLevel
                ->menus()
                ->wherePivot('can_view', 1)
                ->whereNull('parent_id')
                ->where('is_active', 1)
                ->orderBy('order')
                ->with([
                    'children' => function ($q) use ($user) {

                        $q->where('is_active', 1)
                            ->whereIn('id', function ($sub) use ($user) {

                                $sub->select('menu_id')
                                    ->from('user_level_menus')
                                    ->where('user_level_id', $user->user_level_id)
                                    ->where('can_view', 1);
                            })
                            ->orderBy('order');
                    }
                ])
                ->get();

            $view->with('menus', $menus);
        });
    }
}
