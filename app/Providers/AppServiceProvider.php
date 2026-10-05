<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

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
        //
        Paginator::useBootstrapFive();

        // VIEW COMPOSER: mỗi khi view partial.sidebar được render thì tự động
        // truyền biến $menus vào -> không controller nào phải tự lấy menu.
        View::composer('partial.sidebar', function ($view) {
            $menus = Menu::nhom()
                ->hoatDong()
                ->thuTu()
                ->with(['children' => fn ($q) => $q->hoatDong()])
                ->get();

            $view->with('menus', $menus);
        });
    }
}
