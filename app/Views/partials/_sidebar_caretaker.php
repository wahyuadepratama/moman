<?php
function active($currect_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);
  clearstatcache();
  if($currect_page == $url){
      echo 'active'; //class name in css
  }
}
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item nav-profile" style="margin-top: 5%">
      <a href="jamaah-dashboard" class="nav-link">
        <div class="nav-profile-image">
          <img src="images/faces/face1.jpg" alt="profile">
          <span class="login-status online"></span> <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">Wahyu Ade Pratama</span>
          <span class="text-secondary text-small">Pengurus</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-3"><b>Dashboard Caretaker</b></h6>
        </div>

        <li class="nav-item <?php active('caretaker-dashboard'); active('caretaker-dashboard@update'); active('caretaker-dashboard-account@update');?>">
          <a class="nav-link" href="caretaker-dashboard">
            <span class="menu-title">Profile</span>
            <i class="mdi mdi-account-multiple menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('caretaker-management-donation-dana');?> <?php active('caretaker-management-donation-transaction');?> <?php active('caretaker-management-donation-type');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterDonation" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Donation Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterDonation">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php active('caretaker-management-donation-collection');?>">
                <a class="nav-link" href="caretaker-management-donation-collection">
                  <span class="menu-title">Dana Collection</span>
                  <i class="mdi mdi-cash-multiple menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('caretaker-management-donation-transaction');?>">
                <a class="nav-link" href="caretaker-management-donation-transaction">
                  <span class="menu-title">Transaction</span>
                  <i class="mdi mdi-call-split menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('caretaker-management-donation-type');?>">
                <a class="nav-link" href="caretaker-management-donation-type">
                  <span class="menu-title">Donation Type</span>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>

            </ul>
          </div>
        </li>

        <li class="nav-item <?php active('caretaker-management-qurban-collection');?> <?php active('caretaker-management-qurban-transaction');?> <?php active('caretaker-management-qurban-type');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterQurban" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Qurban Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterQurban">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php active('caretaker-management-qurban-collection');?>">
                <a class="nav-link" href="caretaker-management-qurban-collection">
                  <span class="menu-title">Dana Collection</span>
                  <i class="mdi mdi-cash-usd menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('caretaker-management-qurban-transaction');?>">
                <a class="nav-link" href="caretaker-management-qurban-transaction">
                  <span class="menu-title">Transaction</span>
                  <i class="mdi mdi-call-made menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('caretaker-management-qurban-type');?>">
                <a class="nav-link" href="caretaker-management-qurban-type">
                  <span class="menu-title">Qurban Type</span>
                  <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
                </a>
              </li>

            </ul>
          </div>
        </li>

        <li class="nav-item <?php active('caretaker-management-event-schedule');?> <?php active('caretaker-management-event-financial');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterEvent" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Event Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterEvent">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php active('caretaker-management-event-schedule');?>">
                <a class="nav-link" href="caretaker-management-event-schedule">
                  <span class="menu-title">Event Schedule</span>
                  <i class="mdi mdi-calendar-clock menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('caretaker-management-event-financial');?>">
                <a class="nav-link" href="caretaker-management-event-financial">
                  <span class="menu-title">Event Financial</span>
                  <i class="mdi mdi-chart-line menu-icon"></i>
                </a>
              </li>

            </ul>
          </div>
        </li>

        <li class="nav-item <?php active('admin-management-jamaah');?> ">
          <a class="nav-link" href="admin-management-jamaah">
            <span class="menu-title">Jamaah Management</span>
            <i class="mdi mdi-account-multiple menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('caretaker-management-facility');?>">
          <a class="nav-link" href="caretaker-management-facility">
            <span class="menu-title">Facility Management</span>
            <i class="mdi mdi-home-modern menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('caretaker-event');?> <?php active('caretaker-report');?>">
          <a class="nav-link" data-toggle="collapse" href="#filter" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">About Mosque</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filter">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php active('caretaker-event');?>">
                <a class="nav-link" href="caretaker-event">
                  <span class="menu-title">Event</span>
                  <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('caretaker-report');?>">
                <a class="nav-link" href="caretaker-report">
                  <span class="menu-title">Report</span>
                  <i class="mdi mdi-chart-line menu-icon"></i>
                </a>
              </li>

            </ul>
          </div>
        </li>

      </span>
    </li>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-2"><b>Main Menu</b></h6>
        </div>
        <li class="nav-item">
          <a class="nav-link" href="./">
            <span class="menu-title">Home</span>
            <i class="mdi mdi-home menu-icon"></i>
          </a>
        </li>
        <li class="nav-item <?php active('maps');?>">
          <a class="nav-link" href="maps">
            <span class="menu-title">Maps</span>
            <i class="mdi mdi-map-marker-radius menu-icon"></i>
          </a>
        </li>
        <li class="nav-item <?php active('donation');?>">
          <a class="nav-link" href="donation">
            <span class="menu-title">Donation</span>
            <i class="mdi mdi-home-modern menu-icon"></i>
          </a>
        </li>
        <li class="nav-item <?php active('qurban');?>">
          <a class="nav-link" href="qurban">
            <span class="menu-title">Qurban</span>
            <i class="mdi mdi-home-modern menu-icon"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="jamaah-dashboard">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-view-dashboard menu-icon"></i>
          </a>
        </li>
      </span>
    </li>

  </ul>
</nav>
