<?php

class DonationController extends Controller{

  use Auth;

  public function donation(){
    return $this->view('guest/donation');
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
