<?php 
/*
 *Base Controller
 *Loads the modals and views
*/

class Controller
{ 
    private $userModel;
    private $auth_header;
    private $serverKey;

    public function __construct()
    {
        $this->userModel = $this->model('User');
 
    }


    //Load model
    public function model($model)
    {
        //Require model file
        require_once '../app/models/' . $model . '.php';

        //Instantiate model
        return new $model();
    }

    //Load view
    public function view($view, $data = [])
    {
        //echo $view; exit;
        //echo $_COOKIE['token'];
        //Check for view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            //View doesnt exist
            die("view does not exist");
        }
    }
    public function generateUniqueId() {
        // Generate a UUID
        $uuid = uniqid('', true);
    
        // Get the current timestamp
        $timestamp = microtime(true);
    
        // Hash them together to ensure uniqueness
        $uniqueId = hash('sha256', $uuid . $timestamp);
    
        return $uniqueId;
    }
    


    public function getData()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        //print_r($raw);

        if (json_encode($data) === 'null') {
            return $data =  $_POST;
        } else {
            return $data;
        }
        exit;
    }

    public function getMyJsonID($token, $serverKey)
    {

        return    $JWT_token = JWT::encode($token, $serverKey);
    }



    public function getAuthorizationHeader()
    {
        $headers =  null;
        if (isset($_SERVER['Authorization'])) {

            $headers = trim($_SERVER['Authorization']);
            
        } else if (isset($_SERVER['HTTP_ATHORIZATION'])) {
            $headers = trim($_SERVER['HTTP_ATHORIZATION']);
            
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $request_headers = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
                 
            }
        }
         

        return $headers;
    }

    public function bearer()
    {


        $this->auth_header  = $this->getAuthorizationHeader();


        if (
            $this->auth_header
            &&
            preg_match('#Bearer\s(\S+)#', $this->auth_header, $matches)
        ) {

            return $bearer = $matches['1'];
        }
    }


 

    public function myJsonID($bearer, $serverKey)
    {
        $myJsonID = JWT::decode($bearer, $serverKey);
        if ($myJsonID === 401) {
            return false;
        } else {

            return $myJsonID;
        }
    }



    public function serverKey()
    {
        return   'secret_server_keysa' . date("M");
    }



    //JWT::decode($bearer,'secret_server_key'.date("H"))
    public function RouteProtecion(){
  
        $headers =  $this->getAuthorizationHeader();
     
        if (!isset($headers)) {
            $response = ['error' => 'Authorization header missing', 'status' => 401];
          print_r(json_encode($response));
        }else {
             $jwt = str_replace('Bearer ', '', $headers);
        $decoded = $this->myJsonID($jwt, $this->serverKey);
       
        $thisuser = $this->getuserbyid();
        return $thisuser ;
        if (!$decoded) {
            $response = ['error' => 'Invalid token', 'status' => 401];
            print_r($response);
       
        }
        }
       
        
      }

    //echo $bearer;
    public function getuserbyid(){
        $bearer = $this->bearer();
         
        if($bearer){ 
             $userId = $this->myJsonID($bearer,$this->serverKey);
            //  print_r($userId->user_id) ;
            //  exit;
             if(!isset($userId)){
              $response = array(
                
                 'status' => 'false',
                 'message' => 'Oops Something Went Wrong x get!!',
        
              );
              print_r(json_encode($response));
              exit;
          }
          $vb = $this->userModel->getuserbyid($userId->user_id);
          
          if(empty($userId->user_id)) { 
    //   print_r(json_encode($vb));
          $response = array(
                 'status' => 'false',
                 'message' => 'No user with this userID!'
              );
              print_r(json_encode($response));
              
          } else {
            // $response = [
            //   'status' => 'true',
            //   'fullname'=> $vb->full_name,
            //   'email'=> $vb->email,
            //   'tagname'=> $vb->user_tag,
            //   'user_id'=> $vb->veluxite_id,
            // //   'data' => $vb,
            // ];
            //  print_r(json_encode(($vb)));
             return $vb ;
          }
         
         
      
      }
      }

    

}

























?>