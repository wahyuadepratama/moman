<?php

/**
 * class untuk inisialisasi database
 */
class WorshipPlaceController extends Controller{

  use Helper;

  // ------------------------------- Admin -------------------------------------
  public function listMosque(){
    $this->authAdmin();
    return $this->view('admin/management-mosque-list');
  }

  public function addMosque(){
    return $this->view('admin/management-mosque-new');
  }
// -------------------------------- End Admin ----------------------------------
  public function reportJamaah(){
    return $this->view('jamaah/report');
  }

  public function reportCaretaker(){
    return $this->view('caretaker/report');
  }

  // Admin - Report

  public function reportAdmin(){
    return $this->view('admin/management-report');
  }

}
