<?php

class UserController extends Controller{

  use Auth;

  public function index(){
    // die($this->AuthJamaah());
    return $this->view('guest/home');
  }

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

  // Admin Dasbhoard

  public function dashboardAdmin(){
    return $this->view('admin/dashboard');
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
