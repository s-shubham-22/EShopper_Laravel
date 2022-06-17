<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Brand;

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
        view()->share('categories', Category::withCount('products')->get());
        view()->share('products', Product::all());
        view()->share('brands', Brand::all());
        view()->share('variants', Variant::with('product')->get());
    }
}
