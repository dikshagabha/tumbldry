
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-borderless dataTable">
          <thead>
            <tr>
              <th>Plan Id</th>
              <th>Phone Number</th>
              <th>Name</th>
              <th>Valid From</th>
              <th>Valid To</th>
              <th>Status</th>
              <!-- <th>Options</th> -->
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$user->plan_id}}
              </td>
              <td>
                {{$user->phone_number}}
              </td>
               <td>
                {{$user->name}}
              </td>
              <td>
                {{$user->valid_from}}
              </td>

              <td>
                {{$user->valid_to}}
              </td>
              <td>
                @if($user->status==0)
                 
                    <!-- <span class="badge badge-warning"> -->Inactive<!-- </span> -->
                 
                @else
                    <!-- <span class="badge badge-success"> -->Active<!-- </span> -->
                @endif
              </td>
             <!-- <td>
                   <a href="{{route('manage-runner.edit',encrypt( $user->id))}}" title="edit">
                   <vs-button type="gradient" color="warning" ><i class="fa fa-edit"></i></vs-button>
                  </a> 
                  <a href="{{route('manage-plans.show',encrypt( $user->id))}}" class="view" title="view">
                    <vs-button type="gradient" color="success" > <i class="fa fa-eye"></i></vs-button>
                  </a>
                  <a href="{{route('manage-plans.destroy', encrypt( $user->id))}}" id="delete" data-token="{{csrf_token()}}" title="delete"> 
                    <vs-button type="gradient" color="danger" > <i class="fa fa-trash"></i></vs-button>
                  </a>
              </td>-->
            </tr>
              @php
                $i++;
              @endphp
            @endforeach
          </tbody>
      </table>

      {{$users->links()}}
      @else
      No Records Found
      @endif