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
      <?php $this->include('partials/_sidebar_caretaker'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-chart-line"></i>
              </span>
              Mosque Financial Report
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">

                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="changeToEvent()" id="navEvent">Event's Report</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToDonation()" id="navDonation">Donation's Report</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#" onclick="changeToQurban()" id="navQurban">Qurban's Report</a>
                      </li>
                    </ul>

                    <script type="text/javascript">
                      function changeToEvent(){
                          var x = document.getElementById("event");
                          var y = document.getElementById("donation");
                          var z = document.getElementById("qurban");
                          x.style.display = "block";
                          y.style.display = "none";
                          z.style.display = "none";

                          var a = document.getElementById("navEvent");
                          var b = document.getElementById("navDonation");
                          var c = document.getElementById("navQurban");
                          a.classList.add("active");
                          b.classList.remove("active");
                          c.classList.remove("active");
                      }
                      function changeToDonation(){
                          var x = document.getElementById("event");
                          var y = document.getElementById("donation");
                          var z = document.getElementById("qurban");
                          x.style.display = "none";
                          y.style.display = "block";
                          z.style.display = "none";

                          var a = document.getElementById("navEvent");
                          var b = document.getElementById("navDonation");
                          var c = document.getElementById("navQurban");
                          a.classList.remove("active");
                          b.classList.add("active");
                          c.classList.remove("active");
                      }
                      function changeToQurban(){
                          var x = document.getElementById("event");
                          var y = document.getElementById("donation");
                          var z = document.getElementById("qurban");
                          x.style.display = "none";
                          y.style.display = "none";
                          z.style.display = "block";

                          var a = document.getElementById("navEvent");
                          var b = document.getElementById("navDonation");
                          var c = document.getElementById("navQurban");
                          a.classList.remove("active");
                          b.classList.remove("active");
                          c.classList.add("active");
                      }
                    </script>

                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%" id="event">
                      <table class="table table-striped">
                        <tr>
                          <th>Event Name</th>
                          <th>Schedule</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th>Detail</th>
                        </tr>
                        <tr>
                          <td>bla bla bla</td>
                          <td>1298192</td>
                          <td>kdjfkdjf</td>
                          <td>success</td>
                          <td>view</td>
                        </tr>
                      </table>
                    </div>

                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%; display:none" id="donation">
                      <table class="table table-striped">
                        <tr>
                          <th>Donation Name</th>
                          <th>Schedule</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th>Detail</th>
                        </tr>
                        <tr>
                          <td>bla bla bla</td>
                          <td>1298192</td>
                          <td>kdjfkdjf</td>
                          <td>success</td>
                          <td>view</td>
                        </tr>
                      </table>
                    </div>

                    <div class="col-md-12 table-responsive" style="text-align:center;margin-top:2%;display:none" id="qurban">
                      <table class="table table-striped">
                        <tr>
                          <th>Qurban Name</th>
                          <th>Schedule</th>
                          <th>Description</th>
                          <th>Status</th>
                          <th>Detail</th>
                        </tr>
                        <tr>
                          <td>bla bla bla</td>
                          <td>1298192</td>
                          <td>kdjfkdjf</td>
                          <td>success</td>
                          <td>view</td>
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

  <?php $this->include('partials/_plugin'); ?>

  <!-- Custom js for this page-->
  <script src="script/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
