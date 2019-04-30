<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="form-group-inner">
    <div class="price_wrap">
      @php
      $quantity=$pri="";
      @endphp

      @foreach($items  as $item)
       <div class="row">
          <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">

             <label class="login2 pull-right pull-right-pro"></label>
          </div>
          <div class="col-lg-32 col-md-3 col-sm-3 col-xs-3">
            <span class="form-control">{{$item->name}}</span>
            <input type="hidden" class="form-control" name="parameter[]"  value="{{$item->id}}" placeholder="Parameter"/>
          
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            @php
              if(isset($prices))
                {
                $prev = $prices->where('parameter', $item->id);
                if($prev->count())
                {  
                  $quantity= $prev->first()->quantity;
                  $pri= $prev->first()->value;
                }
              }

            @endphp
            <input type="text" class="form-control" name="quantity[]"  value="{{$quantity}}" placeholder="Quantity"/>
              
          </div>
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" class="form-control" name="price[]"  value="{{$pri}}" placeholder="Price(Rs)"/>            
             </div>             
          </div>
      @endforeach
       </div>
       <br>
       <div class="row">
          <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">

             <label class="login2 pull-right pull-right-pro"></label>
          </div>
          

      {{ $items->links() }}
       
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

           <label class="login2 pull-right pull-right-pro"></label>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
          <span class="error" id="parameter_error"></span>  
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
          <span class="error" id="quantity_error"></span>   
        </div>
           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
             <span class="error" id="price_error"></span>  
           </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
              
           </div>
      </div>
      <br>
      <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
              
               <button type="submit" id="save" class="btn btn-success save">Save</button>        
           
            </div>
      </div>
     
   

</div>