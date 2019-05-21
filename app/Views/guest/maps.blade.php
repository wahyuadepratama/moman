<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Script for maps -->
  <?php $this->include('maps/_google_map'); ?>
  <!-- end of script -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <!-- end custome -->

</head>
<body onload="init(); loading()">
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

          <div class="row">
            <div class="col-md-12" style="margin-bottom: 2%">
            <label>Check location: &nbsp;</label>

              <button class="btn btn-outline-success btn-icon " onclick="aktifkanGeolocation()" title="Current Location"> <i class="mdi mdi-home-map-marker"></i> </button>
              <button class="btn btn-outline-success btn-icon " id="manualPosition" onclick="manualLocation()" title="Manual Location"> <i class="mdi mdi-map-marker"></i> </button>
              <button href="#radiusCollapse" data-toggle="collapse" class="btn btn-outline-success btn-icon " title="Radius"> <i class="mdi mdi-map-marker-radius"></i> </button>

              <div class="collapse" id="radiusCollapse" style="margin-top:2%">
                <div class="card card-body">
                <div class="form-control" id="closest">
                  <label><b>Radius&nbsp</b></label><label style="color:black" id="km"><b>0</b></label>&nbsp<label><b>m</b></label><br>
                  <input class="custom-range" type="range" onclick="cekRadius();aktifkanRadius();resultt()" id="inputradiusmes" name="inputradiusmes" data-highlight="true" min="1" max="20" value="1" >
                </div>
                </div>
              </div>

            </div>
            <div class="col-md-9 grid-margin">
                <div id="map" class="form-control" style="height: 35em;"></div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body" style="padding: 5%">
                  <h6 style="text-align:center">Result</h6>

                  <div class="box-body" style="max-height:400px;overflow:auto;">
                    <div class="form-group" id="hasilcari1" style="display:none;">
                      <table class="table table-bordered" id='hasilcari'>
                        tes
                      </table>
                    </div>
                 </div>

                 <div class="col-sm-4" style="display:none;" id="resultaround">
                  <section class="panel">
                    <div class="panel-body">
                      <a class="btn btn-compose">Attraction Around</a>
                      <div class="box-body" style="max-height:400px;overflow:auto;">
                        <div class="form-group" id="hasilcari2" style="display:none;">
                          <table class="table table-bordered" id='hasilcariaround'>
                          </table>
                        </div>
                      </div>
                    </div>
                  </section>
                 </div>

                 <div class="col-sm-8" style="display:none;" id="infoo">
                   <section class="panel">
                    <div class="panel-body">
                      <a class="btn btn-compose">Information</a>
                      <div class="box-body" style="max-height:350px;overflow:auto;">
                        <div class="form-group">
                          <table class="table" id='info'>
                          <tbody  style='vertical-align:top;'>
                          </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    </section>
                 </div>

                 <div class="col-sm-8" style="display:none;" id="att1">
                   <section class="panel">
                    <div class="panel-body" >
                      <a class="btn btn-compose">Attraction Around Mosque</a>
                      <div class="box-body" style="max-height:350px;overflow:auto;">
                        <div class="form-group">
                          <table class="table table-bordered" id='info1'>
                          </table>
                        </div>
                      </div>
                    </div>
                    </section>
					       </div>

                 <div class="col-sm-4" style="display:none;" id="att2">
                  <section class="panel">
          					<div class="panel-body">
                      <a class="btn btn-compose">Route</a>
                    </div>
                    <div id="rute" class='box-body'></div>
                  </section>
                 </div>

                 <div class="col-sm-8" style="display:none;" id="infoev">
                  <section class="panel">
                    <div class="panel-body">
                      <a class="btn btn-compose">Information of Event</a>
                      <div class="box-body" style="max-height:350px;overflow:auto;">

                        <div class="form-group">
                          <table class="table" id='infoevent'>
                          <tbody  style='vertical-align:top;'>
                          </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </section>
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
  <!-- End custom js for this page-->

</body>

</html>
