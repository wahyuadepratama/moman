<?php

class ApiMapsController extends Controller{

  public function index()
  {
    return $this->view('api/maps');
  }

  public function data()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM facility");
    $stmt->execute();
    $f =  $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($f);
  }

}
