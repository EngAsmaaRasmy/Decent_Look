@extends('layouts.base',['title'=>'Checkout'])
@section('main')
 <main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('')}}assets/images/page-header-bg.jpg'))">
        <div class="container">
            <h1 class="page-title">{{trans('site.checkout')}}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('site.home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('site.checkout')}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    

     <div class="page-content">
        <div class="checkout">
            <div class="container">
                    <div class="row">
                        <aside class="col-lg-9 ">
                            <div class="summary">
                                <h3 class="summary-title text-center">{{trans('site.your_order')}}</h3><!-- End .summary-title -->

                                <table class="table table-summary">
                                    <thead>
                                        <tr>
                                            <th >{{trans('site.customer_name')}}</th>
                                            <th>{{Auth::user()->name}}</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>{{trans('site.email')}}</th>
                                            <th>{{Auth::user()->email}}</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>{{trans('site.address')}}</th>
                                            <th>{{Auth::user()->address}}</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>{{trans('site.phone')}}</th>
                                            <th>{{Auth::user()->phone}}</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>{{trans('site.product')}}:</th>
                                            <th class="text-center">{{trans('site.quantity')}}:</th>
                                            <th>{{trans('site.price')}}:</th>
                                            <th class="text-center">{{trans('site.total')}}:</th>
                                        </tr>
                                    </thead>                
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td> @if(App::getlocale()=='ar')
                                                {{$product->product->name_ar}}
                                                @else
                                                {{$product->product->name}}
                                                @endif
                                            </td>
                                            <td class="text-center">{{$product->quantity}}</td> 

                                            <td>{{$product->price}} 
                                                @if(App::getlocale()=='ar')
                                                ج.س
                                                @else
                                                SDG 
                                                @endif
                                            </td>
                                            <td class="text-center">{{$product->total}} 
                                                @if(App::getlocale()=='ar')
                                                ج.س
                                                @else
                                                SDG 
                                                @endif
                                            </td>
                                        </tr>   
                                        @endforeach
                                        <tr class="summary-total">
                                            <td>{{trans('site.total')}}:</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{number_format($sumTotal)}} 
                                                @if(App::getlocale()=='ar')
                                                ج.س
                                                @else
                                                SDG 
                                                @endif
                                            </td>
                                            {{-- <td>td> --}}
                                        </tr><!-- End .summary-total -->
                                        <hr>
                                    </tbody>
                                </table><!-- End .table table-summary -->
                                <form   action="{{route ('create.orders')}}" method="POST" enctype="multipart/form-data">
                                <table class="table table-summary mt-2">
                                      <tr>
                                            <td @if(App::getlocale()=='ar')>
                                                طرق الدفع
                                                @else
                                                Payment Methods:
                                                @endif
                                                <div class="accordion-summary mb-2" id="accordion-payment">
                                                    <div class="card">
                                                        <div class="card-header" id="heading-1">
                                                            <h2 class="card-title">
                                                                <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                                                    <input type="hidden" value="1" name="paid_way">
                                                                    @if(App::getlocale()=='ar')
                                                                    <span class="text-align"> تحويل مصرفي مباشر</span> 
                                                                    @else
                                                                    <span class="text-align"> Direct bank transfer</span>
                                                                    @endif
                                                                </a>
                                                            </h2>
                                                        </div><!-- End .card-header -->
                                                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-payment">
                                                            <div class="card-body">
                                                                @if(App::getlocale()=='ar')
                                                                قم بالدفع مباشرة إلى حسابنا المصرفي. 1111111
                                                                @else
                                                                Make your payment directly into our bank account. 1111111.
                                                                @endif
                                                            </div><!-- End .card-body -->
                                                        </div><!-- End .collapse -->
                                                    </div><!-- End .card -->
        
                                                    <div class="card">
                                                        <div class="card-header" id="heading-2">
                                                            <h2 class="card-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                                                    <input type="hidden" value="0" name="paid_way">
                                                                    @if(App::getlocale()=='ar')
                                                                    <span class="text-align"> التسديد نقداً</span>
                                                                     
                                                                    @else
                                                                    <span class="text-align"> Cash payments</span>
                                                                    @endif
                                                                </a>
                                                            </h2>
                                                        </div><!-- End .card-header -->
                                                        <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-payment">
                                                            <div class="card-body">
                                                                @if(App::getlocale()=='ar')
                                                                الدفع نقدا عند الاستلام
                                                                @else
                                                                Payment Cash on delivery.
                                                                @endif 
                                                            </div><!-- End .card-body -->
                                                        </div><!-- End .collapse -->
                                                    </div><!-- End .card -->
                                            </td>
                                            <td></td>
                                        </tr><!-- End .summary-subtotal -->
                                    </tbody>
                                </table><!-- End .table table-summary -->
                                <table>
                                </table>
                                <br>
                               
                                    @csrf
                                    <input type="hidden" value="{{Auth::user()->id}}" name="customer_id">
                                    <input type="hidden" value="" name="total">
                                    <input type="hidden" value="" name="status_id">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-order btn-lg btn-place">
                                            <span class="btn-text">{{trans('site.place_order')}} </span>
                                            <span class="btn-hover-text">{{trans('site.proceed')}} </span>
                                        </button>
                                    </div>
                                  </form>
                            </div><!-- End .summary -->
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection