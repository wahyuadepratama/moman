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
              Report
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group float-right">
                      <select class="form-control" onchange="redirect(this.value)">
                        <?php foreach ($worships as $key): ?>
                          <option <?= (isset($_GET['worship']) ? ( ($key->worship_place_id==$_GET['worship']) ? 'selected' : '' ) : '' ) ?>
                            value="<?= $key->worship_place_id ?>"><?= $key->name ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="row">

                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="changeToEvent()" id="navEvent">Information</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToQurban()" id="navQurban">Qurban's Report</a>
                      </li>
                    </ul>

                    <script type="text/javascript">
                      function changeToEvent(){
                          var x = document.getElementById("event");
                          var z = document.getElementById("qurban");
                          x.style.display = "block";
                          z.style.display = "none";

                          var a = document.getElementById("navEvent");
                          var c = document.getElementById("navQurban");
                          a.classList.add("active");
                          c.classList.remove("active");
                      }
                      function changeToQurban(){
                          var x = document.getElementById("event");
                          var z = document.getElementById("qurban");
                          x.style.display = "none";
                          z.style.display = "block";

                          var a = document.getElementById("navEvent");
                          var c = document.getElementById("navQurban");
                          a.classList.remove("active");
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
                            <th>Ustad/Pengisi Acara</th>
                          </tr>
                          <?php foreach ($event as $f): ?>
                            <tr>
                              <td><?= $f->name ?></td>
                              <td><?= $f->description ?></td>
                              <td><?= date('d M Y', strtotime($f->date))  ?> <?= date('H:i:s', strtotime($f->time)) ?></td>
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
                          <?php foreach ($facility as $f): ?>
                            <tr>
                              <td><?= $f->name ?></td>
                              <td><?= $f->total ?></td>
                              <td><?= $f->condition ?></td>
                              <td><?= date('d M Y, h:i:s', strtotime($f->updated_at)) ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </table>
                      </div>
                    </div>

                    <div class="col-md-12" id="qurban" style="display:none">

                      <form action="<?php $this->url('jamaah/about') ?>" method="get" style="margin-top: 50px">
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
                        </div>
                      </form>

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
                              <td>Participant</td>
                              <td>:</td>
                              <td><?= $participant ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>

                      <div class="row" style="margin-top: 50px">

                        <?php foreach ($group as $key): ?>

                          <?php
                            if (isset($_GET['worship'])) {
                              $id = $_GET['worship'];
                            }else {
                              $id = $worships[0]->id;
                            }
                            $stmt = $GLOBALS['pdo']->prepare("SELECT name, serial_number FROM qurban_detail
                                                              INNER JOIN qurban_order
                                                              ON qurban_order.jamaah_id=qurban_detail.jamaah_id
                                                              AND qurban_order.date=qurban_detail.date
                                                              AND qurban_order.order_number=qurban_detail.order_number
                                                              INNER JOIN jamaah ON jamaah.id=qurban_order.jamaah_id
                                                              WHERE qurban_detail.worship_place_id=:id AND qurban_detail.year=:y
                                                              AND qurban_detail.group_name=:grup ORDER BY qurban_detail.serial_number ASC");
                            $stmt->execute(['id'=> $id, 'y' => $_GET['year'], 'grup' => $key->group_name]);
                            $group = $stmt->fetchAll(PDO::FETCH_OBJ);
                            // $this->die($group);
                          ?>

                          <div class="col-md-3">
                            <div class="card" style="width: 12rem; margin-bottom: 20px">
                              <div class="card-header">
                                Group <?= $key->group_name ?> (<?= $key->animal ?>)
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
  <script type="text/javascript">
    function redirect(val) {
      window.location = '/jamaah/about?year='+<?= $_GET['year'] ?>+'&worship='+val
    }
  </script>
  <!-- End custom js for this page-->
</body>

</html>
