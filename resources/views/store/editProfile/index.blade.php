@extends('store.layout.app')
@section('title', 'Edit Profile')
@section('content')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="admintab-wrap edu-tab1 mg-t-30">
            <ul class="nav nav-tabs custom-menu-wrap custon-tab-menu-style1">
                <li class="active"><a data-toggle="tab" href="#TabProject"><span class="edu-icon edu-analytics tab-custon-ic"></span>Basic Information</a>
                </li>
                <li><a data-toggle="tab" href="#TabDetails"><span class="edu-icon edu-analytics-arrow tab-custon-ic"></span>Change Password</a>
                </li>
                <li><a data-toggle="tab" href="#TabPlan"><span class="edu-icon edu-analytics-bridge tab-custon-ic"></span>Change Profile Image</a>
                </li>
            </ul>
            <div class="tab-content">
              <div id="TabProject" class="tab-pane in active animated  custon-tab-style1">
                <br>
                <form action="{{route('store.postEditProfile')}}" method="post" id="basicInfo">
                  @csrf
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <div class="all-form-element-inner">
                    <div class="form-group-inner">
                      <div class="row">
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                             <label class="login2 pull-right pull-right-pro">Name</label>
                           </div>
                           <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                             <input type="text" class="form-control" name="name"  value="{{$user->name}}"/>
                           </div>
                         </div>
                       </div>

                       <div class="form-group-inner">
                         <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label class="login2 pull-right pull-right-pro">Store Name</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" name="store_name" value="{{$user->store_name}}"/>
                              </div>
                            </div>
                          </div>

                          <div class="form-group-inner">
                            <div class="row">
                                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                   <label class="login2 pull-right pull-right-pro">Address</label>
                                 </div>
                                 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                   <input type="text" class="form-control" name="address" value="@if($address){{$user->address}}@endif"/>
                                 </div>
                               </div>
                             </div>
                             <div class="form-group-inner">
                               <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                      <label class="login2 pull-right pull-right-pro">State</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                      <input type="text" class="form-control" name="state" value="{{$user->state}}"/>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group-inner">
                                  <div class="row">
                                       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                         <label class="login2 pull-right pull-right-pro">Latitude</label>
                                       </div>
                                       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                         <input type="text" class="form-control" name="latitude" value="{{$user->latitude}}" />
                                       </div>
                                     </div>
                                   </div>
                                   <div class="form-group-inner">
                                     <div class="row">
                                          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro">Landmark</label>
                                          </div>
                                          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <textarea class="form-control" name="landmark" value="{{$user->landmark}}"/></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="all-form-element-inner">
                            <div class="form-group-inner">
                              <div class="row">
                                   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <label class="login2 pull-right pull-right-pro">Email</label>
                                   </div>
                                   <div class="col-lg-7 col-md-7 col-sm-7 col-xs-10">
                                     <input type="text" class="form-control" name="email" disabled value="{{$user->email}}"/>
                                   </div>
                                   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                     <button class="btn btn-primary form-control email_edit"> Edit</button>
                                   </div>
                                 </div>
                               </div>

                               <div class="form-group-inner">
                                 <div class="row">
                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="login2 pull-right pull-right-pro">Phone Number</label>
                                      </div>
                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control"  value="{{$user->phone_number}}" name="phone_number"/>
                                      </div>
                                      <!-- <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" disabled value="{{$user->phone_number}}"/>
                                      </div> -->
                                    </div>
                                  </div>

                                  <div class="form-group-inner">
                                    <div class="row">
                                         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                           <label class="login2 pull-right pull-right-pro">City</label>
                                         </div>
                                         <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                           <input type="text" class="form-control" name="city" value="@if($address){{$address->city}}@endif"/>
                                         </div>
                                       </div>
                                     </div>
                                     <div class="form-group-inner">
                                       <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                              <label class="login2 pull-right pull-right-pro">Pin Code</label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                              <input type="text" class="form-control" name="pin" value="{{$user->pin}}"/>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group-inner">
                                          <div class="row">
                                               <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                 <label class="login2 pull-right pull-right-pro">Longitude</label>
                                               </div>
                                               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                 <input type="text" class="form-control" name="longitude" value="{{$user->latitude}}"/>
                                               </div>
                                             </div>
                                           </div>
                                         </div>
                                       </div>
                          <div class="login-btn-inner">
                          <div class="row">
                              <div class="col-lg-5"></div>
                              <div class="col-lg-7">
                                  <div class="login-horizental cancel-wp pull-left form-bc-ele">
                                      <button class="btn btn-sm btn-primary  save" type="submit">Save Changes</button>
                                  </div>
                              </div>
                          </div>
                      </div>

                    </form>
                  </div>
                  <div id="TabDetails" class="tab-pane animated  custon-tab-style1">
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                      <p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                  </div>
                  <div id="TabPlan" class="tab-pane animated  custon-tab-style1">
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                      <p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries. </p>
                      <p>the leap into electronic typesetting, remaining essentially unchanged.</p>
                  </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script>
$(document).ready(function(){

  $(document).on('click', '.save', function(e){
    e.preventDefault();
    $.ajax({
      url: $('#basicInfo').attr('action'),
      type:$('#basicInfo').attr('method'),
      data:$('#basicInfo').serializeArray(),
      success: function(){

      },
      error:function(){

      }
    })
  })

  $(document).on('click', '.email_edit', function(e){
    e.preventDefault();
  })

})
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=2&libraries=places&callback=initMap"
        async defer></script> -->

@endsection
