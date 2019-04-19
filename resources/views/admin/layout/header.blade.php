<div class="header-advance-area">
    <div class="header-top-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="header-top-wraper">
                        <div class="row">
                            <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                <div class="menu-switcher-pro">
                                    <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                <div class="header-top-menu tabl-d-n">

                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <div class="header-right-info">
                                    <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                          <li class="nav-item">
                                          <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                          <i class="fa fa-bell" aria-hidden="true"></i>
                                          <span class="indicator-nt"></span></a>
                                            <div role="menu" class="notification-author dropdown-menu animated zoomIn">
                                                <div class="notification-single-top">
                                                    <h1>Notifications</h1>
                                                </div>
                                                <ul class="notification-menu">
                                                    <!-- <li>
                                                        <a href="#">
                                                            <div class="notification-icon">
                                                                <i class="educate-icon educate-checked edu-checked-pro admin-check-pro" aria-hidden="true"></i>
                                                            </div>
                                                            <div class="notification-content">
                                                                <span class="notification-date">16 Sept</span>
                                                                <h2>Advanda Cro</h2>
                                                                <p>Please done this project as soon possible.</p>
                                                            </div>
                                                        </a>
                                                    </li> -->
                                                    No Notifications

                                                </ul>
                                                <div class="notification-view">
                                                    <a href="#">View All Notification</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                <img src="{!! Helper::userImage() !!}" alt="" />
                                                <span class="admin-name">{{Auth::User()->name}}</span>
                                                <i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
                                              </a>
                                            <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">

                                                <!-- <li>
                                                  <a href="{{route('store.editProfile')}}"><i class="fa fa-user"></i> Edit Profile</a>
                                                </li> -->
                                                 <li>
                                                <!--<a href="#"><span class="edu-icon edu-locked author-log-ic"></span>Log Out</a> -->
                                                  <a class="dropdown-item" href="{{ route('store.logout') }}"
                                                     onclick="event.preventDefault();
                                                                   document.getElementById('logout-form').submit();">
                                                      <i class="fa fa-power-off"></i> {{ __('Logout') }}
                                                  </a>
                                                  <form id="logout-form" action="{{ route('store.logout') }}" method="POST" style="display: none;">
                                                      @csrf
                                                  </form>

                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
