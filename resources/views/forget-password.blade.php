
@extends('layouts.base',['title'=>'Reset password'])

@section('main')
<main class="main">
    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url({{asset('assets/images/backgrounds/login-bg.jpg')}})">
        <div class="container">
            <div class="form-box">
               <div class="form-tab">
                <ul class="nav nav-pills nav-fill" role="tablist">
							   
                    <li class="nav-item">
                        <a class="nav-link active" id="register-tab-2" data-toggle="tab" href="#forgetPassword" role="tab" aria-controls="forgetPassword" aria-selected="true">{{trans('site.forget')}}</a>
                    </li>
                </ul>
                <div class="tab-pane fade show active" id="forgetPassword" role="tabpanel" aria-labelledby="register-tab-2">
                    <form method="POST" action="{{ route('forget.password.post') }}">

                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="singin-email-2">{{trans('site.email')}} *</label>
                            <input type="email" class="form-control" id="email_address" name="email" required autofocus>
                        </div><!-- End .form-group -->

                        <div class="form-footer">
                            <div> 
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>{{trans('site.send')}}</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                            </div>
                        </div><!-- End .form-footer -->
                        
                    </form>
                </div><!-- .End .tab-pane -->
            </div><!-- End .form-tab -->
            </div><!-- End .form-box -->
        </div><!-- End .container -->
    </div><!-- End .login-page section-bg -->
</main><!-- End .main -->
@endsection