<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $list_products = Product::with('category')->orderBy('created_at', 'desc')->paginate('10');
        $categories = Category::withCount(['products'])->get();
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');

        return view('landinpage.products.index', compact('list_products', 'products', 'categories', 'countCart', 'sumTotal'));
    }
    public function show($id)
    {
        $product = Product::with(['category', 'subCategory', 'subSubCategory'])->find($id);
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $list_products = Product::with('category', 'subCategory')->where('category_id', $product->category_id)->orderBy('created_at', 'desc')->paginate('10');
        $categories = Category::withCount(['products'])->get();
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');

        return view('landinpage.products.show', compact('product', 'categories', 'products', 'list_products', 'countCart', 'sumTotal'));
    }
    public function quickView($id)
    {
        $product = Product::with(['category'])->find($id);
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $list_products = Product::with('category')->orderBy('created_at', 'desc')->paginate('10');
        $categories = Category::withCount(['products'])->get();
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');

        return view('landinpage.products.quick-view', compact('product', 'categories', 'products', 'list_products', 'countCart', 'sumTotal'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $search_products = Product::orderby('created_at', 'DESC')->get();
        $search_products = $search_products->collect()->filter(function ($search_product) use ($search) {
            if (
                Str::contains(strtolower($search_product->name), strtolower($search)) ||
                Str::contains($search_product->name_ar, $search)
            ) {
                if (app()->getlocale() == 'ar') {
                    $search_product->name = $search_product->name_ar;
                    $search_product->description = $search_product->description_ar;
                }

                return $search_product;
            }
        });
        $categories = Category::withCount(['products'])->get();
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');

        return view('landinpage.products.search', compact('search_products', 'products', 'categories', 'countCart', 'sumTotal'));
    }

    public function filter(Request $request)
    {
        $filter = $request->get('category_id');
        $filterSubCategory = $request->get('sub_category_id');
        if ($filter != null) {
            $searchProducts = Product::whereIn('category_id', $filter)->get();
            $customer_id = Auth::user()->id ?? 'None';
            $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
            $categories = Category::withCount(['products'])->get();
            $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
            $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
            return view('landinpage.products.search', compact('searchProducts', 'products', 'categories', 'countCart', 'sumTotal'));
        } elseif ($filterSubCategory != null) {
            $searchProducts = Product::whereIn('sub_category_id', $filterSubCategory)->get();
            $customer_id = Auth::user()->id ?? 'None';
            $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
            $subCategories = SubCategory::withCount(['products'])->get();
            $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
            $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
            return view('landinpage.products.search-sub-category', compact('searchProducts', 'products', 'subCategories', 'countCart', 'sumTotal'));
        } else {
            toastr()->warning(trans('main.wrong'));
            return back();
        }
    }
}
