<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('store.home') }}">
          <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        </a>
      </li>

       <li class="nav-item">
        <a class="nav-link" href="{{ route('manage-runner.index') }}">
         <i class="fa fa-id-badge" aria-hidden="true"></i> Runner
        </a>
      </li>

       <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('manage-customer.index') }}">
          <i class="fa fa-check-circle-o" aria-hidden="true"></i>  Customer
        </a>
      </li>

       <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('store-pickup-request.index') }}">
          <i class="fa fa-address-book-o" aria-hidden="true"></i> Pickup Request
        </a>
      </li>
       <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('store.create-order.index') }}">
          <i class="fa fa-compass" aria-hidden="true"></i> Orders</a>
      </li>
       <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('manage-plans.index') }}">
          <i class="fa fa-link" aria-hidden="true"></i> Plans
        </a>
      </li>

      <li class="nav-item active-link">
        <a class="nav-link" href="{{ route('store.getRate') }}">
          <i class="fa fa-money" aria-hidden="true"></i> Rates
        </a>
      </li>
     

      <ul class="nav-title">Reports
        <li class="nav-item ">
          <a class="nav-link" href="{{ route('store.customer-reports') }}">
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>  Customer
          </a>
          </li>
          <li class="nav-item ">
          <a class="nav-link" href="{{ route('store.order-reports')  }}">
           <i class="fa fa-compass" aria-hidden="true"></i> Orders</a>
          </li>

          <li class="nav-item ">
          <a class="nav-link" href="{{ route('store.ledger-reports')  }}">
           <i class="fa fa-book" aria-hidden="true"></i> Ledger</a>
          </li>

          <li class="nav-item ">
          <a class="nav-link" href="{{ route('store.settlement-reports') }}">
            <i class="fa fa-money" aria-hidden="true"></i> Settlement Sheet</a>
          </li>
      </ul>     
    </ul>
  </nav>
</div>