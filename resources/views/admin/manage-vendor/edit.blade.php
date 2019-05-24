@extends('layouts.app')
@section('title', 'Manage Vendor')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
            {{ Form::model($user, ['route'=> array('manage-vendor.update', $id) , 'method'=>'put', 'id'=>'addFrenchise', 'images'=>true]) }}
            @include('admin.manage-vendor.form')

              <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
                {{Form::hidden('address_id', $user->addresses->id)}}
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                <a href="{{route('manage-vendor.index')}}">
                  <button type="button" class="btn btn-default" data-id="5" data-url="{{route('manage-runner.index')}}">Cancel</button>
                </a>
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                  <button type="button" class="btn btn-warning" id="add_frenchise">Edit</button>
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
          @include('admin.addAddressForm')  
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_new_address">Save</button>
      </div>
    </div>

  </div>
</div>
<div id="ProvidersModal" class="modal fade " role="dialog">
  <div class="modal-dialog  modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Add Provider</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="providerForm">
          @include('admin.manage-vendor.addProviderForm')  
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_new_provider">Save</button>
      </div>
    </div>

  </div>
</div>

@endsection

@push('js')
<script>


var map; var map1;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {    
    zoom: 8
  });

  map1 = new google.maps.Map(document.getElementById('map_provider'), {    
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
        var marker1 = new google.maps.Marker({
            position: pos,
            map: map1,
            draggable:true,
          });
        map1.setCenter(pos); 
        map.setCenter(pos);
        google.maps.event.addListener(marker, 'dragend', function (evt) {
           geocodePosition(marker.getPosition());
        });

        google.maps.event.addListener(marker1, 'dragend', function (evt) {
           geocodePosition_1(marker.getPosition());
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
  function geocodePosition_1(pos) 
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
              $('#address_provider').val(results[0].formatted_address);
              if (results[0].address_components[2]) 
              {
                $('#city_provider').val(results[0].address_components[2].long_name);
              }
               if (results[0].address_components[4]) {
                $('#state_provider').val(results[0].address_components[4].long_name);
               }
               address = results[0].address_components;
               zipcode = address[address.length - 1].long_name;
               $('#pin_provider').val(zipcode);
              $('#latitude_provider').val(results[0].geometry.location.lat());
              $('#longitude_provider').val(results[0].geometry.location.lng());
          } 
          else 
          {
              console.log('Cannot determine address at this location.'+status);
          }
      }
      );
  }
}
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
      //$('#formAddress')[0].reset();
  })
  $(document).on("click", "#add_provider", function(e){
      e.preventDefault();
      $('#ProvidersModal').modal('show');
  })
  $(document).on("click", "#add_new_address", function(e){
    e.preventDefault();
    var form = $('#formAddress')[0];
    var data = new FormData(form);

    console.log($('#formAddress').attr('action'));
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
              $("#"+key+'_form').val(data.data[key]);
          }
        }

        $("#addressModal").modal('hide');
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", "#add_new_provider", function(e){
    e.preventDefault();
    var form = $('#formProvider')[0];
    var data = new FormData(form);

    console.log($('#formProvider').attr('action'));
    $(".error").html("");    
    $.ajax({
      url: $('#formProvider').attr('action'),
      type:'post',
      data: data,
      cache: false,
      processData: false,  
      contentType: false,      
      success: function(data){
        success(data.message);
        if (data.data) 
        {
          for(i=0;i<data.data.length;i++){
            console.log(data.data[i].name)
            $("#providers").append("<div class='badge badge-primary'>"+data.data[i].name+"</div>")
          }
        }

        $("#ProvidersModal").modal('hide');
        $('body').waitMe('hide');
      }
    })
  })
  $('#addressModal #ProvidersModal').on('shown.bs.modal', function () {
    data = google.maps.event.trigger(map, "resize");
  });
 $('#ProvidersModal').on('shown.bs.modal', function () {
    data = google.maps.event.trigger(map1, "resize");
  });

})

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('MAPS_EMBED_KEY')}}&libraries=places&callback=initMap"
        async defer></script>

@endpush
