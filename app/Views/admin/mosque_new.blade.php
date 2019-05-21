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
  <!-- end custome -->

  <!-- Script for maps -->
  <?php $this->include('maps/_add_mosque'); ?>
  <!-- end of script -->

</head>
<body onload="init()">
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

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-plus-circle"></i>
              </span>
              Add New Mosque
            </h3>
          </div>

          <div class="row">

            <div class="col-md-6 grid-margin">
                <div id="map" class="form-control" style="height: 57em;"></div>
            </div>

            <div class="col-md-6 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">

                    <form action="<?php $this->url('admin/mosque/store') ?>" method="post">

                      <?php $this->csrf_field() ?>

                      <div class="col-md-12">

                        <div class="input-group mb-3">
                          <input name='latlang' type="text" id="latlng" class="form-control" placeholder="Latitude, Langitude" aria-label="Recipient's username" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <button id="showLocation" class="btn btn-sm btn-success" type="button">Check</button>
                            <button id="delete-polygon" class="btn btn-sm btn-danger" type="button"> <i class="mdi mdi-delete"></i> </button>
                          </div>
                        </div><br>

                        <div class="form-group">
                          <label>Worship Place Type</label>
                          <select class="form-control" name="type">
                            <option value="1">Mosque</option>
                            <option value="2">Mushalla</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" name="name" placeholder="Name" class="form-control">
                        </div>

                        <div class="form-group">
                          <label>Address</label>
                          <input type="text" name="address" placeholder="Address" class="form-control">
                        </div>

                        <div class="form-group">
                          <label>Capacity</label>
                          <input type="number" name="capacity" placeholder="People Capacity" class="form-control">
                        </div>

                        <div class="form-group">
                          <label>Park Area Size ( m<sup>2</sup> )</label>
                          <input type="number" name="park_area_size" placeholder="Park Area Size" class="form-control">
                        </div>

                        <div class="form-group">
                          <label>Facility</label>
                          <select class="js-example-basic-multiple form-control" name="facility[]" multiple="multiple">
                            <?php foreach ($f as $value): ?>
                              <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <div class="form-group">
                          <label>Geom</label>
                          <textarea name="geom" id="geom" rows="8" cols="80" class="form-control"></textarea>
                        </div>

                        <input type="submit" value="Save" class="form-control btn btn-sm btn-gradient-info">

                      </div>
                    </form>

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
  <script type="text/javascript">
    $(document).ready(function() {
      $('.js-example-basic-multiple').select2();
    });
  </script>
  <!-- End custom js for this page-->
</body>

</html>
