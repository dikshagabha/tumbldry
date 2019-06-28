<div class="row">
  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">      
      <div class="form-group-inner">
        <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
               <label class="login2 pull-right pull-right-pro">Name</label>
             </div>
             <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
              {!! Form::text('name',null,array('class' => 'form-control', "maxlength"=>20,
                              "id"=>'name',  "placeholder"=>"Name")) !!}
              <span class="error" id="name_error"></span>
             </div>               
        </div>
      </div>
      <br>
      <div class="form-group-inner">
        <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
               <label class="login2 pull-right pull-right-pro">Description</label>
             </div>
             <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
              {!! Form::textarea('description',null,array('class' => 'form-control',  "placeholder"=>"Description", "maxlength"=>200, "id"=>'description')) !!}
              <span class="error" id="description_error"></span>
             </div>
        </div>
      </div>
      
      <br>
      <div class="form-group-inner">
        <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
               <label class="login2 pull-right pull-right-pro">Type</label>
             </div>
             <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
              {!! Form::select('type',[1=>'Membership Plan'], null, array('class' => 'form-control',  "placeholder"=>"Plan Type")) !!}
              <span class="error" id="type_error"></span>
             </div>
        </div>
      </div>
      <br>

      <div class="form-group-inner">
        <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
               <label class="login2 pull-right pull-right-pro">Duration</label>
             </div>
             <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::select('end_date',[1=>'Weekly', 2=>'Monthly', 3=>'Yearly'], null,array('class' => 'form-control',  "placeholder"=>"Plan Duration")) !!}
                <span class="error" id="end_date_error"></span>
             </div>
        </div>
      </div>
      <br>


      <div class="form-group-inner">
        <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
               <label class="login2 pull-right pull-right-pro">Price</label>
             </div>
             <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                {!! Form::text('price', null,array('class' => 'form-control',  "placeholder"=>"Price", 'maxlength'=>20)) !!}
                <span class="error" id="price_error"></span>
             </div>
        </div>
      </div>
      <br>

      
    
      <br>
    </div>
</div>