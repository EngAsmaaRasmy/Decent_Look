<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Traits\ApiResponser;
use App\Traits\SlugTrait;
use App\Traits\TranslationTrait;
use DataTables;

class CustomerController extends Controller
{
    use ApiResponser;
    use SlugTrait;
    use TranslationTrait;
    public function index()
    {
        return DataTables::of(User::query()->orderBy('created_at', 'desc'))
            ->addColumn('created_at', function ($order) {
                return  $order->created_at;
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['created_at'])
            ->make(true);
    }

    public function show($id)
    {
        $customers = User::find($id);
        if (!$customers) {
            return $this->error(__('main.not_found'), 404);
        }
        return $this->success(['custmers' => $customers]);
    }
    public function destroy($id)
    {
        $customers = User::find($id);
        if (!$customers) {
            return $this->error(__('main.not_found'), 404);
        }
        $customers = Order::where('customer_id', $id)->get();
        if (count($customers) > 0) {
            return $this->error(trans('main.custmer_has_order'), 422);
        }

        User::find($id)->delete();
        return $this->success('', trans('main.Customer_delete_success'));
    }
}
