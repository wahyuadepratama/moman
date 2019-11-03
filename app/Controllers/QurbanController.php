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

      $stmt = $GLOBALS['pdo']->prepare("SELECT gq.*, mq.max_person FROM group_qurban as gq INNER JOIN
                                        mosque_qurban as mq ON gq.worship_place_id = mq.worship_place_id
                                        AND gq.year = mq.year AND gq.animal_type = mq.animal_type
                                        WHERE gq.worship_place_id=:id AND gq.year=:y ORDER BY gq.group ASC");
      $stmt->execute(['id'=> $id, 'y' => date('Y')]);
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

    // $var = '1~9012';
    // $res = substr($var, 0, 1);
    // $res = substr($var, 2, 8);

    $id             = $this->decrypt($_GET['id']);
    $_POST['price'] = substr($_POST['price'], 3);
    $_POST['price'] = str_replace(".", "", $_POST['price']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT dq.*, gq.animal_type FROM detail_qurban as dq INNER JOIN group_qurban as gq
                                      ON dq.year=gq.year AND dq.group=gq.group AND dq.worship_place_id=gq.worship_place_id
                                      WHERE dq.worship_place_id=:id AND dq.year=:year ORDER BY dq.group DESC");
    $stmt->execute(['id'=> $id, 'year'=> date('Y')]);
    $detailQurban = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT gq.*, mq.* FROM group_qurban as gq INNER JOIN mosque_qurban as mq ON
                                      gq.worship_place_id = mq.worship_place_id AND
                                      gq.year = mq.year AND gq.animal_type = mq.animal_type
                                      WHERE gq.worship_place_id=:id AND gq.year=:year AND gq.animal_type=:animal");
    $stmt->execute(['id'=> $id, 'year'=> date('Y'), 'animal' => $_POST['type']]);
    $groupQurban = $stmt->fetchAll(PDO::FETCH_OBJ);

    $inserted = false;
    foreach ($groupQurban as $group) {

      $total_slot = 0;

      foreach ($detailQurban as $detail) {
        if ($group->group == $detail->group) {
          $total_slot += $detail->total_slot;
        }
      }

      if ($total_slot + $_POST['total_slot'] <= $group->max_person && $inserted == false) {
        $stmt = $GLOBALS['pdo']->prepare('INSERT INTO public.detail_qurban("group", year, worship_place_id, jamaah_id, datetime, total_slot,
                                          fund, confirmation, payment_method) VALUES (:group, :year, :worship, :jamaah, now(), :slot,
                                          :fund, :confirm, :payment)');
        $stmt->execute(['group'=> $group->group, 'year'=> date('Y'), 'worship' => $id, 'jamaah' => $_SESSION['user']->jamaah_id,
                        'slot' => $_POST['total_slot'], 'fund' => $_POST['price'], 'confirm' => 'false', 'payment' => $_POST['payment'] .'~'. '0' .'~'. $_POST['account']]);
        $inserted = true;
      }
    }

    if ($inserted == false) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT dq.group FROM group_qurban as dq WHERE dq.worship_place_id=:id
                                        AND dq.year=:year ORDER BY dq.group DESC LIMIT 1");
      $stmt->execute(['id'=> $id, 'year'=> date('Y')]);
      $lastGroup = $stmt->fetch(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare('INSERT INTO public.group_qurban(animal_type, year, worship_place_id, status, "group")
                                        VALUES (:animal_type, :year, :id, :status, :group)');
      $stmt->execute(['animal_type' => $_POST['type'], 'year' => date('Y'), 'id' => $id, 'status' => 'true', 'group'=> sprintf("%02s", (int)$lastGroup->group+1)]);

      $stmt = $GLOBALS['pdo']->prepare('INSERT INTO public.detail_qurban("group", year, worship_place_id, jamaah_id, datetime, total_slot,
                                        fund, confirmation, payment_method) VALUES (:group, :year, :worship, :jamaah, now(), :slot,
                                        :fund, :confirm, :payment)');
      $stmt->execute(['group'=> sprintf("%02s", (int)$lastGroup->group+1), 'year'=> date('Y'), 'worship' => $id, 'jamaah' => $_SESSION['user']->jamaah_id,
                      'slot' => $_POST['total_slot'], 'fund' => $_POST['price'], 'confirm' => 'false', 'payment' => $_POST['payment'] .'~'. '0' .'~'. $_POST['account']]);
    }

    $stmt = $GLOBALS['pdo']->prepare("SELECT dq.* FROM detail_qurban as dq WHERE dq.worship_place_id=:id
                                      AND dq.year=:year AND dq.jamaah_id=:jamaah ORDER BY dq.datetime DESC LIMIT 1");
    $stmt->execute(['id'=> $id, 'year'=> date('Y'), 'jamaah' => $_SESSION['user']->jamaah_id]);
    $inserted = $stmt->fetch(PDO::FETCH_OBJ);

    return $this->redirect('jamaah/qurban/checking?id='. $this->encrypt($inserted->datetime));
  }

  public function checkQurban()
  {
    $this->authJamaah();
    $id = $this->decrypt($_GET['id']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT dq.*, gq.animal_type, mq.max_person, mq.animal_price FROM detail_qurban as dq
                                      INNER JOIN group_qurban as gq ON dq.group=gq.group AND dq.year=gq.year
                                      AND dq.worship_place_id=gq.worship_place_id INNER JOIN mosque_qurban as mq
                                      ON gq.animal_type=mq.animal_type AND gq.year=mq.year
                                      AND gq.worship_place_id=mq.worship_place_id WHERE dq.datetime=:id");
    $stmt->execute(['id' => $id]);
    $qurban = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, stewardship.whatsapp, account.*, worship_place.name as mosque
                                      FROM account INNER JOIN stewardship ON account.stewardship_id = stewardship.jamaah_id
                                      INNER JOIN jamaah ON stewardship.jamaah_id = jamaah.id
                                      INNER JOIN worship_place ON jamaah.worship_place_id = worship_place.id
                                      WHERE account.id=:id");
    $stmt->execute(['id' => substr($qurban->payment_method, 4, 9)]);
    $account = $stmt->fetch(PDO::FETCH_OBJ);

    return $this->view('jamaah/qurban_confirm', [ 'mosque' => $account->mosque,
                                                  'account' => $account,
                                                  'qurban' => $qurban
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

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO mosque_qurban(worship_place_id, year, animal_price, animal_type, max_person)
                                      VALUES(:wpi, :y, :ap, :at, :mp)");
    $stmt->execute(['wpi'=> $_SESSION['user']->worship_place_id, 'y' => date('Y'), 'ap' => $_POST['animal_price'],
                    'at' => $_POST['animal_type'], 'mp' => $_POST['person']]);

    if($stmt->fetch(PDO::FETCH_OBJ))
      $this->flash('New Qurban Type has been added!');
    else
      $this->flash('Duplicate Data!');

    return $this->redirect('stewardship/qurban');
  }

  public function destroyAnimalStewardship()
  {
    $this->authStewardship();

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM group_qurban WHERE worship_place_id=:id AND year=:year AND animal_type=:at");
    $stmt->execute(['id'=> $_GET['w'], 'year' => $_GET['y'], 'at' => $_GET['a']]);
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($r)) {
      $this->flash('This qurban animal has order by jamaah! You can not remove it');
      return $this->redirect('stewardship/qurban');
    }

    $stmt = $GLOBALS['pdo']->prepare('DELETE FROM mosque_qurban WHERE worship_place_id=:id AND year=:year AND animal_type=:at');
    $stmt->execute(['id'=> $_GET['w'], 'year' => $_GET['y'], 'at' => $_GET['a']]);

    $this->flash('Destroy Qurban Animal Success!');
    return $this->redirect('stewardship/qurban');
  }

  public function transactionStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT detail_qurban.*, worship_place.name, group_qurban.*, j.username, mq.*
                                      FROM detail_qurban
                                      INNER JOIN worship_place ON detail_qurban.worship_place_id = worship_place.id
                                      INNER JOIN jamaah as j ON detail_qurban.jamaah_id=j.id
                                      INNER JOIN group_qurban ON group_qurban.year=detail_qurban.year AND
                                      group_qurban.worship_place_id=detail_qurban.worship_place_id AND
                                      group_qurban.group=detail_qurban.group
                                      INNER JOIN mosque_qurban as mq ON group_qurban.year=mq.year AND
                                      group_qurban.worship_place_id=mq.worship_place_id AND
                                      group_qurban.animal_type=mq.animal_type WHERE detail_qurban.worship_place_id=:id
                                      ORDER BY datetime DESC");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/qurban_transaction', ['trans' => $data]);
  }

  public function confirmTransactionStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    if (isset($_GET['id'])) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_qurban WHERE datetime=:id AND confirmation=false");
      $stmt->execute(['id'=> $this->decrypt($_GET['id'])]);
      $r = $stmt->fetch(PDO::FETCH_OBJ);

      $currentInstallment = (int)substr($r->payment_method, 0, 1) - 1;
      $newInstallment = (int)substr($r->payment_method, 2, 1) + 1;
      $stewardship = substr($r->payment_method, 4, 8);

      if ($currentInstallment == 0)
        $confirm = 'true';
      else
        $confirm = 'false';

      $stmt = $GLOBALS['pdo']->prepare("UPDATE detail_qurban SET confirmation=:confirm, payment_method=:payment WHERE datetime=:id");
      $stmt->execute(['confirm' => $confirm, 'payment' => $currentInstallment.'~'.$newInstallment.'~'.$stewardship,
                      'id' => $this->decrypt($_GET['id'])]);

      $this->flash('Confirmation Success!');
      return $this->redirect('stewardship/qur/detail');
    }else {
      return $this->redirect('stewardship/qur/detail');
    }
  }

  public function closeTransactionStewardship()
  {
    $this->authStewardship();

    $stmt = $GLOBALS['pdo']->prepare("SELECT dq.* FROM mosque_qurban as dq WHERE dq.animal_type LIKE :d");
    $stmt->execute(['d' => '%Goat%']);
    $goat = $stmt->fetch(PDO::FETCH_OBJ);

    if ($goat) {

        $stmt = $GLOBALS['pdo']->prepare("SELECT dq.* FROM detail_qurban as dq WHERE dq.datetime=:d");
        $stmt->execute(['d' => $this->decrypt($_GET['id'])]);
        $d = $stmt->fetch(PDO::FETCH_OBJ);

        $stmt = $GLOBALS['pdo']->prepare("SELECT dq.group FROM group_qurban as dq WHERE dq.worship_place_id=:id
                                          ORDER BY dq.group DESC LIMIT 1");
        $stmt->execute(['id'=> $_SESSION['user']->worship_place_id]);
        $lastGroup = $stmt->fetch(PDO::FETCH_OBJ);
        $newGroup = sprintf("%02s", (int)$lastGroup->group+1);

        $stmt = $GLOBALS['pdo']->prepare('INSERT INTO public.group_qurban(animal_type, year, worship_place_id, status, "group")
                                          VALUES (:animal_type, :year, :id, :status, :group)');
        $stmt->execute(['animal_type' => "Goat", 'year' => date('Y'), 'id' => $_SESSION['user']->worship_place_id,
                                         'status' => 'true', 'group'=> $newGroup]);

        $currentFund = (int)substr($d->payment_method, 2, 1) * $d->fund;

        if ($currentFund >= $goat->animal_price) {
          $stewardship = substr($d->payment_method, 4, 8);
          $refund = $currentFund - $goat->animal_price;

          $stmt = $GLOBALS['pdo']->prepare('UPDATE public.detail_qurban SET "group"=:g, fund=:fund, confirmation=:confirm, payment_method=:payment WHERE datetime=:id');
          $stmt->execute(['g' => $newGroup,'fund' => $goat->animal_price, 'confirm' => 'true', 'payment' => '0'.'~'.'1'.'~'.$stewardship.'~'.$refund,
                          'id' => $this->decrypt($_GET['id'])]);

          $this->flash('This transaction successfully closed!');
          return $this->redirect('stewardship/qur/detail');
        }else{
          $this->flash('This transaction doesnt have enough fund!');
          return $this->redirect('stewardship/qur/detail');
        }

    }else{
      $this->flash('Your Mosque doesnt have goat animal for qurban!');
      return $this->redirect('stewardship/qur/detail');
    }
  }

  public function indexGroupAnimalStewardship()
  {
    $id = $_SESSION['user']->worship_place_id;
    $stmt = $GLOBALS['pdo']->prepare("SELECT gq.*, mq.max_person FROM group_qurban as gq INNER JOIN
                                      mosque_qurban as mq ON gq.worship_place_id = mq.worship_place_id
                                      AND gq.year = mq.year AND gq.animal_type = mq.animal_type
                                      WHERE gq.worship_place_id=:id AND gq.year=:y ORDER BY gq.group ASC");
    $stmt->execute(['id'=> $id, 'y' => date('Y')]);
    $qurban = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/qurban_group', ['qurban' => $qurban]);
  }

  public function addGroupAnimalStewardship()
  {
    $stmt = $GLOBALS['pdo']->prepare('INSERT INTO public.group_qurban(animal_type, year, worship_place_id, status, "group")
                                      VALUES (:animal_type, :year, :id, :status, :group)');
    $stmt->execute(['animal_type' => $_POST['animal_type'], 'year' => date('Y'), 'id' => $_SESSION['user']->worship_place_id,
                    'status' => 'true', 'group'=> $_POST['group']]);
    if ($stmt->fetchAll(PDO::FETCH_OBJ)) {
      $this->flash('Group successfully created!');
      return $this->redirect('stewardship/qurb/group');
    }else{
      $this->flash('Group Duplicate!');
      return $this->redirect('stewardship/qurb/group');
    }
  }

  public function changeGroupAnimalStewardship()
  {
    $id = $this->decrypt(substr($_GET['par'],3,100));

    $stmt = $GLOBALS['pdo']->prepare('UPDATE detail_qurban SET "group"=:g WHERE datetime=:id');
    $stmt->execute(['g' => substr($_GET['par'], 0, 2), 'id' => $id]);

    $this->flash('User successfully moved to group '. substr($_GET['par'], 0, 2) .'!');
    return $this->redirect('stewardship/qurb/group');
  }

  public function destroyGroupAnimalStewardship()
  {
    $stmt = $GLOBALS['pdo']->prepare('DELETE FROM group_qurban WHERE worship_place_id=:id AND year=:year AND "group"=:g');
    $stmt->execute(['id'=> $_GET['w'], 'year' => $_GET['y'], 'g' => $_GET['g']]);

    $this->flash('Group successfully removed!');
    return $this->redirect('stewardship/qurb/group');
  }
}
