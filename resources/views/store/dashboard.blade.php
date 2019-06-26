@extends('store.layout-new.app')
@section('title', 'Dashboard')
@section("css")
<link rel="stylesheet" type="text/css" href="{{asset('css/chosen/bootstrap-chosen.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/jcf.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/chartist.css')}}">
<style>
.ct-series-a .ct-line, .ct-series-a .ct-point {
  stroke: #fec713;
}
/*.ct-chart-donut{
  webkit-animation: fa-spin 300s infinite linear;
    animation: fa-spin 300s infinite linear;
}
*/

.ct-series-a .ct-slice-pie, .ct-series-a .ct-slice-donut-solid, .ct-series-a .ct-area {
    fill: #b2d236;
}

.ct-series-b .ct-slice-pie, .ct-series-b .ct-slice-donut-solid, .ct-series-b .ct-area {
    fill: #fec713;
}
</style>
<style type='text/css'>
  .my-legend .legend-title {
    text-align: left;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 90%;
    }
  .my-legend .legend-scale ul {
    margin: 0;
    margin-bottom: 5px;
    padding: 0;
    float: left;
    list-style: none;
    }
  .my-legend .legend-scale ul li {
    font-size: 80%;
    list-style: none;
    margin-left: 0;
    line-height: 18px;
    margin-bottom: 2px;
    }
  .my-legend ul.legend-labels li span {
    display: block;
    float: left;
    height: 16px;
    width: 30px;
    margin-right: 5px;
    margin-left: 0;
    border: 1px solid #999;
    }
  .my-legend .legend-source {
    font-size: 70%;
    color: #999;
    clear: both;
    }
  .my-legend a {
    color: #777;
    }
</style>
@endsection
@section('content')
<!-- <vs-row vs-justify="center"  id="dataList">
 -->	@include('store.dashboard-list')
<!-- </vs-row>
 -->

<div id="addressModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
         <h4 class="modal-title">Customer Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
      </div>
      <div class="modal-body">
        <div id="details">
         
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection

@push('js')
<script src="{{ asset('js/chartist.js') }}"></script>
<link href='{{ asset("js/core/main.css") }}' rel='stylesheet' />
<link href='{{ asset("js/daygrid/main.css") }}' rel='stylesheet' />

<script src='{{ asset("js/core/main.js") }}'></script>
<script src='{{ asset("js/daygrid/main.js")}} '></script>
<script type="text/javascript">

  $.ajax({
    url:'{{route("store.newCustomers")}}',
    success: function(data){
      new Chartist.Line('#chart1', {
          labels: data.values,
          series: [data.data]
        });
    }
  })

  document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        $.ajax({
            url:'{{route("store.ordersEvents")}}',
            success: function(data){
              event_array=[];

              for (var key in data.data) {
                event_array.push(data.data[key]);
              }
              var calendar = new FullCalendar.Calendar(calendarEl, {
              plugins: [ 'dayGrid' ],
              events: data.data,
              eventColor: '#378006'
            });
            calendar.render();
            }
          })
      });


  $.ajax({
    url:'{{route("store.newOrders")}}',
    success: function(data){
      new Chartist.Line('#chart2', {
          labels: data.values,
          series: [data.data]
        }).on('draw',function (data) {
          $('#chart2 .ct-line').css('stroke', '#b2d236');
          $('#chart2 .ct-point').css('stroke', '#b2d236');
        });

      
    }
  })

  $.ajax({
    url:'{{route("store.ordersCompare")}}',
    success: function(data){
      var data1 = {
          labels: data.values,
          series: data.data
        };

        var options = {
          labelInterpolationFnc: function(value) {
            return value
          },
          donut: true,
          donutWidth: 60,
          donutSolid: true,
          startAngle: 270,
          showLabel: true
        };

        var responsiveOptions = [
          ['screen and (min-width: 640px)', {
            chartPadding: 30,
            labelOffset: 100,
            labelDirection: 'explode',
            labelInterpolationFnc: function(value) {
              return value;
            }
          }],
          ['screen and (min-width: 1024px)', {
            labelOffset: 80,
            chartPadding: 20
          }]
        ];
        new Chartist.Pie('#chart3', data1, options );
      
    }
  })






$(document).ready(function(){
	 $(document).on("change",".runner_select",function(e) {
      e.preventDefault();
      
      current = $(this);
      console.log(current.val());
      if (current.val() ) 
      {
        $('body').waitMe();
        $.ajax({
              url: current.attr('href'),
              data:{ 'assigned_to':current.val(), 'id':current.data('id') },
              type:"post",
              success: function(data){
                $('body').waitMe("hide");      
                success(data.message);          
                //$('.runner_select').trigger("chosen:updated");
                //$('.runner_select').chosen("destroy").chosen();
                var current_page = $(".pagination").find('.active').text();
                load_listings(location.href+'?page='+current_page, 'serach_form');
                //window.location.reload()
              },
            })
      }     
	});
	$(document).on("click",".view",function(e) {
      e.preventDefault();
      $('body').waitMe();
      current = $(this)
      $.ajax({
        url:current.attr('href'),
        method:'get',
        success:function(data){
          $('#details').html(data);
           $('body').waitMe('hide');
          $("#addressModal").modal('show');
        }
      })
    });

});
</script>
@endpush