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
      <?php $this->include('partials/_sidebar_admin'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <?php if (isset($_GET['success']) && isset($_GET['success']) == 'true'): ?>
            <br><div class="alert alert-success">
              <small>Data berhasil ditambah!</small>
            </div>
          <?php endif; ?>

          <?php if (isset($_GET['deleted']) && isset($_GET['deleted']) == 'true'): ?>
            <br><div class="alert alert-success">
              <small>Data berhasil dihapus!</small>
            </div>
          <?php endif; ?>

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              Facility Type
            </h3>
            <a href="#" data-toggle="modal" data-target="#add_facility" class="btn btn-gradient-danger btn-sm">+ Add Facility Type</a>
            <!-- Modal Avatar -->
            <div class="modal fade" id="add_facility" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="<?php $this->url('admin/facility-type/store') ?>" method="post">

                  <?php $this->csrf_field() ?>

                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="avatar">New Facility Type</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="text" name="name" class="form-control" placeholder="Nama">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Add</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- End Modal -->
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 table-responsive" style="text-align:center">
                      <table class="table table-striped">
                        <tr>
                          <th>Facility Name</th>
                          <th>Action</th>
                        </tr>
                        <?php if (isset($facility)): ?>
                          <?php foreach ($facility as $value): ?>
                            <tr>
                              <td><?= $value['name'] ?></td>
                              <td>
                                <a href="#" onclick="confirm('<?php $this->url('admin/facility-type/destroy?id=' . $value['id']) ?>')" class="btn btn-sm btn-danger">Delete</a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>

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
  <script src="<?php $this->url('script/js/dashboard.js') ?>"></script>
  <!-- End custom js for this page-->
</body>

</html>
