@extends('layouts.app')
@section('title', 'Manage Franchise')

@section('content')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
@endsection


<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
            <br>
            {{Form::open(['route'=>'admin-manage-plans.store', "id"=>"addFrenchise"])}}
              @include('admin.manage-plans.form')
            {{Form::close()}}
             <div class="form-group-inner">
               <div class="row">
                 <div class="col-lg-3 col-md-3 col-sm-3">
                </div>
                 <div class="col-lg-3 col-md-3 col-sm-3">
                  <a href="{{route('admin-manage-plans.index')}}"> <button type="button" class="btn">Cancel</button> </a>
                 </div>
                 <div class="col-lg-5 col-md-5 col-sm-5">
                   <button type="submit" class="btn btn-primary" id="add_frenchise" >Add Plans</button>
                 </div>
                </div>
              </div>

            </div>
          </div>
          <br>
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
        <button type="button" class="btn btn-primary" id="add_new_address">Save</button>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
  <script src="https://cdn.ckeditor.com/4.12.0/basic/ckeditor.js"></script>
<script>
// CKEDITOR.replace('description', {
//   height: 150
// });
$(document).ready(function(){
  //$("#address_select").chosen();
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
      
    })
  })

  $(document).on('click', '#edit_address', function(e){
    e.preventDefault();
    $('body').waitMe();
    $.ajax({
      url: $('#edit_address').attr('data-url'),
      type:'get',
      dataType:'html',
      success: function(data){
        $('#addressForm').html(data);
        $('body').waitMe('hide');
        $('#addressModal').modal('show');
      },
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
        success(data.message);
        $('#formAddress')[0].reset();
        $('#addressModal').modal('hide');
        $('#add_address').hide();

        $('#added_address').html(data.address.address+', '+data.address.city+', '+data.address.state+', '+data.address.pin);
        $("#address_id").val(data.address.id);
        $('#edit_address').attr('data-url', data.url);
        $('#edit_address').show();
        $('body').waitMe('hide');

      }
    })
  })

  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();
    $(".error").html("")
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:'post',
      data: $('#addFrenchise').serializeArray(),
      dataType:'json',
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
