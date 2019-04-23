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
              Profile
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">

                      <center>
                        <a href="#" data-toggle="modal" data-target="#avatar">
                            <div class="hover-image">
                              <img class="hover-image-radius" src="images/faces/face1.jpg" alt="avatar" style="border-radius: 50%">
                              <div class="overlay">
                                <div class="hover-image-icon">
                                  <i class="mdi mdi-upload text-success"></i>
                                </div>
                              </div>
                            </div>
                        </a>

                        <a style="margin-top: 2%" href="#" class="btn btn-sm btn-gradient-danger" data-toggle="modal" data-target="#password">Change Password</a>
                        <a style="margin-top: 2%" href="#" class="btn btn-sm btn-gradient-info" data-toggle="modal" data-target="#profile">Update Profile</a>
                        <!-- Modal Avatar -->
                        <div class="modal fade" id="avatar" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="avatar">Change Avatar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <input type="file" name="" value="Upload Avatar" class="form-control">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success">Upload</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal -->
                        <!-- Modal Profile -->
                        <div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="profile" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="profile">Update Profile and Bank Account</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a style="margin-top: 2%" href="caretaker-dashboard@update" class="btn btn-sm btn-gradient-info form-control">Update Profile</a>
                                <a style="margin-top: 2%" href="caretaker-dashboard-account@update" class="btn btn-sm btn-gradient-success form-control">Update Bank Account</a>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Profile -->
                        <!-- Modal Password -->
                        <div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="password" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="password">Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <input type="text" name="" placeholder="New Password" class="form-control">
                                <input type="text" name="" placeholder="Confirmation Password" class="form-control">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger">Save</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal -->
                      </center>

                    </div>

                    <div class="col-md-4">

                      <address class="text-default">
                            <p class="font-weight-bold">
                              Name
                            </p>
                            <p class="mb-2">
                              Wahyu Ade Pratama
                            </p><br>
                            <p class="font-weight-bold">
                              Phone
                            </p>
                            <p>
                              081371321971
                            </p><br>
                            <p class="font-weight-bold">
                              Address
                            </p>
                            <p>
                              Jala utama II blok j2 no 12, Mata Air, Padang Selatan
                            </p><br>
                      </address>

                    </div>

                    <div class="col-md-4">
                      <address class="text-default">
                            <p class="font-weight-bold">
                              Jamaah From
                            </p>
                            <p>
                              Masjid Al - Amanah M. Natsir
                            </p><br>
                            <p class="font-weight-bold">
                              Identity Number
                            </p>
                            <p>
                              320120310230123010230120
                            </p><br>
                            <p class="font-weight-bold">
                              Bank Account
                            </p>
                            <p>
                              <li>bla bla</li>
                              <li>bla bla</li>
                            </p><br>
                      </address>
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
                          <th>Transaction Name</th>
                          <th>Total</th>
                          <th>Date Time</th>
                          <th>Status</th>
                          <th>Detail</th>
                        </tr>
                        <tr>
                          <td>bla bla bla</td>
                          <td>1298192</td>
                          <td>kdjfkdjf</td>
                          <td>success</td>
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
