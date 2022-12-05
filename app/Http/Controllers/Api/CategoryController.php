<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use ApiResponser;
    use SlugTrait;
    use TranslationTrait;

    public function index()
    {
        return DataTables::of(Category::query()->orderBy('created_at', 'desc'))
            ->addColumn('created_at', function ($category) {
                return $category->created_at;
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['created_at'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = FacadesValidator::make($input, [
            'name' => 'required|unique:categories,name',
            'image' => 'required|image|mimes:jpeg,jpg,gif,png|
            max:10240|dimensions:min_width=280,min_height=280'
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422, $validator->errors());
        }
        $category = Category::create($input);
        $input['slug'] = $this->createSlug('Category', $category->id, $category->name, 'categories');

        if ($request->file('image')) {
            $image_name = md5($category->id . "app" . $category->id . rand(1, 1000));

            $image_ext = $request->file('image')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/categories/';

            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }
            $request->file('image')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $category->image = $image_full_name;
        }
        $category->save();
        $this->translate($request, 'Category', $category->id);
        return $this->success(['category' => $category], trans('main.category_create_success'));
    }
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->error(__('main.not_found'), 404);
        }
        return $this->success(['category' => $category]);
    }
    public function edit($id)
    {
        $category = Category::find($id);
        return $this->success(['category' => $category]);
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $category = Category::find($id);
        if (!$category) {
            return $this->error(__('main.not_found'), 404);
        }
        $validator = FacadesValidator::make($input, [
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'image|mimes:jpeg,jpg,gif,png|
            max:10240|dimensions:min_width=280,min_height=280',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422, $validator->errors());
        }
        $category = Category::find($id);
        $this->editSlug('Category', $category->id, $category->name, 'categories');
        $category->update($input);
        if ($request->file('image')) {
            $image_name = md5($category->id . "app" . $category->id . rand(1, 1000));
            $image_ext = $request->file('image')->getClientOriginalExtension(); // example: png, jpg ... etc
            $image_full_name = $image_name . '.' . $image_ext;
            $uploads_folder =  getcwd() . '/uploads/categories/';

            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }
            $request->file('image')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $category->image =  $image_full_name;
        }
        $category->save();
        $this->editTranslation($request, 'Category', $category->id);

        return $this->success(['category' => $category], __('main.category_update_success'));
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->error(__('main.not_found'), 404);
        }
        if ($category->image) {
            File::delete(public_path() . "/uploads/categories/" . $category->image);
        }
        $category->delete();
        return $this->success('', trans('main.category_delete_success'));
    }
}
