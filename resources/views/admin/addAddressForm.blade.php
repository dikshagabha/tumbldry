<form action="{{route('admin.setSessionAddresses')}}" method="post" id="formAddress">
  <div class="row">
  <div class="col-sm-6 col-md-6 col-lg-6">
    <div class="form-group-inner">
      <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <label class="login2 pull-right pull-right-pro">Address</label>
         </div>
         <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
           <input type="text" class="form-control" name="address" id="address" value=""/>
           <span class="error" id="address_error"></span>
         </div>
       </div>
    </div>
  <div class="form-group-inner">
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
         <label class="login2 pull-right pull-right-pro">City</label>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
         <input type="text" class="form-control" name="city"  id="city" value=""/>
         <span class="error" id="city_error"></span>
       </div>
     </div>
  </div>
  <div class="form-group-inner">
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
         <label class="login2 pull-right pull-right-pro">State</label>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
         <input type="text" class="form-control" name="state" value="" id="state"/>
         <span class="error" id="state_error"></span>
       </div>
     </div>
  </div>
  <div class="form-group-inner">
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
         <label class="login2 pull-right pull-right-pro">Pin</label>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
         <input type="text" name="pin" class="form-control"  id="pin" maxlength="10">
         
         <span class="error" id="pin_error"></span>
         <!-- <input type="text" class="form-control" name="pin" value=""/> -->
       </div>
     </div>
  </div>
  <div class="form-group-inner">
    <div class="row">
       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
         <label class="login2 pull-right pull-right-pro">Landmark</label>
       </div>
       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
         <input type="text" class="form-control" name="landmark" value=""/>
         <span class="error" id="landmark_error"></span>
       </div>
     </div>
       <input type="hidden" class="form-control" name="latitude" id="latitude" value=""/>
       <input type="hidden" class="form-control" name="longitude" id="longitude" value=""/>
  </div>
  </div> 

  <div class="col-sm-6 col-md-6 col-lg-6" id="map" style="height:200px; margin: 0; padding: 0"> 
  </div>
  </div>

@csrf
</form>
