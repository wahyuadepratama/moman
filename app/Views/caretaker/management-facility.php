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
                <i class="mdi mdi-home-modern"></i>
              </span>
              Facility Management
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">

                      <div class="form-group">
                        <label>Facility Type</label>
                        <select class="form-control" style="color: black;">
                          <option value="mosque construction">Infak Mosque Construction</option>
                          <option value="yatim piatu">Infak Yatim Piatu</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Condition</label>
                        <select class="form-control" style="color: black;">
                          <option value="baik">Baik</option>
                          <option value="rusah ringan">Rusak Ringan</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" name="" placeholder="Total facility" class="form-control">
                      </div>

                      <input type="submit" name="" value="Save" class="form-control btn btn-sm btn-gradient-success">

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 table-responsive" style="text-align:center">
                      <table class="table table-striped">
                        <tr>
                          <th>Facility Name</th>
                          <th>Condition</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                        <tr>
                          <td>bla bla bla</td>
                          <td>1298192</td>
                          <td>kdjfkdjf</td>
                          <td>view</td>
                        </tr>
                      </table>
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
