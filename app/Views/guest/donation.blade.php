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

          <!-- <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              Donation Mosque Construction
            </h3>
          </div> -->

          <div class="row">

            <style media="screen">
            .x {position: absolute; left: 0;right: 0;margin-left: auto;margin-right: auto;width: 350px;text-align: center;top: 45px;font-size: 25px;border-radius: 5%;color: white;padding-left: 5px;padding-right: 10px;}
            @media only screen and (max-width: 768px) {.x{font-size: 15px;top:20px}}
            </style>
            <div class="col-md-12 grid-margin">
              <div class="card" style="position:relative !important;">
                <img class="img-fluid" src="<?php $this->url('images/masjid.png') ?>" style="object-fit:cover;filter: sepia(90%) brightness(30%); height:150px">
                <p class="x">Mosque Construction Donation</p>
              </div>
            </div>

            <?php $t = 1000; ?>
            <?php foreach ($project as $d): ?>
              <div class="col-md-3 grid-margin">
                <div class="card">
                  <style media="screen">
                    .effect{transform-origin: 50% 65%;transition: transform 15s, filter 6s ease-in-out;filter: brightness(70%);height: 150px;color:white}
                    .fund {position: absolute;bottom: 1px;left: 20px;background-color: rgba(0,0,0,.5);border-radius: 5%;color: white;padding-left: 5px;padding-right: 10px;}
                  </style>

                  <div class="effect" style="position:relative">
                    <p class="fund"> <i class="mdi mdi-home-map-marker"></i>&nbsp; <?= $d->worship ?></p>

                    <?php
                      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM project_gallery WHERE project_id=:id ORDER BY RANDOM()"); $stmt->execute(['id' => $d->id]); $data = $stmt->fetch(PDO::FETCH_OBJ);
                    ?>

                    <img class="load-delay<?= $d->id ?> d-block w-100" src="<?php $this->url('images/load.gif') ?>" data-original="<?php $this->url('images/project/'. $data->image) ?>" style="object-fit:cover;border-radius:2%" height="200">

                    <script type="text/javascript">
          						$(document).ready(function () {
          						setTimeout(function () {
          							$('.load-delay<?= $d->id ?>').each(function () { var imagex = $(this); var imgOriginal = imagex.data('original'); $(imagex).attr('src', imgOriginal); }); }, 1000 + <?= $t ?>);
                      });
          					</script>

                  </div>
                </div>
                <div class="card bg-gradient-white card-img-holder text-grey" style="border-radius: 5% !important">
                  <div class="card-body" style="padding: 10% !important">
                    <!-- <img src="<?php $this->url('images/circle.svg') ?>" class="card-img-absolute" alt="circle-image"> -->
                    <h5 class="font-weight-bold mb-3" style="position:absolute">
                      <i class="mdi mdi-check-circle text-success mdi-24px float-right"></i> <?= $d->name ?>
                    </h5><br><br><br>
                    <?php
                      if(isset($d->collected)){
                        $percent = ($d->collected/$d->fund)*100;
                      }else{
                        $percent = 0;
                      }
                    ?>
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percent ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div><br>
                    <h6 class="text-left">Fund Collected: </h6>
                    <h6 class="text-right"> Rp <?= number_format(($d->collected),0,',','.') ?> </h6>
                  </div>
                  <a href="<?php $this->url('donation/detail?project='. $this->encrypt($d->id)) ?>" class="btn btn-sm btn-success">Detail</a>
                </div>
              </div>
              <?php $t = $t + 1000; ?>
            <?php endforeach; ?>
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
  <!-- End custom js for this page-->
</body>

</html>
