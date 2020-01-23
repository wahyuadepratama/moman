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
              Qurban Information
            </h3>
            <a href="#" data-toggle="modal" data-target="#add_event" class="btn btn-gradient-danger btn-sm">+ Add Qurban</a>
            <!-- Modal Avatar -->
            <div class="modal fade" id="add_event" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="<?php $this->url('stewardship/qurban/store') ?>" method="post">

                  <?php $this->csrf_field() ?>

                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="avatar">New Qurban</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <label>Deadline Payment</label>
                      <input name="deadline_payment" id="datepicker" class="form-control" required/><br>
                      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
                      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
                      <script>
                          $('#datepicker').datepicker({
                              uiLibrary: 'materialdesign',
                              iconsLibrary: 'materialicons'
                          });
                      </script>

                      <label>Animal Price (Goat)</label>
                      <input type="text" name="animal_price" class="form-control" placeholder="Price" id="rupiah" required><br>

                      <label>Group Available</label>
                      <input type="number" name="group_max" value="" placeholder="Ex: 10" class="form-control" required><br>

                      <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
                      <label>Description</label>
                      <textarea name="description" rows="2" placeholder="Description Project" cols="10" class="form-control">
                      </textarea><br>
                      <script>CKEDITOR.replace( 'description' );</script>

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
                      <?php foreach ($qurban as $p): ?>
                      <table class="table">
                            <tr>
                              <td colspan="3">
                                <b class="float-left">Qurban in <?= $p->year ?></b>

                                <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_detail WHERE worship_place_id=:id AND year=:year LIMIT 1");
                                  $stmt->execute(['id'=> $p->worship_place_id, 'year' => $p->year]);
                                  $r = $stmt->fetch(PDO::FETCH_OBJ);
                                ?>

                                <?php if (!$r): ?>
                                  <b class="float-right">
                                    <a href="<?php $this->url('/stewardship/qurban/destroy?worship='.$p->worship_place_id.'&year='.$p->year) ?>"
                                      class="btn btn-sm btn-danger">Delete</a>
                                  </b>
                                <?php else: ?>
                                  <b class="float-right">
                                    <a href="<?php $this->url('stewardship/qurb/group?worship='.$p->worship_place_id.'&year='.$p->year) ?>"
                                      class="btn btn-sm btn-primary">Manage Group</a>
                                  </b>
                                <?php endif; ?>

                              </td>
                            </tr>
                            <tr>
                              <td>Animal Price</td>
                              <td>:</td>
                              <td>Rp <?= number_format(($p->animal_price),0,',','.') ?></td>
                            </tr>
                            <tr>
                              <td>Deadline Payment</td>
                              <td>:</td>
                              <td>
                                <?php
                                  $date = new DateTime($p->deadline_payment);
                                  echo $date->format('j F Y');
                                ?>
                              </td>
                            </tr>
                            <tr>
                              <td>Description</td>
                              <td>:</td>
                              <td><?= $p->description ?></td>
                            </tr>
                      </table><hr><br><br><br>
                      <?php endforeach; ?>
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

    function printDiv(divName) {
         var printContents = document.getElementById(divName).innerHTML;
         var originalContents = document.body.innerHTML;
         document.body.innerHTML = printContents;
         window.print();
         document.body.innerHTML = originalContents;
    }
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
