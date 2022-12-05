<?php

namespace App\Models;

use App\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'image',
        'description'
    ];


    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id');
    }
    protected $appends = [
        'name_ar', 'description_ar', 'slug', 'image_full_path',
    ];


    public function getImageFullPathAttribute()
    {
        return $this->image ? env('APP_URL') . 'uploads/categories/' . $this->image : null;
    }

    public function getNameArAttribute()
    {
        $translation = Translation::where('model', 'Category')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'name')
            ->first();

        return $translation ? $translation->value : null;
    }

    public function getDescriptionArAttribute()
    {
        $translation = Translation::where('model', 'Category')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'description')
            ->first();

        return $translation ? $translation->value : null;
    }

    public function getSlugAttribute()
    {
        $slug = Slug::where('model', 'Category')
            ->where('row_id', $this->attributes['id'])
            ->first();

        return $slug ? $slug->value : null;
    }
}
