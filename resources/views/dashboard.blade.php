@extends('layouts.base',['title'=>'Dashboard'])
@section('main')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('')}}assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{trans('site.my_account')}}<span></span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">{{trans('site.dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{Auth::user()->name}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    <aside class="col-md-4 col-lg-3">
                        <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">{{trans('site.dashboard')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">{{trans('site.orders')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">{{trans('site.account_details')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('logout')}}">{{trans('site.log_out')}}</a>
                            </li>
                        </ul>
                    </aside><!-- End .col-lg-3 -->

                    <div class="col-md-8 col-lg-9">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                @if(App::getlocale()=='ar')
                                <p>مرحبا <span class="font-weight-normal text-dark">{{Auth::user()->name}}</span> (ليس <span class="font-weight-normal text-dark">مستخدم</span>? <a href="{{url('logout')}}">تسجيل خروج</a>) 
                                    <br>
                                    من لوحة تحكم حسابك يمكنك عرض <a href="#tab-orders" class="tab-trigger-link link-underline">طلباتك الأخيرة ،</a>,  <a href="#tab-account" class="tab-trigger-link">وتعديل كلمة المرور وتفاصيل الحساب</a>.</p>
                                @else
                                <p>Hello <span class="font-weight-normal text-dark">{{Auth::user()->name}}</span> (not <span class="font-weight-normal text-dark">User</span>? <a href="{{url('logout')}}">Log out</a>) 
                                <br>
                                From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
                            @endif
                            </div><!-- .End .tab-pane -->
                            

                            <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
                                @if($orders == null)
                                <p>No order has been made yet.</p>
                                <a href="category.html" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                                @else
                                <table class="table table">
                                    <thead>
                                        <tr>
                                            <th>{{trans('site.order_no')}}</th>
                                            <th> {{trans('site.total')}}</th>
                                            <th>{{trans('site.status')}}</th>
                                            <th> {{trans('site.created_at')}}</th>
                                            <th> {{trans('site.details')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach($orders as $order)
                                        <tr style="font-size: 17px;">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$order->total}} 
                                                @if(App::getlocale()=='ar')
                                                ج.س
                                                @else
                                                SDG 
                                                @endif
                                            </td>
                                            @if($order->status->name == 'pending')
                                            <td class="text-danger">{{$order->status->name}}</td>
                                            @elseif($order->status->name == 'underprocessing')
                                            <td class="text-warning">{{$order->status->name}}</td>
                                            @else
                                            <td class="text-success">{{$order->status->name}}</td>
                                            @endif
                                            <td>{{$order->created_at}}</td>
                                            <td><a href="{{route ('web-site-orders.show', [$order->id])}}"><span class="icon"><i class="icon icon-eye" title="  Show Order Details "></i></span></a>
                                            </td>  
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table><!-- End .table table-summary -->
                                @endif
                            </div><!-- .End .tab-pane -->


                            <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
                                <p>No downloads available yet.</p>
                                <a href="category.html" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
                                <p>The following addresses will be used on the checkout page by default.</p>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Billing Address</h3><!-- End .card-title -->

                                                <p>User Name<br>
                                                User Company<br>
                                                John str<br>
                                                New York, NY 10001<br>
                                                1-234-987-6543<br>
                                                yourmail@mail.com<br>
                                                <a href="#">Edit <i class="icon-edit"></i></a></p>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->

                                    <div class="col-lg-6">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

                                                <p>You have not set up this type of address yet.<br>
                                                <a href="#">Edit <i class="icon-edit"></i></a></p>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            </div><!-- .End .tab-pane -->

                            <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                <form action="{{ route('customer-account.update', [$customer_id]) }}" method="post" enctype="multipart/form-data">
                                    {{ method_field('patch') }}     
                                    {{ csrf_field() }}
                                    @csrf
                                    <label>{{trans('site.name')}}</label>
                                    <input type="text" class="form-control" name="name"required value="{{Auth::user()->name}}" pattern="[A-Z][a-zA-Z]+ ?\w+">

                                    <label>{{trans('site.email')}}</label>
                                    <input type="email" class="form-control" disabled name="email" required value="{{Auth::user()->email}}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">

                                    <label>{{trans('site.current_password')}}
                                        @if(App::getlocale()=='ar')
                                        (اتركه فارغا لتركه دون تغيير)
                                                @else
                                                (leave blank to leave unchanged) 
                                                @endif
                                    </label>
                                    <input type="password" class="form-control"required disabled name="password">

                                    <label>{{trans('site.new_password')}}
                                        @if(App::getlocale()=='ar')
                                        (اتركه فارغا لتركه دون تغيير)
                                                @else
                                                (leave blank to leave unchanged) 
                                                @endif
                                    </label>
                                    <input type="password" name="newPassword" class="form-control"pattern=".{6,}">
                        
                                    <label>{{trans('site.confirm_password')}}</label>
                                    <input type="password" name="confirmPassword" class="form-control mb-2" pattern=".{6,}">

                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>{{trans('site.save_changes')}}</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            </div><!-- .End .tab-pane -->
                        </div>
                    </div><!-- End .col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection