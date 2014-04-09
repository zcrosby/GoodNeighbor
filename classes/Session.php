<?php

class Session extends User{
    
    public function verifyUser(){
/*
        //DEBUG- this allows you to login without a db---------------------------
        $_SESSION['isLoggedIn'] = true;
        return true;
        // DEBUG_----------------
*/
         if( count($_POST) ){
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');
            $password = sha1($password);
            
            if( $this->userExists($email, $password) ){
                $_SESSION['isLoggedIn'] = "true";
                $_SESSION['UserID'] = $this->getUserID($email, $password);
               //DEBUG  echo $_SESSION['UserID'];
                return true;
            }
            else{
                return false;
            }
        }
        
    }//end verifyUser
    
}
