<nav class="nav navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="<?php $this->url('') ?>"><img style="width: 60%;height: 60%;padding-top: 5px;" src="<?php $this->url('images/logo/logo.png') ?>" alt="logo"/></a>
    <a class="navbar-brand brand-logo-mini" href="<?php $this->url('') ?>"><img style="width: 100px;height: 55px;" src="<?php $this->url('images/logo/logo-mini.svg') ?>" alt="logo"/></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch" id="sidebar">
      <ul class="navbar-nav navbar-nav-right">

        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" href="<?php $this->url('') ?>">
            <p class="mb-1 text-black"><b>HOME</b></p>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" href="<?php $this->url('maps') ?>">
            <p class="mb-1 text-black"><b>MAPS</b></p>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" href="<?php $this->url('donation') ?>">
            <p class="mb-1 text-black"><b>DONATION</b></p>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" href="<?php $this->url('qurban') ?>">
            <p class="mb-1 text-black"><b>QURBAN</b></p>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" href="<?php $this->url('login') ?>">
            <p class="mb-1 text-black"><b>LOGIN</b></p>
          </a>
        </li>

      </ul>
  </div>
</nav>
