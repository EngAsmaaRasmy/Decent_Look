@extends('layouts.base',['title'=>'Cart'])
@section('main')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('')}}assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{trans('site.cart')}}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('site.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{url('cart_products')}}">{{trans('site.cart')}}</a></li>

            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->


            <div class="page-content">
            	<div class="cart">
	                <div class="container">
	                	<div class="row">
	                		<div class="col-lg-9">
								
	                			<table class="table table-cart table-mobile">
									<thead class="text-center">
										<tr>

											<th width="350px">{{trans('site.product')}}</th>
											<th>{{trans('site.price')}}</th>
											<th>{{trans('site.quantity')}}</th>
											<th></th>
											<th>{{trans('site.total')}}</th>
											<th></th>
										</tr>
									</thead>

									<tbody>
                                        @foreach($products as $product)
										<tr>

											<td class="product-col">
												<div class="product">
													<figure class="product-media">
														<a href="{{route ('web-site-products.show',[$product->id])}}">
															<img src="{{asset('uploads/'.$product->product->img1)?? 'None'}}" alt="Product image">
														</a>
													</figure>

													<h3 class="product-title">
														<a href="{{route ('web-site-products.show',[$product->id])}}">
															@if(App::getlocale()=='ar')
                                                            {{$product->product->name_ar}}
                                                            @else
                                                            {{$product->product->name}}
                                                            @endif
															</a>
													</h3><!-- End .product-title -->
												</div><!-- End .product -->
											</td>
											<td class="price-col">{{$product->product->price}}
												 @if(App::getlocale()=='ar')
												ج.س
												@else
												SDG 
												@endif</td>
											<form action="{{ route('cart.update',$product->id)}}" method="POST">
											@csrf
											<td  class="quantity-col text-center">
                                                <div class="cart-product-quantity">
														<div class="input-group">
															<input type="hidden" name="id" value="{{ $product->id}}" >
															<input type="hidden" name="price" value="{{ $product->price}}" >
															<input  type="number" name="quantity" class="form-control mx-2 px-3" value="{{$product->quantity}}" min="1" max="10" step="1" data-decimals="0" required>
														    <input type="hidden" name="total" value="{{ $product->total}}" >
															<div class="input-group-append ">
															</div>
														</div>
													  
                                                </div><!-- End .cart-product-quantity -->                                 
                                            </td>
											<td class="text-center">
												<button class="btn-remove mx-3"><i class="icon-refresh"></i></button>
											</td>
										</form>
											<td class="total-col mx-3">{{ $product->total}}
												@if(App::getlocale()=='ar')
													ج.س
													@else
													SDG 
													@endif
											</td>
											<td class="remove-col ">
                                                    <form action="{{ route('cart.remove',$product->product_id) }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" value="{{ $product->id }}" name="id">
                                                      <button class="btn-remove"><i class="icon-close"></i></button>
                                                  </form>
                                            </td>

										</tr>
                                        @endforeach

									</tbody>
								</table><!-- End .table table-wishlist -->
	                		</div><!-- End .col-lg-9 -->
	                		<aside class="col-lg-3">
	                			<div class="summary summary-cart">
	                				<h3 class="summary-title">{{trans('site.cart_total')}}</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-total">
	                							<td>{{trans('site.total')}}:</td>
	                							<td>
													{{number_format($sumTotal)}}
													@if(App::getlocale()=='ar')
													ج.س
													@else
													SDG 
													@endif 
												</td>
	                						</tr><!-- End .summary-total -->
	                					</tbody>
	                				</table><!-- End .table table-summary -->

	                				<a href="{{route('order.checkout')}}" class="btn btn-outline-primary-2 btn-order btn-block">{{trans('site.proceed_to_checkout')}}</a>
	                			</div><!-- End .summary -->

		            			<a href="{{url('web-site-categories')}}" class="btn btn-outline-dark-2 btn-block mb-3"><span>{{trans('site.continue_shopping')}}</span><i class="icon-refresh"></i></a>
	                		</aside><!-- End .col-lg-3 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
@endsection
