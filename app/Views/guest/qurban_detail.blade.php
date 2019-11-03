<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Script for maps -->

  <!-- end of script -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <?php $this->include('style/_profile'); ?>
  <!-- end custome -->

</head>
<body onload="loading()">

  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <!-- $this->include('partials/_sidebar') -->
      <!-- partial -->

      <div class=""><!-- <div class="main-panel"> -->
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              Qurban <?= $_GET['mosque'] ?>
            </h3>
          </div>

          <div class="row">
            <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="row">
                  <?php $t = 1000; ?>
                  <?php foreach ($qurban as $d): ?>
                    <div class="<?= (count($qurban) == 1) ? 'col-md-12' : 'col-md-6' ?> grid-margin">
                      <div class="card">
                        <style media="screen">
                          .effect{transform-origin: 50% 65%;transition: transform 15s, filter 6s ease-in-out;filter: brightness(70%);height: 150px;color:white}
                          .fund {position: absolute;bottom: 1px;left: 20px;background-color: rgba(0,0,0,.5);border-radius: 5%;color: white;padding-left: 5px;padding-right: 10px;}
                        </style>

                        <div class="effect" style="position:relative">
                          <p style="bottom: 20% !important" class="fund"> <i class="mdi mdi-cow"></i>&nbsp; <?= $d->animal_type ?></p>
                          <p class="fund"> <i class="mdi mdi-account-multiple"></i>&nbsp; Max: <?= $d->max_person ?> Person</p>

                          <?php if ($d->max_person == '1'): ?>
                            <img class="d-block w-100" src="<?php $this->url('images/goat.jpg') ?>" style="object-fit:cover" height="180">
                          <?php endif; ?>

                          <?php if ($d->max_person == '7'): ?>
                            <img class="d-block w-100" src="<?php $this->url('images/cow.jpg') ?>" style="object-fit:cover" height="180">
                          <?php endif; ?>

                          <?php if ($d->max_person == '10'): ?>
                            <img class="d-block w-100" src="<?php $this->url('images/camel.jpg') ?>" style="object-fit:cover" height="180">
                          <?php endif; ?>

                        </div>
                      </div>
                      <div class="card">
                        <a style="color:white" class="btn btn-sm btn-success">Rp <?= number_format(($d->animal_price),0,',','.') ?></a>
                      </div>
                    </div>
                    <?php $t = $t + 1000; ?>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-4">
                <div class="card bg-gradient-light card-img-holder text-grey form-control" style="padding: 1% !important;">
                  <div class="card-body">
                    <form action="<?php $this->url('qurban/store?id='. $_GET['id']) ?>" method="post">
                      <?php $this->csrf_field() ?>
                      <div class="row">

                        <?php if (isset($_SESSION['jamaah'])): ?>
                          <?php if ($_SESSION['jamaah'] === true): ?>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Fund</label>
                                  <input type="text" placeholder="Fund" class="form-control" disabled id="fund">
                                  <input type="hidden" name="price" id='price'>
                                  <input type="hidden" name="type" id="type">
                                </div>
                                <div class="form-group">
                                  <label>Qurban Option</label>
                                  <select class="form-control" name="account" style="color: black;" onchange="choose(this.value)">
                                    <option value="0">===== Choose Qurban Animal =====</option>
                                    <?php foreach ($qurban as $q): ?>
                                      <option value="<?= $q->max_person . '~' . 'Rp ' . number_format(($q->animal_price/$q->max_person),0,',','.').
                                      '~'. $q->animal_type.'~'. 'Rp ' . number_format(($q->animal_price/$q->max_person),0,',','.').
                                      '~'. $q->animal_price/$q->max_person ?>">
                                        <?= $q->animal_type ?> (1x payment)
                                      </option>
                                    <?php endforeach; ?>
                                    <?php foreach ($qurban as $q): ?>
                                      <option value="<?= $q->max_person . '~' . 'Rp ' . number_format(($q->animal_price/$q->max_person),0,',','.').
                                      '~'. $q->animal_type.'~'. 'Rp ' . number_format((($q->animal_price/3)/$q->max_person),0,',','.').
                                      '~'. ($q->animal_price/3)/$q->max_person .'~'.'3'?>">
                                        <?= $q->animal_type ?> (3x payment)
                                      </option>
                                    <?php endforeach; ?>
                                    <?php foreach ($qurban as $q): ?>
                                      <option value="<?= $q->max_person . '~' . 'Rp ' . number_format(($q->animal_price/$q->max_person),0,',','.').
                                      '~'. $q->animal_type.'~'. 'Rp ' . number_format((($q->animal_price/6)/$q->max_person),0,',','.').
                                      '~'. ($q->animal_price/6)/$q->max_person .'~'.'6'?>">
                                        <?= $q->animal_type ?> (6x payment)
                                      </option>
                                    <?php endforeach; ?>
                                    <?php foreach ($qurban as $q): ?>
                                      <option value="<?= $q->max_person . '~' . 'Rp ' . number_format(($q->animal_price/$q->max_person),0,',','.').
                                      '~'. $q->animal_type.'~'. 'Rp ' . number_format((($q->animal_price/9)/$q->max_person),0,',','.').
                                      '~'. ($q->animal_price/9)/$q->max_person .'~'.'9'?>">
                                        <?= $q->animal_type ?> (9x payment)
                                      </option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>

                                <input id="payment" name="payment" value="" type="hidden">

                                <div class="form-group" id="goat" style="display:none">
                                  <label>Total Slot</label>
                                  <select id="dGoat" class="form-control" name="total_slot" style="color: black;" onchange="onSelectedSlot(this.value)">
                                    <option value="1" id="default_selected_1">===== Choose Total Slot =====</option>
                                    <option value="1">1</option>
                                  </select>
                                </div>

                                <div class="form-group" id="cow" style="display:none">
                                  <label>Total Slot</label>
                                  <select id="dCow" class="form-control" name="total_slot" style="color: black;" onchange="onSelectedSlot(this.value)">
                                    <option value="1" id="default_selected_2">===== Choose Total Slot =====</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                  </select>
                                </div>

                                <div class="form-group" id="camel" style="display:none">
                                  <label>Total Slot</label>
                                  <select id="dCamel" class="form-control" name="total_slot" style="color: black;" onchange="onSelectedSlot(this.value)">
                                    <option value="1" id="default_selected_3">===== Choose Total Slot =====</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label>Stewardship Account Bank</label>
                                  <select class="form-control" name="account" style="color: black;">
                                    <?php foreach ($account as $ac): ?>
                                      <option value="<?= $ac->id ?>"><?= $ac->bank ?> a/n <?= $ac->owner ?> (<?= $ac->account_number ?>)</option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label>Your Total Payment</label>
                                  <input type="text" placeholder="Rp 0" class="form-control" disabled id="total_fund">
                                </div>

                                <input type="submit" name="" value="Qurban" class="form-control btn btn-sm btn-gradient-success">
                              </div>

                          <?php endif; ?>
                        <?php else: ?>
                          <h6>Please Login to Qurban. Login  <a href="<?php $this->url('login') ?>">Here</a> </h6>
                        <?php endif; ?>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="card bg-gradient-light card-img-holder text-grey form-control" style="padding: 1% !important;">
                  <div class="card-body">
                    <table class="table">
                      <thead style="text-align:left">
                        <tr>
                          <th>Group</th>
                          <th>Animal</th>
                          <th>Participant</th>
                          <th>Slot Used</th>
                          <th>Slot Available</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($group as $key): ?>
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
                            <td>
                              <?php foreach ($r as $val): ?>
                                <?= $val->total_slot ?> Slot<br>
                              <?php endforeach; ?>
                            </td>
                            <td>
                              <?= $key->max_person - $slot ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
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
  <script src="<?php $this->url('script/js/dashboard.js') ?>"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#data').DataTable({
        dom: '<"clear"f><"clear">',
      });
    } );
  </script>
  <script type="text/javascript">

  var animal_price = 0;

  function choose(v) {
    console.log(v);
    var arr = [];
    var arr = v.split('~', 6);
    var m = arr[0];
    var p = arr[1];
    var at = arr[2];
    var price = arr[3];
    animal_price = arr[4];
    var installments = arr[5]

    document.getElementById('price').value = price;
    document.getElementById('type').value = at;
    document.getElementById('total_fund').value = numberWithCommas(0);
    if (installments == '9') {
      document.getElementById('fund').value = p + ' /slot (9x Installments)';
      document.getElementById('payment').value = '9';
    }else if (installments == '6') {
      document.getElementById('fund').value = p + ' /slot (6x Installments)';
      document.getElementById('payment').value = '6';
    }else if(installments == '3'){
      document.getElementById('fund').value = p + ' /slot (3x Installments)';
      document.getElementById('payment').value = '3';
    }else{
      document.getElementById('fund').value = p + ' /slot';
      document.getElementById('payment').value = '1';
    }

    if (m == '1') {
      document.getElementById('goat').style.display = 'block';
      document.getElementById('cow').style.display = 'none';
      document.getElementById('camel').style.display = 'none';
      document.getElementById('dCamel').name = '';
      document.getElementById('dCow').name = '';
      document.getElementById('dGoat').name = 'total_slot';
      document.getElementById('default_selected_1').selected = true;
    }
    if (m == '7') {
      document.getElementById('goat').style.display = 'none';
      document.getElementById('cow').style.display = 'block';
      document.getElementById('camel').style.display = 'none';
      document.getElementById('dGoat').name = '';
      document.getElementById('dCamel').name = '';
      document.getElementById('dCow').name = 'total_slot';
      document.getElementById('default_selected_2').selected = true;
    }
    if (m == '10') {
      document.getElementById('goat').style.display = 'none';
      document.getElementById('cow').style.display = 'none';
      document.getElementById('dGoat').name = '';
      document.getElementById('dCow').name = '';
      document.getElementById('camel').style.display = 'block';
      document.getElementById('dCamel').name = 'total_slot';
      document.getElementById('default_selected_3').selected = true;
    }
  }

  function onSelectedSlot(val){
    result = (animal_price * val).toFixed(0);
    document.getElementById('total_fund').value = numberWithCommas(result);
  }

  function numberWithCommas(x) {
      return 'Rp ' + x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  </script>
  <!-- End custom js for this page-->
</body>

</html>
