@extends('store.layouts.app')
@section('title', 'Manage Runner')
@section('content')

<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
    <vs-card>
      <div slot="header">
        <h3>
          Runner Details
        </h3>
      </div>
      <div>

        <vs-row vs-justify="flex-end">
         
          <a href="{{route('manage-runner.create')}}">
            <vs-button type="gradient" color="danger">Add New Runner</vs-button>
          </a>
         </vs-row>
           <br>
            <!-- <vs-row  > -->
                {{ Form::open(['method' => 'get', 'id' => 'store-search', 'name' => 'serach_form']) }}
              <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="5">
                  {{ Form::text('search', '', ['class' => 'form-control', 'placeholder' => 'Search by Name or E-mail or Phone', 'maxlength'=>'50']) }}
                </vs-col>

                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="2">                  
                 {{ Form::select('sort_type', ['' => 'Select Status', '1' => 'Active', '0' => 'Inactive'], null, ['class' => 'form-control', 'id' => 'sort_type']) }}
                </vs-col>
                
                <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="1">
                  <vs-button type="gradient" color="success" id="search-button">Filter</vs-button>

                </vs-col>
                 <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="1">
                  <vs-button type="gradient" color="danger"id="reset-button" >Reset</vs-button>
                </vs-col>
              {{ Form::close() }}

            <!-- </vs-row> -->
            <br>
            <br>
              <div id="dataList">
                
               
               @include('store.manage-runner.list')
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
         <h4 class="modal-title">Runner Details</h4>
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
<script src="{{asset('js/bootbox.js')}}"></script>
<script>
$(document).ready(function(){
  var current_page = $(".pagination").find('.active').text();
  $(document).on('click', '#delete', function(e){
    e.preventDefault();
          bootbox.confirm({
          title: "Confirm",
          message: "Do you want to delete the Runner? This cannot be undone.",
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

  $(document).on('click', '.view', function(e){
    e.preventDefault();
    $('body').waitMe();
    current = $(this);
    
    $.ajax({
      url: current.attr('href'),
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