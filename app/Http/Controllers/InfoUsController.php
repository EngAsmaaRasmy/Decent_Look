<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class InfoUsController extends Controller
{

    public function about()
    {
        $info = About::first();
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $categories = Category::withCount(['products'])->get();
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');

        return view('landinpage.informations.about', compact('info', 'products', 'categories', 'countCart', 'sumTotal'));
    }
    public function contact()
    {
        $info = About::first();
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $categories = Category::withCount(['products'])->get();
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');

        return view('landinpage.informations.contact', compact('info', 'products', 'categories', 'countCart', 'sumTotal'));
    }
}
