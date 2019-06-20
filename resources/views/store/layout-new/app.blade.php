<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <!-- Main styles for this application-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/vuesax/dist/vuesax.css" rel="stylesheet">
    <link href="{{asset('store/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('store/css/timeline.css')}}" rel="stylesheet">
    
  </head>
  <style type="text/css">
    .error{
      color: red;
    }
  </style>
  @yield('css')
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('store.layout-new.header')
    <div class="app-body" id='app'>
       @include('store.layout-new.sidebar')
       <main class="main">
        <!-- Breadcrumb-->  
        <div class="container-fluid">
          <div class="animated fadeIn">
          <div class="row">
              <div class="col-md-12">
                <div class="card">                  
                  <div class="card-body">
                   @yield('content')                    
                  </div>
                </div>
              </div>
            </div>            
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
<script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
<script src="{{ asset('material') }}/js/core/popper.min.js"></script>
<!-- <script src="{{asset('store/js/charts.js')}}"></script>
<script src="{{asset('store/js/colors.js')}}"></script>
<script src="{{asset('store/js/widgets.js')}}"></script>
<script src="{{asset('store/js/popovers.js')}}"></script> -->

<script src="{{asset('store/js/main.js')}}"></script>

<script type="text/javascript">
  
  
</script>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="{{asset('js/waitMe.js')}}"></script>
<script src="{{asset('js/pnotify.custom.min.js')}}"></script>
<script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/moment-timezone.min.js') }}" type="text/javascript"></script>

<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuesax/dist/vuesax.umd.js"></script>

<script src="https://js.pusher.com/4.4/pusher.min.js"></script>



@auth()          
<script type="text/javascript">

  new Vue({
          el: '#app',
          data:{
             active:false,
             activeItem:false,
             notExpand: false,
             reduce:true,
          }
        })
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
        $(".timeline").prepend("<li><p>"+data.message+"</p></li>");
        load_listings(location.href);
      });
  })
</script>
@endauth

<script type="text/javascript">
  
$(document).ready(function(){

$(document).on('click', '.sidebar-toggler', function(e){
current = $(this);

if($('body').hasClass(current.data('toggle'))){
$('body').removeClass(current.data('toggle'));

$('body').addClass('pace-done');

}else{
$('body').removeClass('pace-done');
$('body').addClass(current.data('toggle'));

}
})

$(document).on('click', '.notifications', function(e){
  e.preventDefault();
  current = $(this);

  if($('.dropdown-menu').hasClass('show')){
  $('.dropdown-menu').removeClass('show');       
  }else{
  $('.dropdown-menu').removeClass('show');
  $('.dropdown-menu').addClass('show');

  }
  })
})

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
         //console.log(data);
         if (data.responseJSON) {error(data.responseJSON.message);}
         
         else {
          error("Something went wrong")}
         
      }
    }
  })

})
</script>
@stack('js') 
