<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                   <div class="header">
                    @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                    <a class="btn btn-outline my-2 rounded " href="{{ route('lang.switch', $lang) }}">
                        <img src="{{asset($language['img'])}}"><span class="text-dark mx-2 lang">{{$language['display']}}</span> </a>
                    @endif
                    @endforeach
                </div><!-- End .header-dropdown -->
                <div class="header-dropdown">
                   
                </div><!-- End .header-dropdown -->
            </div><!-- End .header-left -->
            <div class="header-right">
                        <div class="header">
                            @if (Auth::user())
                            <div class="header-dropdown">
                                <a style="font-size: 15px;"><i class="icon-user"></i>
                                    {{Auth::user()->name}}
                                </a>
                                <div class="header-menu p-3">
                                    <ul class="p-3">
                                        <li class="mb-1"><a href="{{url('dashboard')}}">{{trans('site.dashboard')}}</a></li> 
                                        <li><a href="{{url('logout')}}">{{trans('site.log_out')}}</a></li> 
                                    </ul>
                                </div><!-- End .header-menu --> 
                            </div>  
                        </div><!-- End .compare-dropdown -->  
                         @else
                        <a style="font-size: 15px;" href="{{route('show.login')}}"><i class="icon-user my-4"></i>{{trans('site.log_in')}}</a>
                         @endif
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->
    
  <div class="header-middle sticky-header">
      <div class="container">
          <div class="header-left">
            <button class="mobile-menu-toggler">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars"></i>
            </button>
            <a href="{{route('home')}}" class="logo">
                  <img src="{{asset('logo.png')}}" alt="Decent Look Logo" width="130" height="25">
            </a>
              <nav class="main-nav">
                <ul class="menu sf-arrows">
                    <li class="megamenu-container {{ Request::is('/') ? 'active' : '' }}">
                        <a href="{{url('/')}}" class="">{{trans('site.home')}}</a>
                    </li>
                    <li class="{{ Request::is('web-site-categories') ? 'active' : '' }}">
                        <a  href="#" class="sf-with-ul sub">{{trans('site.categories')}}</a>
                            <ul class="sub-menu ">
                                @foreach($categories as $category)
                                <li style="position: static;">
                                    <a href="{{route ('web-site-categories.show',[$category->id])}}" class="sf-with-ul sub">
                                        @if(App::getlocale()=='ar')
                                        {{$category->name_ar ??'None' }}
                                        @else
                                        {{$category->name ??'None' }}
                                        @endif
                                    </a>
                                        <ul class="sub-menu" style="top: 0rem">
                                            <?php 
                                                $subCategories = App\Models\SubCategory::where('category_id' , $category->id)->get();
                                            ?>
                                            @foreach ($subCategories as $subCategory)
                                            <li class="" style="position: static;">
                                                <a href="{{route ('web-site-sub-categories.show',[$subCategory->id])}}">
                                                    @if(App::getlocale()=='ar')
                                                    {{$subCategory->name_ar}}
                                                    @else
                                                    {{$subCategory->name}}
                                                    @endif                             
                                                 </a>
                                                 <?php 
                                                 $subSubCategories = App\Models\SubSubCategory::where('sub_category_id' , $subCategory->id)->get();
                                                 ?>
                                                 @if ($subSubCategories->isNotEmpty())
                                                    <ul class="sub-menu" style="top: 0rem">
                                                       
                                                        @foreach ($subSubCategories as $subSubCategory)
                                                        <li class="">
                                                            <a href="{{route ('web-site-sub-sub-categories.show',[$subSubCategory->id])}}">
                                                                @if(App::getlocale()=='ar')
                                                                {{$subSubCategory->name_ar}}
                                                                @else
                                                                {{$subSubCategory->name}}
                                                                @endif                             
                                                            </a>
                                                        </li>
                                                        @endforeach 
                                                        
                                                    </ul>
                                                @endif
                                            </li>
                                             @endforeach 
                                            
                                        </ul>
                                   
                                </li>
                               @endforeach    
                            </ul>   
                    </li>
                    <li class="megamenu-container {{ Request::is('web-site-products') ? 'active' : '' }}">
                        <a href="{{route('web-site-products.index')}}">{{trans('site.products')}}</a>
                    </li>
                    <li class="megamenu-container {{ Request::is('about-us') ? 'active' : '' }}">
                        <a href="{{route ('about')}}">{{trans('site.about_us')}}</a>
                    </li>
                    <li class="megamenu-container {{ Request::is('contact-us') ? 'active' : '' }}">
                        <a href="{{route ('contact')}}">{{trans('site.contact_us')}}</a>
                    </li> 
                </ul><!-- End .menu -->
            </nav><!-- End .main-nav -->
          </div><!-- End .header-left -->

          <div class="stiky-header-right" 
          @if(App::getlocale()=='en')
          style="align-self: stretch;display: flex;
            align-items: center; margin-left:auto;" @else 
            style="align-self: stretch;display: flex;
            align-items: center; margin-left:auto;" @endif>
            <div class="header-search">
                <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                <form action="{{route ('products.search')}}" method="get">
                    <div class="header-search-wrapper">
                        <label for="q" class="sr-only">{{trans('site.search')}}</label>
                        <input type="search" class="form-control" name="search" id="q" placeholder="{{trans('site.search_in')}}..." required>
                    </div><!-- End .header-search-wrapper -->
                </form>
            </div><!-- End .header-search -->
              <div class="dropdown cart-dropdown">
                  <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                      <i class="icon-shopping-cart"></i>
                      <span class="cart-count">{{$countCart}}</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                      <div class="dropdown-cart-products">
                    @auth
                        @foreach($products as $product)
                          <div class="product">

                              <div class="product-cart-details">
                                  <h4 class="product-title">
                                      <a href="{{route ('web-site-products.show',[$product->id ??'None'])}}">
                                        @if(App::getlocale()=='ar')
                                        {{$product->product->name_ar ??'None' }}
                                        @else
                                        {{$product->product->name ??'None' }}
                                        @endif
                                        </a>
                                  </h4>

                                  <span class="cart-product-info">
                                      <span class="cart-product-qty">{{$product->quantity ??'None'}}</span>
                                       <span class="cart-product-qty">× {{$product->price ??'None'}} </span>
                                       @if(App::getlocale()=='ar')
                                      ج.س
                                      @else
                                      SDG 
                                      @endif
                                  </span>
                              </div><!-- End .product-cart-details -->

                              <figure class="product-image-container">
                                  <a href="/landinpage/products/{{$product->product->id}}" class="product-image">
                                      <img src="{{asset('uploads/'.$product->product->img1 )?? 'None'}}" alt="product">
                                  </a>
                              </figure>
                              <form action="{{ route('cart.remove',$product->product_id) }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $product->id }}" name="id">
                                <button class="btn-remove" title="Remove Product"><i class="icon-close"></i></button>
                               </form>
                              {{-- <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a> --}}

                          </div><!-- End .product -->
                          @endforeach
                         @endauth


                      </div><!-- End .cart-product -->

                      <div class="dropdown-cart-total">
                          <span >{{trans('site.total')}}</span> 

                          <span class="cart-total-price">{{number_format($sumTotal)}}  @if(App::getlocale()=='ar')
                            ج.س
                            @else
                            SDG 
                            @endif</span>
                      </div><!-- End .dropdown-cart-total -->

                      <div class="dropdown-cart-action">
                          <a href="{{route('cart.products')}}" class="btn btn-primary">{{trans('site.view_cart')}}</a>
                          <a href="{{route('order.checkout')}}" class="btn btn-outline-primary-2"><span>{{trans('site.checkout')}}</span>
                            <i class="icon-long-arrow-right"></i></a>
                      </div><!-- End .dropdown-cart-total -->
                  </div><!-- End .dropdown-menu -->
              </div><!-- End .cart-dropdown -->
          </div>
      </div><!-- End .container -->
  </div><!-- End .header-middle -->
</header><!-- End .header -->
