@php
$i=1;
@endphp
<hr>
@if(count($items))

<div class="row">
  	<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">	
		<table class="table table-borderless table-dark ">
			<!-- <thead>
				<td width="40%"><h3>Item</h3></td>
				<td colspan="2" width="20%"><h3>Quantity</h3></td>
				<td><h3>Action</h3></td>
			</thead> -->
			<tbody>
			@foreach($items as $item)
 				<tr>
					<td width="40%">
						<strong>{{$item['item']}}</strong>
					</td>					
					<td width="10%">
						<input type="text" name="quantity" class="form-control quantityVal_{{$i}} " 
						 value="{{$item['quantity']}}"  
						>
						</td>
						<td>
						<button type="button" class="btn btn-link quantity" data-url = "{{route('store.quantityItemSession')}}" data-id='{{$i}}'
						data-id="{{$i}}" style="color:white" title="Add Quantity"> 
						<i class="fa fa-refresh"></i>
						</button>
					</td>					
					<td>				
						<button type="button" class="btn btn-danger deleteItemBtn" action = "{{route('store.deleteItemSession')}}" data-add=@if($item['units']) 0 @else 1 @endif data-id="{{$i}}" title="Delete"><i class="fa fa-trash"></i></button>
					</td>
					<td>
						@if($item['estimated_price'])
							{{$item['estimated_price']}} Rs
						@else
							N/A
						@endif
					</td>
				</tr>
				@if($item['units'])
				<tr >
					<td >
						<input type="number" name="weight" class="weight_{{$i}} form-control" value="{{$item['weight']}}"> 
					</td>
					<td>kg</td>
					<td colspan="2">
						<button type="button" class="btn btn-success weight" data-url = "{{route('store.weightItemSession')}}" 
						data-id="{{$i}}" style="color:white" title="Add Weight"> 
						Add Weight
						</button>
					</td>
				</tr>	
				@endif
				@if(count($item['addons']))
					<tr>	
					<td colspan="5">	
					 <div id="addonForm{{$i}}" class="form">
							@foreach($item['addons'] as $addon)
									
									@if($item['units'])
									<input type="checkbox" id="{{$addon['name'].'_'.$addon->id.'_'.$i}}" 
									value="{{ $addon['id'] }}" name="addon{{$i}}[]" 									
									@if(in_array( $addon['id'], $item['selected_addons']))

										checked

									@endif 
									>

									@else
									<input type="radio" id="{{$addon['name'].'_'.$addon->id.'_'.$i}}" 
									value="{{ $addon['id'] }}" name="addon{{$i}}[]" 									
									@if(in_array( $addon['id'], $item['selected_addons']))

										checked

									@endif 
									>
									@endif

									<label for="{{$addon['name'].'_'.$addon->id.'_'.$i}}">{{ $addon['name'] }}
									</label>
								
							@endforeach
							<input type="hidden" name="quantity" value="{{$item['quantity']}}">
							<input type="hidden" name="weight" value="{{$item['weight']}}">
							<input type="hidden" name="service" value="{{$item['service_id']}}">
							<input type="hidden" name="id" value="{{$i}}">

							<button type="button" class="btn btn-link addOn" data-url = "{{route('store.addonItemSession')}}" title="Add Addon" data-id='{{$i}}'
							data-id="{{$i}}" style="color:white"> 
								<i class="fa fa-refresh"></i>
							</button>


					 </div>
					</td>

					</tr>
					

				@endif

			</tbody>

		@php
		$i++;
		@endphp
		@endforeach
		</table>


			<span class="error" id="quantity_error"></span>
			<span class="error" id="addon_error"></span>
	</div>

	<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
		<table class="table-dark">
			<thead>
				<!-- <td width="50%"><h4>Item</h4></td>
				<td width="50%"><h4>Price</h4></td> -->
			</thead>
			<tr>
				<td style="text-align: center;" colspan="2"><strong>Price</strong></td>
				<td style="text-align: center;">@if($price_data['estimated_price'])
									{{$price_data['estimated_price']}} Rs
								@else
									N/A
								@endif
				</td>
			</tr>
			<tr>
				<td style="text-align: center;"  colspan="2">
					CGST (9%)
				</td>
				<td style="text-align: center;" >
					{{ $price_data['cgst'] }}
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;" >
					GST (9%)
				</td>
				<td style="text-align: center;" >
					{{ $price_data['gst'] }}
				</td>
			</tr>
			<tr >
				<td style="text-align: center;" >Coupon</td>
				<td style="text-align: center;" ><input type="text" name="coupon" id="coupon" class="form-control" value="{{$coupon_discount['coupon']}}">
				<span class="error" id="coupon_error"></span></td>
				<td style="text-align: center;" ><button type="button" class="btn btn-danger" data-url="{{route('store.couponItemSession')}}" id="couponBtn">Apply</button></td>

			</tr>	

			<tr >
				<td style="text-align: center;" >Discount</td>
				<td style="text-align: center;" >
					<input type="text" name="discount" id="discount" class="form-control" value="{{$coupon_discount['user_discount']}}">
					<span class="error" id="discount_error"></span>
			    </td>
				 <td style="text-align: center;" ><button type="button" class="btn btn-danger" data-url="{{route('store.discountItemSession')}}" id="discountBtn">Apply</button>
				 </td>
			</tr>
			<tr >
				<td colspan="2" style="text-align: center;">
					TOTAL PRICE
				</td>
				<td style="text-align: center;">

					@if($price_data['total_price'])
						{{$price_data['total_price']}}
					@else
						N/A
					@endif
				</td>
			</tr>
			@if($wallet)
			<tr>
				<td colspan="2">Customer Wallet</td><td>{{$wallet['wallet']->price}} Rs</td> 
			</tr>
			@endif
			<tr >
				<br>
				<td colspan="3" style="text-align: center;" >
					<button type="button" class="btn btn-warning" id="add_frenchise">Create Order</button></td>
			</tr>		
		</table>
	</div>
</div>
@else

@endif