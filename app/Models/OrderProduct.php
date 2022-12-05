<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'product_id',
        'order_id',
        'price',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    protected $appends = [
        'sub_total'
      ];

    public function getSubTotalAttribute()
    {
        $price = (float)$this->price;
        $quantity = (float)$this->quantity;
        return number_format($price * $quantity);
    }
}
