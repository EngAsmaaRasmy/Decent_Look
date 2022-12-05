 <!DOCTYPE html>
<html lang="en" @if(App::getlocale()=='en') dir="ltr" @else dir="rtl" @endif>


<!-- molla/index-16.html  22 Nov 2019 10:00:09 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
      @if(isset($title))
          {{ $title }}
      @endif 
   </title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Decent Look Website">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
      <!-- Google Font -->

      <link rel="stylesheet" href="//cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{asset('assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css')}}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnific-popup/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery.countdown.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic&family=Poppins&display=swap" rel="stylesheet">
    <!-- Main CSS File -->
    @toastr_css
    @if(App::getlocale()=='en')
 
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/demos/demo-16.css')}}">
    @else
    <link rel="stylesheet" href="{{ asset('assets/css/rtl.css')}}"> 
    <link rel="stylesheet" href="{{asset('assets/css/demos/demo-16.css')}}">

    <style>
       *
       {
        font-family: 'Droid Arabic Kufi', serif !important;      
       }
       li
        {
            text-align:right;
        }
       .input-control select{
            font-size: 12px;
        }
       
    </style>
    @endif

    <style>

        /* Important part */
    
        .input-control input:focus {
            outline: 0;
        }
    
        input:required:valid  {
            border-color: #dadada;
         }
        input:required:invalid {
            border-color: #e61f7b;
        } 
        .toast-success, .toast-error , .toast-info , .toast-warning {
            font-size: 13px;
            width : 30%;
        }
        .banner img
        {
          height: 90vh;
        }
        .text-center .product-media img ,.product-4 .product-media img
        {
            height: 42vh;
        }
        @media only screen and (max-width: 600px) {
          .text-center .product-media img ,.product-4 .product-media img
            {
                height: 30vh;
            }
            .banner img
            {
              height: 70vh;
            }
        }
    </style>
    @if(App::getlocale()=='en')
    <style>
      .lang{
        font-family: 'Noto Kufi Arabic', sans-serif;
      }
    </style>
    @elseif(App::getlocale()=='ar')
    <style>
     .lang{
      font-family: 'Poppins', sans-serif;
      }
    </style>
    @endif

</head>

<body>
  <div class="page-wrapper">
    @include('layouts.header')
    @yield('main')
    @include('layouts.footer')
  </div>
  <button style="position: fixed;" id="scroll-top" title="quick chat"><a href="https://api.whatsapp.com/send?phone=919902142421&amp;text=Hi there! I have a question :)"><i class="icon-whatsapp"></i></a></button>
  @include('layouts.mobile-nav')

 <!-- Google Map -->
 <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDc3LRykbLB-y8MuomRUIY0qH5S6xgBLX4"></script>

<!-- Plugins JS File -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.hoverIntent.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/js/superfish.min.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-input-spinner.js')}}"></script>
<!-- Main JS File -->
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="{{asset('assets/js/demos/demo-16.js')}}"></script>

@toastr_js
@toastr_render

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-215979267-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-215979267-1');
</script>


</body>
</html>
