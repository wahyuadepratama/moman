<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <style media="all"> .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555; } .invoice-box table { width: 100%; line-height: inherit; text-align: left; } .invoice-box table td { padding: 5px; vertical-align: top; } .invoice-box table tr td:nth-child(2) { text-align: right; } .invoice-box table tr.top table td { padding-bottom: 20px; } .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; } .invoice-box table tr.information table td { padding-bottom: 40px; } .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; } .invoice-box table tr.details td { padding-bottom: 20px; } .invoice-box table tr.item td{ border-bottom: 1px solid #eee; } .invoice-box table tr.item.last td { border-bottom: none; } .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; } @media only screen and (max-width: 600px) { .invoice-box table tr.top table td { width: 100%; display: block; text-align: center; } .invoice-box table tr.information table td { width: 100%; display: block; text-align: center; } } /** RTL **/ .rtl { direction: rtl; font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; } .rtl table { text-align: right; } .rtl table tr td:nth-child(2) { text-align: left; } </style>
  <!-- end custome -->

</head>
<body onload="loading()">
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <?php $this->include('partials/_sidebar_stewardship'); ?>
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">

          <?php if (!empty($this->flash())): ?>
            <br><div class="alert alert-success">
              <small><?php $this->flash('print') ?></small>
            </div>
          <?php endif; ?>

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              Qurban Transaction
            </h3>
          </div>

          <div class="row">

            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 table-responsive">
                      <table class="table" id="data">
                        <thead style="text-align:center">
                          <tr>
                            <th>ID Trx</th>
                            <th>Group</th>
                            <th>Paid</th>
                            <th>Unpaid</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody style="text-align:center">
                          <?php foreach ($trans as $h): ?>
                            <tr>
                              <td>#<?= $h->worship_place_id ?><?= $h->group ?><?= $h->year ?><?= date('jmyHis', strtotime($h->datetime)) ?></td>
                              <td><?= $h->group ?></td>
                              <td>Rp <?= number_format($h->fund * (int)substr($h->payment_method, 2, 1),0,',','.') ?></td>
                              <td>Rp <?= number_format($h->fund * (int)substr($h->payment_method, 0, 1),0,',','.') ?></td>
                              <td>
                                <?php if ($h->confirmation == true): ?>
                                  <span class="badge badge-success">Payment Completed</span>
                                <?php else: ?>
                                  <span class="badge badge-danger">Payment in Progress</span>
                                <?php endif; ?>
                              </td>
                              <td>
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#invoice<?= $h->worship_place_id ?><?= $h->group ?><?= $h->year ?><?= date('jmyHis', strtotime($h->datetime)) ?>"> <i class="mdi mdi-crop-free"></i> </a>

                                  <?php if (rtrim($h->animal_type) != 'Goat'): ?>
                                  <button type="button" class="btn btn-sm btn-danger" onclick="notif('<?php $this->url('stewardship/qur/close?id='. $this->encrypt($h->datetime)) ?>', 'Warning!',
                                    'This feature is used if qurban funds from jamaah are insufficient and only enough for qurban goats. The remaining excess funds will be refunded',
                                    'question', 'Yes, Change Qurban to Goat!')" name="button">Close Qurban</button>
                                <?php endif; ?>

                                <!-- Modal Avatar -->
                                <div class="modal fade" id="invoice<?= $h->worship_place_id ?><?= $h->group ?><?= $h->year ?><?= date('jmyHis', strtotime($h->datetime)) ?>" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <form method="post" action="<?php $this->url('stewardship/qur/confirm?id='. $this->encrypt($h->datetime)) ?>">
                                          <?php $this->csrf_field() ?>
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="avatar">Detail</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <table style="text-align:left !important">
                                            <tr>
                                              <td>Worship Place</td>
                                              <td>:</td>
                                              <td><?= $h->name ?></td>
                                            </tr>
                                            <tr>
                                              <td>Qurban</td>
                                              <td>:</td>
                                              <td><?= $h->animal_type ?></td>
                                            </tr>
                                            <tr>
                                              <td>Jamaah</td>
                                              <td>:</td>
                                              <td><?= $h->username ?></td>
                                            </tr>
                                            <tr>
                                              <td>Payment of each Installment</td>
                                              <td>:</td>
                                              <td>Rp <?= number_format($h->fund,0,',','.') ?></td>
                                            </tr>
                                            <tr>
                                              <td>Unpaid Installments</td>
                                              <td>:</td>
                                              <td><?= substr($h->payment_method, 0, 1) ?> more times</td>
                                            </tr>
                                            <tr>
                                              <td>Paid Installments</td>
                                              <td>:</td>
                                              <td><?= substr($h->payment_method, 2, 1) ?> times</td>
                                            </tr>
                                            <tr style="color: red">
                                              <td>Unpaid</td>
                                              <td>:</td>
                                              <td>Rp <?= number_format($h->fund * (int)substr($h->payment_method, 0, 1),0,',','.') ?></td>
                                            </tr>
                                            <tr style="color: green">
                                              <td>Paid</td>
                                              <td>:</td>
                                              <td>Rp <?= number_format($h->fund * (int)substr($h->payment_method, 2, 1),0,',','.') ?></td>
                                            </tr>
                                            <?php if (substr($h->payment_method, 10, 20)): ?>
                                              <tr style="font-weight: bold">
                                                <td>Refund</td>
                                                <td>:</td>
                                                <td>Rp <?= number_format((int)substr($h->payment_method, 10, 20),0,',','.') ?></td>
                                              </tr>
                                            <?php endif; ?>

                                          </table>
                                        </div>
                                        <div class="modal-footer">
                                          <?php if ($h->confirmation == false): ?>
                                            <button class="btn btn-sm btn-success" type="submit"> Confirmation </button>
                                          <?php endif; ?>
                                          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                        </form>
                                      </div>
                                  </div>
                                </div>
                                <!-- End Modal -->
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
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
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#data').DataTable({
        "pageLength" : "100",
        "dom": '<"clear"f><"clear">',
        "language": {
            "lengthMenu": '_MENU_ ',
                "search": '',
                "searchPlaceholder": "search"
        }
    });
    } );

  </script>
  <script src="<?php $this->url('script/js/dashboard.js') ?>"></script>
  <!-- End custom js for this page-->
</body>

</html>
