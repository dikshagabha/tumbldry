<vs-col type="flex" vs-justify="center" vs-align="left" vs-w="5">
	<vs-card>
	  <div slot="header">
	    <h3>
	      Runners Not Assigned
	    </h3>
	  </div>
	  <div>     
		@if($users->count())
	      <table class="table dataTable " style="overflow-x:auto;">
	          <thead>
	            <tr>
	              <th>Id</th>
	              <th>Phone Number</th>
	              <th width="20%">Name</th>
	              <th>Service</th>
	              <th>Pickup Time</th>
	              <th width="20%">AssignedTo</th>
	            </tr>
	          </thead>
	          <tbody>
	     		 @foreach($users as $user)
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
	               	{{$user->service_name}}
	              </td>

	              <td>
	                  
	                  @if($user->request_time)
	                    {{$user->request_time->setTimezone($timezone)->format('y/m/d')}} ({{$user->start_time}} - {{$user->end_time}})
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
</vs-col>
<vs-col type="flex" vs-justify="center" vs-align="right" vs-w="1">  
</vs-col>
<vs-col type="flex" vs-justify="center" vs-align="right" vs-w="5">
	<vs-card>
	  <div slot="header">
	    <h3>
	      Pending Pickups
	    </h3>
	  </div>
	  <div>
	  <br>
	     @if($pending->count())
	      <table class="table dataTable " style="overflow-x:auto;">
	          <thead>
	            <tr>
	              <th>Id</th>
	              <th>Phone Number</th>
	              <th width="20%">Name</th>
	              <th>Service</th>
	              <th>Pickup Time</th>
	              <th width="20%">AssignedTo</th>
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
	               	{{$user->service_name}}
	              </td>

	              <td>
	                  
	                  @if($user->request_time)
	                    {{$user->request_time->setTimezone($timezone)->format('y/m/d')}} ({{$user->start_time}} - {{$user->end_time}})
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
</vs-col>