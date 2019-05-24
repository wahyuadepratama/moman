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
              List Stewardship
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
                            <th>Worship Place</th>
                            <th>Status</th>
                            <th>Action</th>
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
                                <td> <?= $value->name ?> </td>

                                <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship WHERE jamaah_id=:id");
                                  $stmt->execute(['id' => $value->jamaah_id]);
                                  $data = $stmt->fetch(PDO::FETCH_OBJ);
                                ?>

                                <td>
                                  <?php if (empty($data)): ?>
                                    <p class="text-danger">Jamaah</p>
                                  <?php else: ?>
                                    <p class="text-success">Stewardship</p>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <?php if (empty($data)): ?>

                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#add_facility<?= $value->id ?>">Change</a>
                                    <!-- Modal Avatar -->
                                    <div class="modal fade" id="add_facility<?= $value->id ?>" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                      <div class="modal-dialog" role="document">

                                          <?php $this->csrf_field() ?>

                                          <form action="<?php $this->url('admin/stewardship/store?id='. $value->id) ?>" method="post">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="avatar">Upgrade Jamaah Menjadi Pengurus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <?php
                                                  $t = $GLOBALS['pdo']->prepare("SELECT * FROM type_of_work");
                                                  $t->execute();
                                                  $type = $t->fetchAll(PDO::FETCH_OBJ);
                                                ?>
                                                <select class="form-control" name="type">
                                                  <?php foreach ($type as $t): ?>
                                                    <option value="<?= $t->id ?>"><?= $t->name ?></option>
                                                  <?php endforeach; ?>
                                                </select>
                                                <input type="text" name="identity" class="form-control" placeholder="Identity Number (KTP)" required>
                                                <input type="text" name="whatsapp" class="form-control" placeholder="Whatsapp" value="<?= $value->phone ?>">
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Approve</button>
                                              </div>
                                            </div>
                                          </form>

                                      </div>
                                    </div>
                                    <!-- End Modal -->
                                  <?php else: ?>

                                    <a href="#" class="btn btn-sm btn-success" onclick="notif('#', 'This User has become stewardship', 'warning', 'Ok')">Done</a>

                                  <?php endif; ?>
                                </td>
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
