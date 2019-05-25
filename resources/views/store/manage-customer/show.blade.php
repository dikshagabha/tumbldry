
Basic Information
<table class="table table-bordered">
	<tr >
		<td width="50%">Name</td>
		<td>{{$user->name}}</td>
	</tr>
	<tr>
		<td>Email</td>
		<td>{{$user->email}}</td>
	</tr>
	
	<tr>
		<td>Phone Number</td>
		<td>{{$user->phone_number}}</td>
	</tr>
	
</table>
@if($user->customer_addresses)
Address Information
@php
$i=1;
@endphp
<table class="table table-bordered">
	@foreach($user->customer_addresses as $address)


	<tr>
		<td class="table-modal">{{$address['address']}}</td>
	</tr>
	@php
	$i++;
	@endphp
	@endforeach
</table>
@endif