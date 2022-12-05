
@extends('layouts.base',['title'=>'Order'])
@section('main')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{trans('site.checkout')}}</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('site.home')}} </a></li>
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('site.dashboard')}} </a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('site.order_details')}} </li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="checkout">
            <div class="container ">	
                <form action="#">
                    <div class="row">
                        <aside class="col-lg-9 ">
                            <div class="summary">
                                <h3 class="summary-title text-center">{{trans('site.your_orders')}} </h3><!-- End .summary-title -->

                                <table class="table table-summary">
                                    <thead>
                                        <tr>
                                            <th>{{trans('site.order_number')}} </th>
                                            <td>{{$orderNumber}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('site.order_status')}}</th>
                                            <td>{{$order->status->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('site.payment_mehod')}}</th>
                                            @if($order->paid_way == 1)
                                            <td>{{trans('site.bank')}}</td>
                                            @else
                                            <td>{{trans('site.cash')}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>{{trans('site.total_amount')}} </th>
                                            <td>{{$order->total}} 
                                                @if(App::getlocale()=='ar')
                                                ج.س
                                                @else
                                                SDG 
                                                @endif
                                            </td>
                                        </tr>
                                        <tr >
                                            <table class="table mt-5">
                                                <tr>
                                                    <th>{{trans('site.product')}} </th><th></th><th></th>
                                                    <th>{{trans('site.price')}} </th><th></th>
                                                    <th class="text-center">{{trans('site.quantity')}} </th><th></th><th></th>
                                                    <th>{{trans('site.total')}} </th>
                                                </tr>
                                                @foreach($order_products as $order_product)
                                                <tr>
                                                    <td>
                                                        @if(App::getlocale()=='ar')
                                                        {{$order_product->product->name_ar??'none' }}
                                                            @else
                                                            {{$order_product->product->name??'none' }}
                                                            @endif
                                                        </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{$order_product->price??'none' }} 
                                                        @if(App::getlocale()=='ar')
                                                        ج.س
                                                        @else
                                                        SDG 
                                                        @endif
                                                    </td>
                                                    <td></td>
                                                    <td class="text-center">{{$order_product->quantity??'none' }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{$order_product->sub_total??'none' }} 
                                                        @if(App::getlocale()=='ar')
                                                        ج.س
                                                        @else
                                                        SDG 
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </tr>
                                    </thead>
                                </table>
                            </div><!-- End .summary --> 
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </form>
            </div><!-- End .container -->
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection
