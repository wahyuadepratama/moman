<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Script for maps -->
  <?php $this->include('maps/_find_mosque'); ?>
  <!-- end of script -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <?php $this->include('style/_profile'); ?>
  <!-- end custome -->

</head>
<body onload="init()">
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <?php $this->include('partials/_sidebar'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              Donation Orphans
            </h3>
          </div>

          <div class="row">
            <div class="col-md-4 grid-margin">
              <div class="card">
                <style media="screen">
                .effect{
                  transform-origin: 50% 65%;
                  transition: transform 15s, filter 6s ease-in-out;
                  filter: brightness(30%);
                  height: 120px;
                }
                </style>
                <div class="effect">
                  <img class="d-block w-100" src="<?php $this->url('images/mosque/example.png') ?>" alt="First slide">
                </div>
              </div>
              <div class="card bg-gradient-dark card-img-holder text-white">
                <div class="card-body" style="padding: 10% !important">
                  <img src="<?php $this->url('images/dashboard/circle.svg') ?>" class="card-img-absolute" alt="circle-image">
                  <h4 class="font-weight-bold mb-3">
                    <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i> Masjid Al-Amanah
                  </h4>                  
                </div>
              </div>
              <div class="card">
                <a href="<?php $this->url('donation/detail?project=2') ?>" class="btn btn-sm btn-success">Detail</a>
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
