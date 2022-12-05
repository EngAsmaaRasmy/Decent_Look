<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;
use DataTables;

class OrderController extends Controller
{

    use ApiResponser;
    use SlugTrait;
    use TranslationTrait;

    public function index(Request $request)
    {
        return DataTables::of(Order::query()->orderBy('created_at', 'desc'))
            ->addColumn('status', function ($order) {
                return  $order->status->name;
            })
            ->addColumn('email', function ($order) {
                return $order->customer->email;
            })
            ->addColumn('name', function ($order) {
                return  $order->customer->name;
            })
            ->addColumn('total', function ($order) {
                return $order->total;
            })
            ->addColumn('created_at', function ($order) {
                return $order->created_at;
            })
            ->addColumn('view', function ($order) {
                $action = '';
                $action .= '<a href="/admin-dashboard/orders/' . $order->id . '" class="btn btn-xs btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                return $action;
            })
            ->addColumn('edit', function ($order) {
                $action = '';
                $action .= '<a href="/admin-dashboard/orders/' . $order->id . '/edit" class="btn btn-xs btn-primary"><i class="far fa-edit"></i></a>';
                return $action;
            })
            ->addColumn('created_at', function ($order) {

                return  $order->created_at;
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['status', 'email', 'name', 'created_at', 'view', 'edit'])
            ->make(true);
    }
    public function show($id)
    {
        $order = Order::with(['customer', 'status'])->find($id);
        if (!$order) {
            return $this->error(__('main.not_found'), 404);
        }
        $order->products = OrderProduct::with(['product'])->where('order_id', $id)->get();
        return $this->success(['order' => $order]);
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();
        $order = Order::find($id);
        if (!$order) {
            return $this->error(__('item_not_found'), 404);
        }
        $order->status_id = $input['status_id'];
        $order->total = $input['total'];
        $order->save();
        return $this->success(['order' => $order], __('main.Order_update_success'));
    }
}
