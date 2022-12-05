
@extends('layouts.base')

@section('main')
<main class="main">
    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url({{asset('assets/images/backgrounds/login-bg.jpg')}})">
        <div class="container">
            <div class="form-box">
                @if ($errors->any())
                <div class="alert alert-danger col-md-11 rounded mx-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
               @endif
                <div class="form-tab">
                    <ul class="nav nav-pills nav-fill" role="tablist">	   
                        <li class="nav-item">
                            <a class="nav-link active" id="register-tab-2" data-toggle="tab" href="#forgetPassword" role="tab" aria-controls="forgetPassword" aria-selected="true">Reset Password</a>
                        </li>
                    </ul>
                    <div class="tab-pane" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
                        <form method="POST" action="{{ route('reset.password.post') }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <label for="singin-email-2">{{trans('site.email')}} *</label>
                                <input type="email" class="form-control" id="email_address" name="email" required>
                            </div><!-- End .form-group -->

                            <div class="form-group">
                                <label for="singin-email-2">{{trans('site.new_password')}} *</label>
                                <input type="password" class="form-control" id="email_address" name="password" required autofocus>
                            </div><!-- End .form-group -->
    
                            <div class="form-group">
                                <label for="singin-email-2">{{trans('site.confirm_password')}} *</label>
                                <input type="password" class="form-control" id="email_address" name="password_confirmation" required autofocus>
                            </div><!-- End .form-group -->

                            <div class="form-footer">
                                <div> 
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>{{trans('site.submit')}}</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                </div>
                            </div><!-- End .form-footer -->
                            
                        </form>
                        
                    </div><!-- .End .tab-pane -->
                                  </div><!-- End .tab-content -->
                </div><!-- End .form-tab -->
            </div><!-- End .form-box -->
        </div><!-- End .container -->
    </div><!-- End .login-page section-bg -->
</main><!-- End .main -
@endsection