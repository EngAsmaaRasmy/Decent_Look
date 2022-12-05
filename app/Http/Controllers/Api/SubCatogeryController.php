<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubCatogeryController extends Controller
{
    use ApiResponser;
    use SlugTrait;
    use TranslationTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return DataTables::of(SubCategory::query()->orderBy('created_at', 'desc'))
            ->addColumn('category', function ($subcategory) {

                return $subcategory->category->name ?? 'None';
            })
            ->addColumn('created_at', function ($subcategory) {
                return $subcategory->created_at;
            })
            ->rawColumns(['created_at', 'category'])
            ->make(true);
    }

    public function list()
    {
        $subCategories = SubCategory::orderby('created_at', 'DESC')->get();
        return $this->success(['subCategories' => $subCategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return $this->success(['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'category_id' => 'required',
            // 'image' => 'image|mimes:jpeg,jpg,gif,png|
            //  max:10240|dimensions:width=376,height=540',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422);
        }
        $subcategory = SubCategory::create($input);
        $input['slug'] = $this->createSlug('SubCategory', $subcategory->id, $subcategory->name, 'sub_categories');
        if ($request->file('image')) {
            $image_name = md5($subcategory->id . "app" . $subcategory->id . rand(1, 1000));

            $image_ext = $request->file('image')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/subCategories/';

            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }

            $request->file('image')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $subcategory->image =  $image_full_name;
        }
        $subcategory->save();
        $this->translate($request, 'SubCategory', $subcategory->id);
        return $this->success(['subcategory' => $subcategory], trans('main.subCategory_create_success'));
    }

    /**f
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $subcategory = SubCategory::with('Category')->find($id);
        return $this->success(['subcategory' => $subcategory]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = SubCategory::with('Category')->find($id);
        return $this->success(['subcategory' => $subcategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return $this->error(trans('main.item_not_found'), 404);
        }
        $validator = Validator::make($input, [
            'name' => 'required',
            'category_id' => 'required',
            'image' => 'image|mimes:jpeg,jpg,gif,png|
            max:10240|dimensions:width=376,height=540',
        ]);
        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422);
        }

        $subcategory = SubCategory::find($id);
        $this->editSlug('subcategory', $subcategory->id, $subcategory->name, 'sub_categories');
        $subcategory->update($input);
        if ($request->file('image')) {
            $image_name = md5($subcategory->id . "app" . $subcategory->id . rand(1, 1000));

            $image_ext = $request->file('image')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/subCategories/';

            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }

            $request->file('image')->move($uploads_folder, $image_name  . '.' . $image_ext);

            $subcategory->image =  $image_full_name;
        }
        $subcategory->save();
        $this->editTranslation($request, 'SubCategory', $subcategory->id);
        return $this->success(['subcategory' => $subcategory], trans('main.subCategory_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        if (!$subcategory) {
            return $this->error(trans('main.item_not_found'), 404);
        }
        if ($subcategory->image) {
            File::delete(public_path() . "/upload/subCategories/", $subcategory->image);
        }
        $subcategory->delete();
        return $this->success('', trans('main.subCategory_delete_success'));
    }
}
