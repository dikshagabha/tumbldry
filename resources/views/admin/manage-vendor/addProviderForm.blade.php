<form action="{{route('admin.postAddSessionProviders')}}" method="post" id="formProvider">
  <div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6">
     <div class="form-group-inner">
      <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <label class="login2 pull-right pull-right-pro">Name</label>
         </div>
         <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
           <input type="text" class="form-control" name="vendor_name" value=""/>
           <span class="error" id="vendor_name_error"></span>
         </div>
       </div>
    </div>
     <div class="form-group-inner">
      <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <label class="login2 pull-right pull-right-pro">Phone Number</label>
         </div>
         <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
           <input type="text" class="form-control" name="vendor_phone_number"value=""/>
           <span class="error" id="vendor_phone_number_error"></span>
         </div>
       </div>
    </div>
     <div class="form-group-inner">
      <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <label class="login2 pull-right pull-right-pro">Email</label>
         </div>
         <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
           <input type="text" class="form-control" name="vendor_email" value=""/>
           <span class="error" id="vendor_email_error"></span>
         </div>
       </div>
    </div>
    <div class="form-group-inner">
      <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <label class="login2 pull-right pull-right-pro">Address</label>
         </div>
         <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
           <input type="text" class="form-control" name="vendor_address" id="address_provider" value=""/>
           <span class="error" id="vendor_address_error"></span>
         </div>
       </div>
    </div>
  <div class="form-group-inner">
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
         <label class="login2 pull-right pull-right-pro">City</label>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
         <input type="text" class="form-control" name="vendor_city"  id="city_provider" value=""/>
         <span class="error" id="vendor_city_error"></span>
       </div>
     </div>
  </div>
  <div class="form-group-inner">
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
         <label class="login2 pull-right pull-right-pro">State</label>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
         <input type="text" class="form-control" name="vendor_state" value="" id="state_provider"/>
         <span class="error" id="vendor_state_error"></span>
       </div>
     </div>
  </div>
  <div class="form-group-inner">
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
         <label class="login2 pull-right pull-right-pro">Pin</label>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
         <input type="text" name="vendor_pin" class="form-control"  id="pin_provider" maxlength="10">
         
         <span class="error" id="vendor_pin_error"></span>
       </div>
     </div>
  </div>
  <div class="form-group-inner">
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
         <label class="login2 pull-right pull-right-pro">Landmark</label>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
         <input type="text" class="form-control" name="landmark_provider" value=""/>
         <span class="error" id="vendor_landmark_error"></span>
       </div>
     </div>
  </div>
  </div> 
  <input type="hidden" name="vendor_latitude" id="latitude_provider">
  <input type="hidden" name="vendor_longitude" id="longitude_provider">
  <div class="col-sm-6 col-md-6 col-lg-6" id="map_provider" style="height:300px; margin: 0; padding: 0"> 
  </div>
  </div>

@csrf
</form>
