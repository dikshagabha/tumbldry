@include('store.layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page">
  <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('{{ asset('material') }}/img/store_login.jpg'); background-size: cover; background-position: top center;align-items: center;" data-color="green">
  <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    @yield('content')
    
    @include('store.layouts.footers.guest')
  </div>
</div>
