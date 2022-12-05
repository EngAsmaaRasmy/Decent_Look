<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


    public function show($id)
    {
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])
            ->where('customer_id', $customer_id)
            ->orderBy('created_at', 'desc')->paginate('4');
        $order = Order::with('status')->find($id);
        $categories = Category::withCount(['products'])->get();
        $order_products = OrderProduct::whereHas('product', function ($query) use ($order) {
            $query->where('order_id', $order->id);
        })
            ->with(['product'])->orderBy('id', 'DESC')->get();
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        $orderNumber = str_pad($order->id , 5, "0", STR_PAD_RIGHT);
        return view(
            'landinpage.orders.show',
            compact('orderNumber','categories', 'products', 'order', 'order_products', 'countCart', 'sumTotal')
        );
    }
}
