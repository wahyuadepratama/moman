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
                            <th>Datetime</th>
                            <th>Animal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody style="text-align:center">
                          <?php foreach ($trans as $h): ?>
                            <tr>
                              <td>
                                <?php
                                  $date = new DateTime($h->datetime);
                                  echo $date->format('l, j F Y, g:i a');
                                ?>
                              </td>
                              <td>
                                <?= $h->animal_type ?>
                              </td>
                              <td>
                                Rp <?= number_format(($h->fund),0,',','.') ?>
                              </td>
                              <td>
                                <?php if ($h->confirmation == true): ?>
                                  <div class="text-success"> <b>Confirmed</b> </div>
                                <?php else: ?>
                                  <div class="text-danger"> <b>Checking</b> </div>
                                <?php endif; ?>
                              </td>
                              <td>
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#invoice<?= $h->worship_place_id ?><?= $h->grup ?><?= $h->year ?>"> <i class="mdi mdi-crop-free"></i> </a>
                                <!-- Modal Avatar -->
                                <div class="modal fade" id="invoice<?= $h->worship_place_id ?><?= $h->grup ?><?= $h->year ?>" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <form method="post" action="<?php $this->url('stewardship/qur/confirm?id='. $h->datetime) ?>">
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
                                              <td>Jamaah</td>
                                              <td>:</td>
                                              <td><?= $h->username ?></td>
                                            </tr>
                                            <tr>
                                              <td style="vertical-align:top">Participant</td>
                                              <td style="vertical-align:top">:</td>
                                              <td>
                                                <?php
                                                  $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM participant WHERE grup=:grup AND year=:year AND worship_place_id=:id");
                                                  $stmt->execute(['grup' => $h->grup, 'year' => $h->year, 'id' => $h->worship_place_id]);
                                                  $part = $stmt->fetchAll(PDO::FETCH_OBJ);
                                                ?>
                                                <ul>
                                                  <?php foreach ($part as $p): ?>
                                                    <li><?= $p->name ?></li>
                                                  <?php endforeach; ?>
                                                </ul>
                                              </td>
                                            </tr>
                                            <?php if ($h->confirmation == true): ?>
                                              <tr>
                                                <td style="vertical-align:top">Description</td>
                                                <td style="vertical-align:top">:</td>
                                                <td>
                                                    <?= $h->description ?>
                                                </td>
                                              </tr>
                                            <?php else: ?>
                                              <tr>
                                                <td style="vertical-align:top">Description</td>
                                                <td style="vertical-align:top">:</td>
                                                <td>
                                                  <textarea name="description" rows="5" required placeholder="Example: Ditransfer dari bank Mandiri (121312) a/n Jhony pada tanggal 20 Mei 2019" cols="30" class="form-control"></textarea>
                                                </td>
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
