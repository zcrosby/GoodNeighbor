<?php
/*
 * Description of Login
 */
class Login extends \User{
 
/*****processLogin Moved to Session class******
    public function processLogin(){

        //DEBUG- this allows you to login without a db---------------------------
        $_SESSION['isLoggedIn'] = true;
        return true;
        // DEBUG_----------------

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
        
    }//end processLogin
*/
    /*****getUserID Moved to User class******
    public function getUserID($email, $password){
        //goes into db and returns user id
        $db = $this->connectToDB();
        try {
            if( $db != NULL){
                $stmt = $db->prepare("SELECT user_id "
                                   . "FROM user_info " 
                                   . "WHERE user_email = :email " 
                                   . "AND password = :password limit 1 ;");

                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                //DEBUG var_dump($result);

                if( $stmt->execute() ){  
                    $idNum = $result["user_id"];
                    $this->closeDB();
                    return $idNum;              
                }
            }//end if db not nutt
        }
        catch (Exception $ex) {
           //debug var_dump($ex);
           $this->db = null;
           echo $ex;
       }  
    }//end getUserID()
      
     *********getUserID Moved to User class********/
}
