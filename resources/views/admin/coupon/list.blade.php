
@php
$i = ($users->currentpage() - 1) * $users->perPage() + 1;
@endphp

@if($users->count())

<table class="table table-striped">
    <thead>
      <tr>
        <th>S No</th>
        <th>Name</th>
        <th>Discount</th>
        <th>Option</th> 
       </tr>
    </thead>
    <tbody>

@foreach($users as $user)
      <tr>
        <td>
          {{$i}}
        </td>
        <td>
          {{$user->coupon}}
        </td>
      
        <td>
          {{$user->coupon_price}} %
        </td>
        <td>
          <a href="{{route('edit-coupons.edit', encrypt($user->id))}}"><button class="btn btn-success"> <i class="fa fa-edit"></i></button></a>
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
