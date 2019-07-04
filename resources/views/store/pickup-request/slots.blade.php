@if(count($slots))
	<table class="table table-borderless">
		<th>Start Time</th>
		<th>End Time</th>
		<th>Select</th>

		@foreach($slots as $slot)
		<tr>
			<td>
				{{$slot[0]->format('h:i a')}}
			</td>
			<td>
				{{$slot[1]->format('h:i a')}}
			</td>

			<td>
				<input type="radio" name="start" class="slots" data-start="{{$slot[0]}}" data-end="{{$slot[1]}}">
			</td>
		</tr>
		@endforeach

	</table>
@else
No slots found
@endif