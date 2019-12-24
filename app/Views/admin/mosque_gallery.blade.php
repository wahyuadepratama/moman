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
              <?php
                $stmt = $GLOBALS['pdo']->prepare("SELECT name FROM worship_place WHERE id=:id");
                $stmt->execute(['id' => $_GET['id']]);
               ?>
              Gallery <?= $stmt->fetch()['name'] ?>
            </h3>
            <a href="#" data-toggle="modal" data-target="#add_gallery" class="btn btn-gradient-danger btn-sm">+ Add Image</a>
            <!-- Modal Avatar -->
            <div class="modal fade" id="add_gallery" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="<?php $this->url('admin/mosque/gallery/store?id='. $_GET['id']) ?>" method="post" enctype="multipart/form-data">

                  <?php $this->csrf_field() ?>

                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="avatar">New Image</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="file" name="image" class="form-control" placeholder="Nama">
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Add</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- End Modal -->
          </div>

            <div class="row text-center text-lg-left">

              <?php if (isset($data)): ?>
                <?php foreach ($data as $value): ?>
                  <div class="col-lg-3 col-md-4 col-6">
                    <a href="#" class="d-block mb-4 h-100 img-wrap">
                      <style media="screen">
                        .img-wrap { position: relative; } .img-wrap .close { position: absolute;top: 2px;right: 2px;z-index: 100; }
                      </style>
                          <span class="close" onclick="confirm('<?php $this->url('admin/mosque/gallery/destroy?gallery='. $value['serial_number'] . '&id=' . $_GET['id']) ?>')"> <i class="mdi mdi-delete"></i> </span>
                          <img class="img-fluid img-thumbnail" src="<?php $this->url('images/mosque/'. $value['image']) ?>" data-toggle="modal" data-target="#myModal<?= $value['id'] ?>">
                          <div id="myModal<?= $value['serial_number'] ?>" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content" style="background-color:#0000;border-color:#0000">
                                  <div class="modal-body" style="text-align:center">
                                      <img src="<?php $this->url('images/mosque/'. $value['image']) ?>" class="img-responsive" width="500px" style="margin-top:20%">
                                  </div>
                              </div>
                            </div>
                          </div>
                        </a>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
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

</body>

</html>
