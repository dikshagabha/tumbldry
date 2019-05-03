@extends('layouts.app')
@section('title', 'Manage Store')

@section('content')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jcf.css') }}">
  <!-- <style type="text/css">
    div[data-acc-content] { display: none;  }
  </style> -->
@endsection

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">

<form action="{{route('pickup-request.store')}}" method="post"  id="addFrenchise" enctype="multipart/form-data">
 <br>
  @csrf
  @include('admin.pickup-request.form')

   <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3">
     </div>
     <div class="col-lg-3 col-md-3 col-sm-3">
      <a href="{{route('pickup-request.index')}}">
        <button type="button" class="btn btn-default" data-url="{{route('pickup-request.index')}}">Cancel</button>
      </a>
      </div>
     <div class="col-lg-5 col-md-5 col-sm-5">
       <a href="{{route('pickup-request.store')}}" id="add_frenchise">
          
          <button type="submit" class="btn btn-success">Save</button>
       </a>
     </div>
    </div>
</form>

</div>
  </div>

    </div>
  </div>
</div>

<div id="addressModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Address</h4>
      </div>
      <div class="modal-body">
        <div id="addressForm">
          <form action="{{route('admin.postAddAddress')}}" method="post" class="addressForm" id="formAddress">
            
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_new_address">Save</button>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>

<script>
$(document).ready(function(){

  //jcf.replaceAll();
	$('#service').chosen();

  

  $('input[type=radio][name=property_type]').change(function() {
    if (this.value == 1) {
        $(".lease_data").show()
    }
    else if (this.value == 2) {
         $(".lease_data").hide()
    }
});

  $(document).on('click', '#search-user', function(e){
    e.preventDefault(); 
    $(".error").html("")
    $('body').waitMe(); 
    
    $.ajax({
      url: $('#search-user').data('url'),
      type:'post',
      data: {'phone_number':$('#phone').val()},
      success: function(data){
        success(data.message);
        if (data.customer) 
        {
          for (var key in data.customer) {
              $("#"+key).val(data.customer[key]);
              $("#"+key).prop('readonly', true);
            }
            $("#customer_id").val(data.customer.id);
            $("#address_id").val(data.customer.address_id);
        }
        else{
          
           $("#name").val("").prop('readonly', false);
           $("#address").val("").prop('readonly', false); 
            $("#city").val("").prop('readonly', false);
           $("#state").val("").prop('readonly', false);
            $("#pin").val("").prop('readonly', false);
           $("#email").val("").prop('readonly', false);
            $("#latitude").val("").prop('readonly', false);
           $("#longitude").val("").prop('readonly', false);
           $("#landmark").val("").prop('readonly', false);

        }
        $('body').waitMe('hide');
      }

    })
  })
 
  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();

    var data = $('#addFrenchise').serializeArray();
    //var data = new FormData(form);
   
    $(".error").html("");
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:'post',
      data: data,    
      success: function(data){
        success(data.message);
        //window.location=data.redirectTo;
        $('body').waitMe('hide');
      }
    })
  })
})
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=2&libraries=places&callback=initMap"
        async defer></script> -->

@endpush
