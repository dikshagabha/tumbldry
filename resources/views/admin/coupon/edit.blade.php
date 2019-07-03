@extends('layouts.app')
@section('title', 'Manage Service')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
@endsection
<br>

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="card card-stats">
            <br>
            <form action="{{route('edit-coupons.update', $id)}}" method="put"  id="addFrenchise">
              @csrf
              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
              <div class="all-form-element-inner">
                <div class="form-group-inner">
                  <div class="row">
                       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                         <label class="login2 pull-right pull-right-pro">Title</label>
                       </div>
                       <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                         <input type="text" class="form-control" name="coupon"  readonly value="{{ $coupon->coupon }}"/>
                         <span class="error" id="title_error"></span>
                       </div>
                     </div>
                   </div>
                   <br>
                   <div class="form-group-inner">
                     <div class="row">
                          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label class="login2 pull-right pull-right-pro">Discount</label>
                          </div>
                          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                            <input type="text" name="coupon_price" class="form-control" maxlength="10" value="{{$coupon->coupon_price}}"> 
                            <span class="error" id="coupon_price_error"></span>
                          </div>
                             <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                              %
                             </div>
                          </div>
                        </div>
                    <br>
                    @if($coupon->coupon=="Service Discount")
                      <div class="form-group-inner">
                         <div class="row">
                              
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label class="login2 pull-right pull-right-pro">Previous Service</label>
                              </div>
                              <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                {{Form::Select('parameter', $service, $coupon->parameter, ['class'=>'form-control service', 'placeholder'=>'Select Service'])}}
                                <span class="error" id="coupon_price_error"></span>
                              </div>
                               
                             </div>
                        </div>
                      <br>
                       <div class="form-group-inner">
                         <div class="row">
                              
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label class="login2 pull-right pull-right-pro">Current Service</label>
                              </div>
                              <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                {{Form::Select('value', $service, $coupon->value, ['class'=>'form-control service', 'placeholder'=>'Select Service'])}}
                                <span class="error" id="coupon_price_error"></span>
                              </div>
                               
                             </div>
                      </div>

                    @endif

                    @if($coupon->coupon=="Laundary Discount")
                      <div class="form-group-inner">
                         <div class="row">
                              
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label class="login2 pull-right pull-right-pro">Last Order Quantity</label>
                              </div>
                              <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                {{Form::text('parameter', $coupon->parameter, ['class'=>'form-control'])}}
                                <span class="error" id="coupon_price_error"></span>
                              </div>
                                                           
                             </div>
                        </div>
                      <br>
                    @endif

                    @if($coupon->coupon=="WeekDay Discount")
                      <div class="form-group-inner">
                         <div class="row">
                              
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label class="login2 pull-right pull-right-pro">Day of week</label>
                              </div>
                              <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                {{Form::Select('parameter', $weekdays, $coupon->parameter,['class'=>'form-control service'])}}
                                <span class="error" id="coupon_price_error"></span>
                              </div>                               
                             </div>
                        </div>
                      <br>
                    @endif
                      

                     <div class="form-group-inner">
                       <div class="row">
                         <div class="col-lg-3 col-md-3 col-sm-3">
                        </div>
                         <div class="col-lg-3 col-md-3 col-sm-3">
                          <a href="{{route('edit-coupons.index')}}"> <button type="button" class="btn">Cancel</button> </a>
                         </div>
                         <div class="col-lg-5 col-md-5 col-sm-5">
                           <button type="submit" class="btn btn-primary" id="add_frenchise" >Edit Coupon</button>
                         </div>
                        </div>
                      </div>
                  </div>
               </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')

<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script>
$(document).ready(function(){
  $('.service').chosen();
  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();

    var form = $('#addFrenchise')[0];

    var data = new FormData(form);

    $(".error").html("");
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:$('#addFrenchise').attr('method'),
      data: $('#addFrenchise').serializeArray(),     
      success: function(data){
        success(data.message);
        window.location=data.redirectTo;
        $('body').waitMe('hide');
      }
    })
  })
})
</script>
@endpush
