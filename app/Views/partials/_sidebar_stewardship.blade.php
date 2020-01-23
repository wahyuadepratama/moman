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
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="<?php $this->url('images/avatar/'. $_SESSION['user']->avatar) ?>" alt="profile">
          <span class="login-status online"></span> <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2"><?= $_SESSION['user']->jamaah_name ?></span>
          <span class="text-secondary text-small">@<?= $_SESSION['user']->username ?></span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-3"><b>Dashboard Stewardship</b></h6>
        </div>

        <li class="nav-item <?php $this->active('stewardship/dashboard');?>">
          <a class="nav-link" href="<?php $this->url('stewardship/dashboard') ?>">
            <span class="menu-title">Account</span>
            <i class="mdi mdi-account-multiple menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php $this->active('stewardship/qurban');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterQurban" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Qurban</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterQurban">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item <?php $this->active('stewardship/qurban');?> <?php $this->active('stewardship/qurb/group'); ?>">
                <a class="nav-link" href="<?php $this->url('stewardship/qurban') ?>">
                  <span class="menu-title">Management</span>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/qur/detail');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/qur/detail') ?>">
                  <span class="menu-title">Transaction</span>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item <?php $this->active('stewardship/mosque/event');
                                  $this->active('stewardship/mosque/schedule');?>">
          <a class="nav-link" data-toggle="collapse" href="#event" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Mosque Management</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="event">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item <?php $this->active('stewardship/mosque/event');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/mosque/event') ?>">
                  <span class="menu-title">Event</span>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/mosque/schedule');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/mosque/schedule') ?>">
                  <span class="menu-title">Schedule</span>
                  <i class="mdi mdi-calendar-clock menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/mosque/jamaah');?> ">
                <a class="nav-link" href="<?php $this->url('stewardship/mosque/jamaah') ?>">
                  <span class="menu-title">Jamaah</span>
                  <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/mosque/facility');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/mosque/facility') ?>">
                  <span class="menu-title">Facility</span>
                  <i class="mdi mdi-home-modern menu-icon"></i>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item <?php $this->active('stewardship/recipient/ustad');?> ">
          <a class="nav-link" href="<?php $this->url('stewardship/recipient/ustad') ?>">
            <span class="menu-title">Data Ustad</span>
            <i class="mdi mdi-account menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php $this->active('stewardship/report');?>">
          <a class="nav-link" href="<?php $this->url('stewardship/report?year='. date('Y')) ?>">
            <span class="menu-title">Qurban Report</span>
            <i class="mdi mdi-chart-line menu-icon"></i>
          </a>
        </li>

      </span>
    </li>

  </ul>
</nav>
