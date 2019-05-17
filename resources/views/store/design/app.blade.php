<!doctype html>
<html lang="en" style="height: 100%">
<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="assets/paper_img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>{{$titlePage}}|Tumbldry</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('store/bootstrap3/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('store/assets/css/ct-paper.css') }}" rel="stylesheet"/>
    <link href="{{ asset('store/assets/css/demo.css') }}" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('css/waitMe.css')}}">
    <link rel="stylesheet" href="{{asset('css/pnotify.custom.min.css')}}">
    </head>
    <style type="text/css">
      .error{
        color: red;
      }

      
.table-modal
{word-break: break-word;}
    </style>
     @yield('css')
</head>

<body>
<nav class="navbar navbar-ct-transparent" role="navigation-demo" id="demo-navbar">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="{{route('store.home')}}">
           <div class="logo-container">
                <div class="logo" style="width:100px">
                    <img src="{{asset('images/logo.png')}}"  alt="Creative Tim Logo">
                </div>
                <div class="brand" @if($titlePage!="Dashboard") style="color: black" @endif>
                    TumblDry
                </div>
            </div>
      </a>
    </div>

<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navigation-example-2">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <button href="#" class="dropdown-toggle btn btn-danger btn-simple" data-toggle="dropdown">Users <b class="caret"></b></button>
            <ul class="dropdown-menu dropdown-danger dropdown-menu-right">
              <li><a href="{{ route('manage-customer.index') }}">Customer</a></li>
              <li><a href="{{ route('manage-runner.index') }}">Runner</a></li>
            </ul>
        </li>
        <li>
          <a href="{{ route('store.create-order.index') }}" class="btn btn-danger btn-simple">Order</a>
        </li>
        <li>
          <button href="#" class="dropdown-toggle btn btn-danger btn-simple" data-toggle="dropdown">
          <i class="fa fa-bell"> </i> (<span class="notif-count" >{{Auth::user()->notifications()->where('read_at', 'null')->count()}}</span>)</button>

          <ul class="dropdown-menu dropdown-danger dropdown-menu-right">

            @if(Auth::user()->notifications)    
              @foreach(Auth::user()->notifications as $notifications)
                <li><a class="dropdown-item @if($notifications->read_at==null) font-weight-bold @endif" href="#">{{ $notifications->message }}</a></li>
              @endforeach
            @else
              <a class="dropdown-item" href="#">No Notifications</a>
            @endif
              
              <!-- <li><a href="{{ route('manage-customer.index') }}">Customer</a></li>
              <li><a href="{{ route('manage-runner.index') }}">Runner</a></li> -->
          </ul>
        </li>
        <li>
          <button href="#" class="dropdown-toggle btn btn-danger btn-simple" data-toggle="dropdown">
          <i class="fa fa-user"> </i></button>
          <ul class="dropdown-menu dropdown-danger dropdown-menu-right">
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}">{{ __('Log out') }}</a>
            </li>
          </ul>
        </li>
      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-->
</nav>

<div class="wrapper">

    @if($titlePage=="Dashboard")
    <div class="demo-header demo-header-image">
            <div class="motto">
                <h1 class="title-uppercase">WELCOME {{Auth::user()->name}}</h1>
                <h3> </h3>
            </div>
    </div>
    @endif
    <div class="main">
        <div class="section">
         <div class="container tim-container">
            <div class="tim-title">
                <h3>{{$titlePage}}</h3>
            </div>
            @yield('content')
          </div>
        </div>
    </div>

    <footer class="footer-demo section-dark">
    <div class="container">
        <nav class="pull-left">
            <ul>

                <li>
                    <a href="http://www.creative-tim.com">
                        TumblDry
                    </a>
                </li>
                <li>
                    <!-- <a href="http://blog.creative-tim.com">
                       Blog
                    </a> -->
                </li>
                <li>
                    <!-- <a href="http://www.creative-tim.com/product/rubik">
                        Licenses
                    </a> -->
                </li>
            </ul>
        </nav>
        <div class="copyright pull-right">
            &copy; 2019
        </div>
    </div>
</footer>
</div>

<script src="{{asset('store/assets/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
  <script src="{{asset('store/assets/js/jquery-ui-1.10.4.custom.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('store/bootstrap3/js/bootstrap.js')}}" type="text/javascript"></script>

  <!--  Plugins -->
  <script src="{{asset('store/assets/js/ct-paper-checkbox.js')}}"></script>
  <script src="{{asset('store/assets/js/ct-paper-radio.js')}}"></script>
  <script src="{{asset('store/assets/js/bootstrap-select.js')}}"></script>
  <script src="{{asset('store/assets/js/bootstrap-datepicker.js')}}"></script>

  <script src="{{asset('store/assets/js/ct-paper.js')}}"></script>


  <script src="{{asset('js/waitMe.js')}}"></script>
  <script src="{{asset('js/pnotify.custom.min.js')}}"></script>
  <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/moment-timezone.min.js') }}" type="text/javascript"></script>
  
  <script src="https://js.pusher.com/4.4/pusher.min.js"></script>

  @auth()
          <script type="text/javascript">
            $(document).ready(function(){

              user_id = "{{Auth::user()->id}}";
              var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
                cluster: 'ap2',
                forceTLS: true
              });

             var channel = pusher.subscribe('my-channel');
              channel.bind('notification'+user_id, function(data) {
                  $(".notif-count").text(parseInt($(".notif-count").text())+1);
                  console.log(data.message);
                  $(".dropdown-menu").prepend("<li><a class='dropdown-item' href='#'>"+data.message+"</a></li>");
                  load_listings(location.href);
                });
            })
          </script>
        @endauth
        <script>
          var user_timezone;
          $(document).ready(function(){
          user_timezone = moment.tz.guess();
          

           $.ajax({
            type: 'POST',
            url: {!! json_encode(route('store.set-timezone')) !!},
            data: {
                user_timezone : moment.tz(user_timezone).format("Z")
            },
            datatype: 'html',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

          $(document).on('click', ".notifications", function(e){
            e.preventDefault();
            //$(".notif-count").text(0);
            url = $(this).attr('href');
            console.log(url);
            $.ajax({
                  async: false,
                  type : 'post',
                  url : url,
                 // data : data,
                 // dataType : 'html',
                  success : function(data) {

                    $(".notif-count").text(0);
                  },
                });

            })
          });
         
      </script>

        <script type="text/javascript">
            
            function load_listings(url, filter_form_name) {
                let data = {};
                // check if the element is not specified
                if(typeof filter_form_name !== 'undefined') {
                  data = $("form[name="+filter_form_name+"]").serialize();
                }

                // send the ajax request for the url
                $.ajax({
                  async: false,
                  type : 'get',
                  url : url,
                  data : data,
                  dataType : 'html',
                  success : function(data) {
                    $('body').waitMe('hide');
                    $("#dataList").empty();
                    $("#dataList").html(data);
                  },
                  error : function(response) {
                    error("Unable to fetch the list");
                  }
                });
              }

          function success(message=""){
              PNotify.removeAll() 
              new PNotify({
                title: 'Success!',
                text: message,
                type: 'success'
              });
            }
            
            function error(message){
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
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
                  'timezone': user_timezone
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
                     
                     if (data.responseJSON) {error(data.responseJSON.message);}
                     
                     else {error("Something went wrong")}
                     
                  }
                }
              })

            })
</script>
        </script>
        @stack('js')
</body>

