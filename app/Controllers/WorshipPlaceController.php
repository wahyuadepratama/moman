<?php

/**
 * class untuk inisialisasi database
 */
class WorshipPlaceController extends Controller{

  use Auth;

  public function reportJamaah(){
    return $this->view('jamaah/report');
  }

  public function reportCaretaker(){
    return $this->view('caretaker/report');
  }

  // Admin - Mosque

  public function mosqueNewAdmin(){
    return $this->view('admin/management-mosque-new');
  }

  public function mosqueListAdmin(){
    return $this->view('admin/management-mosque-list');
  }

  // Admin - Report

  public function reportAdmin(){
    return $this->view('admin/management-report');
  }

}
