    <header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="{{route('store.home')}}">
        <img class="navbar-brand-full" src="{{asset('images/logo.png')}}" width="70%" height="50" alt="CoreUI Logo">
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
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg notifications-dropdown-menu">              
        @foreach(Auth::user()->notifications()->latest()->limit(5)->get() as $notifications)
           <div class="col-md-12 notification" style="font-size: 12px;
              background: #fdfdfd;
              position: relative;
              padding: 10px;
              border-bottom: 1px solid #c8ced3;" > 
              {{ $notifications->message }} 
            </div>
        @endforeach
        </div>
        <li class="nav-item d-md-down-none">
          <a class="nav-link settings" href="#">
            <i class="fa fa-cog"></i>
          </a>
        </li>
       <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg settings-dropdown"> 
        <a href="{{ route('store.edit-profile') }}"><div class="col-md-12 notification" style="font-size: 12px;
              background: #fdfdfd;
              position: relative;
              padding: 10px;
              border-bottom: 1px solid #c8ced3;" > 
              Edit Profile
            </div>
          </a>
       <a href="{{ route('store.change-password') }}"><div class="col-md-12 notification" style="font-size: 12px;
          background: #fdfdfd;
          position: relative;
          padding: 10px;
          border-bottom: 1px solid #c8ced3;" > 
          Change Password
        </div>
      </a>             
        <a href="{{ route('logout') }}"><div class="col-md-12 notification" style="font-size: 12px;
              background: #fdfdfd;
              position: relative;
              padding: 10px;
              border-bottom: 1px solid #c8ced3;" > 
              {{ __('Log out') }}
            </div>
          </a>
        </div>
<!-- 
        <a href="{{ route('logout') }}"><button class="btn btn-danger"> {{ __('Log out') }} </button></a></li> -->
      
      </ul>
      
    </header>