<?php

class DonationController extends Controller{

  // __________________________________ GUEST ____________________________________

  public function donation(){
    $stmt = $GLOBALS['pdo']->prepare("SELECT project.*, worship_place.name as worship FROM project INNER JOIN worship_place ON project.worship_place_id = worship_place.id ORDER BY project.id DESC");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($r as $key) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT SUM(fund) as total FROM cash_in WHERE project_id=:id AND confirmation = 'true'");
      $stmt->execute(['id' => $key->id]);
      $collected = $stmt->fetch(PDO::FETCH_OBJ);
      $key->collected = $collected->total;
    }

    return $this->view('guest/donation', ['project' => $r]);
  }

  public function donationDetail(){
    if(isset($_GET['project'])){
      $id = $this->decrypt($_GET['project']);
      $stmt = $GLOBALS['pdo']->prepare("SELECT project.*, worship_place.id as worship_id,
                                        worship_place.name as worship FROM project INNER JOIN
                                        worship_place ON project.worship_place_id = worship_place.id
                                        WHERE project.id=:project_id");
      $stmt->execute(['project_id' => $id]);
      $result = $stmt->fetch(PDO::FETCH_OBJ);

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
      $result->collected = $collected->total;

      return $this->view('guest/donation_detail', ['project' => $result,
                                                   'steward' => $stewardship,
                                                   'account' => $account,
                                                   'donatur' => $donatur]);
    }else{
      return $this->view('error/404');
    }
  }

  public function orphans()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place ORDER BY name DESC");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $this->view('guest/orphan', ['orphan' => $r]);
  }

  public function orphanDetail()
  {
    if(isset($_GET['id'])){
      $id = $this->decrypt($_GET['id']);

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

      return $this->view('guest/orphan_detail', ['mosque' => $m,
                                                   'steward' => $stewardship,
                                                   'account' => $account,
                                                   'donatur' => $donatur]);
    }else{
      return $this->view('error/404');
    }
  }

  public function poor()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place ORDER BY name DESC");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $this->view('guest/poor', ['orphan' => $r]);
  }

  public function poorDetail()
  {
    if(isset($_GET['id'])){
      $id = $this->decrypt($_GET['id']);

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
                                        AND cash_in.status_out='poor' AND cash_in.confirmation=true AND cash_in.worship_place_id=:id");
      $stmt->execute(['id' => $id]);
      $donatur = $stmt->fetchAll(PDO::FETCH_OBJ);

      return $this->view('guest/poor_detail', ['mosque' => $m,
                                               'steward' => $stewardship,
                                               'account' => $account,
                                               'donatur' => $donatur]);
    }else{
      return $this->view('error/404');
    }
  }

  // __________________________________ JAMAAH ____________________________________
  public function storeDonation()
  {
    $this->authJamaah();
    $this->check_csrf($_POST);

    if (isset($_GET['project'])) {

      if (!isset($_POST)) {
        return $this->redirect('donation/detail?project='. $_GET['project']);
      }

      $_POST['fund'] = substr($_POST['fund'], 4);
      $_POST['fund'] = str_replace(".", "", $_POST['fund']);

      $id = $this->decrypt($_GET['project']);
      $stmt = $GLOBALS['pdo']->prepare("SELECT worship_place.name as mosque, worship_place.id as worship_id
                                        FROM project INNER JOIN
                                        worship_place ON project.worship_place_id = worship_place.id
                                        WHERE project.id=:project_id");
      $stmt->execute(['project_id' => $id]);
      $result = $stmt->fetch(PDO::FETCH_OBJ);

      if ($_POST['public'] == 'public') {
        $_POST['public'] = 'true';
      }else{
        $_POST['public'] = 'false';
      }

      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id, project_id, jamaah_id, fund,
                                        status_in, status_out, datetime, confirmation, public)
                                        VALUES(:worship, :project, :jamaah, :fund, :_in, :_out, now(), 'false', :public)");
      $stmt->execute(['worship' => $result->worship_id,
                      'project' => $id,
                      'jamaah' => $_SESSION['user']->jamaah_id,
                      'fund' => $_POST['fund'],
                      '_in' => 'transfer jamaah',
                      '_out' => 'project',
                      'public' => $_POST['public']
                    ]);

      return $this->redirect('jamaah/checking?id='. $this->encrypt($GLOBALS['pdo']->lastInsertId()));

    }else{
      return $this->view('error/404');
    }
  }

  public function storeOrphan()
  {
    $this->authJamaah();
    $this->check_csrf($_POST);

    if (isset($_GET['id'])) {

      if (!isset($_POST)) {
        return $this->redirect('orphan/detail?id='. $_GET['id']);
      }

      $_POST['fund'] = substr($_POST['fund'], 4);
      $_POST['fund'] = str_replace(".", "", $_POST['fund']);

      $id = $this->decrypt($_GET['id']);

      if ($_POST['public'] == 'public') {
        $_POST['public'] = 'true';
      }else{
        $_POST['public'] = 'false';
      }

      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id, jamaah_id, fund,
                                        status_in, status_out, datetime, description, confirmation, public)
                                        VALUES(:worship, :jamaah, :fund, :_in, :_out, now(), :dsc, 'false', :public)");
      $stmt->execute(['worship' => $id,
                      'jamaah' => $_SESSION['user']->jamaah_id,
                      'fund' => $_POST['fund'],
                      '_in' => 'transfer jamaah',
                      '_out' => 'orphanage',
                      'dsc' => $_POST['account'],
                      'public' => $_POST['public']
                    ]);

      return $this->redirect('jamaah/checking?id='. $this->encrypt($GLOBALS['pdo']->lastInsertId()));

    }else{
      return $this->view('error/404');
    }
  }

  public function storePoor()
  {
    $this->authJamaah();
    $this->check_csrf($_POST);

    if (isset($_GET['id'])) {

      if (!isset($_POST)) {
        return $this->redirect('poor/detail?id='. $_GET['id']);
      }

      $_POST['fund'] = substr($_POST['fund'], 4);
      $_POST['fund'] = str_replace(".", "", $_POST['fund']);

      $id = $this->decrypt($_GET['id']);

      if ($_POST['public'] == 'public') {
        $_POST['public'] = 'true';
      }else{
        $_POST['public'] = 'false';
      }

      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id, jamaah_id, fund,
                                        status_in, status_out, datetime, description, confirmation, public)
                                        VALUES(:worship, :jamaah, :fund, :_in, :_out, now(), :dsc, 'false', :public)");
      $stmt->execute(['worship' => $id,
                      'jamaah' => $_SESSION['user']->jamaah_id,
                      'fund' => $_POST['fund'],
                      '_in' => 'transfer jamaah',
                      '_out' => 'poor',
                      'dsc' => $_POST['account'],
                      'public' => $_POST['public']
                    ]);

      return $this->redirect('jamaah/checking?id='. $this->encrypt($GLOBALS['pdo']->lastInsertId()));

    }else{
      return $this->view('error/404');
    }
  }

  public function checkDonation()
  {
    $this->authJamaah();
    $id = $this->decrypt($_GET['id']);

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

    return $this->view('jamaah/donation_confirm', ['mosque' => $account->mosque,
                                            'account' => $account,
                                            'donation' => $cash->fund
                                          ]);
  }

  // __________________________________ STEWARDSHIP ____________________________________
  public function projectStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM project WHERE worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    return $this->view('stewardship/project', ['project' => $stmt]);
  }

  public function storeProjectStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $_POST['fund'] = substr($_POST['fund'], 4);
    $_POST['fund'] = str_replace(".", "", $_POST['fund']);

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO project(name, description, fund, worship_place_id)
                                      VALUES(:name, :description, :fund, :worship_place_id)");
    $stmt->execute(['name' => $_POST['name'], 'description' => $_POST['description'], 'fund' => $_POST['fund'], 'worship_place_id' => $_SESSION['user']->worship_place_id]);
    $lastId = $GLOBALS['pdo']->lastInsertId();

    for ($i=0; $i < count($_FILES['gallery']['name']); $i++) {

      $jenis_gambar=$_FILES['gallery']['type'][$i];
      if(($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif"  || $jenis_gambar=="image/png")
          && ($_FILES["gallery"]["size"][$i] <= 3000000)){

            $name= time().'_'.($_FILES['gallery']['name'][$i]);
            $filepath= 'images/project/' .$name;
            move_uploaded_file($_FILES["gallery"]["tmp_name"][$i], $filepath);

            $stmt = $GLOBALS['pdo']->prepare("INSERT INTO project_gallery(image, project_id)
                                              VALUES(:image, :project_id)");
            $stmt->execute(['image' => $name, 'project_id' => $lastId]);

      }
    }

    $this->flash('New Project Successfully Added!');
    return $this->redirect('stewardship/donation/project');
  }

  public function updateProjectStewardship()
  {
    if (isset($_GET['id'])) {
      $stmt = $GLOBALS['pdo']->prepare("UPDATE project SET progress=:progress where id=:id");
      $stmt->execute(['progress' => $_POST['progress'], 'id' => $_GET['id']]);

      for ($i=0; $i < count($_FILES['gallery']['name']); $i++) {

        $jenis_gambar=$_FILES['gallery']['type'][$i];
        if(($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif"  || $jenis_gambar=="image/png")
            && ($_FILES["gallery"]["size"][$i] <= 3000000)){

              $name= time().'_'.($_FILES['gallery']['name'][$i]);
              $filepath= 'images/project/' .$name;
              move_uploaded_file($_FILES["gallery"]["tmp_name"][$i], $filepath);

              $stmt = $GLOBALS['pdo']->prepare("INSERT INTO project_gallery(image, project_id)
                                                VALUES(:image, :project_id)");
              $stmt->execute(['image' => $name, 'project_id' => $_GET['id']]);

        }
      }
      $this->flash('Project Successfully Updated!');
      return $this->redirect('stewardship/donation/project');
    }else{
      $this->flash('Something Wrong!');
      return $this->redirect('stewardship/donation/project');
    }
  }

  public function transactionStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT cash_in.*, worship_place.name, jamaah.username FROM cash_in
                                      INNER JOIN worship_place ON cash_in.worship_place_id = worship_place.id
                                      INNER JOIN jamaah ON cash_in.jamaah_id = jamaah.id
                                      WHERE worship_place.id=:worship_id ORDER BY confirmation ASC");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/transaction', ['trans' => $data]);
  }

  public function confirmTransactionStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    if (isset($_GET['id'])) {
      $stmt = $GLOBALS['pdo']->prepare("UPDATE cash_in SET description=:des, confirmation='true' WHERE id=:id");
      $stmt->execute(['des' => $_POST['description'], 'id' => $_GET['id']]);

      $this->flash('Confirmation Success!');
      return $this->redirect('stewardship/donation/transaction');
    }else {
      return $this->redirect('stewardship/donation/transaction');
    }

  }

}
