<?php

class RecipientController extends Controller{

  public function indexPoor()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM poor");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/poor', ['poor' => $data]);
  }

  public function storePoor()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO poor(name, address, phone)
                                      VALUES(:name, :address, :phone)");
    $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'],]);

    $this->flash('Add Poor Data Successfully!');
    return $this->redirect('stewardship/recipient/poor');
  }

  public function updatePoor()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);
      $stmt = $GLOBALS['pdo']->prepare("UPDATE poor SET name=:name, address=:address, phone:phone WHERE id=:id");
      $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'], 'id' => $_GET['id']]);

      $this->flash('Edit Poor Data Successfully!');
      return $this->redirect('stewardship/recipient/poor');
    }else{
      return $this->redirect('stewardship/recipient/poor');
    }
  }

  public function indexTpa()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM tpa");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/tpa', ['tpa' => $data]);
  }

  public function storeTpa()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO tpa(name, address)
                                      VALUES(:name, :address)");
    $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address']]);

    $this->flash('Add TPA Data Successfully!');
    return $this->redirect('stewardship/recipient/tpa');
  }

  public function updateTpa()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);
      $stmt = $GLOBALS['pdo']->prepare("UPDATE tpa SET name=:name, address=:address WHERE id=:id");
      $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'id' => $_GET['id']]);

      $this->flash('Edit TPA Data Successfully!');
      return $this->redirect('stewardship/recipient/tpa');
    }else{
      return $this->redirect('stewardship/recipient/tpa');
    }
  }

  public function indexStore()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM store");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/store', ['store' => $data]);
  }

  public function storeStore()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO store(name, address, phone)
                                      VALUES(:name, :address, :phone)");
    $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'],]);

    $this->flash('Add Store Data Successfully!');
    return $this->redirect('stewardship/recipient/store');
  }

  public function updateStore()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);
      $stmt = $GLOBALS['pdo']->prepare("UPDATE store SET name=:name, address=:address, phone=:phone WHERE id=:id");
      $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'], 'id' => $_GET['id']]);

      $this->flash('Edit Store Data Successfully!');
      return $this->redirect('stewardship/recipient/store');
    }else{
      return $this->redirect('stewardship/recipient/store');
    }
  }

  public function indexBuilder()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM builder");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/builder', ['builder' => $data]);
  }

  public function storeBuilder()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO builder(name, address, phone)
                                      VALUES(:name, :address, :phone)");
    $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'],]);

    $this->flash('Add Builder Data Successfully!');
    return $this->redirect('stewardship/recipient/builder');
  }

  public function updateBuilder()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);
      $stmt = $GLOBALS['pdo']->prepare("UPDATE builder SET name=:name, address=:address, phone=:phone WHERE id=:id");
      $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'], 'id' => $_GET['id']]);

      $this->flash('Edit Builder Data Successfully!');
      return $this->redirect('stewardship/recipient/builder');
    }else{
      return $this->redirect('stewardship/recipient/builder');
    }
  }

  public function indexUstad()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM ustad");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/ustad', ['ustad' => $data]);
  }

  public function storeUstad()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO ustad(name, address, phone)
                                      VALUES(:name, :address, :phone)");
    $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'],]);

    $this->flash('Add Ustad Data Successfully!');
    return $this->redirect('stewardship/recipient/ustad');
  }

  public function updateUstad()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);
      $stmt = $GLOBALS['pdo']->prepare("UPDATE ustad SET name=:name, address=:address, phone=:phone WHERE id=:id");
      $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'], 'id' => $_GET['id']]);

      $this->flash('Edit Ustad Data Successfully!');
      return $this->redirect('stewardship/recipient/ustad');
    }else{
      return $this->redirect('stewardship/recipient/ustad');
    }
  }

  public function indexOrphanage()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM orphanage");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/orphanage', ['orphanage' => $data]);
  }

  public function storeOrphanage()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO orphanage(name, address, phone)
                                      VALUES(:name, :address, :phone)");
    $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'],]);

    $this->flash('Add Orphan Data Successfully!');
    return $this->redirect('stewardship/recipient/orphanage');
  }

  public function updateOrphanage()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);
      $stmt = $GLOBALS['pdo']->prepare("UPDATE orphanage SET name=:name, address=:address, phone=:phone WHERE id=:id");
      $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'], 'id' => $_GET['id']]);

      $this->flash('Edit Orphan Data Successfully!');
      return $this->redirect('stewardship/recipient/orphanage');
    }else{
      return $this->redirect('stewardship/recipient/orphanage');
    }
  }

}
