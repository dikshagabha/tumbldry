
<table class="table table-bordered">
	<tr >
		<th width="50%">Order Id</th>
		<td>ORDER{{$order->id}}</td>
	</tr>
	<tr>
		<th>Coupon Applied</th>
		<td>{{$order->coupon_id}}</td>
	</tr>
	<tr>
		<th>Total Amount</th>
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
		<th>GRN <input type="checkbox" name="select_all[]" title="Select All" class="select_all" value="0"><button type="button" id="grnBtn" data-url="{{route('store.getGrn')}}" class="btn btn-link" title="Download Grn"><i class="fa fa-download"></i></button></th>
	</tr>
	
	@foreach($order->items as $item)
	<tr>
		<td class="table-modal">{{$item->item}}</td>
		<td class="table-modal">{{round($item->quantity, 2)}}</td>
		<td class="table-modal">{{$item->service_name}}</td>
		<td class="table-modal"><input type="checkbox" name="grn[]"  value="{{ $item['id'] }}" class="grn_units"> </td>

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