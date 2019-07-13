@if(count($stores))
<table class="table table-borderless">
		<th>Name</th>
		<th>Address</th>
		<th>Select Time Slot</th>
	@foreach($stores as $store)
	<tr>
		<td>
			{{$store['store_name']}}
		</td>
		<td>
			{{$store['address']}}
		</td>
		<td>	
			@foreach($store['slots'] as $key=>$slot)
				<input type="radio" name="start_slot" class="slots_pick" data-store="{{$store['id']}}" 
				data-start="{{$slot[0]}}" data-end="{{$slot[1]}}" id="{{$store['id'].''.$key}}">
				<label for="{{$store['id'].''.$key}}"> 
					{{$slot[0]->format('h:i a')}} : {{$slot[1]->format('h:i a')}}</label><br>
			@endforeach
		</td>
	</tr>
	@endforeach
</table>
@else
No slots found
@endif