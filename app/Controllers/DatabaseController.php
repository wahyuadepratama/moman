<?php

/**
 * class untuk inisialisasi database
 */
class DatabaseController extends Controller
{

  function index()
  {
    return $this->view('home');
    echo "Welcome Home";
  }

  public function cobaGet()
  {
    $tes = array('wahyu' => 'nama depan', 'ade' => 'nama belakang', 'pratama' => 'nama tengah');

    echo json_encode($tes);
  }
}
