<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <?php $this->include('style/_profile') ?>
  <!-- end custome -->

</head>
<body>
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <?php $this->include('partials/_sidebar_admin'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-elevation-rise"></i>
              </span>
              Dashboard
            </h3>
          </div>

          <div class="row">

            <div class="col-md-3 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="<?php $this->url('images/circle.svg') ?>" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-normal mb-3">Mosque
                    <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5"> <?php echo $mosque ?> </h2>
                  <h6 class="card-text">Padang Selatan District</h6>
                </div>
              </div>
            </div>

            <div class="col-md-3 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="<?php $this->url('images/circle.svg') ?>" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-normal mb-3">Stewardship
                    <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5"> <?php echo $stewardship ?> </h2>
                  <h6 class="card-text">Padang Selatan District</h6>
                </div>
              </div>
            </div>

            <div class="col-md-3 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="<?php $this->url('images/circle.svg') ?>" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-normal mb-3">Jamaah
                    <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5"> <?php echo $jamaah ?> </h2>
                  <h6 class="card-text">Padang Selatan District</h6>
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
  <!-- End custom js for this page-->
</body>

</html>
