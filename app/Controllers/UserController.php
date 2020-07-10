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
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('admin/jamaah', ['j' => $r]);
  }

  public function indexStewardship()
  {
    $this->authAdmin();
    $stmt = $GLOBALS['pdo']->prepare("SELECT stewardship.*, jamaah.username, jamaah.phone, jamaah.avatar, worship_place.name
                                      FROM stewardship INNER JOIN jamaah ON stewardship.jamaah_id=jamaah.id
                                      INNER JOIN worship_place ON worship_place.id=stewardship.worship_place_id");
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
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO stewardship (jamaah_id, period, type_of_work_id, account_status, worship_place_id)
                                          VALUES(:jamaah_id, :period, :type, 'true', :worship)");
        $stmt->execute(['jamaah_id' => $_GET['id'], 'period' => $_POST['period'], 'type' => $_POST['type'], 'worship' => $_POST['worship']]);

        $this->flash('Successfully Create Account!');
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
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, jamaah.name as jamaah_name
                                      FROM jamaah WHERE username =:username AND password=:password");
    $stmt->execute(['username' => $_POST['username'], 'password' => md5($_POST['password']) ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    // End check username and password from db

    // Store data to session
    if( ! empty($data)){
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship INNER JOIN worship_place
                                        ON stewardship.worship_place_id=worship_place.id
                                        WHERE jamaah_id=:id AND account_status='true'");
      $stmt->execute(['id' => $data->id]);
      $s = $stmt->fetch(PDO::FETCH_OBJ);

      if(!empty($s)){
        $_SESSION['jamaah'] = true;
        $_SESSION['stewardship'] = true;
        $_SESSION['user'] = $data;
        $_SESSION['user']->worship_place_id = $s->worship_place_id;
        $_SESSION['user']->worship_name = $s->name;
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
    return $this->view('guest/register');
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
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO jamaah(id, name, password, address, updated_at, phone, username)
                                      VALUES(:id, :name, :password, :address, now(), :phone, :username)");
    $stmt->execute(['id' => $_POST['ktp'],
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

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah where id=:id");
    $stmt->execute(['id' => $_POST['ktp'] ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    // End insert data to db

    // Store data to session (check if insert data failed, return fail)
    if( ! empty($data)){
      $_SESSION['jamaah'] = true;
      $_SESSION['user'] = $data;
      $this->redirect('jamaah/dashboard');
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
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah_worship as jw INNER JOIN worship_place as wp
                                      ON jw.worship_place_id=wp.id WHERE jw.jamaah_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->id]);
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place");
    $stmt->execute();
    $all = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('jamaah/dashboard', ['mosque' => $r, 'allMosque' => $all]);
  }

  public function addNewMosque()
  {
    $this->authJamaah();
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO jamaah_worship(jamaah_id, worship_place_id, created_at)
                                      VALUES(:jamaah_id, :worship_place_id, now())");
    $stmt->execute(['jamaah_id' => $_SESSION['user']->id, 'worship_place_id' => $_POST['mosque']]);

    $this->flash('Anda berhasil terdaftar sebagai jamaah masjid!');
    return $this->redirect('jamaah/dashboard');
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
    $stmt = $GLOBALS['pdo']->prepare("UPDATE jamaah SET name=:name, username=:username,
                                      phone=:phone, address=:address where id=:id");
    $stmt->execute(['name' => $_POST['name'],
                    'username' => $_POST['username'],
                    'phone' => $_POST['phone'],
                    'address' => $_POST['address'],
                    'id' => $_SESSION['user']->id]);
    // End update

    // Refresh data on dashboard after updated
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, jamaah.name as jamaah_name
                                      FROM jamaah WHERE jamaah.id=:jamaah_id");
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
    // qurban_order.*, jamaah.name as jamaah_name,
    //                                   worship_place.name, qurban.year, qurban.animal_price
    $stmt = $GLOBALS['pdo']->prepare("SELECT DISTINCT qurban_order.*, jamaah.name as jamaah_name,
                                      worship_place.name, qurban.year, qurban.animal_price
                                      FROM qurban_order
                                      INNER JOIN jamaah ON jamaah.id=qurban_order.jamaah_id
                                      INNER JOIN jamaah_worship ON jamaah_worship.jamaah_id = jamaah.id
                                      INNER JOIN qurban_detail ON qurban_order.jamaah_id=qurban_detail.jamaah_id
                                      AND qurban_order.order_number=qurban_detail.order_number
                                      AND qurban_order.date=qurban_detail.date
                                      INNER JOIN worship_place ON qurban_detail.worship_place_id=worship_place.id
                                      INNER JOIN qurban ON qurban.worship_place_id=worship_place.id
                                      WHERE qurban_order.jamaah_id=:jamaah_id ORDER BY qurban_order.date DESC");
    $stmt->execute(['jamaah_id' => $_SESSION['user']->id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
// return $this->die($data);
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

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship as jw INNER JOIN worship_place as wp
                                      ON jw.worship_place_id=wp.id WHERE jw.jamaah_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->id]);
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/dashboard', ['m' => $data, 'gallery' => $gallery->image,
                                                 'worship_id' => $_SESSION['user']->worship_place_id,
                                                 'mosque' => $r]);
  }

  public function updateAccountStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("UPDATE stewardship SET type_of_work_id=:type_of_work_id
                                      WHERE jamaah_id=:jamaah_id
                                      AND period=:period AND worship_place_id=:worship");
    $stmt->execute(['type_of_work_id' => $_POST['type'], 'jamaah_id' => $_SESSION['user']->id,
                    'period' => $_POST['period_hidden'], 'worship' => $_SESSION['user']->worship_place_id]);

    $this->flash('Update Data Success!');
    return $this->redirect('stewardship/dashboard?period='. $_POST['period_hidden']);
  }

  public function storeAccountBank()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO bank_account(worship_place_id, rekening_number, bank_code)
                                      VALUES(:worship, :rek, :bank)");
    $stmt->execute(['worship'=> $_SESSION['user']->worship_place_id, 'rek' => $_POST['account_number'],
                    'bank' => $_POST['bank']]);

    $this->flash('Add Account Success!');
    return $this->redirect('stewardship/dashboard?period='. $_GET['period']);
  }

  public function destroyAccountBank()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare('DELETE FROM bank_account
                                      WHERE rekening_number=:rek');
    $stmt->execute(['rek' => $_GET['rek']]);

    $this->flash('Destroy Account Success!');
    return $this->redirect('stewardship/dashboard');
  }

  public function changeMosque()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place WHERE id=:id");
    $stmt->execute(['id' => $_GET['id']]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

    $_SESSION['user']->worship_place_id = $_GET['id'];
    $_SESSION['user']->worship_name = $data->name;
  }

  public function jamaahStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah INNER JOIN jamaah_worship
                                      ON jamaah.id=jamaah_worship.jamaah_id
                                      WHERE worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/jamaah', ['j' => $data]);
  }

}
