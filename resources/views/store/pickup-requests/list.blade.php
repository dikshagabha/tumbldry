
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable">
          <thead>
            <tr>
              <th>S No</th>
              <th>Customer Phone Number</th>
              <th>Customer Name</th>
              <th>Customer Address</th>
             <th> Service </th>
  
	</tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$i}}
              </td>
              <td>
                <a href="{{route('getcustomerdetails', $user->customer_id)}}" id="getCustomer">{{$user->customer_phone}}</a>
              </td>
              <td>
                {{$user->customer_name}}
              </td>              
              <td>

                <a href="{{route('getaddressdetails', $user->address)}}" id="getAddress">
                  {{$user->customer_address_string}}
                </a>
                
              </td>          
           
	<td>
               	{{$user->service_name}}
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
