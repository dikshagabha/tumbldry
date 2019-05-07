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
                        'id' => 'search_customer', 'data-url'=>route('admin.getRate')]) }}

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
                      <tr>
                        <td class="table-modal">Latitude</td>
                        <td class="table-modal" id="latitude"></td>
                      </tr>
                      <tr>
                        <td class="table-modal">Longitude</td>
                        <td class="table-modal" id="longitude"></td>
                      </tr>
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
        <!-- 
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">store</i>
              </div>
              <p class="card-category">Revenue</p>
              <h3 class="card-title">$34,245</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">info_outline</i>
              </div>
              <p class="card-category">Fixed Issues</p>
              <h3 class="card-title">75</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">local_offer</i> Tracked from Github
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="fa fa-twitter"></i>
              </div>
              <p class="card-category">Followers</p>
              <h3 class="card-title">+245</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- <div class="row">
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Daily Sales</h4>
              <p class="card-category">
                <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> updated 4 minutes ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-warning">
              <div class="ct-chart" id="websiteViewsChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Email Subscriptions</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-danger">
              <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Completed Tasks</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title">Tasks:</span>
                  <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#profile" data-toggle="tab">
                        <i class="material-icons">bug_report</i> Bugs
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#messages" data-toggle="tab">
                        <i class="material-icons">code</i> Website
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#settings" data-toggle="tab">
                        <i class="material-icons">cloud</i> Server
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Sign contract for "What are conference organizers afraid of?"</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                        </td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Create 4 Invisible User Experiences you Never Knew About</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="messages">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                        </td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Sign contract for "What are conference organizers afraid of?"</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="settings">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                        </td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>Sign contract for "What are conference organizers afraid of?"</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="card-title">Employees Stats</h4>
              <p class="card-category">New employees on 15th September, 2016</p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <th>ID</th>
                  <th>Name</th>
                  <th>Salary</th>
                  <th>Country</th>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Dakota Rice</td>
                    <td>$36,738</td>
                    <td>Niger</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Minerva Hooper</td>
                    <td>$23,789</td>
                    <td>Curaçao</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Sage Rodriguez</td>
                    <td>$56,142</td>
                    <td>Netherlands</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Philip Chaney</td>
                    <td>$38,735</td>
                    <td>Korea, South</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
       -->  
        <!-- </div>
      </div> -->
    
  </div>
@endsection

@push('js')

<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('#select_type').chosen();
      $('#select_city').chosen();
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
          $("#Userist").hide();
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