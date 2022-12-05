<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderChangeHistory extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'to_status_id',
        'from_status_id',
    ];
}
