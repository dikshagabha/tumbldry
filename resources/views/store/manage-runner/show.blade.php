
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
Address Information
<table class="table table-bordered">
	<tr>
		<td width="50%" class="table-modal">Address</td>
		<td class="table-modal">{{$user->address}}</td>
	</tr>
	<tr>
		<td class="table-modal">City</td>
		<td class="table-modal">{{$user->city}}</td>
	</tr>
	<tr>
		<td class="table-modal">State</td>
		<td class="table-modal">{{$user->state}}</td>
	</tr>
	<tr>
		<td class="table-modal">Pin</td>
		<td class="table-modal">{{$user->pin}}</td>
	</tr>
	<tr>
		<td class="table-modal">Latitude</td>
		<td class="table-modal">{{$user->latitude}}</td>
	</tr>
	<tr>
		<td class="table-modal">Longitude</td>
		<td class="table-modal">{{$user->longitude}}</td>
	</tr>
	<tr>
		<td class="table-modal">Landmark</td>
		<td class="table-modal">{{$user->landmark}}</td>
	</tr>
</table>