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

  <!-- Vuejs CDN -->
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

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

            <div class="col-md-6 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 table-responsive" style="margin-top: 3%">
                      <table class="table">
                        <tr>
                          <td>Worship Place</td>
                          <td>:</td>
                          <td>
                            <select class="form-control" name="" onchange="changeSessionMosque(this.value)">
                              <?php foreach ($mosque as $key): ?>
                                <option <?= $key->id == $_SESSION['user']->worship_place_id ? 'selected' : '' ?> value="<?= $key->id ?>"><?= $key->name ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Stewardship Period</td>
                          <td>:</td>
                          <td>
                            <?= $m->period ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Type of Work</td>
                          <td>:</td>
                          <td><?= $m->name ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align: top">Account Bank</td>
                          <td style="vertical-align: top">:</td>
                          <td>
                            <ul>
                              <?php
                                $account = $GLOBALS['pdo']->prepare("SELECT * FROM bank_account
                                                                     INNER JOIN bank ON bank_account.bank_code=bank.bank_code
                                                                     WHERE bank_account.worship_place_id=:id");
                                $account->execute(['id' => $_SESSION['user']->worship_place_id]);
                                $accounts = $account->fetchAll(PDO::FETCH_OBJ);
                              ?>
                              <?php if ($accounts): ?>
                                <?php foreach ($accounts as $a): ?>
                                  <li><?= $a->bank_name ?> (<?= $a->rekening_number ?>)</li>
                                <?php endforeach; ?>
                              <?php else: ?>
                                <b>No Bank Account Yet!</b>
                              <?php endif; ?>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                          <td style="vertical-align: top">Stewardships</td>
                          <td style="vertical-align: top">:</td>
                          <td>
                            <ul>
                              <?php
                                $stewards = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship INNER JOIN jamaah ON
                                                                    jamaah.id=stewardship.jamaah_id
                                                                    WHERE jamaah.worship_place_id=:worship_id
                                                                    AND stewardship.account_status='true'");
                                $stewards->execute(['worship_id' => $worship_id]);
                                $stewards = $stewards->fetchAll(PDO::FETCH_OBJ);
                              ?>
                              <?php if ($stewards): ?>
                                <?php foreach ($stewards as $a): ?>
                                  <li><?= $a->name ?> (<?= $a->period ?>)</li>
                                <?php endforeach; ?>
                              <?php else: ?>
                                <b>There are no other accounts yet!</b>
                              <?php endif; ?>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#edit" class="form-control btn btn-sm btn-success">Edit</a>
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
                                      <input type="hidden" name="period_hidden" value="<?= $m->period ?>">
                                      <label>Type of Work</label>
                                      <select class="form-control" name="type">
                                        <?php
                                          $type = $GLOBALS['pdo']->prepare("SELECT * FROM type_of_work");
                                          $type->execute();
                                          $type = $type->fetchAll(PDO::FETCH_OBJ);
                                        ?>
                                        <?php foreach ($type as $t): ?>
                                          <?php if ($m->type_of_work_id == $t->id): ?>
                                            <option value="<?= $t->id ?>"><?= $t->name ?></option>
                                          <?php endif; ?>
                                        <?php endforeach; ?>

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
                            <a href="#" data-toggle="modal" data-target="#add"
                            class="form-control btn btn-sm btn-danger" style="">Update Bank Account</a>
                            <!-- Modal Avatar -->
                            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="avatar" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form action="<?php $this->url('stewardship/account/store?stewardship='. $_SESSION['user']->id.'&period='. $m->period) ?>" method="post">

                                  <?php $this->csrf_field() ?>

                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="avatar">Update Bank Account</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <?php
                                        $banks = $GLOBALS['pdo']->prepare("SELECT * FROM bank");
                                        $banks->execute();
                                        $banks = $banks->fetchAll(PDO::FETCH_OBJ);
                                      ?>
                                      <select class="form-control" name="bank">
                                        <?php foreach ($banks as $bank): ?>
                                          <option value="<?= $bank->bank_code ?>"><?= $bank->bank_name ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                      <input type="text" name="account_number" class="form-control" placeholder="No Rek " required>
                                      <div class="card" style="margin-top:2%;padding-top:2%;padding:5%">
                                        <?php if ($accounts): ?>
                                          <?php $no = 1; ?>
                                          <?php foreach ($accounts as $a): ?>
                                            <div class="row">
                                              <div class="col-md-10">
                                                <?= $no.'. '. $a->bank_name ?> (<?= $a->rekening_number ?>)
                                              </div>
                                              <div class="col-md-2">
                                                <h6> <a onclick="confirm('<?php $this->url('stewardship/account/destroy?rek='. $a->rekening_number) ?>')" href="#" > <i class="mdi mdi-delete text-danger"></i> </a> </h6>
                                              </div>
                                            </div>
                                            <?php $no++ ?>
                                          <?php endforeach; ?>
                                        <?php else: ?>
                                          <b>No Bank Account Yet!</b>
                                        <?php endif; ?>
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
            <div class="col-md-6">
              <img src="<?php $this->url('images/mosque/'. $gallery) ?>" class="img-responsive" width="500px">
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

    function changeSessionMosque(id) {
      axios.post('/stewardship/dashboard/changeMosque?id='+id).then(response => {
        location.reload();
      })
    }
  </script>

</body>

</html>
