<?php

namespace App\Providers;

use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // $galleries = DB::table('product_galleries')->get();
        // View::share('galleries', $galleries);
        Builder::useVite();
    }
}
