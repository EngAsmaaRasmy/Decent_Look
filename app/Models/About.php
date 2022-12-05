<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;


    public $fillable = [
        'id',
        'name',
        'adress',
        'phone',
        'email',
        'url_facebook',
        'url_whatsap',
        'url_instgram',
        'description',
        'about_me',
        'logo',

    ];
    protected $appends = [
        'name_ar', 'description_ar', 'about_me_ar','slug'
    ];

    public function getNameArAttribute()
    {
        $translation = Translation::where('model', 'About')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'name')
            ->first();

        return $translation ? $translation->value : null;
    }

    public function getDescriptionArAttribute()
    {
        $translation = Translation::where('model', 'About')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'description')
            ->first();

        return $translation ? $translation->value : null;
    }
    public function getAboutMeArAttribute()
    {
        $translation = Translation::where('model', 'About')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'about_me')
            ->first();

        return $translation ? $translation->value : null;
    }

    public function getSlugAttribute()
    {
        $slug = Slug::where('model', 'About')
            ->where('row_id', $this->attributes['id'])
            ->first();

        return $slug ? $slug->value : null;
    }
}
