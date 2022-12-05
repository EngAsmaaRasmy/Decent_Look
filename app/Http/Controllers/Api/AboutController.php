<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;
use DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;

class AboutController extends Controller
{


    use ApiResponser;
    use SlugTrait;
    use TranslationTrait;

    public function index()
    {
        return DataTables::of(About::query()->orderBy('created_at', 'desc'))
            ->addColumn('created_at', function ($about) {
                return $about->created_at;
            })
            ->addColumn('description_ar', function ($about) {
                return $about->description_ar;
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['created_at', 'description_ar'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = FacadesValidator::make($input, [
            'name' => 'required|unique:abouts,name',
            'adress'    => 'max:100000',
            'phone'      => 'max:14',
            'email'        => 'email|unique:abouts',
            'url_facebook' => 'max:100000',
            'url_whatsap'    => 'max:1000',
            'url_instgram'    => 'max:1000',
            'description'         => 'max:100000',
        ]);

        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422, $validator->errors());
        }
        $about = About::create($input);
        $input['slug'] = $this->createSlug('About', $about->id, $about->name, 'abouts');

        if ($request->file('logo')) {
            $image_name = md5($about->id . "app" . $about->id . rand(1, 1000));

            $image_ext = $request->file('logo')->getClientOriginalExtension(); // example: png, jpg ... etc

            $image_full_name = $image_name . '.' . $image_ext;

            $uploads_folder =  getcwd() . '/uploads/';

            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }
            $request->file('logo')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $about->image =  $image_full_name;
        }
        $about->save();
        $this->translate($request, 'About', $about->id);
        return $this->success(['about' => $about], trans('main.about_create_success'));
    }

    public function show($id)
    {
        $abouts = About::find($id);
        if (!$abouts) {
            return $this->error(__('main.not_found'), 404);
        }
        return $this->success(['abouts' => $abouts]);
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $about = About::find($id);
        if (!$about) {
            return $this->error(__('main.not_found'), 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:abouts,name',
            'adress'    => 'max:100000',
            'phone'      => 'max:14',
            'email'        => 'email|unique:abouts',
            'url_facebook' => 'max:100000',
            'url_whatsap'    => 'max:1000',
            'url_instgram'    => 'max:1000',
            'description'         => 'max:100000',
        ]);
        if ($validator->fails()) {
            $message = implode("\n", $validator->errors()->all());
            return $this->error($message, 422, $validator->errors());
        }
        $about = About::find($id);
        $this->editSlug('Category', $about->id, $about->name, 'abouts');
        $about->update($input);
        if ($request->file('logo')) {
            $image_name = md5($about->id . "app" . $about->id . rand(1, 1000));
            $image_ext = $request->file('logo')->getClientOriginalExtension(); // example: png, jpg ... etc
            $image_full_name = $image_name . '.' . $image_ext;
            $uploads_folder =  getcwd() . '/uploads/';
            if (!file_exists($uploads_folder)) {
                mkdir($uploads_folder, 0777, true);
            }
            $request->file('logo')->move($uploads_folder, $image_name  . '.' . $image_ext);
            $about->logo =  $image_full_name;
        }
        $about->save();
        $this->editTranslation($request, 'About', $about->id);
        return $this->success(['about' => $about], __('main.about_update_success'));
    }
    public function destroy($id)
    {
        $about = About::find($id);
        if ($about->logo) {
            File::delete(public_path() . "/uploads/" . $about->logo);
        }
        $about->delete();
        return $this->success('', trans('main.about_delete_success'));
    }
}
