@extends('admin.layout.app')
@section('title', 'Manage Store')
@section('content')

@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
<br>
<div class="container-fluid">
<div class="row">
  <div class="col-md-9">
  </div>
  <div class="col-md-3">
    <a href="{{route('manage-store.create')}}"><button class="btn btn-danger">Add New Store</button></a>
  </div>
</div>
<br>
<div class="row">
@if($users->count())

<table class="table table-striped">
    <thead>
      <tr>
        <th>S No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Store Name</th>
        <th>Options</th>
      </tr>
    </thead>
    <tbody>

@foreach($users as $user)
      <tr>
        <td>
          {{$i}}
        </td>
        <td>
          {{$user->name}}
        </td>
        <td>
          {{$user->email}}
        </td>
        <td>
          {{$user->phone_number}}
        </td>
        <td>
          {{$user->store_name}}
        </td>
        <td>
            <a href="{{route('manage-store.edit',encrypt( $user->id))}}" title="edit">
              <button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button>
            </a>
            <a href="{{route('manage-store.show',encrypt( $user->id))}}" class="view" title="view">
              <button type="button" class="btn btn-info "><i class="fa fa-eye"></i></button>
            </a>
            <a href="{{route('manage-store.destroy', encrypt( $user->id))}}" id="delete" data-token="{{csrf_token()}}" title="delete"> 
              <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </a>
        </td>
      </tr>
      @php
      $i++;
      @endphp
      @endforeach
    </tbody>
</table>

{{$users->links()}}
@else
No Records Found
</div>
@endif
</div>
<div id="addressModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Store Details</h4>
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
@section('js')
<script src="{{asset('js/bootbox.js')}}"></script>
<script>
$(document).ready(function(){
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
                    window.location.reload()
                  },
                })
              }
          }
      });

  })


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
})
</script>

@endsection
