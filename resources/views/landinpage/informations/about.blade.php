@extends('layouts.base',['title'=>'About Decent Look'])
@section('main')

<main class="main">

        	<div class="page-header text-center" style="background-image: url('{{asset('')}}assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">{{trans('site.about_us')}}</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">{{trans('site.home')}}</a></li>
                        <li class="breadcrumb-item"><a href="">{{trans('site.pages')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{trans('site.about_us')}}</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('{{asset('')}}assets/images/backgrounds/bg-4.jpg')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1 m-auto">
                            <div class="about-text text-center mt-3">
                                <h2 class="title text-center mb-2" style="color: rgb(245, 236, 236)">{{trans('site.who_we_are')}}</h2><!-- End .title text-center mb-2 -->
                                <p style="color: white !important; font-size: 15px !important;"> @if(App::getlocale()=='ar')
                                    {{$info->about_me_ar ??'None'}}
                                    @else
                                    {{$info->about_me ??'None'}}
                                    @endif
                                    </p>
                            </div><!-- End .about-text -->
                        </div><!-- End .col-lg-10 offset-1 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .bg-image pt-8 pb-8 -->

</main><!-- End .main -->




@endsection
