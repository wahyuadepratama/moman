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
              Qurban Group
            </h3>

          </div>

          <div class="row">

            <?php foreach ($group as $key): ?>

              <?php
                $stmt = $GLOBALS['pdo']->prepare("SELECT qurban_detail.*, qurban_detail.id as id_trx, qurban_participant.*
                                                  FROM qurban_detail INNER JOIN qurban_participant ON
                                                  qurban_participant.id = qurban_detail.participant_id
                                                  WHERE worship_place_id=:id AND year=:y AND group_name=:grup ORDER BY datetime");
                $stmt->execute(['id'=> $_GET['worship'], 'y' => $_GET['year'], 'grup' => $key->group_name]);
                $group = $stmt->fetchAll(PDO::FETCH_OBJ);
              ?>

              <div class="col-md-3">
                <div class="card" style="width: 14rem; margin-bottom: 20px">
                  <div class="card-header">
                    Group <?= $key->group_name ?>
                  </div>
                  <ul class="list-group list-group-flush">
                    <?php foreach ($group as $value): ?>

                      <?php if ($value->total_qurban > 1): ?>
                        <?php
                          $btn = true;
                          for ($i=0; $i < $value->total_qurban; $i++) {
                            ?>
                              <li class="list-group-item">
                                <?= $value->name ?>
                                <?php if ($btn): ?>
                                  <button data-toggle="modal" onclick="change('<?= $value->id_trx ?>')" data-target="#add_poor" class="float-right btn btn-gradient-primary btn-sm">Change</button>
                                <?php endif; ?>
                              </li>
                            <?php
                            $btn = false;
                          }
                        ?>
                      <?php else: ?>
                        <li class="list-group-item">
                          <?= $value->name ?>
                          <button data-toggle="modal" onclick="change('<?= $value->id_trx ?>')" data-target="#add_poor" class="float-right btn btn-gradient-primary btn-sm">Change</button>
                        </li>
                      <?php endif; ?>

                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            <?php endforeach; ?>

          </div>

          <!-- Modal Avatar -->
          <div class="modal fade" id="add_poor" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form action="<?php $this->url('stewardship/qurb/group/change?worship='. $_GET['worship'] .'&year='. $_GET['year']) ?>" method="post">

                <?php $this->csrf_field() ?>

                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="avatar">Change Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <label>Select Group</label>
                    <select class="form-control" name="group_name" style="color: black">
                      <option value="01">01</option>
                      <option value="02">02</option>
                      <option value="03">03</option>
                      <option value="04">04</option>
                      <option value="05">05</option>
                      <option value="06">06</option>
                      <option value="07">07</option>
                      <option value="08">08</option>
                      <option value="09">09</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                    </select>

                    <input type="hidden" name="id" id="qurban_id">
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

    function change(val){
      $("#qurban_id").val(val);
    }
  </script>
  <script src="<?php $this->url('script/js/dashboard.js') ?>"></script>
  <!-- End custom js for this page-->
</body>

</html>
