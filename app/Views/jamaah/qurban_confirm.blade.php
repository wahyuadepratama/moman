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
<body onload="loading()">
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <?php $this->include('partials/_sidebar_jamaah'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12" style="text-align:center;">
                      <!-- <i style="font-size: 10em" class="mdi mdi-check-circle text-success"></i> -->
                      <img src="<?php $this->url('images/wait.gif') ?>" width="300px">
                      <h3>Qurban Confirmation (<?=$qurban->total_slot .' Slot '. $qurban->animal_type ?>)</h3>
                      <h3>Rp <?= number_format(($qurban->fund),0,',','.') ?></h3><br><br>

                      <h5>Installments that have been Paid: <?= substr($qurban->payment_method, 2, 1) ?> times</h5>
                      <h5>Unpaid Installments: <?= substr($qurban->payment_method, 0, 1) ?> more times</h5><br>
                      <h5>Already Paid: Rp <?= number_format($qurban->fund * (int)substr($qurban->payment_method, 2, 1),0,',','.') ?></h5>
                      <h5>Remaining Payment: Rp <?= number_format($qurban->fund * (int)substr($qurban->payment_method, 0, 1),0,',','.') ?></h5><br>

                      <h5>Invoice #<?= $qurban->worship_place_id ?><?= $qurban->group ?><?= $qurban->year ?><?= date('jmyHis', strtotime($qurban->datetime)) ?><h5><br>

                      <h4>Transfer Qurban Fund via <?= $mosque ?> Bank Account</h4>
                      <h4><?= $account->bank ?> a/n <?= $account->owner ?> (<?= $account->account_number ?>)</h4><br>

                      <h4>After making a payment, please confirm immediately via the following SMS or WhatsApp to:</h4>
                      <h4><?= $account->whatsapp ?> (SMS) | <?= $account->phone ?> (Whatsapp)</h4> <br>
                      <a href="<?php $this->url('jamaah/qurban') ?>" class="btn btn-md btn-success">Check Invoice After Payment</a>
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

  <!-- End custom js for this page-->
</body>

</html>
