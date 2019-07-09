@if($order->items->count())
<div id="grnForm">
<table class="table table-bordered">
	<tr>
		<th>Item</th>
		@if($type==1)
		<th>GRN 
			<input type="checkbox" name="select_all[]" title="Select All" class="select_all" value="0">
			@if($order->status != 6)<button type="button" id="grnBtn" data-url="{{route('store.getGrn')}}" class="btn btn-link" title="Print Grn">Print Tag</button>@endif
			<span id="grn_error" class="error"></span>
		</th>
		@else
		<th>Processed 
			<input type="checkbox" name="select_all_deliver[]" title="Select All" class="select_all_deliver" value="0">
			@if($order->status != 6)<button type="button" id="deliverBtn"  data-url="{{route('store.itemsDeliver')}}" class="btn btn-link" title="Items Ready to be delivered"><i class="fa fa-car"></i></button>@endif
			<span id="deliver_error" class="error"></span>
		</th>

		@endif
		
	</tr>
	@php $j=1; @endphp
	@foreach($order->items as $item)
		<tr>
			<td class="table-modal">{{$item->item}} ({{ $item->item_value }}/{{$order->items->sum('quantity')}})</td>
			@if($type==1)
			<td class="table-modal">
					<input type="checkbox" name="grn[]" value="{{$item['id']}}" 
					@if($item->status == 4 ||  $item->status==2 ) checked @endif class="grn_units">

		    </td>
		    @else
	    		<td>
		    	@if($item->status != 1)
					<input type="checkbox" @if($item->status == 2) checked @endif name="deliver[]"  value="{{ $item['id'] }}" class="deliver_units"> 
				@else
					--
				@endif
				</td>
		    @endif
		</tr>
		@php $j++; @endphp
	@endforeach
	<input type="hidden" name="order_id" value="{{ $order->id }}">
</table>
</div>
@endif