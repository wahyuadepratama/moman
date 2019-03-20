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
<body style="background-image:url('images/padang.jpeg');background-position: center;
  background-repeat: no-repeat;
  background-size: cover;">
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar_home'); ?>
    <!-- partial -->

    <div class="container">
      <div class="content" style="margin-top:10%;margin-bottom:5%">
        <div class="row">

          <!-- <div class="col-md-3"></div> -->
          <div class="col-md-6">
            <div class="card" style="background-color: #dbffdb94">
              <div class="card-body">
                <div class="auth-form-light text-left p-5">
                  <h4>Please login here</h4>
                  <form class="pt-3">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg" placeholder="Username or Phone">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-lg" placeholder="Password">
                    </div>
                    <div class="mt-3">
                      <a class="btn btn-block btn-gradient-success btn-lg font-weight-medium auth-form-btn" href="../../index.html">SIGN IN</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="card" style="background-color: #dbffdb94">
              <div class="card-body">
                <div class="auth-form-light text-left p-5">
                  <h4>Don't have an account? Register here</h4>
                  <form class="pt-3">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg" placeholder="Phone">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg" placeholder="Address">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-lg" placeholder="Password Confirmation">
                    </div>
                    <div class="form-group">
                      <select class="form-control">
                        <option value="masjid">Masjid XXXX</option>
                        <option value="mushalla">Mushalla XXXXXXX</option>
                      </select>
                    </div>
                    <div class="mt-3">
                      <a class="btn btn-block btn-gradient-success btn-lg font-weight-medium auth-form-btn" href="../../index.html">SIGN UP</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3"></div>

        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>

    <!-- partial:partials/_footer.php -->
    <?php $this->include('partials/_footer'); ?>
    <!-- partial -->

    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?php $this->include('partials/_plugin'); ?>

</body>

</html>
