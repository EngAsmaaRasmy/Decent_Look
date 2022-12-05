<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $fillable = [
        'product_id',
        'customer_id',
        'quantity',
        'price',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id');
    }

    public function getImg1URL()
    {
        return Storage::url($this->img1);
    }

    public function setTotal()
    {
        $this->total = $this->price * $this->quantity;
    }

    public function getPriceAttribute()
    {
        $price = (float)$this->attributes['price'];
        return  number_format($price);
    }

    public function getTotalAttribute()
    {
        $total = (float)$this->attributes['total'];
        return  number_format($total);
    }
}
