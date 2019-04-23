<?php
function active($currect_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);
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
          <span class="text-secondary text-small">Jamaah</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-3"><b>Dashboard Jamaah</b></h6>
        </div>

        <li class="nav-item <?php active('jamaah-dashboard');?> <?php active('jamaah-dashboard@update');?>">
          <a class="nav-link" href="jamaah-dashboard">
            <span class="menu-title">Profile</span>
            <i class="mdi mdi-account-multiple menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('jamaah-event');?> <?php active('jamaah-report');?>">
          <a class="nav-link" data-toggle="collapse" href="#filter" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">About Mosque</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filter">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php active('jamaah-event');?>">
                <a class="nav-link" href="jamaah-event">
                  <span class="menu-title">Event</span>
                  <i class="mdi mdi-worker menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('jamaah-report');?>">
                <a class="nav-link" href="jamaah-report">
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
