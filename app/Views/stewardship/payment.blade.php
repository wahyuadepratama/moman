<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <script src="<?php $this->url('script/vendors/js/vendor.bundle.base.js'); ?>"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
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

          <?php if (!empty($this->flash())): ?>
            <br><div class="alert alert-success">
              <small><?php $this->flash('print') ?></small>
            </div>
          <?php endif; ?>

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-chart-line"></i>
              </span>
              Payment of Funds
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">

                <?php
                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash' AND confirmation='true'");
                  $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                  $cashb = $stmt->fetch(PDO::FETCH_OBJ);

                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE worship_place_id=:id AND status_in='cash'");
                  $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                  $cashc = $stmt->fetch(PDO::FETCH_OBJ);

                  $cashBalance = $cashb->sum - $cashc->sum;
                ?>
                <button type="button" class="btn btn-lg btn-default">Mosque Cash Balance: &nbsp; Rp <?= number_format(($cashb->sum),0,',','.') ?> </button>

                <div class="card-body">
                  <div class="row">
                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="changeToProject()" id="navProject">Project</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToDonation()" id="navDonation">Orphans</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToTpa()" id="navTpa">TPA / MDA</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToQurban()" id="navQurban">Poor</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToEvent()" id="navEvent">Event</a>
                      </li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>
                      <li class="nav-item"><a class="nav-link" href="#"></a></li>                                            
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToCash()" id="navmosqueCash">Mosque Cash</a>
                      </li>
                    </ul>

                    <script type="text/javascript">

                    function changeToCash(){
                      var u = document.getElementById("tpa");
                      var v = document.getElementById("mosqueCash");
                      var w = document.getElementById("project");
                      var x = document.getElementById("eventM");
                      var y = document.getElementById("donation");
                      var z = document.getElementById("qurban");

                      var a = document.getElementById("navEvent");
                      var b = document.getElementById("navDonation");
                      var c = document.getElementById("navQurban");
                      var d = document.getElementById("navProject");
                      var e = document.getElementById("navmosqueCash");
                      var f = document.getElementById("navTpa");

                        u.style.display = "none";
                        v.style.display = "block";
                        w.style.display = "none";
                        x.style.display = "none";
                        y.style.display = "none";
                        z.style.display = "none";

                        a.classList.remove("active");
                        b.classList.remove("active");
                        c.classList.remove("active");
                        d.classList.remove("active");
                        e.classList.add("active");
                        f.classList.remove('active');
                    }
                    function changeToProject(){
                      var u = document.getElementById("tpa");
                      var v = document.getElementById("mosqueCash");
                      var w = document.getElementById("project");
                      var x = document.getElementById("eventM");
                      var y = document.getElementById("donation");
                      var z = document.getElementById("qurban");

                      var a = document.getElementById("navEvent");
                      var b = document.getElementById("navDonation");
                      var c = document.getElementById("navQurban");
                      var d = document.getElementById("navProject");
                      var e = document.getElementById("navmosqueCash");
                      var f = document.getElementById("navTpa");

                        u.style.display = "none";
                        v.style.display = "none";
                        w.style.display = "block";
                        x.style.display = "none";
                        y.style.display = "none";
                        z.style.display = "none";

                        a.classList.remove("active");
                        b.classList.remove("active");
                        c.classList.remove("active");
                        d.classList.add("active");
                        e.classList.remove("active");
                        f.classList.remove('active');
                    }
                      function changeToEvent(){
                        var u = document.getElementById("tpa");
                        var v = document.getElementById("mosqueCash");
                        var w = document.getElementById("project");
                        var x = document.getElementById("eventM");
                        var y = document.getElementById("donation");
                        var z = document.getElementById("qurban");

                        var a = document.getElementById("navEvent");
                        var b = document.getElementById("navDonation");
                        var c = document.getElementById("navQurban");
                        var d = document.getElementById("navProject");
                        var e = document.getElementById("navmosqueCash");
                        var f = document.getElementById("navTpa");

                          u.style.display = "none";
                          v.style.display = "none";
                          w.style.display = "none";
                          x.style.display = "block";
                          y.style.display = "none";
                          z.style.display = "none";

                          a.classList.add("active");
                          b.classList.remove("active");
                          c.classList.remove("active");
                          d.classList.remove("active");
                          e.classList.remove("active");
                          f.classList.remove('active');
                      }
                      function changeToDonation(){
                        var u = document.getElementById("tpa");
                        var v = document.getElementById("mosqueCash");
                        var w = document.getElementById("project");
                        var x = document.getElementById("eventM");
                        var y = document.getElementById("donation");
                        var z = document.getElementById("qurban");

                        var a = document.getElementById("navEvent");
                        var b = document.getElementById("navDonation");
                        var c = document.getElementById("navQurban");
                        var d = document.getElementById("navProject");
                        var e = document.getElementById("navmosqueCash");
                        var f = document.getElementById("navTpa");

                          u.style.display = "none";
                          v.style.display = "none";
                          w.style.display = "none";
                          x.style.display = "none";
                          y.style.display = "block";
                          z.style.display = "none";

                          a.classList.remove("active");
                          b.classList.add("active");
                          c.classList.remove("active");
                          d.classList.remove("active");
                          e.classList.remove("active");
                          f.classList.remove('active');
                      }
                      function changeToQurban(){
                        var u = document.getElementById("tpa");
                        var v = document.getElementById("mosqueCash");
                        var w = document.getElementById("project");
                        var x = document.getElementById("eventM");
                        var y = document.getElementById("donation");
                        var z = document.getElementById("qurban");

                        var a = document.getElementById("navEvent");
                        var b = document.getElementById("navDonation");
                        var c = document.getElementById("navQurban");
                        var d = document.getElementById("navProject");
                        var e = document.getElementById("navmosqueCash");
                        var f = document.getElementById("navTpa");

                          u.style.display = "none";
                          v.style.display = "none";
                          w.style.display = "none";
                          x.style.display = "none";
                          y.style.display = "none";
                          z.style.display = "block";

                          a.classList.remove("active");
                          b.classList.remove("active");
                          c.classList.add("active");
                          d.classList.remove("active");
                          e.classList.remove("active");
                          f.classList.remove('active');
                      }
                      function changeToTpa(){
                        var u = document.getElementById("tpa");
                        var v = document.getElementById("mosqueCash");
                        var w = document.getElementById("project");
                        var x = document.getElementById("eventM");
                        var y = document.getElementById("donation");
                        var z = document.getElementById("qurban");

                        var a = document.getElementById("navEvent");
                        var b = document.getElementById("navDonation");
                        var c = document.getElementById("navQurban");
                        var d = document.getElementById("navProject");
                        var e = document.getElementById("navmosqueCash");
                        var f = document.getElementById("navTpa");

                          u.style.display = "block";
                          v.style.display = "none";
                          w.style.display = "none";
                          x.style.display = "none";
                          y.style.display = "none";
                          z.style.display = "none";

                          a.classList.remove("active");
                          b.classList.remove("active");
                          c.classList.remove("active");
                          d.classList.remove("active");
                          e.classList.remove("active");
                          f.classList.add('active');
                      }
                    </script>

                    <!-- Project -->
                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%;" id="project">
                      <table class="table">
                        <tr style="background-color:#ebedf2">
                          <th>Year</th>
                          <th>Project Name</th>
                          <th>Detail</th>
                          <th>Cash In</th>
                          <th>Cash Out</th>
                          <th>Balance</th>
                          <th>Payment</th>
                        </tr>
                        <?php foreach ($project as $key): ?>
                          <tr>
                            <td><?= $key->date_part ?></td>
                            <td><?= $key->name ?></td>
                            <td>
                              <?php $e = $this->encrypt($key->id) ?>
                              <a onclick="window.open('<?= $this->url('donation/detail?project='. $e) ?>', '_blank');" href="#" class="btn btn-sm btn-success"> <i class="fa fa-search"></i> </a>
                            </td>
                            <?php
                              $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE project_id=:id AND status_out='project' AND confirmation='true'");
                              $stmt->execute(['id' => $key->id]);
                              $cash_in = $stmt->fetch(PDO::FETCH_OBJ);

                              $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE project_id=:id");
                              $stmt->execute(['id' => $key->id]);
                              $cash_out = $stmt->fetch(PDO::FETCH_OBJ);

                              $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE project_id=:id AND status_out='cash' AND confirmation='true'");
                              $stmt->execute(['id' => $key->id]);
                              $cash = $stmt->fetch(PDO::FETCH_OBJ);

                              $cash_out->sum = $cash_out->sum + $cash->sum;
                            ?>
                            <td>Rp <?= number_format(($cash_in->sum),0,',','.') ?></td>
                            <td>Rp <?= number_format(($cash_out->sum),0,',','.') ?></td>
                            <td>Rp <?= number_format(($cash_in->sum-$cash_out->sum),0,',','.') ?></td>
                            <td>
                              <a href="#" data-toggle="modal" data-target="#<?= $key->id ?>" class="btn btn-sm btn-success"> Use Funds</a>
                              <!-- Modal Avatar -->
                              <div class="modal fade" id="<?= $key->id ?>" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <form action="<?php $this->url('stewardship/donation/payment/project/store?id='. $key->id) ?>" method="post" enctype="multipart/form-data">

                                    <?php $this->csrf_field() ?>

                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="avatar">Use Funds to:</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">

                                        <input type="text" placeholder="Fund" name="fund" class="form-control" id="rupiah<?= $key->id ?>" style="margin-bottom:2%" required>

                                        <select class="form-control" style="color:black" name="cash_out" onchange="showDetail<?= $key->id ?>(this.value)">
                                          <option value="builder">Builder Payment</option>
                                          <option value="store">Store Payment</option>
                                          <option value="cash">Add to The Mosque Cash Balance</option>
                                        </select>

                                        <div id="formBuilder<?= $key->id ?>" style="margin-top:2%;margin-bottom:2%">
                                          <select class="js-example-basic-single form-control" name="builder">
                                            <?php
                                              $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM builder");
                                              $stmt->execute();
                                              $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            ?>
                                              <option value="0">=== Select Builder Name ===</option>
                                            <?php foreach ($b as $k): ?>
                                              <option value="<?= $k->id ?>"><?= $k->name ?></option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>

                                        <div id="formStore<?= $key->id ?>" style="display:none;margin-top:2%;margin-bottom:2%">
                                          <select class="js-example-basic-single form-control" name="store">
                                            <?php
                                              $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM store");
                                              $stmt->execute();
                                              $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                            ?>
                                              <option value="0">=== Select Store ===</option>
                                            <?php foreach ($b as $k): ?>
                                              <option value="<?= $k->id ?>"><?= $k->name ?></option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>

                                        <script type="text/javascript">
                                          // In your Javascript (external .js resource or <script> tag)
                                          $(document).ready(function() {
                                            $('.js-example-basic-single').select2({
                                          		width: '100%'
                                            });
                                          });
                                        </script>
                                        <input type="text" name="keterangan" class="form-control" id="keterangan<?= $key->id ?>" placeholder="Keterangan">
                                      </div>

                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Add</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <!-- End Modal -->
                            </td>
                          </tr>

                          <script type="text/javascript">
                            function showDetail<?= $key->id ?>(v){
                              if (v == 'cash') {
                                var x = document.getElementById("formBuilder<?= $key->id ?>");
                                var y = document.getElementById("formStore<?= $key->id ?>");
                                var z = document.getElementById("keterangan<?= $key->id ?>");
                                x.style.display = "none";
                                y.style.display = "none";
                                z.style.display = 'none';
                              }else{
                                if (v == 'builder') {
                                  var x = document.getElementById("formBuilder<?= $key->id ?>");
                                  var y = document.getElementById("formStore<?= $key->id ?>");
                                  x.style.display = "block";
                                  y.style.display = "none";
                                }
                                if (v == 'store') {
                                  var x = document.getElementById("formBuilder<?= $key->id ?>");
                                  var y = document.getElementById("formStore<?= $key->id ?>");
                                  x.style.display = "none";
                                  y.style.display = "block";
                                }
                                var z = document.getElementById("keterangan<?= $key->id ?>");
                                z.style.display = 'block';
                              }
                            }
                          </script>

                        <?php endforeach; ?>

                      </table>
                    </div>
                    <!-- End Project -->

                    <!-- Orphanage -->
                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%; display:none" id="donation">
                      <div class="row">
                        <div class="col-md-6">
                          <table class="table">
                            <tr style="background-color:#ebedf2">
                              <th>Year</th>
                              <th>Cash In</th>
                            </tr>
                            <?php $to = 0 ?>
                            <?php foreach ($orphans as $o): ?>
                              <tr>
                                <td><?= $o->date_part ?></td>
                                <td>Rp <?= number_format(($o->sum),0,',','.') ?></td>
                              </tr>
                              <?php $to = $to + $o->sum ?>
                            <?php endforeach; ?>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <table class="table">
                            <tr style="background-color:#ebedf2">
                              <td> <b>Total</b> </td>
                              <td>Rp <?= number_format(($to),0,',','.') ?></td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr style="background-color:#ebedf2">
                              <td> <b>Cash Out</b> </td>
                              <td>
                                <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE status_in='orphanage' AND worship_place_id=:worship_id ");
                                  $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
                                  $d_cash_out = $stmt->fetch(PDO::FETCH_OBJ);

                                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash' AND confirmation='true' AND status_in='orphan balance'");
                                  $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                                  $d_cash = $stmt->fetch(PDO::FETCH_OBJ);

                                  $d_cash_out->sum = $d_cash_out->sum + $d_cash->sum;
                                ?>
                                Rp <?= number_format(($d_cash_out->sum),0,',','.') ?>
                              </td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr style="background-color:#ebedf2">
                              <td> <b>Balance</b> </td>
                              <td>Rp <?= number_format(($to - $d_cash_out->sum),0,',','.') ?></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td>
                                <a href="#" data-toggle="modal" data-target="#paydonation" class="btn btn-sm btn-success form-control"> Pay for this</a>
                                <!-- Modal Avatar -->
                                <div class="modal fade" id="paydonation" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <form action="<?php $this->url('stewardship/donation/payment/orphans/store') ?>" method="post" enctype="multipart/form-data">

                                      <?php $this->csrf_field() ?>

                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="avatar">Use Funds to:</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">

                                          <input type="text" placeholder="Fund" name="fund" class="form-control" id="rupiahpay" style="margin-bottom:2%" required>

                                          <select class="form-control" style="color:black" name="cash_out" onchange="showDetailpay(this.value)">
                                            <option value="orphan">Orphanage</option>
                                            <option value="cash">Add to The Mosque Cash Balance</option>
                                          </select>

                                          <div id="formBuilderpay" style="margin-top:2%;margin-bottom:2%">
                                            <select class="js-example-basic-single form-control" name="orphan">
                                              <?php
                                                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM orphanage");
                                                $stmt->execute();
                                                $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                              ?>
                                                <option value="0">=== Select Orphanage ===</option>
                                              <?php foreach ($b as $k): ?>
                                                <option value="<?= $k->id ?>"><?= $k->name ?></option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>

                                          <script type="text/javascript">
                                            // In your Javascript (external .js resource or <script> tag)
                                            $(document).ready(function() {
                                              $('.js-example-basic-single').select2({
                                            		width: '100%'
                                              });
                                            });
                                          </script>
                                          <input type="text" name="keterangan" class="form-control" id="keteranganpay" placeholder="Keterangan">
                                        </div>

                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-success">Add</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- End Modal -->
                                <script type="text/javascript">
                                  function showDetailpay(v){
                                    if (v == 'cash') {
                                      var a = document.getElementById("formBuilderpay");
                                      var b = document.getElementById("keteranganpay");
                                      a.style.display = "none";
                                      b.style.display = "none"
                                    }else{
                                      if (v == 'orphan') {
                                        var x = document.getElementById("formBuilderpay");
                                        x.style.display = "block";
                                      }
                                      var z = document.getElementById("keteranganpay");
                                      z.style.display = 'block';
                                    }
                                  }
                                </script>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                    <!-- End Orphanage -->

                    <!-- For Poor -->
                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%; display:none" id="qurban">
                      <div class="row">
                        <div class="col-md-6">
                          <table class="table">
                            <tr style="background-color:#ebedf2">
                              <th>Year</th>
                              <th>Cash In</th>
                            </tr>
                            <?php $to = 0 ?>
                            <?php foreach ($poor as $o): ?>
                              <tr>
                                <td><?= $o->date_part ?></td>
                                <td>Rp <?= number_format(($o->sum),0,',','.') ?></td>
                              </tr>
                              <?php $to = $to + $o->sum ?>
                            <?php endforeach; ?>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <table class="table">
                            <tr style="background-color:#ebedf2">
                              <td> <b>Total</b> </td>
                              <td>Rp <?= number_format(($to),0,',','.') ?></td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr style="background-color:#ebedf2">
                              <td> <b>Cash Out</b> </td>
                              <td>
                                <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE status_in='poor' AND worship_place_id=:worship_id ");
                                  $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
                                  $d_cash_out = $stmt->fetch(PDO::FETCH_OBJ);

                                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash' AND confirmation='true' AND status_in='poor balance'");
                                  $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                                  $d_cash = $stmt->fetch(PDO::FETCH_OBJ);

                                  $d_cash_out->sum = $d_cash_out->sum + $d_cash->sum;
                                ?>
                                Rp <?= number_format(($d_cash_out->sum),0,',','.') ?>
                              </td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr style="background-color:#ebedf2">
                              <td> <b>Balance</b> </td>
                              <td>Rp <?= number_format(($to - $d_cash_out->sum),0,',','.') ?></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td>
                                <a href="#" data-toggle="modal" data-target="#poordonation" class="btn btn-sm btn-success form-control"> Pay for this</a>
                                <!-- Modal Avatar -->
                                <div class="modal fade" id="poordonation" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <form action="<?php $this->url('stewardship/donation/payment/poor/store') ?>" method="post" enctype="multipart/form-data">

                                      <?php $this->csrf_field() ?>

                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="avatar">Use Funds to:</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">

                                          <input type="text" placeholder="Fund" name="fund" class="form-control" id="rupiahpoor" style="margin-bottom:2%" required>

                                          <select class="form-control" style="color:black" name="cash_out" onchange="showDetailpoor(this.value)">
                                            <option value="poor">Poor</option>
                                            <option value="cash">Add to The Mosque Cash Balance</option>
                                          </select>

                                          <div id="formBuilderpoor" style="margin-top:2%;margin-bottom:2%">
                                            <select class="js-example-basic-single form-control" name="poor">
                                              <?php
                                                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM poor");
                                                $stmt->execute();
                                                $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                              ?>
                                                <option value="0">=== Select Poor Identity ===</option>
                                              <?php foreach ($b as $k): ?>
                                                <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>

                                          <script type="text/javascript">
                                            // In your Javascript (external .js resource or <script> tag)
                                            $(document).ready(function() {
                                              $('.js-example-basic-single').select2({
                                            		width: '100%'
                                              });
                                            });
                                          </script>
                                          <input type="text" name="keterangan" class="form-control" id="keteranganpoor" placeholder="Keterangan">
                                        </div>

                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-success">Add</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- End Modal -->
                                <script type="text/javascript">
                                  function showDetailpoor(v){
                                    if (v == 'cash') {
                                      var a = document.getElementById("formBuilderpoor");
                                      var b = document.getElementById("keteranganpoor");
                                      a.style.display = "none";
                                      b.style.display = "none"
                                    }else{
                                      if (v == 'poor') {
                                        var x = document.getElementById("formBuilderpoor");
                                        x.style.display = "block";
                                      }
                                      var z = document.getElementById("keteranganpoor");
                                      z.style.display = 'block';
                                    }
                                  }
                                </script>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                    <!-- End Poor -->

                    <!-- For TPA -->
                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%; display:none" id="tpa">
                      <div class="row">
                        <div class="col-md-6">
                          <table class="table">
                            <tr style="background-color:#ebedf2">
                              <th>Year</th>
                              <th>Cash In</th>
                            </tr>
                            <?php $to = 0 ?>
                            <?php foreach ($tpa as $o): ?>
                              <tr>
                                <td><?= $o->date_part ?></td>
                                <td>Rp <?= number_format(($o->sum),0,',','.') ?></td>
                              </tr>
                              <?php $to = $to + $o->sum ?>
                            <?php endforeach; ?>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <table class="table">
                            <tr style="background-color:#ebedf2">
                              <td> <b>Total</b> </td>
                              <td>Rp <?= number_format(($to),0,',','.') ?></td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr style="background-color:#ebedf2">
                              <td> <b>Cash Out</b> </td>
                              <td>
                                <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE status_in='tpa' AND worship_place_id=:worship_id ");
                                  $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
                                  $d_cash_out = $stmt->fetch(PDO::FETCH_OBJ);

                                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash' AND confirmation='true' AND status_in='tpa balance'");
                                  $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                                  $d_cash = $stmt->fetch(PDO::FETCH_OBJ);

                                  $d_cash_out->sum = $d_cash_out->sum + $d_cash->sum;
                                ?>
                                Rp <?= number_format(($d_cash_out->sum),0,',','.') ?>
                              </td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr style="background-color:#ebedf2">
                              <td> <b>Balance</b> </td>
                              <td>Rp <?= number_format(($to - $d_cash_out->sum),0,',','.') ?></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td>
                                <a href="#" data-toggle="modal" data-target="#tpadonation" class="btn btn-sm btn-success form-control"> Pay for this</a>
                                <!-- Modal Avatar -->
                                <div class="modal fade" id="tpadonation" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <form action="<?php $this->url('stewardship/donation/payment/tpa/store') ?>" method="post" enctype="multipart/form-data">

                                      <?php $this->csrf_field() ?>

                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="avatar">Use Funds to:</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">

                                          <input type="text" placeholder="Fund" name="fund" class="form-control" id="rupiahtpa" style="margin-bottom:2%" required>

                                          <select class="form-control" style="color:black" name="cash_out" onchange="showDetailtpa(this.value)">
                                            <option value="tpa">TPA / MDA</option>
                                            <option value="cash">Add to The Mosque Cash Balance</option>
                                          </select>

                                          <div id="formBuildertpa" style="margin-top:2%;margin-bottom:2%">
                                            <select class="js-example-basic-single form-control" name="tpa">
                                              <?php
                                                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM tpa");
                                                $stmt->execute();
                                                $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                              ?>
                                                <option value="0">=== Select TPA ===</option>
                                              <?php foreach ($b as $k): ?>
                                                <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>

                                          <script type="text/javascript">
                                            // In your Javascript (external .js resource or <script> tag)
                                            $(document).ready(function() {
                                              $('.js-example-basic-single').select2({
                                            		width: '100%'
                                              });
                                            });
                                          </script>
                                          <input type="text" name="keterangan" class="form-control" id="keterangantpa" placeholder="Keterangan">
                                        </div>

                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-success">Add</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- End Modal -->
                                <script type="text/javascript">
                                  function showDetailtpa(v){
                                    if (v == 'cash') {
                                      var a = document.getElementById("formBuildertpa");
                                      var b = document.getElementById("keterangantpa");
                                      a.style.display = "none";
                                      b.style.display = "none"
                                    }else{
                                      if (v == 'tpa') {
                                        var x = document.getElementById("formBuildertpa");
                                        x.style.display = "block";
                                      }
                                      var z = document.getElementById("keterangantpa");
                                      z.style.display = 'block';
                                    }
                                  }
                                </script>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                    <!-- End TPA -->

                    <!-- For Event -->
                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%; display:none" id="eventM">
                      <div class="row">
                        <div class="col-md-6">
                          <table class="table">
                            <tr style="background-color:#ebedf2">
                              <th>Year</th>
                              <th>Cash In</th>
                            </tr>
                            <?php $to = 0 ?>
                            <?php foreach ($event as $o): ?>
                              <tr>
                                <td><?= $o->date_part ?></td>
                                <td>Rp <?= number_format(($o->sum),0,',','.') ?></td>
                              </tr>
                              <?php $to = $to + $o->sum ?>
                            <?php endforeach; ?>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <table class="table">
                            <tr style="background-color:#ebedf2">
                              <td> <b>Total</b> </td>
                              <td>Rp <?= number_format(($to),0,',','.') ?></td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr style="background-color:#ebedf2">
                              <td> <b>Cash Out</b> </td>
                              <td>
                                <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE (status_out='ustad payment' OR status_out='stewardship payment' OR status_out='store payment')
                                                                    AND worship_place_id=:worship_id AND status_in='event'");
                                  $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
                                  $e_cash_out = $stmt->fetch(PDO::FETCH_OBJ);

                                  $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash'
                                                                    AND confirmation='true' AND status_in='event balance'");
                                  $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                                  $e_cash = $stmt->fetch(PDO::FETCH_OBJ);

                                  $e_cash_out->sum = $e_cash_out->sum + $e_cash->sum;
                                ?>
                                Rp <?= number_format(($e_cash_out->sum),0,',','.') ?>
                              </td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr style="background-color:#ebedf2">
                              <td> <b>Balance</b> </td>
                              <td>Rp <?= number_format(($to - $e_cash_out->sum),0,',','.') ?></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td>
                                <a href="#" data-toggle="modal" data-target="#eventdonation" class="btn btn-sm btn-success form-control"> Pay for this</a>
                                <!-- Modal Avatar -->
                                <div class="modal fade" id="eventdonation" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <form action="<?php $this->url('stewardship/donation/payment/event/store') ?>" method="post" enctype="multipart/form-data">

                                      <?php $this->csrf_field() ?>

                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="avatar">Use Funds to:</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">

                                          <input type="text" placeholder="Fund" name="fund" class="form-control" id="rupiahevent" style="margin-bottom:2%" required>

                                          <select class="form-control" style="color:black" name="cash_out" onchange="showDetailevent(this.value)">
                                            <option value="cash">Add to The Mosque Cash Balance</option>
                                            <option value="ustad">Ustad Payment</option>
                                            <option value="stewardship">Stewardship Payment</option>
                                            <option value="store">Store Payment</option>
                                          </select>

                                          <div id="ustad" style="margin-top:2%;margin-bottom:2%;display:none">
                                            <select class="js-example-basic-single form-control" name="ustad">
                                              <?php
                                                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM ustad");
                                                $stmt->execute();
                                                $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                              ?>
                                                <option value="0">=== Select Ustad Identity ===</option>
                                              <?php foreach ($b as $k): ?>
                                                <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>

                                          <div id="stewardship" style="margin-top:2%;margin-bottom:2%;display:none">
                                            <select class="js-example-basic-single form-control" name="stewardship">
                                              <?php
                                                $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.address, jamaah.id FROM stewardship INNER JOIN jamaah ON stewardship.jamaah_id=jamaah.id WHERE jamaah.worship_place_id=:id");
                                                $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                                                $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                              ?>
                                                <option value="0">=== Select Stewardship Identity ===</option>
                                              <?php foreach ($b as $k): ?>
                                                <option value="<?= $k->id ?>"><?= $k->username ?> (<?= $k->address ?>)</option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>

                                          <div id="store" style="margin-top:2%;margin-bottom:2%;display:none">
                                            <select class="js-example-basic-single form-control" name="store">
                                              <?php
                                                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM store");
                                                $stmt->execute();
                                                $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                              ?>
                                                <option value="0">=== Select Store ===</option>
                                              <?php foreach ($b as $k): ?>
                                                <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>

                                          <script type="text/javascript">
                                            // In your Javascript (external .js resource or <script> tag)
                                            $(document).ready(function() {
                                              $('.js-example-basic-single').select2({
                                            		width: '100%'
                                              });
                                            });
                                          </script>
                                          <input type="text" name="keterangan" class="form-control" id="keteranganevent" placeholder="Keterangan" style="display:none">
                                        </div>

                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-success">Add</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <!-- End Modal -->
                                <script type="text/javascript">
                                  function showDetailevent(v){
                                    if (v == 'cash') {
                                      var a = document.getElementById("ustad");
                                      var b = document.getElementById("stewardship");
                                      var c = document.getElementById("store");
                                      a.style.display = "none";
                                      b.style.display = "none"
                                      c.style.display = "none"

                                      var z = document.getElementById("keteranganevent");
                                      z.style.display = 'none';
                                    }else{
                                      if (v == 'ustad') {
                                        var a = document.getElementById("ustad");
                                        var b = document.getElementById("stewardship");
                                        var c = document.getElementById("store");
                                        a.style.display = "block";
                                        b.style.display = "none"
                                        c.style.display = "none"
                                      }
                                      if (v == 'stewardship') {
                                        var a = document.getElementById("ustad");
                                        var b = document.getElementById("stewardship");
                                        var c = document.getElementById("store");
                                        a.style.display = "none";
                                        b.style.display = "block"
                                        c.style.display = "none"
                                      }
                                      if (v == 'store') {
                                        var a = document.getElementById("ustad");
                                        var b = document.getElementById("stewardship");
                                        var c = document.getElementById("store");
                                        a.style.display = "none";
                                        b.style.display = "none"
                                        c.style.display = "block"
                                      }
                                      var z = document.getElementById("keteranganevent");
                                      z.style.display = 'block';
                                    }
                                  }
                                </script>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                    <!-- End for event -->

                    <!-- For mosque cash -->
                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%;display:none" id="mosqueCash">
                      <table class="table table-striped">
                        <tr>
                          <th>Mosque Cash Total</th>
                          <th>Mosque Cash Out</th>
                          <th>Balance</th>
                          <th>Action</th>
                        </tr>
                        <tr>
                          <td>Rp <?= number_format(($cashb->sum),0,',','.') ?></td>
                          <td>Rp <?= number_format(($cashc->sum),0,',','.') ?></td>
                          <td>Rp <?= number_format(($cashBalance),0,',','.') ?></td>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#cashdonation" class="btn btn-sm btn-success form-control"> Use Fund</a>
                            <!-- Start Modal -->
                            <div class="modal fade" id="cashdonation" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="<?php $this->url('stewardship/donation/payment/cash/store') ?>" method="post" enctype="multipart/form-data">

                                  <?php $this->csrf_field() ?>

                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="avatar">Use Funds to:</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">

                                      <input type="text" placeholder="Fund" name="fund" class="form-control" id="rupiahcash" style="margin-bottom:2%" required>

                                      <select class="form-control" style="color:black" name="cash_out" onchange="showDetailcash(this.value)">
                                        <option value="poor">Donation to Poor</option>
                                        <option value="orphanage">Donation to Orphanage</option>
                                        <option value="tpa">Donation to TPA</option>
                                        <option value="ustad">Ustad Payment</option>
                                        <option value="stewardship">Stewardship Payment</option>
                                        <option value="store">Store Payment</option>
                                        <option value="builder">Builder Payment</option>
                                      </select>

                                      <script type="text/javascript">
                                        function showDetailcash(v) {
                                          var a = document.getElementById("_ustad");
                                          var b = document.getElementById("_stewardship");
                                          var c = document.getElementById("_store");
                                          var d = document.getElementById("_poor");
                                          var e = document.getElementById("_project");
                                          var f = document.getElementById("_orphanage");
                                          var g = document.getElementById("_builder");
                                          var h = document.getElementById("_tpa");

                                          if (v == 'ustad') {
                                            a.style.display = "block";
                                            b.style.display = "none"
                                            c.style.display = "none"
                                            d.style.display = "none";
                                            e.style.display = "none"
                                            f.style.display = "none"
                                            g.style.display = "none"
                                            h.style.display = "none"
                                          }
                                          if (v == 'stewardship') {
                                            a.style.display = "none";
                                            b.style.display = "block"
                                            c.style.display = "none"
                                            d.style.display = "none";
                                            e.style.display = "none"
                                            f.style.display = "none"
                                            g.style.display = "none"
                                            h.style.display = "none"
                                          }
                                          if (v == 'store') {
                                            a.style.display = "none";
                                            b.style.display = "none"
                                            c.style.display = "block"
                                            d.style.display = "none";
                                            e.style.display = "none"
                                            f.style.display = "none"
                                            g.style.display = "none"
                                            h.style.display = "none"
                                          }
                                          if (v == 'poor') {
                                            a.style.display = "none";
                                            b.style.display = "none"
                                            c.style.display = "none"
                                            d.style.display = "block";
                                            e.style.display = "none"
                                            f.style.display = "none"
                                            g.style.display = "none"
                                            h.style.display = "none"
                                          }
                                          if (v == 'tpa') {
                                            a.style.display = "none";
                                            b.style.display = "none"
                                            c.style.display = "none"
                                            d.style.display = "none";
                                            e.style.display = "none"
                                            f.style.display = "none"
                                            g.style.display = "none"
                                            h.style.display = "block"
                                          }
                                          if (v == 'orphanage') {
                                            a.style.display = "none";
                                            b.style.display = "none"
                                            c.style.display = "none"
                                            d.style.display = "none";
                                            e.style.display = "none"
                                            f.style.display = "block"
                                            g.style.display = "none"
                                            h.style.display = "none"
                                          }
                                          if (v == 'builder') {
                                            a.style.display = "none";
                                            b.style.display = "none"
                                            c.style.display = "none"
                                            d.style.display = "none";
                                            e.style.display = "block"
                                            f.style.display = "none"
                                            g.style.display = "block"
                                            h.style.display = "none"
                                          }
                                        }
                                      </script>

                                      <div id="_ustad" style="margin-top:2%;margin-bottom:2%;display:none">
                                        <select class="js-example-basic-single form-control" name="ustad">
                                          <?php
                                            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM ustad");
                                            $stmt->execute();
                                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                          ?>
                                            <option value="0">=== Select Ustad Identity ===</option>
                                          <?php foreach ($b as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <div id="_stewardship" style="margin-top:2%;margin-bottom:2%;display:none">
                                        <select class="js-example-basic-single form-control" name="stewardship">
                                          <?php
                                            $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.address, jamaah.id FROM stewardship INNER JOIN jamaah ON stewardship.jamaah_id=jamaah.id WHERE jamaah.worship_place_id=:id");
                                            $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                          ?>
                                            <option value="0">=== Select Stewardship Identity ===</option>
                                          <?php foreach ($b as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->username ?> (<?= $k->address ?>)</option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <div id="_store" style="margin-top:2%;margin-bottom:2%;display:none">
                                        <select class="js-example-basic-single form-control" name="store">
                                          <?php
                                            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM store");
                                            $stmt->execute();
                                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                          ?>
                                            <option value="0">=== Select Store ===</option>
                                          <?php foreach ($b as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <div id="_project" style="margin-top:2%;margin-bottom:2%;display:none">
                                        <select class="js-example-basic-single form-control" name="project">
                                          <?php
                                            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM project WHERE worship_place_id=:id");
                                            $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                          ?>
                                            <option value="0">=== Select Project ===</option>
                                          <?php foreach ($b as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->name ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <div id="_poor" style="margin-top:2%;margin-bottom:2%;">
                                        <select class="js-example-basic-single form-control" name="poor">
                                          <?php
                                            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM poor");
                                            $stmt->execute();
                                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                          ?>
                                            <option value="0">=== Select Poor ===</option>
                                          <?php foreach ($b as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <div id="_orphanage" style="margin-top:2%;margin-bottom:2%;display:none">
                                        <select class="js-example-basic-single form-control" name="orphanage">
                                          <?php
                                            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM orphanage");
                                            $stmt->execute();
                                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                          ?>
                                            <option value="0">=== Select Orphans ===</option>
                                          <?php foreach ($b as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <div id="_builder" style="margin-top:2%;margin-bottom:2%;display:none">
                                        <select class="js-example-basic-single form-control" name="builder">
                                          <?php
                                            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM builder");
                                            $stmt->execute();
                                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                          ?>
                                            <option value="0">=== Select Builder ===</option>
                                          <?php foreach ($b as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <div id="_tpa" style="margin-top:2%;margin-bottom:2%;display:none">
                                        <select class="js-example-basic-single form-control" name="tpa">
                                          <?php
                                            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM tpa");
                                            $stmt->execute();
                                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                                          ?>
                                            <option value="0">=== Select TPA ===</option>
                                          <?php foreach ($b as $k): ?>
                                            <option value="<?= $k->id ?>"><?= $k->name ?> (<?= $k->address ?>)</option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <script type="text/javascript">
                                        // In your Javascript (external .js resource or <script> tag)
                                        $(document).ready(function() {
                                          $('.js-example-basic-single').select2({
                                            width: '100%'
                                          });
                                        });
                                      </script>
                                      <input type="text" name="keterangan" class="form-control" id="keterangancash" placeholder="Keterangan">
                                    </div>

                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-success">Add</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <!-- End Modal -->
                          </td>
                        </tr>
                      </table>
                    </div>
                    <!-- End mosque cash -->

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

  <script src="<?php $this->url('script/vendors/js/vendor.bundle.addons.js'); ?>"></script>
  <script src="<?php $this->url('script/js/off-canvas.js'); ?>"></script>
  <script src="<?php $this->url('script/js/misc.js'); ?>"></script>
  <!-- End custom js for this page-->
</body>

  <!-- for project -->
  <?php foreach ($project as $j): ?>
    <script type="text/javascript">
        var rupiah_<?= $j->id ?> = document.getElementById('rupiah<?= $j->id ?>');
        rupiah_<?= $j->id ?>.addEventListener('keyup', function(e){
          // tambahkan 'Rp.' pada saat form di ketik
          // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
          rupiah_<?= $j->id ?>.value = formatRupiah(this.value, 'Rp. ');
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
          var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split   		= number_string.split(','),
          sisa     		= split[0].length % 3,
          rupiah_<?= $j->id ?>	= split[0].substr(0, sisa),
          ribuan_<?= $j->id ?>	= split[0].substr(sisa).match(/\d{3}/gi);
          // tambahkan titik jika yang di input sudah menjadi angka ribuan
          if(ribuan_<?= $j->id ?>){
            separator_<?= $j->id ?> = sisa ? '.' : '';
            rupiah_<?= $j->id ?> += separator_<?= $j->id ?> + ribuan_<?= $j->id ?>.join('.');
          }
          rupiah_<?= $j->id ?> = split[1] != undefined ? rupiah_<?= $j->id ?> + ',' + split[1] : rupiah_<?= $j->id ?>;
          return prefix == undefined ? rupiah_<?= $j->id ?> : (rupiah_<?= $j->id ?> ? 'Rp. ' + rupiah_<?= $j->id ?> : '');
        }
        rupiah_<?= $j->id ?>.addEventListener('keyup', function(e){
          rupiah_<?= $j->id ?>.value = formatRupiah(this.value, 'Rp. ');
        });
      </script>
  <?php endforeach; ?>
  <!-- end project -->

  <!-- For orphans -->
  <script type="text/javascript">
      var rupiah_pay = document.getElementById('rupiahpay');
      rupiah_pay.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah_pay.value = formatRupiah(this.value, 'Rp. ');
      });
      /* Fungsi formatRupiah */
      function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah_pay	= split[0].substr(0, sisa),
        ribuan_pay	= split[0].substr(sisa).match(/\d{3}/gi);
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan_pay){
          separator_pay = sisa ? '.' : '';
          rupiah_pay += separator_pay + ribuan_pay.join('.');
        }
        rupiah_pay = split[1] != undefined ? rupiah_pay + ',' + split[1] : rupiah_pay;
        return prefix == undefined ? rupiah_pay : (rupiah_pay ? 'Rp. ' + rupiah_pay : '');
      }
      rupiah_pay.addEventListener('keyup', function(e){
        rupiah_pay.value = formatRupiah(this.value, 'Rp. ');
      });
    </script>
    <!-- End orphans -->

    <!-- For TPA -->
    <script type="text/javascript">
        var rupiah_tpa = document.getElementById('rupiahtpa');
        rupiah_tpa.addEventListener('keyup', function(e){
          // tambahkan 'Rp.' pada saat form di ketik
          // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
          rupiah_tpa.value = formatRupiah(this.value, 'Rp. ');
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
          var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split   		= number_string.split(','),
          sisa     		= split[0].length % 3,
          rupiah_tpa	= split[0].substr(0, sisa),
          ribuan_tpa	= split[0].substr(sisa).match(/\d{3}/gi);
          // tambahkan titik jika yang di input sudah menjadi angka ribuan
          if(ribuan_tpa){
            separator_tpa = sisa ? '.' : '';
            rupiah_tpa += separator_tpa + ribuan_tpa.join('.');
          }
          rupiah_tpa = split[1] != undefined ? rupiah_tpa + ',' + split[1] : rupiah_tpa;
          return prefix == undefined ? rupiah_tpa : (rupiah_tpa ? 'Rp. ' + rupiah_tpa : '');
        }
        rupiah_tpa.addEventListener('keyup', function(e){
          rupiah_tpa.value = formatRupiah(this.value, 'Rp. ');
        });
      </script>
    <!-- End For TPA -->

    <!-- For Poor -->
    <script type="text/javascript">
        var rupiah_poor = document.getElementById('rupiahpoor');
        rupiah_poor.addEventListener('keyup', function(e){
          // tambahkan 'Rp.' pada saat form di ketik
          // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
          rupiah_poor.value = formatRupiah(this.value, 'Rp. ');
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
          var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split   		= number_string.split(','),
          sisa     		= split[0].length % 3,
          rupiah_poor	= split[0].substr(0, sisa),
          ribuan_poor	= split[0].substr(sisa).match(/\d{3}/gi);
          // tambahkan titik jika yang di input sudah menjadi angka ribuan
          if(ribuan_poor){
            separator_poor = sisa ? '.' : '';
            rupiah_poor += separator_poor + ribuan_poor.join('.');
          }
          rupiah_poor = split[1] != undefined ? rupiah_poor + ',' + split[1] : rupiah_poor;
          return prefix == undefined ? rupiah_poor : (rupiah_poor ? 'Rp. ' + rupiah_poor : '');
        }
        rupiah_poor.addEventListener('keyup', function(e){
          rupiah_poor.value = formatRupiah(this.value, 'Rp. ');
        });
      </script>
      <!-- End Poor -->

      <!-- For Event -->
      <script type="text/javascript">
          var rupiah_event = document.getElementById('rupiahevent');
          rupiah_event.addEventListener('keyup', function(e){
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah_event.value = formatRupiah(this.value, 'Rp. ');
          });
          /* Fungsi formatRupiah */
          function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah_event	= split[0].substr(0, sisa),
            ribuan_event	= split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan_event){
              separator_event = sisa ? '.' : '';
              rupiah_event += separator_event + ribuan_event.join('.');
            }
            rupiah_event = split[1] != undefined ? rupiah_event + ',' + split[1] : rupiah_event;
            return prefix == undefined ? rupiah_event : (rupiah_event ? 'Rp. ' + rupiah_event : '');
          }
          rupiah_event.addEventListener('keyup', function(e){
            rupiah_event.value = formatRupiah(this.value, 'Rp. ');
          });
        </script>
        <!-- End Event -->

        <!-- For Mosque Cash -->
        <script type="text/javascript">
            var rupiah_cash = document.getElementById('rupiahcash');
            rupiah_cash.addEventListener('keyup', function(e){
              // tambahkan 'Rp.' pada saat form di ketik
              // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
              rupiah_cash.value = formatRupiah(this.value, 'Rp. ');
            });
            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix){
              var number_string = angka.replace(/[^,\d]/g, '').toString(),
              split   		= number_string.split(','),
              sisa     		= split[0].length % 3,
              rupiah_cash	= split[0].substr(0, sisa),
              ribuan_cash	= split[0].substr(sisa).match(/\d{3}/gi);
              // tambahkan titik jika yang di input sudah menjadi angka ribuan
              if(ribuan_cash){
                separator_cash = sisa ? '.' : '';
                rupiah_cash += separator_cash + ribuan_cash.join('.');
              }
              rupiah_cash = split[1] != undefined ? rupiah_cash + ',' + split[1] : rupiah_cash;
              return prefix == undefined ? rupiah_cash : (rupiah_cash ? 'Rp. ' + rupiah_cash : '');
            }
            rupiah_cash.addEventListener('keyup', function(e){
              rupiah_cash.value = formatRupiah(this.value, 'Rp. ');
            });
          </script>
          <!-- End Mosque Cash -->

</html>
