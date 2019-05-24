<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Required meta tags -->
  <?php $this->include('partials/_header'); ?>
  <script src="<?php $this->url('script/vendors/js/vendor.bundle.base.js'); ?>"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
  <!-- end of required meta tags -->

  <!-- Cuztome css here -->
  <?php $this->include('style/_global'); ?>
  <?php $this->include('style/_profile') ?>
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

          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
              </span>
              Account
            </h3>
          </div>

          <div class="row">

            <?php if (!empty($this->flash())): ?>
              <br><div class="alert alert-success form-control">
                <?php $this->flash('print') ?>
              </div>
            <?php endif; ?>

            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-primary card-img-holder text-white">
                <div class="card-body">
                  <img src="<?php $this->url('images/circle.svg') ?>" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-bold mb-3">
                    Total Jamaah
                  </h4>
                  <h4 class="text-right">
                    <?php
                      $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM jamaah WHERE worship_place_id=:id");
                      $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                      echo $c = $stmt->fetch()['count'] . ' account';
                    ?>
                  </h4><br>
                  <h4 class="font-weight-bold mb-3">
                    Waiting Donation Status
                  </h4>
                  <h4 class="text-right">
                    <?php
                      $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM cash_in WHERE worship_place_id=:id AND confirmation='false'");
                      $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                      echo $h = $stmt->fetch()['count'] . ' transaction';
                    ?>
                  </h4><br>
                  <h4 class="font-weight-bold mb-3">
                    Waiting Qurban Status
                  </h4>
                  <h4 class="text-right">
                    <?php
                      $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM detail_qurban WHERE worship_place_id=:id AND confirmation='false'");
                      $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
                      echo $h = $stmt->fetch()['count'] . ' transaction';
                    ?>
                  </h4>
                </div>
              </div>
            </div>

            <div class="col-md-8 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 table-responsive" style="margin-top: 3%">
                      <table class="table">
                        <tr>
                          <td>Type of Work</td>
                          <td>:</td>
                          <td><?= $m->name ?></td>
                        </tr>
                        <tr>
                          <td>WhatsApp</td>
                          <td>:</td>
                          <td><?= $m->whatsapp ?></td>
                        </tr>
                        <tr>
                          <td>KTP</td>
                          <td>:</td>
                          <td><?= $m->identity_number ?></td>
                        </tr>
                        <tr>
                          <td>Stewardship at</td>
                          <td>:</td>
                          <td><?= $_SESSION['user']->name ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align: top">Account Bank</td>
                          <td style="vertical-align: top">:</td>
                          <td>
                            <ul>
                              <?php
                                $account = $GLOBALS['pdo']->prepare("SELECT * FROM account WHERE stewardship_id=:stewardship_id");
                                $account->execute(['stewardship_id' => $_SESSION['user']->jamaah_id]);
                                $account = $account->fetchAll(PDO::FETCH_OBJ);
                              ?>
                              <?php foreach ($account as $a): ?>
                                <li><?= $a->bank ?> (<?= $a->account_number ?>) a/n <?= $a->owner ?></li>
                              <?php endforeach; ?>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#edit" class="btn btn-sm btn-success">Edit</a>
                            <!-- Modal Avatar -->
                            <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="<?php $this->url('stewardship/account/update') ?>" method="post">

                                  <?php $this->csrf_field() ?>

                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="avatar">Edit</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <input type="text" class="form-control" name="whatsapp" value="<?= $m->whatsapp ?>">
                                      <select class="form-control" name="type">
                                        <?php
                                          $type = $GLOBALS['pdo']->prepare("SELECT * FROM type_of_work");
                                          $type->execute();
                                          $type = $type->fetchAll(PDO::FETCH_OBJ);
                                        ?>
                                        <?php foreach ($type as $t): ?>
                                          <option value="<?= $t->id ?>"><?= $t->name ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <!-- End Modal -->
                            <a href="#" data-toggle="modal" data-target="#add" class="btn btn-sm btn-danger">Add Bank Account</a>
                            <!-- Modal Avatar -->
                            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="<?php $this->url('stewardship/account/store') ?>" method="post">

                                  <?php $this->csrf_field() ?>

                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="avatar">Edit Account</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <?php
                                        $account = $GLOBALS['pdo']->prepare("SELECT * FROM account WHERE stewardship_id=:stewardship_id");
                                        $account->execute(['stewardship_id' => $_SESSION['user']->jamaah_id]);
                                        $account = $account->fetchAll(PDO::FETCH_OBJ);
                                      ?>
                                      <input type="text" name="bank" class="form-control" placeholder="Bank" required>
                                      <input type="text" name="owner" class="form-control" placeholder="Owner" required>
                                      <input type="text" name="account_number" class="form-control" placeholder="No Rek " required>
                                      <div class="card" style="margin-top:2%;padding-top:2%;padding:5%">
                                        <?php $no = 1; ?>
                                        <?php foreach ($account as $a): ?>
                                          <div class="row">
                                            <div class="col-md-10">
                                              <?= $no.'. '. $a->bank ?> (<?= $a->account_number ?>) a/n <?= $a->owner ?>
                                            </div>
                                            <div class="col-md-2">
                                              <h6> <a onclick="confirm('<?php $this->url('stewardship/account/destroy?id='. $a->id) ?>')" href="#" > <i class="mdi mdi-delete text-danger"></i> </a> </h6>
                                            </div>
                                          </div>
                                          <?php $no++ ?>
                                        <?php endforeach; ?>
                                      </div>
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
                          </td>
                        </tr>
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
  <!-- Custom js for this page-->
  <script type="text/javascript">
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
    });
  </script>

  <style media="screen">#nprogress .bar {background: #6cbd78cc;}</style>
  <script type="text/javascript">
    function loading() {
      NProgress.configure({ easing: 'ease', speed: 3000 });
      NProgress.configure({ showSpinner: false });
      NProgress.configure({ minimum: 0.1 });
      NProgress.start();
      NProgress.done();
      // setTimeout(function(){ NProgress.done(); }, 1000);
    }
  </script>

</body>

</html>