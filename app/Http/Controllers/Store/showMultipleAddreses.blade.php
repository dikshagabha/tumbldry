@if($data)
<table class="table table-bordered">
	<th>Address</th>	
	@foreach($data as $address)
	<tr>
		<td class="table-modal">{{$address->address}}</td>
	</tr>
	@endforeach
</table>
@endif