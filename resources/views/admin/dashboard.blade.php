@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Home')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
@endsection
@section('content')
  <div class="content">
    <div class="container-fluid">


      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i><img style="width:40px" src="{{ asset('images/icons/store.png') }}"></i>
           
              </div>
              <p class="card-category">Stores</p>
              <h3 class="card-title">
                {{$user->where('role', 3)->count()}}
              </h3>
                
            </div>
            <div class="card-footer">
              <div class="stats">
                <!-- <i class="material-icons text-danger">warning</i> -->
                <!-- <a href="#pablo">Get More Space...</a> -->
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i><img style="width:40px" src="{{ asset('images/icons/franchise.png') }}"></i>
           
              </div>
              <p class="card-category">Frenchises</p>
              <h3 class="card-title">
                {{$user->where('role', 2)->count()}}
                
              </h3>
                
            </div>
            <div class="card-footer">
              <div class="stats">
                <!-- <i class="material-icons text-danger">warning</i> -->
                <!-- <a href="#pablo">Get More Space...</a> -->
              </div>
            </div>
          </div>
        </div>
      
      
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i><img style="width:40px" src="{{ asset('images/icons/service.png') }}"></i>
           
              </div>
              <p class="card-category">Services</p>
              <h3 class="card-title">
                {{$service}}
                
              </h3>
                
            </div>
            <div class="card-footer">
              <div class="stats">
                <!-- <i class="material-icons text-danger">warning</i> -->
                <!-- <a href="#pablo">Get More Space...</a> -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row" id="rate_search">
        <div class="col-md-12">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              
            </div>
            <div class="card-body">
              <h4 class="card-title">Pending Pickups..</h4>
              <div class="card-category">
                
                  <div class="row">
                    @if($pending->count())
                    <table class=" table table-borderless">
                      
                      <th>Customer Id</th>
                      <th>Customer Phone Number</th>
                      <th> Service </th>
                      <th> Pickup Time </th>
                       <th> Assign to Store</th>
                      <tbody>
                        @foreach($pending as $user)
                              <tr>
                                 <td>
                                  {{$user->customer_id}}
                                </td>
                                <td>
                                  {{$user->customer_phone}}
                                  
                                </td>
                                  <td>
                                    {{$user->service_name}}
                                  </td>
                                  <td>
                                    
                                    @if($user->request_time)
                                      {{$user->request_time->setTimezone($timezone)->format('y/m/d')}}
                                      {{$user->start_time}} - {{$user->end_time}}
                                    @else
                                      --
                                    @endif
                                  </td>
                                  <td>
                                    {{Form::select('user_id', $stores, null, ['class'=>'form-control select_store', 'placeholder'=>'Select Store', 'data-url'=>route('admin.assignStore', $user->id)])}}
                                  </td>

                              </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @else
                    No pending pickups found.
                    @endif
                  </div>
                  

              </div>
            </div>
            
            <div class="card-footer">
              <div class="stats">
                <!-- <i class="material-icons">access_time</i> updated 4 minutes ago -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" id="rate_search">
        <div class="col-md-12">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              
            </div>
            <div class="card-body">
              <h4 class="card-title">Search Rates..</h4>
              <div class="card-category">
                {{Form::open(['route'=>'admin.getRate', 'id'=>'rateForm'])}}

                  <div class="row">
                    <!-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    </div> -->
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                        {{ Form::select('type',  $types, null, ['class' => 'form-control', 'placeholder' => 'Select Type', 'id' => 'select_type', 'data-url'=>route('admin.getServices')]) }}
                        <span class="error" id="type_error"></span>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                        {{ Form::select('city',  $cities, null, ['class' => 'form-control', 'placeholder' => 'Select City',
                        'id' => 'select_city']) }}
                        <span class="error" id="city_error"></span>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                        {{ Form::select('service',  [], null,['class' => 'form-control', 'placeholder' => 'Select Service',
                        'id' => 'select_service',  'maxlength'=>'50']) }}
                        <span class="error" id="service_error"></span>
                    </div>
                     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                        {{ Form::submit('Submit', ['class' => 'btn btn-warning',
                        'id' => 'search_rate', 'data-url'=>route('admin.getRate')]) }}

                        {{ Form::button('Reset', ['class' => 'btn btn-danger reset',
                         'data-type'=>1]) }}
                       
                    </div>
                  </div>                
                {{Form::close()}}

                <div id="dataList">

                  
                </div>

              </div>
            </div>
            
            <div class="card-footer">
              <div class="stats">
                <!-- <i class="material-icons">access_time</i> updated 4 minutes ago -->
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row" id="rate_search">
        <div class="col-md-12">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              
            </div>
            <div class="card-body">
              <h4 class="card-title">Search User..</h4>
              <div class="card-category">
                {{Form::open(['route'=>'admin.findUser', 'id'=>'customerForm'])}}

                  <div class="row">                    
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        {{ Form::text('phone_number',  null,['class' => 'form-control', 'placeholder' => 'Phone Number']) }}
                        <span class="error" id="phone_number_error"></span>
                    </div>                    
                     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        {{ Form::submit('Submit', ['class' => 'btn btn-warning',
                        'id' => 'search_customer']) }}

                        {{ Form::button('Reset', ['class' => 'btn btn-danger reset', 'data-type'=>2]) }}
                  
                    </div>
                  </div>                
                {{Form::close()}}

                <div id="UserList" style="display: none" >


                    Basic Information
                    <table class="table table-bordered">
                      <tr>
                        <td width="50%">Name</td>
                        <td id="name"></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td id="email"></td>
                      </tr>
                      <tr>
                        <td>Phone Number</td>
                        <td id="phone_number"></td>
                      </tr> 

                      <tr>
                        <td>Role</td>
                        <td id="role_type"></td>
                      </tr>                    
                    </table>
                    Address Information
                    <table class="table table-bordered">
                      <tr>
                        <td width="50%" class="table-modal">Address</td>
                        <td class="table-modal" id="address"></td>
                      </tr>
                      <tr>
                        <td class="table-modal">City</td>
                        <td class="table-modal" id="city"></td>
                      </tr>
                      <tr>
                        <td class="table-modal">State</td>
                        <td class="table-modal" id="state"></td>
                      </tr>
                      <tr>
                        <td class="table-modal">Pin</td>
                        <td class="table-modal" id="pin"></td>
                      </tr>
                      <!-- <tr>
                        <td class="table-modal">Latitude</td>
                        <td class="table-modal" id="latitude"></td>
                      </tr>
                      <tr>
                        <td class="table-modal">Longitude</td>
                        <td class="table-modal" id="longitude"></td>
                      </tr> -->
                      <tr>
                        <td class="table-modal">Landmark</td>
                        <td class="table-modal" id="landmark"></td>
                      </tr>
                    </table>
                </div>
              </div>
            </div>
            
            <div class="card-footer">
              <div class="stats">
                <!-- <i class="material-icons">access_time</i> updated 4 minutes ago -->
              </div>
            </div>
          </div>
        </div>
      </div>
       
  </div>
@endsection

@push('js')

<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('#select_type').chosen();
      $('#select_city').chosen();
      $('.select_store').chosen();
      $('#select_service').chosen();
     $(document).on('change', '#select_type', function(e){
      e.preventDefault(); 
        
        $(".error").html("");
        $('body').waitMe();

        $.ajax({
          url:$('#select_type').data('url'),
          data:{'type': $('#select_type').val()},
          type:'get',
          success: function(data){
            $('#select_service').html("");
            
            
            $.each(data.service, function(key, value) {   
               $('#select_service')
                   .append($("<option></option>")
                              .attr("value", key)
                              .text(value)); 
            });
            $('#select_service').trigger('chosen:updated')
            $('body').waitMe('hide');
          }
        })
      });

      $(document).on('change', '.select_store', function(e){
        e.preventDefault();
        $(".error").html("");
        $('body').waitMe();
        current = $(this);
        $.ajax({
          url:current.data('url'),
          data:{'store_id': current.val()},
          type:'post',
          success: function(data){
            window.location.reload();
          },
          error: function(data){
            window.location.reload();
          }
        })
       });

     $(document).on('click', '.reset', function (e) {
      e.preventDefault();        
        $(".error").html("");
        $('body').waitMe();

        type = $(this).data('type');

        if (type==1) 
        {
          $('#rateForm')[0].reset();
          $("#dataList").hide();
        }
        else{
          $('#customerForm')[0].reset();
          $("#UserList").hide();
        }

         $('body').waitMe('hide');
     })

    $(document).on('click', '#search_rate', function(e){
      e.preventDefault();        
        $(".error").html("");
        $('body').waitMe();

        $.ajax({
          url:$('#rateForm').attr('action'),
          data:$('#rateForm').serializeArray(),
          type:'post',
          success: function(data){
            $('#dataList').html(data);
            $("#dataList").show();
            $('body').waitMe('hide');
          }
        })
         }); 

    $(document).on('click', '#search_customer', function(e){
      e.preventDefault();        
        $(".error").html("");
        $('body').waitMe();
        $('#UserList').hide();

        $.ajax({
          url:$('#customerForm').attr('action'),
          data:$('#customerForm').serializeArray(),
          type:'post',
          dataType:"json",
          success: function(data){
            if (data.user) 
            {
              console.log(data);

              for(key in data.user)
              {
                $("#"+key).html(data.user[key]);
              }
            }

            $('#UserList').show();
            $('body').waitMe('hide');
          },
         
        })
         }); 

    $(document).on("click",".pagination li a",function(e) {
        e.preventDefault();
        //load_listings($(this).attr('href'), 'form_data');
        url = $(this).attr('href');
        $.ajax({
          url:url,
          data:$('#rateForm').serializeArray(),
          type:'post',
          success: function(data){
            $('#dataList').html(data);
            $('body').waitMe('hide');
          }
        })

      });
    });
  </script>
@endpush