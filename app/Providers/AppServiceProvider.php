<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        $customer_id =Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at')->paginate('4');
        $categories = Category::withCount(['products'])->get();
        $orders = Order::with('status')->where('customer_id', $customer_id)->orderBy('created_at')->paginate('10');
        $footerCategories = Category::paginate('4');
        $show_categories = Category::withCount(['products'])->paginate('2');
        $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        $sumQuantity = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('quantity');
        $footerCategories = Category::paginate('4');
        View::share('products', $products);
        View::share('categories', $categories);
        View::share('footerCategories', $footerCategories);
        View::share('show_categories', $show_categories);
        View::share('allProducts', $allProducts);
        View::share('countCart', $countCart);
        View::share('sumTotal', $sumTotal);
        View::share('footerCategories', $footerCategories);
        View::share('orders', $orders);
        View::share('customer_id', $customer_id);
        View::share('sumQuantity', $sumQuantity);
    }
}
