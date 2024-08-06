<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function findLoginByToken($token)
    {
        $this->db->query('SELECT * FROM initkeyrid WHERE bearer_token= :bearer_token');
        $this->db->bind(':bearer_token', $token);

        $row = $this->db->single();
    
        
        if($this->db->rowCount() > 0){
            return $row;
        } else{
            return false;
        
        
        
        }


    }



    public function loginUser($email)
    {
        $this->db->query('SELECT * FROM initkeyrid  WHERE email= :email or user_tag = :user_tag');
        $this->db->bind(':email', $email);
        $this->db->bind(':user_tag', $email);

        $row = $this->db->single();
       
        //return $row;
        if($this->db->rowCount() > 0){
            return $row;
        } else {
          
           return false;
       
        
        }


    }





    //Find user by email
    public function findUserByEmail_det($email)
    {
        $this->db->query("SELECT * FROM initkeyrid WHERE  email = :email");

        // Bind Values
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
        return $row;
        }else{
            
            return false;
        }
    
    }


public function findUserByEmail($email)
{
    $this->db->query("SELECT * FROM initkeyrid WHERE email = :email AND activationx = 1");

    // Bind Values
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

public function findUserByEmail1($email)
{
    $this->db->query("SELECT * FROM initkeyrid WHERE email = :email");

    // Bind Values
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

 


    //Get user by Id
    public function getUserByid($id)
    {
        $this->db->query("SELECT * FROM initkeyrid WHERE  veluxite_id = :veluxite_id");

        // Bind Values
        $this->db->bind(':veluxite_id', $id);

        $row1 = $this->db->single();

        // Check roow
       
         if ($this->db->rowCount() > 0) {
             return $row1;
        } else {
             $this->db->query("SELECT * FROM sub_initkeyrid WHERE  veluxite_id = :veluxite_id");

        // Bind Values
        $this->db->bind(':veluxite_id', $id);

        $row2 = $this->db->single();

        // Check roow
       
         if ($this->db->rowCount() > 0) {
             return $row2;
        } else {
            return false;
        }
        }
    }
 


    //Get user by Id
    public function cookieChecker($live)
    {
        $this->db->query("SELECT * FROM initkeyrid WHERE bearer_token = :bearer_token");

        // Bind Valuesrid
        $this->db->bind(':bearer_token', $live);

        $row = $this->db->single();

        // Check roow



        if ($this->db->rowCount() > 0) {
            return true;
        } else {

            return false;
        }

    }




    //Get all submule 
    public function getuserdetails($email)
    {
        $this->db->query("SELECT * FROM initkeyrid where email = :email");
        $this->db->bind(':email', $email);
       if( $row = $this->db->resultSet()){
        return $row;
       }else {
        $this->db->query("SELECT * FROM sub_initkeyrid where email = :email");
        $this->db->bind(':email', $email);
        $row = $this->db->resultSet();
        return $row;
       }
        
        

    }




    //Get user by Id
    public function getErrorByid($code)
    {
        //echo "SELECT * FROM errormessages WHERE 'code' = ':code'";
        $this->db->query("SELECT * FROM errormessages WHERE code = :code");

        // Bind Values
        $this->db->bind(':code', $code);

        $row = $this->db->single();

        // Check roow



        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }

    }




    //Get user by Id
    public function getUserBybearer_token($bearer_token)
    {
        $this->db->query("SELECT * FROM initkeyrid WHERE bearer_token = :bearer_token");

        // Bind Values
        $this->db->bind(':bearer_token', $bearer_token);

        $row = $this->db->single();

        // Check roow
        return $row;

    }





    public function deleteToken($veluxite_id, $token)
    {
        $token = '';
        //echo "removed"; exit;
        $this->db->query('UPDATE  initkeyrid SET token = :token WHERE veluxite_id= :veluxite_id');
        $this->db->bind(':veluxite_id', $veluxite_id);
        $this->db->bind(':token', $token);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function deletesub($data)
    {
        
        //echo "removed"; exit;
        $this->db->query('DELETE FROM sub_initkeyrid WHERE user_tag = :user_tag and registrer_id = :registrer_id');
        // $this->db->bind(':veluxite_id', $data['']);
        $this->db->bind(':user_tag', $data['tname']);
        $this->db->bind(':registrer_id', $data['reg_id']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }






    public function updateToken($veluxite_id, $token, $tag)
    {
        $this->db->query('UPDATE  initkeyrid SET bearer_token = :bearer_token WHERE veluxite_id= :veluxite_id and user_tag = :user_tag');
        $this->db->bind(':veluxite_id', $veluxite_id);
        $this->db->bind(':bearer_token', $token);
        $this->db->bind(':user_tag', $tag);
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


public function userPush($fcmtoken, $user)
{
    $this->db->query('UPDATE initkeyrid SET fcmtoken = :fcmtoken WHERE user_tag = :user_tag');
    $this->db->bind(':fcmtoken', $fcmtoken);
    $this->db->bind(':user_tag', $user);

    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}

}