@extends('store.layout-new.app')
@section('title', 'Manage Runner')

@section('content')


<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
    <div slot="header">
        <h3>
          Edit Runner
        </h3>
      </div>
      <div>

        <vs-row vs-justify="center">
         <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">

           <a href="{{route('manage-runner.index')}}">
              <vs-button color="danger" type="border" icon="arrow_back"></vs-button>
            </a>
            <br>

       {{ Form::model($user, ['route'=> array('manage-runner.update', $id) , 'method'=>'put', 'id'=>'addFrenchise', 'images'=>true]) }}
            @include('store.manage-runner.form')

              <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <!-- <div class="col-lg-3 col-md-3 col-sm-3">
                <a href="{{route('manage-runner.index')}}">
                  <button type="button" class="btn btn-default" data-id="5" data-url="{{route('manage-runner.index')}}">Cancel</button>
                </a>
                </div> -->
               <div class="col-lg-5 col-md-5 col-sm-5">
                  <button type="button" class="btn btn-warning" id="add_frenchise" data-url="{{route('manage-runner.update', $id )}}">Edit</button>
               </div>
              </div>
            {{Form::close()}}
       
      </vs-col>
    <br>
    </vs-row>
    </div>
  </vs-col>
</vs-row>

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
                $('#city').val(results[0].city);
                $('#state').val(results[0].state);
                $('#pin').val(results[0].zip);
                $('#latitude').val(results[0].latitude);
                $('#longitude').val(results[0].longitude);
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
