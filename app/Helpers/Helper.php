<?php

/**
 * Write your trait to help you
 */

trait Helper{

  public function authAdmin(){
    // cek jika admin belum login maka redirect ke 404
    if(empty($_SESSION['admin'])){
      $this->view('error/404');
      die('');
    }
  }

  public function passLoginAdmin(){
    // langsung redirect ke dashboard admin jika sudah login
    if(isset($_SESSION['admin'])){
      if($_SESSION['admin'] === true){
        $this->redirect('admin/dashboard');
      }
    }
  }

  public function authJamaah(){
    // cek jika admin belum login maka redirect ke 404
    if(empty($_SESSION['jamaah'])){
      $this->view('error/404');
      die('');
    }
  }

  public function passLoginJamaah(){
    // langsung redirect ke dashboard guest jika sudah login
    if(isset($_SESSION['jamaah'])){
      if($_SESSION['jamaah'] === true){
        $this->redirect('jamaah/dashboard');
      }
    }
  }

  public function authStewardship(){
    // cek jika admin belum login maka redirect ke 404
    if(empty($_SESSION['stewardship'])){
      $this->view('error/404');
      die('');
    }
  }

}
