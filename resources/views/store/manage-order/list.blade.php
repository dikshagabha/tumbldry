
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

  <table class="table table-striped dataTable">
      <thead>
        <tr>
          <th>S No</th>
          <th>Order</th>
          <th width="40%">Order Status</th>

        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td>
              {{$i}}
            </td>
            <td>
              <a  class="view" title="view order details" href="{{route('store.getOrderDetails', $user->id)}}">
                ORDER{{$user->id}}
              </a>
            </td>
            <td>
                {{
                  Form::select('status', [1=>'Pending', '2'=>'Recieved', 3=>'Processing', 4 =>'Assign Delivery to Runner', 5 =>'Out for delivery',
                                           6 =>'Delivered'], $user->status, ['class'=>'form-control change_status',
                                          'data-url'=> route('store.order.status',$user->id)])
                }}
                @if($user->status==4)
                  {{
                    Form::select('runner', $runner, $user->delivery_runner_id, ['class'=>'form-control',
                                            'data-url'=> route('store.order.status',$user->id),
                                            'placeholder'=>'Select Runner', 'id'=>'runner'.$user->id])
                  }}
                  <span class="error" id="id_error"></span>
                  {{
                    Form::button('assign', ['class'=>'btn btn-warning assign_runner', 'data-url'=> route('store.order.assign-delivery', $user->id), 'data-id'=>$user->id ])
                  }}
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
