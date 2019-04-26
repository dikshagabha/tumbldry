@extends('layouts.app')
@section('title', 'Manage Frenchise')
@section('content')
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;

@endphp
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
          <div class="row">
            <div class="col-md-9">
            </div>
            <div class="col-md-3">
              <a href="{{route('manage-frenchise.create')}}"><button class="btn btn-danger">Add New Frenchise</button></a>
            </div>
          </div>
            <br>
            <!-- <div class="row"> -->
          @if($users->count())

          <table class="table table-striped">
              <thead>
                <tr>
                  <th>S No</th>
                  <th>Frenchise Name</th>
                  <th>Contact Person Name</th>
                  <th>Contact Person Email</th>
                  <th>Contact Person Phone Number</th>
                 
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
                    {{$user->store_name}}
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
                      <a href="{{route('manage-frenchise.edit', encrypt( $user->id))}}" title="edit"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button></a>
                      <a href="{{route('manage-frenchise.destroy', encrypt( $user->id))}}" id="delete" data-token="{{csrf_token()}}" title="delete"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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
          <!-- </div> -->
        </div>
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
          message: "Do you want to delete the Franchise? This cannot be undone.",
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

@endpush
