@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())
  <table class="table table-borderless dataTable">
      <thead>
        <tr>
         <!--  <th>S No</th> -->
          <th>Order</th>
          <th>Customer Id</th>
          <th>Phone Number</th>
          <th>Date of Arrival</th>
          <th width='30%'>Order Status</th>

        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <!-- <td>
              {{$i}}
            </td> -->
            <td>
              <a  class="view" title="view order details" href="{{route('store.getOrderDetails', $user->id)}}">
                {{$user->id}}
              </a>
            </td>
            <td>
              CUSTOMER{{$user->customer_id}}
            </td>
            <td>
              {{$user->customer_phone_number}}
            </td>
            <td>
              @if($user->date_of_arrival)

              {{$user->date_of_arrival->format('l y/m/d h:i a')}}
              @else
              --
              @endif
            </td>
            <td>
                {{
                  Form::select('status', [1=>'Pending', '2'=>'Recieved', 3=>'Processing', 4 =>'Assign Partial Delivery to Runner',
                                            5 => 'Assign Full Delivery to Runner', 6 =>'Out for delivery', 7 =>'Delivered'], $user->status, ['class'=>'form-control change_status',
                                          'data-url'=> route('store.order.status',$user->id)])
                }}
                <div class="add_runner" @if($user->status != 4 && $user->status != 5 ) style="display: none" @endif>
                  {{
                    Form::select('runner', $runner, $user->delivery_runner_id, ['class'=>'form-control',
                                            'data-url'=> route('store.order.status',$user->id),
                                            'placeholder'=>'Select Runner', 'id'=>'runner'.$user->id])
                  }}
                  <span class="error" id="id_error"></span>
                  <br>
                  {{
                    Form::button('Assign', ['class'=>'btn btn-warning assign_runner', 'data-url'=> route('store.order.assign-delivery', $user->id), 'data-id'=>$user->id ])
                  }}
                </div>
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
