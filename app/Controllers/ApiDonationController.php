<?php

class ApiDonationController extends Controller
{

  function __construct()
  {
    header('content-type: application/json; charset=utf8');
	  header("access-control-allow-origin: *");
  }

  public function index()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT project.*, worship_place.name as worship FROM project INNER JOIN worship_place ON project.worship_place_id = worship_place.id ORDER BY project.id DESC");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Variable to check
    foreach ($r as $key) {
        $str = $key->description;
        $newstr = filter_var($str, FILTER_SANITIZE_STRING);
        $key->description = $newstr;

        $str = $key->progress;
        $newstr = filter_var($str, FILTER_SANITIZE_STRING);
        $key->progress = $newstr;

        $n = 'Rp '. number_format(($key->fund),0,',','.');
        $key->fund = $n;

        $stmt = $GLOBALS['pdo']->prepare("SELECT SUM(fund) as total FROM cash_in WHERE project_id=:id AND confirmation = 'true'");
        $stmt->execute(['id' => $key->id]);
        $collected = $stmt->fetch(PDO::FETCH_OBJ);

        $key->fund_collected = 'Rp '. number_format(($collected->total),0,',','.');
    }
    echo json_encode($r);
  }

  public function show(){
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $stmt = $GLOBALS['pdo']->prepare("SELECT project.*, worship_place.id as worship_id,
                                        worship_place.name as worship FROM project INNER JOIN
                                        worship_place ON project.worship_place_id = worship_place.id
                                        WHERE project.id=:project_id");
      $stmt->execute(['project_id' => $id]);
      $result = $stmt->fetch(PDO::FETCH_OBJ);

      // Filter data project
      $str = $result->description;
      $newstr = filter_var($str, FILTER_SANITIZE_STRING);
      $result->description = $newstr;

      $str = $result->progress;
      $newstr = filter_var($str, FILTER_SANITIZE_STRING);
      $result->progress = $newstr;

      $n = 'Rp '. number_format(($result->fund),0,',','.');
      $result->fund = $n;
      // End filter data project

      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp FROM stewardship
                                        INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                        WHERE jamaah.worship_place_id = :id");
      $stmt->execute(['id' => $result->worship_id]);
      $stewardship = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*
                                        FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                        INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                        WHERE jamaah.worship_place_id=:id");
      $stmt->execute(['id' => $result->worship_id]);
      $account = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT cash_in.public, cash_in.fund, jamaah.username FROM cash_in INNER JOIN jamaah ON
                                        cash_in.jamaah_id = jamaah.id WHERE cash_in.status_in='transfer jamaah'
                                        AND cash_in.status_out='project' AND cash_in.project_id=:id AND
                                        cash_in.confirmation=true");
      $stmt->execute(['id' => $id]);
      $donatur = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT SUM(fund) as total FROM cash_in WHERE project_id=:id AND confirmation = 'true'");
      $stmt->execute(['id' => $id]);
      $collected = $stmt->fetch(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM project_gallery WHERE project_id=:id");
      $stmt->execute(['id' => $result->id]);
      $gallery = $stmt->fetchAll(PDO::FETCH_OBJ);;

      $result->fund_collected = 'Rp '. number_format(($collected->total),0,',','.');
      $finally = array('project' => $result, 'account' => $account, 'gallery' => $gallery);

      echo json_encode($finally);
      
    }else{
      $result = ['status' => 'data not found'];
      echo json_encode($result);
    }
  }

  public function store()
  {
    if (isset($_POST['id'])) {
      if (isset($_POST['fund'])) {
        if(isset($_POST['account'])){

          $id = $_POST['id'];
          $stmt = $GLOBALS['pdo']->prepare("SELECT worship_place.name as mosque, worship_place.id as worship_id
                                            FROM project INNER JOIN
                                            worship_place ON project.worship_place_id = worship_place.id
                                            WHERE project.id=:project_id");
          $stmt->execute(['project_id' => $id]);
          $result = $stmt->fetch(PDO::FETCH_OBJ);

          if (isset($_POST['public'])) {
            $_POST['public'] = 'true';
          }else{
            $_POST['public'] = 'false';
          }

          $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id, project_id, jamaah_id, fund,
                                            status_in, status_out, datetime, confirmation, public)
                                            VALUES(:worship, :project, :jamaah, :fund, :_in, :_out, now(), 'false', :public)");
          $stmt->execute(['worship' => $result->worship_id,
                          'project' => $id,
                          'jamaah' => $_POST['jamaah_id'],
                          'fund' => $_POST['fund'],
                          '_in' => 'transfer jamaah',
                          '_out' => 'project',
                          'public' => $_POST['public']
                        ]);

          $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*
                                            FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                            INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                            WHERE account.id=:id");
          $stmt->execute(['id' => $_POST['account']]);
          $account = $stmt->fetch(PDO::FETCH_OBJ);

          $lastId = $GLOBALS['pdo']->lastInsertId();

          $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM cash_in WHERE id=:id");
          $stmt->execute(['id' => $lastId]);
          $cash = $stmt->fetch(PDO::FETCH_OBJ);

          $finally['result'] = 'Donation Success!';
          $finally['mosque'] = $result->mosque;
          $finally['donation'] = 'Mosque Construction';
          $finally['stewardship'] = $account->username;
          $finally['bank_account'] = $account->account_number;
          $finally['total'] = 'Rp '. number_format(($_POST['fund']),0,',','.');
          $finally['status'] = 'waiting';
          $finally['no_invoice'] = $lastId;

          $date = new DateTime($cash->datetime);

          $finally['date'] = $date->format('l, j F Y');
          $finally['whatsapp'] = $account->whatsapp;

          echo json_encode($finally);

        }else{
          $result = ['status' => 'account bank not available'];
          echo json_encode($result);
        }
      }else{
        $result = ['status' => 'you have to input total donation'];
        echo json_encode($result);
      }
    }else{
      $result = ['status' => 'data not found'];
      echo json_encode($result);
    }
  }

  // ---------------------------------------------- For Orphans, TPA/MDA, Poor ------------------------------------------------------------

  public function listMosque()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place");
    $stmt->execute();
    $collected = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($collected);
  }

  public function detailMosqueForDonation()
  {
    if(isset($_GET['id'])){

      $id = $_GET['id'];

      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place WHERE id = :id");
      $stmt->execute(['id' => $id]);
      $m = $stmt->fetch(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp FROM stewardship
                                        INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                        WHERE jamaah.worship_place_id = :id");
      $stmt->execute(['id' => $id]);
      $stewardship = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*
                                        FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                        INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                        WHERE jamaah.worship_place_id=:id");
      $stmt->execute(['id' => $id]);
      $account = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT cash_in.public, cash_in.fund, jamaah.username FROM cash_in INNER JOIN jamaah ON
                                        cash_in.jamaah_id = jamaah.id WHERE cash_in.status_in='transfer jamaah'
                                        AND cash_in.status_out='orphanage' AND cash_in.confirmation=true AND cash_in.worship_place_id=:id");
      $stmt->execute(['id' => $id]);
      $donatur = $stmt->fetchAll(PDO::FETCH_OBJ);

      $result = array('mosque' => $m,
                      'stewardship' => $stewardship,
                      'account' => $account,
                      'donatur' => $donatur);

      echo json_encode($result);

    }else{
      $result = ['status' => 'data not found'];
      echo json_encode($result);
    }
  }

  public function storeOrphan()
  {
    if (isset($_GET['id'])) {

      $id = $_GET['id'];

      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id, jamaah_id, fund,
                                        status_in, status_out, datetime, description, confirmation, public)
                                        VALUES(:worship, :jamaah, :fund, :_in, :_out, now(), :dsc, 'false', :public)");
      $stmt->execute(['worship' => $id,
                      'jamaah' => $_POST['jamaah'],
                      'fund' => $_POST['fund'],
                      '_in' => 'transfer jamaah',
                      '_out' => 'orphanage',
                      'dsc' => $_POST['account'],
                      'public' => $_POST['public']
                    ]);

      $result = ['status' => 'store data success', 'trx' => $GLOBALS['pdo']->lastInsertId()];
      echo json_encode($result);

    }else{
      $result = ['status' => 'error store data'];
      echo json_encode($result);
    }
  }

  public function storePoor()
  {
    if (isset($_GET['id'])) {

      $id = $_GET['id'];

      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id, jamaah_id, fund,
                                        status_in, status_out, datetime, description, confirmation, public)
                                        VALUES(:worship, :jamaah, :fund, :_in, :_out, now(), :dsc, 'false', :public)");
      $stmt->execute(['worship' => $id,
                      'jamaah' => $_POST['jamaah'],
                      'fund' => $_POST['fund'],
                      '_in' => 'transfer jamaah',
                      '_out' => 'poor',
                      'dsc' => $_POST['account'],
                      'public' => $_POST['public']
                    ]);

      $result = ['status' => 'store data success', 'trx' => $GLOBALS['pdo']->lastInsertId()];
      echo json_encode($result);

    }else{
      $result = ['status' => 'error store data'];
      echo json_encode($result);
    }
  }

  public function storeTpa()
  {
    if (isset($_GET['id'])) {

      $id = $_GET['id'];

      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id, jamaah_id, fund,
                                        status_in, status_out, datetime, description, confirmation, public)
                                        VALUES(:worship, :jamaah, :fund, :_in, :_out, now(), :dsc, 'false', :public)");
      $stmt->execute(['worship' => $id,
                      'jamaah' => $_POST['jamaah'],
                      'fund' => $_POST['fund'],
                      '_in' => 'transfer jamaah',
                      '_out' => 'tpa',
                      'dsc' => $_POST['account'],
                      'public' => $_POST['public']
                    ]);

      $result = ['status' => 'store data success', 'trx' => $GLOBALS['pdo']->lastInsertId()];
      echo json_encode($result);

    }else{
      $result = ['status' => 'error store data'];
      echo json_encode($result);
    }
  }

  public function history()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT cash_in.*, worship_place.name FROM cash_in
                                      INNER JOIN worship_place ON cash_in.worship_place_id = worship_place.id
                                      WHERE jamaah_id=:jamaah_id ORDER BY datetime DESC");
    $stmt->execute(['jamaah_id' => $_GET['id']]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($data as $key){
        $key->fund = 'Rp '. number_format(($key->fund),0,',','.');
        if ($key->status_out == "project") {
          $key->donation_name = 'Infaq Mosque Development';
        }elseif ($key->status_out == "tpa") {
          $key->donation_name = 'Infaq TPA/MDA';
        }elseif ($key->status_out == "orphanage") {
          $key->donation_name = 'Infaq Orphans';
        }elseif ($key->status_out == "poor") {
          $key->donation_name = 'Infaq Poor';
        }
        $date = new DateTime($key->datetime);
        $key->datetime = $date->format('j F Y, g:i a');
    }

    echo json_encode($data);
  }

  public function historyDetail()
  {
    $id = $_GET['id'];

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM cash_in WHERE id=:id");
    $stmt->execute(['id' => $id]);
    $cash = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*, worship_place.name as mosque
                                      FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                      INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                      INNER JOIN worship_place ON jamaah.worship_place_id = worship_place.id
                                      WHERE account.id=:id");
    $stmt->execute(['id' => $cash->description]);
    $account = $stmt->fetch(PDO::FETCH_OBJ);

    $result = array('mosque' => $account->mosque, 'account' => $account, 'donation' => 'Rp '. number_format(($cash->fund),0,',','.'));

    echo json_encode($result);
  }

}
