
@extends('layouts.base',['title'=>'login to decent look website'])
<style>
    .span{
        color: red;
    }
</style>

@section('main')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">{{trans('site.home')}}</a></li>
                <li class="breadcrumb-item"><a href="#">{{trans('site.pages')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('site.log_in')}}</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url({{asset('assets/images/backgrounds/login-bg.jpg')}})">
        <div class="container">
            <div class="form-box">
                <div class="form-tab">
                    <ul class="nav nav-pills nav-fill nav-border-anim" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ count($errors) ? '' : 'active' }}" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">{{trans('site.log_in')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $errors->has('email')  ? 'active' : '' }} {{ $errors->has('password')  ? ' active' : '' }}" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">{{trans('site.sign_up')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tab-content-5">
                        <div class="tab-pane fade show  {{ count($errors) ? '' : 'active' }}" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                            <form action="{{ route('custmer.login') }}" method="post" enctype="multipart/form-data"
                                         autocomplete="">
                                         <h6 for="name">{{trans('site.important')}} <span class="span">*</span> {{trans('site.required')}}</h6>
                                         {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="singin-email-2"> {{trans('site.email')}} <span class="span">*</span> </label>
                                        <input type="email" class="form-control" id="singin-email-2" name="email" required>
                                        @if ($errors->any())
                                        <small for="fname" class="error text-danger" style="font-size: 15px">{{ $errors->first('email')}}</small> 
                                      @endif
                                    </div><!-- End .form-group -->

                                    <div class="form-group">
                                        <label for="singin-password-2">{{trans('site.password')}} <span class="span">*</span> </label>
                                        <input type="password" class="form-control" id="singin-password-2" name="password" required>
                                        @if ($errors->any())
                                        <small for="fname" class="error text-danger" style="font-size: 15px">{{ $errors->first('password')}}</small> 
                                      @endif
                                    </div><!-- End .form-group -->

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>{{trans('site.log_in')}}</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </div><!-- End .form-footer -->
                                    <a href="{{route ('forget.password.get')}}" class="forgot-link">{{trans('site.forget')}}</a>
                                </form>
                        </div><!-- .End .tab-pane -->
                        <div class="tab-pane fade show {{ $errors->has('email')  ? 'active' : '' }} {{ $errors->has('password')  ? 'active' : '' }}" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form action="{{ route('register.store') }}" method="post" enctype="multipart/form-data"
                            autocomplete="">
                            <h6 for="name">{{trans('site.important')}} <span class="span">*</span> {{trans('site.required')}}</h6>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="singin-email-2">{{trans('site.full_name')}} <span class="span">*</span> </label>
                                <input type="text" class="form-control" placeholder="Name" id="singin-email-2" pattern="\D.{2,}" name="name" required>
                                @if ($errors->any())
                                        <small for="fname" class="error text-danger" style="font-size: 12px">{{ $errors->first('name')}}</small> 
                                      @endif
                            </div>
                            <div class="form-group"> 
                                <label for="singin-email-2">{{trans('site.email')}} <span class="span">*</span> </label>
                                <input type="email" class="form-control" placeholder="user@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  id="singin-email-2" name="email" required>
                                @if ($errors->any())
                                <small for="fname" class="error text-danger" style="font-size: 12px">{{ $errors->first('email')}}</small> 
                              @endif
                            </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>{{trans('site.phone')}} <span class="span">*</span> </label>
                                        <input type="text" class="form-control" placeholder="0XXXXXXXXX" pattern="^0[0-9]{9,12}"  name="phone" required>
                                        @if ($errors->any())
                                        <small for="fname" class="error text-danger" style="font-size: 12px">{{ $errors->first('phone')}}</small> 
                                      @endif
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>{{trans('site.address')}} ({{trans('site.optional')}})</label>
                                        <input type="text" class="form-control" name="address">
                                        @if ($errors->any())
                                        <small for="fname" class="error text-danger" style="font-size: 12px">{{ $errors->first('address')}}</small> 
                                      @endif
                                        
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>{{trans('site.password')}} <span class="span">*</span> </label>
                                        <input type="password" class="form-control"  pattern=".{6,}" id="singin-password-2" name="password" required>
                                        @if ($errors->any())
                                        <small for="fname" class="error text-danger" style="font-size: 12px">{{ $errors->first('password')}}</small> 
                                      @endif
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>{{trans('site.confirm_password')}} <span class="span">*</span> </label>
                                        <input type="password" class="form-control" pattern=".{6,}" name="password_confirmation" required>
                                        @if ($errors->any())
                                        <small for="fname" class="error text-danger" style="font-size: 12px">{{ $errors->first('password_confirmation')}}</small> 
                                      @endif
                                        
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>{{trans('site.sign_up')}}</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>  
                                </div><!-- End .form-footer -->
                            </form>
                        </div><!-- .End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .form-tab -->
            </div><!-- End .form-box -->
            </div><!-- End .form-box -->
        </div><!-- End .container -->
    </div><!-- End .login-page section-bg -->
</main><!-- End .main -->
@endsection