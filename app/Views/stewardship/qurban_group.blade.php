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
            <a href="#" data-toggle="modal" data-target="#add_event" class="btn btn-gradient-danger btn-sm">+ Add Group</a>
            <!-- Modal Avatar -->
            <div class="modal fade" id="add_event" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <form action="<?php $this->url('stewardship/qurb/group/add') ?>" method="post">

                  <?php $this->csrf_field() ?>

                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="avatar">New Qurban <?= date('Y') ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <label>Group Name</label>
                      <input type="text" class="form-control" name="group" placeholder="Example: 02" maxlength="2">
                      <label>Group Name</label>
                      <select class="form-control" name="animal_type">
                        <option value="Goat">Goat</option>
                        <option value="Cow">Cow</option>
                      </select>
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
                      <div class="col-md-12 table-responsive" id="qurban">
                        <table class="table resize-font">
                          <thead style="text-align:left">
                            <tr>
                              <th>Group</th>
                              <th>Animal</th>
                              <th>Participant</th>
                              <th>Slot Used</th>
                              <th>Slot Available</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody style="text-align:left">
                            <?php foreach ($qurban as $key): ?>
                              <tr>
                                <?php
                                  $stmt = $GLOBALS['pdo']->prepare("SELECT dq.*, j.username
                                                                    FROM detail_qurban as dq INNER JOIN jamaah as j ON dq.jamaah_id = j.id
                                                                    WHERE dq.worship_place_id=:id AND dq.year=:y AND dq.group=:g");
                                  $stmt->execute(['id'=> $key->worship_place_id, 'y' => $key->year, 'g' => $key->group]);
                                  $r = $stmt->fetchAll(PDO::FETCH_OBJ);
                                  // $this->die($r);
                                  $slot = 0;
                                  $participant = 0;
                                ?>
                                <td><?= $key->group ?></td>
                                <td><?= $key->animal_type ?></td>
                                <td>
                                  <?php foreach ($r as $val): ?>
                                    <?php
                                      $slot += $val->total_slot;
                                      $participant++;
                                    ?>
                                    <li>
                                      <?= $val->username ?>
                                      <select class="float-right" name="" onchange="moveTo(this.value)">
                                          <option value="<?= $val->group ?>">==== Select Group ===</option>
                                        <?php foreach ($qurban as $q): ?>

                                            <?php
                                              $stmt = $GLOBALS['pdo']->prepare("SELECT dq.*, j.username
                                                                                FROM detail_qurban as dq INNER JOIN jamaah as j ON dq.jamaah_id = j.id
                                                                                WHERE dq.worship_place_id=:id AND dq.year=:y AND dq.group=:g");
                                              $stmt->execute(['id'=> $q->worship_place_id, 'y' => $q->year, 'g' => $q->group]);
                                              $s = $stmt->fetchAll(PDO::FETCH_OBJ);
                                              $countSlot = 0;
                                              foreach ($s as $forMove) {
                                                $countSlot += $forMove->total_slot;
                                              }
                                            ?>

                                          <?php if ($q->animal_type == $key->animal_type && $q->max_person - $countSlot != 0): ?>
                                            <option value="<?= $q->group ?>~<?= $this->encrypt($val->datetime) ?>">Move to group <?= $q->group ?></option>
                                          <?php endif; ?>
                                        <?php endforeach; ?>
                                      </select>
                                    </li>
                                  <?php endforeach; ?>
                                </td>
                                <td>
                                  <?php foreach ($r as $val): ?>
                                    <?= $val->total_slot ?> Slot<br>
                                  <?php endforeach; ?>
                                </td>
                                <td>
                                  <?= $key->max_person - $slot ?>
                                </td>
                                <td>
                                  <?php if ($participant > 0): ?>
                                    ~
                                  <?php else: ?>
                                    <a href="#" onclick="confirm('<?php $this->url('stewardship/qurb/group/destroy?y='. $key->year. '&w=' . $key->worship_place_id . '&g=' . $key->group) ?>')" class="btn btn-sm btn-danger"> <i class="mdi mdi-delete"></i> </a>
                                  <?php endif; ?>
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

    function moveTo(val){
      window.location = "<?= $this->url('stewardship/qurb/group/change?par=') ?>"+val;
    }
  </script>
  <script src="<?php $this->url('script/js/dashboard.js') ?>"></script>
  <!-- End custom js for this page-->
</body>

</html>
