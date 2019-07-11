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
          <i><img style="width:25px" src="{{ asset('images/icons/dashboard.png') }}"></i>
          <!-- <i class="material-icons">dashboard</i> -->
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
          <i><img style="width:25px" src="{{ asset('images/icons/franchise.png') }}"></i>
           <!-- <i class="material-icons">assessment</i> -->
          <p>{{ __('Franchise') }}</p>
          
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'store' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-store.index') }}">
          <!-- <i class="material-icons">accessibility</i> -->
          <i><img style="width:25px" src="{{ asset('images/icons/store.png') }}"></i>
            <p>{{ __('Store') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'vendor' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-vendor.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/customer.png') }}"></i>
          <p>{{ __('Vendor') }}</p>
          
        </a>
      </li>
      
      <li class="nav-item{{ $activePage == 'service' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-service.index') }}">
            <i><img style="width:25px" src="{{ asset('images/icons/service.png') }}"></i>
          <p>{{ __('Service') }}</p>
          
        </a>
      </li> 

      

      <li class="nav-item {{ ($activePage == 'rate-card') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="false">
          <i><img style="width:25px" src="{{ asset('images/icons/coins.png') }}"></i>
          <p>{{ __('Rate Card') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="laravelExample">
          <ul class="nav">
            <li>
              <a class="nav-link" href="{{ route('admin.getRateCard', ['type'=>1]) }}">
                 <i><img style="width:25px" src="{{ asset('images/icons/dry-clean.png') }}"></i>
                <p>{{ __('Dry Clean') }}</p>
                
              </a>
            </li>
            <li>
              <a class="nav-link" href="{{ route('admin.getRateCard', ['type'=>2]) }}">
                 <i><img style="width:25px" src="{{ asset('images/icons/laundary.png') }}"></i>
                <p>{{ __('Laundry') }}</p>
                
              </a>
            </li>

            <li>
              <a class="nav-link" href="{{ route('admin.getRateCard', ['type'=>3]) }}">
                <i><img style="width:25px" src="{{ asset('images/icons/car.png') }}"></i>
                <p>{{ __('Car Clean') }}</p>
                
              </a>
            </li>
            <li>
              <a class="nav-link" href="{{ route('admin.getRateCard', ['type'=>4]) }}">
                <i><img style="width:25px" src="{{ asset('images/icons/shoe.png') }}"></i>
                <p>{{ __('Shoe Clean') }}</p>
                
              </a>
            </li>
             <li>
              <a class="nav-link" href="{{ route('admin.getRateCard', ['type'=>5]) }}">
                <i><img style="width:25px" src="{{ asset('images/icons/sofa.png') }}"></i>
                <p>{{ __('Sofa Clean') }}</p>
                
              </a>
            </li>
            <li>
              <a class="nav-link" href="{{ route('admin.getRateCard', ['type'=>6]) }}">
                <i><img style="width:25px" src="{{ asset('images/icons/home.png') }}"></i>
                <p>{{ __('Home Clean') }}</p>
                
              </a>
            </li>
          </ul>
        </div>
      </li>  

      <li class="nav-item{{ $activePage == 'ratecardsheet' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.getRateCardSheet') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/coins.png') }}"></i>
          <p>{{ __('Upload Rate Card Sheet') }}</p>
          
        </a>
      </li>  

      <li class="nav-item{{ $activePage == 'pickup-request' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin-pickup-request.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/pickup.png') }}"></i>
          <p>{{ __('Pickup Request') }}</p>
          
        </a>
      </li>  
       <li class="nav-item{{ $activePage == 'plans' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin-manage-plans.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/plan.png') }}"></i>
          <p>{{ __('Plans') }}</p>
          
        </a>
      </li>  
       <li class="nav-item{{ $activePage == 'supplies' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('manage-supplies.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/supply.png') }}"></i>
          <p>{{ __('Supplies') }}</p>
          
        </a>
      </li>   

      <li class="nav-item{{ $activePage == 'coupon' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('edit-coupons.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/coupon.png') }}"></i>
          <p>{{ __('Coupons') }}</p>
          
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'billing' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('billing.index') }}">
          <i><img style="width:25px" src="{{ asset('images/icons/billing.png') }}"></i>
          <p>{{ __('Billing') }}</p>          
        </a>
      </li>        
    </ul>
  </div>
</div>