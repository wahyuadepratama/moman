<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Moman - Gallery <?= $name->name ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php $this->url('script/vendors/iconfonts/mdi/css/materialdesignicons.min.css'); ?>">
  <link rel="stylesheet" href="<?php $this->url('script/vendors/css/vendor.bundle.base.css'); ?>">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php $this->url('script/css/style.css'); ?>">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php $this->url('images/favicon.png'); ?>" />
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js" charset="utf-8"></script>
  <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css">
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <!-- end custome -->

</head>
<body>
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->

    <!-- partial -->

    <div class="container-fluid page-body-wrapper" style="padding:0 !important">

      <!-- partial:partials/_sidebar.html -->

      <!-- partial -->

      <div class="">
        <div class="content-wrapper">

            <div class="row text-center text-lg-left">

              <?php if (isset($data)): ?>
                <?php foreach ($data as $value): ?>
                  <div class="col-lg-3 col-md-4 col-6">
                    <a href="#" class="d-block mb-4 h-100 img-wrap">
                      <style media="screen">
                        .img-wrap { position: relative; } .img-wrap .close { position: absolute;top: 2px;right: 2px;z-index: 100; }
                      </style>
                          <img class="img-fluid img-thumbnail" src="<?php $this->url('images/mosque/'. $value->image) ?>" data-toggle="modal" data-target="#myModal<?= $value->serial_number ?>">
                          <div id="myModal<?= $value->serial_number ?>" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content" style="background-color:#0000;border-color:#0000">
                                  <div class="modal-body" style="text-align:center">
                                      <img src="<?php $this->url('images/mosque/'. $value->image) ?>" class="img-responsive" width="500px" style="margin-top:20%">
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
