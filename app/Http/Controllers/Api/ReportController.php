<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;
use DataTables;

class ReportController extends Controller
{

    use ApiResponser;
    use SlugTrait;
    use TranslationTrait;
    public function reportCustomer()
    {
        $custmer = User::withCount(['orders'])->get();
        return DataTables::of($custmer)
            ->addColumn('created_at', function ($order) {
                return  $order->created_at;
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['created_at'])
            ->make(true);
    }
    public function reportProduct()
    {
        $products = Product::withCount(['orderProducts'])->get();
        return DataTables::of($products)
            ->addColumn('name', function ($product) {
                return  $product->name ?? 'None';
            })
            ->addColumn(category, function ($product) {
                return  $product->catogery->name ?? 'None';
            })
            ->addColumn('created_at', function ($order) {
                return  $order->created_at;
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['created_at', category])
            ->make(true);
    }
}
