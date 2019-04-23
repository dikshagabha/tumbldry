<form action="{{route('admin.postEditAddress', ['id'=>$address->id])}}" method="post" id="formAddress">
  @csrf
<div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Address</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
       <input type="text" class="form-control" name="address" value="{{$address->address}}"/>
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
       <input type="text" class="form-control" name="city"  id="city" value="{{$address->city}}"/>
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
       <input type="text" class="form-control" name="state" value="{{$address->state}}" id="state"/>
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
       <input type="text" name="pin" class="form-control" maxlength="10" value="{{$address->pin}}">
       <!-- <select class="form-control" id="pinchange" data-url="{{route('getPinDetails')}}" placeholder="Select A Pin" name="pin">
         <option></option>
         @foreach($locations as $location)
         <option value="{{$location->pincode}}"> {{$location->pincode}}</option>
         @endforeach
       </select> -->
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
       <input type="text" class="form-control" name="latitude" value="{{$address->latitude}}"/>
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
       <input type="text" class="form-control" name="longitude" value="{{$address->longitude}}"/>
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
       <input type="text" class="form-control" name="landmark" value="{{$address->landmark}}"/>
       <span class="error" id="landmark_error"></span>
     </div>
   </div>
     <input type="hidden" class="form-control" name="location_id" id="location_id" value=""/>
</div>
</form>
