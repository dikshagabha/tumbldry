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
          <th>Order Status</th>
          <th>Print Grn</th>
          <th>Processed Items</th>
          <th>Assign Runner</th>
          <th>Invoice</th>
          <th>Delivery Challan</th>
          <th>Payment Reciept</th>
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
                  @elseif($pay->type==4)
                    Card Pay
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
             {{$user->status_name}}
            </td> 
            <td>
               @if($user->service->form_type == 1 || $user->service->form_type == 2)
                 <a href="{{ route('store.getItemsForm', ['id'=>$user->id, 'type'=>1]) }}" class="print_grn"  title ="Print Grn" data-order_id="{{$user->id}}"> 
                    <vs-button type="gradient" color="danger" class="btn btn-danger"> <i class="fa fa-print"></i> </vs-button>
                 </a>
               @else
               --
               @endif
            </td> 

             <td>
              <a href="{{ route('store.getItemsForm', ['id'=>$user->id, 'type'=>2]) }}" class="print_grn" title ="Mark items processed" data-order_id="{{$user->id}}"> 
                    <vs-button type="gradient" color="blue" class="btn"><i class="fa fa-check"></i> </vs-button>
              </a>
              </td> 

            

             <td>
             @if($user->delivery_mode==2 && $user->items()->where('status', 2)->count() > 0)
                 @if(!$user->delivery_runner_id)
                  <a href="{{ route('store.assignDeliver', $user->id) }}" class="deliver" data-order_id="{{$user->id}}"> 
                      <vs-button type="gradient" color="light" class="btn btn-light"> <i class="fa fa-car"></i> </vs-button>
                  </a>
                  @else
                    {{$user->runner_name}}
                  @endif
              @else
                --
              @endif
           
            </td>  
            <td>
              
                @if($user->items()->where('status', 2)->count() == $user->items()->count())
                  <a href="{{ route('store.printInvoice', $user->id) }}" class="print_invoice"> 
                    <vs-button type="gradient" color="warning" class="btn btn-warning"> <i class="fa fa-file-pdf-o"></i> </vs-button></a>
                @else
                  --
                @endif
              </a>
            </td> 

            <td>
                
                @if( $user->items()->where('status', 2)->count()> 0 && $user->items()->where('status', 2)->count()< $user->items()->count())
                  <a href="{{ route('store.printInvoice', $user->id) }}" class="print_invoice"> 
                    <vs-button type="gradient" color="information" class="btn btn-info"> <i class="fa fa-file-pdf-o"></i> </vs-button></a>
                @else
                  --
                @endif
              </a>
            </td>  

              <td>
                
                @if($user->payment()->count())
                  <a href="{{ route('store.printInvoice', $user->id) }}" class="print_invoice"> 
                  
                    <vs-button type="gradient" color="dark" class="btn btn btn-dark"> <i class="fa fa-file-pdf-o"></i> </vs-button>
                  
                  </a>
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
