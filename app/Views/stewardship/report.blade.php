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

                    <div class="col-md-12 table-responsive">
                      <form action="<?php $this->url('stewardship/report') ?>" method="get">
                        <div class="row" style="margin-top:0.5%;margin-bottom:3%">
                          <div class="col-md-2">
                            <select class="form-control" style="color:black" name="year">
                              <?php foreach ($year as $key): ?>
                                <option value="<?= $key->year ?>"><?= $key->year ?></option>
                              <?php endforeach; ?>
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
                                   window.print();
                                   document.body.innerHTML = originalContents;
                              }
                            </script>
                          </div>
                        </div>
                      </form>
                      <div id='printableAreaQ'>

                        <center>
                          <h3>Qurban Report <?= $_GET['year'] ?></h3>
                        </center>

                        <div class="row" style="margin-top: 50px">
                          <div class="col-md-6" style="margin-bottom: 15px">
                            <table class="table">
                              <tr>
                                <td>Funds Raised</td>
                                <td>:</td>
                                <td>Rp <?= number_format($fundRaised,0,',','.') ?></td>
                              </tr>
                              <tr>
                                <td>Total Goat</td>
                                <td>:</td>
                                <td><?= $goat ?> animals</td>
                              </tr>
                              <tr>
                                <td>Total Cow</td>
                                <td>:</td>
                                <td><?= $cow ?> animals</td>
                              </tr>
                              <tr>
                                <td>Participants</td>
                                <td>:</td>
                                <td><?= $participant ?> jamaah</td>
                              </tr>
                            </table>
                          </div>
                        </div>

                        <div class="row" style="margin-top: 50px">

                          <?php foreach ($group as $key): ?>

                            <?php
                              $stmt = $GLOBALS['pdo']->prepare("SELECT name, serial_number FROM qurban_detail INNER JOIN qurban_order
                                                                ON qurban_order.jamaah_id=qurban_detail.jamaah_id
                                                                AND qurban_order.datetime=qurban_detail.datetime
                                                                INNER JOIN jamaah ON jamaah.id=qurban_order.jamaah_id
                                                                WHERE qurban_detail.worship_place_id=:id AND qurban_detail.year=:y
                                                                AND qurban_detail.group_name=:grup ORDER BY qurban_detail.serial_number ASC");
                              $stmt->execute(['id'=> $_SESSION['user']->worship_place_id, 'y' => $_GET['year'], 'grup' => $key->group_name]);
                              $group = $stmt->fetchAll(PDO::FETCH_OBJ);
                              // $this->die($group);
                            ?>

                            <div class="col-md-3">
                              <div class="card" style="width: 12rem; margin-bottom: 20px">
                                <div class="card-header">
                                  <b>Group <?= $key->group_name ?> (<?= $key->animal ?>)</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                  <?php if ($group): ?>
                                    <?php foreach ($group as $value): ?>
                                      <li class="list-group-item"><?= $value->serial_number ?>. <?= $value->name ?></li>
                                    <?php endforeach; ?>
                                  <?php else: ?>
                                    <li class="list-group-item">Empty!</li>
                                  <?php endif; ?>
                                </ul>
                              </div>
                            </div>
                          <?php endforeach; ?>

                        </div>
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
