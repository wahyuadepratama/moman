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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Avatar</th>
                            <th>Phone</th>
                            <th>Account</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (isset($j)): ?>
                            <?php foreach ($j as $value): ?>
                              <tr>
                                <td> #<?= $value->id ?></td>
                                <td> <?= $value->username  ?> </td>
                                <td> <img src="<?php $this->url('images/avatar/'. $value->avatar) ?>" width="100px"> </td>
                                <td> <?= $value->phone ?> </td>
                                <td>
                                  <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#add_facility<?= $value->phone ?>">Add Stewardship Account</a>
                                  <!-- Modal Avatar -->
                                  <div class="modal fade" id="add_facility<?= $value->phone ?>" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                    <div class="modal-dialog" role="document">

                                        <?php $this->csrf_field() ?>

                                        <form action="<?php $this->url('admin/jamaah/store?id='. $value->id) ?>" method="post">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="avatar">Upgrade Jamaah Become Pengurus</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <?php
                                                $t = $GLOBALS['pdo']->prepare("SELECT * FROM type_of_work");
                                                $t->execute();
                                                $type = $t->fetchAll(PDO::FETCH_OBJ);

                                                $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah_worship as jw INNER JOIN worship_place as wp
                                                                                  ON jw.worship_place_id=wp.id WHERE jw.jamaah_id=:id");
                                                $stmt->execute(['id' => $value->id]);
                                                $listWorship = $stmt->fetchAll(PDO::FETCH_OBJ);
                                              ?>
                                              <select class="form-control" name="type">
                                                <?php foreach ($type as $t): ?>
                                                  <option value="<?= $t->id ?>"><?= $t->name ?></option>
                                                <?php endforeach; ?>
                                              </select>
                                              <select class="form-control" name="worship">
                                                <?php foreach ($listWorship as $l): ?>
                                                  <option value="<?= $l->worship_place_id ?>"><?= $l->name ?></option>
                                                <?php endforeach; ?>
                                                <?php if (!$listWorship): ?>
                                                  <option disabled selected>Belum Ada Masjid Terdaftar</option>
                                                <?php endif; ?>
                                              </select>
                                              <input type="text" name="period" class="form-control" placeholder="2019-2020" maxlength="9">
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-success">Upgrade</button>
                                            </div>
                                          </div>
                                        </form>

                                    </div>
                                  </div>
                                  <!-- End Modal -->
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
        "paging": false,
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
