@extends('layouts.base',['title'=>'Contact to Decent look'])
@section('main')
<style>
    .contact-box a
    {
        font-size: 18px;
    }
</style>



<main class="main">
    <div class="page-header text-center" style="background-image: url('{{asset('')}}assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">{{trans('site.contact_us')}}</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('site.home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{url('landinpage/categories')}}">{{trans('site.pages')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('site.contact_us')}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div id="map" class="mb-5"><div class="mapouter"><div class="gmap_canvas"><iframe class="gmap_iframe" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=khartom&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a href="https://www.fridaynightfunkin.net/friday-night-funkin-mods-fnf-play-online/">FNF Mods</a></div><style>.mapouter{position:relative;text-align:right;width:100%;height:100%;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;height:100%;}.gmap_iframe {height:100%!important;}</style></div></div><!-- End #map -->
        <div class="container">
            <div class="touch-container row justify-content-center my-5">
                <div class="col-md-9 col-lg-7">
                    <div class="text-center">
                    <h2 class="title mb-1">{{trans('site.get_in_touch')}}</h2><!-- End .title mb-2 -->
                    <p class="lead text-primary">
                        {{trans('site.contact_p')}} 
                    </p><!-- End .lead text-primary -->
                    </div><!-- End .text-center -->
                </div><!-- End .col-md-9 col-lg-7 -->
            </div><!-- End .row -->
            <div class="row">
                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h1><span class="icon icon-phone"></span></h1>
                        <h3>{{trans('site.phone')}}</h3>
                        <p>
                            <a href="tel:{{$info->phone ?? 'None'}}">{{$info->phone ?? 'None'}}</a></i>
                        </p>
                        
                    
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-3 -->
                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h1><span class="icon icon-envelope"></span></h1>
                        <h3>{{trans('site.start_conversation')}}</h3>

                        <p><a href="mailto:{{$info->email}}">{{$info->email ?? 'None'}}</a></p>
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-3 -->

                <div class="col-md-4">
                    <div class="contact-box text-center">
                        <h1><span class="icon icon-whatsapp"></span></h1>
                        <h3>{{trans('site.social')}}</h3>

                        <p>
                        <a title="quick chat" href="https://api.whatsapp.com/send?phone=919902142421&amp;text=Hi there! I have a question :)">{{$info->url_whatsap ?? 'None'}}</a>
                        </p><!-- End .soial-icons -->
                    </div><!-- End .contact-box -->
                </div><!-- End .col-md-3 -->
            </div><!-- End .row -->

            
        </div><!-- End .container -->
    </div>

</main><!-- End .main -->




@endsection
