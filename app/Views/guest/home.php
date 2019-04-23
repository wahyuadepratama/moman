<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <style media="screen">
    .effect{
      transform-origin: 50% 65%;
      transition: transform 15s, filter 6s ease-in-out;
      filter: brightness(30%);
      height: 380px;
    }.effect:hover{
      filter: brightness(100%);
      transform: scale(2);
    }.centered {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      text-align: center;
      font-size: 45px;
      padding-top: 8%;
    }@media only screen and (max-width: 768px) {
      .centered{
        font-size:25px;

      }
      .explaination{
        margin-left: 0%;
        margin-right: 0%;
      }
      .slide{
        height: 260px;
      }
    }


    .wrimagecard{
      margin-top: 0;
        margin-bottom: 1.5rem;
        text-align: left;
        position: relative;
        background: #fff;
        box-shadow: 12px 15px 20px 0px rgba(46,61,73,0.15);
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    .wrimagecard .fas{
      position: relative;
        font-size: 70px;
    }
    .wrimagecard-topimage_header{
    padding: 20px;
    }
    a.wrimagecard:hover, .wrimagecard-topimage:hover {
        box-shadow: 2px 4px 8px 0px rgba(46,61,73,0.2);
    }
    .wrimagecard-topimage a {
        width: 100%;
        height: 100%;
        display: block;
    }
    .wrimagecard-topimage_title {
        padding: 20px 24px;
        height: 80px;
        padding-bottom: 0.75rem;
        position: relative;
    }
    .wrimagecard-topimage a {
        border-bottom: none;
        text-decoration: none;
        color: #525c65;
        transition: color 0.3s ease;
    }
  </style>
  <!-- end custome -->

</head>
<body>
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar_home'); ?>
    <!-- partial -->

    <div class="carousel slide" data-ride="carousel" style="margin: -20px">
      <div class="carousel-inner">
        <div class="carousel-item active effect">
          <img class="d-block w-100" src="<?php $this->url('images/home.png') ?>" alt="First slide">
        </div>
        <div class="centered" style="text-shadow: 5px 2px 10px #289a61;"> Mosque Management <br><br>
          <a href="<?php $this->url('donation') ?>" class="btn btn-success">Donation</a>
          <a href="<?php $this->url('maps') ?>" class="btn btn-info">Information</a>
        </div>

      </div>
    </div>

    <p style="margin-right: 20%;margin-left: 20%;margin-top: 5%;margin-bottom: 5%; color:black; font-size:120%" class="explaination text-center font-italic">
      <b>Moman </b> is application that help you to give donation to the right recipient. <b>Moman </b> will give you some detail information about mosque and finance transparently.<br>
      Besides, you can also make a qurban transaction here by choosing the right mosque.
    </p><br>

    <div class="container" style="margin-bottom:5%">
	     <div class="row">
      	<div class="col-md-3 col-sm-4">
        	<div class="wrimagecard wrimagecard-topimage">
              <a href="#">
              <div class="wrimagecard-topimage_header" style="background-color:rgba(187, 120, 36, 0.1) ">
                <center><i class="fas fa-hand-holding-usd" style="color:#33a444b8"></i></center>
              </div>
              <div class="wrimagecard-topimage_title">
                <h4>Give Your Donation</h4>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
        	<div class="wrimagecard wrimagecard-topimage">
              <a href="#">
              <div class="wrimagecard-topimage_header" style="background-color:rgba(187, 120, 36, 0.1) ">
                <center><i class="fas fa-map-marker-alt" style="color:#33a444b8"></i></center>
              </div>
              <div class="wrimagecard-topimage_title">
                <h4>Maps Information</h4>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
        	<div class="wrimagecard wrimagecard-topimage">
              <a href="#">
              <div class="wrimagecard-topimage_header" style="background-color:rgba(187, 120, 36, 0.1) ">
                <center><i class="fas fa-coins" style="color:#33a444b8"></i></center>
              </div>
              <div class="wrimagecard-topimage_title">
                <h4>Financial Report</h4>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
        	<div class="wrimagecard wrimagecard-topimage">
              <a href="#">
              <div class="wrimagecard-topimage_header" style="background-color:rgba(187, 120, 36, 0.1) ">
                <center><i class="fas fa-mosque" style="color:#33a444b8"></i></center>
              </div>
              <div class="wrimagecard-topimage_title">
                <h4>Qurban at Mosque</h4>
              </div>
            </a>
          </div>
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
