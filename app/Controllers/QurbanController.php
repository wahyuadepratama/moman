<?php

class QurbanController extends Controller{

  // __________________________________________ GUEST __________________________________________
  public function index()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $this->view('guest/qurban', ['qurban' => $r]);
  }

  public function show()
  {
    if(isset($_GET['id'])){

      $id = $this->decrypt($_GET['id']);

      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM mosque_qurban WHERE worship_place_id=:id AND year=:y");
      $stmt->execute(['id'=> $id, 'y' => date('Y')]);
      $r = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*
                                        FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                        INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                        WHERE jamaah.worship_place_id=:id");
      $stmt->execute(['id' => $id]);
      $account = $stmt->fetchAll(PDO::FETCH_OBJ);

      return $this->view('guest/qurban_detail', ['qurban' => $r, 'account' => $account]);

    }else{
      return $this->view('error/404');
    }
  }

  // __________________________________________ JAMAAH __________________________________________

  public function store()
  {
    $this->authJamaah();
    $this->check_csrf($_POST);

    $id = $this->decrypt($_GET['id']);

    $_POST['goat'] = array_filter($_POST['goat']);
    $_POST['cow'] = array_filter($_POST['cow']);
    $_POST['camel'] = array_filter($_POST['camel']);

    $_POST['price'] = substr($_POST['price'], 3);
    $_POST['price'] = str_replace(".", "", $_POST['price']);

    if ($_POST['goat'] != NULL)
      $data = $_POST['goat'];

    if ($_POST['cow'] != NULL)
      $data = $_POST['cow'];

    if ($_POST['camel'] != NULL)
      $data = $_POST['camel'];

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_qurban WHERE worship_place_id=:id ORDER BY datetime DESC");
    $stmt->execute(['id'=> $id]);
    $r = $stmt->fetch(PDO::FETCH_OBJ);

    if (empty($r))
      $r = 1;
    else
      $r = (int)$r->grup + 1;

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO detail_qurban(jamaah_id, animal_type, year, worship_place_id, datetime,
                                      fund, payment_method, description, confirmation, grup)
                                      VALUES(:jamaah_id, :animal_type, :year, :worship_place_id, now(), :fund, :payment,
                                      :description, :confirmation, :grup)");
    $stmt->execute([
                    'jamaah_id'=> $_SESSION['user']->jamaah_id,
                    'animal_type' => $_POST['type'],
                    'year' => date('Y'),
                    'worship_place_id' => $id,
                    'fund' => $_POST['price'],
                    'payment' => 'transfer',
                    'description' => $_POST['account'],
                    'confirmation' => 'false',
                    'grup' => $r
                  ]);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_qurban WHERE worship_place_id=:id ORDER BY datetime DESC");
    $stmt->execute(['id'=> $id]);
    $insert = $stmt->fetch(PDO::FETCH_OBJ);

    foreach ($data as $key) {
      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO participant(grup, name,year, worship_place_id) VALUES(:grup, :name, :year, :id)");
      $stmt->execute(['grup' => $r, 'name' => $key, 'year' => $insert->year, 'id' => $insert->worship_place_id]);
    }

    return $this->redirect('jamaah/qurban/checking?id='. $this->encrypt($insert->datetime));
  }

  public function checkQurban()
  {
    $this->authJamaah();
    $id = $this->decrypt($_GET['id']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_qurban WHERE datetime=:id");
    $stmt->execute(['id' => $id]);
    $q = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM participant WHERE grup=:grup AND year=:year AND worship_place_id=:id");
    $stmt->execute(['grup' => $q->grup, 'year' => $q->year, 'id' => $q->worship_place_id]);
    $part = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*, worship_place.name as mosque
                                      FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                      INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                      INNER JOIN worship_place ON jamaah.worship_place_id = worship_place.id
                                      WHERE account.id=:id");
    $stmt->execute(['id' => $q->description]);
    $account = $stmt->fetch(PDO::FETCH_OBJ);

    return $this->view('jamaah/qurban_confirm', ['mosque' => $account->mosque,
                                                  'account' => $account,
                                                  'donation' => $q->fund,
                                                  'animal' => $q->animal_type,
                                                  'part' => $part
                                                ]);
  }

  // __________________________________________ STEWARDSHIP __________________________________________
  public function animalStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM mosque_qurban WHERE worship_place_id=:id ORDER BY year");
    $stmt->execute(['id'=> $_SESSION['user']->worship_place_id]);
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/qurban', ['qurban' => $r]);
  }

  public function storeAnimalStewardship()
  {
    $this->authStewardship();

    $_POST['animal_price'] = substr($_POST['animal_price'], 4);
    $_POST['animal_price'] = str_replace(".", "", $_POST['animal_price']);

    $date = date('Y');

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO mosque_qurban(worship_place_id, year,animal_price, animal_type, max_person)
                                      VALUES(:wpi, :y, :ap, :at, :mp)");
    $stmt->execute(['wpi'=> $_SESSION['user']->worship_place_id, 'y' => $date, 'ap' => $_POST['animal_price'],
                    'at' => $_POST['animal_type'], 'mp' => $_POST['person']]);

    $this->flash('New Qurban Type has been added!');
    return $this->redirect('stewardship/qurban');
  }

  public function destroyAnimalStewardship()
  {
    $this->authStewardship();

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_qurban WHERE worship_place_id=:id AND year=:year AND animal_type=:at");
    $stmt->execute(['id'=> $_GET['w'], 'year' => $_GET['y'], 'at' => $_GET['a']]);
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($r)) {
      $this->flash('This qurban animal has bought by jamaah! You cannt delete it');
      return $this->redirect('stewardship/qurban');
    }

    $stmt = $GLOBALS['pdo']->prepare('DELETE FROM mosque_qurban WHERE worship_place_id=:id AND year=:year AND animal_type=:at');
    $stmt->execute(['id'=> $_GET['w'], 'year' => $_GET['y'], 'at' => $_GET['a']]);

    $this->flash('Destroy Account Success!');
    return $this->redirect('stewardship/qurban');
  }

  public function transactionStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT detail_qurban.*, worship_place.name, jamaah.username FROM detail_qurban
                                      INNER JOIN worship_place ON detail_qurban.worship_place_id = worship_place.id
                                      INNER JOIN jamaah ON detail_qurban.jamaah_id = jamaah.id
                                      WHERE worship_place.id=:worship_id ORDER BY confirmation ASC");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/qurban_transaction', ['trans' => $data]);
  }

  public function confirmTransactionStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    if (isset($_GET['id'])) {
      $stmt = $GLOBALS['pdo']->prepare("UPDATE detail_qurban SET description=:des, confirmation='true' WHERE datetime=:id");
      $stmt->execute(['des' => $_POST['description'], 'id' => $_GET['id']]);

      $this->flash('Confirmation Success!');
      return $this->redirect('stewardship/qur/detail');
    }else {
      return $this->redirect('stewardship/qur/detail');
    }
  }
}
