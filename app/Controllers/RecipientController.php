<?php

class RecipientController extends Controller{

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

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO ustad(name, address, phone, last_editor)
                                      VALUES(:name, :address, :phone, :last)");
    $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'],
                    "last" => "Edited by ". $_SESSION['user']->username." at ".date('Y-m-d H:i:s')]);

    $this->flash('Add Ustad Data Successfully!');
    return $this->redirect('stewardship/recipient/ustad');
  }

  public function updateUstad()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);
      $stmt = $GLOBALS['pdo']->prepare("UPDATE ustad SET name=:name, address=:address, phone=:phone, last_editor=:editor WHERE id=:id");
      $stmt->execute(['name'=> $_POST['name'], 'address' => $_POST['address'], 'phone' => $_POST['phone'], 'id' => $_GET['id'],
                      "editor" => "Edited by ". $_SESSION['user']->username." at ".date('Y-m-d H:i:s')]);

      $this->flash('Edit Ustad Data Successfully!');
      return $this->redirect('stewardship/recipient/ustad');
    }else{
      return $this->redirect('stewardship/recipient/ustad');
    }
  }

}
