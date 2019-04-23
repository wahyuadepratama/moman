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
      <?php $this->include('partials/_sidebar_caretaker'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              Update Bank Account
            </h3>
          </div>

          <div class="row">

            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">

                      <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" name="" placeholder="Name" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Account Owner</label>
                        <input type="text" name="" placeholder="Phone" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Account Number</label>
                        <input type="text" name="" placeholder="Address" class="form-control">
                      </div>

                      <input type="submit" name="" value="Add Account" class="form-control btn btn-sm btn-gradient-info">

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-7 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h5>List Your Bank Account</h5><br>
                  <div class="row">
                    <div class="col-md-12 table-responsive" style="text-align:center">
                      <table class="table table-striped">
                        <tr>
                          <th>Bank Name</th>
                          <th>Account Owner</th>
                          <th>Account Number</th>
                          <th>Status</th>
                        </tr>
                        <tr>
                          <td>bla bla bla</td>
                          <td>1298192</td>
                          <td>1234567890111213</td>
                          <td>
                            <a href="#" onclick="return confirm('Are you want to delete this?');"><i class="mdi mdi-delete menu-icon icon-md"></i></a>
                          </td>
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
