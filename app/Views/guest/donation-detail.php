<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Script for maps -->
  <?php $this->include('maps/_find_mosque'); ?>
  <!-- end of script -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <?php $this->include('style/_profile'); ?>
  <!-- end custome -->

</head>
<body onload="init()">
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <?php $this->include('partials/_sidebar'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              Pembangunan Halaman Masjid
            </h3>
          </div>

          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div id="2" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner slide style=" style="width:100%  !important;">
                    <div class="carousel-item active imgfix">
                      <img class="d-block w-100" src="<?php $this->url('images/mosque/example.png') ?>" >
                    </div>
                    <div class="carousel-item imgfix">
                      <img class="d-block w-100" src="<?php $this->url('images/mosque/example.png') ?>" >
                    </div>
                    <div class="carousel-item imgfix">
                      <img class="d-block w-100" src="<?php $this->url('images/mosque/example.png') ?>" >
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#2" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#2" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              <div class="col-md-7" style="margin: 2%">
                <div class="row">
                   <div class="card bg-gradient-dark card-img-holder text-white form-control" style="padding: 2% !important;">
                    <div class="card-body" style="padding: 5% !important">
                      <img src="<?php $this->url('images/dashboard/circle.svg') ?>" class="card-img-absolute" alt="circle-image">
                      <h4 class="font-weight-bold mb-3">
                        <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i> Pembangunan Halaman Masjid
                      </h4><br>
                      <h6 class="text-left">Fund Needed:</h6>
                      <h6 class="text-right">Rp 123.000.000</h6>

                      <h6 class="text-left">Fund Collected: </h6>
                      <h6 class="text-right">Rp 23.000.000</h6>

                      <h6 class="text-left">Mosque/Mushalla: </h6>
                      <h6 class="text-right">Masjid Al-Amanah</h6>

                      <h6 class="text-left">Stewardship Mosque: </h6>
                      <h6 class="text-right">Muhammad Ali (0813271821)</h6>
                      <h6 class="text-right">Jaka Perdana Putra (9821312112)</h6>

                      <h6 class="text-left">Description and Progress: </h6>
                      <h6 class="text-left">Description and Progress Description and Progress Description and Progress Description and Progress Description and Progress Description and Progress</h6>
                    </div>
                  </div>
                  <div class="card bg-gradient-dark card-img-holder text-white form-control" style="margin-top: 5%; padding: 2% !important;">
                    <div class="card-body">
                      <div class="row">

                        <div class="col-md-12">

                          <div class="form-group">
                            <label>Total</label>
                            <input type="number" name="" placeholder="Total Donation" class="form-control">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputConfirmPassword1">Stewardship Account Bank</label>
                            <select class="form-control" style="color: black;">
                              <option value="mosque construction">BNI a/n Ihsan Sanusi (xxx-xx-x-xxxx)</option>
                              <option value="yatim piatu">BRI a/n Dayat Rifai (xxx-xxxxxx-xxxxx)</option>
                            </select>
                          </div>

                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="status">Use your profile as a donatur
                            </label>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="status">Dont show donatur's name to public (write as Hamba Allah)
                            </label>
                          </div>
                          <input type="submit" name="" value="Donation" class="form-control btn btn-sm btn-gradient-success">
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="margin: 2%">
                <div class="row">
                  <div class="card bg-gradient-dark card-img-holder text-white form-control" style="padding: 2% !important;">
                    <div class="card-body" style="padding: 10% !important">
                      <img src="<?php $this->url('images/dashboard/circle.svg') ?>" class="card-img-absolute" alt="circle-image">
                      <h4 class="font-weight-bold mb-3">
                        <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i> List Donatur
                      </h4><br>
                      <h6 class="text-left">Hendra Setiawan:</h6>
                      <h6 class="text-right">Rp 200.000</h6>
                      <h6 class="text-left">Asep Chaniago: </h6>
                      <h6 class="text-right">Rp 1.000.000</h6>
                      <h6 class="text-left">Ade Fitra: </h6>
                      <h6 class="text-right">Rp 500.000</h6>
                      <h6 class="text-left">Hendra Setiawan:</h6>
                      <h6 class="text-right">Rp 200.000</h6>
                      <h6 class="text-left">Asep Chaniago: </h6>
                      <h6 class="text-right">Rp 1.000.000</h6>
                      <h6 class="text-left">Ade Fitra: </h6>
                      <h6 class="text-right">Rp 500.000</h6>
                      <h6 class="text-left">Hendra Setiawan:</h6>
                      <h6 class="text-right">Rp 200.000</h6>
                      <h6 class="text-left">Asep Chaniago: </h6>
                      <h6 class="text-right">Rp 1.000.000</h6>
                      <h6 class="text-left">Ade Fitra: </h6>
                      <h6 class="text-right">Rp 500.000</h6>
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
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#data').DataTable({
        dom: '<"clear"f><"clear">',
      });
    } );
  </script>
  <!-- End custom js for this page-->
</body>

</html>
