<div class="wrapper ">
  @include('store.layouts.navbars.sidebar')
  <div class="main-panel">
    @include('store.layouts.navbars.navs.auth')
    @yield('content')
    @include('store.layouts.footers.auth')
  </div>
</div>