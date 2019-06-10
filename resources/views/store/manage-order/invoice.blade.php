<html>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<div class="container">
	<h3 style="text-align: center;">Tax Invoice</h3>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6">
			<img src="{{asset('images/logo.png')}}" width="100px" height="100px">
		</div>
			ORDER # {{$order->id}}
	</div>
	<hr>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 pull-left">
			<strong>Billed To</strong>
			<br>
			{{$order->customer_name}}<br>{{$order->customer_phone_number}}<br>{{$order->customer_address}}

		</div>
		<div class="col-md-6 col-sm-6 col-lg-6 pull-right">
			{{$user->store_name}}<br>{{$user->phone_number}}<br>{{$user->address}}
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 pull-left">
			<strong>Order Date</strong>
			{{$order->created_at->format('d-m-y')}}
		</div>
		<div class="col-md-6 col-sm-6 col-lg-6 pull-right">
			<strong>Arrival Date</strong>
			{{$order->date_of_arrival->format('d-m-y')}}
		</div>
	</div>

	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 pull-left">
			<strong>Status</strong>
			@if($order->payment()->count())	
				Paid 
			@else
				Unpaid
			@endif
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12">
			<table class="table table-borderless">
				<tr><th colspan="6"> Order Summary ({{$order->customer_service}}) </th></tr>
				<tr><td> ID </td> 
					<td> Description </td>
					<td> Weight </td>					
					<td> Total </td>
				 </tr>
					
				@if(! $items_partial)
					<tr>
						<td>1. </td>
						<td>						
							@foreach($items as $item)
								{{$item->quantity}} X {{ $item->item }}  
								@if($item->itemimage->count()) 
								(
									@foreach($item->itemimage as $addon)
										{{ $addon->addon_name.','}}
									@endforeach 
								)
								@endif
								<br>
							@endforeach
							<br>
							Total Pcs: {{$total}} 
						</td>
						<td>
							@if($weight){{$weight}}@else -- @endif
						</td>
						<td>						
							{{$order->estimated_price}} Rs
						</td>
					</tr>
					<tr>						
						<td colspan="3">Sub Total</td>
						<td> Rs {{$order->estimated_price}}</td>
					</tr>					
					<tr>						
						<td colspan="3">SGST(9%)</td>
						<td>  Rs {{$order->gst}}</td>
					</tr>
					<tr>
						<td colspan="3">CGST(9%)</td>
						<td> Rs {{$order->cgst}}</td>
					</tr>
					<tr>
						<td colspan="3">Estimated Price</td>
						<td>Rs {{$order->estimated_price+$order->cgst+$order->gst}}</td>
						
					</tr>
					<tr>						
						<td colspan="3"> Discount </td>
						<td>Rs {{$order->discount}}</td>
					</tr>
					<tr>
						<td colspan="3">Net Amount</td>
						<td>Rs {{$order->total_price}}</td>
					</tr>
				@elseif($items->where('status', 2)->count() == 0)
				<tr>
					<td>1. </td>
					<td>
						Pending Clothes	<br>			
						@foreach($items->where('status', '!=', 2) as $item)
							{{$item->quantity}} X {{ $item->item }}  @if($item->itemimage->count()) ({{ $item->itemimage->first()->addon_name}}) @endif<br>
						@endforeach
						<br>
						Total Pcs: {{$items->where('status','!=' , 2)->sum('quantity')}}
					</td>					
					<td>
						@if($weight){{$weight}}@else -- @endif
					</td>
					<td>						
							{{$order->estimated_price}} Rs
						</td>
				</tr>
				<tr>						
						<td colspan="3">Sub Total</td>
						<td> Rs {{$order->estimated_price}}</td>
					</tr>					
					<tr>						
						<td colspan="3">SGST(9%)</td>
						<td>  Rs {{$order->gst}}</td>
					</tr>
					<tr>
						<td colspan="3">CGST(9%)</td>
						<td> Rs {{$order->cgst}}</td>
					</tr>
					<tr>
						<td colspan="3">Estimated Price</td>
						<td>Rs {{$order->estimated_price+$order->cgst+$order->gst}}</td>
						
					</tr>
					<tr>						
						<td colspan="3"> Discount </td>
						<td>Rs {{$order->discount}}</td>
					</tr>
					<tr>
						<td colspan="3">Net Amount</td>
						<td>Rs {{$order->total_price}}</td>
					</tr>
				@else
				<tr>
					<td>1. </td>
					<td>
						Clothes being delivered	<br>					
							@foreach($items->where('status', 2) as $item)
								{{$item->quantity}} X {{ $item->item }}  @if($item->itemimage->count()) ({{ $item->itemimage->first()->addon_name}}) @endif<br>
							@endforeach
							<br>
							Total Pcs: {{$items->where('status', 2)->sum('quantity')}}
					</td>					
					<td>
						@if($items->where('status', 2)->count()!=0)
							@if($weight){{$weight}}@else -- @endif

						@else
						--
						@endif
					</td>
				
					<td>						
						--
					</td>
				</tr>
				<tr>
						<td>2. </td>
						<td>
							Pending Clothes	<br>			
							@foreach($items->where('status', '!=', 2) as $item)
								{{$item->quantity}} X {{ $item->item }}  @if($item->itemimage->count()) ({{ $item->itemimage->first()->addon_name}}) @endif<br>
							@endforeach
							<br>
							Total Pcs: {{$items->where('status','!=' , 2)->sum('quantity')}}
						</td>					
						<!-- <td>
							@if($weight){{$weight}}@else -- @endif
						</td> -->
					
						<td>						
							
						</td>
				</tr>
				<tr>
						
					<td colspan="3">Sub Total</td>
					<td> -- </td>
				</tr>
				
				<tr>
					
					<td colspan="3">SGST(9%)</td>
					<td> --</td>
				</tr>
				<tr>
					
					<td colspan="3">CGST(9%)</td>
					<td>--</td>
				</tr>

				<tr>
					
					<td colspan="3"> Discount </td>
					<td> --</td>
				</tr>

				<tr>
					
					<td colspan="3">Net Amount</td>
					<td>--</td>
				</tr>
				@endif
			</table>
		</div>
	</div>
</div>
</html>