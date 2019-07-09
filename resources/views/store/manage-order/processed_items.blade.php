
@if($order->items->count())
<div id="grnForm">
<table class="table table-bordered">
	<tr>
		<th>Item</th>
		
		<th>GRN 
			<input type="checkbox" name="select_all[]" title="Select All" class="select_all" value="0">
			
				@if($user->status != 6)
				<button type="button" id="grnBtn" data-url="{{route('store.getGrn')}}" class="btn btn-link" title="Print Grn">Print Tag</button>

				@endif
			<span id="grn_error" class="error"></span>
		</th>
		
	</tr>
	
	@foreach($order->items as $item)
		@foreach($item->quantity as $quantity)
				<tr>
					<td class="table-modal">{{$item->item}}</td>
					<td class="table-modal">
						@if($item->status != 1)
							<input type="checkbox" @if($item->status == 2) checked @endif name="deliver[]"  value="{{ $item['id'] }}" class="deliver_units"> 
						@else
							--
						@endif
					</td>
					
				</tr>
		@endforeach
	@endforeach
	<input type="hidden" name="order_id" value="{{ $order->id }}">
	
</table>
</div>
@endif