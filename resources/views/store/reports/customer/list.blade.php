
@php
$i = 1;
@endphp
 @if($users->count())

      <table class="table display nowrap dataTable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Status</th>
               <th>Created At</th>
<!--               <th>View</th> -->
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$user->id}}
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
             <!--  <td>                  
                  <a href="{{route('manage-customer.show',encrypt($user->id))}}" class="view" title="view">
                    <vs-button type="gradient" color="warning"><i class="fa fa-eye"></i></vs-button>
                  </a>
                  
              </td> -->

@php
$i ++;
@endphp
            </tr>
             
            @endforeach
          </tbody>
      </table>

      @else
      No Records Found
      @endif