@if($edit)
<table class="table table-bordered">
    <thead>
      <th>Item</th>
      @if($type==1) <th>Quantity</th> @endif
      <th>Price</th>
    </thead>
    <tbody>
      @foreach($prices as $price)
        <tr>
        <td>{{$price->item_name}}</td>
          @if($type==1)<td> {{$price->quantity}} </td> @endif
          <td>{{$price->value}} Rs</td>
        </tr>
      @endforeach
    </tbody>

    {{$prices->links()}}
</table>
@else
No Records Found
@endif