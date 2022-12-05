<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth ;

class SubCategoryController extends Controller
{
    public function show($id)
    {
        $subCategory = SubCategory::find($id);
        $productsSubCategory = Product::where('sub_category_id', $subCategory->id)->get();
        $subCategories = SubCategory::withCount(['products'])->get();
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])
        ->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('landinpage.subcategory.show', compact('productsSubCategory', 'subCategories', 'subCategory', 'countCart', 'sumTotal', 'products'));
     }
}
