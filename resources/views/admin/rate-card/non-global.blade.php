<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="form-group-inner">
    @php
      $operator=$bsp=null;
    @endphp

      <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
        </div>
           <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
              <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Base Price Variance (%)</label>
               </div>

               @php
              if(isset($prices))
                {
                if($prices->count())
                {  
                 $bsp= $prices->first()->bsp;
                 $operator= $prices->first()->operator;
                }
              }

            @endphp

              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  {{ Form::select('operator', ['0'=>'-', '1'=>'+'], $operator,['class' => 'form-control']) }}
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                  
                  {!! Form::text('bsp',$bsp,array('class' => 'form-control')) !!}
                </div>
                  
                  <span class="error" id="bsp_error"></span>
             </div>
           </div>

           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
              
             <button type="submit" id="save" class="btn btn-success save">Save</button>        
           
           </div>
           </div>
    </div>
    
      @include('admin.rates-table')
    
</div>