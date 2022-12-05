<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;

class StatisticsController extends Controller
{

    use ApiResponser;
    use SlugTrait;
    use TranslationTrait;

    public function statisticsHomeDashborad()
    {
        $statistics_categories = Category::count();
        $statistics_products = Product::count();
        $statistics_customers = User::count();
        $statistics_orders = Order::count();
        return $this->success([
            'statistics_categories' => $statistics_categories,
            'statistics_products' => $statistics_products,
            'statistics_customers' => $statistics_customers,
            'statistics_orders' => $statistics_orders
        ]);
    }
}
