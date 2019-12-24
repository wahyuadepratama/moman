<?php

class Controller{

  Use Helper;

  public function __construct(){
    session_start();
  }

  public function view($file, $data = []){
    if(file_exists('app/Views/'.$file.'.blade.php')){
      foreach ($data as $k => $value) { ${$k} = $value; }
      require_once 'app/Views/'.$file.'.blade.php';
    }else{
      $error = ['error' => true, 'status' => 'View ' . $file .' not found'];
      die(json_encode($error));
    }
  }

  function url($v){
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
      $link = 'https';
    else
      $link = 'http';

    $link .= '://';
    echo $link . $GLOBALS['url'] . '/' . $v;
  }

  function active($currect_page){
    $get_url    = ltrim($_SERVER['REQUEST_URI'], '/');
    $get_url    = explode('?', $get_url, 2);
    $get_url    = $get_url[0];

    if($currect_page == $get_url){
        echo 'active'; //class name in css
    }
  }

  function check($currect_page){
    $get_url    = ltrim($_SERVER['REQUEST_URI'], '/');
    $get_url    = explode('?', $get_url, 2);
    $get_url    = $get_url[0];
    if($currect_page == $get_url){
        return true;
    }else{
      return false;
    }
  }

  function include($file){
    require_once 'app/Views/'. $file .'.blade.php';
  }

  public function redirect($route){
    if($route == '/')
      $route = '';
    header('location: /'. $route);
  }

  public function csrf_field(){
    // session_start();
    // Show input token to check csrf
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $field = "<input name='csrf_token' type='hidden' value='". $_SESSION['csrf_token'] ."'>";
    echo $field;
  }

  public function check_csrf($post){
    // Prevent POST method from xss
    if (isset($post['csrf_token']) && $post['csrf_token'] === $post['csrf_token']) {
        return true;
    }else{
      $this->redirect('/csrf-token-mismatch');
    }
  }

  public function flash($note = NULL){
    if (isset($_SESSION['flash'])) {
      if($note == NULL)
        return $_SESSION['flash'];
    }
    if($note == 'print'){
      echo $_SESSION['flash'];
      return $_SESSION['flash'] = NULL;
    }
    $_SESSION['flash'] = $note;
    return $_SESSION['flash'];
  }

  public function encrypt($string, $key=5) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
    return $output;
  }

  function decrypt($string, $key=5) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return $output;
  }

  public function die($v){
    echo json_encode($v);
    die('');
  }

  public function getLastId($table, $id)
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT ". $id ." FROM ". $table ." ORDER BY ". $id ." DESC LIMIT 1");
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_OBJ);
    return $data;
  }

}
