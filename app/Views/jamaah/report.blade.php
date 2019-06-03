<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <!-- end custome -->

</head>
<body>
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <?php $this->include('partials/_sidebar_jamaah'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              <?= $_SESSION['user']->name ?> Report
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">

                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="changeToEvent()" id="navEvent">Information</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToDonation()" id="navDonation">Donation's Report</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToQurban()" id="navQurban">Qurban's Report</a>
                      </li>
                    </ul>

                    <script type="text/javascript">
                      function changeToEvent(){
                          var x = document.getElementById("event");
                          var y = document.getElementById("donation");
                          var z = document.getElementById("qurban");
                          x.style.display = "block";
                          y.style.display = "none";
                          z.style.display = "none";

                          var a = document.getElementById("navEvent");
                          var b = document.getElementById("navDonation");
                          var c = document.getElementById("navQurban");
                          a.classList.add("active");
                          b.classList.remove("active");
                          c.classList.remove("active");
                      }
                      function changeToDonation(){
                          var x = document.getElementById("event");
                          var y = document.getElementById("donation");
                          var z = document.getElementById("qurban");
                          x.style.display = "none";
                          y.style.display = "block";
                          z.style.display = "none";

                          var a = document.getElementById("navEvent");
                          var b = document.getElementById("navDonation");
                          var c = document.getElementById("navQurban");
                          a.classList.remove("active");
                          b.classList.add("active");
                          c.classList.remove("active");
                      }
                      function changeToQurban(){
                          var x = document.getElementById("event");
                          var y = document.getElementById("donation");
                          var z = document.getElementById("qurban");
                          x.style.display = "none";
                          y.style.display = "none";
                          z.style.display = "block";

                          var a = document.getElementById("navEvent");
                          var b = document.getElementById("navDonation");
                          var c = document.getElementById("navQurban");
                          a.classList.remove("active");
                          b.classList.remove("active");
                          c.classList.add("active");
                      }
                    </script>

                    <div class="col-md-12 table-responsive" style="margin-top:2%" id="event">
                      <table class="table">
                        <tr>
                          <td>Name</td>
                          <td>:</td>
                          <td><?= $q->name ?></td>
                        </tr>
                        <tr>
                          <td>Address</td>
                          <td>:</td>
                          <td><?= $q->address ?></td>
                        </tr>
                        <tr>
                          <td>Capacity</td>
                          <td>:</td>
                          <td><?= $q->capacity ?> Jamaah</td>
                        </tr>
                        <tr>
                          <td>Park Area Size</td>
                          <td>:</td>
                          <td><?= $q->park_area_size ?> m<sup>2</sup> </td>
                        </tr>
                        <tr>
                          <td>Location</td>
                          <td>:</td>
                          <td> <a href="<?php $this->url('maps') ?>" class="btn btn-sm btn-success">Got to Maps</a> </td>
                        </tr>
                      </table>
                      <div style="text-align:center;margin-top:5%;">
                        <table class="table">
                          <tr style="background-color:#ebedf2">
                            <th>Event</th>
                            <th>Description</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Ustad/Pengisi Acara</th>
                          </tr>
                          <?php foreach ($q->event as $f): ?>
                            <tr>
                              <td><?= $f->name ?></td>
                              <td><?= $f->description ?></td>
                              <td><?= $f->schedule ?></td>
                              <td><?= $f->status ?></td>
                              <td><?= $f->ustad ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </table>
                      </div>
                      <div style="text-align:center;margin-top:5%;">
                        <table class="table">
                          <tr style="background-color:#ebedf2">
                            <th>Facility</th>
                            <th>Total</th>
                            <th>Condition</th>
                            <th>Last Updated</th>
                          </tr>
                          <?php foreach ($q->facility as $f): ?>
                            <tr>
                              <td><?= $f->name ?></td>
                              <td><?= $f->total ?></td>
                              <td><?= $f->condition ?></td>
                              <td><?= $f->updated_at ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </table>
                      </div>
                    </div>

                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%; display:none" id="donation">
                      <style media="screen">
                        table.resize-font tr th { font-size: 13px; }
                        table.resize-font tr td { font-size: 13px; }
                      </style>
                      <h4 style="display:none;text-align:center;margin:5%" id='title'>Report <?= $_GET['type'] ?> <?= $_SESSION['user']->name ?> on <?= $d ?> <?= $_GET['year'] ?></h4>
                      <table class="table resize-font">
                        <tr style="background-color:#ebedf2">
                          <th>No</th>
                          <th>Date</th>
                          <th>Description</th>
                          <th>Cash In</th>
                          <th>Cash Out</th>
                        </tr>
                        <?php $n = 1; $in=0; $out=0; ?>
                        <?php foreach ($allReport as $ar): ?>
                        <tr>
                          <td><?= $n ?></td>
                          <td>
                            <?php
                              $date = new DateTime($ar->datetime);
                              echo $date->format('l, j F Y');
                            ?>
                          </td>
                          <td>
                            <?php if ($ar->status_in == 'transfer jamaah'): ?>
                              <?php
                                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM cash_in WHERE id=:id");
                                $stmt->execute(['id' => $ar->id]);
                                $c = $stmt->fetch(PDO::FETCH_OBJ);

                                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah WHERE id=:jamaah_id");
                                $stmt->execute(['jamaah_id' => $c->jamaah_id]);
                                $j = $stmt->fetch(PDO::FETCH_OBJ);

                                if ($ar->status_out == 'project') {
                                  echo 'Infaq Mosque from '; echo ($c->public == 'true') ? $j->username : 'Hamba Allah';
                                }elseif($ar->status_out == 'tpa'){
                                  echo 'Infaq TPA/MDA from '; echo ($c->public == 'true') ? $j->username : 'Hamba Allah';
                                }elseif($ar->status_out == 'orphanage'){
                                  echo 'Infaq Orphans from '; echo ($c->public == 'true') ? $j->username : 'Hamba Allah';
                                }elseif($ar->status_out == 'poor'){
                                  echo 'Infaq for Poor from '; echo ($c->public == 'true') ? $j->username : 'Hamba Allah';
                                }
                              ?>
                            <?php endif; ?>
                            <?php if ($ar->status_in == 'cash jamaah'): ?>
                              <?php
                                if ($ar->status_out == 'project') {
                                  echo 'Infaq for Mosque ('. $ar->description .')';
                                }elseif($ar->status_out == 'tpa'){
                                  echo 'Infaq for TPA/MDA ('. $ar->description .')';
                                }elseif($ar->status_out == 'orphanage'){
                                  echo 'Infaq for Orphans ('. $ar->description .')';
                                }elseif($ar->status_out == 'poor'){
                                  echo 'Infaq for Poor ('. $ar->description .')';
                                }
                              ?>
                            <?php endif; ?>
                            <?php if ($ar->status_in == 'infaq box'): ?>
                              <?php
                                if ($ar->status_out == 'event') {
                                  echo $ar->description;
                                }elseif($ar->status_out == 'cash'){
                                  echo $ar->description;
                                }
                              ?>
                            <?php endif; ?>
                            <?php if ($ar->status_out == 'ustad payment'): ?>
                              <?= 'Ustad Payment' ?>
                            <?php endif; ?>
                            <?php if ($ar->status_out == 'tpa payment'): ?>
                              <?= 'TPA/MDA Payment' ?>
                            <?php endif; ?>
                            <?php if ($ar->status_out == 'orphanage payment'): ?>
                              <?= 'Orphans Payment' ?>
                            <?php endif; ?>
                            <?php if ($ar->status_out == 'poor payment'): ?>
                              <?= 'Poor Payment' ?>
                            <?php endif; ?>
                            <?php if ($ar->status_out == 'builder payment'): ?>
                              <?= 'Builder Payment' ?>
                            <?php endif; ?>
                            <?php if ($ar->status_out == 'store payment'): ?>
                              <?= 'Store Payment' ?>
                            <?php endif; ?>
                            <?php if ($ar->status_out == 'stewardship payment'): ?>
                              <?= 'Stewardship Payment' ?>
                            <?php endif; ?>
                          </td>

                          <?php if ($ar->status_in == 'transfer jamaah' || $ar->status_in == 'cash jamaah' || $ar->status_in == 'infaq box'): ?>

                            <td> Rp <?= number_format(($ar->fund),0,',','.') ?> </td>
                            <td> - </td>
                            <?php $in = $in + $ar->fund ?>
                          <?php else: ?>

                            <td> - </td>
                            <td> Rp <?= number_format(($ar->fund),0,',','.') ?> </td>
                            <?php $out = $out + $ar->fund ?>

                          <?php endif; ?>

                        </tr>
                        <?php $n++ ?>
                        <?php endforeach; ?>
                        <tr style="background-color:#ebedf2">
                          <td colspan="3">Total</td>
                          <td>Rp <?= number_format(($in),0,',','.') ?></td>
                          <td>Rp <?= number_format(($out),0,',','.') ?></td>
                        </tr>
                        <tr><td colspan="5"></td></tr>
                        <tr style="background-color:#ebedf2">
                          <td colspan="3">Saldo All Donation on May <?= date('Y') ?></td>
                          <?php if ($in-$out < 0): ?>
                          <td colspan="2">Rp <?= number_format((0),0,',','.') ?> <br><br>(Use of Rp <?= number_format(($out-$in),0,',','.') ?> Mosque Cash)</td>
                          <?php else: ?>
                          <td colspan="2">Rp <?= number_format(($in-$out),0,',','.') ?></td>
                          <?php endif; ?>
                        </tr>
                      </table>
                    </div>

                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%;display:none" id="qurban">
                      <table class="table resize-font">
                        <tr style="background-color:#ebedf2">
                          <th>No</th>
                          <th>Qurban</th>
                          <th>Fund</th>
                          <th style="text-align:left">Participant</th>
                        </tr>
                        <?php $tot=0 ?>
                        <?php foreach ($qurban as $q): ?>
                          <tr>
                            <td>#<?= $q->worship_place_id ?><?= $q->grup ?><?= $q->year ?></td>
                            <td><?= $q->animal_type ?></td>
                            <td>Rp <?= number_format(($q->fund),0,',','.') ?></td>
                            <td style="text-align:left">

                                <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM participant WHERE grup=:grup AND year=:year AND worship_place_id=:id");
                                  $stmt->execute(['grup' => $q->grup, 'year' => $q->year, 'id' => $q->worship_place_id]);
                                  $part = $stmt->fetchAll(PDO::FETCH_OBJ);
                                ?>
                                <?php foreach ($part as $p): ?>
                                  <li><?= $p->name ?></li>
                                <?php endforeach; ?>

                            </td>
                          </tr>
                          <?php $tot = $tot + $q->fund ?>
                        <?php endforeach; ?>
                        <tr style="background-color:#ebedf2">
                          <td colspan="2">Total</td>
                          <td>Rp <?= number_format(($tot),0,',','.') ?></td>
                          <td></td>
                        </tr>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- content-wrapper ends -->

        <!-- partial:partials/_footer.php -->
        <?php $this->include('partials/_footer'); ?>
        <!-- partial -->

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?php $this->include('partials/_plugin'); ?>

  <!-- Custom js for this page-->
  <script src="script/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
