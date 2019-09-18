<?php

class ApiQurbanController extends Controller
{

  function __construct()
  {
    header('content-type: application/json; charset=utf8');
	  header("access-control-allow-origin: *");
  }

  function index()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT w.name, w.id FROM worship_place AS w");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($r as $key) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT q.animal_type, q.animal_price, q.year FROM mosque_qurban AS q WHERE worship_place_id=:id AND q.year=:y");
      $stmt->execute(['id'=>$key->id, 'y' => date('Y')]);
      $t = $stmt->fetchAll(PDO::FETCH_OBJ);
      $key->animal_type = $t;
    }    

    echo json_encode($r);
  }
}
