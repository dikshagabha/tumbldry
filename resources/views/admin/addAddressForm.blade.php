<form action="{{route('admin.postAddAddress')}}" method="post" id="formAddress">
  <div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Address</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
       <input type="text" class="form-control" name="address" value=""/>
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
       <input type="text" name="pin" class="form-control" maxlength="10">
       
       <span class="error" id="pin_error"></span>
       <!-- <input type="text" class="form-control" name="pin" value=""/> -->
     </div>
   </div>
</div>
<div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Latitude</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
       <input type="text" class="form-control" name="latitude" value=""/>
       <span class="error" id="latitude_error"></span>
     </div>
   </div>
</div>
<div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Longitude</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
       <input type="text" class="form-control" name="longitude" value=""/>
       <span class="error" id="longitude_error"></span>
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
     <input type="hidden" class="form-control" name="location_id" id="location_id" value=""/>
</div>
@csrf
</form>
