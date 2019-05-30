
<template lang="html">
<!--   <div class="parentx-static"> -->


  <div class="parentx-static">

    <!-- <vs-sidebar static-position default-index="1" color="primary" class="sidebarx"  v-model="active">
    <div ref="parentSidebar" id="parentx" -->

    <vs-button   @click="active=!active, notExpand = false" color="dark" type="border" icon="menu"></vs-button>
   

    <vs-sidebar :reduce="reduce" vsBackgroundHidden :parent="$refs.parentSidebar" parent="body" default-index="{{$activePage}}"  color="primary" class="sidebarx" spacer v-model="active">
   
      <div class="header-sidebar" slot="header">
       <!--  <vs-avatar  size="70px" src="https://randomuser.me/api/portraits/men/85.jpg"/> -->
        <h4>
         {{Auth::user()->name}}
          <!-- <vs-button color="primary" icon="more_horiz" type="flat"></vs-button> -->
        </h4>
      </div>
      <vs-sidebar-item index="dashboard" icon="question_answer" href="{{ route('store.home') }}">
        Dashboard
      </vs-sidebar-item>
      <vs-sidebar-item index="runner" icon="person" href="{{ route('manage-runner.index') }}">
        Runner
      </vs-sidebar-item>
      <vs-sidebar-item index="customer" icon="verified_user" href="{{ route('manage-customer.index') }}">
        Customer
      </vs-sidebar-item>
      <vs-sidebar-item index="pickup-request" icon="account_box" href="{{ route('store-pickup-request.index') }}">
        Pickup Request
      </vs-sidebar-item>
      <vs-sidebar-item index="order" icon="question_answer" href="{{ route('store.create-order.index') }}">
        Orders
      </vs-sidebar-item>
      <vs-sidebar-item index="rates" icon="money" href="{{ route('store.getRate') }}">
        Rates
      </vs-sidebar-item>
      <vs-sidebar-group title="Reports" icon="paper">
          <vs-sidebar-item  index="customer_reports" icon="verified_user" href="{{ route('store.customer-reports') }}">
            Customer
          </vs-sidebar-item>
          <vs-sidebar-item index="order_reports" icon="question_answer" href="{{ route('store.order-reports') }}">
            Order
          </vs-sidebar-item>
      </vs-sidebar-group>
      <div class="footer-sidebar" slot="footer">
      </div>
    </vs-sidebar>
  </div>
  </div>
</template>
