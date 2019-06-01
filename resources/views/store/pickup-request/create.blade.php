@extends('store.layouts.app')
@section('title', 'Pickup Request')

@section('content')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jcf.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.css') }}">
  <!-- <style type="text/css">
    div[data-acc-content] { display: none;  }
  </style> -->
@endsection

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">

<form action="{{route('store-pickup-request.store')}}" method="post"  id="addFrenchise" enctype="multipart/form-data">
 <br>
  @csrf
  @include('store.pickup-request.form')

   <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3">
     </div>
     <div class="col-lg-3 col-md-3 col-sm-3">
      <a href="{{route('store-pickup-request.index')}}">
        <button type="button" class="btn btn-default" data-url="{{route('pickup-request.index')}}">Cancel</button>
      </a>
      </div>
     <div class="col-lg-5 col-md-5 col-sm-5">
       <a href="{{route('store-pickup-request.store')}}" id="add_frenchise">
          
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
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Add Address</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="addressForm">
             @include('store.addAddressForm')
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_new_address">Save</button>
      </div>
    </div>

  </div>
</div>

<div id="selectAddressModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Select Address</h4>

         <button type="button" class="btn btn-warning" id="add_address"><i class="fa fa-plus"></i> </button>
      </div>
      <div class="modal-body">
        <div id="selectAddressForm">
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select_new_address">Save</button>
      </div>
    </div>

  </div>
</div>

@endsection

@push('js')
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.datetimepicker.js')}}"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
 
  
$(document).ready(function(){

  $('#service').chosen();
  $("#picker").flatpickr({enableTime: true,
    defaultDate:moment(),
    minDate:moment().add(3, 'hours').format("YYYY-MM-DD HH:mm:ss")});

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
          
            $('#name').val(data.customer['name']).prop('readonly', true);
            $('#email').val(data.customer['email']).prop('readonly', true);
            $('#phone_number').val(data.customer['phone_number']).prop('readonly', true);

            $('#address_form').text(data.customer.address);
            $("#customer_id").val(data.customer.id);
            $("#address_id").val(data.customer.address_id);

            $(".select").show();
            $(".add").hide();
        }
        if (data.address) {
          $('#address_form').text(data.address.address);
           $("#address_id").val(data.address.id);

        }
        $('body').waitMe('hide');
      },
      error: function(data){
            error(data.responseJSON.message);
            $(".select").hide();
            $(".add").show();
            $('#name').val('').prop('readonly', false);
            $('#email').val('').prop('readonly', false);
            $('#phone_number').val('').prop('readonly', false);
            $('#address_form').text('');
            $("#customer_id").val("");
            $("#address_id").val("");
             $('body').waitMe('hide');
      }
    })
  })

   $(document).on("click", "#add_address", function(e){
      e.preventDefault();
      $("#selectAddressModal").modal('hide');
      $('#addressModal').modal('show');
      //$('#formAddress')[0].reset();
    })

   $(document).on("click", "#select_address", function(e){
      e.preventDefault();
      current = $(this);

       $.ajax({
        url: current.data('url'),
        type:'get',
        data: {'user_id' : $('#customer_id').val()},     
        success: function(data){
          $('#selectAddressForm').html(data.view);
          $("#selectAddressModal").modal('show');
          $('body').waitMe('hide');
        }
    })
    })

   $(document).on("click", ".address", function(e){
      e.preventDefault();
      current = $(this);

      $('#address_id').val(current.data('id'));

      $('#address_form').text(current.data('value'));

       $("#selectAddressModal").modal('hide');
    })

   $(document).on("click", "#add_new_address", function(e){
    e.preventDefault();
    var form = $('#formAddress')[0];
    var data = new FormData(form);
    data.append('user_id', $('#customer_id').val());
    
    $(".error").html("");    
    $.ajax({
      url: $('#formAddress').attr('action'),
      type:'post',
      data: data,
      cache: false,
      processData: false,  
      contentType: false,      
      success: function(data){
        success(data.message);
        if (data.data) 
        {
          for (var key in data.data) {
              $("#"+key+'_form').text(data.data[key]);
          }
        }
        $('#address_id').val(data.data.address_id);
        $("#addressModal").modal('hide');
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
        window.location=data.redirectTo;
        $('body').waitMe('hide');
      }
    })
  })
})
var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {    
    zoom: 8
  });
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var marker = new google.maps.Marker({
            position: pos,
            map: map,
            draggable:true,
          });

        map.setCenter(pos);
        google.maps.event.addListener(marker, 'dragend', function (evt) {
           geocodePosition(marker.getPosition());
        });
      });


  }
  function geocodePosition(pos) 
  {
     geocoder = new google.maps.Geocoder();
     geocoder.geocode
      ({
          latLng: pos
      }, 
      function(results, status) 
      {
          if (status == google.maps.GeocoderStatus.OK) 
          {

              $('#address').val(results[0].formatted_address);
              if (results[0].address_components[2]) 
              {
                $('#city').val(results[0].address_components[2].long_name);
              }
               if (results[0].address_components[4]) {
                $('#state').val(results[0].address_components[4].long_name);
               }
               address = results[0].address_components;
               zipcode = address[address.length - 1].long_name;
               $('#pin').val(zipcode);
              $('#latitude').val(results[0].geometry.location.lat());
              $('#longitude').val(results[0].geometry.location.lng());
          } 
          else 
          {
              console.log('Cannot determine address at this location.'+status);
          }
      }
      );
  }
}
$('#addressModal').on('shown.bs.modal', function () {
    data = google.maps.event.trigger(map, "resize");
  });

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('MAPS_EMBED_KEY')}}&libraries=places&callback=initMap"
        async defer></script>
@endpush