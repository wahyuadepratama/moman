<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item nav-profile" style="margin-top: 5%">
      <a href="#" class="nav-link">

        <?php if (isset($_SESSION['jamaah'])): ?>

          <?php if ($_SESSION['jamaah'] === true): ?>
            <div class="nav-profile-image">
              <img src="<?php $this->url('images/avatar/'. $_SESSION['user']->avatar) ?>" alt="profile">
              <span class="login-status online"></span> <!--change to offline or busy as needed-->
            </div>
            <div class="nav-profile-text d-flex flex-column">
              <span class="font-weight-bold mb-2"><?= $_SESSION['user']->username ?></span>
              <span class="text-secondary text-small">Jamaah</span>
            </div>
          <?php endif; ?>

        <?php else: ?>
          <div class="nav-profile-image">
            <img src="<?php $this->url('images/avatar/default.jpg') ?>" alt="profile">
            <span class="login-status online"></span> <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">Please Login</span>
            <span class="text-secondary text-small">You're not logged in</span>
          </div>
        <?php endif; ?>

      </a>
    </li>

    <?php if($this->check('maps') == true){ ?>

    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-2"><b>Maps</b></h6>
        </div>

        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#filter" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Filter</span>
            <i class="menu-arrow"></i>
          </a>
            <div class="collapse" id="filter">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item" style="margin: 3%;">
                  <input type="text" class="form-control" placeholder="Name" id="names">
                </li>
                <li class="nav-item" style="margin: 3%;">
                  <select class="form-control" style=" color:grey" id="types">
                    <option value="">All Worship Place</option>
                    <option value="1">Masjid</option>
                    <option value="2">Mushalla</option>
                  </select>
                </li>
                <li class="nav-item" style="margin: 3%">
                  <select class="form-control" style=" color:grey" id="park_area">
                    <option value="0">All Parking Area</option>
                    <option value="50">0 - 50</option>
                    <option value="100">50 - 100</option>
                    <option value="200">100 - 200</option>
                    <option value="more"> > 200</option>
                  </select>
                </li>
                <li class="nav-item" style="margin: 3%">
                  <select class="form-control" style=" color:grey" id="capacity">
                    <option value="0">All Capacity</option>
                    <option value="100">0 - 100</option>
                    <option value="300">100 - 300</option>
                    <option value="500">300 - 500</option>
                    <option value="more"> > 500</option>
                  </select>
                </li>
                <li class="nav-item" style="margin: 3%">
                  <button type="submit" class="form-control btn btn-gradient-success btn-sm" onclick="filterMasjid()">Filter</button>
                </li>
              </ul>
            </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#facility" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Facility</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="facility">
              <?php
                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM facility");
                $stmt->execute();
                $fac = $stmt->fetchAll(PDO::FETCH_OBJ);
              ?>
              <?php foreach ($fac as $f): ?>
                <div class="form-check" style="margin:3%">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" value="<?= $f->id ?>" name="facility"> <?= $f->name ?>
                  </label>
                </div>
              <?php endforeach; ?>
              <button style="margin:3%" type="submit" class="form-control btn btn-gradient-success btn-sm" onclick="filterFacility()">Filter</button>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#kegiatan" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Event</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="kegiatan">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item" style="margin: 3%;">
                <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
                <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
                <input name="date" id="datepicker" class="form-control-sm" data-date-format="mm/dd/yyyy"/>
                <script>
                    $('#datepicker').datepicker({
                        uiLibrary: 'materialdesign',
                        iconsLibrary: 'materialicons'
                    });
                </script>
              </li>
              <li class="nav-item" style="margin: 3%">
                <input type="submit" class="form-control btn btn-gradient-success btn-sm" value="Search" onclick="filterEventMasjid()">
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" onclick="tampilkanSemuaMasjid()">
            <span class="menu-title">All Mosque</span>
            <i class="mdi mdi-home-modern menu-icon"></i>
          </a>
        </li>

      </span>
    </li>

    <?php } ?>

    <?php if ($this->check('qurban') == true || $this->check('qurban/detail') == true): ?>

      <li class="nav-item sidebar-actions">
        <span class="nav-link">
          <div class="border-bottom">
            <h6 class="font-weight-normal mb-2"><b>Qurban</b></h6>
          </div>

          <li class="nav-item <?php $this->active('qurban'); $this->active('qurban/detail') ?>">
            <a class="nav-link" href="#" onclick="location.href = '<?php $this->url('qurban') ?>'">
              <span class="menu-title">Qurban at Mosque</span>
              <i class="mdi mdi-home-modern menu-icon"></i>
            </a>
          </li>

        </span>
      </li>

    <?php endif; ?>

  </ul>
</nav>
