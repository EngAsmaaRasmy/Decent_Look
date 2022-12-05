@extends('layouts.base',['title'=>'Search for product'])
@section('main')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('')}}assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{trans('site.allProducts')}}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('site.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{url('web-site-products')}}">{{trans('site.products')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('site.search_for')}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="products mb-3">
                        <div class="row justify-content-start">
                            @if($searchProducts->isNotEmpty())
                            @foreach ($searchProducts as $product)
                            <div class="col-6 col-md-4 col-lg-4">
                                <div class="product product-7 text-center">
                                    <figure class="product-media">
                                        <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
                                            <img src="{{asset('uploads/'.$product->img1)}}" alt="Product image" class="product-image">
                                        </a>

                                        <div class="product-action-vertical">
                                            <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                        </div><!-- End .product-action-vertical -->

                                        <div class="product-action">
                                            <form class="btn-product btn-cart" id="myform" action="{{route('cart.store')}}" method="POST" enctype="multipart/form-data" >
                                                @csrf
                                                <input type="hidden" value="{{$product->id}}" name="product_id">
                                                <input type="hidden" value="1" name="quantity">
                                                <input type="hidden" value="{{$product->price}}" name="price">
                                                <a type="submit" onclick="document.getElementById('myform').submit()"><span>{{trans('site.add_to_cart')}}</span></a>
                                              </form>
                                        </div><!-- End .product-action -->
                                    </figure><!-- End .product-media -->

                                    <div class="product-body">
                                        <div class="product-cat">
                                            <a href="{{route ('web-site-categories.show',[$product->catogery->id ??'None'])}}">
                                                @if(App::getlocale()=='ar')
                                                {{$product->catogery->name_ar}}
                                                @else
                                                {{$product->catogery->name}}
                                                @endif
                                                </a>
                                        </div><!-- End .product-cat -->
                                        <h3 class="product-title"><a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
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
                                </div>
                            </div><!-- End .col-md-6 -->
                           @endforeach
                           @else
                           <div class="col-8 col-md-8 col-lg-8 m-auto">
                            <div class="product product-7 text-center">
                                <div class="product-body">
                                    <div class="product-cat p-5">
                                        <h2>{{trans('site.no_products')}}</h2>
                                    </div><!-- End .product-cat -->
                                    
                                </div><!-- End .product-body -->
                            </div>
                        </div><!-- End .col-md-6 -->
                        @endif
                        </div><!-- End .row -->
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>@if(App::getlocale()=='ar')
                                    قبل
                                   @else
                                   PREV 
                                   @endif 
                                </a>
                            </li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item-total">@if(App::getlocale()=='ar')
                                من
                               @else
                               OF 
                               @endif  6</li>
                            <li class="page-item">
                                <a class="page-link page-link-next" href="#" aria-label="Next">
                                    @if(App::getlocale()=='ar')
                                     بعد
                                    @else
                                    NEXT 
                                    @endif <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
                            <label>{{trans('site.all_categories')}}</label>
                            <a href="#" class="sidebar-filter-clear">{{trans('site.clear_all')}} </a>
                        </div><!-- End .widget widget-clean -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    {{trans('site.category')}}
                                </a>
                             </h3><!-- End .widget-title -->
                          <form action="{{ route('product.filter') }}" method="GET" autocomplete="off">
                            {{csrf_field() }}
                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count">
                                        @foreach($categories as $category)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" value="{{ $category->id }}" name="category_id[]" class="custom-control-input" id="{{ $category->id }}">
                                                <label class="custom-control-label" for="{{ $category->id }}">
                                                    @if(App::getlocale()=='ar')
                                                    {{$category->name_ar}}
                                                    @else
                                                    {{$category->name}}
                                                    @endif
                                                   </label>
                                            </div><!-- End .custom-checkbox -->
                                            <span class="item-count">{{$category->products_count}}</span>
                                        </div><!-- End .filter-item -->   
                                        @endforeach
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                                <button type="submit" class="btn btn-primary btn-marg btn-round ">
                                    <span>{{trans('site.filters')}}</span>
                                </button>
                            </div><!-- End .collapse -->
                              
                          </form>
                        </div><!-- End .widget -->
                        
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div>
        </div>
    </div>
</main><!-- End .main -->
@endsection
