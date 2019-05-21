{{ Form::open(['id'=>'ItemForm', 'enctype'=>"multipart/form-data", 'route'=>'store.addItemSession']) }}
             
<div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Service</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
       {{ Form::select("service", $services, null, ['class'=>'form-control', 'id'=>'service', 'placeholder'=>'Select Service' ,'data-url'=>route('store.get-items')])}} 
       <span class="error" id="service_error"></span>
     </div>
   </div>
</div>
<br>
<div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Item</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <!-- {{ Form::select("item", [], null, ['class'=>'form-control', 'id'=>'item', 'placeholder'=>'Select Item', 'disabled'=>'true'])}}  -->

         <form id="form-country_v1" name="form-country_v1">
          <div class="typeahead__container">
              <div class="typeahead__field">
                  <div class="typeahead__query">
                      <input class="js-typeahead-country_v1" name="item" type="search" name="item" placeholder="Search Item" id="item" autocomplete="on">
                  </div>
                 
              </div>
          </div>
      <!-- 

       <input type="text" class="form-control" name="item"  id="item"/>   -->
       <span class="error" id="item_error"></span>
     </div>
   </div>
</div>

<div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Quantity</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
       <input type="number" class="form-control" name="quantity"  id="quantity"/>      
     </div>
   </div>
</div>
<br>
<div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Add On</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
       {{ Form::select("add_on", $add_on, null, ['class'=>'form-control', 'id'=>'add_on', "name"=>"add_on",'placeholder'=>'Select Add On'])}} 
       <span class="error" id="add_on_error"></span>
     </div>
   </div>
</div>
<br>
<div class="form-group-inner">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
       <label class="login2 pull-right pull-right-pro">Images</label>
     </div>
     <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
       {{ Form::file("images[]", ['class'=>'form-control', 'id'=>'images', 'multiple'=>true])}} 
       <span class="error" id="images_error"></span>
     </div>
   </div>
</div>
{{ Form::close() }}