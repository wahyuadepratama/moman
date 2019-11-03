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
              List Mosque
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Capacity</th>
                            <th>Park Area</th>
                            <th>Gallery</th>
                            <th>Detail</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (isset($mosque)): ?>
                            <?php foreach ($mosque as $value): ?>
                              <tr>
                                <td><?= $value['id'] ?></td>
                                <td> <?= $value['name']  ?> </td>
                                <td> <?= $value['address']  ?> </td>
                                <td> <?= $value['capacity'] . ' jamaah'?> </td>
                                <td> <?= $value['park_area_size'] ?> m<sup>2</sup> </td>
                                <td> <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT count(*) FROM gallery WHERE worship_place_id=:id");
                                  $stmt->execute(['id' => $value['id']]);
                                  echo $stmt->fetch()['count'] . ' image';
                                 ?> </td>
                                <td>
                                  <a href="<?php $this->url('admin/mosque/gallery?id='. $value['id']) ?>" class="btn btn-sm btn-success">Gallery</a>
                                  <a href="#" onclick="confirm('<?php $this->url('admin/mosque/destroy?id=' . $value['id']) ?>')" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                              </tr>
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
        "pageLength" : "100",
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
