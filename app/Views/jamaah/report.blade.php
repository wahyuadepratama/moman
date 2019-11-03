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
              <?= $_SESSION['user']->name ?> Report <?= date('Y') ?>
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
                          <th>Detail</th>
                          <th>Description</th>
                          <th>Cash In</th>
                          <th>Cash Out</th>
                        </tr>
                        <?php $n = 1; $in=0; $out=0; ?>
                        <?php foreach ($allReport as $ar): ?>

                        <?php
                          foreach ($cash_in as $key) if ($key->id == $ar->id) $c = $key;
                          foreach ($cash_out as $key) if ($key->id == $ar->id) $o = $key;
                          foreach ($jamaah as $key) if ($key->id == $c->jamaah_id) $j = $key;
                        ?>

                        <tr>
                          <td><?= $n ?></td>
                          <td>
                            <?php
                              $date = new DateTime($ar->datetime);
                              echo $date->format('l, j F Y');
                            ?>
                          </td>
                          <td>

                            <!-- Status in from cash in -->
                            <?php if ($ar->status_in == 'transfer jamaah'): ?>
                              <?php
                                if ($ar->status_out == 'project') {
                                  foreach ($project as $key) if ($key->id == $c->project_id) $pr = $key;
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
                                  echo 'Infaq from Event';
                                }elseif($ar->status_out == 'cash'){
                                  echo 'Infaq Box';
                                }
                              ?>
                            <?php endif; ?>
                            <!-- End of status in from cash in -->

                            <!-- Status out from cash out -->
                            <?php if ($ar->status_out == 'ustad payment'): ?>
                              <?php foreach ($ustad as $key) if ($key->id == $o->ustad_id) $u = $key; ?>
                              <?= 'Ustad Payment for '. $u->name ?>
                            <?php endif; ?>

                            <?php if ($ar->status_out == 'tpa payment'): ?>
                              <?php foreach ($tpa as $key) if ($key->id == $o->tpa_id) $t = $key; ?>
                              <?= 'TPA/MDA Payment for '. $t->name ?>
                            <?php endif; ?>

                            <?php if ($ar->status_out == 'orphanage payment'): ?>
                              <?php foreach ($orphan as $key) if ($key->id == $o->orphanage_id) $or = $key; ?>
                              <?= 'Orphans Payment for '. $or->name ?>
                            <?php endif; ?>

                            <?php if ($ar->status_out == 'poor payment'): ?>
                              <?php foreach ($poor as $key) if ($key->id == $o->poor_id) $p = $key; ?>
                              <?= 'Poor Payment for '. $p->name ?>
                            <?php endif; ?>

                            <?php if ($ar->status_out == 'builder payment'): ?>
                              <?= 'Builder Payment' ?>
                            <?php endif; ?>

                            <?php if ($ar->status_out == 'store payment'): ?>
                              <?php foreach ($store as $key) if ($key->id == $o->store_id) $s = $key; ?>
                              <?= 'Store Payment at '. $s->name ?>
                            <?php endif; ?>

                            <?php if ($ar->status_out == 'stewardship payment'): ?>
                              <?= 'Stewardship Payment' ?>
                            <?php endif; ?>
                            <!-- End of status out from cash out -->

                          </td>
                          <td>
                            <?php if ($ar->status_out == 'store payment'): ?>
                              <?= $ar->description ?>
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
                            <?php if ($ar->status_in == 'transfer jamaah'): ?>
                              <?php if ($ar->status_out == 'project'): ?>
                                <?= $pr->name ?>
                              <?php endif; ?>
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
                          <td colspan="4">Total</td>
                          <td>Rp <?= number_format(($in),0,',','.') ?></td>
                          <td>Rp <?= number_format(($out),0,',','.') ?></td>
                        </tr>
                      </table>
                    </div>

                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%;display:none" id="qurban">
                      <table class="table resize-font">
                        <thead style="text-align:left">
                          <tr>
                            <th>Group</th>
                            <th>Animal</th>
                            <th>Participant</th>
                            <th>Slot Used</th>
                            <th>Slot Available</th>
                            <th>Paid</th>
                            <th>Unpaid</th>
                          </tr>
                        </thead>
                        <tbody style="text-align:left">
                          <?php $paid=0; $unpaid=0; ?>
                          <?php foreach ($qurban as $key): ?>
                            <tr>
                              <?php
                                $stmt = $GLOBALS['pdo']->prepare("SELECT dq.*, j.username
                                                                  FROM detail_qurban as dq INNER JOIN jamaah as j ON dq.jamaah_id = j.id
                                                                  WHERE dq.worship_place_id=:id AND dq.year=:y AND dq.group=:g");
                                $stmt->execute(['id'=> $key->worship_place_id, 'y' => $key->year, 'g' => $key->group]);
                                $r = $stmt->fetchAll(PDO::FETCH_OBJ);
                                // $this->die($r);
                                $slot = 0;
                              ?>
                              <td><?= $key->group ?></td>
                              <td><?= $key->animal_type ?></td>
                              <td>
                                <?php foreach ($r as $val): ?>
                                  <li><?= $val->username ?></li>
                                  <?php
                                    $slot += $val->total_slot
                                  ?>
                                <?php endforeach; ?>
                              </td>
                              <td><?= $slot ?></td>
                              <td><?= $key->max_person- $slot ?></td>
                              <td>
                                <?php foreach ($r as $val): ?>
                                  Rp <?= number_format($val->fund * (int)substr($val->payment_method, 2, 1),0,',','.') ?><br>
                                  <?php $paid += $val->fund * (int)substr($val->payment_method, 2, 1) ?>
                                <?php endforeach; ?>
                              </td>
                              <td>
                                <?php foreach ($r as $val): ?>
                                  Rp <?= number_format($val->fund * (int)substr($val->payment_method, 0, 1),0,',','.') ?><br>
                                  <?php $unpaid += $val->fund * (int)substr($val->payment_method, 0, 1) ?>
                                <?php endforeach; ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                          <tr style="background-color:#ebedf2">
                            <td colspan="5" style="text-align:center">Total</td>
                            <td>Rp <?= number_format($paid, 0,',','.') ?></td>
                            <td>Rp <?= number_format($unpaid, 0,',','.') ?></td>
                          </tr>
                        </tbody>
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
