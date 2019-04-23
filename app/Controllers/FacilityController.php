<?php

/**
 * class untuk inisialisasi database
 */
class FacilityController extends Controller{  

  // Caretaker - Facility

  public function facilityCaretaker(){
    return $this->view('caretaker/management-facility');
  }

  // Admin - Facility

  public function facilityAdmin(){
    return $this->view('admin/management-facility');
  }

}
