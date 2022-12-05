<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use Auth;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::withCount('products')->orderBy('created_at')->paginate('5');
        $category_products = Product::with(category)->orderBy('created_at', 'desc')->get();
        $customer_id = Auth::user()->id ??'None';
        $products = Cart::with(['product'])->where
        ('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('landinpage.category.index', compact('category_products', 'categories', 'countCart', 'sumTotal', 'products'));

        $categories = Category::withCount('products')->orderBy('created_at')->paginate('5');
        $category_products = Product::with(category)->orderBy('created_at', 'desc')->get();
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('landinpage.category.index', compact('category_products', 'categories', 'countCart', 'sumTotal', 'products'));
    }

    public function show($id)
    {
        $category = Category::find($id);
        $products_category = Product::where('category_id', $category->id)->get();
        $categories = Category::withCount(['products'])->get();
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])
        ->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('landinpage.category.show', compact('products_category', 'categories', 'category', 'countCart', 'sumTotal', 'products'));
     }
}
