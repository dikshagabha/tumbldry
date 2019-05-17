<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="../assets/paper_img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  
  <title>Login</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    
    <link href="{{ asset('store/bootstrap3/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('store/assets/css/ct-paper.css') }}" rel="stylesheet"/>
    <link href="{{ asset('store/assets/css/demo.css') }} " rel="stylesheet" /> 
    <link href="{{ asset('store/assets/css/examples.css') }}" rel="stylesheet" /> 
        
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('css/waitMe.css')}}">
    <link rel="stylesheet" href="{{asset('css/pnotify.custom.min.css')}}">
</head>
<body>
    <nav class="navbar navbar-ct-transparent navbar-fixed-top" role="navigation-demo" id="register-navbar">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Tumbldry</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <!-- <div class="collapse navbar-collapse" id="navigation-example-2">
          <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="#" class="btn btn-simple">Components</a>
            </li>
            <li>
                <a href="#" class="btn btn-simple">Tutorial</a>
            </li>
            <li>
                <a href="#" target="_blank" class="btn btn-simple"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
                <a href="#" target="_blank" class="btn btn-simple"><i class="fa fa-facebook"></i></a>
            </li>
           </ul>
        </div>
      </div> /.container-->
    </nav> 
    
    <div class="wrapper">
        <div class="register-background"> 
            <div class="filter-black"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 ">
                            <div class="register-card">
                                <h3 class="title">Welcome</h3>
                                  {{Form::open(['route'=>'store.login', 'id'=>'loginForm', 'method'=>'post'])}}
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="Email" name="email">
                                    <span class="error" id="email_error"></span>
                                    <br>
                                    <label>Password</label>
                                    <input type="password" class="form-control" name= 'password' placeholder="Password">
                                    <span class="error" id="password_error"></span>
                                    <br>
                                    <button class="btn btn-danger btn-block" id="login">Login</button>
                                  </form>
                                <div class="forgot">
                                    <!-- <a href="#" class="btn btn-simple btn-danger">Forgot password?</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>     
            <div class="footer register-footer text-center">
                    <h6>&copy; 2019</h6>
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