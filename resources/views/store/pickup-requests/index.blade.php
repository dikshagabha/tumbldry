@extends('store.layouts.app')
@section('title', 'Manage Pickup Requests')
@section("css")
<link rel="stylesheet" type="text/css" href="{{asset('css/chosen/bootstrap-chosen.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/jcf.css')}}">
@endsection
@section('content')


<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
    <vs-card>
      <div slot="header">
        <h3>
          Pickup Requests
        </h3>
      </div>
      <div>

        <vs-row vs-justify="flex-end">
         
         
         </vs-row>
           <br>
              <div id="dataList">
                
               
               @include('store.pickup-requests.list')
              </div>
        
      </div>
      <div slot="footer">
        
      </div>
    </vs-card>
  </vs-col>
</vs-row>


<div id="addressModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Customer Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
      <div class="modal-body">
        <div id="details">
         
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="OrderModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
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
@endsection

@push('js')

<script src="{{asset('js/jcf/jcf.js')}}"></script>
<script src="{{asset('js/jcf/jcf.select.js')}}"></script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script>
$(document).ready(function(){
  //$('.runner_select').chosen();
 

  var current_page = $(".pagination").find('.active').text(); 
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

  $(document).on("change",".runner_select",function(e) {
      e.preventDefault();
      
      current = $(this);
      console.log(current.val());
      if (current.val() ) 
      {
        $('body').waitMe();
        $.ajax({
              url: current.attr('href'),
              data:{ 'assigned_to':current.val(), 'id':current.data('id') },
              type:"post",
              success: function(data){
                $('body').waitMe("hide");      
                success(data.message);          
                //$('.runner_select').trigger("chosen:updated");
                //$('.runner_select').chosen("destroy").chosen();
                var current_page = $(".pagination").find('.active').text();
                load_listings(location.href+'?page='+current_page, 'serach_form');
                //window.location.reload()
              },
            })
      }     
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

  $(document).on('click', '#getCustomer, #getAddress', function(e){
    e.preventDefault();
    $('body').waitMe();
    url = $(this).attr('href');
    $.ajax({
      url: url,
      type:"get",
      success: function(data){
        $('body').waitMe("hide");        
        $('#details').html(data);
        $("#addressModal").modal('show');
      },
    })
  })

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


})
</script>

@endpush