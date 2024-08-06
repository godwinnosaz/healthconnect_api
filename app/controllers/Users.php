<?php 


Class Users extends Controller 
{
  private $userModel;
  private $serverKey;

  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->serverKey  = 'secret_server_key'.date("H");
  }

  public function loginfunc()
  {
    $jsonData = $this->getData();
    if (!isset($jsonData['email']) || !isset($jsonData['password'])) {
      $response = array(
        'status' => 'false',

        'message' => 'Enter login details',

      );

      print_r(json_encode($response));
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $loginData = $this->getData();

      // Init data
      $data = [

        'email' => trim($jsonData['email']),
        'password' => trim($jsonData['password']),
        'email_err' => '',
        'msg' => '',
        'loginStatus' => '',
        'password_err' => '',
      ];
      // Validate Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      }

      // Validate password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      }
      if ((empty($data['email_err'])) && (empty($data['password_err']))) {
        if ($this->userModel->getUserByEmailuser_tag($data['email'])) {
          $loginDatax = $this->userModel->loginUser($data['email']);
          $postPassword = $data['password'];
         
          $hash_password = $loginDatax->password;
          $email = $loginDatax->email;
          $tag = $loginDatax->user_tag;
          $user_id = $loginDatax->veluxite_id;
       if ((password_verify($postPassword, $hash_password))) {



            $tokenX = $token = "token" . md5(date("dmyhis") . rand(1222, 89787)) . md5(date("dmyhis") . rand(1222, 89787)) . md5(date("dmyhis") . rand(1222, 89787)) . md5(date("dmyhis") . rand(1222, 89787)) . md5(date("dmyhis") . rand(1222, 89787));
            $this->userModel->updateToken($user_id, $tokenX, $tag);

            $loginData = $this->userModel->findLoginByToken($tokenX);
             
            $userData = $this->userModel->findUserByEmail_det($loginData->user_tag);
            $initData = [
              'loginData' => $loginData,
              'userData' => $userData,
            ];

            $datatoken = [
              'user_id' => $user_id,
              'appToken' => $initData['loginData']->bearer_token,

            ];
            $JWT_token = $this->getMyJsonID($datatoken, $this->serverKey);
            $response = array(
              'status' => true,
              'access_token' => $JWT_token,
              'datatoken' => $datatoken,
              'message' => 'success',
              'data' => $initData,

            );


            print_r(json_encode($response));
            exit;
          } else {
            $response = array(
              'status' => 'false',
              'message' => 'Invalid password',

            );

            print_r(json_encode($response));
            exit;
          }

        } else {


          $response = array(
            'status' => 'false',

            'message' => 'invalid user login detail',
            'data' => $data,
          );

          print_r(json_encode($response));
          exit;
        }
      } else {
        $response = array(
          'status' => 'false',
          'message' => 'All input fields must be complete',
          'data' => $data,
        );

        print_r(json_encode($response));
        exit;
      }


    } else {

      $response = array(
        'status' => 'false',

        'message' => 'Invalid server method',

      );

      print_r(json_encode($response));
      exit;
    }

    
  }
}