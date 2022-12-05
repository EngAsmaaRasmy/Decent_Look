<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'image',
        'description',
        'category_id'
    ];


    public function getImageFullPathAttribute()
    {
        return $this->image ? env('APP_URL') . 'uploads/subCategories/' . $this->image : null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'sub_category_id');
    }

    protected $appends = [
        'name_ar', 'description_ar', 'slug','image_full_path'
    ];

    public function getNameArAttribute()
    {
        $translation = Translation::where('model', 'SubCategory')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'name')
            ->first();

        return $translation ? $translation->value : null;
    }

    public function getDescriptionArAttribute()
    {
        $translation = Translation::where('model', 'SubCategory')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'description')
            ->first();

        return $translation ? $translation->value : null;
    }

    public function getSlugAttribute()
    {
        $slug = Slug::where('model', 'SubCategory')
            ->where('row_id', $this->attributes['id'])
            ->first();

        return $slug ? $slug->value : null;
    }
}
