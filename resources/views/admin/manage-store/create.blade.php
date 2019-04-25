@extends('admin.layout.app')
@section('title', 'Manage Store')

@section('content')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
  <style type="text/css">
    div[data-acc-content] { display: none;  }
  </style>
@endsection
<br>


<form action="{{route('manage-store.store')}}" method="post"  id="addFrenchise" enctype="multipart/form-data">
  @csrf
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
          <div class="all-form-element-inner">
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Name</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                     <input type="text" class="form-control" name="name"  value=""/>
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
                     <input type="text" class="form-control" name="email"  value=""/>
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
                    <input type="text" class="form-control" name="store_name"  value=""/>
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
                     <input type="text" class="form-control" name="phone_number"  value=""/>
                     <span class="error" id="phone_number_error"></span>
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
                 <button type="button" class="btn btn-primary next" data-id="1" data-url="{{route('admin.store.add', 1)}}">Next</button>
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
          Machines Information
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
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
                     <input type="text" class="form-control" name="machine_count" maxlength="5" value=""/>
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
                       <input type="text" class="form-control" name="machine_type" maxlength="50" value=""/>
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
                       <input type="text" class="form-control" name="boiler_count" maxlength="5" value=""/>
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
                       <input type="text" class="form-control" name="boiler_type" maxlength="50" value=""/>
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
                       <input type="text" class="form-control" name="iron_count" maxlength="5"  value=""/>
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
                 <button type="button" class="btn btn-primary next" data-id="2" data-url="{{route('admin.store.add', 2)}}">Next</button>
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
        <button class="btn  btn-default collapsed 3"  disabled type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Property Information
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
                <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                     <label class="login2 pull-right pull-right-pro">Property Type</label>
                   </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <input type="radio"  name="property_type" value="2" id="owned_property_type" />
                     <label for="owned_property_type"> Owned </label>

                     <input type="radio"  name="property_type" value="1" id="leased_property_type" />
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
                       <input type="text" class="form-control" name="store_size" maxlength="50" value=""/>
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
                       <input type="text" class="form-control" name="store_rent" maxlength="5" value=""/>
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
                       <input type="text" class="form-control" name="rent_enhacement" maxlength="5" value=""/>
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
                       <input type="text" class="form-control" name="rent_enhacement_percent" maxlength="5"  value=""/>
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
                       <input type="text" class="form-control" name="landlord_name" maxlength="50"  value=""/>
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
                       <input type="text" class="form-control" name="landlord_number" maxlength="15"  value=""/>
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
                 <button type="button" class="btn btn-primary next" data-id="3" data-url="{{route('admin.store.add', 3)}}">Next</button>
               </div>
              </div>
            </div>
          </div>
       </div>
     

  <div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-default collapsed 4" disabled type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Upload Documents
        </button>
      </h5>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
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
                 <button type="button" class="btn btn-primary next" data-id="4" data-url="{{route('admin.store.add', 4)}}">Next</button>
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
    <div class="card-header" id="headingFive">
      <h5 class="mb-0">
        <button class="btn  btn-default collapsed 5"  disabled type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
          Account Information
        </button>
      </h5>
    </div>
    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
      <div class="card-body">
            <div class="form-group-inner">
              <div class="row">
                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                      <label class="login2 pull-right pull-right-pro">Account Number</label>
                    </div>
                   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                       <input type="text" class="form-control" name="account_number" maxlength="50" value=""/>
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
                       <input type="text" class="form-control" name="bank_name" maxlength="5" value=""/>
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
                       <input type="text" class="form-control" name="branch_code" maxlength="50" value=""/>
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
                       <input type="text" class="form-control" name="ifsc_code" maxlength="50"  value=""/>
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
                       <input type="text" class="form-control" name="gst_number" maxlength="50"  value=""/>
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
                       <input type="text" class="form-control" name="pan_card_number" maxlength="15"  value=""/>
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
                       <input type="text" class="form-control" name="id_proof_number" maxlength="50"  value=""/>
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
                </div>
               <div class="col-lg-5 col-md-5 col-sm-5">
                 <button type="button" class="btn btn-primary" data-id="5" data-url="{{route('admin.store.add', 5)}}" id="add_frenchise">Save</button>
               </div>
              </div>
            </div>
          </div>
       </div>
</div>
</form>

<div id="addressModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Address</h4>
      </div>
      <div class="modal-body">
        <div id="addressForm">
          <form action="{{route('admin.postAddAddress')}}" method="post" class="addressForm" id="formAddress"></form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_new_address">Save</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.accordion-wizard.min.js')}}"></script>
<script>
$(document).ready(function(){


  function sendRequest(url, current){
    var form = $('#addFrenchise')[0];

    var data = new FormData(form);

    $.ajax({
      url: url,
      type:'post',
      data: data,
      enctype: 'multipart/form-data',
      processData: false,  // Important!
      contentType: false,
      
      success: function(data){
       
        console.log('.'+(current.data('id')+1));
        $('.'+(current.data('id')+1)).prop("disabled", false);
        $('.'+(current.data('id')+1)).trigger('click');
         $('body').waitMe('hide');
         current.hide();
      }  
      })   
  }

  $('input[type=radio][name=property_type]').change(function() {
    if (this.value == 1) {
        $(".lease_data").show()
    }
    else if (this.value == 2) {
         $(".lease_data").hide()
    }
});

  $(document).on('click', '.next', function(e){
    e.preventDefault(); 
    $(".error").html("")
    $('body').waitMe(); 
    sendRequest($(this).data('url'), $(this));
  })

  $(document).on('click', '#add_address', function(e){
    e.preventDefault();
    $('body').waitMe();
    $.ajax({
      url: $('#add_address').attr('data-url'),
      type:'get',
      //dataType:'HTML',
      success: function(data){
        console.log(data);
        $('#addressForm').html(data);
        //console.log($('#addressForm').html())
        
        $('body').waitMe('hide');
        $('#addressModal').modal('show');
        //$("#pinchange").chosen();
      },
      
    })
  })

  $(document).on('click', '#edit_address', function(e){
    e.preventDefault();
    $('body').waitMe();
    $.ajax({
      url: $('#edit_address').attr('data-url'),
      type:'get',
      //dataType:'html',
      success: function(data){
        $('#addressForm').html(data);
        $('body').waitMe('hide');
        $('#addressModal').modal('show');
      },
    })
  })

   $(document).on('click', '#add_new_address', function(e){
    e.preventDefault();
    $('body').waitMe();
    $(".error").html("")
    console.log($('#formAddress').attr('action'));
    $.ajax({
      url: $('#formAddress').attr('action'),
      type:'post',
      data: $('#formAddress').serializeArray(),
      dataType:'json',
      success: function(data){
        success(data.message);
        $('#formAddress')[0].reset();
        $('#addressModal').modal('hide');
        $('#add_address').hide();

        $('#added_address').html(data.address.address+', '+data.address.city+', '+data.address.state+', '+data.address.pin);
        $("#address_id").val(data.address.id);
        $('#edit_address').attr('data-url', data.url);
        $('#edit_address').show();
        $('body').waitMe('hide');

      }
    })
  })
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

  $(document).on('change', '#pinchange', function(e){
    e.preventDefault();
    $('body').waitMe();
    $.ajax({
      url: $('#pinchange').attr('data-url'),
      type:'get',
      data:{'id': $('#pinchange').val()},
      dataType:'json',
      success: function(data){
        $('#state').val(data.state);
        $('#city').val(data.city);
        $('#location_id').val(data.location_id);
        $('body').waitMe('hide');
      },
    })
  })

})
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=2&libraries=places&callback=initMap"
        async defer></script> -->

@endsection
