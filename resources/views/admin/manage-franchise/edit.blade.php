@extends('admin.layout.app')
@section('title', 'Manage Frenchise')

@section('content')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
@endsection
<br>
<form action="{{route('manage-frenchise.update', $id)}}" method="put"  id="addFrenchise">
  @csrf
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
  <div class="all-form-element-inner">
    <div class="form-group-inner">
      <div class="row">
           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
             <label class="login2 pull-right pull-right-pro">Name</label>
           </div>
           <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
             <input type="text" class="form-control" name="store_name"  value="{{$user->store_name}}"/>
             <span class="error" id="store_name_error"></span>
           </div>
         </div>
       </div>

     <div class="form-group-inner">
       <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <label class="login2 pull-right pull-right-pro">Address</label>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-10">
              <select name="address_id" class="form-control" id="address_select">
                @foreach($address as $add)
                  <option value="{{$add->id}}" @if($add->id==$user->address->first()['address_id']) selected @endif>
                    {{$add->address}}, {{$add->state}},  {{$add->city}}, {{$add->pin}}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <button type="button" class="btn btn-primary" id="add_address" data-url="{{route('admin.addAddress')}}">Add Address</button>
            </div>
          </div>
        </div>

        <div class="form-group-inner">
          <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label class="login2 pull-right pull-right-pro">Contact Person:</label>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-10">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5">
                    <label class="login2 pull-right pull-right-pro">Name</label>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" class="form-control" name="name" maxlength="50" value="{{$user->name}}"/>
                    <span class="error" id="name_error"></span>
                  </div>
              </div>           
            </div>
        </div>
        <div class="form-group-inner">
          <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label class="login2 pull-right pull-right-pro"></label>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-10">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5">
                    <label class="login2 pull-right pull-right-pro">Email</label>
                    
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" class="form-control" name="email" maxlength="50"  value="{{$user->email}}"/>
                    <span class="error" id="email_error"></span>
                  </div>
              </div>           
            </div>
        </div>
        <div class="form-group-inner">
          <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label class="login2 pull-right pull-right-pro"></label>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-10">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5">
                    <label class="login2 pull-right pull-right-pro">Phone Number</label>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" class="form-control" name="phone_number"  maxlength="15" value="{{$user->phone_number}}"/>
                    <span class="error" id="phone_number_error"></span>
                  </div>
              </div>           
            </div>
        </div>

         <div class="form-group-inner">
           <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-3">
            </div>
             <div class="col-lg-3 col-md-3 col-sm-3">
              <a href="{{route('manage-frenchise.index')}}"> <button type="button" class="btn">Cancel</button> </a>
             </div>
             <div class="col-lg-5 col-md-5 col-sm-5">
               <button type="submit" class="btn btn-primary" id="add_frenchise" >Edit Frenchise</button>
             </div>
            </div>
          </div>
      </div>
   </div>
</form>

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

@section('js')
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script>
$(document).ready(function(){
  $("#address_select").chosen();
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
    $(".error").html("")
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type: $('#addFrenchise').attr('method'),
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

@endsection
