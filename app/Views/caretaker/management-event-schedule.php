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
                <i class="mdi mdi-calendar-clock"></i>
              </span>
              Event Management - Schedule
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">

                      <div class="form-group">
                        <label>Event Type</label>
                        <div class="form-group">
                          <div class="input-group">
                            <select class="form-control" style="color: black;">
                              <option value="mosque construction">Wirid Kamis Malam</option>
                              <option value="yatim piatu">Wirid Subuh</option>
                            </select>
                            <div class="input-group-append">
                              <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#eventType"><i class="mdi mdi-plus-box"></i></button>
                            </div>
                            <!-- Modal Add Event Type -->
                            <div class="modal fade" id="eventType" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="eventType">Add Event Type</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <input type="text" name="" placeholder="Write your cuztome event type here" class="form-control">
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger">Add</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Modal -->
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Ustad</label>
                        <div class="form-group">
                          <div class="input-group">
                            <select class="form-control" style="color: black;">
                              <option value="mosque construction">Ustad Ade Fitra</option>
                              <option value="yatim piatu">Ustad Haris Yaman</option>
                            </select>
                            <div class="input-group-append">
                              <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#ustad"><i class="mdi mdi-plus-box"></i></button>
                            </div>
                            <!-- Modal Add Ustad -->
                            <div class="modal fade" id="ustad" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="ustad">Add Ustad Name</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <input type="text" name="" placeholder="Write new ustad name here" class="form-control">
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger">Add</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- End Modal -->
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Schedule</label>
                        <input type="date" name="" class="form-control">
                      </div>

                      <input type="submit" name="" value="Tambah" class="form-control btn btn-sm btn-gradient-success">

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
                          <th>Event Name</th>
                          <th>Ustad</th>
                          <th>Date Time</th>
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
