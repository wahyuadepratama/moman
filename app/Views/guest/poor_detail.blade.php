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
              Donation Orphans
            </h3>
          </div>

          <div class="">
            <div class="row">
              <div class="col-md-12">
                <div class="card bg-gradient-white card-img-holder text-grey form-control" style="padding:3%">
                  <p class="text-right" style="font-size:150%">
                    قَالَ « اللَّهُمَّ أَحْيِنِى مِسْكِينًا وَأَمِتْنِى مِسْكِينًا وَاحْشُرْنِى فِى زُمْرَةِ الْمَسَاكِينِ يَوْمَ الْقِيَامَةِ ». فَقَالَتْ عَائِشَةُ لِمَ يَا رَسُولَ اللَّهِ قَالَ « إِنَّهُمْ يَدْخُلُونَ الْجَنَّةَ قَبْلَ أَغْنِيَائِهِمْ بِأَرْبَعِينَ خَرِيفًا يَا عَائِشَةُ لاَ تَرُدِّى الْمِسْكِينَ وَلَوْ بِشِقِّ تَمْرَةٍ يَا عَائِشَةُ أَحِبِّى الْمَسَاكِينَ وَقَرِّبِيهِمْ فَإِنَّ اللَّهَ يُقَرِّبُكِ يَوْمَ الْقِيَامَةِ »
                  </p>
                  <p class="text-left">
                    "Ya Allah, live me in a poor state, turn me off in poor condition and gather me together with the poor on the Day of Judgment". Aisyah said, "Why Rasulullah, do you ask for that?" "These poor people entered heaven 40 years before the rich people. Aisyah, do not reject the poor even with one date palm. Aisyah, love the poor and close to them because Allah will be close to You on the Day of Judgment ", replied the Rasulullah sallallaahu‘ alaihi wa sallam (Narrated by Tirmidzi no. 2352. Syaikh Al Albani says this hadits is shahih)<br><br>
                    “Ya Allah, hidupkanlah aku dalam keadaan miskin, matikanlah aku dalam keadaan miskin dan kumpulkanlah aku bersama dengan orang-orang miskin pada hari kiamat”. ‘Aisyah berkata, “Mengapa –wahai Rasulullah- engkau meminta demikian?” “Orang-orang miskin itu masuk ke dalam surga 40 tahun sebelum orang-orang kaya. Wahai ‘Aisyah, janganlah engkau menolak orang miskin walau dengan sebelah kurma. Wahai ‘Aisyah, cintailah orang miskin dan dekatlah dengan mereka karena Allah akan dekat dengan-Mu pada hari kiamat”, jawab Rasul shallallahu ‘alaihi wa sallam (HR. Tirmidzi no. 2352. Syaikh Al Albani mengatakan bahwa hadits ini shahih)
                  </p>
                </div>
              </div>
              <div class="col-md-7" style="margin: 2%">
                <div class="row">
                   <div class="card bg-gradient-white card-img-holder text-grey form-control" style="padding: 2% !important;">
                    <div class="card-body" style="padding: 5% !important">

                      <h6 class="text-left">Mosque/Mushalla: </h6>
                      <p class="text-right"><?= $mosque->name ?></p>

                      <h6 class="text-left">Stewardship Mosque: </h6>
                      <?php foreach ($steward as $w): ?>
                        <p class="text-right"> <i class="mdi mdi-whatsapp"></i> <?= $w->username ?> <b>(<?= $w->phone ?>)</b> </p>
                      <?php endforeach; ?><br>

                      <div class="">

                        <?php if (isset($_SESSION['jamaah'])): ?>
                          <?php if ($_SESSION['jamaah'] === true): ?>

                            <form action="<?php $this->url('poor/detail/store?id='. $this->encrypt($mosque->id)) ?>" method="post">
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
                </div>
              </div>
              <div class="col-md-4" style="margin: 2%">
                <div class="row">
                  <div class="card bg-gradient-white card-img-holder text-grey form-control" style="padding: 2% !important;">
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
