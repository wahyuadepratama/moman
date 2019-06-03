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
              Qurban Available
            </h3>
          </div>

          <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <?php $t = 1000; ?>
                  <?php foreach ($qurban as $d): ?>
                    <div class="col-md-6 grid-margin">
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
              <div class="col-md-6">
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
                                      <option value="<?= $q->max_person . '~' . 'Rp ' . number_format(($q->animal_price),0,',','.').'~'. $q->animal_type ?>"><?= $q->animal_type ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>

                                <div class="form-group" id="goat" style="display:none">
                                  <input type="text" name="goat[]" class="form-control" placeholder="Participant 1">
                                </div>

                                <div class="form-group" id="cow" style="display:none">
                                  <input type="text" name="cow[]" class="form-control" placeholder="Participant 1"><br>
                                  <input type="text" name="cow[]" class="form-control" placeholder="Participant 2 (Optional)"><br>
                                  <input type="text" name="cow[]" class="form-control" placeholder="Participant 3 (Optional)"><br>
                                  <input type="text" name="cow[]" class="form-control" placeholder="Participant 4 (Optional)"><br>
                                  <input type="text" name="cow[]" class="form-control" placeholder="Participant 5 (Optional)"><br>
                                  <input type="text" name="cow[]" class="form-control" placeholder="Participant 6 (Optional)"><br>
                                  <input type="text" name="cow[]" class="form-control" placeholder="Participant 7 (Optional)">
                                </div>

                                <div class="form-group" id="camel" style="display:none">
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 1"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 2 (Optional)"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 3 (Optional)"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 4 (Optional)"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 5 (Optional)"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 6 (Optional)"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 7 (Optional)"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 8 (Optional)"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 9 (Optional)"><br>
                                  <input type="text" name="camel[]" class="form-control" placeholder="Participant 10 (Optional)"><br>
                                </div>

                                <div class="form-group">
                                  <label>Stewardship Account Bank</label>
                                  <select class="form-control" name="account" style="color: black;">
                                    <?php foreach ($account as $ac): ?>
                                      <option value="<?= $ac->id ?>"><?= $ac->bank ?> a/n <?= $ac->owner ?> (<?= $ac->account_number ?>)</option>
                                    <?php endforeach; ?>
                                  </select>
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
  function choose(v) {
    console.log(v);
    var arr = [];
    var arr = v.split('~', 3);
    var m = arr[0];
    var p = arr[1];
    var at = arr[2];

    console.log(p);
    document.getElementById('fund').value = p;
    document.getElementById('price').value = p;
    document.getElementById('type').value = at;

    if (m == '1') {
      document.getElementById('goat').style.display = 'block';
      document.getElementById('cow').style.display = 'none';
      document.getElementById('camel').style.display = 'none';
    }
    if (m == '7') {
      document.getElementById('goat').style.display = 'none';
      document.getElementById('cow').style.display = 'block';
      document.getElementById('camel').style.display = 'none';
    }
    if (m == '10') {
      document.getElementById('goat').style.display = 'none';
      document.getElementById('cow').style.display = 'none';
      document.getElementById('camel').style.display = 'block';
    }
  }
  </script>
  <!-- End custom js for this page-->
</body>

</html>
