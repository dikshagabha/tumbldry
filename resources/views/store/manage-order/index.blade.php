@extends('store.layout-new.app')
@section('title', 'Manage Store')

@section('css')

<link rel="stylesheet" type="text/css" href=" https://printjs-4de6.kxcdn.com/print.min.css">
@endsection
@section('content')
<div id="OrderModal" class="modal in" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Order Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
      <div class="modal-body">
        <div id="Orderdetails">
         
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="DeliverModal" class="modal in" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Select Runner</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="assignRunner">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success assign_runner" data-dismiss="modal" >Assign</button>
      </div>
    </div>
  </div>
</div>
<div id="selectGrnModal" class="modal in" role="dialog">
  <div class="modal-dialog modal-lg">    
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Order Items</h4>
      </div>
      <div class="modal-body">
        <div id="printGrnForm">
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div>
  <div class="col-md-3 pull-right">
    <a href="{{route('store.orderWithoutPickup')}}">
      <button type="button" class="btn btn-danger">Create Order</button>
    </a>
   </div>
   <br>
  <div id="dataList">
   @include('store.manage-order.list')
  </div>
</div>


@endsection
@push('js')
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script>
$(document).ready(function(){
  var current_page = $(".pagination").find('.active').text();
  $(document).on('click', '#delete', function(e){
    e.preventDefault();
          bootbox.confirm({
          title: "Confirm",
          message: "Do you want to delete the store? This cannot be undone.",
          buttons: {
              cancel: {
                  label: '<i class="fa fa-times"></i> Cancel'
              },
              confirm: {
                  label: '<i class="fa fa-check"></i> Confirm'
              }
          },
          callback: function (result) {
              if(result){
                $('body').waitMe();
                //console.log($('#dataList tr').length)
                

                $.ajax({
                  url: $('#delete').attr('href'),
                  type:"post",
                  data:{
                    '_method':"delete", '_token':$('#delete').data('token')
                  },
                  headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
                    'method':'delete'
                  },
                  success: function(){
                    $('body').waitMe("hide");
                    if($('#dataList tr').length<=2)
                    {
                    var current_page = $(".pagination").find('.active').text()-1;
                    
                    load_listings(location.href+'?page='+current_page);
                    }

                    else
                    {
                    
                    var current_page = $(".pagination").find('.active').text();
                    load_listings(location.href+'?page='+current_page, 'serach_form');
                    }
                    //window.location.reload()
                  },
                })
              }
          }
      });
  })

  $(document).on("click", ".print_grn", function(e){
      e.preventDefault();
      //alert();
      $(".error").html(""); 
      current = $(this);   
      
      $.ajax({
        url: current.attr('href'),
        type:'get',
        //data: $('#addonForm'+current.data('id')+' :input').serializeArray(),
        cache: false,
        success: function(data){
          $("#printGrnForm").html(data.view);
          $("#selectGrnModal").modal('show');
        }
      })
    })

  $(document).on("click","#reset-button",function(e) {
      e.preventDefault();
      $('body').waitMe();
      //$('#export_csv').removeClass('apply_filter');
      // Reset Search Form fields
      $('#store-search')[0].reset();
      //check current active page
      var current_page = 1;
      // reload the list
      load_listings(location.href+'?page='+current_page);
      //stopLoader("body");
    });
  
  $(document).on("click","#search-button",function(e) {
      e.preventDefault();
      $('body').waitMe();
      //$('#export_csv').addClass('apply_filter');
      //check current active page
      var current_page = $(".pagination").find('.active').text();
      // reload the list
      load_listings(location.href, 'serach_form');
      //stopLoader("body");
    });

  $(document).on('click', '.status', function(e){
    e.preventDefault();
    current = $(this);
    if (current.data('status')==1) 
    {
      message = "Are you sure you want to activate this user?"
    }
    else{
      message = "Are you sure you want to deactivate this user?"
    }
          bootbox.confirm({
          title: "Confirm",
          message: message,
          buttons: {
              cancel: {
                  label: '<i class="fa fa-times"></i> Cancel'
              },
              confirm: {
                  label: '<i class="fa fa-check"></i> Confirm'
              }
          },
          callback: function (result) {
              if(result){
                $('body').waitMe();


                $.ajax({
                  url: current.attr('href'),
                  type:"post",
                  data:{
                    'status':current.data('status')
                  },
                  success: function(){
                    $('body').waitMe("hide");
                    
                    var current_page = $(".pagination").find('.active').text();
                    console.log(location.href+'?page='+current_page);
                    load_listings(location.href+'?page='+current_page, 'serach_form');
                    //window.location.reload()
                  },
                })
              }
          }
      });
  })
  
  $(document).on("click",".pagination li a",function(e) {
    e.preventDefault();
    load_listings($(this).attr('href'));
  });

  $(document).on("click",".view",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)
      $.ajax({
        url:current.attr('href'),
        method:'get',
        success:function(data){
          $('#Orderdetails').html(data);
           $('body').waitMe('hide');
          $("#OrderModal").modal('show');
        }
      })
    });

  $(document).on("change",".change_status",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this);
      console.log(current.val());
      if (current.val() != 4 && current.val() != 5)
      {
        $.ajax({
          url:current.data('url'),
          method:'post',
          data:{'status':current.val()},
          success:function(data){
            $('body').waitMe('hide');
            var current_page = $(".pagination").find('.active').text();
            load_listings(location.href+'?page='+current_page, 'serach_form');
            success(data.message);
          }
        })
      }else{
            $('body').waitMe('hide');
            current.next( ".add_runner" ).show();
          }
        
        
    });

  $(document).on("click",".deliver",function(e) {
      e.preventDefault();
      //alert();
      $('body').waitMe();
      current = $(this);
      $.ajax({
          url:current.attr('href'),
          method:'get',
          success:function(data){
            $('body').waitMe('hide');
            $('#assignRunner').html(data.view);
            $("#DeliverModal").modal('show');
     
          }
      })
    });

  $(document).on("click",".assign_runner",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)
      $.ajax({
        url:$('#deliveryForm').attr('action'),
        method:'post',        
        data:$('#deliveryForm').serializeArray(),
        success:function(data){
          var current_page = $(".pagination").find('.active').text();
          load_listings(location.href+'?page='+current_page, 'serach_form');
          success(data.message);
          $('body').waitMe('hide');
        }
      })
    });

    $(document).on("click",".print_invoice",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)
      $.ajax({
        url: current.attr('href'),
        method:'get',
        xhrFields: {
                responseType: 'blob'
            },
        success:function(data){

          var current_page = $(".pagination").find('.active').text();
          load_listings(location.href+'?page='+current_page, 'serach_form');
          
          var pdfFile = new Blob([data], {
            type: "application/pdf"
            });
            var pdfUrl = URL.createObjectURL(pdfFile);
              printJS(pdfUrl);
             $('body').waitMe('hide');
        }
      })
    });

  $(document).on("click","#grnBtn",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)
      $.ajax({
        url:current.data('url'),
        method:'post',
         //xhrFields is what did the trick to read the blob to pdf
            xhrFields: {
                responseType: 'blob'
            },
        data: $('#grnForm :input').serializeArray(),
        success:function(data){
          $('body').waitMe('hide');

          var pdfFile = new Blob([data], {
            type: "application/pdf"
            });
            var current_page = $(".pagination").find('.active').text();
            load_listings(location.href+'?page='+current_page, 'serach_form');
            var pdfUrl = URL.createObjectURL(pdfFile);
            //window.open(pdfUrl);
            printJS(pdfUrl);
        }
      })
    });

  $(document).on("click","#deliverBtn",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)
      $.ajax({
        url:current.data('url'),
        method:'post',
        data: $('#grnForm :input').serializeArray(),
        success:function(data){
          $('body').waitMe('hide');
          var current_page = $(".pagination").find('.active').text();
          console.log(location.href+'?page='+current_page);
          load_listings(location.href+'?page='+current_page, 'serach_form');
          success(data.message);
        }
      })
    });

  $(document).on("change",".selectVendor",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)
      $.ajax({
        url:current.data('url'),
        method:'post',
        data: {'order_id': current.data('order'), 'item_id': current.data('item'),
                'vendor_id': current.val(), 'service_id':current.data('service')},
        success:function(data){
          $('body').waitMe('hide');
          var current_page = $(".pagination").find('.active').text();
          load_listings(location.href+'?page='+current_page, 'serach_form');
          //$("#OrderModal").modal('hide');
          success(data.message);
        }
      })
    });

  $(document).on('click', '.select_all', function(e){
    //e.preventDefault();

    if ($(this).prop('checked')) {
      $(".grn_units").prop("checked", true); 
    }else{
      $(".grn_units").prop("checked", false);
    }
  })

  $(document).on('click', '.select_all_deliver', function(e){
    //e.preventDefault();

    if ($(this).prop('checked')) {
      $(".deliver_units").prop("checked", true); 
    }else{
      $(".deliver_units").prop("checked", false);
    }
  })

  $(document).on("click", ".mark_status", function(e){
    e.preventDefault();
    $(".error").html(""); 
    current = $(this);
    $("#OrderModal").modal('hide');
    text = 'pending';
    if (current.attr('value')==1) {
        text = 'recieved';
    }

    bootbox.confirm({
        title: "Confirm",
        message: "Mark order item as "+text+" ?",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
          if (result) {
            $.ajax({
              url: current.attr('href'),
              type:'post',
              data:{"status": current.attr('value'), "data":"dl;fdsf"},
              cache: false,
              success: function(data){
                success(data.message);
                var current_page = $(".pagination").find('.active').text();
                console.log(location.href+'?page='+current_page);
                load_listings(location.href+'?page='+current_page, 'serach_form');

                //$(".ItemsAdded").html(data.view);
                $('body').waitMe('hide');
              }
            })
          }
            
        }
      });
    })
})
</script>

@endpush