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
              Project
            </h3>

            <a href="#" data-toggle="modal" data-target="#add_project" class="btn btn-gradient-danger btn-sm">+ Add Project</a>
            <!-- Modal Avatar -->
            <div class="modal fade" id="add_project" role="dialog" aria-labelledby="avatar" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="<?php $this->url('stewardship/donation/project/store') ?>" method="post" enctype="multipart/form-data">

                  <?php $this->csrf_field() ?>

                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="avatar">New Project</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="text" name="name" class="form-control" placeholder="Nama Project">
                      <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
                      <input type="text" placeholder="Fund Needed" name="fund" class="form-control" id="rupiah"><br>

                      <h6> <small>Description</small> </h6>
                      <textarea name="description" rows="4" placeholder="Description Project" cols="20" class="form-control"></textarea><br>
                      <script>CKEDITOR.replace( 'description' );</script>

                      <h6> <small>Multiple Image</small> </h6>
                      <input type="file" name="gallery[]" multiple class="form-control">
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
                      <table class="table" id="data"  style="text-align:center !important">
                        <thead>
                          <tr>
                            <th style="align:center">No</th>
                            <th>Name</th>
                            <th>Fund Needed</th>
                            <th>Fund Collected</th>
                            <th>Gallery</th>
                            <th>Detail</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (isset($project)): ?>
                            <?php $no=1; ?>
                            <?php foreach ($project as $value): ?>
                              <tr>
                                <td><?= $no ?></td>
                                <td> <?= $value['name']  ?> </td>
                                <td> Rp <?= number_format(($value['fund']),0,',','.') ?> </td>
                                <td> belum dibuat </td>
                                <td> <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT count(*) FROM project_gallery WHERE project_id=:project_id");
                                  $stmt->execute(['project_id' => $value['id']]);
                                  echo $stmt->fetch()['count'] . ' image';
                                 ?> </td>
                                <td>
                                  <?php $e = $this->encrypt($value['id']) ?>
                                  <a onclick="window.open('<?= $this->url('donation/detail?project='. $e) ?>', '_blank');" href="#" class="btn btn-sm btn-success">Show</a>
                                </td>
                                <td>
                                  <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#progress<?= $value['id'] ?>">+ Add Progress</a>
                                  <!-- Modal Avatar -->
                                  <div class="modal fade" id="progress<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <form action="<?php $this->url('stewardship/donation/project/progress?id='. $value['id']) ?>" method="post" enctype="multipart/form-data">

                                        <?php $this->csrf_field() ?>

                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="avatar">Update Progress</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <textarea name="progress" rows="4" placeholder="Progress Project" cols="40" class="form-control"> <?= $value['progress'] ?> </textarea>
                                            <script>CKEDITOR.replace( 'progress' );</script><br>

                                            <h6 style="text-align:left !important"> <small>Photo Progress</small> </h6>
                                            <input type="file" name="gallery[]" multiple class="form-control">
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Update</button>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                  <!-- End Modal -->
                                </td>
                              </tr>
                              <?php $no++ ?>
                            <?php endforeach; ?>
                          <?php endif; ?>
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
    });
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
