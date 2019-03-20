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
          <span class="font-weight-bold mb-2">Administrator</span>
          <span class="text-secondary text-small">Admin</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-3"><b>Dashboard Admin</b></h6>
        </div>

        <li class="nav-item <?php active('admin-dashboard');?> ">
          <a class="nav-link" href="admin-dashboard">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-elevation-rise menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('admin-management-mosque-new');?> <?php active('admin-management-mosque-list');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterMosque" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Mosque Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterMosque">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php active('admin-management-mosque-new');?>">
                <a class="nav-link" href="admin-management-mosque-new">
                  <span class="menu-title">New Mosque</span>
                  <i class="mdi mdi-plus-circle menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('admin-management-mosque-list');?>">
                <a class="nav-link" href="admin-management-mosque-list">
                  <span class="menu-title">List All Mosque</span>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>

            </ul>
          </div>
        </li>

        <li class="nav-item <?php active('admin-management-caretaker-new');?> <?php active('admin-management-caretaker-list');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterCaretaker" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Caretaker Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterCaretaker">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php active('admin-management-caretaker-new');?>">
                <a class="nav-link" href="admin-management-caretaker-new">
                  <span class="menu-title">New Caretaker</span>
                  <i class="mdi mdi-plus-circle menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('admin-management-caretaker-list');?>">
                <a class="nav-link" href="admin-management-caretaker-list">
                  <span class="menu-title">List All Mosque</span>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>

            </ul>
          </div>
        </li>

        <li class="nav-item <?php active('admin-management-transaction-donation');?> <?php active('admin-management-transaction-qurban');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterTransaction" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Transaction Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterTransaction">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php active('admin-management-transaction-donation');?>">
                <a class="nav-link" href="admin-management-transaction-donation">
                  <span class="menu-title">Donation Transaction</span>&nbsp;
                  <i class="mdi mdi-plus-circle menu-icon"></i>
                </a>
              </li>

              <li class="nav-item <?php active('admin-management-transaction-qurban');?>">
                <a class="nav-link" href="admin-management-transaction-qurban">
                  <span class="menu-title">Qurban Transaction</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>

            </ul>
          </div>
        </li>        

        <li class="nav-item <?php active('admin-event');?> ">
          <a class="nav-link" href="admin-event">
            <span class="menu-title">Event Category</span>
            <i class="mdi mdi-folder-upload menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('admin-facility');?> ">
          <a class="nav-link" href="admin-facility">
            <span class="menu-title">Facility Category</span>
            <i class="mdi mdi-filter-variant menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('admin-report');?> ">
          <a class="nav-link" href="admin-report">
            <span class="menu-title">Report</span>
            <i class="mdi mdi-note menu-icon"></i>
          </a>
        </li>

      </span>
    </li>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-3"><b>Main Menu</b></h6>
        </div>
        <li class="nav-item">
          <a class="nav-link" href="./">
            <span class="menu-title">Home</span>
            <i class="mdi mdi-home menu-icon"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="maps">
            <span class="menu-title">Maps</span>
            <i class="mdi mdi-map-marker-radius menu-icon"></i>
          </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="jamaah-dashboard">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-view-dashboard menu-icon"></i>
          </a>
        </li>
      </span>
    </li>

  </ul>
</nav>
