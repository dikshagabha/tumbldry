
@if($address)
	<table class="table table-borderless">
	@foreach($address as $add)
	<!-- <a href="#" class="table-modal address" data-id="{{$add->id}}" data-value="{{$add->address}}">
	 -->
	<tr class="table-modal address" data-id="{{$add->id}}"  style="cursor: pointer;" data-value="{{$add->address}}" >
		<td>{{$add->address}}</td>
	
	</tr>
	<!-- </a> -->
	@endforeach
	</table>
@endif