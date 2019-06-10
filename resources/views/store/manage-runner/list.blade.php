
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-borderless dataTable">
          <thead>
            <tr>
              <th>S No</th>
              <th>Name</th>
              <th>Phone Number</th>
              <!-- <th>Status</th> -->
              <th>Options</th>
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$i}}
              </td>
              <td>
                {{$user->name}}
              </td>
              <td>
                {{$user->phone_number}}
              </td>
             <!--  <td>
                @if($user->status==0)
                  <a href="{{route('manage-runner.status', $user->id)}}" class="status" data-status="1">
                   Inactive
                  </a>
                @else
                  <a href="{{route('manage-runner.status', $user->id)}}" class="status" data-status="0">
                    Active
                  </a>
                @endif
              </td> -->
              <td>
                  <a href="{{route('manage-runner.edit',encrypt( $user->id))}}" title="edit">
                   <vs-button type="gradient" color="warning" class="btn btn-warning" ><i class="fa fa-edit"></i></vs-button>
                  </a>
                  <a href="{{route('manage-runner.show',encrypt( $user->id))}}" class="view" title="view">
                    <vs-button type="gradient" color="success" class="btn btn-success"> <i class="fa fa-eye"></i></vs-button>
                  </a>
                  <a href="{{route('manage-runner.destroy', encrypt( $user->id))}}" class="delete" data-token="{{csrf_token()}}" title="delete"> 
                    <vs-button type="gradient" color="danger" class="btn btn-danger"> <i class="fa fa-trash"></i></vs-button>
                  </a>
              </td>
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