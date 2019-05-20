
  <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
      
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Phone Number</label>
               </div>
               <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                
              		{!! Form::text('phone_number',null, array('class' => 'form-control', "maxlength"=>20,
                                              "id"=>'phone')) !!}
                <span class="error" id="phone_number_error"></span>
              </div>                
              <div class="col-md-2 col-lg-2 col-sm-2">
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
                {!! Form::text('name', null ,array('class' => 'form-control', "maxlength"=>50, "id"=>'name')) !!}
                <span class="error" id="name_error"></span>
               </div>
          </div>
        </div>
        <br>

        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Address</label>
               </div>
               <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                  
                  <span id="address"></span> <span id="city"></span>
                  <span id="state"></span> <span id="pin"></span>

                  <input type="hidden" name="address_id">
                  <span class="error" id="address_id_error"></span>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <button type="button" class="btn btn-warning" id="add_address"><i class="fa fa-plus"></i> </button>
                </div>
                  
               </div>
          </div>
        <br>


        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Service</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                 {{ Form::select("service", $services, null, ['class'=>'form-control', 'id'=>'service', 'placeholder'=>'Select Service' ,'data-url'=>route('store.get-items')])}}
                <span class="error" id="service_error"></span>
               </div>
          </div>
        </div>


        <br>
       <!--  <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Address</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     {!! Form::text('address', null, array('class' => 'form-control', 'maxlength'=>"50", 'id'=>"address", "placeholder"=>"Address")) !!}
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
                     {!! Form::text('city',null,array('class' => 'form-control', 'maxlength'=>"50", 'id'=>"city", "placeholder"=>"City")) !!}
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
                       
                     {!! Form::text('state',null,array('class' => 'form-control', 'maxlength'=>"50", 'id'=>"state", "placeholder"=>"State")) !!}
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
                       
                     {!! Form::text('pin',null,array('class' => 'form-control', 'maxlength'=>"6", 'id'=>"pin", "placeholder"=>"Pin")) !!}
                      <span class="error" id="pin_error"></span>
                    </div>
                    
                  </div>
            </div>
            <div class="form-group-inner" style="display: none">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                      <label class="login2 pull-right pull-right-pro">Latitude</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('latitude',null,array('class' => 'form-control', 'maxlength'=>"10", 'id'=>"latitude", "placeholder"=>"Latitude")) !!}
                      <span class="error" id="latitude_error"></span>
                    </div>
                    
                  </div>
            </div>
            <div class="form-group-inner" style="display: none">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Longitude</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('longitude',null,array('class' => 'form-control', 'maxlength'=>"10", 'id'=>"longitude", "placeholder"=>"Longitude")) !!}
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
                       
                     {!! Form::textarea('landmark',null,array('class' => 'form-control', 'maxlength'=>"200", 'id'=>"landmark", "placeholder"=>"Landmark")) !!}
                      <span class="error" id="landmark_error"></span>
                    </div>
                    
                  </div>
            </div> -->

            <br>

         <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                 <!-- <label class="login2 pull-right pull-right-pro">Search Item</label> -->
               </div>
               
               <!-- <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"> -->
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-82">
                 <!-- {!! Form::text('item',null,array('class' => 'form-control', "maxlength"=>50, "id"=>'item', 'placeholder'=>'Search Item')) !!} -->
                <input type="text" name="item" autocomplete="on" placeholder="Search Item" class="form-control" id="item">
                <!-- <div class="typeahead__container">
                    <div class="typeahead__field">
                        <div class="typeahead__query">
                            <input class="js-typeahead-country_v1" name="item" type="search" name="item" placeholder="Search Item" id="item" autocomplete="on">
                        </div>
                       
                    </div>
                </div> -->
                 <span class="error" id="item_error"></span>
                 </div>
                 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <a href="{{route('store.addItemSession')}}" id="add_item"><button type="button" class="btn btn-success"> <i class="fa fa-plus"></i> </button></a>
                <!-- {!! Form::Submit('<i class="fa fa-search"></i>',array('class' => 'btn btn-succes', "maxlength"=>50, "id"=>'item')) !!} -->
                </div>
               </div>
               


               
          <!-- </div> -->

        </div>


    </div>
  </div>


           
