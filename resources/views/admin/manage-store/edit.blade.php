@extends('layouts.app')
@section('title', 'Manage Store')

@section('content')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
@endsection


<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
        <!-- <form action="{{route('manage-store.update', $id)}}" method="put"  id="addFrenchise"> -->


      {{ Form::model($user, ['route'=> array('manage-store.update', $id) , 'method'=>'put', 'id'=>'addFrenchise',
                              'images'=>true]) }}

        @include('admin.manage-store.form')

      {{Form::close()}}
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
        <h4 class="modal-title">Add Address</h4>
      </div>
      <div class="modal-body">
        <div id="addressForm"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_new_address">Add Address</button>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script>
$(document).ready(function(){

  
  $('#collapseTwo, #collapseThree, #collapseFour, #collapseFive , #collapseSix').addClass('show');
  $('.1, .2, .3, .4, .5, .6').prop('disabled', false);

	$('#parent').chosen();

  if ($('#leased_property_type').attr("checked") == 'checked') {
    $(".lease_data").show()
  }
  $('input[type=radio][name=property_type]').change(function() {
    if (this.value == 1) {
        $(".lease_data").show()
    }
    else if (this.value == 2) {
         $(".lease_data").hide()
    }
  });

  $(".next").hide();
  $(document).on('click', '#add_address', function(e){
    e.preventDefault();
    $('body').waitMe();
    $.ajax({
      url: $('#add_address').attr('data-url'),
      type:'get',
      dataType:'html',
      success: function(data){
        $('#addressForm').html(data);
        $('body').waitMe('hide');
        $('#addressModal').modal('show');
        //$("#pinchange").chosen();
      },
      error:function(){

      }
    })
  })

  $(document).on('click', '#add_new_address', function(e){
    e.preventDefault();
    $('body').waitMe();
    $(".error").html("")
    $.ajax({
      url: $('#formAddress').attr('action'),
      type:'post',
      data: $('#formAddress').serializeArray(),
      dataType:'json',
      success: function(data){
        success("New Address Added!");
        $('#addressModal').modal('hide');

        $('body').waitMe('hide');
        window.location.reload();
      }
    })
  })

  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();

    var form = $('#addFrenchise')[0];

    var data = new FormData(form);

    console.log(data.values())
    $(".error").html("");
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:'post',
      data: data,
      cache: false,
      processData: false,  
      contentType: false,      
      success: function(data){
        success(data.message);
        window.location=data.redirectTo;
        $('body').waitMe('hide');
      }
    })
  })

  $('#addressModal').on('shown.bs.modal', function(){
    $("#pinchange").chosen();
  });

  $(document).on('change', '#pinchange', function(e){
    e.preventDefault();
    $.ajax({
      url: $('#pinchange').attr('data-url'),
      type:'get',
      data:{'id': $('#pinchange').val()},
      dataType:'json',
      success: function(data){
        $('#state').val(data.state);
        $('#city').val(data.city);
        $('#location_id').val(data.location_id);
      },

    })
  })

})
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=2&libraries=places&callback=initMap"
        async defer></script> -->

@endpush
