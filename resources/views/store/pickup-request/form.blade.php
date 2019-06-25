<div class="card-body">
  <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
      
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Phone Number</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('phone_number',null,array('class' => 'form-control', "maxlength"=>20,
                                "id"=>'phone' )) !!}
                <span class="error" id="phone_number_error"></span>
               </div>

              <div class="col-md-2 col-lg-2 col-sm-2" style="display: none">
                   <button type="button" class="btn btn-detail" id="search-user" data-url = "{{route('store.findCustomer')}}"><i class="fa fa-search"></i></button>
              </div>
                <input type="hidden" name="customer_id" id="customer_id">
                <input type="hidden" name="address_id" id="address_id">
               
          </div>
        </div>
        <br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Name</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('name',null,array('class' => 'form-control', "maxlength"=>50, "id"=>'name')) !!}
                <span class="error" id="name_error"></span>
               </div>
          </div>
        </div>

        <br>

        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Email</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('email',null,array('class' => 'form-control', "maxlength"=>50, "id"=>'email')) !!}
                <span class="error" id="email_error"></span>
               </div>
          </div>
        </div>
<br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Service Intersted</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::select('service', $services, null,array('class' => 'form-control', "placeholder"=>"Select Service", "id"=>"service")) !!}
                <span class="error" id="service_error"></span>
               </div>
          </div>
        </div>
    <br>
    <div class="form-group-inner">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <label class="login2 pull-right pull-right-pro">Pickup Time</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
               <input type="text" id="picker" name="request_time" class="form-control" placeholder="Date">                 
               <span class="error" id="request_time_error"></span>
            </div>  
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
               <input type="text" id="picker_start" name="start_time" placeholder="From" class="form-control">                 
               <span class="error" id="start_time_error"></span>
            </div>
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
               <input type="text" id="picker_end" name="end_time" placeholder="To" class="form-control">                 
               <span class="error" id="start_time_error"></span>
            </div>  
        </div>
      </div>
      <br>

      <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Address</label>
               </div>
              <!--  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"> -->
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                  
                  <span id="address_form"></span>
                  <!--  {!! Form::text('address',null,array('class' => 'form-control',  "placeholder"=>"Address", "maxlength"=>50, "id"=>'address_form', 'readonly'=>true)) !!} -->

                  <span class="error" id="address_id_error"></span>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-2 select" style="display: none">
                  <button type="button" class="btn btn-warning" id="select_address"  data-url= "{{ route('store.getCustomerAddresses') }}" title="select Address"><i class="fa fa-home"></i> </button>                
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 add"  >
                  <button type="button" class="btn btn-warning" id="add_address"><i class="fa fa-plus"></i> </button>
                </div>
               <!-- </div> -->
          </div>
        </div>
        <br>
        
     
    </div>
  </div>
</div>

           