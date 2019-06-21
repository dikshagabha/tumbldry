
@if($user->items()->where('status', 2)->count() > 0 && $user->items()->where('status', 2)->count()< $user->items()->count() && $user->delivery_mode==2)
Assign Partial Delivery
@endif

@if($user->items()->where('status', 2)->count() == $user->items()->count() && $user->delivery_mode==2)
Assign Full Delivery
@endif

{{Form::open(["id"=>'deliveryForm', 'route'=>'store.order.assign-delivery'])}}
{{
	Form::select('runner_id', $runner, null,['class'=>'form-control', 'placeholder'=>'Select Runner'])
}}
{{Form::hidden('order_id', $id, ['id'=>'deliver_order_id'])}}
{{Form::close()}}