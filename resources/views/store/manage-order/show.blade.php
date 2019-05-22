
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
<table class="table table-bordered">
	<tr>
		<th>Item</th>
		<th>Quantity</th>
		<th>Service</th>
	</tr>
	@foreach($order->items as $item)
	<tr>
		<td class="table-modal">{{$item->item}}</td>
		<td class="table-modal">{{round($item->quantity, 2)}}</td>
		<td class="table-modal">{{$item->service_name}}</td>
	</tr>
	@endforeach
</table>

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