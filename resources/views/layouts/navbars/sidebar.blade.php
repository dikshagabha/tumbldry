<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="#" class="simple-text logo-normal">
      {{ __('TumblDry') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <!-- <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Laravel Examples') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
           
          </ul>
        </div>
      </li> -->
      <li class="nav-item{{ $activePage == 'frenchise' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-frenchise.index') }}">
           <i class="material-icons">assessment</i>
          <p>{{ __('Franchise') }}</p>
          
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'store' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-store.index') }}">
          <i class="material-icons">accessibility</i>
            <p>{{ __('Store') }}</p>
        </a>
      </li>

      
      <li class="nav-item{{ $activePage == 'service' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-service.index') }}">
           <i class="material-icons">build</i>
          <p>{{ __('Service') }}</p>
          
        </a>
      </li>      
    </ul>
  </div>
</div>