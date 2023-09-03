<?php
  //Load Config 
  require_once 'config/config.php';

  // Load Libraries
 /*  require_once 'libraries/core.php';
  require_once 'libraries/controller.php';
  require_once 'libraries/database.php'; */


  //Autoload Core libraries

  // Load helpers 
  require_once 'helpers/url_helper.php';
  require_once 'helpers/session_helper.php';

  spl_autoload_register(function($classeName){
    require_once 'libraries/' .$classeName. '.php';
  });