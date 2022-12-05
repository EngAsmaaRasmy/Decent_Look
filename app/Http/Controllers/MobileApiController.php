<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendMail;
use App\Models\Customer;
use App\Models\CustomerLoginSession;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Seller;
use Validator;
use Illuminate\Validation\Rule;
use DB;

class MobileApiController extends Controller
{

    public function register(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'full_name' => 'required',
            'email' => 'nullable|email|unique:customers',
            'mobile' => 'required|unique:customers',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->apiResponse('', true, $message);
        }

        $input['password'] = Hash::make($input['password']);

        $input['verified'] = 1;

        $customer = Customer::create($input);
        $session = new CustomerLoginSession();
        $token = uniqid(base64_encode(Str::random(40)));
        $session->customer_id = $customer->id;
        $session->token = $token;
        $session->save();
        $customer->token = $token;

        return $this->apiResponse($customer, false, '');
    }

    public function verifiyOtp(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required',
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->apiResponse('', true, $message);
        }

        $customer = Customer::where('email', $input['email'])
            ->where('otp', $input['otp'])
            ->first();

        if (!$customer) {
            return $this->apiResponse('', true, __('strings.Wrong username or password'));
        }

        $token = uniqid(base64_encode(Str::random(40)));
        $session = CustomerLoginSession::create([
            'customer_id' => $customer->id,
            'token' => $token,
        ]);
        $customer->verified = 1;
        $customer->save();
        $customer->token = $token;
        return $this->apiResponse($customer, false, '');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->apiResponse('', true, $message);
        }

        $customer = Customer::where('mobile', $input['mobile'])
            ->first();
        if (!$customer) {
            return $this->apiResponse(['verified' => true, 'account' => false, 'password' => false], true, __('strings.Account Not found'));
        }
        $authenticated = Hash::check($input['password'], $customer->password);

        if (!$authenticated) {
            return $this->apiResponse(['verified' => true, 'account' => true, 'password' => false], true, __('strings.Wrong password'));
        }

        $token = uniqid(base64_encode(Str::random(40)));

        $session = CustomerLoginSession::where('customer_id')
            ->first();

        if (!$session) {
            $session = new CustomerLoginSession();
            $session->customer_id = $customer->id;
            $session->token = $token;
            $session->save();
            $customer->token = $token;
            return $this->apiResponse($customer, false, '');
        } else {
            return $this->apiResponse('', true, __('strings.Session is expired'));
        }
    }

    public function logout(Request $request)
    {
        $input = $request->all();
        if (isset($input['token'])) {
            $session = CustomerLoginSession::where('token', $input['token'])->first();
            if ($session) {
                $session->expired = 1;
                $session->save();
                return $this->apiResponse('', false, 'logout');
            }
        }
    }

    public function categoires(Request $request)
    {
        $categories = Category::with('products')->get();
        return $this->apiResponse($categories, false, '');
    }

    public function sellers(Request $request)
    {
        $sellers = Seller::with('products')->get();
        return $this->apiResponse($sellers, false, '');
    }

    public function products()
    {
        $products = Product::with(['category', 'seller'])->get();
        return $this->apiResponse($products, false, '');
    }

    public function addProductToCart(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_id' => 'required',
            'quntity' => 'required',
        ]);
        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->apiResponse('', true, $message);
        }

        $token = $request->bearerToken();

        $input['customer_id'] = CustomerLoginSession::where('token', $token)->first()->customer->id;

        $item = Cart::create($input);

        if (!$item) {
            return $this->apiResponse('', true, __('strings.Something went wrong'));
        }

        return $this->apiResponse($item, false, __('strings.Done Successfully'));
    }

    public function updateProductInCart(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'product_id' => 'required',
            'quntity' => 'required',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->apiResponse('', true, $message);
        }

        $token = $request->bearerToken();

        $input['customer_id'] = CustomerLoginSession::where('token', $token)->first()->customer->id;

        $cart = Cart::find($id);
        if (!$cart) {
            return $this->apiResponse('', true, __('strings.Not found'));
        }

        $cart = $cart->update($input);

        if (!$cart) {
            return $this->apiResponse('', true, __('strings.Something went wrong'));
        }

        return $this->apiResponse($cart, false, __('strings.Done Successfully'));
    }


    public function cartProducts(Request $request)
    {
        $customer_id = CustomerLoginSession::where('token', $request->bearerToken())->first()->customer->id;
        $products = Cart::with(['product'])->where('customer_id', $customer_id)->get();
        return $this->apiResponse($products, false, '');
    }

    public function removeProductFromCart(Request $request, $product_id)
    {
        $token = $request->bearerToken();

        $customer_id = CustomerLoginSession::where('token', $token)->first()->customer->id;

        $product = Cart::where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->first();

        if (!$product) {
            return $this->apiResponse('', true, __('strings.Item Not Exist'));
        }

        $deleted = $product->delete();
        if (!$deleted) {
            return $this->apiResponse('', true, __('strings.Something went wrong'));
        }

        return $this->apiResponse($product, false, __('strings.Deleted Successfully'));
    }

    public function createOrder(Request $request)
    {
        $token = $request->bearerToken();

        $input['customer_id'] = CustomerLoginSession::where('token', $token)->first()->customer->id;

        $cartProducts = Cart::where('customer_id', $input['customer_id'])->get();

        if (count($cartProducts) > 0) {
            $input['total'] = 0;
            $order = Order::create($input);
            foreach ($cartProducts as $key => $order_product) {
                $product = Product::find($order_product->product_id);
                if (!$product) {
                    return $this->apiResponse('', true, __('strings.Product Not Found'));
                }

                $new_order_product = OrderProduct::create([
                    'price' => $product->price,
                    'quntity' => $order_product->quntity,
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                ]);

                if (!$new_order_product) {
                    return $this->apiResponse('', true, __('strings.Something went wrong'));
                }
            }

            $orderProducts = OrderProduct::where('order_id', $order->id)->select(DB::raw('sum(quntity * price) as total'))->get();
            $order->total = $orderProducts[0]->total ? $orderProducts[0]->total : 0;
            $order->save();

            $order->products = $order->products;
            $deleted = Cart::where('customer_id', $input['customer_id'])->delete();
            if (!$deleted) {
                return $this->apiResponse($order, true, __('strings.Something went wrong'));
            }
            return $this->apiResponse($order, false, __('strings.Order Created Successfully'));
        } else {
            return $this->apiResponse('', true, __('strings.Cart is Empty'));
        }
    }

    public function orders(Request $request)
    {
        $token = $request->bearerToken();
        $customer_id = CustomerLoginSession::where('token', $token)->first()->customer->id;
        $orders = Order::with(['status', 'orderProducts'])->where('customer_id', $customer_id)->get();
        return $this->apiResponse($orders, false, '');
    }

    public function sendOtp(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->apiResponse('', true, $message);
        }

        $customer = Customer::where('email', $input['email'])
            ->first();

        if (!$customer) {
            return $this->apiResponse('', true, __('strings.Account Not found'));
        }
        $otp = rand(1000, 9999);
        $customer->otp = $otp;
        $customer->save();
        $this->sendEmail([
            'email' => $customer->email,
            'otp' => $otp,
        ]);
        return $this->apiResponse($customer, false, __('strings.OTP code send to email'));
    }

    public function sendEmail($data)
    {
        Mail::to($data['email'])->send(new SendMail($data));
    }

    public function profile(Request $request)
    {
        $token = $request->bearerToken();

        $customer = CustomerLoginSession::where('token', $token)->first()->customer;
        if (!$customer) {
            return $this->apiResponse([], true, __('strings.Customer is not registered'));
        }
        return $this->apiResponse($customer, false, '');
    }

    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $token = $request->bearerToken();

        $customer = CustomerLoginSession::where('token', $token)->first()->customer;
        if (!$customer) {
            return $this->apiResponse([], true, __('strings.Customer is not registered'));
        }

        $validator = Validator::make($input, [
            'full_name' => 'required',
            'email' => ['nullable', 'email', Rule::unique('customers')->ignore($customer->id)],
            'mobile' => ['required', Rule::unique('customers')->ignore($customer->id)],
            'password' => 'nullable|confirmed',
        ]);
        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->apiResponse('', true, $message);
        }
        $message = __('strings.Update profile success');
        if ($customer->email != $input['email']) {
            $otp = rand(1000, 9999);
            $input['otp'] = $otp;
            $this->sendEmail([
                'email' => $input['email'],
                'otp' => $otp,
            ]);
            $message = __('strings.OTP code send to email');
        }
        $customer->update($input);

        return $this->apiResponse($customer, false, $message);
    }

    private function apiResponse($data, $error, $message)
    {
        return response()->json([
            'data' => $data,
            'error' => $error,
            'message' => $message
        ]);
    }
}
