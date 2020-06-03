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
                            <th>No Trx</th>
                            <th>Date</th>
                            <th>Jamaah Name</th>
                            <th>Status</th>
                            <th>Detail</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($trans as $h): ?>

                            <?php
                              $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM qurban_detail
                                                                WHERE jamaah_id=:j AND date=:dates
                                                                AND order_number=:order");
                              $stmt->execute(['j' => $h->jamaah_id, 'dates' => $h->date, 'order' => $h->order_number]);
                              $count = $stmt->fetch(PDO::FETCH_OBJ);
                            ?>

                            <tr>
                              <td>#<?php $date = new DateTime($h->date); ?><?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?></td>
                              <td><?php $date = new DateTime($h->date); echo $date->format('j F Y'); ?></td>
                              <td><?= $h->jamaah_name ?></td>
                              <td>
                                <?php if ($h->payment_completed == true): ?>
                                  <div class="text-success" name="button"> <b>Payment Completed</b> </div>
                                <?php else: ?>
                                  <div class="text-danger"> <b>Payment Incomplete</b> </div>
                                <?php endif; ?>
                              </td>
                              <td>
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#invoice<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>">More</a>
                                <!-- Modal Avatar -->
                                <div class="modal fade" id="invoice<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <form class="" action="<?php $this->url('/stewardship/qur/confirm') ?>" method="post">
                                      <?php $this->csrf_field() ?>
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="avatar">Detail Information</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body" id="printableArea<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>">
                                          <div class="invoice-box">
                                            <style media="all"> .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555; } .invoice-box table { width: 100%; line-height: inherit; text-align: left; } .invoice-box table td { padding: 5px; vertical-align: top; } .invoice-box table tr td:nth-child(2) { text-align: right; } .invoice-box table tr.top table td { padding-bottom: 20px; } .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; } .invoice-box table tr.information table td { padding-bottom: 40px; } .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; } .invoice-box table tr.details td { padding-bottom: 20px; } .invoice-box table tr.item td{ border-bottom: 1px solid #eee; } .invoice-box table tr.item.last td { border-bottom: none; } .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; } @media only screen and (max-width: 600px) { .invoice-box table tr.top table td { width: 100%; display: block; text-align: center; } .invoice-box table tr.information table td { width: 100%; display: block; text-align: center; } } /** RTL **/ .rtl { direction: rtl; font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; } .rtl table { text-align: right; } .rtl table tr td:nth-child(2) { text-align: left; } </style>
                                            <table cellpadding="0" cellspacing="0">

                                                <tr class="heading">
                                                  <td>Worship Place</td>
                                                  <td>
                                                      <?= $h->name ?>
                                                  </td>
                                                </tr>

                                                <tr class="details">
                                                  <td style="vertical-align:top">Participant Name</td>
                                                  <td>
                                                    <?= $h->jamaah_name ?>
                                                  </td>
                                                </tr>

                                                <tr class="heading">
                                                    <td>Total Animal</td>
                                                    <td>
                                                      <?= $count->count ?> Slot
                                                    </td>
                                                </tr>

                                                  <tr class="details">
                                                      <td>Total Qurban</td>
                                                      <td>
                                                          Rp <?= number_format(($h->animal_price * $count->count),0,',','.') ?>
                                                      </td>
                                                  </tr>

                                                  <tr class="details" style="color:green">
                                                      <td>Paid</td>
                                                      <td>
                                                          Rp <?= number_format(($h->uang_muka + $h->uang_pelunasan),0,',','.') ?>
                                                      </td>
                                                  </tr>

                                                  <tr class="details" style="color: red">
                                                    <td>Unpaid</td>
                                                    <td>
                                                      Rp <?= number_format((($h->animal_price*$count->count) - ($h->uang_muka + $h->uang_pelunasan)),0,',','.') ?>
                                                    </td>
                                                  </tr>

                                                  <tr class="heading">
                                                    <td>New Payment</td>
                                                    <td></td>
                                                  </tr>

                                                  <tr class="details">
                                                    <td style="vertical-align:top">Fund</td>
                                                    <td>
                                                      <input type="text" name="fund" value="" class="form-control" required id="rupiah<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>">
                                                      <script type="text/javascript">

                                                        var rupiah<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?> = document.getElementById('rupiah<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>');
                                                        rupiah<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>.addEventListener('keyup', function(e){
                                                          // tambahkan 'Rp.' pada saat form di ketik
                                                          // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                                                          rupiah<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>.value = formatRupiah(this.value, 'Rp. ');
                                                        });

                                                        rupiah<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>.addEventListener('keyup', function(e){
                                                          rupiah<?= $date->format('Ymj').$h->order_number.$h->jamaah_id; ?>.value = formatRupiah(this.value, 'Rp. ');
                                                        });
                                                      </script>
                                                      <input type="hidden" name="jamaah" value="<?= $h->jamaah_id ?>">
                                                      <input type="hidden" name="date" value="<?= $h->date ?>">
                                                      <input type="hidden" name="uang_muka" value="<?= $h->uang_muka ?>">
                                                      <input type="hidden" name="order_number" value="<?= $h->order_number ?>">
                                                      <input type="hidden" name="uang_pelunasan" value="<?= $h->uang_pelunasan ?>">
                                                      <input type="hidden" name="unpaid" value="<?= $h->animal_price*$count->count - ($h->uang_muka + $h->uang_pelunasan) ?>">
                                                    </td>
                                                  </tr>

                                            </table>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                          <?php if (!$h->payment_completed): ?>
                                            <input type="submit" class="btn btn-sm btn-success" value="Confirmation">
                                          <?php endif; ?>
                                          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                    </form>
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
  <script type="text/javascript">
    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split   		= number_string.split(','),
      sisa     		= split[0].length % 3,
      rupiah     		= split[0].substr(0, sisa),
      ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
  </script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#data').DataTable({
        "order": [[ 0, "desc" ]],
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
