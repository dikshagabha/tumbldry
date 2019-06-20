@extends('store.layout-new.app')

@section('title', 'Change Password')

@section('content')

 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <a href="{{ route('store.home') }}" id="back"> 
          <vs-button color="danger" type="border" icon="arrow_back"></vs-button></a>
       </div>
       <br>
       <br>
{{ Form::model($user, ['route'=> 'store.edit-profile' , 'method'=>'put', 'id'=>'addFrenchise','images'=>true]) }}
<!-- 
{{Form::open(['route'=>'store.edit-profile', 'id'=>'loginForm', 'method'=>'post'])}} -->
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Basic Information
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="row">
           <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
          <div class="">
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Name</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    {!! Form::text('name',null,array('class' => 'form-control')) !!}
                    <!--  <input type="text" class="form-control" name="name"  /> -->
                     <span class="error" id="name_error"></span>
                   </div>
                 </div>
            </div>

            
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Email</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                      {!! Form::text('email',null,array('class' => 'form-control')) !!}
                     <span class="error" id="email_error"></span>
                   </div>
                 </div>
            </div>

            <div class="form-group-inner">
             <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label class="login2 pull-right pull-right-pro">Store Name</label>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     {!! Form::text('store_name',null,array('class' => 'form-control')) !!}
                    <span class="error" id="store_name_error"></span>
                  </div>
                </div>
            </div>

            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Phone Number</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     {!! Form::text('phone_number',null,array('class' => 'form-control')) !!}
                     <span class="error" id="phone_number_error"></span>
                   </div>
                 </div>
            </div>

            <div class="">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Frenchise</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     {{Form::select('user_id', $users, null, ['id'=>'parent','placeholder'=>'Select a Frenchise', 'class' => 'form-control'])}}
                     <span class="error" id="user_id_error"></span>
                   </div>
                 </div>
            </div>
            
            <br>
           <div class="form-group-inner">
             <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                 <!-- <button type="button" class="btn btn-primary next" data-id="1" data-url="{{route('admin.store.add', 1)}}">Next</button> -->
               </div>
              </div>
            </div>
          </div>
       </div>
     </div>
    </div>
  </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-default collapsed 2" disabled type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Address Information
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
         <div class="row">
           <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
          <div class="all-form-element-inner">
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Address</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     {!! Form::text('address', null, array('class' => 'form-control', 'maxlength'=>"50")) !!}
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
                     {!! Form::text('city',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
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
                       
                     {!! Form::text('state',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
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
                       
                     {!! Form::text('pin',null,array('class' => 'form-control', 'maxlength'=>"6")) !!}
                      <span class="error" id="pin_error"></span>
                    </div>
                    
                  </div>
            </div>
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Latitude</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('latitude',null,array('class' => 'form-control', 'maxlength'=>"10")) !!}
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
                       
                     {!! Form::text('longitude',null,array('class' => 'form-control', 'maxlength'=>"10")) !!}
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
                       
                     {!! Form::text('landmark',null,array('class' => 'form-control', 'maxlength'=>"200")) !!}
                      <span class="error" id="landmark_error"></span>
                    </div>
                    
                  </div>
            </div>
          
            <br>
           <div class="form-group-inner">
             <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                 <!-- <button type="button" class="btn btn-primary next" data-id="2" data-url="{{route('admin.store.add', 2)}}">Next</button> -->
               </div>
              </div>
            </div>
          </div>
       </div>
     </div>
       </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-default collapsed 3" disabled type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Machines Information
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
         <div class="row">
           <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
          <div class="all-form-element-inner">
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Count of Machines</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     {!! Form::text('machine_count', null, array('class' => 'form-control', 'maxlength'=>"5")) !!}
                     <span class="error" id="machine_count_error"></span>
                   </div>
                 </div>
            </div>
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Type of Machines</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">

                    {{Form::select('machine_type', $machines, null, ['id'=>'parent','placeholder'=>'Select a Machine Type', 'class' => 'form-control'])}}
                     <span class="error" id="machine_type_error"></span>
                    </div>
                 </div>
            </div>

            <div class="form-group-inner">
               <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Count of Boiler</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('boiler_count',null,array('class' => 'form-control', 'maxlength'=>"5")) !!}
                      <span class="error" id="boiler_count_error"></span>
                    </div>
                    
                  </div>
            </div>

            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Type of Boiler</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                      
                      {{Form::select('boiler_type', $boiler, null, ['id'=>'parent','placeholder'=>'Select a Boiler Type', 'class' => 'form-control'])}}
                     
                      <span class="error" id="boiler_type_error"></span>
                    </div>
                    
                  </div>
            </div>
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Count of Ironing Table</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('iron_count',null,array('class' => 'form-control', 'maxlength'=>"5")) !!}
                      <span class="error" id="iron_count_error"></span>
                    </div>
                    
                  </div>
            </div>
            

          
            <br>
           <div class="form-group-inner">
             <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                 <!-- <button type="button" class="btn btn-primary next" data-id="3" data-url="{{route('admin.store.add', 3)}}">Next</button> -->
               </div>
              </div>
            </div>
          </div>
       </div>
     </div>
       </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn  btn-default collapsed 4"  disabled type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Property Information
        </button>
      </h5>
    </div>
    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">
                <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Property Type</label>
                   </div>
                   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">

                    {!! Form::radio('property_type', '2', (isset($user) && $user->property_type==2)? true: false, ['id'=>'owned_property_type']) !!}
                    
                     <label for="owned_property_type"> Owned </label>
                     {!! Form::radio('property_type', '1', (isset($user) && $user->property_type==1)? true: false, ['id'=>'leased_property_type']) !!}
                     <label for="leased_property_type"> Leased </label>
                     
                     <span class="error" id="property_type_error"></span>
                   </div>
                 </div>


            </div>
            <div class="lease_data" style="display: none">
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Store Size</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('store_size',null,array('class' => 'form-control', 'maxlength'=>"5")) !!}
                      <span class="error" id="store_size_error"></span>
                    </div>
                 </div>
            </div>

            <div class="form-group-inner">
               <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Store Rent</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('store_rent',null,array('class' => 'form-control', 'maxlength'=>"5")) !!}
                      <span class="error" id="store_rent_error"></span>
                    </div>
                    
                  </div>
            </div>

            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Rent Enhacement Period</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('rent_enhacement',null,array('class' => 'form-control', 'maxlength'=>"5")) !!}
                      <span class="error" id="rent_enhacement_error"></span>
                    </div>
                    
                  </div>
            </div>
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Rent Enhacement Percent</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('rent_enhacement_percent',null,array('class' => 'form-control', 'maxlength'=>"5")) !!}
                      <span class="error" id="rent_enhacement_percent_error"></span>
                    </div>
                    
                  </div>
            </div>  
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Landlord Name</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('landlord_name',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
                      <span class="error" id="landlord_name_error"></span>
                    </div>
                    
                  </div>
            </div>  
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Landlord Number</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       
                     {!! Form::text('landlord_number',null,array('class' => 'form-control', 'maxlength'=>"5")) !!}
                      <span class="error" id="landlord_number_error"></span>
                    </div>
                    
                  </div>
            </div> 
            </div>         
            <br>
           <div class="form-group-inner">
             <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                 <!-- <button type="button" class="btn btn-primary next" data-id="4" data-url="{{route('admin.store.add', 4)}}">Next</button> -->
               </div>
              </div>
            </div>
          </div>
       </div>
     

  <div class="card">
    <div class="card-header" id="headingFive">
      <h5 class="mb-0">
        <button class="btn btn-default collapsed 5" disabled type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
          Upload Documents
        </button>
      </h5>
    </div>
    <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordionExample">
      <div class="card-body">
         <div class="row">
           <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
          <div class="all-form-element-inner">
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Address Proof</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="address_proof" value=""/>
                     <span class="error" id="address_proof_error"></span>
                   </div>
                 </div>
            </div>

             <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">GST Certificate</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="gst_certificate" value=""/>
                     <span class="error" id="gst_certificate_error"></span>
                   </div>
                 </div>
            </div>
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Bank Passbook</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="bank_passbook" value=""/>
                     <span class="error" id="bank_passbook_error"></span>
                   </div>
                 </div>
            </div>
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Cancelled Cheque</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="cheque" value=""/>
                     <span class="error" id="cheque_error"></span>
                   </div>
                 </div>
            </div>
              <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Pan Card</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="pan" value=""/>
                     <span class="error" id="pan_error"></span>
                   </div>
                 </div>
            </div>
             <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">ID Proof</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="id_proof" value=""/>
                     <span class="error" id="id_proof_error"></span>
                   </div>
                 </div>
            </div>

            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">LOI Copy</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="loi_copy" value=""/>
                     <span class="error" id="loi_copy_error"></span>
                   </div>
                 </div>
            </div>

            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Agreement Copy</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="agreement_copy" value=""/>
                     <span class="error" id="agreement_copy_error"></span>
                   </div>
                 </div>
            </div>

            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Franchisee Fees Cheque/Transaction Details</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="transaction_details" value=""/>
                     <span class="error" id="transaction_details_error"></span>
                   </div>
                 </div>
            </div>

            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Rent Agreement/Registry Copy</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="rent_agreement" value=""/>
                     <span class="error" id="rent_agreement_error"></span>
                   </div>
                 </div>
            </div>

            <!-- <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Store</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="file" class="form-control" name="id_proof" value=""/>
                     <span class="error" id="id_proof_error"></span>
                   </div>
                 </div>
            </div> -->
            <br>
           <div class="form-group-inner">
             <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                 <!-- <button type="button" class="btn btn-primary next" data-id="5" data-url="{{route('admin.store.add', 5)}}">Next</button> -->
               </div>
              </div>
            </div>
          </div>
       </div>
     </div>
       </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingSix">
      <h5 class="mb-0">
        <button class="btn  btn-default collapsed 6"  disabled type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
          Account Information
        </button>
      </h5>
    </div>
    <div id="collapseSix" class="collapse show" aria-labelledby="headingSix" data-parent="#accordionExample">
      <div class="card-body">
        <div class="row">
           <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
          <div class="all-form-element-inner">
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Account Number</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                       
                     {!! Form::text('account_number',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
                      <span class="error" id="account_number_error"></span>
                    </div>
                 </div>
            </div>

            <div class="form-group-inner">
               <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Bank Name</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       {!! Form::text('bank_name',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
                     
                      <span class="error" id="bank_name_error"></span>
                    </div>
                    
                  </div>
            </div>

            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Branch Code</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       {!! Form::text('branch_code',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
                     
                      <span class="error" id="branch_code_error"></span>
                    </div>
                    
                  </div>
            </div>
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">IFSC Code</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       {!! Form::text('ifsc_code',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
                     
                      <span class="error" id="ifsc_code_error"></span>
                    </div>
                    
                  </div>
            </div>  
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">GST Number</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        {!! Form::text('gst_number',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
                     
                      <span class="error" id="gst_number_error"></span>
                    </div>
                    
                  </div>
            </div>  
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">PAN Card Number</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     {!! Form::text('pan_card_number',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
                     
                      <span class="error" id="pan_card_number_error"></span>
                    </div>
                    
                  </div>
            </div> 
            <div class="form-group-inner">
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">ID Proof Number</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       {!! Form::text('id_proof_number',null,array('class' => 'form-control', 'maxlength'=>"50")) !!}
                     <span class="error" id="id_proof_number_error"></span>
                    </div>
                    
                  </div>
            </div>         
            <br>
           <div class="form-group-inner">
             <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3">
               </div>
               <div class="col-lg-3 col-md-3 col-sm-3">
                <!-- <a href="{{route('manage-store.index')}}">
                  <button type="button" class="btn btn-default" data-id="5" data-url="{{route('admin.store.add', 5)}}">Cancel</button>
                </a> -->
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                 <button type="button" class="btn btn-primary" data-id="6" data-url="{{route('admin.store.add', 6)}}" id="add_frenchise">Save</button>
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
          </div>
       </div>
</div>

{{Form::close()}}
@endsection
@push('js')
<script type="text/javascript">
	
	$(document).ready(function(){
    if ($('#leased_property_type').attr("checked") == 'checked') {
      $(".lease_data").show()
    }
    $('input[type=radio][name=property_type]').change(function() {
      if (this.value == 1) {
          $(".lease_data").show()
      }
      else if (this.value == 2) {
           $(".lease_data").hide()
      }
    });

     $(document).on('click', '#add_frenchise', function(e){
        e.preventDefault();
        $('body').waitMe();

        var form = $('#addFrenchise')[0];

        var data = new FormData(form);

        console.log(data.values())
        $(".error").html("");
        $.ajax({
          url: $('#addFrenchise').attr('action'),
          type:'post',
          data: data,
          cache: false,
          processData: false,  
          contentType: false,      
          success: function(data){
            success(data.message);
            //window.location=data.redirectTo;
            $('body').waitMe('hide');
          }
        })
      })


		$(document).on('click','#back',function(e){
      e.preventDefault();
      $('.error').html("");
      window.location = $(this).attr('href');
    });

	});
</script>
@endpush