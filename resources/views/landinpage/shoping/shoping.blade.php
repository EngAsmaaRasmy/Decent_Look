@extends('layouts.base')
@section('main')

<body>
    <div class="page-wrapper">


        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title"><span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>

                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-9">
                			<div class="toolbox">
                				<div class="toolbox-left">
                					<div class="toolbox-info">
                						Showing <span>{{$category_products->count()}}</span> Products
                					</div><!-- End .toolbox-info -->
                				</div><!-- End .toolbox-left -->

                				<div class="toolbox-right">

                					<div class="toolbox-layout">
                						<a href="category-list.html" class="btn-layout">
                							<svg width="16" height="10">
                								<rect x="0" y="0" width="4" height="4" />
                								<rect x="6" y="0" width="10" height="4" />
                								<rect x="0" y="6" width="4" height="4" />
                								<rect x="6" y="6" width="10" height="4" />
                							</svg>
                						</a>

                						<a href="category-2cols.html" class="btn-layout">
                							<svg width="10" height="10">
                								<rect x="0" y="0" width="4" height="4" />
                								<rect x="6" y="0" width="4" height="4" />
                								<rect x="0" y="6" width="4" height="4" />
                								<rect x="6" y="6" width="4" height="4" />
                							</svg>
                						</a>

                						<a href="category.html" class="btn-layout active">
                							<svg width="16" height="10">
                								<rect x="0" y="0" width="4" height="4" />
                								<rect x="6" y="0" width="4" height="4" />
                								<rect x="12" y="0" width="4" height="4" />
                								<rect x="0" y="6" width="4" height="4" />
                								<rect x="6" y="6" width="4" height="4" />
                								<rect x="12" y="6" width="4" height="4" />
                							</svg>
                						</a>

                						<a href="category-4cols.html" class="btn-layout">
                							<svg width="22" height="10">
                								<rect x="0" y="0" width="4" height="4" />
                								<rect x="6" y="0" width="4" height="4" />
                								<rect x="12" y="0" width="4" height="4" />
                								<rect x="18" y="0" width="4" height="4" />
                								<rect x="0" y="6" width="4" height="4" />
                								<rect x="6" y="6" width="4" height="4" />
                								<rect x="12" y="6" width="4" height="4" />
                								<rect x="18" y="6" width="4" height="4" />
                							</svg>
                						</a>
                					</div><!-- End .toolbox-layout -->
                				</div><!-- End .toolbox-right -->
                			</div><!-- End .toolbox -->

                            <div class="products mb-3">
                                <div class="row justify-content-start">
                                    @foreach ($category_products as $product)
                                    <div class="col-6 col-md-4 col-lg-4">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <span class="product-label label-new">New</span>
                                                <a href="../landinpage/products/{{$product->id}}">
                                                    <img src="{{$product->getImageFullPathAttribute()}}" alt="Product image" class="product-image">
                                                </a>

                                                <div class="product-action">
                                                    <form action="{{route('cart.store')}}" method="POST" enctype="multipart/form-data" >
                                                        @csrf
                                                        <input type="hidden" value="{{$product->id}}" name="product_id">
                                                        <input type="hidden" value="1" name="quantity">
                                                        <input type="hidden" value="{{$product->price}}" name="price">
                                                        <button class="btn-product btn-cart btn-lg btn-block"><span>add to cart</span></button>
                                                      </form>
                                                </div><!-- End .product-action -->
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="../landinpage/categories/{{$product->catogery->id ?? 'None'}}">{{$product->catogery->name ??'None'}}</a>
                                                </div><!-- End .product-cat -->
                                                <h3 class="product-title"><a href="../landinpage/products/{{$product->id}}">{{$product->name}}</a></h3><!-- End .product-title -->
                                                <div class="product-price">
                                                    {{$product->price}}
													@if(App::getlocale()=='ar')
													ج.س
													@else
													SDG 
													@endif
                                                </div><!-- End .product-price -->
                                                <div class="product-nav product-nav-thumbs">
                                                    <a href="#" class="active">
                                                        <img src="{{$product->getImageFullPathAttribute()}}" alt="product desc">
                                                    </a>
                                                    <a href="#">
                                                        <img src="{{$product->getImageFullPathAttribute()}}" alt="product desc">
                                                    </a>

                                                    <a href="#">
                                                        <img src="{{$product->getImageFullPathAttribute()}}" alt="product desc">
                                                    </a>
                                                </div><!-- End .product-nav -->
                                            </div><!-- End .product-body -->
                                        </div><!-- End .product -->
                                    </div><!-- End .col-sm-6 col-lg-4 -->
                                    @endforeach


                                </div><!-- End .row -->
                            </div><!-- End .products -->


                		</div><!-- End .col-lg-9 -->
                		<aside class="col-lg-3 order-lg-first">
                			<div class="sidebar sidebar-shop">
                				<div class="widget widget-clean">
                					<label>Filters:</label>
                					<a href="#" class="sidebar-filter-clear"> Count Product</a>
                				</div><!-- End .widget widget-clean -->

                				<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
									        Category
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-1">
										<div class="widget-body">
											<div class="filter-items filter-items-count">
                                                @foreach ($categories as $categorie)
                                                <div class="filter-item">
													<div class="custom-control custom-checkbox">
                                                        <a href="../landinpage/categories/{{$categorie->id}}" class="sidebar-filter-clear">{{$categorie->name}}</a>
													</div><!-- End .custom-checkbox -->
													<span class="item-count">{{$categorie->products_count}}</span>
												</div><!-- End .filter-item -->
                                                @endforeach

											</div><!-- End .filter-item -->

										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
        						</div><!-- End .widget -->
                			</div><!-- End .sidebar sidebar-shop -->
                		</aside><!-- End .col-lg-3 -->
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->


    </div><!-- End .page-wrapper -->
       <!-- Plugins JS File -->
    @endsection

</body>


<!-- molla/category.html  22 Nov 2019 10:02:52 GMT -->
</html>
