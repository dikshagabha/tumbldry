
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
		<td>Store Name</td>
		<td>{{$user->store_name}}</td>
	</tr>
	<tr>
		<td>Phone Number</td>
		<td>{{$user->phone_number}}</td>
	</tr>
	<tr>
		<td>Frenchise Name</td>
		<td>{{$user->parent_name}}</td>
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
Machines Information
<table class="table table-bordered">
	<tr>
		<td width="50%" class="table-modal">Count of Machines</td>
		<td class="table-modal">{{$user->machine_count}}</td>
	</tr>
	<tr>
		<td class="table-modal">Type of Machines</td>
		<td class="table-modal">{{$data->where('type', 1)->first()->name}}</td>
	</tr>
	<tr>
		<td class="table-modal">Count of Boiler</td>
		<td class="table-modal">{{$user->boiler_count}}</td>
	</tr>
	<tr>
		<td class="table-modal">Type of Boiler</td>
		<td class="table-modal">{{$data->where('type', 2)->first()->name}}</td>
	</tr>
	<tr>
		<td class="table-modal">Count of Ironing Tables</td>
		<td class="table-modal">{{$user->iron_count}}</td>
	</tr>
</table>
Property Information
<table class="table table-bordered">
	<tr>
		<td width="50%" class="table-modal">Property Type</td>
		<td class="table-modal">@if($user->property_type==2) Owned @else Leased @endif</td>
	</tr>
	@if($user->property_type==1)
	<tr>
		<td class="table-modal">Store Size</td>
		<td class="table-modal">{{$user->store_size}}</td>
	</tr>
	<tr>
		<td class="table-modal">Store Rent</td>
		<td class="table-modal">{{$user->store_rent}}</td>
	</tr>
	<tr>
		<td class="table-modal">Rent Enhacement Period</td>
		<td class="table-modal">{{$user->rent_enhacement}}</td>
	</tr>
	<tr>
		<td class="table-modal">Rent Enhacement Percent</td>
		<td class="table-modal">{{$user->rent_enhacement_percent}}</td>
	</tr>
	<tr>
		<td class="table-modal">Landlord Name</td>
		<td class="table-modal">{{$user->landlord_name}}</td>
	</tr>
	<tr>
		<td class="table-modal">Landlord Number</td>
		<td class="table-modal">{{$user->landlord_number}}</td>
	</tr>
	@endif
</table>
Account Information
<table class="table table-bordered">
	<tr>
		<td width="50%" class="table-modal">Account Number</td>
		<td class="table-modal">@if($user->account_number){{$user->account_number}} @else -- @endif</td>
	</tr>
	<tr>
		<td class="table-modal">Bank Name</td>
		<td class="table-modal">@if($user->bank_name) {{$user->bank_name}} @else -- @endif</td>
	</tr>
	<tr>
		<td class="table-modal">IFSC Code</td>
		<td class="table-modal">@if($user->ifsc_code) {{$user->ifsc_code}} @else -- @endif</td>
	</tr>
	<tr>
		<td class="table-modal">GST Number</td>
		<td class="table-modal">@if($user->gst_number) {{$user->gst_number}} @else -- @endif</td>
	</tr>
	<tr>
		<td class="table-modal">PAN Card Number</td>
		<td class="table-modal">@if($user->pan_card_number) {{$user->pan_card_number}} @else -- @endif</td>
	</tr>
	<tr>
		<td class="table-modal">ID Proof Number</td>
		<td class="table-modal">@if($user->id_proof_number) {{$user->id_proof_number}} @else -- @endif</td>
	</tr>
</table>