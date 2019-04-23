<?php

class Controller{

  public function view($file, $data = []){
    if(file_exists('app/Views/'.$file.'.php')){
      require_once 'app/Views/'.$file.'.php';
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
    require_once 'app/Views/'. $file .'.php';
  }

  public function redirect($route){
    header('location: '. $route);
  }

  public function csrf_field(){
    // session_start();
    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $field = "<input name='csrf_token' type='hidden' value='". $_SESSION['csrf_token'] ."'>";
    echo $field;
  }

  public function check_csrf($post){
    if (isset($post['csrf_token']) && $post['csrf_token'] === $post['csrf_token']) {
        return true;
    }else{
      $this->redirect('/csrf-token-mismatch');
    }
  }

}
