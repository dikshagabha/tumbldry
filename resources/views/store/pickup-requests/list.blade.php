
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable " style="overflow-x:auto;">
          <thead>
            <tr>
              <th>Id</th>
              <th>Phone Number</th>
              <th width="20%">Name</th>
              <th>Service</th>
              <th>Pickup Time</th>
              <th>Status</th>
              <th width="20%">AssignedTo</th>
            </tr>
          </thead>
          <tbody>
      @foreach($users as $user)
            <tr>
              <td>
                {{$user->id}}
              </td>
              <td>
                <a href="{{route('getcustomerdetails', $user->customer_id)}}" id="getCustomer">{{$user->customer_phone}}</a>
              </td>
              <td>
                {{$user->customer_name}}
              </td>
              
              <td>
               	{{$user->service_name}}
              </td>

              <td>
                  
                  @if($user->request_time)
                    {{$user->request_time->setTimezone($timezone)->format('y/m/d h:i a')}}
                  @else
                    --
                  @endif
              </td>
              
              <td>
                {{$user->status_text}}
              </td>
              <td>
                {{Form::select("runner_id",$runners, $user->assigned_to, ["class"=>"runner_select form-control", 'placeholder'=>"Select Runner", 'href'=>route('store.assign-runner'), 'data-id'=>$user->id ])}}
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
