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

<form action="{{route('manage-store.store')}}" method="post"  id="addFrenchise" enctype="multipart/form-data">
 
  @csrf
  @include('admin.manage-store.form')

   <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3">
     </div>
     <div class="col-lg-3 col-md-3 col-sm-3">
      <a href="{{route('manage-store.index')}}">
        <button type="button" class="btn btn-default" data-id="5" data-url="{{route('admin.store.add', 5)}}">Cancel</button>
      </a>
      </div>
     <div class="col-lg-5 col-md-5 col-sm-5">
       
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
<script src="{{asset('js/jquery.accordion-wizard.min.js')}}"></script>

<script src="{{asset('js/jquery.mask.js')}}"></script>

<script src="{{asset('js/jcf/jcf.js')}}"></script>
<script src="{{asset('js/jcf/jcf.radio.js')}}"></script>
<script src="{{asset('js/jcf/jcf.file.js')}}"></script>

<script>
$(document).ready(function(){

  jcf.replaceAll();
	$('#parent').chosen();
  function sendRequest(url, current){
    var form = $('#addFrenchise')[0];

    var data = new FormData(form);

    $.ajax({
      url: url,
      type:'post',
      data: data,
      enctype: 'multipart/form-data',
      processData: false,  // Important!
      contentType: false,
      
      success: function(data){       
        $('.'+(current.data('id')+1)).prop("disabled", false);
        $('.'+(current.data('id')+1)).trigger('click');
         $('body').waitMe('hide');
         current.hide();
        }  
      })   
  }

  $('input[type=radio][name=property_type]').change(function() {
    if (this.value == 1) {
        $(".lease_data").show()
    }
    else if (this.value == 2) {
         $(".lease_data").hide()
    }
});

  $(document).on('click', '.next', function(e){
    e.preventDefault(); 
    $(".error").html("")
    $('body').waitMe(); 
    sendRequest($(this).data('url'), $(this));
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
})
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=2&libraries=places&callback=initMap"
        async defer></script> -->

@endpush
