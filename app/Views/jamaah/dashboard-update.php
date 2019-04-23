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
      <?php $this->include('partials/_sidebar_jamaah'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              Update Your Profile
            </h3>
          </div>

          <div class="row">

            <div class="col-md-6 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">

                    <div class="col-md-12">

                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="" placeholder="Name" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="" placeholder="Phone" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="" placeholder="Address" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Jamaah From</label>
                        <input type="text" name="" placeholder="Find your mosque via maps beside" class="form-control">
                      </div>

                      <input type="submit" name="" value="Save Profile" class="form-control btn btn-sm btn-gradient-info">

                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin">
                <div id="map" class="form-control" style="height: 35em;"></div>
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
  <!-- End custom js for this page-->
</body>

</html>
