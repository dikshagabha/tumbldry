@php
$i=1;
@endphp
@foreach($items as $item)
 
  <div class="row">



  	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> <h3>Item {{$i}}</h3></div>
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
		
		<table class="table">
			<tr>
				<td>
				</td>
				<td>
				
					<button type="button" class="btn btn-danger deleteItemBtn" action = "{{route('store.deleteItemSession')}}" data-id="{{$i}}"><i class="fa fa-trash"></i></button>
				</td>
			</tr>
			
			<tr>
				<td>Service</td>
				<td>{{$item['service_name']}}</td>
			</tr>
			<tr>
				<td>item</td>
				<td>{{$item['item']}}</td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td>{{$item['quantity']}}</td>
			</tr>
			<tr>
				<td>Images</td>
				<td>@isset($item['images'])
						@foreach($item['images'] as $image)
						<a data-fancybox="gallery" href="{{asset('/uploaded_images/order/'.$image)}}"><img src="{{asset('/uploaded_images/order/'.$image)}}" width="100px" height="100px">
						</a>
						@endforeach
					@else
					---
					@endif</td>
			</tr>

			
		</table>
	</div>
</div>
@php
$i++
@endphp
@endforeach