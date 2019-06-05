@extends('store.layouts.app')
@section('title', 'Manage Plans')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/chosen/bootstrap-chosen.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jcf.css') }}">
  <!-- <style type="text/css">
    div[data-acc-content] { display: none;  }
  </style> -->
@endsection
@section('content')


<vs-row vs-justify="center">
  <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">
    <vs-card>
      <div slot="header">
        <h3>
          Create Plan 
        </h3>
      </div>
      <div>

        <vs-row vs-justify="center">
         <vs-col type="flex" vs-justify="center" vs-align="center" vs-w="11">

          <a href="{{route('manage-plans.index')}}">

              <vs-button color="danger" type="border" icon="arrow_back"></vs-button>
          
          </a>
            <br>
         <form action="{{route('manage-plans.store')}}" method="post"  id="addFrenchise" enctype="multipart/form-data">
            @csrf

            @include('store.manage-plans.form')

         <div class="row">
           <div class="col-lg-3 col-md-3 col-sm-3">
           </div>
           <div class="col-lg-5 col-md-5 col-sm-5">
            <vs-button color="primary" type="border"  id="add_frenchise" data-url="{{ route('manage-plans.store') }}">
              Create
            </vs-button>
           </div>
          </div>
        </form>
      </vs-col>
    <br>
    </vs-row>
    </div>
    
    </vs-card>
  </vs-col>
</vs-row>

@endsection

@push('js')
<script>
$(document).ready(function(){
 
  $(document).on('click', '#add_frenchise', function(e){
    e.preventDefault();
    $('body').waitMe();

    var form = $('#addFrenchise')[0];

    var data = new FormData(form);

    console.log(data.values())
    $(".error").html("");
    $.ajax({
      url: $('#addFrenchise').attr('action'),
      type:'post',
      data: data,
      cache: false,
      processData: false,  
      contentType: false,      
      success: function(data){
        success(data.message);
        window.location=data.redirectTo;
        $('body').waitMe('hide');
      }
    })
  })

  $(document).on('change', '#plan_type', function(e){
    e.preventDefault();
    $('body').waitMe();

    var form = $('#addFrenchise')[0];
    var data = new FormData(form);
    $(".error").html("");
    $.ajax({
      url: $('#plan_type').data('url'),
      type:'post',
      data: {'type': $('#plan_type').val()},
         
      success: function(data){
        //success(data.message);

        $("#plans").html(data.view);
        //window.location=data.redirectTo;
        $('body').waitMe('hide');
      }
    })
  })
  $(document).on('click', '#search-user', function(e){
      e.preventDefault(); 
      $(".error").html("")
      $('body').waitMe();      
      $.ajax({
        url: $('#search-user').data('url'),
        type:'post',
        data: {'phone_number':$('#phone').val()},
        success: function(data){
          success(data.message);
          if (data.customer) 
          {
              $('#name').val(data.customer['name']).prop('readonly', true);
            $('#email').val(data.customer['email']).prop('readonly', true);
            $('#phone').val(data.customer['phone_number']).prop('readonly', true);
            $("#customer_id").val(data.customer.id);
              
          }
          $('body').waitMe('hide');
        },
        error: function(data){

           if (data.status==422) {
            $('body').waitMe('hide');
                    var errors = data.responseJSON;
                    for (var key in errors.errors) {
                      console.log(errors.errors[key][0])
                        $("#"+key+"_error").html(errors.errors[key][0])
                      }
          }else{
            error(data.responseJSON.message);
            $('#name').val('').prop('readonly', false);
            $('#email').val('').prop('readonly', false);
            $('#phone_number').val('').prop('readonly', false);
            $("#customer_id").val("");
            $('body').waitMe('hide');
           }
        }
      })
    })
})
</script>


@endpush
