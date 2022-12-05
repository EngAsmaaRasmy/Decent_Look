<footer class="footer">
  <div class="footer-middle">
      <div class="container">
          <div class="row">
              <div class="col-sm-6 col-lg-3">
                  <div class="widget widget-about">
                      <h4 class="widget-title">
                        @if(App::getlocale()=='ar')
                     عن ديسنت لوك
                        @else
                        About Decent look 
                        @endif
                          
                    </h4><!-- End .widget-title -->
                      <p>
                        @if(App::getlocale()=='ar')
                        متجر لبيع الملابس اون لاين للرجال والنساء والأطفال
                           @else
                           Online clothing store for men, women and children.
                           @endif
                           </p>

                      <div class="social-icons">
                          <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook"></i></a>
                          <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                          <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                          <a href="#" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                      </div><!-- End .soial-icons -->
                  </div><!-- End .widget about-widget -->
              </div><!-- End .col-sm-6 col-lg-3 -->

              <div class="col-sm-6 col-lg-3">
                  <div class="widget">
                      <h4 class="widget-title">{{trans('site.useful_links')}}</h4><!-- End .widget-title -->

                      <ul class="widget-list">
                          <li><a href="{{route ('about')}}">{{trans('site.about')}} Decent look</a></li>
                          <li><a href="{{route ('contact')}}">{{trans('site.contact_us')}}</a></li>
                          <li><a href="{{route('login')}}">{{trans('site.log_in')}}</a></li>
                      </ul><!-- End .widget-list -->
                  </div><!-- End .widget -->
              </div><!-- End .col-sm-6 col-lg-3 -->

              <div class="col-sm-6 col-lg-3">
                  <div class="widget">
                    <h4 class="widget-title">{{trans('site.categories')}}</h4><!-- End .widget-title -->

                    <ul class="widget-list">
                        @foreach($footerCategories as $category)
                        <li><a href="{{route ('web-site-categories.show',[$category->id])}}">
                            @if(App::getlocale()=='ar')
                            {{$category->name_ar ??'None' }}
                            @else
                            {{$category->name ??'None' }}
                             @endif
                          </a></li>
                        @endforeach
                    </ul><!-- End .widget-list -->
                  </div><!-- End .widget -->
              </div><!-- End .col-sm-6 col-lg-3 -->

              <div class="col-sm-6 col-lg-3">
                  <div class="widget">
                      <h4 class="widget-title">{{trans('site.my_account')}}</h4><!-- End .widget-title -->

                      <ul class="widget-list">
                          <li><a href="{{route('login')}}">{{trans('site.sign_up')}}</a></li>
                          <li><a href="{{route('cart.products')}}">{{trans('site.view_cart')}}</a></li>

                      </ul><!-- End .widget-list -->
                  </div><!-- End .widget -->
              </div><!-- End .col-sm-6 col-lg-3 -->
          </div><!-- End .row -->
      </div><!-- End .container -->
  </div><!-- End .footer-middle -->

  <div class="footer-bottom">
      <div class="container">
          <img src="{{asset('assets/images/logo/logo-footer.png')}}" alt="Decent Look" width="82" height="25">
      </div><!-- End .container -->
  </div><!-- End .footer-bottom -->
</footer><!-- End .footer -->
