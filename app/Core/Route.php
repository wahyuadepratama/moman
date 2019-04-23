<?php

class Route{

    public static $all_route;
    public static $not_match_route;

    public static function web($url, $controller, $method){

      self::$all_route++;

      if($_SERVER['REQUEST_URI'] != '/'){
        $get_url    = ltrim($_SERVER['REQUEST_URI'], '/');
        $get_url    = explode('?', $get_url, 2);
        $get_url    = $get_url[0];
      }else{
        $_GET['url'] = '/';
        $get_url = $_GET['url'];
      }    

      if($url == "lastpage" && self::$all_route - 1 == self::$not_match_route){
        $error = new Controller;
        return $error->view('error/404');
      }

      if ($url == $get_url) {
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
