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
<body onload="loading()">
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <?php $this->include('partials/_sidebar_stewardship'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <?php if (!empty($this->flash())): ?>
            <br><div class="alert alert-success">
              <small><?php $this->flash('print') ?></small>
            </div>
          <?php endif; ?>

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              List Jamaah
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 table-responsive">
                      <table class="table" id="data">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Avatar</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Address</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (isset($j)): ?>
                            <?php $no=1; ?>
                            <?php foreach ($j as $value): ?>
                              <tr>
                                <td><?= $no ?></td>
                                <td> <?= $value->username  ?> </td>
                                <td> <img src="<?php $this->url('images/avatar/'. $value->avatar) ?>" width="100px"> </td>
                                <td> <?= $value->phone ?> </td>
                                <td>
                                  <?php if ($value->type == 'domisili'): ?>
                                    Jamaah berdomisili dilingkungan masjid ini
                                  <?php else: ?>
                                    Jamaah tidak berasal dari lingkungan masjid ini
                                  <?php endif; ?>
                                </td>
                                <td><?= $value->address ?></td>
                              </tr>
                              <?php $no++ ?>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </tbody>
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
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" charset="utf-8"></script>
  <script type="text/javascript">
  // $(document).ready(function() {
  //   $('#data').DataTable({
  //     dom: '<"clear"f><"clear">',
  //   });
  // } );
    $(document).ready(function() {
      $('#data').DataTable({
        "dom": '<"clear"f><"clear">',
        "language": {
            "lengthMenu": '_MENU_ ',
                "search": '',
                "searchPlaceholder": "search"
        }
    });
    } );
  </script>
  <!-- End custom js for this page-->

  <script src="<?php $this->url('script/js/dashboard.js') ?>"></script>

</body>

</html>
