<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item nav-profile" style="margin-top: 5%">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="<?php $this->url('images/avatar/default.jpg') ?>" alt="profile">
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

        <li class="nav-item <?php $this->active('admin/mosque'); ?> <?php $this->active('admin/mosque/add'); ?> <?php $this->active('admin/mosque/gallery'); ?>">
          <a class="nav-link" data-toggle="collapse" href="#filter" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Mosque</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="filter">
            <ul class="nav flex-column sub-menu">

              <li class="nav-item <?php $this->active('admin/mosque'); ?> <?php $this->active('admin/mosque/gallery'); ?>">
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

        <li class="nav-item <?php $this->active('admin/jamaah');?>">
          <a class="nav-link" href="#" onclick="location.href = '<?php $this->url('admin/jamaah') ?>'">
            <span class="menu-title">Jamaah</span>
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

  </ul>
</nav>
