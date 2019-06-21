
 @if($users->count())

      <table class="table dataTable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Service</th>
              <th>Status</th>
               <th>Created At</th>
            <!--   <th>View</th> -->
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$user->id}}
              </td>
              <td>{{$user->customer_service}}</td>
              <td>
                @if($user->status==1)
                    <!-- <span class="badge badge-warning"> -->Pending<!-- </span> -->
                @elseif($user->status==2)
                 <!--  <span class="badge badge-info"> -->Recieved<!-- </span> -->
                @elseif($user->status==3)
                  <!-- <span class="badge badge-warning"> -->Processing<!-- </span> -->
                @elseif($user->status==4)
                  <!-- <span class="badge badge-danger"> -->Partial Delivery<!-- </span> -->
                @elseif($user->status==5)
                  <!-- <span class="badge badge-danger"> -->Full Delivery<!-- </span> -->
                @elseif($user->status==6)
                  <!-- <span class="badge badge-success"> -->Delivered<!-- </span> -->
                  
                @endif
              </td>
              <td>
                  {{$user->created_at->setTimezone($timezone)->format('y/m/d h:i a')}}
                  
              </td>
     
            </tr>
             
            @endforeach
          </tbody>
      </table>
      @else
      No Records Found
      @endif