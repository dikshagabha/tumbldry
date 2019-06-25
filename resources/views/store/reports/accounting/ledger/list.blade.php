

@php
$i = 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable">
          <thead>
            <tr>
              <th>S.No.</th>
              <th>Type</th>
              <th>Price</th>
              <th>Payment Mode</th>
               <th>Payment Date</th>
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{ $i }}
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
                @elseif($user->type==5)
                  {{$user->payment_mode}}
                @endif
              </td>
              <td>
                @if($user->created_at)
                  {{$user->created_at->setTimezone($timezone)->format('y/m/d h:i a')}}
                @else
                  --
                @endif
              </td>
          @php
            $i++;
            @endphp

            </tr>
            @endforeach
          </tbody>
      </table>



      @else
      No Records Found
      @endif