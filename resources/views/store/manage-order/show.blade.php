
<table class="table table-bordered">
	<tr >
		<td width="50%">Order Id</td>
		<td>ORDER{{$order->id}}</td>
	</tr>
	<tr>
		<td>Coupon Applied</td>
		<td>{{$order->coupon}}</td>
	</tr>
	<tr>
		<td>Total Amount</td>
		<td>{{$order->total_price}} Rs</td>
	</tr>
</table>

@if($order->items->count())
Items:

<table class="table table-bordered">
	@foreach($order->items as $item)
	<tr>
		<td class="table-modal">{{$item->item}}</td>
		<td class="table-modal">{{round($item->quantity, 2)}}</td>
	</tr>
	@endforeach
</table>

@endif