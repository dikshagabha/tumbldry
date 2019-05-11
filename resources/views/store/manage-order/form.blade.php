
  <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
      
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Phone Number</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('phone_number',$pickup->customer_phone,array('class' => 'form-control', "maxlength"=>20,
                                "id"=>'phone', 'readonly'=>true)) !!}
                <span class="error" id="phone_number_error"></span>
               </div>
               <!-- <button type="button" class="btn btn-detail" id="search-user" data-url = "{{route('admin.findCustomer')}}"><i class="fa fa-search"></i></button> -->
                  <input type="hidden" name="customer_id" id="customer_id">
                  <input type="hidden" name="address_id" id="address_id">
          </div>
        </div>

        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Name</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('name',$pickup->customer_name,array('class' => 'form-control', "maxlength"=>50, "id"=>'name', 'readonly'=>true)) !!}
                <span class="error" id="name_error"></span>
               </div>
          </div>
        </div>
        <br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                {!! Form::Button('Add Item', array('class' => 'btn btn-danger', 'id'=>'add_item')) !!}
                <input type="hidden" name="item" id="item" value=0>
                <span class="error" id="item_error"></span>
               </div>
          </div>
        </div>


    </div>
  </div>


           