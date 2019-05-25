
@if($address)
	
	@foreach($address as $add)
	<a href="#" class="table-modal address" data-id="{{$add->id}}" data-value="{{$add->address}}">{{$add->address}}</a>
	<br>
	@endforeach
@endif