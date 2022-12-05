<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'total',
        'customer_id',
        'status_id',
        'paid_way',
    ];

    protected $dates = ['expired_at'];
    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\OrderStatu', 'status_id');
    }

    public function orderProducts()
    {
        return $this->hasMany('App\Models\OrderProduct', 'order_id');
    }

    public function getTotalAttribute()
    {
        $total = (float)$this->attributes['total'];
        return  number_format($total);
    }
}
