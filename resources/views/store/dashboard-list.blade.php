<div class="row">
<div class="col-md-6 col-sm-6 col-lg-6">
	<vs-card>
	  <div slot="header">
	    <h3>
	      Runners Not Assigned
	    </h3>
	  </div>
	  <div>    
	  @if($users->count())
	      <table class="table dataTable table-borderless table-responsive
	      " style="
    font-size: 12px;
    padding: 0 !important;
">
	          <thead>
	            <tr>
	              <th>Id</th>
	              <th>Phone Number</th>
	              <th style="padding-right:30px;padding-left:30px">Name</th>
	              <th>Service</th>
	              <th style="padding-right:75px;padding-left:75px">Pickup Time</th>
	              <th style="padding-right:50px;padding-left:50px">AssignedTo</th>
	            </tr>
	          </thead>
	          <tbody>
	     		 @foreach($users as $user)
	            <tr @if($user->created_at->addHours(2)->lt($current_time)) 
	            		style="background-color: rgba(255, 0, 0, 0.3)" 
	            	@endif>
	              <td>
	                {{$user->id}}
	              </td>
	              <td>
	                <a href="{{route('getcustomerdetails', $user->customer_id)}}" class="view">{{$user->customer_phone}}</a>
	              </td>
	              <td>
	                {{$user->customer_name}}
	              </td>
	              
	              <td>
	               	{{$user->service_short_name}}
	              </td>

	              <td>
	                  
	                  @if($user->request_time)
                 
                    {{$user->request_time->format('d/m/y')}}
                    
                    {{ $user->start_time->format('h:i a')}} -

                    {{$user->end_time->format('h:i a')}}
                 
                  @else
                    --
                  @endif
	              </td>
	              <td>
	                {{Form::select("runner_id",$runners, $user->assigned_to, ["class"=>"runner_select form-control", 'placeholder'=>"Select Runner", 'href'=>route('store.assign-runner'), 'data-id'=>$user->id ])}}
	              </td>
		        </tr>
	            @endforeach
	          </tbody>
	  		</table>
	      @else
	      No Records Found
	      @endif

	  </div>
	  
	</vs-card>
	<vs-card>
	  <div slot="header">
	    <h3>
	      New Orders
	    </h3>
	  </div>
	  <div>
	    <div class="ct-chart ct-golden-section" id="chart2"></div>
	  </div>
	</vs-card>

	<vs-card>
	  <div slot="header">
	    <h3>
	      New Customers
	    </h3>
	  </div>
	  <div>
	    <div class="ct-chart ct-golden-section" id="chart1"></div>
	  </div>
	</vs-card>
</div>
<!-- <vs-col type="flex" vs-justify="center" vs-align="right" vs-w="0.5">  
</vs-col> -->
<div class="col-md-6 col-sm-6 col-lg-6">
	<vs-card>
	  <div slot="header">
	    <h3>
	      Pending Pickups
	    </h3>
	  </div>
	  <div>
	  <br>
	     @if($pending->count())
	      <table class="table dataTable  table-borderless table-responsive" style="
			font-size: 12px;
			padding: 0 !important;
		">
	          <thead>
	            <tr>
	              <th>Id</th>
	              <th>Phone Number</th>
	              <th style="padding-right:30px;padding-left:30px">Name</th>
	              <th>Service</th>
	              <th style="padding-right:80px;padding-left:80px">Pickup Time</th>
	              <th style="padding-right:20px;padding-left:20px">AssignedTo</th>
	            </tr>
	          </thead>
	          <tbody>
	     		 @foreach($pending as $user)
	            <tr>
	              <td>
	                {{$user->id}}
	              </td>
	              <td>
	                <a href="{{route('getcustomerdetails', $user->customer_id)}}" class="view">{{$user->customer_phone}}</a>
	              </td>
	              <td>
	                {{$user->customer_name}}
	              </td>
	              
	              <td>
	               	{{$user->service_short_name}}
	              </td>

	              <td>
	                  
	                  @if($user->request_time)
	                    {{$user->request_time->setTimezone($timezone)->format('y/m/d')}} ({{$user->start_time->format('h:i a')}} - {{$user->end_time->format('h:i a')}})
	                  @else
	                    --
	                  @endif
	              </td>
	              <td>
	                {{$user->runner_name}}
	              </td>
		        </tr>
	            @endforeach
	          </tbody>
	  		</table>
	      @else
	      No Records Found
	      @endif  	    
	  </div>
	</vs-card>
	<vs-card>
	  <div slot="header">
	    <h3>
	      Orders Completed V/S Pending Orders
	    </h3>
	  </div>
	  <div>
	    <div class="ct-chart ct-golden-section" id="chart3"></div>
	  </div>
	</vs-card>
	

</div>
</div>
<div class="row">
<div class='my-legend col-12'>
	<div class='legend-scale'>
	  <ul class='legend-labels' style="float: right !important">
	    
	    <li><span style='background:#fec713;'></span>Order Created</li>
	    <li><span style='background:#b2d236;'></span>Order Delivered</li>
	  </ul>
	</div>
</div>
<div id='calendar'></div>