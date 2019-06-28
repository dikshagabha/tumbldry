@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;

@endphp
  <!-- <div class="row"> -->
@if($users->count())

<table class="table table-borderless">
    <thead>
      <tr>
        <th>S No</th>
        <td>Name</td>
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
            <a href="{{route('manage-supplies.edit', encrypt( $user->id))}}" title="edit" class="edit"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button></a>

            <a href="{{route('manage-supplies.destroy', encrypt( $user->id))}}" id="delete" data-token="{{csrf_token()}}" title="delete"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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