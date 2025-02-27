<?php
  
  /*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */

  class Core {
     protected $currentController = 'Users';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
      //print_r($this->getUrl());

         $url = $this->getUrl();

     //  print_r($this->getUrl());
       //echo ucwords($url[0]);
     
      // Look in controllers for first value
      if(file_exists('../app/controllers/'. ucwords($url[0]). '.php')){
        // If exists, set as controller
        $this->currentController = ucwords($url[0]);
        // Unset 0 Index
        unset($url[0]);
      }
  //echo     $this->currentController ; //  = "Users";
      // Require the controller
      require_once '../app/controllers/'. $this->currentController . '.php';

      // Instantiate controller class
      $this->currentController = new $this->currentController;


      

      //echo $url[1];
     // exit;

      if(isset($url[1])){
        //Check to see if method exists in controller
        if(method_exists($this->currentController, $url[1])){
            $this->currentMethod = $url[1];

            //Unset
            unset($url[1]);
        }
      }

      
        //Get params
        $this->params = $url ? array_values($url) : [];


        // echo $this->currentController ; 

        //echo $this->currentMethod;
       // exit;
        //Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params); 
    }

    public function getUrl(){
      if(isset($_GET['url'])){
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    } 
  } 
  
?> 