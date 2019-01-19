<?php

class Route{

    public static function web($url, $controller, $method){

      if(isset($_GET['url'])){
        $get_url    = explode('/', filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
      }else{
        $_GET['url'] = '/';
      }

      // die($url);

      if ($url == $_GET['url']) {
        $file = $controller .'.php';
        require_once 'app/Controllers/'. $file;
        $class_controller = new $controller;
      }else{
        return false;
      }

      call_user_func_array([$class_controller, $method], array($url));
    }

    public static function api($url, $controller, $method){

      if(isset($_GET['url'])){
        $get_url    = explode('/', filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
      }else{
        $_GET['url'] = '/';
      }

      // die($url);

      if ('api/'. $url == $_GET['url']) {
        $file = $controller .'.php';
        require_once 'app/Controllers/'. $file;
        $class_controller = new $controller;
      }else{
        return false;
      }

      call_user_func_array([$class_controller, $method], array($url));
    }
}
