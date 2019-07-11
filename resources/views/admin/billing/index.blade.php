@extends('layouts.app')
@section('title', 'Billing')
@section('content')
@section('css')
<link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
<link rel="stylesheet" href="{{ asset('css/jcf.css') }}">
@endsection
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-stats">
                    <br>          
                    <div>
                        <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <label class="login2 pull-right pull-right-pro" >
                                                <h4>Import Billing</h4>
                                            </label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            
                                        </div>
                                    </div>
                                </div>
                      {{Form::open(['route'=>'billing.importBilling', 'method'=>'post', 'id'=>'addFrenchise', 'name'=>'form_data'])}}
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="login2 pull-right pull-right-pro">Select Store</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        {{Form::select('users',$users, null, ['class'=>"form-control store", 'placeholder'=>"Select Store"])}} 
                                        <span class="error" id="users_error"></span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="login2 pull-right pull-right-pro">Upload Sheet</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        {{Form::file('sheet',['class'=>"form-control", 'placeholder'=>"Select Store"])}} 
                                        <a href = "{{route('billing.downloadExcel')}}" >(Demo Excel)</a>
                                        <span class="error" id="sheet_error"></span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group-inner">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                        <label class="login2 pull-right pull-right-pro"></label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                        {{Form::submit('Upload',['class'=>"btn btn-success save"])}} 
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <br>
                    <hr>
                    <div>
                      
                        <div class="row">
                          
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              {{Form::open(['url'=>route('billing.carryForward', 1), 'method'=>'post', 'id'=>'addBilling1', 'name'=>'form_data'])}}
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <label class="login2 pull-right pull-right-pro" >
                                                <h4>Amount Paid By Store</h4>
                                            </label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro">Select Store</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            {{Form::select('user',$users, null, ['class'=>"form-control store", 'placeholder'=>"Select Store"])}} 
                                           
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro">Amount</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            {{Form::text('price',null,['class'=>"form-control"])}} 
                                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <!-- <label class="login2 pull-right pull-right-pro">Amount</label> -->
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            OR                                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro">Uplaod Sheet</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            {{Form::file('sheet',['class'=>"form-control", 'placeholder'=>"Select Store"])}} <a href="{{route('admin.democarry')}}">(Demo Excel)</a>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro"></label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            {{Form::submit('Submit',['class'=>"btn btn-success save_amount", 'id'=>'save_amount', 'data-type'=>'1'])}} 
                                            {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              {{Form::open(['url'=>route('billing.carryForward', 2), 'method'=>'post', 'id'=>'addBilling2', 'name'=>'form_data'])}}
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <label class="login2 pull-right pull-right-pro" >
                                                <h4>Amount Paid To Store</h4>
                                            </label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro">Select Store</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            {{Form::select('user',$users, null, ['class'=>"form-control store", 'placeholder'=>"Select Store"])}} 
                                           
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro">Amount</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            {{Form::text('price',null,['class'=>"form-control"])}} 
                                           
                                        </div>
                                    </div>
                                </div>
                                 <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <!-- <label class="login2 pull-right pull-right-pro">Amount</label> -->
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            OR                                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro">Uplaod Sheet</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            {{Form::file('sheet',['class'=>"form-control", 'placeholder'=>"Select Store"])}} <a href="{{route('admin.democarry')}}">(Demo Excel)</a>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <label class="login2 pull-right pull-right-pro"></label>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            {{Form::submit('Submit',['class'=>"btn btn-success save_amount", 'id'=>'save_amount', 'data-type'=>'2'])}} 
                                            {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                          
                          <div style="text-align: center;">
                            <span class="error" id="user_error"></span><br>
                            <span class="error" id="price_error"></span>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{asset('js/jcf/jcf.js')}}"></script>
<script src="{{asset('js/jcf/jcf.file.js')}}"></script>
<script src="{{asset('js/chosen/chosen.jquery.min.js')}}"></script>
<script>
    $(document).ready(function(){
      jcf.replaceAll();
      $('.store').chosen();
    
      $(document).on('click', '.save', function(e){
        e.preventDefault();
        $('body').waitMe();
    
        var form = $('#addFrenchise')[0];
        var data = new FormData(form);
        $(".error").html("");
        $.ajax({
          url: $('#addFrenchise').attr('action'),
          type:'post',
          data: data,
          processData:false,
          contentType:false,
          success: function(data){
            success(data.message);
            $('body').waitMe('hide');
            $('#addFrenchise')[0].reset();
          }
    
        })
      }) 
      $(document).on('click', '.save_amount', function(e){
        e.preventDefault();
        $('body').waitMe();
        dataurl = $(this).attr('data-type');
        console.log($('#addBilling'+dataurl).attr('url'));

        var form = $('#addBilling'+dataurl)[0];

        var data = new FormData(form);
        $(".error").html("");
        $.ajax({
          url: $('#addBilling'+dataurl).attr('action'),
          type:'post',
          data: data,
          processData:false,
          contentType:false,
          success: function(data){
            success(data.message);
            $('body').waitMe('hide');
            $('#addBilling')[0].reset();
          }
    
        })
      })
    })
</script>
@endpush