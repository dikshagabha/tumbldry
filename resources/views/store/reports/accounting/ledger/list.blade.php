
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Type</th>
              <th>Price</th>
              <th>Payment Mode</th>
               <th>Payment Date</th>
<!--               <th>View</th> -->
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$user->order_id}}
              </td>
              <td>
                @if($user->type==11)
                  Plan Payment
                @else
                  Order Payment
                @endif
              </td>
              <td>
                {{$user->price}} Rs
              </td>
              <td>
                @if($user->type==1 ||$user->type==11 )
                  Cash
                @elseif($user->type==2)
                  Wallet
                @elseif($user->type==3)
                  Loyality Points Redemption
                @elseif($user->type==4)
                  Internet Banking
                @endif
              </td>
              <td>
                @if($user->created_at)
                  {{$user->created_at->setTimezone($timezone)->format('y/m/d h:i a')}}
                @else
                  --
                @endif
              </td>
             <!--  <td>                  
                  <a href="{{route('manage-customer.show',encrypt($user->id))}}" class="view" title="view">
                    <vs-button type="gradient" color="warning"><i class="fa fa-eye"></i></vs-button>
                  </a>
                  
              </td> -->


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