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
                  <h4>Login Admin</h4>
                  <form class="pt-3" method="post" action="<?php $this->url('admin/login') ?>">

                    <?php $this->csrf_field() ?>

                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg" name="username" placeholder="Username or Phone" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
                    </div>
                    <div class="mt-3">
                      <input type="submit" class="btn btn-block btn-gradient-success btn-lg font-weight-medium auth-form-btn" value="SIGN IN" >
                      <?php if (isset($data['error'])): ?>
                        <br><div class="alert alert-danger">
                          <?php echo $data['error'] ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

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
