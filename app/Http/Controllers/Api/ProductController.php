<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use ApiResponser;
    use SlugTrait;
    use TranslationTrait;

    public function index()
    {
        return DataTables::of(Product::query()->orderBy('created_at', 'desc'))
            ->addColumn('category', function ($product) {
                return $product->category->name_ar ?? 'None';
            })
            ->addColumn('subCategory', function ($product) {
                return $product->subCategory->name_ar ?? 'None';
            })
            ->addColumn('created_at', function ($product) {
                return $product->created_at;
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['created_at', 'category', 'subCategory'])
            ->make(true);
    }

    public function create()
    {
        return $this->success([
            'categories' => Category::orderBy('name')->get(),
            'subCategories' => SubCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = FacadesValidator::make($input, [
            'name' => 'required|unique:products,name',
            'quantity' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'img1' => 'required|image|mimes:jpeg,jpg,gif,png|max:10240',
            //    dimensions:width=376,height=540'
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422, $validator->errors());
        }
        $product = Product::create($input);
        $input['slug'] = $this->createSlug('Product', $product->id, $product->name, 'products');

        if ($request->file('img1')) {
            $image_name = md5($product->id . "app" . $product->id . rand(1, 1000));

            $image_ext = $request->file('img1')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/products/';
            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }
            $request->file('img1')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $product->img1 =  $image_full_name;
        }
        if ($request->file('img2')) {
            $image_name = md5($product->id . "app" . $product->id . rand(1, 1000));

            $image_ext = $request->file('img2')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/products/';
            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }
            $request->file('img2')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $product->img2 =  $image_full_name;
        }
        if ($request->file('img3')) {
            $image_name = md5($product->id . "app" . $product->id . rand(1, 1000));

            $image_ext = $request->file('img3')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/products/';
            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }
            $request->file('img3')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $product->img3 =  $image_full_name;
        }
        $product->save();
        $this->translate($request, 'Product', $product->id);
        return $this->success(['product' => $product], trans('main.product_create_success'));
    }

    public function show($id)
    {
        $product = Product::with('category', 'subCategory', 'subSubCategory')->find($id);
        return $this->success(['product' => $product]);
    }

    public function edit($id)
    {
        $product = Product::with('category', 'subCategory', 'subSubCategory')->find($id);
        return $this->success(['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $product = Product::find($id);
        if (!$product) {
            return $this->error(__('main.not_found'), 404);
        }
        $validator = FacadesValidator::make($input, [
            'name' => 'required|unique:products,name,' . $product->id,
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422, $validator->errors());
        }
        $product = Product::find($id);

        $this->editSlug('Product', $product->id, $product->name, 'products');

        $product->update($input);

        if ($request->file('img1')) {
            $image_name = md5($product->id . "app" . $product->id . rand(1, 1000));

            $image_ext = $request->file('img1')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/products/';

            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }
            $request->file('img1')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $product->img1 =  $image_full_name;
        }
        $product->save();
        $this->editTranslation($request, 'Product', $product->id);
        return $this->success(['product' => $product], __('main.Product_update_success'));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->error(__('main.not_found'), 404);
        }
        if ($product->img1) {
            File::delete(public_path() . "/uploads/products/" . $product->img1);
        }
        if ($product->img2) {
            File::delete(public_path() . "/uploads/products/" . $product->img2);
        }
        if ($product->img3) {
            File::delete(public_path() . "/uploads/products/" . $product->img3);
        }
        $product->delete();
        return $this->success('', trans('main.product_delete_success'));
    }
}
