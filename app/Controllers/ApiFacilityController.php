<?php

class ApiFacilityController extends Controller{

  public function __construct()
  {
    header('content-type: application/json; charset=utf8');
	  header("access-control-allow-origin: *");
  }

  public function index()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM facility");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($data);
  }

}
