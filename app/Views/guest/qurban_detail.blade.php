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

      <!-- partial:partials/_sidebar.html -->
      <!-- $this->include('partials/_sidebar') -->
      <!-- partial -->

      <div style="margin-top: 50px"><!-- <div class="main-panel"> -->
        <div class="content-wrapper">

          <?php if (!empty($this->flash())): ?>
            <br><div class="alert alert-danger">
              <small><?php $this->flash('print') ?></small>
            </div>
          <?php endif; ?>

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

                </div>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="card bg-gradient-light card-img-holder text-grey form-control" style="padding: 1% !important;">
                  <div class="card-body">
                    <form action="<?php $this->url('qurban/store?id='. $_GET['id'] .'&mosque='. $_GET['mosque']. '&year='. $_GET['year']) ?>" method="post">
                      <?php $this->csrf_field() ?>
                      <div class="row">

                        <?php if (isset($_SESSION['jamaah'])): ?>
                          <?php if ($_SESSION['jamaah'] === true): ?>

                              <div class="col-md-12">

                                <div class="form-group">
                                  <div class="row">
                                    <div class="col-md-5">
                                      <b><p>Qurban Price (1 Goat)</p></b>
                                    </div>
                                    <div class="col-md-1">
                                      :
                                    </div>
                                    <div class="col-md-6">
                                      <p>Rp <?= number_format(($qurban->animal_price),0,',','.') ?></p>
                                    </div>
                                  </div><br>
                                  <div class="row">
                                    <div class="col-md-5">
                                      <b> <p>Description</p> </b>
                                    </div>
                                    <div class="col-md-1">
                                      :
                                    </div>
                                    <div class="col-md-6">
                                      <?= $qurban->description ?>
                                    </div>
                                  </div>
                                  <input type="hidden" name="year" value="<?= $qurban->year ?>">
                                </div>

                                <div class="form-group">
                                  <label>Total Qurban Animal</label>
                                  <input type="number" placeholder="Total" required name="total_qurban" class="form-control" min="1" max="7">
                                </div>

                                <div class="form-group">
                                  <label>Group Qurban</label>
                                  <select id="dCow" class="form-control" name="group_name" style="color: black;">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                  </select>
                                </div>

                                <div class="form-group" id="account">
                                  <label>Stewardship Account Bank</label>
                                  <select class="form-control" name="account" style="color: black;">
                                    <?php foreach ($account as $ac): ?>
                                      <option value="<?= $ac->account_number ?>~<?= $ac->stewardship_id ?>~<?= $ac->stewardship_period ?>"><?= $ac->bank ?> a/n <?= $ac->owner ?> (<?= $ac->account_number ?>)</option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>

                                <!-- checkbox animal -->
                                <div class="form-check">
                                  <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" onclick="openInputAnimal()">
                                    Qurban with animal to this mosque
                                  </label>
                                  <script type="text/javascript">
                                    var input_animal = 1;
                                    function openInputAnimal() {
                                      if (input_animal == 1) {
                                        $('#account').css("display", "none");
                                        $('#input_animal').css("display", "block"); input_animal++;
                                      }else{
                                        $('#account').css("display", "block");
                                        $('#input_animal').css("display", "none"); input_animal--;
                                      }
                                    }
                                  </script>
                                </div>
                                <div class="form-group" style="display: none" id="input_animal">
                                  <select class="form-control" name="animal" style="color: black">
                                    <option value="">=== Select Animal ===</option>
                                    <option value="goat">Goat</option>
                                    <option value="cow">Cow</option>
                                  </select>
                                </div>
                                <!-- end checkbox animal -->

                                <!-- checkbox particpant -->
                                <div class="form-check">
                                  <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" onclick="openInputName()">
                                    Use another name for qurban
                                  </label>
                                </div>
                                <script type="text/javascript">
                                  var input_name=1;
                                  function openInputName() {
                                    if (input_name == 1) {
                                      $('#input_name').css("display", "block"); input_name++;
                                    }else{
                                      $('#input_name').css("display", "none"); input_name--;
                                    }
                                  }
                                </script>
                                <div class="form-group" style="display: none" id="input_name">
                                  <input type="text" name="participant_name" class="form-control" placeholder="Participa name">
                                </div>
                                <!-- end checkbox participant -->

                                <br><input type="submit" class="form-control btn btn-sm btn-success" value="Qurban">

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
              <div class="col-md-6">
                <div class="row">

                  <?php foreach ($group as $key): ?>

                    <?php
                      $id = $this->decrypt($_GET['id']);
                      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_detail INNER JOIN qurban_participant ON
                                                        qurban_participant.id = qurban_detail.participant_id
                                                        WHERE worship_place_id=:id AND year=:y AND group_name=:grup ORDER BY datetime");
                      $stmt->execute(['id'=> $id, 'y' => $_GET['year'], 'grup' => $key->group_name]);
                      $group = $stmt->fetchAll(PDO::FETCH_OBJ);
                    ?>

                    <div class="col-md-4">
                      <div class="card" style="width: 12rem; margin-bottom: 20px">
                        <div class="card-header">
                          Group <?= $key->group_name ?>
                        </div>
                        <ul class="list-group list-group-flush">
                          <?php foreach ($group as $value): ?>

                            <?php if ($value->total_qurban > 1): ?>
                              <?php
                                for ($i=0; $i < $value->total_qurban; $i++) {
                                  ?>
                                    <li class="list-group-item"><?= $value->name ?></li>
                                  <?php
                                }
                              ?>
                            <?php else: ?>
                              <li class="list-group-item"><?= $value->name ?></li>
                            <?php endif; ?>

                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </div>
                  <?php endforeach; ?>

                </div>
              </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

        <!-- partial:partials/_footer.php -->
        <?php $this->include('partials/_footer'); ?>
        <!-- partial -->

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
  <!-- End custom js for this page-->
</body>

</html>
