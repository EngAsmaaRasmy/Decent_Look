<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mail;

class RegisterController extends Controller
{
    public function index()
    {

        return view('landinpage.custmers.index');
    }


    public function registeration()
    {
        return view('landinpage.custmers.create');
    }

    public function store(Request $request)
    {

        $input = $request->all();
        $this->validate(request(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'address' => 'nullable',
        ]);
        $users = User::create($input);
        $token = uniqid(base64_encode(Str::random(40)));
        $users->remember_token = $token;
        $users->password = Hash::make($request->password); 
        $users->save();
        toastr()->info(trans('main.register_customer_is_done'));
        auth()->login($users);
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $categories = Category::withCount(['products'])->paginate('2');
        $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return redirect()->intended('/dashboard');
        return view('dashboard', compact('allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
    }
    public function showForgetPasswordForm()
    {
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $categories = Category::withCount(['products'])->paginate('2');
        $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('forget-password', compact('allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
    }

    public function submitForgetPasswordForm(Request $request)
    {

        $request->validate([
            'email' => 'required',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forget-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        toastr()->success(trans('main.reset_password'));
        return redirect('/');
    }

    public function showResetPasswordForm($token)
    {
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $categories = Category::withCount(['products'])->paginate('2');
        $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('forget-passwordLink', ['token' => $token], compact('allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', trans('main.token_invalid'));
            toastr()->warning(trans('main.token_invalid'));
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->newPassword)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        toastr()->success(trans('main.password_reset_successfully'));
        return redirect('/');
    }

}
