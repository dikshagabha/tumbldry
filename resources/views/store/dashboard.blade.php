@extends('store.layout-new.app')
@section('title', 'Dashboard')
@section("css")
<link rel="stylesheet" type="text/css" href="{{asset('css/chosen/bootstrap-chosen.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/jcf.css')}}">
@endsection
@section('content')
<!-- <vs-row vs-justify="center"  id="dataList">
 -->	@include('store.dashboard-list')
<!-- </vs-row>
 -->

<div id="addressModal" class="modal" role="dialog">
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

<script type="text/javascript">
$(document).ready(function(){
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

	 $(document).on("click",".view",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)
      $.ajax({
        url:current.attr('href'),
        method:'get',
        success:function(data){
          $('#details').html(data);
           $('body').waitMe('hide');
          $("#addressModal").modal('show');
        }
      })
    });

});
</script>
@endpush