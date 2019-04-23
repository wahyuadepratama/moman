<?php

class DonationController extends Controller{

  public function donation(){
    return $this->view('guest/donation');
  }

  public function donationDetail(){
    if(isset($_GET['project'])){
      return $this->view('guest/donation-detail');
    }
  }

  public function donationConfirmation(){
    if(isset($_GET['donation'])){
      return $this->view('guest/donation-confirmation');
    }
  }

  public function donationOrphan(){
    return $this->view('guest/donation-orphan');
  }

  // Caretaker - Donation Management

  public function donationDanaCaretaker(){
    return $this->view('caretaker/management-donation-collection');
  }

  public function donationTransactionCaretaker(){
    return $this->view('caretaker/management-donation-transaction');
  }

  public function donationTypeCaretaker(){
    return $this->view('caretaker/management-donation-type');
  }

  // Admin - Transaction

  public function transactionDonationAdmin(){
    return $this->view('admin/management-transaction-donation');
  }

}
