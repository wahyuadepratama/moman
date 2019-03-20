<?php

class QurbanController extends Controller{

  use Auth;

  public function qurban(){
    return $this->view('guest/qurban');
  }

  public function qurbanConfirmation(){
    return $this->view('guest/qurban-confirmation');
  }

  // Caretaker - Qurban Management

  public function qurbanDanaCaretaker(){
    return $this->view('caretaker/management-qurban-collection');
  }

  public function qurbanTransactionCaretaker(){
    return $this->view('caretaker/management-qurban-transaction');
  }

  public function qurbanTypeCaretaker(){
    return $this->view('caretaker/management-qurban-type');
  }

  // Admin - Transaction

  public function transactionQurbanAdmin(){
    return $this->view('admin/management-transaction-qurban');
  }

}
