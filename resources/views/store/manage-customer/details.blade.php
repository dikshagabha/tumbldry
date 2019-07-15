@extends('store.layout-new.app')
@section('title', 'Manage Customer')

@section('content')


<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
      <div slot="header">
        
        <hr>
      </div>
      <div>
      <h3>{{$customer->name}}</h3> 
      <strong>(Customer Since {{$customer->created_at->setTimezone($timezone)->format('d/m/Y')}})</strong>
      <br>
       Total number of Orders: {{$total}}<br>
       Average revenue: {{$revenue}} Rs
<hr>
<h4>Pending Orders</h4>
<table class="table table-bordered">
  <th> Order Id</th>
  <th> Items</th>
  <th> Price</th>
  <th> Payment</th>
  <th> Status </th>
  <th> Date</th>
  @foreach($pending as $order)
    <tr>
      <td>{{$order->id}}</td>
      <td>
        @if($order->items->count())
          @foreach($order->items as $item)
            {{round($item->quantity, 2)}} X {{$item->item}}
             @if($item->itemimage->count())
             (@foreach($item->itemimage->where('addon_id', '!=', null) as $key=>$addon)
                                {{ $addon->addon_name.','}}
                                @endforeach)
            @endif
            <br>

          @endforeach
        @endif
      </td>
      <td>{{$order->total_price}} Rs</td>
      <td>@if($order->payment()->count())
                @foreach($order->payment()->where('type', '!=', 0)->get() as $pay)
                  @if($pay->type==1)                     
                    Cash
                  @elseif($pay->type==2)
                    Wallet
                  @elseif($pay->type==4)
                    Card Pay [ {{$pay->transaction_id}}] 
                 @elseif($pay->type==5)
                    {{$pay->payment_mode}}
                  @else
                    Loyality Points
                  @endif
                  ({{$pay->price}} Rs),  
                  @endforeach
                @else
                  --
                @endif</td>
                <td>
             {{$order->status_name}}
            </td> 
             <td>
              {{$order->created_at->setTimezone($timezone)->format('d/m/Y')}}
            </td>
    </tr>
  @endforeach
</table>
<hr>
<h4>
Delivered Orders</h4>
<table class="table table-bordered">
  <th> Order Id</th>
  <th> Items</th>
  <th> Price</th>
  <th> Payment</th>
  <th> Date</th>
  @foreach($delivered as $order)
    <tr>
      <td>{{$order->id}}</td>
      <td>
        @if($order->items->count())
          @foreach($order->items as $item)
            {{round($item->quantity, 2)}} X {{$item->item}}
             @if($item->itemimage->count())
             (@foreach($item->itemimage->where('addon_id', '!=', null) as $key=>$addon)
                                {{ $addon->addon_name.','}}
                                @endforeach)
            @endif
            <br>

          @endforeach
        @endif
      </td>
      <td>{{$order->total_price}} Rs</td>
      <td>@if($order->payment()->count())
                @foreach($order->payment()->where('type', '!=', 0)->get() as $pay)
                  @if($pay->type==1)                     
                    Cash
                  @elseif($pay->type==2)
                    Wallet
                  @elseif($pay->type==4)
                    Card Pay [ {{$pay->transaction_id}}] 
                 @elseif($pay->type==5)
                    {{$pay->payment_mode}}
                  @else
                    Loyality Points
                  @endif
                  ({{$pay->price}} Rs),  
                  @endforeach
                @else
                  --
                @endif</td>

             <td>
              {{$order->created_at->setTimezone($timezone)->format('d/m/Y')}}
            </td>
    </tr>
  @endforeach
</table>
    <br>
    
    </div>
    
    
  </vs-col>
</vs-row>
@endsection
