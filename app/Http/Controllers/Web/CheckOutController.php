<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Auth;

class CheckOutController extends Controller
{
    public function checkout()
    {
        $customer_id = Auth::user()->id ??'None';
        $orders = Order::with('status')->where
        ('customer_id', $customer_id)->orderBy('created_at')->paginate('10');
        $categories = Category::withCount(['products'])->get();
        $products = Cart::with(['product'])->where
        ('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        $sumQuantity = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('quantity');

        return view('landinpage.orders.checkout', compact('sumQuantity','categories', 'orders','products', 'countCart', 'sumTotal'));
    }


    public function order(Request $request)
    {
        $input = $request->all();
        $cartProducts = Cart::where('customer_id', Auth::user()->id)->get();
        $input['total'] = 0;
        $input['status_id'] = 1;
        if (count($cartProducts) > 0) {
            $order = Order::create($input); 
            foreach ($cartProducts as $key => $order_product) {
                $product = Product::find($order_product->product_id);
                if (!$product) {
                    toastr()->warning(trans('main.product_not_found'));
                    return back();
                }
                $new_order_product = OrderProduct::create([
                    'price' => $product->price,
                    'quantity' => $order_product->quantity,
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                ]);
                if (!$new_order_product) {
                    toastr()->warning(trans('main.wrong'));
                    return back();
                }
            }
            $orderProducts = OrderProduct::where('order_id', $order->id)
                ->select(OrderProduct::raw('sum(quantity * price) as total'))->first();
            $order->total = $orderProducts->total ;
            $order->save();
            $order->products = $order->products;
            $deleted = Cart::where('customer_id', $input['customer_id'])->delete();
            if (!$deleted) {
                toastr()->warning(trans('main.wrong'));
                return back();
            }
            toastr()->success(trans('main.order_created_successfully'));
            return redirect()->intended('/dashboard');
        } else {
            toastr()->warning(trans('main.cart_is_empty'));
            return back();
        }
    }
}
