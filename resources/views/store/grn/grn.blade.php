<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
	.no-break {
  page-break-inside: avoid;
}
</style>
<body>
@php
$i = 1;
@endphp

@foreach($orders as $order)
	<table class="no-break" style="width:192px; height: 200px">
		<tr width="192px" height="200px" >
			<td>
				<table class="table table-borderless table-responsive" frame="box" width="192px" height="192px">
				<tr>
					<th col-span=3 style="text-align: center;">{{$user->city}}</th>
				</tr>
				<tr>
					<th col-span=3 style="text-align: center;">{{$order->order->id}}</th>
				</tr>
				<tr>
					<td col-span=3 style="text-align: center;">{{$order->order->customer_name}}</td>
				</tr>
				<tr>
					<td col-span=2 style="text-align: center;">{{$order->service_short_name}}</td>
					<td style="text-align: center;" >{{$order->item_value}}/{{$total}}</td>
				</tr>	
				@if($order->itemimage->count())
				<tr>
					@foreach($order->itemimage->where('addon_id', '!=', null) as $item)
						<td style="text-align: center;">
							{{$item->addons->name}}
						</td>
					@endforeach
				</tr>
				@endif
				<tr>
					<td col-span=3 style="text-align: center;">{{$order->item}}</td>
				</tr>
				</table>
			</td>
		</tr>	
	</table>
	@php
	$i++;
	@endphp
@endforeach

</body>
</html>