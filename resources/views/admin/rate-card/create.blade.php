@extends('layouts.app')
@section('title', 'Manage Store')

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

          <div class="row">            
            <a href = "{{route('admin.getBlankExcel')}}" ><button id="export" data-url="{{route('admin.getBlankExcel')}}" class="btn btn-link">Demo Excel</button></a>
          </div>
          <br>
          {{Form::open(['route'=>'admin.postRateCardForm', 'method'=>'post', 'id'=>'addFrenchise', 'name'=>'form_data'])}}
          
          <!-- <form action="{{route('admin.getRateCardForm')}}"
           method="post"  id="getForm" enctype="multipart/form-data"> -->
           
            @csrf
            @include('admin.rate-card.form')

             <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                <!-- <a href="{{route('manage-store.index')}}">
                  <button type="button" class="btn btn-default" data-id="5" data-url="{{route('admin.store.add', 5)}}">Cancel</button>
                </a> -->
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                 
               </div>
              </div>
         <!--  </form> -->
          <br><br>

            <div id="dataList">

                  @if($type==1)
                    @include("admin.rate-card.global-quantity")
                  @else
                    @include("admin.rate-card.global-price")
                  @endif
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
<script src="{{asset('js/jcf/jcf.checkbox.js')}}"></script>
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>


<script>
$(document).ready(function(){
	  jcf.replaceAll();
  $('#select-service').chosen();
  $('#select-city').chosen();


  $(document).on('change', '#select-city, #select-service', function(e)
  {
    e.preventDefault(); 
    $(".error").html("");
    $('body').waitMe();
    $.ajax({
      url:$('#select-city').data('url'),
      data:$('#addFrenchise').serializeArray(),
      type:'get',
      success: function(data){
        $('#dataList').html(data);
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click",".pagination li a",function(e) {
    e.preventDefault();
    load_listings($(this).attr('href'), 'form_data');
  });

 
  $(document).on('click', '.save', function(e){
    e.preventDefault();
    $('body').waitMe();

    var form = $('#addFrenchise')[0];

    var data = new FormData(form);
    $(".error").html("");
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:'post',
      data: $('#addFrenchise').serializeArray(),
      success: function(data){
        $.ajax({
          url:$('#select-city').data('url'),
          data:$('#addFrenchise').serializeArray(),
          type:'get',
          success: function(data){
            $('#dataList').html(data);
            $('body').waitMe('hide');
          }
        })
        success(data.message);
      },
      error: function(data){
        $('body').waitMe('hide');
        if (data.status==422) {
          var errors = data.responseJSON;
          for (var key in errors.errors) {
              if (key=="operator" || key=="bsp"|| key=="service" || key=="city") {
                  $("#"+key+"_error").html(errors.errors[key][0])
              }
              else if(key.includes('parameter')){
                $("#parameter_error").html(errors.errors[key][0])
              }
              else if(key.includes('price')){
                $("#price_error").html(errors.errors[key][0])
              }
              else if(key.includes('quantity')){
                $("#quantity_error").html(errors.errors[key][0])
              }
            }
        }else{
          error();
        }
      }
    })
  })
})
</script>
@endpush
