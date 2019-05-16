
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable">
          <thead>
            <tr>
              <th>S No</th>
              <th>Phone Number</th>
              <th width="10%">Name</th>
              <th width="20%">Address</th>
              <th>Service</th>
              <th>Pickup Time</th>
              <th>Status</th>
              <th width="20%">AssignedTo</th>
              <th width="10%">Order</th>
              <!-- <th>Runner</th> -->
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

              <td>
                  
                  @if($user->request_time)
                    {{$user->request_time->setTimezone($timezone)->format('l y/m/d h:i a')}}
                  @else
                    --
                  @endif
              </td>
              
              <td>
                {{$user->status_text}}
              </td>

              <!-- <td>
                {{$user->runner_name}}
              </td> -->

              <td>
                {{Form::select("runner_id",$runners, $user->assigned_to, ["class"=>"runner_select form-control", 'placeholder'=>"Select Runner", 'href'=>route('store.assign-runner'), 'data-id'=>$user->id ])}}
              </td>

               <td>
                @if($user->status==2 && !$user->order()->count())
                <a href="{{route('store.create-order', encrypt($user->id))}}" title="create order">
                  <button class="btn btn-link"><i class="fa fa-plus"></i></button>
                </a>
                @elseif($user->order()->count())
                    <a  class="view" title="view order details" href="{{route('store.getOrderDetails', $user->order()->first()->id)}}">
                      ORDER{{$user->order()->first()->id}}
                    </a>
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
