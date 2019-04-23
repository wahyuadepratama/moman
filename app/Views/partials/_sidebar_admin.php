<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item nav-profile" style="margin-top: 5%">
      <a href="jamaah-dashboard" class="nav-link">
        <div class="nav-profile-image">
          <img src="<?php $this->url('images/faces/face1.jpg') ?>" alt="profile">
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
          <h6 class="font-weight-normal mb-2"><b>Dashboard</b></h6>
        </div>

        <li class="nav-item <?php $this->active('admin/dashboard'); ?>">
          <a class="nav-link" href="#" onclick="location.href = '<?php $this->url('admin/dashboard') ?>'">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-home-modern menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php $this->active('admin/mosque'); ?> <?php $this->active('admin/mosque/add'); ?>">
          <a class="nav-link" data-toggle="collapse" href="#filter" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Mosque</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filter">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php $this->active('admin/mosque'); ?>">
                <a class="nav-link" href="#" onclick="location.href = '<?php $this->url('admin/mosque') ?>'">
                  <span class="menu-title">List Mosque</span>
                </a>
              </li>

              <li class="nav-item <?php $this->active('admin/mosque/add'); ?>">
                <a class="nav-link" href="#" onclick="location.href = '<?php $this->url('admin/mosque/add') ?>'">
                  <span class="menu-title">Add New Mosque</span>
                </a>
              </li>

            </ul>
          </div>
        </li>

        <li class="nav-item <?php $this->active('admin/stewardship');?>">
          <a class="nav-link" href="#" onclick="location.href = '<?php $this->url('admin/stewardship') ?>'">
            <span class="menu-title">Stewardship</span>
            <i class="mdi mdi-home-modern menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php $this->active('admin/facility-type');?>">
          <a class="nav-link" href="#" onclick="location.href = '<?php $this->url('admin/facility-type') ?>'">
            <span class="menu-title">Facility Type</span>
            <i class="mdi mdi-home-modern menu-icon"></i>
          </a>
        </li>

      </span>
    </li>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-2"><b>Main Menu</b></h6>
        </div>
        <li class="nav-item">
          <a class="nav-link" href="<?php $this->url('') ?>">
            <span class="menu-title">Home</span>
            <i class="mdi mdi-home menu-icon"></i>
          </a>
        </li>
        <li class="nav-item <?php $this->active('maps');?>">
          <a class="nav-link" href="<?php $this->url('maps') ?>">
            <span class="menu-title">Maps</span>
            <i class="mdi mdi-map-marker-radius menu-icon"></i>
          </a>
        </li>
        <li class="nav-item <?php $this->active('donation'); $this->active('donation/detail'); $this->active('donation/orphans'); $this->active('donation/orphans/detail');?>">
          <a class="nav-link" href="<?php $this->url('donation') ?>">
            <span class="menu-title">Donation</span>
            <i class="mdi mdi-home-modern menu-icon"></i>
          </a>
        </li>
        <li class="nav-item <?php $this->active('qurban');?>">
          <a class="nav-link" href="<?php $this->url('qurban') ?>">
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
