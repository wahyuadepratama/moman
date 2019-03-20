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
    <?php $this->include('partials/_navbar_home'); ?>
    <!-- partial -->

    <div class="homepage">
      <img style="filter: opacity(30%);" src="images/mosque/nurul-iman.jpg" width="100%">
      <div class="text-centered">
        <h3>
          <i>
            "Moman is application for managing mosques and mushalla that aims to facilitate
            the community can do more for mosques and mushallas in their neighborhood"
          </i>
        </h3>
      </div>
    </div>

    <style media="screen">
      .homepage {
        position: relative;
        text-align: center;
        color: white;
        background: rgba(39,62,84,0.82);
      }
      .text-centered {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
    </style>

    <div class="container">
      <div class="content">
        <div class="row">
          <p style="margin-top:20%">ini home</p>
        </div>
      </div>
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
