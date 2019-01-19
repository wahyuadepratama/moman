<?php

class Controller{

  public function view($file, $data = []){
    if(file_exists('app/Views/'.$file.'.php')){
      require_once 'app/Views/'.$file.'.php';
    }else{
      die("View tidak ditemukan!");
    }
  }

}
