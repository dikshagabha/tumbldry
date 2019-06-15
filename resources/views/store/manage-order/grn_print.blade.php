
@if($order->items->count())
Items:
<div id="grnForm">
<table class="table table-bordered">
	<tr>
		<th>Item</th>
		<th>Quantity</th>
		<th>Service</th>
		<th>Status</th>
		@if($vendors)<th>Vendors</th>@endif

		@if($order->service->form_type == 1 || $order->service->form_type == 2)
		<th>GRN <input type="checkbox" name="select_all[]" title="Select All" class="select_all" value="0"><button type="button" id="grnBtn" data-url="{{route('store.getGrn')}}" class="btn btn-link" title="Print Grn">Print Tag</button>
			<span id="grn_error" class="error"></span>
		</th>
		@endif
		<th>Processed 
			<input type="checkbox" name="select_all_deliver[]" title="Select All" class="select_all_deliver" value="0">
			<button type="button" id="deliverBtn"  data-url="{{route('store.itemsDeliver')}}" class="btn btn-link" title="Items Ready to be delivered"><i class="fa fa-car"></i></button>
			<span id="deliver_error" class="error"></span>
		</th>
	</tr>
	
	@foreach($order->items as $item)
	<tr>
		<td class="table-modal">{{$item->item}}</td>
		<td class="table-modal">{{round($item->quantity, 2)}}</td>
		
		<td class="table-modal">{{$item->service_name}}</td>
		
		<td class="table-modal">
			@if($item->status==1)
			<a href="{{route('store.mark-recieved', $item->id)}}" value="{{ $item->status }}" class="mark_status">
				 Pending </a> 
				 @else Recieved @endif
		</td>
		@if($vendors)
		<td>
			@if($order->vendor->count())
				{{ $order->vendor()->where('item_id', $item->id)->first()->vendor_name }}
			@else
				{{
					Form::select('vendor', $vendors, null, ["placeholder"=>"Select Vendor", 
					'id'=>'selectVendor', 'data-order'=>$order->id, 'data-item'=>$item->id, 
					 'data-service'=>$item->service_id,
					 "class"=>'form-control selectVendor', 'data-url'=>route('store.assignVendor')])
				}}
			@endif
		</td>
		@endif
		@if($order->service->form_type == 1 || $order->service->form_type == 2)
		<td class="table-modal">
			@if($item->status != 1)
				<input type="checkbox" name="grn[]" value="{{$item['id']}}" @if($item->status == 4 ||  $item->status==2 ) checked @endif class="grn_units">
			@else
				--
			@endif
		 </td>
		@endif
		<td class="table-modal">
			@if($item->status != 1)
				<input type="checkbox" @if($item->status == 2) checked @endif name="deliver[]"  value="{{ $item['id'] }}" class="deliver_units"> 
			@else
				--
			@endif
		</td>

	</tr>
	@endforeach
	<input type="hidden" name="order_id" value="{{ $order->id }}">
	
</table>
</div>
@endif