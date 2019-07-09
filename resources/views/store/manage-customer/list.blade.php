
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
             <!--  <th>Status</th> -->
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
                  <a href="{{route('manage-customer.status', $user->id)}}" class="status" data-status="1">
                   Inactive
                  </a>
                @else
                  <a href="{{route('manage-customer.status', $user->id)}}" class="status" data-status="0">
                   Active
                  </a>
                @endif
              </td> -->
              <td>
                  <a href="{{route('manage-customer.edit',encrypt( $user->id))}}" title="edit">
                    <button type="gradient" color="warning" class="btn btn-warning" ><i class="fa fa-edit"></i></button>
                  </a>
                  <a href="{{route('manage-customer.show',encrypt( $user->id))}}" class="view" title="view">
                    <button type="gradient" color="success" class="btn btn-success" > <i class="fa fa-eye"></i></button>
                  </a>
                  <a href="{{route('manage-customer.destroy', encrypt( $user->id))}}" class="delete" data-token="{{csrf_token()}}" title="delete"> 
                    <button type="gradient" color="danger" class="btn btn-danger"> <i class="fa fa-trash"></i></button>
                  </a>

                  <a href="{{route('store.customerDetails',($user->id))}}" title="edit">
                    <button type="gradient" color="warning" class="btn btn-warning" >History</button>
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