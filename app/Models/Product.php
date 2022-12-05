<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'name',
        'category_id',
        'quantity',
        'price',
        'description',
        'img1',
        'img2',
        'img3',
        'sub_category_id',
        'sub_sub_category_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo('App\Models\SubCategory', 'sub_category_id');
    }

    public function subSubCategory()
    {
        return $this->belongsTo('App\Models\SubSubCategory', 'sub_sub_category_id');
    }

    public function orderProducts()
    {
        return $this->hasMany('App\Models\OrderProduct', 'product_id');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart', 'product_id');
    }

    public function getImg1URL()
    {
        return Storage::url($this->img1);
    }

    public function getImg2URL()
    {
        return Storage::url($this->img2);
    }
    public function getImg3URL()
    {
        return Storage::url($this->img3);
    }


    protected $appends = [
        'name_ar', 'description_ar', 'slug', 'image_full_path','img2_full_path','img3_full_path',
    ];

    public function getImageFullPathAttribute()
    {
        return $this->img1 ? env('APP_URL') . 'uploads/products/' . $this->img1 : null;
    }

    public function getImg2FullPathAttribute()
    {
        return $this->img2 ? env('APP_URL') . 'uploads/products/' . $this->img2  : null;
    }
    public function getImg3FullPathAttribute()
    {
        return $this->img3 ? env('APP_URL') . 'uploads/products/' . $this->img3  : null;
    }

    public function getNameArAttribute()
    {
        $translation = Translation::where('model', 'Product')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'name')
            ->first();
        return $translation ? $translation->value : null;
    }

    public function getDescriptionArAttribute()
    {
        $translation = Translation::where('model', 'Product')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'description')
            ->first();

        return $translation ? $translation->value : null;
    }

    public function getSlugAttribute()
    {
        $slug = Slug::where('model', 'Product')
            ->where('row_id', $this->attributes['id'])
            ->first();

        return $slug ? $slug->value : null;
    }

    public function getPriceAttribute()
    {
        $price = (float)$this->attributes['price'];
        return  number_format($price);
    }
}
