<?php
/* 
    *Base Controller
    *load the models and views
 */

 class Controller {

    //Load model
    public function model($model){
        // require model file
        require_once '../app/models/' .$model. '.php';
        //instatiate model
        return new $model();
        
    }


    // Load view 
    public function view($view,$data = []){
        // check for the view file
        if (file_exists('../app/views/'.$view.'.php')){
            require_once '../app/views/' .$view. '.php';
        } else {
            // wiew does not exist 
            die('wiew does not exist');
        }

    }
 }