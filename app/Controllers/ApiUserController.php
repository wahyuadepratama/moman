<?php

class ApiUserController extends Controller{

  public function __construct()
  {
    header('content-type: application/json; charset=utf8');
	  header("access-control-allow-origin: *");
  }

  public function login()
  {
    // Check username and password from db
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, jamaah.name as jamaah_name, jamaah.id as jamaah_id
                                      FROM jamaah WHERE username =:username AND password=:password");
    $stmt->execute(['username' => $_POST['username'], 'password' => $_POST['password'] ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    // End check

    // Store data to session (if data empty, return login failed)
    if( ! empty($data)){
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship INNER JOIN worship_place
                                        ON stewardship.worship_place_id=worship_place.id
                                        WHERE jamaah_id=:id AND account_status='true'");
      $stmt->execute(['id' => $data->jamaah_id]);
      $s = $stmt->fetch(PDO::FETCH_OBJ);

      if(!empty($s)){
        $data->status = 'stewardship';
        echo json_encode($data);
      }else{
        $data->status = 'jamaah';
        echo json_encode($data);
      }
    }else{
      $result = ['status' => 'login error'];
      echo json_encode($result);
    }
    // End store data

  }

  public function getDataLogin()
  {
    // harusnya disini check session dulu
    if (isset($_POST['id'])) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.*, jamaah.name as jamaah_name
                                        FROM jamaah WHERE jamaah.id=:id");
      $stmt->execute(['id' => $_POST['id']]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      if( ! empty($data)){
        $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship INNER JOIN worship_place
                                          ON stewardship.worship_place_id=worship_place.id
                                          WHERE jamaah_id=:id AND account_status='true'");
        $stmt->execute(['id' => $data->id]);
        $s = $stmt->fetch(PDO::FETCH_OBJ);

        if(!empty($s)){
          $data->status = 'stewardship';

          $stmt = $GLOBALS['pdo']->prepare("SELECT worship_place.name FROM jamaah_worship INNER JOIN worship_place
                                            ON jamaah_worship.worship_place_id=worship_place.id
                                            WHERE jamaah_id=:id");
          $stmt->execute(['id' => $data->id]);
          $s = $stmt->fetchAll(PDO::FETCH_OBJ);
          $data->worship = $s;

          echo json_encode($data);
        }else{
          $data->status = 'jamaah';
          echo json_encode($data);
        }
      }else{
        $result = ['status' => 'id not found'];
        echo json_encode($result);
      }
    }else{
      $result = ['status' => 'id not found'];
      echo json_encode($result);
    }
  }
}
