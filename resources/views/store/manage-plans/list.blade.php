
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