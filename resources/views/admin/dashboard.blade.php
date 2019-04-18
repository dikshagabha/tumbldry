@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')

<br>
<div class="analytics-sparkle-area">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="analytics-sparkle-line reso-mg-b-30">
                    <div class="analytics-content">
                        <h5>Frenchises</h5>
                        <h2><span class="counter">{{$user->where('role', 2)->count()}}</span> </h2>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="analytics-sparkle-line reso-mg-b-30">
                    <div class="analytics-content">
                        <h5>Stores</h5>
                        <h2><span class="counter">{{$user->where('role', 3)->count()}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="analytics-sparkle-line reso-mg-b-30 table-mg-t-pro dk-res-t-pro-30">
                    <div class="analytics-content">
                        <h5>Services</h5>
                        <h2><span class="counter">{{$service}}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
