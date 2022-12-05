<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\SubSubCategory;
use Illuminate\Support\Facades\Auth;

class SubSubCategoryController extends Controller
{
    public function show($id)
    {
        $subSubCategory = SubSubCategory::find($id);
        $productsSubSubCategory = Product::where('sub_sub_category_id', $subSubCategory->id)->get();
        $subSubCategories = SubSubCategory::withCount(['products'])->get();
        $customer_id = Auth::user()->id ?? 'None';
        $products = Cart::with(['product'])
        ->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate('4');
        $countCart = Cart::where('customer_id', Auth::user()->id ?? 'None')->count();
        $sumTotal = Cart::where('customer_id', Auth::user()->id ?? 'None')->sum('total');
        return view('landinpage.subSubCategory.show', compact('productsSubSubCategory', 'subSubCategories', 'subSubCategory', 'countCart', 'sumTotal', 'products'));
     }
}
