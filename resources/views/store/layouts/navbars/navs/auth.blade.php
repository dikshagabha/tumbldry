
<template>
  <div>
    <vs-navbar v-model="activeItem" class="nabarx">
      <div slot="title">
        <vs-navbar-title>
          
          @include('store.layouts.navbars.sidebar')
          
        </vs-navbar-title>
      </div>

      <vs-navbar-item index="0" icon="bell">
        <div class="dropdown" style="float: right; padding: 13px">
          <a href="#" onclick="return false;" role="button" data-toggle="dropdown" id="dropdownMenu1" data-target="#" style="float: left" aria-expanded="true">
              <i class="fa fa-bell-o" style="font-size: 20px; float: left; color: black">
              </i>
          </a>
          <span class="badge badge-danger notif-count"></span>
          <ul class="dropdown-menu dropdown-menu-left pull-right" role="menu" aria-labelledby="dropdownMenu1">
              <li role="presentation">
                  <a href="#" class="dropdown-menu-header">Notifications</a>
              </li>

              <ul class="timeline timeline-icons timeline-sm  " style="margin:10px;width:210px">

                @if(Auth::user()->notifications()->count())    
              @foreach(Auth::user()->notifications()->limit(5)->get() as $notifications)
                 <li><p>{{ $notifications->message }} 
                        
                  </p></li>
              @endforeach
            @else
              <a class="dropdown-item" href="#">No Notifications</a>
            @endif                                              
              <li role="presentation">
                  <a href="#" class="dropdown-menu-header"></a>
              </li>
          </ul>
      </div>
      </vs-navbar-item>
      <vs-navbar-item index="1">
         <a class="dropdown-item" href="{{ route('logout') }}">{{ __('Log out') }}</a>
      </vs-navbar-item>
     <!--  <vs-navbar-item index="2">
        <a href="#">Update</a>
      </vs-navbar-item> -->
    </vs-navbar>
  </div>
</template>

<!-- 
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="#"><h3>{{ $titlePage }}</h3></a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">Toggle navigation</span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <form class="navbar-form">
      
      </form>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link notifications"  id="navbarDropdownMenuLink" href="{{route('notifications.mark-read')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">notifications</i>
            <span class="notification">(<span class="notif-count" >{{Auth::user()->notifications()->where('read_at', 'null')->count()}}</span>)</span>
            <p class="d-lg-none d-md-block">
              {{ __('Some Actions') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">

            @if(Auth::user()->notifications)    
              @foreach(Auth::user()->notifications as $notifications)
                <a class="dropdown-item @if($notifications->read_at==null) font-weight-bold @endif" href="#">{{ $notifications->message }}</a>
              @endforeach
            @else
              <a class="dropdown-item" href="#">No Notifications</a>
            @endif
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">person</i>
            <p class="d-lg-none d-md-block">
              {{ __('Account') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="#">{{ __('Settings') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}">{{ __('Log out') }}</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
 -->