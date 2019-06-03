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
              Confirmation From Jamaah
            </h3>

            <a href="#" data-toggle="modal" data-target="#add_project" class="btn btn-gradient-danger btn-sm">+ Add Donation</a>
            <!-- Modal Avatar -->
            <div class="modal fade" id="add_project" role="dialog" aria-labelledby="avatar" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="<?php $this->url('stewardship/donation/transaction/store') ?>" method="post" enctype="multipart/form-data">

                  <?php $this->csrf_field() ?>

                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="avatar">New Infaq</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <h6> <small>Select Donation Type</small> </h6>
                      <select class="form-control" name="type" style="color:black" onchange="changes(this.value)">
                        <option value="event">Donation from Event</option>
                        <option value="infaq box">Donation from Infaq Box</option>
                        <option value="project">Donation for Mosque Construction</option>
                        <option value="poor">Donation for Poor</option>
                        <option value="orphanage">Donation for Orphans</option>
                        <option value="tpa">Donation for TPA/MDA</option>
                      </select>

                      <script type="text/javascript">
                        function changes(v) {
                          if (v == 'project') {
                            var z = document.getElementById("projectOption");
                            z.style.display = "block";
                          }else{
                            var z = document.getElementById("projectOption");
                            z.style.display = "none";
                          }
                        }
                      </script>

                      <div id="projectOption" style="margin-top:2%;margin-bottom:2%;display:none">
                        <select class="js-example-basic-single form-control" name="project_id" style="color:black">
                          <?php
                            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM project WHERE worship_place_id=:id");
                            $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                            $b = $stmt->fetchAll(PDO::FETCH_OBJ);
                          ?>
                          <?php foreach ($b as $k): ?>
                            <option value="<?= $k->id ?>"><?= $k->name ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <br><h6> <small>Write Description (optional)</small> </h6>
                      <input type="text" name="name" class="form-control" placeholder="Description (optional)">

                      <br><h6> <small>Fund</small> </h6>
                      <input type="text" placeholder="Fund" name="fund" class="form-control" id="rupiah" required><br>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Add</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- End Modal -->

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
                            <th>Trx</th>
                            <th>Datetime</th>
                            <th>Donation</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody style="text-align:center">
                          <?php foreach ($trans as $h): ?>
                            <tr>
                              <td>#<?= $h->id ?></td>
                              <td>
                                <?php
                                  $date = new DateTime($h->datetime);
                                  echo $date->format('l, j F Y, g:i a');
                                ?>
                              </td>
                              <td>
                                <?php if ($h->status_out == 'project'): ?>
                                  Mosque Construction
                                <?php elseif ($h->status_out == 'tpa'): ?>
                                  Infaq TPA
                                <?php elseif ($h->status_out == 'orphanage'): ?>
                                  Infaq Orphanage
                                <?php elseif ($h->status_out == 'poor'): ?>
                                  Infaq Poor
                                <?php elseif ($h->status_out == 'event'): ?>
                                  From Event
                                <?php endif; ?>
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
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#invoice<?= $h->id ?>"> <i class="mdi mdi-crop-free"></i> </a>
                                <!-- Modal Avatar -->
                                <div class="modal fade" id="invoice<?= $h->id ?>" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <form method="post" action="<?php $this->url('stewardship/donation/transaction/confirm?id='. $h->id) ?>">
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
                                              <td>Donatur</td>
                                              <td>:</td>
                                              <td><?= $h->username ?></td>
                                            </tr>
                                            <tr>
                                              <td>Contact</td>
                                              <td>:</td>
                                              <td><?= $h->phone ?></td>
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
        "pageLength" : "300",
        "dom": '<"clear"f><"clear">',
        "language": {
            "lengthMenu": '_MENU_ ',
                "search": '',
                "searchPlaceholder": "search"
        }
    });
    } );

  </script>
  <script type="text/javascript">

		var rupiah = document.getElementById('rupiah');
		rupiah.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
			rupiah.value = formatRupiah(this.value, 'Rp. ');
		});

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

    rupiah.addEventListener('keyup', function(e){
      rupiah.value = formatRupiah(this.value, 'Rp. ');
    });
	</script>
  <script src="<?php $this->url('script/js/dashboard.js') ?>"></script>
  <!-- End custom js for this page-->
</body>

</html>
