BASIC INFORMATION
<table class="table table-bordered">
	<tr >
		<th width="50%">Name</th>
		<td>{{$user->name}}</td>
	</tr>
	<tr>
		<th>Email</th>
		<td>{{$user->email}}</td>
	</tr>
	
	<tr>
		<th>Phone Number</th>
		<td>{{$user->phone_number}}</td>
	</tr>
	
</table>

@if($user->addresses()->count())
ADDRESS INFORMATION
<table class="table table-bordered">
	<tr >
		<th width="50%">Address</th>
		<td>{{$user->addresses->address}}</td>
	</tr>
	<tr>
		<th>City</th>
		<td>{{$user->addresses->city}}</td>
	</tr>
	
	<tr>
		<th>State</th>
		<td>{{$user->addresses->state}}</td>
	</tr>
	<tr>
		<th>Pin</th>
		<td>{{$user->addresses->pin}}</td>
	</tr>
	
</table>
@endif
@if($user->users()->count())
PROVIDERS INFORMATION
<table class="table table-bordered">

	<th>Name</th>
	<th>Phone Number</th>
	<th>Email</th>
	<th>Address</th>
	@foreach($user->users as $prov)
	<tr>
		<td>{{$prov->name}}</td>
		<td>{{$prov->phone_number}}</td>
		<td>{{$prov->email}}</td>
		<td>{{$prov->address}}</td>
	</tr>
	@endforeach
</table>
@endif