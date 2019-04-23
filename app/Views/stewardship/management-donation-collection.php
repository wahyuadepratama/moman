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
      <?php $this->include('partials/_sidebar_caretaker'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-cash-multiple"></i>
              </span>
              Donation Management - Dana Collection
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label>Total</label>
                        <input type="text" name="" placeholder="Total donation" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Donation Type</label>
                        <select class="form-control" style="color: black;">
                          <option value="mosque construction">Infak Mosque Construction</option>
                          <option value="yatim piatu">Infak Yatim Piatu</option>
                        </select>
                      </div>

                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="status">Donatur already registered
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="status">Donatur not registered
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="status">Funds come from mosque infaq boxes or donation activities
                        </label>
                      </div>

                      <input type="submit" name="" value="Save" class="form-control btn btn-sm btn-gradient-success">

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
  <!-- End custom js for this page-->
</body>

</html>
