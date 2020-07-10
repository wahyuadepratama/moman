<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <script src="<?php $this->url('script/vendors/js/vendor.bundle.base.js'); ?>"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <?php $this->include('style/_profile') ?>
  <!-- end custome -->

</head>
<body onload="loading()">
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <?php $this->include('partials/_sidebar_jamaah'); ?>
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
            <div class="col-md-12 grid-margin">

              <?php if (!empty($this->flash())): ?>
                <br><div class="alert alert-success form-control">
                  <?php $this->flash('print') ?>
                </div>
              <?php endif; ?>
              
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4" style="text-align:center;">

                      <a href="#" data-toggle="modal" data-target="#avatar">
                        <center>
                          <style media="screen">
                          .hover-image {
                            position: relative;
                            width: 150px;
                            border-radius: 50%;
                            height: 150px;
                            background-image: url('<?= $this->url('images/avatar/'. $_SESSION['user']->avatar); ?>');
                            background-size: cover;
                            background-position: center top;
                            }
                          </style>
                          <div class="hover-image" >
                            <!-- <img class="hover-image-radius" src="<?= $this->url('images/avatar/'. $_SESSION['user']->avatar); ?>" alt="avatar" style="border-radius: 50%"> -->
                            <div class="overlay">
                              <div class="hover-image-icon">
                                <i class="mdi mdi-upload text-success"></i>
                              </div>
                            </div>
                          </div>
                        </center>
                      </a><br>

                      <a href="#" style="margin: 1%" class="btn btn-sm btn-gradient-danger" data-toggle="modal" data-target="#password">Change Password</a>
                      <a href="#" style="margin: 1%" class="btn btn-sm btn-gradient-info" data-toggle="modal" data-target="#profile">Update Profile</a>
                      <button type="button" name="button" class="btn btn-sm btn-success"  data-toggle="modal"
                      data-target="#new_mosque">Add Mosque</button>
                      <!-- Modal Avatar -->
                      <div class="modal fade" id="avatar" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <form method="post" enctype="multipart/form-data" action="<?php $this->url('jamaah/avatar/store') ?>">
                            <?php $this->csrf_field() ?>

                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="avatar">Change Avatar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <input type="file" name="image" value="Upload Avatar" class="form-control">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Upload</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!-- End Modal -->
                      <!-- Modal Password -->
                      <div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="password" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <form action="<?php $this->url('jamaah/password/update') ?>" method="post">
                            <?php $this->csrf_field() ?>

                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="password">Change Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <input type="password" name="password" placeholder="New Password" class="form-control">
                                <input type="password" name="password-confirmation" placeholder="Confirmation Password" class="form-control">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Save</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!-- End Modal -->
                      <!-- Modal Profile -->
                      <div class="modal fade" id="profile">
                        <div class="modal-dialog">
                          <form action="<?php $this->url('jamaah/profile/update') ?>" method="post">
                            <?php $this->csrf_field() ?>
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="profile">Update Profile</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="col-md-12">
                                    <input type="text" name="name" value="<?= $_SESSION['user']->name ?>" placeholder="Name" class="form-control">
                                    <input type="text" name="username" value="<?= $_SESSION['user']->username ?>" placeholder="Username" class="form-control">
                                    <input type="text" name="phone" value="<?= $_SESSION['user']->phone ?>" placeholder="Phone" class="form-control">
                                    <input type="text" name="address" value="<?= $_SESSION['user']->address ?>" placeholder="Address" class="form-control"><br>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Save</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!-- End Modal -->
                    </div>
                    <div class="col-md-8 table-responsive" style="margin-top: 3%">
                      <table class="table">
                        <tr>
                          <td>Jamaah Name</td>
                          <td>:</td>
                          <td><?= $_SESSION['user']->name ?></td>
                        </tr>
                        <tr>
                          <td>KTP Number</td>
                          <td>:</td>
                          <td><?= $_SESSION['user']->id ?></td>
                        </tr>
                        <tr>
                          <td>Username</td>
                          <td>:</td>
                          <td><?= $_SESSION['user']->username ?></td>
                        </tr>
                        <tr>
                          <td>Phone</td>
                          <td>:</td>
                          <td><?= $_SESSION['user']->phone ?></td>
                        </tr>
                        <tr>
                          <td>Address</td>
                          <td>:</td>
                          <td><?= $_SESSION['user']->address ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align: top">Jamaah at</td>
                          <td style="vertical-align: top">:</td>
                          <td>
                            <?php if (!$mosque): ?>
                              <p>Belum terdaftar ditempat ibadah manapun!</p>
                            <?php endif; ?>
                            <!-- End Modal -->
                            <?php foreach ($mosque as $m): ?>
                              <li><?= $m->name ?></li>
                            <?php endforeach; ?>
                            <!-- Modal Mosque -->
                            <div class="modal fade" id="new_mosque" role="dialog" aria-labelledby="new_mosque" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="<?php $this->url('jamaah/dashboard/mosque/new') ?>" method="post">
                                  <?php $this->csrf_field() ?>

                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="password">Add Mosque</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <select class="js-example-basic-single form-control" name="mosque" style="width:100%;">
                                        <?php foreach ($allMosque as $value): ?>
                                          <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-danger">Add</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>

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

  <script src="<?php $this->url('script/vendors/js/vendor.bundle.addons.js'); ?>"></script>
  <script src="<?php $this->url('script/js/off-canvas.js'); ?>"></script>
  <script src="<?php $this->url('script/js/misc.js'); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script type="text/javascript">
    function confirm(url){
      Swal.fire({
        title: 'Are you sure?',
        type: 'warning',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          window.location = url;
        }
      })
    }
  </script>
  <!-- Custom js for this page-->
  <style media="screen">#nprogress .bar {background: #6cbd78cc;}</style>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
    });
    function loading() {
      NProgress.configure({ easing: 'ease', speed: 3000 });
      NProgress.configure({ showSpinner: false });
      NProgress.configure({ minimum: 0.1 });
      NProgress.start();
      NProgress.done();
      // setTimeout(function(){ NProgress.done(); }, 1000);
    }
  </script>

</body>

</html>
