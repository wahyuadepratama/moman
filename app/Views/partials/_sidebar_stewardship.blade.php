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
          <span class="font-weight-bold mb-2"><?= $_SESSION['user']->username ?></span>
          <span class="text-secondary text-small">Pengurus</span>
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

        <li class="nav-item <?php $this->active('stewardship/donation/dana');?> <?php $this->active('stewardship/donation/transaction');?> <?php $this->active('stewardship/donation/project');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterDonation" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Donation</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterDonation">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item <?php $this->active('stewardship/donation/project');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/donation/project') ?>">
                  <span class="menu-title">Project</span>
                  <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/donation/transaction');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/donation/transaction') ?>">
                  <span class="menu-title">Transaction</span>
                  <i class="mdi mdi-cash-multiple menu-icon"></i>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item <?php $this->active('stewardship/qurban');?>">
          <a class="nav-link" data-toggle="collapse" href="#filterQurban" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Qurban</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filterQurban">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item <?php $this->active('stewardship/qurban');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/qurban') ?>">
                  <span class="menu-title">Animal</span>
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
            <span class="menu-title">Mosque</span>
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

        <li class="nav-item <?php $this->active('stewardship/recipient/poor');
                                  $this->active('stewardship/recipient/orphanage');
                                  $this->active('stewardship/recipient/store');
                                  $this->active('stewardship/recipient/builder');
                                  $this->active('stewardship/recipient/tpa');
                                  $this->active('stewardship/recipient/ustad');?> ">
          <a class="nav-link" data-toggle="collapse" href="#recipient" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Recipient Profile</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="recipient">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item <?php $this->active('stewardship/recipient/ustad');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/recipient/ustad') ?>">
                  <span class="menu-title">Ustad</span>
                  <i class="mdi mdi-account menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/recipient/tpa');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/recipient/tpa') ?>">
                  <span class="menu-title">TPA</span>
                  <i class="mdi mdi-home menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/recipient/poor');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/recipient/poor') ?>">
                  <span class="menu-title">Poor</span>
                  <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/recipient/orphanage');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/recipient/orphanage') ?>">
                  <span class="menu-title" style="color:red">Orphanage</span>
                  <i class="mdi mdi-account-convert menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/recipient/store');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/recipient/store') ?>">
                  <span class="menu-title">Store</span>
                  <i class="mdi mdi-store menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/recipient/builder');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/recipient/builder') ?>">
                  <span class="menu-title">Builder</span>
                  <i class="mdi mdi-account-settings-variant menu-icon"></i>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item <?php $this->active('stewardship/financial/cashin');?> <?php $this->active('stewardship/financial/cashout'); $this->active('stewardship/financial/report');?>">
          <a class="nav-link" data-toggle="collapse" href="#financial" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Financial</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="financial">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item <?php $this->active('stewardship/financial/cashin');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/financial/cashout') ?>">
                  <span class="menu-title">Cash In</span>
                  <i class="mdi mdi-chart-line menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/financial/cashout');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/financial/cashout') ?>">
                  <span class="menu-title">Cash Out</span>
                  <i class="mdi mdi-chart-bar menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?php $this->active('stewardship/financial/report');?>">
                <a class="nav-link" href="<?php $this->url('stewardship/financial/report') ?>">
                  <span class="menu-title">Report</span>
                  <i class="mdi mdi-chart-histogram menu-icon"></i>
                </a>
              </li>
            </ul>
          </div>
        </li>

      </span>
    </li>

  </ul>
</nav>