<!doctype html>
<html  lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Reset Password</title>
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
    <link rel="stylesheet" href="css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
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
    <script src="{{asset('js/vendor/modernizr-2.8.3.min.js')}}"></script>

</head>

<body>
  <div class="bgimage"></div>

	<div class="error-pagewrap">
		<div class="error-page-int">

			<div class="content-error">
				<div class="hpanel">
                  <div class="panel-body">
                    <div class="text-center m-b-md custom-login">
                      <h3>RESET PASSWORD</h3>
                    </div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                            <div class="form-group">
                              <label for="email" class="control-label">{{ __('Email') }}</label>

                              <div class="">
                                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                  @if ($errors->has('email'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                  @endif
                              </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input id="password" type="password" title="Please enter your password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <label class="invalid-feedback error" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </label>
                                @endif
                              </div>  -->

                            <!-- <div class="checkbox login-checkbox form-group">
                              <label for="remember" class="control-label">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="i-checks" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                  {{ __('Remember Me') }}
                              </label> -->

                            <div style="text-align:center">
                              <!-- <button class="btn btn-success btn-block loginbtn">Login</button> -->
                              <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                              </button>
                          </div>
                        </form>
                    </div>
                </div>
			</div>

		</div>
    </div>
</body>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
  $(document).ready(function(){

  var header = $('.bgimage');

  var backgrounds = new Array(
      'url({{asset("images/bg1.jpg")}})'
    , 'url({{asset("images/bg2.jpg")}})'
    , 'url({{asset("images/bg3.jpg")}})'
  );
console.log(backgrounds);
  var current = 0;

  function nextBackground() {
      current++;
      current = current % backgrounds.length;
      header.css('background-image', backgrounds[current]);
  }
  setInterval(nextBackground, 10000);

  header.css('background-image', backgrounds[0]);
  // header.css('background-size', 'cover');
  // header.css('filter', 'blur(5px)');

  });
</script>
</html>
