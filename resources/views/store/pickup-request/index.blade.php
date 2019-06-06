@extends('store.layouts.app')
@section('title', 'Manage Pickup')
@section('content')

<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
    <vs-card>
      <div slot="header">
        <h3>
          Pickup Details
        </h3>
      </div>
      <div>

      <vs-row vs-justify="flex-end">
       <a href="{{route('store-pickup-request.create')}}">
          <vs-button type="gradient" color="danger">Add Pickup Request</vs-button>
        </a>
      </vs-row>
      <br>
            <div id="dataList">
              
             
             @include('store.pickup-request.list')
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
         <h4 class="modal-title">User Details</h4>
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
    $.ajax({
      url: $('.view').attr('href'),
      type:"get",
      success: function(data){
        $('body').waitMe("hide");        
        $('#details').html(data);
        $("#addressModal").modal('show');
      },
    })
  })

  $(document).on('click', '#getCustomer, #getStore', function(e){
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

  $(document).on("click","#grnBtn",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)

      console.log($('#grnForm :input').serializeArray());
      $.ajax({
        url:current.data('url'),
        method:'post',
         //xhrFields is what did the trick to read the blob to pdf
            xhrFields: {
                responseType: 'blob'
            },
        data: $('#grnForm :input').serializeArray(),
        success:function(response, status, xhr){
          $('body').waitMe('hide');
          // var current_page = $(".pagination").find('.active').text();
          // load_listings(location.href+'?page='+current_page, 'serach_form');
          //success(data.message);

          var filename = "";                   
                var disposition = xhr.getResponseHeader('Content-Disposition');

                 if (disposition) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                } 
                var linkelem = document.createElement('a');
                try {
                                           var blob = new Blob([response], { type: 'application/octet-stream' });                        

                    if (typeof window.navigator.msSaveBlob !== 'undefined') {
                        //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                        window.navigator.msSaveBlob(blob, filename);
                    } else {
                        var URL = window.URL || window.webkitURL;
                        var downloadUrl = URL.createObjectURL(blob);

                        if (filename) { 
                            // use HTML5 a[download] attribute to specify filename
                            var a = document.createElement("a");

                            // safari doesn't support this yet
                            if (typeof a.download === 'undefined') {
                                window.location = downloadUrl;
                            } else {
                                a.href = downloadUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.target = "_blank";
                                a.click();
                            }
                        } else {
                            window.location = downloadUrl;
                        }
                    }   

                } catch (ex) {
                    console.log(ex);
                } 
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
})
</script>

@endpush