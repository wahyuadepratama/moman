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
      <?php $this->include('partials/_sidebar_stewardship'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-chart-line"></i>
              </span>
              Report
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">

                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="changeToDonation()" id="navDonation">Donation</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToQurban()" id="navQurban">Qurban</a>
                      </li>
                    </ul>

                    <script type="text/javascript">
                      function changeToDonation(){
                          var y = document.getElementById("donation");
                          var z = document.getElementById("qurban");
                          y.style.display = "block";
                          z.style.display = "none";

                          var b = document.getElementById("navDonation");
                          var c = document.getElementById("navQurban");
                          b.classList.add("active");
                          c.classList.remove("active");
                      }
                      function changeToQurban(){
                          var y = document.getElementById("donation");
                          var z = document.getElementById("qurban");
                          y.style.display = "none";
                          z.style.display = "block";

                          var b = document.getElementById("navDonation");
                          var c = document.getElementById("navQurban");
                          b.classList.remove("active");
                          c.classList.add("active");
                      }
                    </script>

                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%;" id="donation">
                      <form action="<?php $this->url('stewardship/report') ?>" method="get">
                        <div class="row" style="margin-top:0.5%;margin-bottom:3%">
                          <div class="col-md-2">
                            <select class="form-control" style="color:black" name="year">
                              <option value="<?= $_GET['year'] ?>"><?= $_GET['year'] ?></option>
                              <option value="2018">2018</option>
                              <option value="2019">2019</option>
                              <option value="2020">2020</option>
                            </select>
                          </div>
                          <div class="col-md-2">
                            <select class="form-control" style="color:black" name="month">
                              <option value="<?= $_GET['month'] ?>">
                                            <?php
                                            if ($_GET['month']=='1') {$d = 'January';
                                            }elseif($_GET['month']=='2'){$d = 'February';
                                            }elseif($_GET['month']=='3'){$d = 'March';
                                            }elseif($_GET['month']=='4'){$d = 'April';
                                            }elseif($_GET['month']=='5'){$d = 'May';
                                            }elseif($_GET['month']=='6'){$d = 'June';
                                            }elseif($_GET['month']=='7'){$d = 'July';
                                            }elseif($_GET['month']=='8'){$d = 'August';
                                            }elseif($_GET['month']=='9'){$d = 'September';
                                            }elseif($_GET['month']=='10'){$d = 'October';
                                            }elseif($_GET['month']=='11'){$d = 'November';
                                            }else{$d = 'December';}
                                            echo $d;
                                            ?>
                              </option>
                              <option value="1">January</option>
                              <option value="2">February</option>
                              <option value="3">March</option>
                              <option value="4">April</option>
                              <option value="5">May</option>
                              <option value="6">June</option>
                              <option value="7">July</option>
                              <option value="8">Augut</option>
                              <option value="9">September</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="12">December</option>
                            </select>
                          </div>
                          <div class="col-md-3">
                            <select class="form-control" style="color:black" name="type">
                              <option value="<?= $_GET['type'] ?>"><?= $_GET['type'] ?></option>
                              <option value="Infaq Project Construction">Infaq Project Construction</option>
                              <option value="Infaq TPA/MDA">TPA/MDA Report</option>
                              <option value="Infaq Poor">Poor Report</option>
                              <option value="Infaq Orphan">Orphan Report</option>
                              <option value="Infaq Event">Event Report</option>
                              <option value="All Donation">All Donation</option>
                            </select>
                          </div>
                          <div class="col-md-2">
                            <input type="submit" class="btn btn-sm btn-danger form-control" value="Filter">
                          </div>
                          <div class="col-md-1"></div>
                          <div class="col-md-2">
                            <a href="#" class="btn btn-sm btn-success form-control" onclick="printDiv('printableArea')">Print</a>
                            <script type="text/javascript">
                              function printDiv(divName) {
                                   var printContents = document.getElementById(divName).innerHTML;
                                   var originalContents = document.body.innerHTML;
                                   document.body.innerHTML = printContents;
                                   document.getElementById('title').style.display = 'block';
                                   window.print();
                                   document.body.innerHTML = originalContents;
                              }
                            </script>
                          </div>
                        </div>
                      </form>
                      <div id='printableArea'>
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
                          <tr><td colspan="6"></td></tr>
                          <tr style="background-color:#ebedf2">
                            <td colspan="4">Saldo <?= $_GET['type'] ?> on <?= $d ?> <?= $_GET['year'] ?></td>
                            <?php if ($in-$out < 0): ?>
                            <td colspan="2">Rp <?= number_format((0),0,',','.') ?> <br><br>(Use of Rp <?= number_format(($out-$in),0,',','.') ?> Mosque Cash)</td>
                            <?php else: ?>
                            <td colspan="2">Rp <?= number_format(($in-$out),0,',','.') ?></td>
                            <?php endif; ?>
                          </tr>
                        </table>
                      </div>
                    </div>

                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%;display:none" id="qurban">
                      <form action="<?php $this->url('stewardship/report') ?>" method="get">
                        <div class="row" style="margin-top:0.5%;margin-bottom:3%">
                          <div class="col-md-2">
                            <input type="hidden" name="type" value="All Donation">
                            <input type="hidden" name="month" value="<?= date('m') ?>">
                            <select class="form-control" style="color:black" name="year">
                              <option value="<?= $_GET['year'] ?>"><?= $_GET['year'] ?></option>
                              <option value="2018">2018</option>
                              <option value="2019">2019</option>
                              <option value="2020">2020</option>
                            </select>
                          </div>
                          <div class="col-md-2">
                            <input type="submit" class="btn btn-sm btn-danger form-control" value="Filter">
                          </div>
                          <div class="col-md-6"></div>
                          <div class="col-md-2">
                            <a href="#" class="btn btn-sm btn-success form-control" onclick="printDivQ('printableAreaQ')">Print</a>
                            <script type="text/javascript">
                              function printDivQ(divName) {
                                   var printContents = document.getElementById(divName).innerHTML;
                                   var originalContents = document.body.innerHTML;
                                   document.body.innerHTML = printContents;
                                   document.getElementById('titleQ').style.display = 'block';
                                   window.print();
                                   document.body.innerHTML = originalContents;
                              }
                            </script>
                          </div>
                        </div>
                      </form>
                      <div id='printableAreaQ'>
                        <h4 style="display:none;text-align:center;margin:5%" id='titleQ'>Report Qurban <?= $_GET['year'] ?></h4>
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

  <!-- End custom js for this page-->
</body>

</html>
