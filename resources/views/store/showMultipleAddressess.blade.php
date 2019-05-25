@php
$i=1;
@endphp
@if($data)
<table class="table table-bordered">
	<th>Address</th>
	<th>Options</th>		
	@foreach($data as $address)


	<tr>
		<td class="table-modal">{{$address['address']}}</td>
		<td class="table-modal">
			<button class="btn btn-danger deleteItemBtn" data-url = "{{route('store.deleteCustomerAddresses')}}" data-id="{{$i}}" title="Delete"><i class="fa fa-trash"></i></button>
		</td>
	</tr>
	@php
	$i++;
	@endphp
	@endforeach
</table>
@endif