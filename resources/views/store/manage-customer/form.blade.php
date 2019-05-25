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
                                "id"=>'phone',  "placeholder"=>"Phone Number")) !!}
                <span class="error" id="phone_number_error"></span>
                
               </div>

               
          </div>
        </div>
        <br>
        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Name</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('name',null,array('class' => 'form-control', "placeholder"=>"Name", "maxlength"=>50, "id"=>'name')) !!}
                <span class="error" id="name_error"></span>
               </div>
          </div>
        </div><br>

        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Email</label>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('email',null,array('class' => 'form-control',  "placeholder"=>"Email", "maxlength"=>50, "id"=>'email')) !!}
                <span class="error" id="email_error"></span>
               </div>
          </div>
        </div><br>

        <div class="form-group-inner">
          <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                 <label class="login2 pull-right pull-right-pro">Address</label>
               </div>
              <!--  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9"> -->
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                  
                  <div id="address_form">
                    
                    @if(isset($user) && $user->customer_addresses)
                      @php
                      $i=1;
                      @endphp
                      <table class="table table-bordered">
                        @foreach($user->customer_addresses as $address)
                        <tr>
                          <td class="table-modal">{{$address['address']}}</td>
                          <td class="table-modal">
                            <button class="btn btn-danger deleteItemBtn" data-url = "{{route('store.deleteCustomerAddresses')}}" data-id="{{$i}}" title="Delete"><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                        @php
                        $i++;
                        @endphp
                        @endforeach
                      </table>
                    @endif
                  </div>
                   <!-- {!! Form::text('address',null,array('class' => 'form-control',  "placeholder"=>"Address", "maxlength"=>50, "id"=>'address_form', 'readonly'=>true)) !!} -->

                  <span class="error" id="address_id_error"></span>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <button type="button" class="btn btn-warning" id="add_address"><i class="fa fa-plus"></i> </button>
                </div>
                <span class="error" id="email_error"></span>
               <!-- </div> -->
          </div>
        </div>

        <!-- <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Address</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     {!! Form::text('address', null, array('class' => 'form-control', 'maxlength'=>"50", 'id'=>"address", "placeholder"=>"Address")) !!}
                     <span class="error" id="address_error"></span>
                   </div>
                 </div>
            </div><br>
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
            </div><br>

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
            </div><br>

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
            </div><br>
            <div class="form-group-inner" style="display:none">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Latitude</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('latitude',null,array('class' => 'form-control', 'maxlength'=>"10", 'id'=>"latitude", "placeholder"=>"Latitude")) !!}
                      <span class="error" id="latitude_error"></span>
                    </div>
                    
                  </div>
            </div><br>
            <div class="form-group-inner" style="display:none">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Longitude</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('longitude',null,array('class' => 'form-control', 'maxlength'=>"10", 'id'=>"longitude", "placeholder"=>"Longitude")) !!}
                      <span class="error" id="longitude_error"></span>
                    </div>
                  </div>
            </div><br>
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Landmark</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('landmark',null,array('class' => 'form-control', 'maxlength'=>"200", 'id'=>"landmark", "placeholder"=>"Landmark")) !!}
                      <span class="error" id="landmark_error"></span>
                    </div>
                    
                  </div>
            </div><br>

    </div> -->
    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

      <div id="map" style="height:400px">

    </div> -->
  </div>
</div>
</div>
