@extends('store.layouts.app')
@section('title', 'Manage Pickup Requests')
@section('content')


<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
              <div class="row">
                <div class="col-md-9">
                </div>               
              </div>
              <br><br>
              <div id="dataList">                
               @include('store.pickup-requests.list')
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
@endsection
@push('js')

<script type="text/template">
  

</script>
<script src="{{asset('js/bootbox.js')}}"></script>
<script>
$(document).ready(function(){
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


})
</script>

@endpush