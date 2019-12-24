<?php

class QurbanController extends Controller{

  // __________________________________________ GUEST __________________________________________
  public function index()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT wp.id, wp.name, qurban.year FROM qurban
                                      INNER JOIN worship_place as wp ON wp.id = qurban.worship_place_id
                                      WHERE qurban.deadline_payment > now()");
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

      $stmt = $GLOBALS['pdo']->prepare("SELECT DISTINCT group_name FROM qurban_detail WHERE worship_place_id=:id AND year=:y ORDER BY group_name");
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
    $paymentStatus = 'false';

    // save name participant
    if ($_POST['participant_name'] == "") {
      $_POST['participant_name'] = $_SESSION['user']->jamaah_name;
    }
    // end save name participant

    // is animal leave in mosque?
    if ($_POST['animal'] != "") {
      $paymentStatus = 'true';
      if ($_POST['animal'] != "goat") {
        if ($_POST['total_qurban'] > 1) {
          $this->flash('Please input 1 animal for cow in 1 group. If you have more than 1 cow, please input it one by one.');
          return $this->redirect('qurban/detail?id='. $_GET['id'].'&mosque='.$_GET['mosque']. '&year='. $_GET['year']);
        }else{
          $_POST['total_qurban'] = 7;
        }
      }
    }
    // end checking

    // is group total > 7 in database
    $stmt = $GLOBALS['pdo']->prepare("SELECT SUM(total_qurban) FROM qurban_detail WHERE worship_place_id=:id AND year=:y AND group_name=:grup");
    $stmt->execute(['id'=> $worship_id, 'y' => $_POST['year'], 'grup' => $_POST['group_name']]);
    $group = $stmt->fetch(PDO::FETCH_OBJ);

    if ($group->sum >= 7) {
      $this->flash('Group full! Please choose another group.');
      return $this->redirect('qurban/detail?id='. $_GET['id'].'&mosque='.$_GET['mosque']. '&year='. $_GET['year']);
    }

    if ($group->sum + $_POST['total_qurban'] > 7) {
      $this->flash('Group full! Please choose another group.');
      return $this->redirect('qurban/detail?id='. $_GET['id'].'&mosque='.$_GET['mosque']. '&year='. $_GET['year']);
    }
    // end checking

    // Get last id from db
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_participant ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $id = $stmt->fetch(PDO::FETCH_OBJ);
    $id = (int)ltrim($id->id, 'P') + 1;
    $nextId = 'P'.$id;
    // End get last id

    // insert data to qurban_participant
    $stmt = $GLOBALS['pdo']->prepare('INSERT INTO qurban_participant(id, name, jamaah_id) VALUES(:id, :name, :jamaah_id)');
    $stmt->execute(['id' => $nextId, 'name' => $_POST['participant_name'], 'jamaah_id' => $_SESSION['user']->id]);
    // end insert data

    // insert data to qurban_detail
    $stmt = $GLOBALS['pdo']->prepare('INSERT INTO qurban_detail(worship_place_id, year, participant_id, total_qurban,
                                      group_name, datetime, payment_completed, animal, description)
                                      VALUES(:worship, :year, :participant, :total, :group, now(), :payment, :animal,
                                      :description)');
    $stmt->execute(['worship' => $worship_id,
                    'year' => $_POST['year'],
                    'participant' => $nextId,
                    'total' => $_POST['total_qurban'],
                    'group' => $_POST['group_name'],
                    'payment' => $paymentStatus,
                    'animal' => $_POST['animal'],
                    'description' => $_POST['account']
                  ]);
    $lastTrxId = $GLOBALS['pdo']->lastInsertId();
    // end insert data

    return $this->redirect('jamaah/qurban/checking?id='. $this->encrypt($lastTrxId));
  }

  public function checkQurban()
  {
    $this->authJamaah();
    $id = $this->decrypt($_GET['id']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT qurban.animal_price, qurban_detail.* FROM qurban_detail
                                      INNER JOIN QURBAN ON qurban_detail.worship_place_id = qurban.worship_place_id
                                      AND qurban_detail.year = qurban.year
                                      WHERE qurban_detail.id=:id");
    $stmt->execute(['id' => $id]);
    $qurban = $stmt->fetch(PDO::FETCH_OBJ);
    $qurban->total_fund = $qurban->animal_price * $qurban->total_qurban;

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

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_payment WHERE transaction_id=:id");
    $stmt->execute(['id' => $id]);
    $payment = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('jamaah/qurban_confirm', [ 'account' => $account, 'qurban' => $qurban, 'payment' => $payment ]);
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

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO qurban(worship_place_id, year, animal_price, deadline_payment, description)
                                      VALUES(:worship, :year, :price, :deadline, :description)");
    $stmt->execute(['worship'=> $_SESSION['user']->worship_place_id, 'year' => date('Y'), 'price' => $_POST['animal_price'],
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
    $stmt = $GLOBALS['pdo']->prepare("SELECT qurban_detail.*, worship_place.name as mosque, qurban_participant.name, qurban.animal_price
                                      FROM qurban_detail INNER JOIN qurban ON qurban.worship_place_id=qurban_detail.worship_place_id
                                      AND qurban.year=qurban_detail.year
                                      INNER JOIN worship_place ON qurban_detail.worship_place_id = worship_place.id
                                      INNER JOIN qurban_participant ON qurban_participant.id=qurban_detail.participant_id
                                      WHERE qurban_detail.worship_place_id = :id ORDER BY qurban_detail.datetime DESC");
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

    $stmt = $GLOBALS['pdo']->prepare('INSERT INTO qurban_payment(transaction_id, datetime, fund, status_confirmed, description)
                                      VALUES(:trx, now(), :fund, :status, :description)');
    $stmt->execute(['trx' => $_POST['transaction_id'], 'fund' => $_POST['fund'], 'status' => 'true', 'description' => $_POST['description']]);

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
    $stmt = $GLOBALS['pdo']->prepare("SELECT DISTINCT group_name FROM qurban_detail WHERE worship_place_id=:id AND year=:y ORDER BY group_name");
    $stmt->execute(['id'=> $_GET['worship'], 'y' => $_GET['year']]);
    $group = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/qurban_group', ['group' => $group]);
  }

  public function changeGroupAnimalStewardship()
  {
    $this->authStewardship();

    $stmt = $GLOBALS['pdo']->prepare('SELECT SUM(total_qurban) FROM qurban_detail WHERE group_name=:g AND worship_place_id=:id AND year=:year');
    $stmt->execute(['g' => $_POST['group_name'], 'id' => $_GET['worship'], 'year' => $_GET['year']]);
    $total = $stmt->fetch(PDO::FETCH_OBJ);

    if ($total->sum >= 7) {
      $this->flash('Group is full ! Please choose another grup.');
      return $this->redirect('stewardship/qurb/group?worship='. $_GET['worship'] .'&year='. $_GET['year']);
    }else{
      $stmt = $GLOBALS['pdo']->prepare('SELECT total_qurban FROM qurban_detail WHERE id=:id');
      $stmt->execute(['id' => $_POST['id']]);
      $current = $stmt->fetch(PDO::FETCH_OBJ);
      
      if ($total->sum + $current->total_qurban > 7) {
        $this->flash('Group is full ! Please choose another grup.');
        return $this->redirect('stewardship/qurb/group?worship='. $_GET['worship'] .'&year='. $_GET['year']);
      }
    }

    $stmt = $GLOBALS['pdo']->prepare('UPDATE qurban_detail SET group_name=:g WHERE id=:id');
    $stmt->execute(['g' => $_POST['group_name'], 'id' => $_POST['id']]);

    $this->flash('User successfully moved to group '. $_POST['group_name'] .'!');
    return $this->redirect('stewardship/qurb/group?worship='. $_GET['worship'] .'&year='. $_GET['year']);
  }

}
