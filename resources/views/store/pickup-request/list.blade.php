
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-responsive table-borderless dataTable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Phone Number</th>
              <th>Address</th>
	            <th> Service </th>
              <th> Pickup Time </th>
              <th> Order </th>
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$user->id}}
              </td>
              <td>
                <a href="{{route('getcustomerdetails', $user->customer_id)}}" id="getCustomer">
                {{$user->customer_phone}}</a>
                
              </td>
               <td>
                  {{$user->customer_address_string}}
                </td>
		            <td>
                  {{$user->service_name}}
                </td>
                <td>
                  
                  @if($user->request_time)
                 
                    {{$user->request_time->format('d/m/Y')}}
                    @if($user->start_time)
                    {{ $user->start_time->format('h:i a')}} -
                    @endif
                    @if($user->end_time)
                    {{$user->end_time->format('h:i a')}}
                    @endif
                  @else
                    --
                  @endif
                </td>

                <td>
             
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
