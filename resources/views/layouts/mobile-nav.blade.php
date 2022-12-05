<div class="mobile-menu-container mobile-menu-light">
  <div class="mobile-menu-wrapper">
      <span class="mobile-menu-close"><i class="icon-close"></i></span>

      <form action="{{route ('products.search')}}" method="get" class="mobile-search">
        <label for="q" class="sr-only">{{trans('site.search')}}</label>
        <input type="search" class="form-control" name="search" id="q" placeholder="{{trans('site.search_in')}}..." required>
          <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
      </form>

      <nav class="mobile-nav">
          <ul class="mobile-menu">
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a href="{{url('/')}}" class="">{{trans('site.home')}}</a>
            </li>
            <li class="{{ Request::is('web-site-categories') ? 'active' : '' }}">
                <a  href="{{route('web-site-categories.index')}}" class="sf-with-ul sub">{{trans('site.categories')}}</a>
                    <ul class="sub-menu">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{route ('web-site-categories.show',[$category->id])}}" class="sf-with">
                                @if(App::getlocale()=='ar')
                                {{$category->name_ar ??'None' }}
                                @else
                                {{$category->name ??'None' }}
                                @endif
                            </a>
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
          </ul>
      </nav><!-- End .mobile-nav -->

      <div class="social-icons">
          <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
          <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
          <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
          <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
      </div><!-- End .social-icons -->
  </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->
