<?php

/**
 * Write your trait to help you here
 */
trait Helper{

  public function authAdmin(){
    session_start();
    if(empty($_SESSION['admin'])){
      $this->redirect('/not-found');
    }
  }

  public function passLoginAdmin(){
    session_start();
    if(!empty($_SESSION['admin'])){
      if($_SESSION['admin'] === true){
        $this->redirect('/admin/dashboard');
      }
    }
    }
}
