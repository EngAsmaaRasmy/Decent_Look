@extends('layouts.base' ,['title'=>'Categories in Decent look'])
@section('main')



<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('')}}assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{trans('site.all_categories')}}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('site.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('web-site-categories.index')}}">{{trans('site.categories')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('site.all')}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="products mb-3">
                        <div class="row justify-content-start">
                            @foreach ($category_products as $product)
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
                        </div><!-- End .row -->
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                </a>
                            </li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item-total">of 6</li>
                            <li class="page-item">
                                <a class="page-link page-link-next" href="#" aria-label="Next">
                                    Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">
                        <div class="widget widget-clean">
                            <label>{{trans('site.all_categories')}}</label>
                        </div><!-- End .widget widget-clean -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    {{trans('site.category')}}
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count">
                                        @foreach($categories as $category)
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cat-1">
                                                <label class="custom-control-label" for="cat-1">
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
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                        
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div>
        </div>
    </div>


</main><!-- End .main -->




@endsection
