@extends('store.layout-new.app')

@section('title', 'Change Password')

@section('content')

{{Form::open(['route'=>'store.change-password', 'id'=>'loginForm', 'method'=>'post'])}}
<div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
   			<a href="{{ route('store.home') }}" id="back"> 
   				<vs-button color="danger" type="border" icon="arrow_back"></vs-button></a>
  		 </div> 
               <br>
               <br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Old Password</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::password('old_password',array('class' => 'form-control', "maxlength"=>20,
                                "id"=>'phone',  "placeholder"=>"Old Password")) !!}
                <span class="error" id="old_password_error"></span>
                
               </div>               
          </div>
        </div>
        <br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">New Password</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::password('password',array('class' => 'form-control', "maxlength"=>20,
                                "id"=>'phone',  "placeholder"=>"New Password")) !!}
                <span class="error" id="password_error"></span>
                
               </div>               
          </div>
        </div>
        <br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Confirm Password</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::password('password_confirmation',array('class' => 'form-control', "maxlength"=>20,
                                "id"=>'phone',  "placeholder"=>"Confirm Password")) !!}
                <span class="error" id="password_confirmation_error"></span>
                
               </div>               
          </div>
        </div>
        <br>

        <div class="form-group-inner">
          <div class="row">
          	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
               		<button class="btn btn-success" id="save">Save</button>
               </div>
                            
          </div>
        </div>
        <br>
    </div>
</div>
{{Form::close()}}
@endsection
@push('js')
<script type="text/javascript">
	
	$(document).ready(function(){
		$(document).on('click','#save',function(e){

			e.preventDefault();
			$('.error').html("");
			$.ajax({
				url:$('#loginForm').attr('action'),
				method:'post',
				data:$('#loginForm').serializeArray(),
				success:function (data) {
					success(data.message);
					window.location = data.redirectTo;
				}
			});
		});
		$(document).on('click','#back',function(e){
			e.preventDefault();
			$('.error').html("");
			window.location = $(this).attr('href');
		});

	});
</script>
@endpush