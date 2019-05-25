@extends('store.layouts.app')
@section('title', 'Manage Customer')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
            {{ Form::model($user, ['route'=> array('manage-customer.update', $id) , 'method'=>'put', 'id'=>'addFrenchise', 'images'=>true]) }}
            @include('store.manage-customer.form')
              
              <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                <a href="{{route('manage-runner.index')}}">
                  <button type="button" class="btn btn-default" data-id="5" data-url="{{route('manage-customer.index')}}">Cancel</button>
                </a>
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                  <button type="button" class="btn btn-warning" id="add_frenchise" data-url="{{route('manage-customer.update', $id )}}">Edit</button>
               </div>
              </div>
            {{Form::close()}}
        </div>
      </div>
    </div>
  </div>
</div>


<div id="addressModal" class="modal fade " role="dialog">
  <div class="modal-dialog  modal-lg">
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
        <button type="button" class="btn btn-primary" id="add_new_address" data-url="{{ route('store.addCustomerAddresses')}}">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function(){

  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();

    var form = $('#addFrenchise')[0];

    var data = new FormData(form);
    $(".error").html("");
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:'post',
      data: data,
      cache: false,
      processData: false,  
      contentType: false,      
      success: function(data){
        // /success(data.message);
        window.location=data.redirectTo;
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", "#add_address", function(e){
    e.preventDefault();
    $('#addressModal').modal('show');
  });
  $(document).on("click", "#add_new_address", function(e){
    e.preventDefault();
    var form = $('#formAddress')[0];
    var data = new FormData(form);

    $(".error").html("");    
    $.ajax({
      url: $('#add_new_address').data('url'),
      type:'post',
      data: data,
      cache: false,
      processData: false,  
      contentType: false,      
      success: function(data){
        success(data.message);
        
        $('#address_form').html(data.view);
        $("#addressModal").modal('hide');
        $('body').waitMe('hide');
      }
    })
  });
  $(document).on("click", ".deleteItemBtn", function(e){
    e.preventDefault();
    $(".error").html("");
    current = $(this);  
    console.log(current.data('url')); 
    $.ajax({
      url: current.data('url'),
      type:'post',
      data: {'data-id':current.data('id')},
      cache: false,
      success: function(data){
        success(data.message);
        $("#address_form").html(data.view);
        $('body').waitMe('hide');
      }
    })
  });
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

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('MAPS_EMBED_KEY')}}&libraries=places&callback=initMap"
        async defer></script>

@endpush
