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

  public function include($file)
  {
    require_once 'app/Views/'. $file .'.php';
  }

}
