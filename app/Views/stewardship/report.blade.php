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
                            <td colspan="3">Saldo <?= $_GET['type'] ?> on <?= $d ?> <?= $_GET['year'] ?></td>
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
