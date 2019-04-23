<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <?php $this->include('style/_profile'); ?>
  <!-- end custome -->

</head>
<body>
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
              Qurban
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">

                    <div class="col-md-7">

                      <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Total</label>
                        <input type="text" name="" placeholder="Total Qurban" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Qurban Type</label>
                        <select class="form-control" style="color: black;">
                          <option value="mosque construction">Sapi </option>
                          <option value="yatim piatu">Kambing</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Caretaker Account Bank</label>
                        <select class="form-control" style="color: black;">
                          <option value="mosque construction">BNI a/n Ihsan Sanusi (xxx-xx-x-xxxx)</option>
                          <option value="yatim piatu">BRI a/n Dayat Rifai (xxx-xxxxxx-xxxxx)</option>
                        </select>
                      </div>

                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="status" id="1" onclick="checkProfile()">Use your profile as a donor
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="status" id="2" onclick="checkProfile()">Use another profile as a donor
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="status" id="3" onclick="checkProfile()">Dont show donor's name to public (write as Hamba Allah)
                        </label>
                      </div>

                      <input type="submit" name="" value="Qurban" class="form-control btn btn-sm btn-gradient-success">

                    </div>

                    <script type="text/javascript">
                    function checkProfile() {
                      if (document.getElementById("1").checked){
                        var x = document.getElementById("showProfile");
                        x.style.display = "none";
                      }else if (document.getElementById("2").checked){
                        var x = document.getElementById("showProfile");
                        x.style.display = "block";
                      }else{
                        var x = document.getElementById("showProfile");
                        x.style.display = "none";
                      }
                    }
                    </script>

                    <div class="col-md-5" id="showProfile" style="display:none">
                      <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Mudhahy's Profile</label>
                        <input type="text" name="" placeholder="Name" class="form-control"><br>
                        <input type="text" name="" placeholder="Address" class="form-control"><br>
                        <input type="text" name="" placeholder="Phone" class="form-control">
                      </div>
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
