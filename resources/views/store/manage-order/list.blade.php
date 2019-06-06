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
          <th>Service</th>
          <th>Delivery Mode</th>
          <th>Payment</th>
          <th>Order Date</th>
          <th>Estimated Time</th>
          <th width='20%'>Order Status</th>
          <th>Invoice</th>
          <th>View</th>

        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td>
              <a  class="view" title="view order details" href="{{route('store.getOrderDetails', $user->id)}}">
                {{$user->id}}
              </a>
            </td>
            <td>
              {{$user->customer_id}}
            </td>
            <td>
              {{$user->service->name}}
            </td>
            <td>
              @if($user->delivery_mode==1) Self Pickup @else Home Delivery @endif
            </td>

            <td>
              @if($user->payment()->count())
                @foreach($user->payment()->where('type', '!=', 0)->get() as $pay)
                  @if($pay->type==1)                                
                    Cash
                  @elseif($pay->type==2)
                    Wallet
                  @else
                    Loyality Points
                  @endif
                  ({{$pay->price}} Rs),  
                  @endforeach
                @else
                  --
                @endif
            </td>

            <td>
              @if($user->date_of_arrival)

              {{$user->date_of_arrival->format('y/m/d h:i a')}}
              @else
              --
              @endif
            </td>
            <td>
              {{$user->created_at->addDays(2)->format('y/m/d h:i a')}}
            </td>
            <td>
              @php
                $options =  [1=>'Pending', '2'=>'Recieved', 3=>'Processing', 7 =>'Delivered'];
                if($user->delivery_mode==2){
                  $options =  [1=>'Pending', '2'=>'Recieved', 3=>'Processing', 4 =>'Assign Partial Delivery to Runner',
                                              5 => 'Assign Full Delivery to Runner', 6 =>'Out for delivery', 7 =>'Delivered'];
                              }

              @endphp
                {{
                  Form::select('status',$options, $user->status, ['class'=>'form-control change_status',
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
            <td>
              
                @if($user->items()->where('status', 2)->count() || $user->payment()->count() )
                  <a href="{{ route('store.printInvoice', $user->id) }}" class="print_invoice"> 
                    <vs-button type="gradient" color="warning" class="btn btn-warning"> <i class="fa fa-file-pdf-o"></i> </vs-button></a>
                @else
                  --
                @endif
              </a>
            </td>  

            <td>
                <a  class="view" title="view order details" href="{{route('store.getOrderDetails', $user->id)}}">
                  <vs-button type="gradient" color="success" class="btn btn-success"> <i class="fa fa-eye"></i> </vs-button>
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
