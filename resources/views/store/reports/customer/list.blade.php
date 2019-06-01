
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable">
          <thead>
            <tr>
              <th>S No</th>
              <th>Name</th>
              <th>Status</th>
               <th>Created At</th>
              <th>View</th>
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
                @if($user->status==0)
                  
                   Inactive
                @else
                  Active
                @endif
              </td>
              <td>
                  {{$user->created_at->setTimezone($timezone)->format('y/m/d h:i a')}}
                  
              </td>
              <td>                  
                  <a href="{{route('manage-customer.show',encrypt($user->id))}}" class="view" title="view">
                    <vs-button type="gradient" color="warning"><i class="fa fa-eye"></i></vs-button>
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