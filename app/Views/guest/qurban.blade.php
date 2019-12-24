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

          <div class="row">

            <style media="screen">
            .fund {position: absolute; left: 0;right: 0;margin-left: auto;margin-right: auto;width: 350px;text-align: center;top: 35px;font-size: 25px;border-radius: 5%;color: white;padding-left: 5px;padding-right: 10px;}
            @media only screen and (max-width: 768px) {.fund{font-size: 15px;top:20px}}
            </style>
            <div class="col-md-12 grid-margin">
              <div class="card" style="position:relative !important;">
                <img class="img-fluid" src="<?php $this->url('images/qurban.png') ?>" style="object-fit:cover;filter: sepia(90%) brightness(30%);height:150px">
                <p class="fund">Qurban</p>
              </div>
            </div>

            <?php $t = 1000; ?>
            <?php foreach ($qurban as $d): ?>

              <div class="col-md-3 grid-margin">
                <div class="card">
                  <style media="screen">
                    .effect{transform-origin: 50% 65%;transition: transform 15s, filter 6s ease-in-out;filter: brightness(80%);height: 150px;}
                  </style>
                  <div class="effect">
                    <?php
                      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM gallery WHERE worship_place_id=:id"); $stmt->execute(['id' => $d->id]); $data = $stmt->fetch(PDO::FETCH_OBJ);
                    ?>
                    <img class="load-delay<?= $d->id ?> d-block w-100" src="<?php $this->url('images/load.gif') ?>" data-original="<?php $this->url('images/mosque/'. $data->image) ?>" height="200px">
                    <script type="text/javascript">
          						$(document).ready(function () {
          						setTimeout(function () {
          							$('.load-delay<?= $d->id ?>').each(function () { var imagex = $(this); var imgOriginal = imagex.data('original'); $(imagex).attr('src', imgOriginal); }); }, 1000 + <?= $t ?>);
                      });
          					</script>
                  </div>
                </div>
                <div class="card bg-gradient-white card-img-holder text-grey">
                  <div class="card-body" style="padding: 5% !important">
                    <img src="<?php $this->url('images/circle.svg') ?>" class="card-img-absolute" alt="circle-image">
                    <h6 class="font-weight-bold mb-3">
                      <i class="mdi mdi-check-circle text-success mdi-24px float-right"></i> <?= $d->name ?>
                    </h6>
                  </div>
                </div>
                <div class="card">
                  <a href="<?php $this->url('qurban/detail?id='. $this->encrypt($d->id)) ?><?= '&mosque=' . $d->name .'&year='. $d->year?>"
                    class="btn btn-sm btn-success">Qurban Here</a>
                </div>
              </div>
              <?php $t = $t + 500; ?>
            <?php endforeach; ?>
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
  <!-- End custom js for this page-->
</body>

</html>
