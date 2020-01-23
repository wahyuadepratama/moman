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

  public function indexJamaah()
  {
    $this->authAdmin();
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.id, jamaah.username, jamaah.avatar, jamaah.phone, worship_place.name
                                      FROM jamaah INNER JOIN worship_place ON worship_place.id=jamaah.worship_place_id");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('admin/jamaah', ['j' => $r]);
  }

  public function indexStewardship()
  {
    $this->authAdmin();
    $stmt = $GLOBALS['pdo']->prepare("SELECT stewardship.*, jamaah.username, jamaah.phone, jamaah.avatar, worship_place.name
                                      FROM stewardship INNER JOIN jamaah ON stewardship.jamaah_id=jamaah.id
                                      INNER JOIN worship_place ON worship_place.id=jamaah.worship_place_id");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('admin/stewardship', ['j' => $r]);
  }

  public function storeStewardship()
  {
    if (isset($_GET['id'])) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship WHERE jamaah_id=:id AND period=:period");
      $data = $stmt->execute(['id' => $_GET['id'], 'period' => $_POST['period']]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      if (empty($data)){
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO stewardship (jamaah_id, period, type_of_work_id, whatsapp, account_status)
                                          VALUES(:jamaah_id, :period, :type, :whatsapp, 'true')");
        $stmt->execute(['jamaah_id' => $_GET['id'], 'period' => $_POST['period'], 'type' => $_POST['type'], 'whatsapp' => $_POST['whatsapp']]);

        $this->flash('Successfully Approved!');
        return $this->redirect('admin/stewardship');
      }else{
        $this->flash('Approve Failed! Cause user has been registered for this period');
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

    // Check username and password from db
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, jamaah.name as jamaah_name, worship_place.name, worship_place.address as worship_place_address
                                      FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                      WHERE username =:username AND password=:password");
    $stmt->execute(['username' => $_POST['username'], 'password' => md5($_POST['password']) ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    // End check username and password from db

    // Store data to session
    if( ! empty($data)){
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship WHERE jamaah_id=:id AND account_status='true'");
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
    // End store data
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

    // Check username unique from db
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah WHERE username=:username");
    $stmt->execute(['username' => $_POST['username'] ]);
    $username = $stmt->fetch(PDO::FETCH_OBJ);

    if(!empty($username)){
      $this->flash('This username has Registered!');
      return $this->redirect('register');
    }
    // End check username

    // Insert data to db
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO jamaah(worship_place_id, id, type, name, password, address, updated_at, phone, username)
                                      VALUES(:worship_place_id, :id, :type, :name, :password, :address, now(), :phone, :username)");
    $stmt->execute(['worship_place_id' => $_POST['mosque'],
                    'id' => $_POST['ktp'],
                    'type' => $_POST['type'],
                    'name' => $_POST['name'],
                    'password' => md5($_POST['password']),
                    'address' => $_POST['address'],
                    'phone' => $_POST['phone'],
                    'username' => $_POST['username']
                  ]);

    if (!$stmt->fetch(PDO::FETCH_OBJ)) {
      $this->flash('This identity number has registered!');
      return $this->redirect('register');
    }

    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, jamaah.name as jamaah_name, worship_place.name, worship_place.address as worship_place_address
                                      FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                      WHERE jamaah.id=:id");
    $stmt->execute(['id' => $_POST['ktp'] ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    // End insert data to db

    // Store data to session (check if insert data failed, return fail)
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
    // End store data to session
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
  		$name= time();
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

    // Check unique username from db
    if ($_POST['username'] != $_SESSION['user']->username) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah WHERE username=:username");
      $stmt->execute(['username' => $_POST['username'] ]);
      $username = $stmt->fetch();

      if(!empty($username)){
        $this->flash('You cannot use "'.$_POST['username'].'", another user has been using it!');
        return $this->redirect('jamaah/dashboard');
      }
    }
    // End check username from db

    // Check if user is stewardship, mosque cannot updated
    if (isset($_SESSION['stewardship'])) {
      if ($_SESSION['stewardship'] === true){
        $_POST['mosque'] = $_SESSION['user']->worship_place_id;
      }
    }
    // End check if user is stewardship

    // Update data to db
    $stmt = $GLOBALS['pdo']->prepare("UPDATE jamaah SET name=:name, username=:username, phone=:phone, address=:address, worship_place_id=:mosque, type=:type where id=:id");
    $stmt->execute(['name' => $_POST['name'],
                    'username' => $_POST['username'],
                    'phone' => $_POST['phone'],
                    'address' => $_POST['address'],
                    'mosque' => $_POST['mosque'],
                    'type' => $_POST['type'],
                    'id' => $_SESSION['user']->id]);
    // End update

    // Refresh data on dashboard after updated
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, jamaah.name as jamaah_name, worship_place.name, worship_place.address as worship_place_address
                                      FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                      WHERE jamaah.id=:jamaah_id");
    $stmt->execute(['jamaah_id' => $_SESSION['user']->id]);
    $j = $stmt->fetch(PDO::FETCH_OBJ);

    if (!empty($j)) {
      $_SESSION['user'] = $j;
    }
    // End refresh data

    $this->flash('Update Profile Success!');
    return $this->redirect('jamaah/dashboard');
  }

  public function historyQurban()
  {
    $this->authJamaah();
    $stmt = $GLOBALS['pdo']->prepare("SELECT qurban_order.*, jamaah.name as jamaah_name,
                                      worship_place.name, qurban.year, qurban.animal_price FROM qurban_order
                                      INNER JOIN jamaah ON jamaah.id=qurban_order.jamaah_id
                                      INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                      INNER JOIN qurban ON qurban.worship_place_id=worship_place.id
                                      WHERE qurban_order.jamaah_id=:jamaah_id");
    $stmt->execute(['jamaah_id' => $_SESSION['user']->id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('jamaah/qurban_history', ['history' => $data]);
  }

  //__________________________________________ STEWARDSHIP __________________________________________

  public function dashboardStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship INNER JOIN type_of_work
                                      ON stewardship.type_of_work_id = type_of_work.id
                                      WHERE stewardship.jamaah_id=:jamaah_id");
    $stmt->execute(['jamaah_id' => $_SESSION['user']->id]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM gallery WHERE worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $gallery = $stmt->fetch(PDO::FETCH_OBJ);

    return $this->view('stewardship/dashboard', ['m' => $data, 'gallery' => $gallery->image]);
  }

  public function updateAccountStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("UPDATE stewardship SET type_of_work_id=:type_of_work_id, whatsapp=:whatsapp WHERE jamaah_id=:jamaah_id
                                      AND period=:period");
    $stmt->execute(['type_of_work_id' => $_POST['type'], 'whatsapp' => $_POST['whatsapp'], 'jamaah_id' => $_SESSION['user']->id,
                    'period' => $_POST['period_hidden']]);

    $this->flash('Update Data Success!');
    return $this->redirect('stewardship/dashboard?period='. $_POST['period_hidden']);
  }

  public function storeAccountStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO account(stewardship_id, stewardship_period, bank, owner, account_number)
                                      VALUES(:stewardship_id, :period, :bank, :owner, :account_number)");
    $stmt->execute(['stewardship_id'=> $_GET['stewardship'], 'period' => $_GET['period'], 'bank' => $_POST['bank'],
                    'owner' => $_POST['owner'], 'account_number' => $_POST['account_number']]);

    $this->flash('Add Account Success!');
    return $this->redirect('stewardship/dashboard?period='. $_GET['period']);
  }

  public function destroyAccountStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare('DELETE FROM account WHERE stewardship_id=:id AND stewardship_period=:period
                                      AND account_number=:account');
    $stmt->execute(['id' => $_GET['stewardship'], 'period' => $_GET['period'], 'account' => $_GET['account']]);

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
