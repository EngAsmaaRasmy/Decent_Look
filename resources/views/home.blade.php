@extends('layouts.base',['title'=>'DECENT LOOK WEBSITE'])
@section('main')
<style>
    .block {
  display: block;
  width: 100%;
  border: none;
  background-color: transparent;
  font-size: 16px;
  cursor: pointer;
  text-align: center;
}
.block:hover
{
    color: #fff;
}
</style>
<main class="main">
  <div class="intro-slider-container">
      <div class="intro-slider owl-carousel owl-simple owl-nav-inside owl-light" data-toggle="owl" data-owl-options='{"nav":false, "dots": false, "loop": false}'>
          <div class="intro-slide" style="background-image: url('{{asset('')}}assets/images/demos/demo-16/slider/slide-1.jpg')">
              <div class="container intro-content text-center">
                  <h3 class="intro-subtitle">{{trans('site.what_know')}}</h3><!-- End .h3 intro-subtitle -->
                  <h1 class="intro-title text-white">{{trans('site.for_spring')}}</h1><!-- End .intro-title -->

                  <a href="#scroll-to-content" class="btn btn-outline-white scroll-to">
                      <span>{{trans('site.start_scrolling')}}</span>
                      <i class="icon-long-arrow-down"></i>
                  </a>
              </div><!-- End .intro-content -->
          </div><!-- End .intro-slide -->
      </div><!-- End .intro-slider owl-carousel owl-simple -->
      <span class="slider-loader text-white"></span><!-- End .slider-loader -->
  </div><!-- End .intro-slider-container -->

  <div class="container" id="scroll-to-content">
      <div class="pt-7"></div><!-- End .pt-6 -->
      <hr class="mt-2 mb-6">
      @foreach ($show_categories as $categorie)
      <div class="products-display">
          <div class="heading text-center mt-5">
              <h1 class="title" style="color:  #e61f7b;">
                @if(App::getlocale()=='ar')
                {{$categorie->name_ar}}
                @else
                {{$categorie->name}}
                @endif
                  
                </h1><!-- End .subtitle -->
          </div><!-- End .heading -->
          <div class="row">
              <div class="col-lg-6">
                <div class="banner banner-main banner-overlay">
                    <a href="{{route ('web-site-categories.show',[$categorie->id ??'None'])}}">
                        <img src="{{$categorie->image_full_path ?? 'None'}}" alt="Banner">
                    </a>
                    <div class="banner-content left">
                        <div class="banner-title"><a href="{{route ('web-site-categories.show',[$categorie->id ??'None'])}}"></a></div><!-- End .banner-title -->

                        <p>
                            @if(App::getlocale()=='ar')
                            {{$categorie->description_ar ?? 'None'}}
                            @else
                            {{$categorie->description ?? 'None'}}
                            @endif 
                            </p>
                        <a href="{{route ('web-site-categories.show',[$categorie->id ??'None'])}}" class="banner-link">{{trans('site.discover_now')}}<i class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-main -->
                </div><!-- End .banner banner-overlay -->
            </div><!-- End .col-lg-6 -->
            @php
                $categories_product= App\Models\Product::where('category_id',$categorie->id)
                ->orderBy('id', 'DESC')->paginate('2');
            @endphp
            @foreach(array_chunk($categories_product->all(), 3) as $product)
            <?php $i = 0; ?>
            <div class="col-sm-8 col-lg-3 order-lg-first">
                <div class="display-products-col">
                    <div class="row">
                        <?php $i = 0; ?>
                        @foreach($product as $product)
                        @if($i===0 || $i===1)
                        <div class="col-6 col-lg-12">
                            <div class="product product-4 mb-7">
                                <figure class="product-media">
                                    <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
                                        <img src="{{$product->image_full_path ?? 'None'}}" alt="Product image" class="product-image">
                                        <img src="{{$product->img2_full_path ?? 'None'}}" alt="Product image" class="product-image-hover">
                                    </a>
                                    <div class="product-action-vertical">
                                      <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                    </div><!-- End .product-action -->
                                    <div class="product-action">
                                      <form class="btn-product btn-cart"  action="{{route('cart.store')}}" method="POST" enctype="multipart/form-data" >
                                          @csrf
                                          <input type="hidden" value="{{$product->id}}" name="product_id">
                                          <input type="hidden" value="1" name="quantity">
                                          <input type="hidden" value="{{$product->price}}" name="price">
                                          <button class=" block"><span>{{trans('site.add_to_cart')}}</span></button>
                                        </form>
                                    </div><!-- End .product-action -->
                                </figure><!-- End .product-media -->
      
                                <div class="product-body">
                                    <h3 class="product-title">
                                        <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
                                      @if(App::getlocale()=='ar')
                                      {{$product->name_ar}}
                                      @else
                                      {{$product->name}}
                                      @endif
                                      
                                  </a></h3><!-- End .product-title -->
                                    <div class="product-price">
                                        {{$product->price}}
                                        @if(App::getlocale()=='ar')
                                        ج.س
                                        @else
                                        SDG 
                                        @endif
                                    </div><!-- End .product-price -->
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        </div><!-- End .col-sm-6 col-lg-12 -->
                        @endif
                        <?php $i++;?>
                        @endforeach
                    </div><!-- End .row -->
                </div><!-- End .display-products-col -->
            </div><!-- End .col-sm-6 col-lg-3 -->
             <div class="col-sm-3 col-lg-3">
                  <div class="display-products-col">
                      <div class="product product-4">
                          <figure class="product-media">
                              <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
                                  <img src="{{asset('uploads/'.$product->img1 )?? 'None'}}" alt="Product image" class="product-image">
                                  <img src="{{asset('uploads/'.$product->img2 )?? 'None'}}" alt="Product image" class="product-image-hover">
                              </a>
                              <div class="product-action-vertical">
                                <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                              </div><!-- End .product-action -->
                              <div class="product-action">
                                <form class="btn-product btn-cart"  action="{{route('cart.store')}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="hidden" value="{{$product->id}}" name="product_id">
                                    <input type="hidden" value="1" name="quantity">
                                    <input type="hidden" value="{{$product->price}}" name="price">
                                    <button class=" block"><span>{{trans('site.add_to_cart')}}</span></button>
                                  </form>
                              </div><!-- End .product-action -->
                          </figure><!-- End .product-media -->

                          <div class="product-body">
                              <h3 class="product-title">
                                  <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
                                @if(App::getlocale()=='ar')
                                {{$product->name_ar}}
                                @else
                                {{$product->name}}
                                @endif
                                
                            </a></h3><!-- End .product-title -->
                              <div class="product-price">
                                  {{$product->price}}
                                  @if(App::getlocale()=='ar')
                                  ج.س
                                  @else
                                  SDG 
                                  @endif
                              </div><!-- End .product-price -->
                          </div><!-- End .product-body -->
                      </div><!-- End .product -->
                  </div><!-- End .display-products-col -->
            </div><!-- End .col-sm-6 col-lg-3 --> 
             @endforeach
          </div><!-- End .row -->
          @endforeach

          <!--
          {{2}}
        -->
      </div><!-- End .products-display -->
  </div><!-- End .container -->

  <div class="bg-lighter pt-6 pb-9">
      <div class="container">
          <div class="heading text-center">
              <h2 class="title">{{trans('site.shop_the_collection')}}</h2><!-- End .title -->
              <p class="title-desc">{{trans('site.shop_p')}}</p><!-- End .title-desc -->
          </div><!-- End .heading -->


          <div class="owl-carousel owl-simple col-md-12" data-toggle="owl" 
          data-owl-options='{
              "nav": false, 
              "dots": true,
              "margin": 20,
              "loop": false,
              "responsive": {
                  "0": {
                      "items":2
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
              @foreach ($allProducts as $product)

              <div class="product product-4">
                <figure class="product-media">
                    <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
                        <img src="{{$product->image_full_path ?? 'None'}}" alt="Product image" class="product-image">
                        <img src="{{$product->img2_full_path ?? 'None'}}" alt="Product image" class="product-image-hover">
                    </a>

                    <div class="product-action">

                        <form class="btn-product btn-cart"  action="{{route('cart.store')}}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="hidden" value="{{$product->id}}" name="product_id">
                            <input type="hidden" value="1" name="quantity">
                            <input type="hidden" value="{{$product->price}}" name="price">
                            <button class=" block"><span>{{trans('site.add_to_cart')}}</span></button>
                          </form>
                    </div><!-- End .product-action -->
                </figure><!-- End .product-media -->
                <div class="product-body">
                    <div class="product-cat">
                        <a href="{{route ('web-site-categories.show',[$product->catogery->id ??'None'])}}">
                            @if(App::getlocale()=='ar')
                            {{$product->catogery->name_ar ?? 'None'}}
                            @else
                            {{$product->catogery->name ?? 'None'}}
                              @endif
                            </a>
                    </div><!-- End .product-cat -->
                    <h3 class="product-title"><a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
                        @if(App::getlocale()=='ar')
                        {{$product->name_ar }}
                        @else
                        {{$product->name}}
                          @endif
                        </a></h3><!-- End .product-title -->
                    <div class="product-price">
                        {{$product->price}} 
                        @if(App::getlocale()=='ar')
                                  ج.س
                                  @else
                                  SDG 
                                  @endif
                    </div><!-- End .product-price -->
                </div><!-- End .product-body -->
            </div><!-- End .product -->

              @endforeach


          </div><!-- End .owl-carousel owl-simple --></div><!-- End .container -->
  </div><!-- End .bg-lighter pt-5 pb-5 -->

  <div class="mb-6"></div><!-- End .mb-6 -->

</main><!-- End .main -->

@endsection
