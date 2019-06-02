
<table class="table table-bordered">
	<tr >
		<th width="50%">Order Id</th>
		<td>ORDER{{$order->id}}</td>
	</tr>
	
	<tr>
		<th>Total Amount</th>
		<td>{{$order->estimated_price}} Rs</td>
	</tr>
	<tr>
		<th>GST</th>
		<td>{{$order->gst}} Rs</td>
	</tr>
	<tr>
		<th>CGST</th>
		<td>{{$order->cgst}} Rs</td>
	</tr>
	<tr>
		<th>Discount</th>
		<td>@if($order->discount){{$order->discount}} Rs @endif</td>
	</tr>
	<tr>
		<th>Coupon Applied</th>
		<td>{{$order->coupon_id}}</td>
	</tr>
	<tr>
		<th>Payable Amount Amount</th>
		<td>{{$order->total_price}} Rs</td>
	</tr>
</table>
@if($order->items->count())
Items:
<div id="grnForm">
<table class="table table-bordered">
	<tr>
		<th>Item</th>
		<th>Quantity</th>
		<th>Service</th>
		<th>Status</th>
		<th>GRN <input type="checkbox" name="select_all[]" title="Select All" class="select_all" value="0"><button type="button" id="grnBtn" data-url="{{route('store.getGrn')}}" class="btn btn-link" title="Download Grn"><i class="fa fa-download"></i></button>
			<span id="grn_error" class="error"></span>
		</th>
		<th>Processed 
			<input type="checkbox" name="select_all_deliver[]" title="Select All" class="select_all_deliver" value="0">
			<button type="button" id="deliverBtn"  data-url="{{route('store.itemsDeliver')}}" class="btn btn-link" title="Items Ready to be delivered"><i class="fa fa-car"></i></button>
			<span id="deliver_error" class="error"></span>
		</th>
	</tr>
	
	@foreach($order->items as $item)
	<tr>
		<td class="table-modal">{{$item->item}}</td>
		<td class="table-modal">{{round($item->quantity, 2)}}</td>
		
		<td class="table-modal">{{$item->service_name}}</td>
		
		<td class="table-modal">
			<a href="{{route('store.mark-recieved', $item->id)}}" value="{{ $item->status }}" class="mark_status">
				@if($item->status==1) Pending @else Recieved @endif</a>
		</td>

		<td class="table-modal">
			@if($item->status != 1)
				<input type="checkbox" name="grn[]" value="{{$item['id']}}" @if($item->status == 4 ||  $item->status==2 ) checked @endif class="grn_units">
			@else
				--
			@endif
		 </td>
		
		<td class="table-modal">
			@if($item->status != 1)
				<input type="checkbox" @if($item->status == 2) checked @endif name="deliver[]"  value="{{ $item['id'] }}" class="deliver_units"> 
			@else
				--
			@endif
		</td>

	</tr>
	@endforeach
	<input type="hidden" name="order_id" value="{{ $order->id }}">
	
</table>
</div>
@endif
@if($order->customer->count())
Customer Details:
<table class="table table-bordered">
	<tr>
		<th class="table-modal">Name</th>
		<td class="table-modal">{{$order->customer->name}}</td>
	</tr>
	<tr>
		<th class="table-modal">Phone Number</th>
		<td class="table-modal">{{$order->customer->phone_number}}</td>
	</tr>
	<tr>
		<th class="table-modal">Email</th>
		<td class="table-modal">{{$order->customer->email}}</td>
	</tr>
</table>
@endif
@if($order->address)
Customer Address Details:
<table class="table table-bordered">
	
	<tr>
		<th class="table-modal">Address</th>
		<td class="table-modal">{{$order->address->address}}</td>
	</tr>
	<tr>
		<th class="table-modal">City</th>
		<td class="table-modal">{{$order->address->city}}</td>
	</tr>
	<tr>
		<th class="table-modal">State</th>
		<td class="table-modal">{{$order->address->state}}</td>
	</tr>
	<tr>
		<th class="table-modal">Pin</th>
		<td class="table-modal">{{$order->address->pin}}</td>
	</tr>
</table>

@endif