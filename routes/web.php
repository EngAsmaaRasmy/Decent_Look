<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Api;
use App\Http\Controllers\InfoUsController;
use App\Http\Controllers\Web;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Spatie\Analytics\Period;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Web\SubCategoryController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
    return view('welcome', ['analyticsData' => $analyticsData]);
});
Route::get('lang/{lang}', [LocalizationController::class, 'index'])->name('lang.switch');

Route::get('/', function () {
    $customer_id = Auth::user()->id ?? 'None';
    $products = Cart::with(['product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
    $categories = Category::withCount(['products'])->get();
    $allProducts = Product::with('category')->orderBy('created_at', 'desc')->paginate('7');
    $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
    $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
    return view('/home', compact('customer_id', 'allProducts', 'categories', 'products', 'countCart', 'sumTotal'));
})->name('home');


Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::get('/dashboard', [SessionController::class, 'dashboard'])->name('dashboard');
Route::post('/login', [SessionController::class, 'store'])->name('custmer.login');
Route::get('/logout', [SessionController::class, 'destory'])->name('logout');
Route::get('/registeration', [RegisterController::class, 'registeration'])->name('registeration');
Route::resource('register', RegisterController::class);
Route::get('/show-login-form', [SessionController::class, 'showLoginForm'])->name('show.login');
Route::get('forget-password', [RegisterController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [RegisterController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [RegisterController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [RegisterController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::resource('customer-account', SessionController::class);

Route::group(['prefix' => ''], function () {
    Route::get('/lang/{lang}', [LocalizationController::class, 'index'])->name('lang.switch');
    Route::resource('web-site-categories', Web\CategoryController::class);
    Route::resource('web-site-sub-categories', Web\SubCategoryController::class);
    Route::resource('web-site-sub-sub-categories', Web\SubSubCategoryController::class);
    Route::get('shoping', [Web\CategoryController::class, 'shoping'])->name('shoping');
    Route::resource('web-site-products', Web\ProductController::class);
    Route::get('filter', [Web\ProductController::class, 'filter'])->name('product.filter');
    Route::resource('web-site-orders', Web\OrderController::class);
    Route::post('add-to-cart', [Web\CartController::class, 'addProductToCart'])->name('cart.store')->middleware('auth');
    Route::get('cart-products', [Web\CartController::class, 'cartProducts'])->name('cart.products');
    Route::post('cart-remove/{product_id}', [Web\CartController::class, 'removeProductFromCart'])->name('cart.remove');
    Route::post('cart-update/{id}', [Web\CartController::class, 'updateProductInCart'])->name('cart.update');
    Route::get('check-out', [Web\CheckOutController::class, 'checkout'])->name('order.checkout')->middleware('auth');
    Route::post('add-to-orders', [Web\CheckOutController::class, 'order'])->name('create.orders')->middleware('auth');
    Route::get('about-us', [InfoUsController::class, 'about'])->name('about');
    Route::get('contact-us', [InfoUsController::class, 'contact'])->name('contact');
    Route::get('search', [Web\ProductController::class, 'search'])->name('products.search');
    Route::get('quick-view/{id}', [Web\ProductController::class, 'quickView'])->name('products.quickView');
});

Route::get('/migrate', function () {
    Artisan::call('migrate', array('--force' => true));
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Migrating Is Done";
});
