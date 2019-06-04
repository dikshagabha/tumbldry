@extends('store.layouts.app')

@section('title', 'Order Payment')

@section('content')
	

<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
    <vs-card>

		<vs-breadcrumb
		:items="
		   [
		     {
		       title: 'Create Order',
		       disabled: true
		     },
		     {
		       title: 'Payment',
		       
		     }
		   ]"
		>
			
		</vs-breadcrumb>

      <div slot="header">
        <h3>
        
        </h3>
      </div>
      <br>
      <div id="dataList">
		<vs-row vs-justify="justify">

	      	 <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="5">
		         <h4> Please Select a Payment Mode</h4>
		         
	      	 	<table class="table">
		          	<tr>
		          		<td> <label for = 'cash'>Cash</label>
		          		</td>

		          		<td> 
		          			<input type="checkbox" name="payment_mode[]" value="1" id="cash" class="mode">

		          			<div class="1 input" id="1" style="display: none">
		          				<input type="text" name="cash_pay" value="{{$order->total_price}}" id="cash_pay" class="form-control">
		          			</div>
		          		</td>
		          	</tr>

		          	<tr>
		          		<td> <label for = 'wallet'>Wallet Payment</label>
		          		</td>

		          		<td> 
		          			<input type="checkbox" name="payment_mode[]" value="2" id="wallet" class="mode">  
		          			<div class="2 input" id="2" style="display: none">
		          				<input type="text" name="wallet_pay" id="wallet_pay" value="{{$order->total_price}}" class="form-control">
		          				Wallet Money: {{$userwallet->price}} Rs
		          			</div>
		          		</td>
		          	</tr>
		        </table>
		        <input type="hidden" name="order_id" value="{{$order->id}}">
			</vs-col>
			<vs-col type="flex" vs-justify="right" vs-align="right" vs-w="2">
			</vs-col>
			 <vs-col type="flex" vs-justify="right" vs-align="right" vs-w="5">
		          <h4>ORDER DETAILS</h4>

		          <table class="table table-responsive table-borderless">
		          	<tr>
		          		<td>
		          		Order Id</td>
		          		<td>{{$order->id}}</td>
		          	</tr>
		          	<tr>
		          		<td>
		          		Items</td>
		          		<td>@foreach($order->items as $item)
								{{$item->quantity}} X {{ $item->item }}  @if($item->itemimage->count()) ({{ $item->itemimage->first()->addon_name}}) @endif<br>
							@endforeach</td>
		          	</tr>

		          	<tr>
		          		<td>
		          		Payable Amount</td>
		          		<td>Rs {{$order->total_price }}</td>
		          	</tr>
		        </table>
		          <!-- <vs-list>
				    <vs-list-item title="Order Id">{{$order->id}}</vs-list-item>
				    <vs-list-item title="Walet Payment" subtitle=""></vs-list-item>
				    <vs-list-item title="Some more text"></vs-list-item>
				    <vs-list-item title="Even more text" subtitle="Another little text"></vs-list-item>
				  </vs-list> -->
			</vs-col>
		</vs-row>
		<vs-row>
			<vs-col type="flex" vs-justify="center" vs-align="center" vs-w="5" >
				
        	</vs-col>
			<vs-col type="flex" vs-justify="center" vs-align="center" vs-w="5" >
				<vs-button type="gradient" color="danger" id="pay-button"  data-href="{{route('store.payment')}}" data-id='{{$order->id}}'>Pay</vs-button>
        	</vs-col>
			
       	</vs-row>
       	<br>
      </div>
      <br>
      <div slot="footer">

      </div>
    </vs-card>
  </vs-col>
</vs-row>

@endsection
@push('js')

<script type="text/javascript">
	
	$(document).ready( function(){
		$(document).on('click', '#pay-button',function(e){
			e.preventDefault();
			current=$(this);
			$.ajax({
				url:current.data('href'),
				data:$('#dataList :input').serializeArray(),
				method:'post',
				success:function(data){
					success(data.message);
					window.location = data.redirectTo;
				}
			});
		})

		$(document).on('change', '.mode',function(e){
			e.preventDefault();
			current=$(this);

			//$('.input').hide();
			if (current.prop('checked')) {
				$('#'+current.val()).show()
			}else{
				$('#'+current.val()).hide()
			}
			
		})
	});
</script>
	
@endpush