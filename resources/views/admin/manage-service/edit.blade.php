@extends('admin.layout.app')
@section('title', 'Manage Service')

@section('content')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
@endsection
<br>
<form action="{{route('manage-service.update', $id)}}" method="put"  id="addFrenchise">
  @csrf
  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
  <div class="all-form-element-inner">
    <div class="form-group-inner">
      <div class="row">
           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
             <label class="login2 pull-right pull-right-pro">Name</label>
           </div>
           <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
             <input type="text" class="form-control" name="name"  value="{{$service->name}}"/>
             <span class="error" id="name_error"></span>
           </div>
         </div>
       </div>

       <div class="form-group-inner">
         <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label class="login2 pull-right pull-right-pro">Description</label>
              </div>
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <textarea name="description" class="form-control">{{$service->description}} </textarea>
                <span class="error" id="description_error"></span>
              </div>
            </div>
          </div>
          <div class="price_wrap">

          <div class="form-group-inner" id="add_here">
            <div class="row">
                 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                   <label class="login2 pull-right pull-right-pro">Prices</label>
                 </div>
                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                     <input type="text" class="form-control" name="parameter[]"  value="{{$service->serviceprices->first()['parameter']}}" placeholder="Parameter"/>
                 </div>
                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                     <input type="text" class="form-control" name="price[]"  value="{{$service->serviceprices->first()['value']}}" placeholder="Value"/>
                 </div>
                 <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <button class="btn btn-success" id='add_new'><i class="fa fa-plus" ></i></button>
                 </div>

               </div>
             </div>
             @if($service->serviceprices->count()>1)
              @foreach($service->serviceprices as $key=>$serPrice)
                @if($key>0)
                  <div class="form-group-inner extrafield">
                    <div class="row">
                         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                           <label class="login2 pull-right pull-right-pro"></label>
                         </div>
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                             <input type="text" class="form-control" name="parameter[]"  value="{{$serPrice->parameter}}" placeholder="Parameter"/>
                         </div>
                         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                             <input type="text" class="form-control" name="price[]"  value="{{$serPrice->value}}" placeholder="Value"/>
                         </div>
                         <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                            <button class="btn btn-danger" type="button" id="remove"><i class="fa fa-minus" ></i></button>
                         </div>
                       </div>
                     </div>
                     @endif
                 @endforeach
             @endif

           </div>
           <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">

                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                     <span class="error" id="parameter_error"></span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                      <span class="error" id="price_error"></span>
                </div>
              </div>
           <br>
         <div class="form-group-inner">
           <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-3">
            </div>
             <div class="col-lg-3 col-md-3 col-sm-3">
              <a href="{{route('manage-service.index')}}"> <button type="button" class="btn">Cancel</button> </a>
             </div>
             <div class="col-lg-5 col-md-5 col-sm-5">
               <button type="submit" class="btn btn-primary" id="add_frenchise" >Edit Service</button>
             </div>
            </div>
          </div>
      </div>
   </div>
</form>
@endsection

@section('js')
<script type="text/template" class="temp-data">
  <div class="form-group-inner extrafield">
    <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
           <label class="login2 pull-right pull-right-pro"></label>
         </div>
         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
             <input type="text" class="form-control" name="parameter[]"  value="" placeholder="Parameter"/>
         </div>
         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
             <input type="text" class="form-control" name="price[]"  value="" placeholder="Value"/>
         </div>
         <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <button class="btn btn-danger" type="button" id="remove"><i class="fa fa-minus" ></i></button>
         </div>
       </div>
     </div>

</script>
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script>
$(document).ready(function(){

  $(document).on('click', '#add_new', function(e){
    e.preventDefault()
    $(".price_wrap").append($('.temp-data').html());
  })

  $(document).on('click', '#remove', function(e){
    e.preventDefault();
    $(this).parents('.extrafield').remove();
  })

  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();
    $(".error").html("")
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:$('#addFrenchise').attr('method'),
      data: $('#addFrenchise').serializeArray(),
      dataType:'json',
      success: function(data){
        success(data.message);
        window.location=data.redirectTo;
        $('body').waitMe('hide');
      },
      error:function(data){
        $('body').waitMe('hide');
        if (data.status==422) {
          var errors = data.responseJSON;
          for (var key in errors.errors) {
              if (key=="name" || key=="description") {
                  $("#"+key+"_error").html(errors.errors[key][0])
              }
              else if(key.includes('parameter')){
                $("#parameter_error").html(errors.errors[key][0])
              }
              else if(key.includes('price')){
                $("#price_error").html(errors.errors[key][0])
              }
            }
        }else{
          error();
        }

      }
    })
  })
})
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=2&libraries=places&callback=initMap"
        async defer></script> -->

@endsection
