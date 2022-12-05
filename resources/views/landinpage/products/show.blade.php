
@extends('layouts.base',['title'=>'Product'])
@section('main')



<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('site.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{url('web-site-products')}}">{{trans('site.products')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('site.product_details')}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="product-details-top mb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    <img id="product-zoom" src="{{asset('uploads/'.$product->img1)?? 'None'}}"  alt="product image">

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    <a class="product-gallery-item active" href="#" data-image="{{asset('uploads/'.$product->img1)?? 'None'}}" data-zoom-image="{{asset('uploads/'.$product->img1)?? 'None'}}">
                                        <img src="{{asset('uploads/'.$product->img1)?? 'None'}}" alt="product side">
                                    </a>

                                    <a class="product-gallery-item" href="#" data-image="{{asset('uploads/'.$product->img2)?? 'None'}}" data-zoom-image="{{asset('uploads/'.$product->img2)?? 'None'}}">
                                        <img src="{{asset('uploads/'.$product->img2)?? 'None'}}" alt="product cross">
                                    </a>

                                    <a class="product-gallery-item" href="#" data-image="{{asset('uploads/'.$product->img3)?? 'None'}}" data-zoom-image="{{asset('uploads/'.$product->img3)?? 'None'}}">
                                        <img src="{{asset('uploads/'.$product->img3)?? 'None'}}" alt="product with model">
                                    </a>

                                </div><!-- End .product-image-gallery -->
                            </div><!-- End .row -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="product-details product-details-centered">
                            <h1 class="product-title">
                                @if(App::getlocale()=='ar')
                                {{$product->name_ar ??'none' }}
                                @else
                                {{$product->name??'none' }}
                                @endif
                               </h1><!-- End .product-title -->

                            <div class="product-price">
                                {{$product->price??'none' }} 
                                @if(App::getlocale()=='ar')
                                ج.س
                                @else
                                SDG 
                                @endif
                            </div><!-- End .product-price -->

                            <div class="product-content">
                                <p>
                                    @if(App::getlocale()=='ar')
                                    {{$product->description_ar ??'none' }} 
                                    @else
                                    {{$product->description??'none' }} 
                                     @endif</p>
                            </div><!-- End .product-content -->

                            <div class="product-details-action">
                                <div class="details-action-col">
                                <form action="{{route('cart.store')}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="hidden" value="{{$product->id}}" name="product_id">
                                    <input type="hidden" value="1" name="quantity">
                                    <input type="hidden" value="{{$product->price}}" name="price">
                                    <button class="btn-product btn-cart"><span>{{trans('site.add_to_cart')}}</span></button>
                                  </form>
                                </div>
                            </div><!-- End .product-details-action -->

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>{{trans('site.category')}} : </span>
                                    <a href="{{route ('web-site-categories.show',[$product->catogery->id])}}">
                                        @if(App::getlocale()=='ar')
                                        {{$product->catogery->name_ar}} | {{$product->subCategory->name_ar}}
                                        @else
                                        {{$product->catogery->name}} | {{$product->subCategory->name_ar}}
                                        @endif
                                       </a>
                                </div><!-- End .product-cat -->
                            </div>
                            <div class="product-details-footer">

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">{{trans('site.share')}} :</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=YourPageLink.com&display=popup" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                    <a href="https://api.whatsapp.com/send?text={{urlencode(url()->current())}}/{{$product->slug}}" class="social-icon" title="watsapp" target="_blank"><i class="icon-whatsapp"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                </div>
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->

            <h2 class="title text-center mb-4">{{trans('site.also_like')}} </h2><!-- End .title text-center -->
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": false, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":4,
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>
                @foreach ($list_products as $last_product)
                <div class="product product-7 text-center">
                    <figure class="product-media">
                        <a href="{{route ('web-site-products.show',[$last_product->id ??'None'])}}">
                            <img src="{{asset('uploads/'.$last_product->img1)?? 'None'}}" alt="Product image" class="product-image">
                        </a>

                        <div class="product-action">
                            <form class="btn-product btn-cart btn-lg btn-block" action="{{route('cart.store')}}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <input type="hidden" value="{{$product->id}}" name="product_id">
                                <input type="hidden" value="1" name="quantity">
                                <input type="hidden" value="{{$product->price}}" name="price">
                                <a type="submit"><span>{{trans('site.add_to_cart')}} </span></a>
                              </form>
                        </div><!-- End .product-action -->
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="{{route ('web-site-categories.show',[$last_product->catogery->id ??'None'])}}">
                                @if(App::getlocale()=='ar')
                                {{$last_product->catogery->name_ar ?? 'None'}}
                                     @else
                                     {{$last_product->catogery->name ?? 'None'}}
                                    @endif
                                </a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{route ('web-site-products.show',[$last_product->id ??'None'])}}">
                            @if(App::getlocale()=='ar')
                            {{$last_product->name_ar}}
                                 @else
                                 {{$last_product->name}}
                                @endif
                            </a></h3><!-- End .product-title -->
                        <div class="product-price">
                            {{$last_product->price}} 
                            @if(App::getlocale()=='ar')
                            ج.س
                            @else
                            SDG 
                            @endif
                        </div><!-- End .product-price -->
                    </div><!-- End .product-body -->
                </div><!-- End .product -->    
                @endforeach
            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection
