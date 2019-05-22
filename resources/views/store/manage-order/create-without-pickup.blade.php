@extends('store.layouts.app')
@section('title', 'Create order')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.typeahead.min.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <style type="text/css">
    .table td {
   text-align: center;   
}
  

 </style>

@endsection

@section('content')


<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
            <div class="card-body">
          
              {{Form::open(['url'=> route('store.create-order'), "id"=>"addFrenchise"])}}
             
                  @csrf
                  @include('store.manage-order.form-without-pickup')

                 <div class="ItemsAdded">

                 </div>
               <br>
               <div class="row">
                 
                 <div class="col-lg-3 col-md-3 col-sm-3">
                  <a href="{{route('store.home')}}">
                    <button type="button" class="btn btn-default" data-id="5">Cancel</button>
                  </a>
                  </div>
                <!--  <div class="col-lg-7 col-md-7 col-sm-7">
                    <button type="button" class="btn btn-warning" id="add_frenchise">Create</button>
                 </div> -->
                </div>
            </form>
          </div>
        
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

@endsection

@push('js')
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.typeahead.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>

 
$(document).ready(function(){ 
  

  var path = "{{ route('store.get-items') }}";  
  // $.typeahead({
  //       input: '.js-typeahead-country_v1',
  //       source: {
  //         ajax:
  //         function (query) {
  //             data={'query':query};
  //             return {
  //                 url:  "{{route('store.get-items')}}",
  //                 data: data
  //             }
  //       }
  //     },
  //     mustSelectItem:true,
  //     callback:{
  //       // onSubmit: function(argument) {
  //       //   alert()
  //       // }
  //     }
  // });

  $( "#item" ).autocomplete({
      source: function( request, response ) {
          $.ajax({
              dataType: "json",
              type : 'Get',
              url: path,
              data:{'query': request.term , 'service':$('#service').val()},
              success: function(data) {
                  $('input.suggest-user').removeClass('ui-autocomplete-loading');  
                  // hide loading image

                  response(data);
              },
              error: function(data) {
                  $('input.suggest-user').removeClass('ui-autocomplete-loading');  
              }
          });
      },
      minLength: 2,
      open: function() {},
      close: function() {},
      focus: function(event,ui) {},
      select: function(event, ui) {}
  });

  $(document).on("click", ".addOn", function(e){
      e.preventDefault();
      $(".error").html(""); 
      current = $(this);   
      $.ajax({
        url: current.data('url'),
        type:'post',
        data: $('#addonForm'+current.data('id')+' :input').serializeArray(),
        cache: false,
        success: function(data){
          success(data.message);
          $(".ItemsAdded").html(data.view);
          $('body').waitMe('hide');
        }
      })
    })


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
                $("#"+key).text(data.customer[key]);
                $("#"+key).prop('readonly', true);
                console.log(key);
              }
              $("#customer_id").val(data.customer.id);
              $("#address_id").val(data.customer.address_id);
              if (data.wallet) {
                $("#wallet").text("User has "+data.wallet.price+" Rs in wallet.")
              }
              
          }
          else{
            
             $("#name").val("").prop('readonly', false);
             $("#phone").val("").prop('readonly', false);
             $("#customer_id").val("");
             $("#address_id").val("");
          }
          $('body').waitMe('hide');
        }

      })
    })

  
   $(document).on("click", "#add_address", function(e){
      e.preventDefault();
      $('#addressModal').modal('show');
      //$('#formAddress')[0].reset();
    })

 
  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();

    var data = $('#addFrenchise').serializeArray();
    //var data = new FormData(form);
    
    $(".error").html("");
    $.ajax({
      url: $('#addFrenchise').attr('url'),
      type:'post',
      data: data,    
      success: function(data){
        success(data.message);
        window.location = data.redirectTo;
        $('body').waitMe('hide');
      }
    })
  
  })

  $(document).on('click', '#add_item', function(e){
    e.preventDefault();
    $('body').waitMe();
    
    $.ajax({
      url:$("#add_item").attr('href'),
      data:{'service':$('#service').val(), 'item':$('#item').val()},
      type:'post',
      success:function(data) {
        $(".ItemsAdded").html(data.view);
      }
    })
    //$("#addressModal").modal('show');
    
    $('body').waitMe('hide');
  })

  $('#addressModal').on('shown.bs.modal', function (e) {
   
     //$('#service').trigger("chosen:updated");
    $('#formAddress')[0].reset();
  })

  // $(document).on("click", "#add_new_address", function(e){
  //   e.preventDefault();
  //   var form = $('#ItemForm')[0];
  //   var data = new FormData(form);
  //   $(".error").html("");    
  //   $.ajax({
  //     url: $('#ItemForm').attr('action'),
  //     type:'post',
  //     data: data,
  //     cache: false,
  //     processData: false,  
  //     contentType: false,      
  //     success: function(data){
  //       success(data.message);
  //       $(".ItemsAdded").html(data.view);
  //       $("#addressModal").modal('hide');
  //       $('body').waitMe('hide');
  //     }
  //   })
  // })

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
              $("#"+key).text(data.data[key]);
          }
        }

        $("#addressModal").modal('hide');
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", ".deleteItemBtn", function(e){
    e.preventDefault();
    $(".error").html(""); 
    current = $(this);   
    $.ajax({
      url: current.attr('action'),
      type:'post',
      data: {'data-id':current.data('id')},
      cache: false,
      success: function(data){
        success(data.message);
        $(".ItemsAdded").html(data.view);
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", ".quantity", function(e){
    e.preventDefault();
    $(".error").html(""); 
    current = $(this);   
    $.ajax({
      url: current.data('url'),
      type:'post',
      data: {'data-id': current.data('id'), 'quantity':$('.quantityVal_'+current.data('id')).val()},
      cache: false,
      success: function(data){
        success(data.message);
        $(".ItemsAdded").html(data.view);
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on("click", "#couponBtn", function(e){
    e.preventDefault();
    $(".error").html(""); 
    current = $(this);   
    $.ajax({
      url: current.data('url'),
      type:'post',
      data: {'coupon': $("#coupon").val()},
      cache: false,
      success: function(data){
        success(data.message);
        $(".ItemsAdded").html(data.view);
        $('body').waitMe('hide');
      }
    })
  })

  

});
</script>
@endpush
