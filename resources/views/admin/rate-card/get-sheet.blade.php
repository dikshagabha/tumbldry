@extends('layouts.app')
@section('title', 'Manage Rate Cards')

@section('content')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jcf.css') }}">
@endsection

<div class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card card-stats">
         
          <br>
          {{Form::open(['route'=>'admin.getRateCardSheet', 'method'=>'post', 'id'=>'addFrenchise', 'name'=>'form_data'])}}
                     
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group-inner">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                      </div>
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          {{ Form::select('city',  $cities, 'global',['class' => 'form-control', 'placeholder' => 'Select City',
                          'id' => 'select-city',  'maxlength'=>'50', 'data-url'=>route('admin.getRateCardForm')]) }}
                          <span class="error" id="city_error"></span>
                         </div>
                          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            {{ Form::select('service', $services, null, ['class' => 'form-control', 'id' => 'select-service', 'placeholder'=>'Select Service', 'data-url'=>route('getRateRoute')]) }}
                            <span class="error" id="service_error"></span>
                           </div>

                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <a href="" id="demo_sheet" style="display: none">
                              <span class="btn btn-information" id="demo_sheet" title="Download Demo Excel"> <i class="fa fa-download"></i></span> </a>
                           </div>
                         
                       </div>
                  </div>

              </div>
              <br>

               <div class="form-group-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label class="login2 pull-right pull-right-pro">Upload Sheet</label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        {{Form::file('sheet', ['class'=>"form-control", 'id'=>'save_amount', 'data-type'=>'2'])}} 
                        
                        <span class="error" id="sheet_error"></span>
                             
                    </div>
                </div>
            </div>
             <div class="form-group-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label class="login2 pull-right pull-right-pro"></label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        {{Form::submit('Upload',['class'=>"btn btn-success save_amount", 'id'=>'save_amount', 'data-type'=>'2'])}} 
                        
                    </div>
                </div>
            </div>
            {{Form::close()}}
          <br>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="{{asset('js/jcf/jcf.js')}}"></script>
<script src="{{asset('js/jcf/jcf.file.js')}}"></script>
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script>
$(document).ready(function(){
	  jcf.replaceAll();
    $('#select-service').chosen();
    $('#select-city').chosen();

    $(document).on('change', '#select-service', function(e)
    {
      $('#demo_sheet').hide();
      $('body').waitMe();
       $(".error").html('')
      $.ajax({
          url:$('#select-service').data('url'),
          data:$('#addFrenchise').serializeArray(),
          type:'get',
          success: function(data){
            
             $('#demo_sheet').attr('href', data.route);
             $('#demo_sheet').show();
             $('body').waitMe('hide');
           }
      })
    })

     $(document).on('click', '#save_amount', function(e)
    {
      e.preventDefault();
      $(".error").html('')
      var form = $('#addFrenchise')[0];
        var data = new FormData(form);

      $.ajax({
          url:$('#addFrenchise').attr('action'),
          type:'post',
          data: data,
          processData:false,
          contentType:false,
          success: function(data){
            $('body').waitMe('hide');
            form.reset();
            $('#select-service').trigger('chosen:updated');
            $('#select-city').trigger('chosen:updated');
           }
      })
    })
    
})
</script>
@endpush
