<?php

class UserController extends Controller{

  public function index()
  {
    return $this->view('guest/home');
  }

  // __________________________________________ ADMIN __________________________________________
  public function loginAdmin()
  {
    $this->passLoginAdmin();
    return $this->view('guest/login_admin');
  }

  public function checkLoginAdmin()
  {
    $this->passLoginAdmin();
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM admin WHERE username =:username AND password=:password");
    $stmt->execute(['username' => $_POST['username'], 'password' => md5($_POST['password']) ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

    if( ! empty($data)){
      $_SESSION['admin'] = true;
      $_SESSION['user'] = $data;
      $this->redirect('admin/dashboard');
    }else{
      $this->flash('Username or Password Incorrect!');
      return $this->redirect('admin');
    }
  }

  public function dashboardAdmin()
  {
    $this->authAdmin();
    $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM worship_place");
    $stmt->execute();
    $c = $stmt->fetch()['count'];

    $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM jamaah");
    $stmt->execute();
    $j = $stmt->fetch()['count'];

    $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM stewardship");
    $stmt->execute();
    $s = $stmt->fetch()['count'];

    return $this->view('admin/dashboard', ['mosque' => $c, 'jamaah' => $j, 'stewardship' => $s]);
  }

  public function indexStewardship()
  {
    $this->authAdmin();
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, worship_place.name, worship_place.address as worship_place_address, jamaah.id as jamaah_id
                                      FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $this->view('admin/stewardship', ['j' => $r]);
  }

  public function storeStewardship()
  {
    if (isset($_GET['id'])) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship WHERE jamaah_id=:id");
      $data = $stmt->execute(['id' => $_GET['id']]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      if (empty($data)){
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO stewardship (jamaah_id, type_of_work_id, identity_number, whatsapp)
                                          VALUES(:jamaah_id, :type, :identity_number, :whatsapp)");
        $stmt->execute(['jamaah_id' => $_GET['id'], 'type' => $_POST['type'], 'identity_number' => $_POST['identity'], 'whatsapp' => $_POST['whatsapp']]);

        $this->flash('Successfully Approved!');
        return $this->redirect('admin/stewardship');
      }else{
        $this->flash('Approve Failed!');
        return $this->redirect('admin/stewardship');
      }
    }else{
      return $this->view('error/404');
    }
  }

  // __________________________________________ GUEST __________________________________________
  public function formLogin()
  {
    $this->passLoginJamaah();
    return $this->view('guest/login');
  }

  public function login()
  {
    $this->passLoginJamaah();
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, worship_place.name, worship_place.address as worship_place_address, jamaah.id as jamaah_id
                                      FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                      WHERE phone =:phone AND password=:password");
    $stmt->execute(['phone' => $_POST['phone'], 'password' => md5($_POST['password']) ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

    if( ! empty($data)){
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship WHERE jamaah_id=:id");
      $stmt->execute(['id' => $data->id]);
      $s = $stmt->fetch(PDO::FETCH_OBJ);

      if(!empty($s)){
        $_SESSION['jamaah'] = true;
        $_SESSION['stewardship'] = true;
        $_SESSION['user'] = $data;
        $_SESSION['userStewardship'] = $s;
        $this->redirect('stewardship/dashboard');
      }else{
        $_SESSION['jamaah'] = true;
        $_SESSION['user'] = $data;
        $this->redirect('jamaah/dashboard');
      }
    }else{
      $this->flash('Username or Password Incorrect!');
      return $this->redirect('login');
    }
  }

  public function formRegister()
  {
    $this->passLoginJamaah();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $this->view('guest/register', ['w' => $r]);
  }

  public function register()
  {
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah WHERE phone=:phone");
    $stmt->execute(['phone' => $_POST['phone'] ]);
    $phone = $stmt->fetch(PDO::FETCH_OBJ);

    if(!empty($phone)){
      $this->flash('This Phone has Registered!');
      return $this->redirect('register');
    }

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO jamaah(worship_place_id, type, username, address, phone, password, updated_at)
                                      VALUES(:worship_place_id, :type, :username, :address, :phone, :password, now())");
    $stmt->execute(['worship_place_id' => $_POST['mosque'], 'type' => $_POST['type'], 'username' => $_POST['username'], 'address' => $_POST['address'], 'phone' => $_POST['phone'], 'password' => md5($_POST['password'])]);

    $lastId = $GLOBALS['pdo']->lastInsertId();
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, worship_place.name, worship_place.address as worship_place_address, jamaah.id as jamaah_id
                                      FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                      WHERE jamaah.id=:id");
    $stmt->execute(['id' => $lastId ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

    if( ! empty($data)){
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship WHERE jamaah_id=:id");
      $stmt->execute(['id' => $data->id]);
      $s = $stmt->fetch(PDO::FETCH_OBJ);

      if(!empty($s)){
        $_SESSION['jamaah'] = true;
        $_SESSION['stewardship'] = true;
        $_SESSION['user'] = $data;
        $_SESSION['userStewardship'] = $s;
        $this->redirect('stewardship/dashboard');
      }else{
        $_SESSION['jamaah'] = true;
        $_SESSION['user'] = $data;
        $this->redirect('jamaah/dashboard');
      }
    }else{
      $this->flash('Something Wrong!');
      return $this->redirect('register');
    }
  }

  public function logout()
  {
    session_destroy();
    $this->redirect('/');
  }

  //__________________________________________ JAMAAH __________________________________________

  public function dashboardJamaah()
  {
    $this->authJamaah();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $this->view('jamaah/dashboard', ['m' => $r]);
  }

  public function storeAvatarJamaah()
  {
    $this->authJamaah();
    $this->check_csrf($_POST);

    $jenis_gambar=$_FILES['image']['type'];

    if(($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif"  || $jenis_gambar=="image/png")
        && ($_FILES["image"]["size"] <= 10000000)){

      if ($_SESSION['user']->avatar != 'user.png') {
        if(!unlink('images/avatar/' . $_SESSION['user']->avatar)){
          $this->flash('Image destroy error!');
          return $this->redirect('jamaah/dashboard');
        }
      }

      $sourcename=$_FILES["image"]["name"];
  		$name= time().'_'.$sourcename;
  		$filepath= 'images/avatar/' .$name;
  		move_uploaded_file($_FILES["image"]["tmp_name"], $filepath);

      $stmt = $GLOBALS['pdo']->prepare("UPDATE jamaah SET avatar=:avatar where id=:id");
      $stmt->execute(['avatar' => $name, 'id' => $_SESSION['user']->id]);
      $_SESSION['user']->avatar = $name;

      $this->flash('Avatar has Change Successfully!');
      return $this->redirect('jamaah/dashboard');

  	} else if ($_POST['image']=='null' || $_POST['image']=='' || $_POST['image']==null){
      $this->flash('Foto tidak sesuai!');
  		return $this->redirect('jamaah/dashboard');
  	}

  }

  public function updatePasswordJamaah()
  {
    $this->authJamaah();
    $this->check_csrf($_POST);

    if ($_POST['password'] != $_POST['password-confirmation']) {
      $this->flash('Konfirmasi password tidak sesuai!');
      return $this->redirect('jamaah/dashboard');
    }else{
      $stmt = $GLOBALS['pdo']->prepare("UPDATE jamaah SET password=:password where id=:id");
      $stmt->execute(['password' => md5($_POST['password']), 'id' => $_SESSION['user']->id]);

      $this->flash('Change Password Success!');
      return $this->redirect('jamaah/dashboard');
    }
  }

  public function updateProfileJamaah()
  {
    $this->authJamaah();
    $this->check_csrf($_POST);

    if ($_POST['phone'] != $_SESSION['user']->phone) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah WHERE phone=:phone");
      $stmt->execute(['phone' => $_POST['phone'] ]);
      $phone = $stmt->fetch();

      if(!empty($phone)){
        $this->flash('No. Handphone ini sudah terdaftar!');
        return $this->redirect('jamaah/dashboard');
      }
    }

    if (isset($_SESSION['stewardship'])) {
      if ($_SESSION['stewardship'] === true){
        $_POST['mosque'] = $_SESSION['user']->worship_place_id;
      }
    }

    $stmt = $GLOBALS['pdo']->prepare("UPDATE jamaah SET username=:username, phone=:phone, address=:address, worship_place_id=:mosque, type=:type where id=:id");
    $stmt->execute(['username' => $_POST['name'], 'phone' => $_POST['phone'], 'address' => $_POST['address'], 'mosque' => $_POST['mosque'], 'type' => $_POST['type'], 'id' => $_SESSION['user']->id]);

    $id = $_SESSION['user']->jamaah_id;
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, worship_place.name, worship_place.address as worship_place_address, jamaah.id as jamaah_id
                                      FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                      WHERE jamaah.id=:jamaah_id");
    $stmt->execute(['jamaah_id' => $id]);
    $j = $stmt->fetch(PDO::FETCH_OBJ);

    if (!empty($j)) {
      $_SESSION['user'] = $j;
    }

    $this->flash('Update Profile Success!');
    return $this->redirect('jamaah/dashboard');
  }

  public function history()
  {
    $this->authJamaah();
    $stmt = $GLOBALS['pdo']->prepare("SELECT cash_in.*, worship_place.name FROM cash_in
                                      INNER JOIN worship_place ON cash_in.worship_place_id = worship_place.id
                                      WHERE jamaah_id=:jamaah_id ORDER BY datetime DESC");
    $stmt->execute(['jamaah_id' => $_SESSION['user']->jamaah_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('jamaah/history', ['history' => $data]);
  }

  public function historyQurban()
  {
    $this->authJamaah();
    $stmt = $GLOBALS['pdo']->prepare("SELECT detail_qurban.*, worship_place.name FROM detail_qurban
                                      INNER JOIN worship_place ON detail_qurban.worship_place_id = worship_place.id
                                      WHERE jamaah_id=:jamaah_id ORDER BY datetime DESC");
    $stmt->execute(['jamaah_id' => $_SESSION['user']->jamaah_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('jamaah/qurban_history', ['history' => $data]);
  }

  //__________________________________________ STEWARDSHIP __________________________________________

  public function dashboardStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship INNER JOIN type_of_work ON stewardship.type_of_work_id = type_of_work.id WHERE stewardship.jamaah_id=:jamaah_id");
    $stmt->execute(['jamaah_id' => $_SESSION['user']->jamaah_id]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

    return $this->view('stewardship/dashboard', ['m' => $data]);
  }

  public function updateAccountStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("UPDATE stewardship SET type_of_work_id=:type_of_work_id, whatsapp=:whatsapp where jamaah_id=:jamaah_id");
    $stmt->execute(['type_of_work_id' => $_POST['type'], 'whatsapp' => $_POST['whatsapp'], 'jamaah_id' => $_SESSION['user']->jamaah_id]);

    $this->flash('Update Data Success!');
    return $this->redirect('stewardship/dashboard');
  }

  public function storeAccountStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO account(stewardship_id, bank, owner, account_number)
                                      VALUES(:stewardship_id, :bank, :owner, :account_number)");
    $stmt->execute(['stewardship_id'=> $_SESSION['user']->jamaah_id, 'bank' => $_POST['bank'], 'owner' => $_POST['owner'], 'account_number' => $_POST['account_number']]);

    $this->flash('Add Account Success!');
    return $this->redirect('stewardship/dashboard');
  }

  public function destroyAccountStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare('DELETE FROM account WHERE id=:id');
    $stmt->execute(['id' => $_GET['id']]);

    $this->flash('Destroy Account Success!');
    return $this->redirect('stewardship/dashboard');
  }

  public function jamaahStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah WHERE worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/jamaah', ['j' => $data]);
  }

}
