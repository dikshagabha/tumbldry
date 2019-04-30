<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  

  <div class="form-group-inner">
      <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
        </div>
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

            {{ Form::select('city',  $cities, 'global',['class' => 'form-control', 'placeholder' => 'Select City',
            'id' => 'select-city',  'maxlength'=>'50', 'data-url'=>route('admin.getRateCardForm')]) }}
            <span class="error" id="city_error"></span>
           </div>
           
           @if($services->count())
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
              {{ Form::select('service', $services, $selected, ['class' => 'form-control', 'id' => 'select-service', 'placeholder'=>'Select Service']) }}
              <span class="error" id="service_error"></span>
               
             </div>
           @endif
           {{Form:: hidden("type", $type)}}
         </div>
    </div>

</div>
