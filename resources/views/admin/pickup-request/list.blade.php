
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp
 @if($users->count())

      <table class="table table-striped dataTable">
          <thead>
            <tr>
              <th>S No</th>
              <th>Customer Email</th>
              <th>Store Email</th>
            </tr>
          </thead>
          <tbody>

      @foreach($users as $user)
            <tr>
              <td>
                {{$i}}
              </td>
              <td>

                {{$user->customer_email}}
                
              </td>
              <td>
                  {{$user->store_email}}
                
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