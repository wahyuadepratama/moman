<?php

class ApiQurbanController extends Controller
{

  function __construct()
  {
    header('content-type: application/json; charset=utf8');
	  header("access-control-allow-origin: *");
  }

  function index()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban INNER JOIN worship_place
                                      ON worship_place.id=qurban.worship_place_id");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($r as $key) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT q.animal_price, q.deadline_payment, q.year
                                        FROM qurban AS q WHERE worship_place_id=:id
                                        AND q.year=:y");
      $stmt->execute(['id'=>$key->id, 'y' => date('Y')]);
      $t = $stmt->fetchAll(PDO::FETCH_OBJ);
      $key->animal_type = $t;
    }

    echo json_encode($r);
  }

  function show()
  {
    if (isset($_GET['id'])) {

      $id = $_GET['id'];
      $stmt = $GLOBALS['pdo']->prepare("SELECT w.name, w.id FROM worship_place AS w WHERE id=:id");
      $stmt->execute(['id' => $id]);
      $r = $stmt->fetch(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM mosque_qurban AS q WHERE worship_place_id=:id AND q.year=:y");
      $stmt->execute(['id'=>$id, 'y' => date('Y')]);
      $t = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*
                                        FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                        INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                        WHERE jamaah.worship_place_id=:id");
      $stmt->execute(['id' => $id]);
      $account = $stmt->fetchAll(PDO::FETCH_OBJ);

      foreach ($t as $key)
        $key->animal_price = 'Rp '. number_format(($key->animal_price),0,',','.');

      $r->animal_type = $t;
      $r->account = $account;

      echo json_encode($r);

    }else{
      $result = ['status' => 'error get data'];
      echo json_encode($result);
    }
  }

  public function confirmationQurban()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT detail_qurban.*, worship_place.name, jamaah.username FROM detail_qurban
                                      INNER JOIN worship_place ON detail_qurban.worship_place_id = worship_place.id
                                      INNER JOIN jamaah ON detail_qurban.jamaah_id = jamaah.id
                                      WHERE worship_place.id=:worship_id ORDER BY confirmation ASC");
    $stmt->execute(['worship_id' => $_GET['id']]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($data as $key) {
      $key->id = $key->datetime;
      $date = new DateTime($key->datetime);
      $key->datetime = $date->format('j F Y, g:i a');
      $key->fund = 'Rp '. number_format(($key->fund),0,',','.');
    }

    echo json_encode($data);
  }

  public function detailConfirmationQurban()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_qurban WHERE datetime=:id");
    $stmt->execute(['id' => $_GET['id']]);
    $q = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM participant WHERE grup=:grup AND year=:year AND worship_place_id=:id");
    $stmt->execute(['grup' => $q->grup, 'year' => $q->year, 'id' => $q->worship_place_id]);
    $part = $stmt->fetchAll(PDO::FETCH_OBJ);

    $date = new DateTime($q->datetime);
    $q->datetime = $date->format('j F Y, g:i a');
    $q->fund = 'Rp '. number_format(($q->fund),0,',','.');

    $data = array('info' => $q, 'participant' => $part);
    echo json_encode($data);
  }

  public function storeConfirmationQurban()
  {
    if (isset($_GET['id'])) {
      $stmt = $GLOBALS['pdo']->prepare("UPDATE detail_qurban SET description=:des, confirmation='true' WHERE datetime=:id");
      $stmt->execute(['des' => 'Pembayaran qurban berhasil!', 'id' => $_GET['id']]);

      $result = ['status' => 'confirmation success'];
      echo json_encode($result);

    }else {
      $result = ['status' => 'error store data'];
      echo json_encode($result);
    }
  }
}
