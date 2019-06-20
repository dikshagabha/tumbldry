    <header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="{{asset('images/logo.png')}}" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="{{asset('images/logo.png')}}" width="30" height="30" alt="CoreUI Logo">
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <ul class="nav navbar-nav ml-auto">
        <li class="nav-item d-md-down-none">
          <a class="nav-link notifications" href="{{ route('notifications.mark-read') }}" >
            <i class="fa fa-bell"></i>
            <span class="badge badge-pill badge-danger notif-count"> {{Auth::user()->notifications()->where('read_at',null)->count()}}</span>
          </a>
        </li>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">              
        @foreach(Auth::user()->notifications()->limit(5)->get() as $notifications)
           <div class="col-md-12 notification" style="font-size: 12px;
              background: #fdfdfd;
              position: relative;
              padding: 10px;
              border-bottom: 1px solid #c8ced3;" > 
            {{ $notifications->message }} 
                  
            </div>

        @endforeach
        </div>
        <!-- vs-navbar-item icon="bell">
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
      </vs-navbar-item> -->

      <li><a class="dropdown-item" href="{{ route('logout') }}">{{ __('Log out') }}</a></li>
      
      </ul>
      
    </header>