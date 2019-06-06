@extends('store.layouts.app')
@section('title', 'Reports')
@section('content')


<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
    <vs-card>
      <div slot="header">
        <h3>
          Ledger
        </h3>
      </div>
      <div>

       
           <br>
             {{ Form::open(['method' => 'get', 'id' => 'store-search', 'name' => 'serach_form']) }}
                <div class="form-group-inner">
                    <div class="row">
                      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                      </div>
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          {{ Form::text('currentFilter', '', ['class' => 'form-control', 'placeholder' => 'Filter by date', 'maxlength'=>'50', 'id'=>'date']) }}
                         </div>
                         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          {{ Form::select('monthFilter', $months, null, ['class' => 'form-control', 'placeholder' => 'Filter by month', 'maxlength'=>'50']) }}
                           
                         </div>
                         <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="1">
                  <vs-button type="gradient" color="success" id="search-button">Filter</vs-button>
                </vs-col>
                 <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="1">
                  <vs-button type="gradient" color="danger"id="reset-button" >Reset</vs-button>
                </vs-col>
                       </div>
                  </div>
                  {{ Form::close() }}
              </div>
               <!-- <vs-row vs-justify="flex-end">
                <a href="{{ route('store.export-customer')}}"><vs-button type="gradient" color="danger"  id="export-button" >Export</vs-button></a>
                </vs-row> -->
              <br>
              <div id="dataList">
                
               @include('store.reports.accounting.ledger.list')
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
@endsection
@push('js')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
$(document).ready(function(){

  $("#date").flatpickr({enableTime: false,
    defaultDate:moment(),
   });

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
  
  $(document).on("click",".pagination li a",function(e) {
    e.preventDefault();
    load_listings($(this).attr('href'), 'serach_form');
  });

  $(document).on('click', '.view', function(e){
    e.preventDefault();
    $('body').waitMe();
    current = $(this)
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