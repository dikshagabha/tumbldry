@if(in_array($type->form_type, [1, 2]))
	<input type="text" name="item" autocomplete="on" placeholder="Search Item" class="form-control" id="item">
@else
	{{Form::select('item', $data, null, ['placeholder'=>'Select Type', 'class'=>'form-control', 'id'=>'item'])}}
@endif