<?php

/* 
    *App core classs
    *Creat URL and loads core controller 
    *url Format - /controller/methode/paramas

*/

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        //print_r($this->getUrl());
        $url = $this->getUrl();

        //look in controller for the fisrt value
        if(file_exists('../app/controllers/' . ucwords($url[0]).'.php')){
         //if exist set as controller 
           $this->currentController = ucwords($url[0]);  
         //unset 0 index
           unset($url[0]);
     }

     //Require the controller
     require_once '../app/controllers/'. $this->currentController . '.php';

     // instantiate controller class
     $this->currentController = new $this->currentController;
     //check for second part of url
     if(isset($url[1])){
      //check if meyhode exist
      if(method_exists($this->currentController,$url[1])){
        $this->currentMethod = $url[1];
        //unset  1 index
        unset($url[1]);
      }
     }
     
     //Get params
     $this->params = $url ? array_values($url) : [];
     //call a callback with array 
     call_user_func_array([$this->currentController,$this->currentMethod],$this->params);



    }


    public function getUrl() {
        if(isset($_GET['url'])){
          $url = rtrim($_GET['url'],'/');
          $url = filter_var($url, FILTER_SANITIZE_URL);
          $url = explode('/', $url);
          return $url;
    }
  }
}