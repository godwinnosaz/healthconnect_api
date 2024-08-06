<?php 

  // Load headers
  //require_once 'helpers/headers.php';


require_once 'helpers/headers.php';

//Load Config

require_once 'config/config.php';

  // Load helper
  require_once 'helpers/url_helper.php';
  require_once 'helpers/session_helper.php';
 
//Autoload Core Libraries
spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
});

//require_once '../vendor/autoload.php';


 