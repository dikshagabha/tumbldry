

@if($edit)

{{ Form::open(['method' => 'post', 'id' => 'store-search', 'data-url'=>route('store.getInputRate'),'name' => 'serach_form']) }}
 <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                        {{ Form::text('search', $search , ['class' => 'form-control', 'placeholder' => 'Filter by Item Name', 'maxlength'=>'50', 'id'=>'date']) }}
                        <span class="error" id="type_error"></span>
                    </div>
                  

                   <!--  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

                    </div> -->
                       <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="1">
                          <button class="btn btn-warning" id="search-button">Filter</button>
                        </vs-col>
                        
                                 
                {{Form::close()}}
                <br>
                </div> 
<br>
<vs-row vs-justify="center">
  <table class="table table-bordered">
    <thead>
      <th>Item</th>
     
      <th>Price</th>
    </thead>
    <tbody>
      @foreach($prices as $price)
        <tr>
        <td>{{$price->item_name}}</td>
         
          <td>{{$price->value}} Rs</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</vs-row>
{{$prices->links()}}
@else
No Records Found
@endif