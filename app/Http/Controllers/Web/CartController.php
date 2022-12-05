<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Category;
use Validator;
use Auth;

class CartController extends Controller
{

    public function addProductToCart(Request $request)
    {
        $input = $request->all();
        $this->validate(request(), [
            'product_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);
        if (Cart::where('customer_id' ,Auth::user()->id)->where('product_id', $input['product_id'])->count() > 0) {
            toastr()->warning(trans('main.already_in_cart'));
            return back();
        } else {
            $item = Cart::create([
                'product_id' => $request->product_id,
                'customer_id' => Auth::user()->id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $request->price * $request->quantity,
            ]);
            if (!$item) {
                toastr()->warning(trans('main.not_add_to_cart'));
                return back();
            }
            toastr()->success(trans('main.cart_is_done'));
            return back();
        }    
    }
    public function updateProductInCart(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_id' => 'required',
            'quantity' => 'required',
        ]);
        $input['customer_id'] = Auth::user()->id ?? 'None';
        $cart = Cart::find($id);
        $input['total'] = $input['price'] * $input['quantity'];

        if (!$cart) {
            toastr()->error(trans('main.items_ot_exist'));
            return back();
        }
        $cart->update($input);
        if (!$cart) {
            toastr()->warning(trans('main.wrong'));
            return back();
        }
        toastr()->success(trans('main.quantity_update_successfully'));
        return redirect()->route('cart.products');
    }

    public function cartProducts(Request $request)
    {
        $categories = Category::withCount(['products'])->get();
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $subtotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('landinpage.cart.cart', compact('categories', 'products', 'subtotal', 'countCart', 'sumTotal'));
    }

    public function removeProductFromCart(Request $request, $product_id)
    {
        $customer_id = Auth::user()->id ?? 'None';
        $product = Cart::where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->first();
        if (!$product) {
            toastr()->warning(trans('main.items_ot_exist'));
            return back();
        }
        $deleted = $product->delete();
        if (!$deleted) {
            toastr()->warning(trans('main.wrong'));
            return back();
        }
        toastr()->error(trans('main.product_deleted'));
        return redirect()->route('cart.products');
    }
}
