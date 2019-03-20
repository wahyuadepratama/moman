<?php

class Route{

    public static $all_route;
    public static $not_match_route;

    public static function web($url, $controller, $method){

      self::$all_route++;

      if(isset($_GET['url'])){        
        $get_url    = explode('/', filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
      }else{
        $_GET['url'] = '/';
        $get_url = $_GET['url'];
      }

      if($_GET['url'] != "/" && $get_url[0] != "api" && count($get_url) > 1){
        header("location:". $GLOBALS['url'] . "/" . $get_url[0]);
      }

      if($url == "lastpage" && $get_url[0] != "api" && self::$all_route - 1 == self::$not_match_route){
        $error = new Controller;
        return $error->view('error/404');
      }

      if ($url == $_GET['url']) {
        $file = $controller .'.php';
        require_once 'app/Controllers/'. $file;
        $class_controller = new $controller;
        if(!method_exists($class_controller, $method)){
          $error = ['error' => true, 'status' => 'Method not found'];
          die(json_encode($error));
        }
        call_user_func_array([$class_controller, $method], array($url));
      }else{
        self::$not_match_route++;
        return false;
      }

    }

    public static function api($url, $controller, $method){

      self::$all_route++;

      if(isset($_GET['url'])){
        $get_url    = explode('/', filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
      }else{
        $_GET['url'] = 'api';
        $get_url = $_GET['url'];
      }

      if($_GET['url'] != "/" && count($get_url) > 2){
        header("location:". $GLOBALS['url'] . "/" . $get_url[0]);
      }

      if($url == "api/lastpage" && self::$all_route - 1 == self::$not_match_route){
        header("location:". $GLOBALS['url'] . "/" . $get_url[0]);
      }

      if ("api/" . $url == $_GET['url']) {
        $file = $controller .'.php';
        require_once 'app/Controllers/'. $file;
        $class_controller = new $controller;

        if(!method_exists($class_controller, $method)){
          $error = ['error' => true, 'status' => 'Method not found'];
          die(json_encode($error));
        }

        call_user_func_array([$class_controller, $method], array($url));
      }else{
        self::$not_match_route++;
        return false;
      }
    }
}
