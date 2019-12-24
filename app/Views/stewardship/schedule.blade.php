<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <script src="<?php $this->url('script/vendors/js/vendor.bundle.base.js'); ?>"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
  <?php $this->include('style/_global'); ?>

</head>
<body>
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
              Schedule
            </h3>
            <a href="#" data-toggle="modal" data-target="#add_schedule" class="btn btn-gradient-danger btn-sm">+ Add Schedule Data</a>
            <!-- Modal Avatar -->
            <div class="modal fade" id="add_schedule">
              <div class="modal-dialog" role="document">
                <form action="<?php $this->url('stewardship/mosque/schedule/store') ?>" method="post">

                  <?php $this->csrf_field() ?>

                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="avatar">New Schedule Data</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body col-md-12">

                      <label>Ustad / Pengisi Acara</label>
                      <select class="js-example-basic-single form-control" name="ustad">
                        <?php foreach ($ustad as $u): ?>
                          <option value="<?= $u->id ?>"><?= $u->name   ?></option>
                        <?php endforeach; ?>
                      </select>
                      <div style="margin:5%"></div>

                      <label>Event</label>
                      <select class="js-example-basic-single form-control" name="event">
                        <?php foreach ($event as $e): ?>
                          <option value="<?= $e->id ?>"><?= $e->name ?></option>
                        <?php endforeach; ?>
                      </select>

                      <div style="margin:5%"></div>
                      <script type="text/javascript">
                        // In your Javascript (external .js resource or <script> tag)
                        $(document).ready(function() {
                          $('.js-example-basic-single').select2({
                        		width: '100%'
                          });
                        });
                      </script>
                      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
                      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
                      <input name="schedule" id="datepicker" class="form-control"/>
                      <script>
                          $('#datepicker').datepicker({
                              uiLibrary: 'materialdesign',
                              iconsLibrary: 'materialicons'
                          });
                      </script>

                      <div style="margin:5%"></div>
                      <input type="time" name="time" class="form-control">
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
                            <th>Event</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Ustad</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody style="text-align:center">
                          <?php foreach ($sch as $p): ?>
                            <tr>
                              <td><?= $p->name ?></td>
                              <td>
                                <?php
                                  $date = new DateTime($p->date);
                                  echo $date->format('j F Y');
                                ?>
                              </td>
                              <td><?= $p->time ?></td>
                              <td><?= $p->ustad ?></td>
                              <td>
                                <?php
                                  $date = new DateTime($p->date);
                                  $now = new DateTime();
                                ?>
                                <?php if ($date < $now): ?>
                                  <b class="text-danger">Past</b>
                                <?php else: ?>
                                  <b class="text-success">On Going</b>
                                <?php endif; ?>
                              </td>
                              <td>
                                <a href="#" onclick="confirm('<?php $this->url('stewardship/mosque/schedule/destroy?id='. $p->worship_place_id .'&date='. $p->date . '&time='. $p->time) ?>')"
                                  class="btn btn-sm btn-danger"> <i class="mdi mdi-delete"></i> </a>
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

  <script src="<?php $this->url('script/vendors/js/vendor.bundle.addons.js'); ?>"></script>
  <script src="<?php $this->url('script/js/off-canvas.js'); ?>"></script>
  <script src="<?php $this->url('script/js/misc.js'); ?>"></script>

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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script type="text/javascript">
    function confirm(url){
      Swal.fire({
        title: 'Are you sure?',
        type: 'warning',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          window.location = url;
        }
      })
    }
  </script>
  <!-- End custom js for this page-->
</body>

</html>
