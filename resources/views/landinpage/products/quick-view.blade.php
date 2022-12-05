<div class="container quickView-container">
	<div class="quickView-content">
		<div class="row">
			<div class="col-lg-7 col-md-6">
				<div class="row">
					<div class="product-left">
						<a href="#one" class="carousel-dot active">
							<img src="{{$product->getImageFullPathAttribute()}}" alt="product side">
						</a>
						<a href="#two" class="carousel-dot">
							<img src="{{$product->getImageFullPathAttribute()}}" alt="product side">
						</a>
						<a href="#three" class="carousel-dot">
							<img src="{{$product->getImageFullPathAttribute()}}" alt="product side">
						</a>
						<a href="#four" class="carousel-dot">
							<img src="{{$product->getImageFullPathAttribute()}}" alt="product side">
						</a>
					</div>
					<div class="product-right">
						<div class="owl-carousel owl-theme owl-nav-inside owl-light mb-0" data-toggle="owl" data-owl-options='{
	                        "dots": false,
	                        "nav": false, 
	                        "URLhashListener": true,
	                        "responsive": {
	                            "900": {
	                                "nav": true,
	                                "dots": true
	                            }
	                        }
	                    }'>
							<div class="intro-slide" data-hash="one">
	                            <img src="{{asset('uploads/'.$product->img1)?? 'None'}}" alt="Image Desc">
	                            <a href="{{$product->image_full_path ??'none' }}" class="btn-fullscreen">
                                    <i class="icon-arrows"></i>
                                </a>
		                    </div><!-- End .intro-slide -->

		                    <div class="intro-slide" data-hash="two">
	                            <img src="{{asset('uploads/'.$product->img2)?? 'None'}}" alt="Image Desc">
	                            <a href="{{$product->image_full_path ??'none' }}" class="btn-fullscreen">
                                    <i class="icon-arrows"></i>
                                </a>
		                    </div><!-- End .intro-slide -->

		                    <div class="intro-slide" data-hash="three">
	                            <img src="{{asset('uploads/'.$product->img3)?? 'None'}}" alt="Image Desc">
	                            <a href="{{$product->image_full_path ??'none' }}" class="btn-fullscreen">
                                    <i class="icon-arrows"></i>
                                </a>
		                    </div><!-- End .intro-slide -->
		                </div>
					</div>
                </div>
			</div>
			<div class="col-lg-5 col-md-6">
				<h2 class="product-title">@if(App::getlocale()=='ar')
					{{$product->name_ar ??'none' }}
					@else
					{{$product->name??'none' }}
					@endif</h2>
				<h3 class="product-price">{{$product->price??'none' }} SDG</h3>


                <p class="product-txt">@if(App::getlocale()=='ar')
					{{$product->description_ar ??'none' }} 
					@else
					{{$product->description??'none' }} 
					 @endif</p>

	            
                <div class="details-filter-row details-row-size">
                    <label for="qty">Qty:</label>
                    <div class="product-details-quantity">
                        <input type="number" id="qty" class="form-control" value="1" min="1" max="10" step="1" data-decimals="0" required>
                    </div><!-- End .product-details-quantity -->
                </div><!-- End .details-filter-row -->

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
						<span>{{trans('site.category')}}:</span>
						<a href="#">
							@if(App::getlocale()=='ar')
							{{$product->catogery->name_ar}}
							@else
							{{$product->catogery->name}}
							@endif
						   </a>,
					</div><!-- End .product-cat -->

                    <div class="social-icons social-icons-sm">
                        <span class="social-label">Share:</span>
                        <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>