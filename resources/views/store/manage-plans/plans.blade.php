
@if($plans->count())
	<table class="table table-responsive">

	@foreach($plans as $plan)
		<tr>
			<td>
				<label for="plan_{{$plan->id}}">{{$plan->name}}</label>
			</td>
			<td>
				<label for="plan_{{$plan->id}}">{{$plan->description}}</label>
			</td>
			<td>
				<label for="plan_{{$plan->id}}">Price: {{$plan->price}} Rs</label>
			</td>

			<td>
				<input type="radio" name="plan" id="plan_{{$plan->id}}" value="{{$plan->id}}">
			</td>

		</tr>
	@endforeach
	</table>
@endif