<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;

class SessionController extends Controller
{

    public function showLoginForm()
    {
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $categories = Category::withCount(['products'])->get();
        $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('login');
    }
    public function dashboard()
    {
        $customer_id = Auth::user()->id ?? 'None';
        $orders = Order::with('status')->where('customer_id', $customer_id)->orderBy('created_at')->paginate('10');
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $categories = Category::withCount(['products'])->get();
        $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('dashboard', compact('orders', 'customer_id', 'allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
    }
    public function create()
    {
        return view('login');
    }
    public function store()
    {
        if (!auth()->attempt(request(['email', 'password']))) {
            toastr()->warning(trans('main.email_or_password_encorrect'));
            return back();
        } else {
            return redirect()->intended('/dashboard');
            toastr()->success(trans('main.login_authenticated_is_done'));
            $customer_id = Auth::user()->id ?? 'None';
            $orders = Order::with('status')->where('customer_id', $customer_id)->orderBy('created_at')->paginate('10');
            $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
            $categories = Category::withCount(['products'])->get();
            $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
            $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
            $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
            return view('dashboard', compact('orders', 'customer_id', 'allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
        }
    }

    public function update(Request $request, $id)
    {
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $categories = Category::withCount(['products'])->get();
        $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');

        $input = $request->all();
        $user = User::findOrfail($id);
        $user->update($input);
        if ($request->newPassword) {
            if ($request->newPassword == $request->confirmPassword && $request->newPassword != null) {
                $user = user::where('id', $id)->first();
                $user->update(['password'  => Hash::make($request->newPassword)]);
                return view('/dashboard', compact('customer_id', 'allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
                toastr()->success(trans('main.edit_password'));
            } else {
                return view('/dashboard', compact('customer_id', 'allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
                toastr()->warning(trans('main.doesnot_match'));
            }
        }
        return view('/dashboard', compact('customer_id', 'allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
        toastr()->success(trans('main.edit_account'));
    }

    public function destory()
    {
        auth()->logout();
        toastr()->success(trans('main.log_out'));
        return redirect('/');
    }
}
