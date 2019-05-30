@extends('store.layouts.app', ['activePage' => 'rates', 'titlePage' => __('Rates')])
@section('title', 'Rates')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
@endsection

@section('content')




<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
    <vs-card>
      <div slot="header">
        <h3>
          Rate Card
        </h3>
      </div>
      <div>

        <vs-row vs-justify="center">
         <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">

         
            <br>
{{Form::open(['route'=>'store.getRate', 'id'=>'rateForm'])}}

                  <div class="row">
                    <!-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    </div> -->
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                        {{ Form::select('type',  $types, null, ['class' => 'form-control', 'placeholder' => 'Select Type', 'id' => 'select_type', 'data-url'=>route('store.getServices')]) }}
                        <span class="error" id="type_error"></span>
                    </div>
                  

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                        {{ Form::select('service',  [], null,['class' => 'form-control', 'placeholder' => 'Select Service',
                        'id' => 'select_service',  'maxlength'=>'50']) }}
                        <span class="error" id="service_error"></span>
                    </div>
                     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                        {{ Form::submit('Submit', ['class' => 'btn btn-warning',
                        'id' => 'search_rate', 'data-url'=>route('store.getRate')]) }}

                        {{ Form::button('Reset', ['class' => 'btn btn-danger reset',
                         'data-type'=>1]) }}
                       
                    </div>
                  </div>                
                {{Form::close()}}
                <br>
                <div id="dataList">

                  
                </div>
      </vs-col>
    <br>
    </vs-row>
    </div>
    
    </vs-card>
  </vs-col>
</vs-row>

@endsection

@push('js')

<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('#select_type').chosen();
      $('#select_city').chosen();
      $('#select_service').chosen();
     $(document).on('change', '#select_type', function(e){
      e.preventDefault(); 
        
        $(".error").html("");
        $('body').waitMe();

        $.ajax({
          url:$('#select_type').data('url'),
          data:{'type': $('#select_type').val()},
          type:'get',
          success: function(data){
            $('#select_service').html("");
            
            
            $.each(data.service, function(key, value) {   
               $('#select_service')
                   .append($("<option></option>")
                              .attr("value", key)
                              .text(value)); 
            });
            $('#select_service').trigger('chosen:updated')
            $('body').waitMe('hide');
          }
        })
      });

     $(document).on('click', '.reset', function (e) {
      e.preventDefault();        
        $(".error").html("");
        $('body').waitMe();

        type = $(this).data('type');

        if (type==1) 
        {
          $('#rateForm')[0].reset();
          $("#dataList").hide();
        }
        else{
          $('#customerForm')[0].reset();
          $("#Userist").hide();
        }

         $('body').waitMe('hide');
     })

    $(document).on('click', '#search_rate', function(e){
      e.preventDefault();        
        $(".error").html("");
        $('body').waitMe();

        $.ajax({
          url:$('#rateForm').attr('action'),
          data:$('#rateForm').serializeArray(),
          type:'post',
          success: function(data){
            $('#dataList').html(data);
            $("#dataList").show();
            $('body').waitMe('hide');
          }
        })
         });
    $(document).on("click",".pagination li a",function(e) {
        e.preventDefault();
        //load_listings($(this).attr('href'), 'form_data');
        url = $(this).attr('href');
        $.ajax({
          url:url,
          data:$('#rateForm').serializeArray(),
          type:'post',
          success: function(data){
            $('#dataList').html(data);
            $('body').waitMe('hide');
          }
        })

      });
    });
  </script>
@endpush