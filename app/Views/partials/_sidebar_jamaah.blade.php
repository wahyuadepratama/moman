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
          <span class="font-weight-bold mb-2"><?= $_SESSION['user']->name ?></span>
          <span class="text-secondary text-small"><?= $_SESSION['user']->username ?></span>
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
          <a class="nav-link" href="<?php $this->url('jamaah/dashboard') ?>">
            <span class="menu-title">Profile</span>
            <i class="mdi mdi-account-multiple menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('jamaah/qurban');  $this->active('jamaah/qurban/checking')?>">
          <a class="nav-link" href="<?php $this->url('jamaah/qurban') ?>">
            <span class="menu-title">Qurban</span>
            <i class="mdi mdi-cow menu-icon"></i>
          </a>
        </li>

        <li class="nav-item <?php active('jamaah/about');  $this->active('jamaah/about')?>">
          <a class="nav-link" href="<?php $this->url('jamaah/about?year='. date('Y')) ?>">
            <span class="menu-title">Mosque Information</span>
            <i class="mdi mdi-home menu-icon"></i>
          </a>
        </li>

      </span>
    </li>

  </ul>
</nav>
