<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubSubCategoryController extends Controller
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

        return DataTables::of(SubSubCategory::query()->orderBy('created_at', 'desc'))
            ->addColumn('category', function ($subSubcategory) {

                return $subSubcategory->category->name ?? 'None';
            })
            ->addColumn('subCategory', function ($subSubcategory) {

                return $subSubcategory->category->name ?? 'None';
            })
            ->addColumn('created_at', function ($subSubcategory) {
                return $subSubcategory->created_at;
            })
            ->rawColumns(['created_at', 'category', 'subCategory'])
            ->make(true);
    }

    public function list()
    {
        $subSubCategories = SubSubCategory::orderby('created_at', 'DESC')->get();
        return $this->success(['subSubCategories' => $subSubCategories]);
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
            'sub_category_id' => 'required',
            // 'image' => 'image|mimes:jpeg,jpg,gif,png|
            //  max:10240|dimensions:width=376,height=540',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422);
        }
        $subSubcategory = SubSubCategory::create($input);
        $input['slug'] = $this->createSlug('SubSubcategory', $subSubcategory->id, $subSubcategory->name, 'sub_sub_categories');
        if ($request->file('image')) {
            $image_name = md5($subSubcategory->id . "app" . $subSubcategory->id . rand(1, 1000));

            $image_ext = $request->file('image')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/subSubCategories/';

            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }

            $request->file('image')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $subSubcategory->image =  $image_full_name;
        }
        $subSubcategory->save();
        $this->translate($request, 'SubSubCategory', $subSubcategory->id);
        return $this->success(['subSubCategory' => $subSubcategory], trans('main.subSubCategory_create_success'));
    }

    /**f
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $subSubcategory = SubSubCategory::with('category', 'subCategory')->find($id);
        return $this->success(['subSubcategory' => $subSubcategory]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subSubcategory = SubSubCategory::with('category', 'subCategory')->find($id);
        return $this->success(['subSubcategory' => $subSubcategory]);
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
        $subSubcategory = SubSubCategory::find($id);
        if (!$subSubcategory) {
            return $this->error(trans('main.item_not_found'), 404);
        }
        $validator = Validator::make($input, [
            'name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            // 'image' => 'image|mimes:jpeg,jpg,gif,png|
            // max:10240|dimensions:width=376,height=540',
        ]);
        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422);
        }

        $subSubcategory = SubSubCategory::find($id);
        $this->editSlug('subSubcategory', $subSubcategory->id, $subSubcategory->name, 'sub_sub_categories');
        $subSubcategory->update($input);
        if ($request->file('image')) {
            $image_name = md5($subSubcategory->id . "app" . $subSubcategory->id . rand(1, 1000));

            $image_ext = $request->file('image')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/subSubCategories/';

            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }

            $request->file('image')->move($uploads_folder, $image_name  . '.' . $image_ext);

            $subSubcategory->image =  $image_full_name;
        }
        $subSubcategory->save();
        $this->editTranslation($request, 'SubSubCategory', $subSubcategory->id);
        return $this->success(['subSubcategory' => $subSubcategory], trans('main.subCategory_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subSubCategory = SubSubCategory::find($id);
        if (!$subSubCategory) {
            return $this->error(trans('main.item_not_found'), 404);
        }
        if ($subSubCategory->image) {
            File::delete(public_path() . "/upload/subSubCategories/", $subSubCategory->image);
        }
        $subSubCategory->delete();
        return $this->success('', trans('main.subCategory_delete_success'));
    }
}
