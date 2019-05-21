
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp

@if($users->count())

<table class="table table-striped">
    <thead>
      <tr>
        <th>S No</th>
        <th>Name</th>
        <!-- <th>Description</th>
        <th>Parameters</th> -->
        <th>Type</th>
        <!-- <th>Options</th> -->
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
       <!--  <td>
          @if($user->description) {{ substr($user->description, 0, 50) }}.. @else -- @endif
        </td>
        <td>
          @foreach($user->serviceprices as $prices)
            {{$prices->parameter}}(Rs {{$prices->value}})
          @endforeach
        </td> -->
        <td>
          @if($user->type==1) 
           <span class="badge badge-primary"> MAIN </span>
          @else
           <span class="badge badge-info"> ADDON </span>
          @endif
        </td>
        <!-- <td>
             <a href="{{route('manage-service.edit', $user->id )}}" title="edit"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button></a> 
            <a href="{{route('manage-service.destroy', encrypt( $user->id))}}" id="delete" data-token="{{csrf_token()}}" title="delete">
              <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </a>
        </td> -->
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
