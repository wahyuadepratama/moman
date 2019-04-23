<?php

class UserController extends Controller{

  Use Helper;

  public function index(){
    // $stmt = $GLOBALS['pdo']->query("SELECT * FROM gallery")->fetchAll();
    // die(json_encode($stmt));
    // die($this->AuthJamaah());
    return $this->view('guest/home');
  }

  // ------------------------------- Admin -------------------------------------
  public function loginAdmin(){
    $this->passLoginAdmin();
    return $this->view('guest/login-admin');
  }

  public function checkLoginAdmin(){

    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM admin WHERE username =:username AND password=:password");
    $stmt->execute(['username' => $_POST['username'], 'password' => md5($_POST['password']) ]);
    $data = $stmt->fetch();

    if( ! empty($data)){
      session_start();
      $_SESSION['admin'] = true;
      $_SESSION['username'] = $data['username'];
      $this->redirect('/admin/dashboard');
    }else{
      $error = "Username atau Password kamu salah!";
      return $this->view('guest/login-admin', ['error' => $error]);
    }
  }

  public function checkLogoutAdmin(){
    session_start();
    session_destroy();
    $this->redirect('/');
  }

  public function dashboardAdmin(){
    $this->authAdmin();
    return $this->view('admin/dashboard');
  }
  // ------------------------------- End Admin -----------------------------------

  public function login(){
    return $this->view('guest/login');
  }

  // Jamaah

  public function dashboardJamaah(){
    return $this->view('jamaah/dashboard');
  }

  public function updateDashboardJamaah(){
    return $this->view('jamaah/dashboard-update');
  }

  // Caretaker

  public function dashboardCaretaker(){
    return $this->view('caretaker/dashboard');
  }

  public function updateDashboardCaretaker(){
    return $this->view('caretaker/dashboard-update');
  }

  public function updateAccountDashboardCaretaker(){
    return $this->view('caretaker/dashboard-account-update');
  }

  // Admin - Jamaah

  public function jamaahAdmin(){
    return $this->view('admin/management-jamaah');
  }

  // Admin - Caretaker

  public function caretakerNewAdmin(){
    return $this->view('admin/management-caretaker-new');
  }

  public function caretakerListAdmin(){
    return $this->view('admin/management-caretaker-list');
  }

}
