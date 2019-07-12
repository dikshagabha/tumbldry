
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable">
          <thead>
            <tr>
              <th>S No</th>
              <th>Customer Phone</th>
              <th>Store Phone</th>
	            <th> Service </th>
              <th> Pickup Time </th>
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$i}}
              </td>
              <td>
                <a href="{{route('getcustomerdetails', $user->customer_id)}}" id="getCustomer">
                {{$user->customer_phone}}</a>
                
              </td>
              <td>
                @if($user->store_id)
                 <a href="{{route('getcustomerdetails', $user->store_id)}}" id="getCustomer">
                  {{$user->store_phone}}</a>
                  @else
                  --
                  @endif
                
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
