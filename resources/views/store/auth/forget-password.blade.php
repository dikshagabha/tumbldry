<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="../assets/paper_img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  
  <title>Forgot Password</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    
    <link href="{{ asset('store/bootstrap3/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('store/assets/css/ct-paper.css') }}" rel="stylesheet"/>
    <link href="{{ asset('store/assets/css/demo.css') }} " rel="stylesheet" /> 
    <link href="{{ asset('store/assets/css/examples.css') }}" rel="stylesheet" /> 
     <link href="{{asset('store/css/style.css')}}" rel="stylesheet">
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('css/waitMe.css')}}">
    <link rel="stylesheet" href="{{asset('css/pnotify.custom.min.css')}}">
    <style type="text/css">
      .error{color: red}
    </style>
</head>
<body>

  <body class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Forgot Password</h1>
                <!-- <p class="text-muted">Forgot Password</p> -->

                <br>

                {{Form::open(['route'=>'store.forget-password', 'id'=>'loginForm', 'method'=>'post'])}}
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-user size_class"></i>
                    </span>
                  </div>
                   <input type="text" class="form-control size_class" placeholder="Phone Number" name="phone_number">
                   <!-- <span class="error" id="email_error"></span> -->
                                   
                </div>
                <div class="input-group mb-3">
                   <span class="error" id="phone_number_error"></span>
                                   
                </div>
               <!--  <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fa fa-lock"></i>
                    </span>
                  </div>
                  <input type="password" class="form-control" name= 'password' placeholder="Password">
                                    
                 
                </div>
                 <div class="input-group mb-3">
                    <span class="error" id="password_error"></span>
                                   
                </div> -->
                <div class="row">
                  <div class="col-6">
                    <button class="btn btn-primary size_class" type="button" id="login">Send Message</button>
                  </div>
                  </form>
                  <div class="col-6 text-right">
                    <a href=" {{ route('store.login')}} ">Login</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <h2>TumbleDry</h2>
                  <p></p>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    
</body>

<script src="{{asset('store/assets/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
<script src="{{asset('store/assets/js/jquery-ui-1.10.4.custom.min.js')}}" type="text/javascript"></script>

<script src="{{asset('store/bootstrap3/js/bootstrap.js')}}" type="text/javascript"></script>

<!--  Plugins -->
<script src="{{asset('store/assets/js/ct-paper-checkbox.js')}}"></script>
<script src="{{asset('store/assets/js/ct-paper-radio.js')}}"></script>
<script src="{{asset('store/assets/js/bootstrap-select.js')}}"></script>
<script src="{{asset('store/assets/js/bootstrap-datepicker.js')}}"></script>

<script src=".{{asset('store/assets/js/ct-paper.js')}}"></script>
<script src="{{asset('js/waitMe.js')}}"></script>
<script src="{{asset('js/pnotify.custom.min.js')}}"></script>
    



<script type="text/javascript">
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
      $(document).on('click', '#login', function(e){
        e.preventDefault();
        $('body').waitMe();
        $(".error").html("");
        console.log($('#loginForm').serializeArray());
        $.ajax({
          url: $("#loginForm").attr('action'),
          type: $('#loginForm').attr('method'),
          data: $('#loginForm').serializeArray(),
          headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
                },
          dataType:'json',
          success: function(data){
            success(data.message);
            window.location=data.redirectTo;
            $('body').waitMe('hide');
          },
          error:function(data) {
           
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
    })
</script>
</html>