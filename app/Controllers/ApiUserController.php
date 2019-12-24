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
    $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, jamaah.type as types,
                                      jamaah.address, jamaah.updated_at, jamaah.avatar,
                                      worship_place.name as worship_name, worship_place.address as worship_place_address,
                                      jamaah.id as jamaah_id
                                      FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                      WHERE jamaah.username =:username AND password=:password");
    $stmt->execute(['username' => $_POST['username'], 'password' => $_POST['password'] ]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    // End check

    // Store data to session (if data empty, return login failed)
    if( ! empty($data)){
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship WHERE jamaah_id=:id");
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
      $stmt = $GLOBALS['pdo']->prepare("SELECT jamaah.username, jamaah.phone, jamaah.type as types,
                                        jamaah.address, jamaah.updated_at, jamaah.avatar, worship_place.id as worship_id,
                                        worship_place.name as worship_name, worship_place.address as worship_place_address,
                                        jamaah.id as jamaah_id
                                        FROM jamaah INNER JOIN worship_place ON jamaah.worship_place_id=worship_place.id
                                        WHERE jamaah.id=:id");
      $stmt->execute(['id' => $_POST['id']]);
      $data = $stmt->fetch(PDO::FETCH_OBJ);

      if( ! empty($data)){
        $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship WHERE jamaah_id=:id");
        $stmt->execute(['id' => $data->jamaah_id]);
        $s = $stmt->fetch(PDO::FETCH_OBJ);

        if(!empty($s)){
          $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM account WHERE stewardship_id=:id");
          $stmt->execute(['id' => $_POST['id']]);
          $account = $stmt->fetchAll(PDO::FETCH_OBJ);

          $data->status = 'stewardship';
          $data->account = $account;
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
