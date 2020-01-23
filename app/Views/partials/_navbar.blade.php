<?php
function activeNav($currect_page){
  $get_url    = ltrim($_SERVER['REQUEST_URI'], '/');
  $get_url    = explode('?', $get_url, 2);
  $get_url    = $get_url[0];
  if($currect_page === $get_url){
      echo "style='color:#058A48'"; //class name in css
  }
}
?>

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="<?php $this->url('') ?>"><img style="width: 60%;height: 60%;padding-top: 5px;" src="<?php $this->url('images/logo/logo.png') ?>" alt="logo"/></a>
    <a class="navbar-brand brand-logo-mini" href="<?php $this->url('') ?>"><img style="width: 100px;height: 55px;" src="<?php $this->url('images/logo/logo-mini.svg') ?>" alt="logo"/></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <style media="screen">@media only screen and (max-width: 768px) {.hiddenthis{display: block !important;}}</style>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item d-none d-lg-block full-screen-link">
        <a class="nav-link" href="<?php $this->url('') ?>">
          <h5>Home</h5>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item d-none d-lg-block full-screen-link" <?php activeNav('maps') ?>>
        <a class="nav-link" href="<?php $this->url('maps') ?>">
          <h5>Maps</h5>
        </a>
      </li>
    </ul>    
    <ul class="navbar-nav">
      <li class="nav-item d-none d-lg-block full-screen-link" <?php activeNav('qurban') ?>>
        <a class="nav-link" href="<?php $this->url('qurban') ?>">
          <h5>Qurban</h5>
        </a>
      </li>
    </ul>

    <!-- menu tampilan mobile -->
    <ul class="navbar-nav hiddenthis" style="display:none">
      <li class="nav-item dropdown">
        <a class="nav-link" id="topmenu" href="#" data-toggle="dropdown" aria-expanded="false">
          <span class="mdi mdi-menu"></span> &nbsp; Menu
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="1">
          <a class="nav-link" href="<?php $this->url('') ?>">
            <h5>Home</h5>
          </a>
          <a class="nav-link" href="<?php $this->url('maps') ?>">
            <h5>Maps</h5>
          </a>
          <a class="nav-link" href="<?php $this->url('donation') ?>">
            <h5>Mosque</h5>
          </a>
          <a class="nav-link" href="<?php $this->url('donation/orphans') ?>">
            <h5>Orphans</h5>
          </a>
          <a class="nav-link" href="<?php $this->url('donation/poor') ?>">
            <h5>Poor</h5>
          </a>
          <a class="nav-link" href="<?php $this->url('donation/tpa') ?>">
            <h5>TPA/MDA</h5>
          </a>
          <a class="nav-link" href="<?php $this->url('qurban') ?>">
            <h5>Qurban</h5>
          </a>
        </div>
      </li>
    </ul>
    <!-- end of tampilan mobile -->

    <?php if (isset($_SESSION['jamaah'])): ?>
      <?php if ($_SESSION['jamaah'] === true): ?>
        <ul class="navbar-nav">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="<?php $this->url('images/avatar/'. $_SESSION['user']->avatar) ?>" alt="image">
                <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?= $_SESSION['user']->jamaah_name ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <div class="dropdown-divider"></div>
              <?php if (isset($_SESSION['stewardship'])): ?>
                <?php if ($_SESSION['stewardship'] === true): ?>
                  <a class="dropdown-item" href="<?php $this->url('stewardship/dashboard') ?>">
                    <i class="mdi mdi-view-dashboard mr-2 text-danger"></i>
                     Stewardship Area
                  </a>
                <?php endif; ?>
              <?php endif; ?>
              <?php if (isset($_SESSION['jamaah'])): ?>
                <?php if ($_SESSION['jamaah'] === true): ?>
                  <a class="dropdown-item" href="<?php $this->url('jamaah/dashboard') ?>">
                    <i class="mdi mdi-account-box mr-2 text-danger"></i>
                     Jamaah Area
                  </a>
                <?php endif; ?>
              <?php endif; ?>
              <a class="dropdown-item" href="<?php $this->url('logout') ?>">
                <i class="mdi mdi-logout mr-2 text-danger"></i>
                Signout
              </a>
            </div>
          </li>
        </ul>
      <?php endif; ?>
    <?php elseif (isset($_SESSION['admin'])): ?>
      <?php if ($_SESSION['admin'] === true): ?>
        <ul class="navbar-nav">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="<?php $this->url('images/avatar/default.jpg') ?>" alt="image">
                <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?= $_SESSION['user']->username ?></p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php $this->url('logout') ?>">
                <i class="mdi mdi-logout mr-2 text-danger"></i>
                Signout
              </a>
            </div>
          </li>
        </ul>
      <?php endif; ?>
    <?php else: ?>
      <ul class="navbar-nav">
        <li class="nav-item d-none d-lg-block full-screen-link">
          <a class="nav-link" href="<?php $this->url('login') ?>">
            <h5>Login</h5>
          </a>
        </li>
      </ul>
    <?php endif; ?>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
