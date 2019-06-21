<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('store.home') }}">
          <i class="material-icons">person</i>  Dashboard
        </a>
      </li>

       <li class="nav-item">
        <a class="nav-link" href="{{ route('manage-runner.index') }}">
          <i class="material-icons">person</i> Runner
        </a>
      </li>

       <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('manage-customer.index') }}">
          <i class="material-icons">verified_user</i>  Customer
        </a>
      </li>

       <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('store-pickup-request.index') }}">
          <i class="material-icons">account_box</i> Pickup Request
        </a>
      </li>
       <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('store.create-order.index') }}">
          <i class="material-icons">question_answer</i> Orders</a>
      </li>
       <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('manage-plans.index') }}">
          <i class="material-icons">money_off</i> Plans
        </a>
      </li>

      <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('store.getRate') }}">
          <i class="material-icons">money</i> Rates
        </a>
      </li>
      <li class="nav-title">Reports</li>
            <li class="nav-item ">
              <a class="nav-link" href="{{ route('store.customer-reports') }}">
                <i class="material-icons">verified_user</i> Customer</a>
              </li>
              <li class="nav-item ">
              <a class="nav-link" href="{{ route('store.order-reports')  }}">
               <i class="material-icons">question_answer</i> Orders</a>
              </li>
              <li class="nav-item ">
              <a class="nav-link" href="{{ route('store.export-settlement') }}">
                <i class="material-icons">money</i> Settlement Sheet</a>
              </li>

              </ul>
            </li>
        

      
    </ul>
  </nav>
</div>