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

  <style media="screen">
    #legend {
      background: #ffffffd1;
      padding: 15px;
      margin: 10px;
    }
  </style>

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

            <div class="col-md-8 grid-margin">
                <div id="map" class="form-control" style="height: 30em;positon:absolute"></div>
                <div id="legend">
                  <table>
                    <tr>
                      <td><div style="background-color:#9a55ffc9;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Air Manis</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#187efc;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Bukit Gado-gado</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#e91e63;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Batang Arau</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#9c27b0;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Seberang Palinggam</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#009688;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Pasa Gadang</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#4caf50;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Belakang Pondok</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#ffc107;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Alang Laweh</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#ff5722;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Teluk Bayur</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#cddc39;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Rawang</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#9e9e9e;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Mato Air</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#607d8b;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Mato Air</td>
                    </tr>
                    <tr>
                      <td><div style="background-color:#795548;height:10px;width:50px"></div></td>
                      <td>:</td>
                      <td>Ranah Parak Rumbio</td>
                    </tr>
                  </table>
                </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-body" style="padding: 5%">
                  <h6 class="btn btn-sm btn-success form-control">Result</h6><br>

                  <div style="max-height:330px;overflow:auto;">
                    <div class="form-group" id="hasilcari1" style="display:none;">
                      <table class="table table-bordered" id='hasilcari'>
                      </table>
                    </div>
                 </div>
                </div>
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
              <div class="card">
                <div class="card-body">
                  <section class="panel">
                   <div class="panel-body">

                     <h4 class="btn btn-sm btn-success form-control">Information</h4><br>
                     <div class="box-body" style="max-height:500px;overflow:auto;">
                       <div class="form-group">
                         <table class="table" id='info'>
                         </table>
                       </div>
                     </div>
                     <h4 class="btn btn-sm btn-success form-control">Facility</h4><br>
                     <div class="box-body" style="max-height:500px;overflow:auto;">
                       <div class="form-group">
                         <table class="table" id='infoFacility'>
                         </table>
                       </div>
                     </div>
                     <h4 class="btn btn-sm btn-success form-control">Event</h4><br>
                     <div class="box-body" style="max-height:500px;overflow:auto;">
                       <div class="form-group">
                         <table class="table" id='infoEvent'>
                         </table>
                       </div>
                     </div>

                   </div>
                   </section>
                </div>
              </div>
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
             <div class="card">
               <div class="card-body">
                 <section class="panel">
                   <div class="panel-body">
                     <h4 class="btn btn-sm btn-success form-control">Route</h4><br>
                   </div>
                   <div id="rute" class='box-body' style="max-height:500px !important; overflow:auto;"></div>
                 </section>
               </div>
             </div>
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
