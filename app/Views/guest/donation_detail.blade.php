<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Script for maps -->

  <!-- end of script -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <?php $this->include('style/_profile'); ?>
  <!-- end custome -->

</head>
<body onload="loading()">
  <div class="container-scroller">

    <!-- partial:partials/_navbar.html -->
    <?php $this->include('partials/_navbar'); ?>
    <!-- partial -->

    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
      <!-- $this->include('partials/_sidebar') -->
      <!-- partial -->

      <div class=""><!-- <div class="main-panel"> -->
        <div class="content-wrapper">

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              <?= $project->name ?>
            </h3>
          </div>

          <div class="">
            <div class="row">
              <div class="col-md-7">
                <div id="2" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner slide style=" style="width:100%  !important;">

                    <?php
                      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM project_gallery WHERE project_id=:id"); $stmt->execute(['id' => $project->id]);
                      $data = $stmt->fetchAll(PDO::FETCH_OBJ); $s=1;
                    ?>

                    <?php $t = 2000; ?>
                    <?php foreach ($data as $k): ?>
                      <?php if ($s == 1): ?>
                        <div class="carousel-item active imgfix" style="height: 375px">
                          <img class="w-100 load-delay<?= $k->id ?>" src="<?php $this->url('images/load.gif'); $s=2; ?>" data-original="<?php $this->url('images/project/'. $k->image); ?>">
                        </div>
                      <?php else: ?>
                        <div class="carousel-item imgfix" style="height: 375px">
                          <img class="w-100 load-delay<?= $k->id ?>" src="<?php $this->url('images/load.gif'); $s=2; ?>" data-original="<?php $this->url('images/project/'. $k->image); ?>">
                        </div>
                      <?php endif; ?>

                      <script type="text/javascript">
                        $(document).ready(function () {
                        setTimeout(function () {
                          $('.load-delay<?= $k->id ?>').each(function () { var imagex = $(this); var imgOriginal = imagex.data('original'); $(imagex).attr('src', imgOriginal); }); }, <?= $t ?>);
                        });
                      </script>
                      <?php $t = $t + 2000; ?>

                    <?php endforeach; ?>

                  </div>
                  <a class="carousel-control-prev" href="#2" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#2" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>


                 <div class="card bg-gradient-white card-img-holder text-grey form-control" style="margin-top: 5%;padding: 2% !important;">
                  <div class="card-body" style="padding: 5% !important">
                    <!-- <img src="<?php $this->url('images/circle.svg') ?>" class="card-img-absolute" alt="circle-image"> -->
                    <h4 class="font-weight-bold mb-3">
                      <i class="mdi mdi-check-circle text-success mdi-24px float-right"></i> <?= $project->name ?>
                    </h4><br>
                    <h6 class="text-left">Fund Needed:</h6>
                    <p class="text-right">Rp <?= number_format(($project->fund),0,',','.') ?></p>

                    <h6 class="text-left">Fund Collected: </h6>
                    <p class="text-right">Rp <?= number_format(($project->collected),0,',','.') ?></p>

                    <h6 class="text-left">Mosque/Mushalla: </h6>
                    <p class="text-right"><?= $project->worship ?></p>

                    <h6 class="text-left">Stewardship Mosque: </h6>
                    <?php foreach ($steward as $w): ?>

                      <p class="text-right"> <i class="mdi mdi-whatsapp"></i> <?= $w->username ?> <b>(<?= $w->phone ?>)</b> </p>
                    <?php endforeach; ?><br>

                    <h6 class="text-left">Description: </h6>
                    <p class="text-left"><?= $project->description ?></p><br>

                    <h6 class="text-left">Progress: </h6>
                    <?php if (isset($project->progress)): ?>
                      <p class="text-left"><?= $project->progress ?></p>
                    <?php else: ?>
                      <p class="text-left"> <p>Belum ada progress</p> </p>
                    <?php endif; ?>
                  </div>
                </div>

              </div>
              <div class="col-md-5">

                <div class="card bg-gradient-white card-img-holder text-grey form-control" style="padding: 1% !important;">
                  <div class="card-body">
                    <div class="row">

                      <?php if (isset($_SESSION['jamaah'])): ?>
                        <?php if ($_SESSION['jamaah'] === true): ?>

                          <form action="<?php $this->url('donation/detail/store?project='. $this->encrypt($project->id)) ?>" method="post">
                            <?php $this->csrf_field() ?>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Total</label>
                                <input type="text" placeholder="Fund" name="fund" class="form-control" id="rupiah">
                              </div>
                              <div class="form-group">
                                <label for="exampleInputConfirmPassword1">Stewardship Account Bank</label>
                                <select class="form-control" name="account" style="color: black;">
                                  <?php foreach ($account as $ac): ?>
                                    <option value="<?= $ac->id ?>"><?= $ac->bank ?> a/n <?= $ac->owner ?> (<?= $ac->account_number ?>)</option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" value="public" name="public">Use your profile as a donatur
                                </label>
                              </div>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" value="private" name="public">Dont show donatur's name to public (write as Hamba Allah)
                                </label>
                              </div>
                              <input type="submit" name="" value="Donation" class="form-control btn btn-sm btn-gradient-success">
                            </div>
                          </form>

                        <?php endif; ?>
                      <?php else: ?>
                        <h6>Please Login to Donate. Login  <a href="<?php $this->url('login') ?>">Here</a> </h6>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <div class="card bg-gradient-white card-img-holder text-grey form-control" style="margin-top:5%;padding: 2% !important;">
                  <div class="card-body" style="padding: 10% !important">
                    <!-- <img src="<?php $this->url('images/circle.svg') ?>" class="card-img-absolute" alt="circle-image"> -->
                    <h4 class="font-weight-bold mb-3">
                      <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i> List Donatur
                    </h4><br>
                    <?php if (empty($donatur)): ?>
                      <p>Belum ada donatur.</p>
                    <?php endif; ?>
                    <?php foreach ($donatur as $dn): ?>
                      <?php if ($dn->public === true): ?>
                        <h6 class="text-left"><?= $dn->username ?>:</h6>
                      <?php else: ?>
                        <h6 class="text-left">Hamba Allah:</h6>
                      <?php endif; ?>
                      <h6 class="text-right">Rp <?= number_format(($dn->fund),0,',','.') ?></h6>
                    <?php endforeach; ?>
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
        dom: '<"clear"f><"clear">',
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
  <!-- End custom js for this page-->
</body>

</html>
