@extends('admin.layout.app')
@section('title', 'Manage Service')
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
    <a href="{{route('manage-service.create')}}"><button class="btn btn-danger">Add New Service</button></a>
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
        <th>Description</th>
        <th>Parameters</th>
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
          @if($user->description) {{$user->description}} @else N/A @endif
        </td>
        <td>
          @foreach($user->serviceprices as $prices)
            {{$prices->parameter}}(Rs {{$prices->value}})
          @endforeach
        </td>
        <td>
            <a href="{{route('manage-service.edit', $user->id )}}"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button></a>
            <a href="{{route('manage-service.destroy', encrypt( $user->id))}}" id="delete" data-token="{{csrf_token()}}">
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
@endif
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
          message: "Do you want to delete the service? This cannot be undone.",
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

  $(document).on('click', '.email_edit', function(e){
    e.preventDefault();
  })

})
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=2&libraries=places&callback=initMap"
        async defer></script> -->

@endsection
