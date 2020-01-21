<?php

class QurbanController extends Controller{

  // __________________________________________ GUEST __________________________________________
  public function index()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban INNER JOIN worship_place ON worship_place.id=qurban.worship_place_id");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('guest/qurban', ['qurban' => $r]);
  }

  public function show()
  {
    if(isset($_GET['id'])){

      $id = $this->decrypt($_GET['id']);

      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban WHERE worship_place_id=:id AND year=:y");
      $stmt->execute(['id'=> $id, 'y' => $_GET['year']]);
      $r = $stmt->fetch(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*
                                        FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                        AND account.stewardship_period = stewardship.period
                                        INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                        WHERE jamaah.worship_place_id=:id AND stewardship.period LIKE :d");
      $stmt->execute(['id' => $id, 'd' => '%'.date('Y').'%']);
      $account = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT DISTINCT group_name, animal FROM qurban_group
                                        WHERE worship_place_id=:id AND year=:y ORDER BY group_name");
      $stmt->execute(['id'=> $id, 'y' => $_GET['year']]);
      $group = $stmt->fetchAll(PDO::FETCH_OBJ);

      return $this->view('guest/qurban_detail', ['qurban' => $r, 'account' => $account, 'group' => $group]);

    }else{
      return $this->view('error/404');
    }
  }

  // __________________________________________ JAMAAH __________________________________________

  public function store()
  {
    $this->authJamaah();
    $this->check_csrf($_POST);
    $worship_id = $this->decrypt($_GET['id']);

    // check group available
    $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(group_name) as available FROM qurban_detail
                                      WHERE worship_place_id=:id AND year=:year AND group_name=:grup");
    $stmt->execute(['id' => $worship_id, 'year' => $_POST['year'], 'grup' => $_POST['group_name']]);
    $avai = $stmt->fetch(PDO::FETCH_OBJ);
    if ($avai->available == 0) {
      $available = 7;
    }
    // end check group available

    // -------------------------------- Checking total cannot bigger tahn available
    if ($_POST['total_qurban'] > $available) {
      $this->flash('Group full ! Max 7, Please choose another group..');
      return $this->redirect('qurban/detail?id='. $_GET['id'].'&mosque='.$_GET['mosque']. '&year='. $_GET['year']);
    }
    // end checking

    // Get serial numbers
    $stmt = $GLOBALS['pdo']->prepare("SELECT serial_number FROM qurban_detail WHERE worship_place_id=:id
                                      AND year=:year AND group_name=:grup ORDER BY serial_number DESC");
    $stmt->execute(['id' => $worship_id, 'year' => $_POST['year'], 'grup' => $_POST['group_name']]);
    $serial = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$serial)
        $nextSerial = 1;
    else
        $nextSerial = $serial->serial_number + 1;

    // End get serial number

    // insert to qurban_order
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO qurban_order(jamaah_id, total_slot, uang_muka, uang_pelunasan,
                                      datetime, description, payment_completed)
                                      VALUES(:id, :total, 0, 0, now(), :des, 'false')");
    $stmt->execute(['id' => $_SESSION['user']->id, 'total' => $_POST['total_qurban'], 'des' => $_POST['account']]);
    // end insert qurban_order

    // Get last data
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_order ORDER BY datetime DESC");
    $stmt->execute();
    $lastInput = $stmt->fetch(PDO::FETCH_OBJ);
    // end get data

    // insert data to qurban_detail
    for ($i=0; $i < $_POST['total_qurban']; $i++) {

      $stmt = $GLOBALS['pdo']->prepare('INSERT INTO qurban_detail(worship_place_id, year, group_name, jamaah_id, serial_number, datetime)
                                        VALUES(:worship, :year, :group, :participant, :serial_number, :datetimes)');
      $stmt->execute(['worship' => $worship_id,
                      'year' => $_POST['year'],
                      'group' => $_POST['group_name'],
                      'participant' => $_SESSION['user']->id,
                      'serial_number' => $nextSerial,
                      'datetimes' => $lastInput->datetime
                    ]);

      $nextSerial++;
    }

    return $this->redirect('jamaah/qurban/checking?datetime='. $this->encrypt($lastInput->datetime));
  }

  public function checkQurban()
  {
    $this->authJamaah();

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_order WHERE datetime=:datetimes");
    $stmt->execute(['datetimes' => $this->decrypt($_GET['datetime'])]);
    $qurban = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_detail INNER JOIN qurban_group
                                      ON qurban_detail.worship_place_id=qurban_group.worship_place_id
                                      AND qurban_detail.year=qurban_group.year
                                      AND qurban_detail.group_name=qurban_group.group_name
                                      WHERE datetime=:datetimes");
    $stmt->execute(['datetimes' => $this->decrypt($_GET['datetime'])]);
    $detail = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT animal FROM qurban_detail INNER JOIN qurban_group
                                      ON qurban_detail.worship_place_id=qurban_group.worship_place_id
                                      AND qurban_detail.year=qurban_group.year
                                      AND qurban_detail.group_name=qurban_group.group_name
                                      WHERE datetime=:datetimes");
    $stmt->execute(['datetimes' => $this->decrypt($_GET['datetime'])]);
    $animal = $stmt->fetch(PDO::FETCH_OBJ);

    $desc = explode('~', $qurban->description);
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, stewardship.whatsapp, account.*, worship_place.name as mosque
                                      FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                      AND account.stewardship_period = stewardship.period
                                      INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                      INNER JOIN worship_place ON jamaah.worship_place_id = worship_place.id
                                      WHERE account.stewardship_id=:id AND account.account_number=:account
                                      AND account.stewardship_period=:period");
    $stmt->execute(['id' => $desc[1], 'account' => $desc[0], 'period' => $desc[2]]);
    $account = $stmt->fetch(PDO::FETCH_OBJ);

    return $this->view('jamaah/qurban_confirm', [ 'account' => $account, 'qurban' => $qurban, 'detail' => $detail, 'animal' => $animal]);
  }

  // __________________________________________ STEWARDSHIP __________________________________________
  public function animalStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban WHERE worship_place_id=:id ORDER BY year DESC");
    $stmt->execute(['id'=> $_SESSION['user']->worship_place_id]);
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/qurban', ['qurban' => $r]);
  }

  public function storeAnimalStewardship()
  {
    $this->authStewardship();

    $_POST['animal_price'] = substr($_POST['animal_price'], 4);
    $_POST['animal_price'] = str_replace(".", "", $_POST['animal_price']);

    $date = new DateTime($_POST['deadline_payment']);
    $_POST['deadline_payment'] = $date->format('Y-m-d');
    $year = $date->format('Y');

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO qurban(worship_place_id, year, animal_price, deadline_payment, description)
                                      VALUES(:worship, :year, :price, :deadline, :description)");
    $stmt->execute(['worship'=> $_SESSION['user']->worship_place_id, 'year' => $year, 'price' => $_POST['animal_price'],
                    'deadline' => $_POST['deadline_payment'], 'description' => $_POST['description']]);

    if($stmt->fetch(PDO::FETCH_OBJ))
      $this->flash('New Qurban Type has been added!');
    else
      $this->flash('Duplicate Data!');

    return $this->redirect('stewardship/qurban');
  }

  public function destroyAnimalStewardship()
  {
    $this->authStewardship();

    $stmt = $GLOBALS['pdo']->prepare('DELETE FROM qurban WHERE worship_place_id=:id AND year=:year');
    $stmt->execute(['id'=> $_GET['worship'], 'year' => $_GET['year']]);

    $this->flash('Destroy Qurban Data Success!');
    return $this->redirect('stewardship/qurban');
  }

  public function transactionStewardship()
  {
    $this->authStewardship();
    $this->authJamaah();
    $stmt = $GLOBALS['pdo']->prepare("SELECT qurban_order.*, worship_place.name, jamaah.name as jamaah_name, worship_place.id
                                      as worship_id, qurban_group.animal, qurban.animal_price FROM qurban_order
                                      INNER JOIN qurban_detail ON qurban_detail.jamaah_id=qurban_order.jamaah_id
                                      AND qurban_detail.datetime=qurban_order.datetime
                                      INNER JOIN worship_place ON worship_place.id=qurban_detail.worship_place_id
                                      INNER JOIN qurban_group ON qurban_group.year=qurban_detail.year
                                      AND qurban_group.worship_place_id=qurban_detail.worship_place_id
                                      AND qurban_group.group_name=qurban_detail.group_name
                                      INNER JOIN qurban ON qurban_group.year=qurban.year
                                      AND qurban_group.worship_place_id=qurban.worship_place_id
                                      INNER JOIN jamaah ON qurban_order.jamaah_id=jamaah.id
                                      WHERE jamaah.worship_place_id = :id ORDER BY qurban_order.datetime");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/qurban_transaction', ['trans' => $data]);
  }

  public function confirmTransactionStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    if ($_POST['unpaid'] < $_POST['fund']) {
      $this->flash('Too much payment!');
      return $this->redirect('stewardship/qur/detail');
    }

    $stmt = $GLOBALS['pdo']->prepare('INSERT INTO qurban_payment(worship_place_id, year, group_name, serial_number, datetime, fund, status_confirmed, description)
                                      VALUES(:worship, :year, :grup, :serial_number, now(), :fund, :status, :description)');
    $stmt->execute(['worship' => $_POST['worship'],
                    'year' => $_POST['year'],
                    'group_name' => $_POST['group'],
                    'serial_number' => $_POST['serial'],
                    'fund' => $_POST['fund'],
                    'status' => 'true',
                    'description' => $_POST['description']]);

    $this->flash('Confirmation Success!');
    return $this->redirect('stewardship/qur/detail');
  }

  public function closeTransactionStewardship()
  {
    $this->authStewardship();

    $stmt = $GLOBALS['pdo']->prepare('DELETE FROM qurban_detail WHERE id=:trx');
    $stmt->execute(['trx' => $_GET['id']]);

    $this->flash('Cancel Transaction Success!');
    return $this->redirect('stewardship/qur/detail');
  }

  public function indexGroupAnimalStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT group_name FROM qurban_group WHERE worship_place_id=:id AND year=:y ORDER BY group_name");
    $stmt->execute(['id'=> $_GET['worship'], 'y' => $_GET['year']]);
    $group = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/qurban_group', ['groups' => $group]);
  }

  public function changeGroupAnimalStewardship()
  {
    $this->authStewardship();

    $stmt = $GLOBALS['pdo']->prepare('SELECT COUNT(serial_number) FROM qurban_detail WHERE group_name=:g AND worship_place_id=:id AND year=:year');
    $stmt->execute(['g' => $_POST['group_name'], 'id' => $_GET['worship'], 'year' => $_GET['year']]);
    $total = $stmt->fetch(PDO::FETCH_OBJ);

    $id = explode('~', $_POST['id']);

    if ($total->count > 0) {

      $stmt = $GLOBALS['pdo']->prepare("SELECT serial_number FROM qurban_detail WHERE worship_place_id=:id
                                        AND year=:year AND group_name=:grup ORDER BY serial_number DESC");
      $stmt->execute(['id' => $_GET['worship'], 'year' => $_GET['year'], 'grup' => $_POST['group_name']]);
      $serial = $stmt->fetch(PDO::FETCH_OBJ);

      if ($serial) {
        $serial = $serial->serial_number+1;
      }else{
        $serial = 1;
      }

      if ($total->count >= 7) {
        $this->flash('Group is full ! Please choose another grup.');
        return $this->redirect('stewardship/qurb/group?worship='. $_GET['worship'] .'&year='. $_GET['year']);
      }
    }else{
      $serial = 1;
    }

    $stmt = $GLOBALS['pdo']->prepare('UPDATE qurban_detail SET group_name=:g, serial_number=:s WHERE worship_place_id=:id
                                      AND year=:year AND group_name=:grup AND serial_number=:serials');
    $stmt->execute(['g' => $_POST['group_name'], 's' => $serial, 'id' => $_GET['worship'], 'year' => $_GET['year'],
                    'grup' => $id[1], 'serials' => $id[0]]);

    $this->flash('User successfully moved to group '. $_POST['group_name'] .'!');
    return $this->redirect('stewardship/qurb/group?worship='. $_GET['worship'] .'&year='. $_GET['year']);
  }

}
