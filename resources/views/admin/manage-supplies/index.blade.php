@extends('layouts.app')
@section('title', 'Manage Supplies')
@section('content')

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
          <div class="row">
            <div class="col-md-9">
            </div>
            <div class="col-md-3">
              <button class="btn btn-danger new_supply">Add New Supply</button>
            </div>
          </div>
            <br>
             <div class="">
                {{ Form::open(['method' => 'get', 'id' => 'store-search', 'name' => 'serach_form']) }}
                <div class="form-group-inner">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                      </div>
                         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          {{ Form::text('search', '', ['class' => 'form-control', 'placeholder' => 'Search by Name', 'maxlength'=>'50']) }}
                         </div>
                         
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          <button type="submit" id="search-button" class="btn btn-success margin-bottom-20">Filter</button>
                        <button type="submit" id="reset-button" class="btn btn-danger margin-bottom-20">Reset</button>
                         </div>
                       </div>
                  </div>
                  {{ Form::close() }}
              </div>
            <br>
              <div id="dataList">
                
               @include('admin.manage-supplies.list')
              </div>
            </div>

          <!-- </div> -->
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
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
         {{Form::open(['route'=>'manage-supplies.store', "id"=>"addFrenchise", 'method'=>'post'])}}

              <div class="form-group-inner">
              <div class="row">
                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                   <label class="login2 pull-right pull-right-pro">Name</label>
                 </div>
                 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                  {!! Form::text('name',null,array('class' => 'form-control', "maxlength"=>20,
                                  "id"=>'name',  "placeholder"=>"Name")) !!}
                  <span class="error" id="name_error"></span>
                 </div>               
              </div>
            </div>
            {{Form::close()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_frenchise">Save</button>
      </div>
    </div>

  </div>
</div>

@endsection
@push('js')
<script src="{{asset('js/bootbox.js')}}"></script>
<script>
$(document).ready(function(){

  $(document).on('click', '#delete', function(e){
    e.preventDefault();
          bootbox.confirm({
          title: "Confirm",
          message: "Do you want to delete the Supply? This cannot be undone.",
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
                  },
                })
              }
          }
      });

  })
  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();
    $(".error").html("")
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:$('#addFrenchise').attr('method'),
      data: $('#addFrenchise').serializeArray(),
      dataType:'json',
      success: function(data){
        success(data.message);
        var current_page = 1;
          // reload the list
          $('#addressModal').modal('hide');
          load_listings(location.href, 'serach_form');
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('body').waitMe();
    $(".error").html("")
    current = $(this);
    $.ajax({
      url: current.attr('href'),
      type:'get',
      
      success: function(data){
        //success(data.message);
        //var current_page = 1;
        $("#name").val(data.name);
        $('#addFrenchise').attr('action', data.url)
        $('#addFrenchise').attr('method', "put")
        $('#addressModal').modal('show');
        $('body').waitMe('hide');
      }
    })
  })
 $(document).on("click",".new_supply",function(e) {
    e.preventDefault();
    $('#addressModal').modal('show');
  });
// Ajax base Pagination
  $(document).on("click",".pagination li a",function(e) {
    e.preventDefault();
    load_listings($(this).attr('href'));
  });

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

  // Search by name
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

})
</script>
@endpush
