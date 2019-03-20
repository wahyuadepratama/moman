<?php

/**
 * class untuk inisialisasi database
 */
class EventController extends Controller{

  use Auth;

  // Jamaah - Event

  public function eventJamaah(){
    return $this->view('jamaah/event');
  }

  // Caretaker - Event

  public function eventScheduleCaretaker(){
    return $this->view('caretaker/management-event-schedule');
  }

  public function eventFinancialCaretaker(){
    return $this->view('caretaker/management-event-financial');
  }

  // Admin - Event

  public function eventAdmin(){
    return $this->view('admin/management-event');
  }

  // Caretaker - About Mosque

  public function eventCaretaker(){
    return $this->view('caretaker/event');
  }

}
