<!doctype html>
<html  lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')| TumbleDry</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.transitions.css')}}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/meanmenu.min.css')}}">
    <!-- educate icon CSS
    ============================================ -->
    <link rel="stylesheet" href="{{asset('css/educate-custon-icon.css')}}">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/morrisjs/morris.css')}}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/scrollbar/jquery.mCustomScrollbar.min.css')}}">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/metisMenu/metisMenu.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/metisMenu/metisMenu-vertical.css')}}">

    <!-- forms CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/form/all-type-forms.css')}}">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <!-- modernizr JS
		============================================ -->

    <link rel="stylesheet" href="{{asset('css/waitMe.css')}}">
        <link rel="stylesheet" href="{{asset('css/pnotify.custom.min.css')}}">
    <script src="{{asset('js/vendor/modernizr-2.8.3.min.js')}}"></script>

      @yield('css')
</head>
<body>
  @include('admin.layout.sidebar')
  <div class="all-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="logo-pro">
                    <a href="index.html"><img class="main-logo" width="200px" height="200px" src="{{asset('images/logo.png')}}" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layout.header')
    <div class="content">
      <div class="container-fluid"  style="background-color:white;">
            @yield('content')
        </div>
    </div>
    <!-- @include('store.layout.footer') -->
  </div>
</body>
<!-- jquery
============================================ -->
<script src="{{asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
<!-- bootstrap JS
============================================ -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- wow JS
============================================ -->
<script src="{{asset('js/wow.min.js')}}"></script>
<!-- price-slider JS
============================================ -->
<script src="{{asset('js/jquery-price-slider.js')}}"></script>
<!-- meanmenu JS
============================================ -->
<script src="{{asset('js/jquery.meanmenu.js')}}"></script>
<!-- owl.carousel JS
============================================ -->
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<!-- sticky JS
============================================ -->
<script src="{{asset('js/jquery.sticky.js')}}"></script>
<!-- scrollUp JS
============================================ -->
<script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
<!-- counterup JS
============================================ -->
<script src="{{asset('js/counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset('js/counterup/waypoints.min.js')}}"></script>
<script src="{{asset('js/counterup/counterup-active.js')}}"></script>
<!-- mCustomScrollbar JS
============================================ -->
<script src="{{asset('js/scrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('js/scrollbar/mCustomScrollbar-active.js')}}"></script>
<!-- metisMenu JS
============================================ -->
<script src="{{asset('js/metisMenu/metisMenu.min.js')}}"></script>
<script src="{{asset('js/metisMenu/metisMenu-active.js')}}"></script>
<!-- morrisjs JS
============================================ -->
<!-- <script src="{{asset('js/morrisjs/raphael-min.js')}}"></script>
<script src="{{asset('js/morrisjs/morris.js')}}"></script>
<script src="{{asset('js/morrisjs/morris-active.js')}}"></script> -->
<!-- morrisjs JS
============================================ -->
<script src="{{asset('js/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('js/sparkline/jquery.charts-sparkline.js')}}"></script>
<script src="{{asset('js/sparkline/sparkline-active.js')}}"></script>

<!-- plugins JS
============================================ -->
<script src="{{asset('js/plugins.js')}}"></script>
<!-- main JS
============================================ -->
<script src="{{asset('js/main.js')}}"></script>

<script src="{{asset('js/waitMe.js')}}"></script>
<script src="{{asset('js/pnotify.custom.min.js')}}"></script>

<script>
function success(message=""){
  PNotify.removeAll() 
  new PNotify({
    title: 'Success!',
    text: message,
    type: 'success'
  });
}
function error(message="Something went wrong"){
  PNotify.removeAll() 
  new PNotify({
    title: 'Error!',
    text: message,
    type: 'error'
  });
}
$(document).ready(function(){

  $.ajaxSetup({
    headers:{
      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    },
    error: function(data, status){
      if(data.status==422){
        $('body').waitMe('hide');
        var errors = data.responseJSON;
        for (var key in errors.errors) {
          console.log(errors.errors[key][0])
            $("#"+key+"_error").html(errors.errors[key][0])
          }
      }
      else{
         $('body').waitMe('hide');
         error();
      }
    }
  })

})
</script>
@yield('js')
