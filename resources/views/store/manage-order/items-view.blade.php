@php
$i=1;
@endphp
<hr>
@if(count($items))
<!-- <div class="row">
  	<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">	
	 -->

	 <table>
<tr>
	 <td width="60%" valign="top">	
	<table class="table table-borderless table-dark ">
			<tbody>
				<tr></tr>
			@foreach($items as $item)
 				<tr>
					<td width="40%">
						<strong>{{$item['item']}}</strong>
					</td>					
					<td width="10%">
							<input type="text" name="quantity" class="form-control quantityVal_{{$i}} quantity " 
						 		data-url = "{{route('store.quantityItemSession')}}" data-service = {{$item['service_id']}} data-id='{{$i}}' style="color: black;width: 44px;" 
						 value="{{$item['quantity']}}">
					</td>
					<td>
						<td>
							<input type="file" name="images[]" data-url = "{{route('store.filesItemSession')}}" multiple
								class="upload_image form-control" data-id="{{$i}}">	
								<span class="error" id="files_error"></span>
							@if($item['images'])
								@foreach($item['images'] as $image)
									<a class="group"  data-fancybox="fancy" href="{{asset('uploaded_images').'/'.$image}}">
										<img src="{{asset('uploaded_images').'/'.$image}}" alt="" width="50px" height="50px"  /></a>
								@endforeach
							@endif
						</td>
					</td>										
					<td>				
						<button type="button" class="btn btn-danger deleteItemBtn" action = "{{route('store.deleteItemSession')}}" data-add=@if($item['units']) 0 @else 1 @endif data-id="{{$i}}" title="Delete"><i class="fa fa-trash"></i></button>
					</td>

					@if(!$items[0]['units'])
					<td>
						@if($item['estimated_price'])
							{{$item['estimated_price']}} Rs
						@else
							N/A
						@endif
					</td>
					@endif
				</tr>
				@if(count($item['addons']))
					<tr>	
					<td colspan="5">	
					 <div id="addonForm{{$i}}" class="form">
							@foreach($item['addons'] as $addon)
									
									@if($item['units'])
									<input type="checkbox" id="{{$addon['name'].'_'.$addon->id.'_'.$i}}" 
									value="{{ $addon['id'] }}" name="addon{{$i}}[]"  class="addOn"
									data-url = "{{route('store.addonItemSession')}}" title="Add Addon" data-id='{{$i}}'


									@if($item['selected_addons'] && in_array( $addon['id'], $item['selected_addons']))

										checked

									@endif 
									>

									@else
									<input type="radio" id="{{$addon['name'].'_'.$addon->id.'_'.$i}}" 
									value="{{ $addon['id'] }}" name="addon{{$i}}[]"  class="addOn"
									data-url = "{{route('store.addonItemSession')}}" title="Add Addon" data-id='{{$i}}'								
									@if(in_array( $addon['id'], $item['selected_addons']))

										checked

									@endif 
									>
									@endif

									<label for="{{$addon['name'].'_'.$addon->id.'_'.$i}}">
										{{ $addon['name'] }}
									</label>
								
							@endforeach
							<input type="hidden" name="quantity" value="{{$item['quantity']}}">
							<input type="hidden" name="weight" value="{{$item['weight']}}">
							<input type="hidden" name="service" value="{{$item['service_id']}}">
							<input type="hidden" name="id" value="{{$i}}">
					 </div>
					</td>
				</tr>
				@endif
		@php
			$i++;
		@endphp
		@endforeach
		

			@if($items[0]['units'])
			 <div id="weightForm" class="form">
				<tr >
					<td >
						<input type="number" name="weight" class="weight_input" class="form-control" value="{{$items[0]['weight']}}"> 
					</td>
					<td>kg</td>
					<td colspan="2">
						<button type="button" class="btn btn-success weight" data-url = "{{route('store.weightItemSession')}}" 
						data-id="1" style="color:white" title="Add Weight"> 
						Add Weight
						</button>
					</td>
				</tr>	
			</div>
				@endif
			
		</tbody>
		</table>


			<span class="error" id="quantity_error"></span>
			<span class="error" id="addon_error"></span>

	</td>
	<td  valign="top">
	@if( $items[0]['weight'] )
		<div style="float: right">
			<table class="table-dark">
				<thead>
					<!-- <td width="50%"><h4>Item</h4></td>
					<td width="50%"><h4>Price</h4></td> -->
				</thead>
				<tr></tr>
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
					<td style="text-align: center;     width: 41%;" ><input type="text" name="coupon" id="coupon" class="form-control" value="{{$coupon_discount['coupon']}}" >
					<span class="error" id="coupon_error"></span></td>
					<td style="text-align: center;" ><button type="button" class="btn btn-danger" data-url="{{route('store.couponItemSession')}}" id="couponBtn">Apply</button></td>

				</tr>
				@if($coupon_discount['coupon'])
					<tr> <td colspan="3" style="text-align: center;"> Coupon Discount: {{$coupon_discount['discount']}} Rs</td></tr>
				@endif

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
					<td colspan="3" style="text-align: center;">
						TOTAL PRICE:
					
						@if($price_data['total_price'])
							{{$price_data['total_price']}}
						@else
							N/A
						@endif
					</td>
				</tr>
				 @if(isset($wallet['wallet']))
				<tr>
					<td colspan="3" style="text-align: center;">Customer Wallet: {{ $wallet['wallet']->price}} Rs</td>
				</tr>
				@endif 
				<tr >
					<td colspan="3" style="text-align: center;" ><button type="button" class="btn btn-warning" id="add_frenchise">Create Order</button></td>
				</tr>		
			</table>
		</div>
	@endif
</td>
</tr>
</table>
@else

@endif