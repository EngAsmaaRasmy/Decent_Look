<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderStatu;

class OrderStatuController extends Controller
{

    public function index()
    {
        return response()->json([
            'data' => OrderStatu::orderBy('name')->get(),
            'error' => false,
            'message' => ''
        ]);
    }
}
