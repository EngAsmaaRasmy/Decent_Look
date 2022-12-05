<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoUs extends Model
{
    use HasFactory;
    public $fillable = [
        'phone',
        'phone2',
        'email',
        'address',
        'social',
        'about',
    ];

    protected $appends = [
        'about_ar'
    ];

    public function getAboutArAttribute()
    {
        $translation = Translation::where('model', 'InfoUs')
            ->where('row_id', $this->attributes['id'])
            ->where('field', 'about')
            ->first();

        return $translation ? $translation->value : null;
    }
}
